<?php

namespace App\Http\Controllers;
use App\Services\Order\OrderService;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    public function index(Request $request)
    {
        $ordersQuery = Order::query();

        $this->orderService->applyFilters($ordersQuery, $request);
        return view('order/orders',$this->orderService->getOrderData($ordersQuery, $request));
    }

}
