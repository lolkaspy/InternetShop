<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use PhpParser\Builder;
use Illuminate\Http\Request;

class OrderListController extends Controller
{
    public function show($order_id, Request $request)
    {
        $orderQuery = OrderList::query()->where('order_id',$order_id)
            ->leftJoin('products', 'order_lists.product_id', '=', 'products.id');;


        if($request->filled('name')){
            $orderQuery->whereHas('product', function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->name}%");
            });
        }

        if($request->filled('low_subtotal')){
            $orderQuery->where('subtotal','>=',$request->low_subtotal);
        }

        if($request->filled('high_subtotal')){
            $orderQuery->where('subtotal','<=',$request->high_subtotal);
        }

        $minOrderQuery = clone $orderQuery;
        $maxOrderQuery = clone $orderQuery;

        $minSubtotal = $minOrderQuery->min('subtotal');
        $maxSubtotal = $maxOrderQuery->max('subtotal');

        $sortBy = $request->get('sort_by', 'product_id');
        $sortOrder = $request->get('sort_order', 'asc');


        $orderList = $orderQuery->orderBy($sortBy, $sortOrder)->paginate(25);

        return view('order/order_list', compact('orderList', 'minSubtotal','maxSubtotal'));
    }
}
