<?php

namespace App\Http\Controllers;
use App\Http\Requests\OrderRequest;
use App\Services\Order\OrderService;
use App\Models\Order;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Builder;

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
