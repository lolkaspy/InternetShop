<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Builder;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $ordersQuery = Order::query()->where('user_id', Auth::id());

        if ($request->filled('name')) {
            $ordersQuery->whereHas('orderLists.product', function (Builder $query) use ($request) {
                $query->where('name', 'like', "%{$request->name}%");
            });

        }

        if ($request->filled('state')) {
            $ordersQuery->where('state', '=', $request->state);
        }

        if ($request->filled('low_total')) {
            $ordersQuery->where('total', '>=', $request->low_total);
        }

        if ($request->filled('high_total')) {
            $ordersQuery->where('total', '<=', $request->high_total);
        }

        if ($request->filled('created_at')) {
            $ordersQuery->whereDate('created_at', '=', $request->created_at);
        }

        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        $minTotalQuery = clone $ordersQuery;
        $maxTotalQuery = clone $ordersQuery;

        $minTotal = $minTotalQuery->min('total');
        $maxTotal = $maxTotalQuery->max('total');

        $orders = $ordersQuery->orderBy($sortBy, $sortOrder)->paginate(25);
        return view('order/orders', compact('orders', 'minTotal', 'maxTotal'));
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
