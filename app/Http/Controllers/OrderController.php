<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Services\Order\OrderService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(OrderRequest $request): Renderable
    {
        $ordersQuery = Order::query()->where('user_id', Auth::id());

        $this->orderService->applyFilters($ordersQuery, $request);

        return view('order/orders', $this->orderService->getOrderData($ordersQuery, $request));
    }

    public function cancelOrder($orderId): RedirectResponse
    {
        $order = Order::find($orderId);

        return $this->orderService->cancelOrder($order);
    }

    public function updateOrderState(OrderRequest $request, $orderId): RedirectResponse
    {
        $order = Order::find($orderId);

        return $this->orderService->updateOrderState($request, $order);
    }
}
