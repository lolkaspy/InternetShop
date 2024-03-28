<?php

namespace App\Services\Order;

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

        $minTotal = $minTotalQuery->min('total');
        $maxTotal = $maxTotalQuery->max('total');

        $orders = $ordersQuery->orderBy($sortBy, $sortOrder)->paginate(50);

        return compact('orders', 'minTotal', 'maxTotal');
    }
}
