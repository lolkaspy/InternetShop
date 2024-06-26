<?php

namespace App\Services\Order;

use App\Actions\PriceLimiterAction;
use App\Actions\SortAction;
use App\Enums\StateEnum;
use App\Http\Filters\FilterInterface;
use App\Http\Requests\OrderRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class OrderService implements FilterInterface
{
    public function applyFilters(Builder $query, FormRequest $request): Builder
    {
        if ($request->filled('name')) {
            $query->whereHas('orderLists.product', function (Builder $query) use ($request) {
                $query->where('name', 'like', "%{$request->name}%");
            });
        }

        if ($request->filled('state')) {
            $query->where('state', '=', $request->state);
        }

        if ($request->filled('low_total')) {
            $query->where('total', '>=', $request->low_total);
        }

        if ($request->filled('high_total')) {
            $query->where('total', '<=', $request->high_total);
        }

        if ($request->filled('created_at')) {
            $query->whereDate('created_at', '=', $request->created_at);
        }

        if ($request->filled('user')) {
            $query->whereHas('user', function (Builder $q) use ($request) {
                $q->where('email', 'like', "%{$request->user}%")
                    ->orWhere('name', 'like', "%{$request->user}%");
            });
        }

        return $query;
    }

    public function getOrderData(Builder $ordersQuery, OrderRequest $request): array
    {
        //передаём перечисление на view
        $stateEnum = StateEnum::class;

        $orders = SortAction::sort($ordersQuery, $request)->paginate(50);

        $minLimit = PriceLimiterAction::getMinLimit($ordersQuery, 'total');
        $maxLimit = PriceLimiterAction::getMaxLimit($ordersQuery, 'total');

        return compact('orders', 'stateEnum', 'minLimit', 'maxLimit');
    }

    public function cancelOrder($order): RedirectResponse
    {
        if ($order->state == StateEnum::Approved->value || $order->state == StateEnum::Cancelled->value) {
            return redirect()->back()->with('error', 'Этот заказ уже был обработан и не может быть отменен');
        }
        DB::transaction(function () use ($order): void {

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

        });

        return redirect()->back()->with('success', 'Заказ успешно отменен');
    }

    public function updateOrderState(OrderRequest $request, $order): RedirectResponse
    {
        $oldState = $order->state;
        $newState = $request->state_change;
        DB::transaction(function () use ($oldState, $newState, $order): void {
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

        });

        return redirect()->back()->with('success', 'Статус заказа успешно обновлен');
    }
}
