<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Services\Order\OrderService;
use Illuminate\Contracts\Support\Renderable;

class AdminController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(OrderRequest $request): Renderable
    {
        $ordersQuery = Order::query();

        $this->orderService->applyFilters($ordersQuery, $request);

        return view('order/orders', $this->orderService->getOrderData($ordersQuery, $request));
    }
}
