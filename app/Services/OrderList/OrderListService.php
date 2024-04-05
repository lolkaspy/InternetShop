<?php

namespace App\Services\OrderList;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OrderListService
{
    public function applyFilters(Builder $orderListQuery, Request $request)
    {
        if ($request->filled('name')) {
            $orderListQuery->whereHas('product', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->name}%");
            });
        }

        if ($request->filled('low_subtotal')) {
            $orderListQuery->where('subtotal', '>=', $request->low_subtotal);
        }

        if ($request->filled('high_subtotal')) {
            $orderListQuery->where('subtotal', '<=', $request->high_subtotal);
        }
        return $orderListQuery;
    }

    public function getOrderListData(Builder $orderListQuery, Request $request)
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
