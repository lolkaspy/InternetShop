<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderListRequest;
use App\Models\Order;
use App\Models\OrderList;
use App\Services\OrderList\OrderListService;
use PhpParser\Builder;
use Illuminate\Http\Request;

class OrderListController extends Controller
{
    private $orderListService;
    public function __construct(OrderListService $orderListService)
    {
        $this->orderListService = $orderListService;
    }
    public function show(OrderListRequest $request, $order_id)
    {
        $orderListQuery = OrderList::query()->where('order_id', $order_id)
            ->leftJoin('products', 'order_lists.product_id', '=', 'products.id')->with('order');

        $this->orderListService->applyFilters($orderListQuery,$request);
        return view('order/order_list', $this->orderListService->getOrderListData($orderListQuery,$request));
    }
}
