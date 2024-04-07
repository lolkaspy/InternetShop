<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function createOrder(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $total = 0;
        $orderLists = [];

        if ($request->has('products')) {
            foreach ($request->products as $productId => $quantity) {
                $product = Product::find($productId);

                if ($product->available_quantity < $quantity) {
                    return redirect()->back()->with('error', 'Товара нет в наличии на данный момент');
                }
                $subtotal = $product->price * $quantity;
                $total += $subtotal;

                if ($user->balance < $total) {
                    return redirect()->back()->with('error', 'Недостаточно средств на балансе');
                }
                $orderList = new OrderList;
                $orderList->product_id = $productId;
                $orderList->quantity = $quantity;
                $orderList->subtotal = $subtotal;

                $orderLists[] = $orderList;

                $product->available_quantity -= $quantity;
                $product->save();
            }

            $order = new Order;
            $order->user_id = $user->id;
            $order->total = $total;
            $order->save();

            foreach ($orderLists as $orderList) {
                $orderList->order_id = $order->id;
                $orderList->save();
            }

            $user->balance -= $total;
            $user->save();

            $cartItems = Cart::where('user_id', Auth::id());
            $cartItems->forceDelete();

            return redirect()->back()->with('success', 'Заказ успешно создан');
        }

        return redirect()->back()->with('error', 'Корзина пуста, оформить заказ невозможно');
    }
}
