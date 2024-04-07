<?php

namespace App\Services\OrderList;

use App\Http\Filters\FilterInterface;
use App\Http\Requests\OrderListRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;

class OrderListService implements FilterInterface
{
    public function applyFilters(Builder $query, FormRequest $request): Builder
    {
        if ($request->filled('name')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->name}%");
            });
        }

        if ($request->filled('low_subtotal')) {
            $query->where('subtotal', '>=', $request->low_subtotal);
        }

        if ($request->filled('high_subtotal')) {
            $query->where('subtotal', '<=', $request->high_subtotal);
        }

        return $query;
    }

    public function getOrderListData(Builder $orderListQuery, OrderListRequest $request): array
    {
        $minOrderListQuery = clone $orderListQuery;
        $maxOrderListQuery = clone $orderListQuery;

        $minSubtotal = round($minOrderListQuery->min('subtotal'));
        $maxSubtotal = round($maxOrderListQuery->max('subtotal'));

        $sortBy = $request->get('sort_by', 'product_id');
        $sortOrder = $request->get('sort_order', 'asc');

        $orderList = $orderListQuery->orderBy($sortBy, $sortOrder)->paginate(25);

        return compact('orderList', 'minSubtotal', 'maxSubtotal');
    }
}
