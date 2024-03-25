<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Services\Order\OrderService;
class AdminController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function __invoke(Request $request)
    {
        $ordersQuery = Order::query();
        $this->orderService->applyFilters($ordersQuery, $request);
        return view('order/orders',$this->orderService->getOrderData($ordersQuery, $request));
    }

}
