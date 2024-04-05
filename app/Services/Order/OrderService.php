<?php

namespace App\Services\Order;

use App\Enums\StateEnum;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrderService
{
    public function applyFilters(Builder $ordersQuery, Request $request)
    {
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

        if ($request->filled('user')) {
            $ordersQuery->whereHas('user', function (Builder $query) use ($request) {
                $query->where('email', 'like', "%{$request->user}%")
                    ->orWhere('name', 'like', "%{$request->user}%");
            });
        }

        return $ordersQuery;
    }

    public function getOrderData(Builder $ordersQuery, Request $request)
    {
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');
        $minTotalQuery = clone $ordersQuery;
        $maxTotalQuery = clone $ordersQuery;

        $minTotal = round($minTotalQuery->min('total'));
        $maxTotal = round($maxTotalQuery->max('total'));

        $orders = $ordersQuery->orderBy($sortBy, $sortOrder)->paginate(50);

        return compact('orders', 'minTotal', 'maxTotal');
    }

    public function cancelOrder($order)
    {
        if ($order->state == StateEnum::Approved->value || $order->state == StateEnum::Cancelled->value) {
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
        $order->state = StateEnum::Cancelled->value;
        $order->save();

        return redirect()->back()->with('success', 'Заказ успешно отменен');
    }

    public function updateOrderState(Request $request, $order)
    {
        $oldState = $order->state;
        $newState = $request->state_change;

        //dd("newState - ".$newState."\nCancelled - ".StateEnum::Cancelled->value."\nApproved - ".StateEnum::Approved->value
        //."\nNew - ".StateEnum::New->value."\noldState - ".$oldState);

        if ($newState == StateEnum::Cancelled->value && $oldState != StateEnum::Cancelled->value) {

            $user = $order->user;
            $user->balance += $order->total;
            $user->save();

            foreach ($order->orderLists as $orderList) {
                $product = $orderList->product;
                $product->available_quantity += $orderList->quantity;
                $product->save();
            }

        } elseif (($newState == StateEnum::New->value || $newState == StateEnum::Approved->value) && $oldState == StateEnum::Cancelled->value) {

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
