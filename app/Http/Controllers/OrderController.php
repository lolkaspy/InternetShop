<?php

namespace App\Http\Controllers;
use App\Services\Order\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Builder;

class OrderController extends Controller
{
    private $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function index(Request $request)
    {
        $ordersQuery = Order::query()->where('user_id', Auth::id());

        $this->orderService->applyFilters($ordersQuery, $request);
        return view('order/orders', $this->orderService->getOrderData($ordersQuery, $request));
    }

    public function cancelOrder($orderId)
    {
        $order = Order::find($orderId);

        if ($order->state == 1 || $order->state == -1) {
            return redirect()->back()->with('error', 'Этот заказ уже был обработан и не может быть отменен');
        }

        $user = $order->user;
        $user->balance += $order->total;
        $user->save();

        foreach ($order->orderLists as $orderList) {
            $product = $orderList->product;
            $product->available_quantity += $orderList->quantity;
            $product->save();
        }

        // Обновить статус заказа
        $order->state = -1;
        $order->save();

        return redirect()->back()->with('success', 'Заказ успешно отменен');
    }

    public function updateOrderState(Request $request, $orderId)
    {
        $order = Order::find($orderId);
        $oldState = $order->state;
        $newState = $request->state;

        if ($newState == -1 && $oldState != -1) {

            $user = $order->user;
            $user->balance += $order->total;
            $user->save();

            foreach ($order->orderLists as $orderList) {
                $product = $orderList->product;
                $product->available_quantity += $orderList->quantity;
                $product->save();
            }

        } elseif (($newState == 0 || $newState == 1) && $oldState == -1) {

            $user = $order->user;
            $user->balance -= $order->total;
            $user->save();

            foreach ($order->orderLists as $orderList) {
                $product = $orderList->product;
                $product->available_quantity -= $orderList->quantity;
                $product->save();
            }
        }

        $order->state = $newState;
        $order->save();

        return redirect()->back()->with('success', 'Статус заказа успешно обновлен');
    }

}
