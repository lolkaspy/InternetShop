<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\Product;
use App\Services\Cart\CartService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function index(): Renderable
    {
        $cart = Cart::query()->where('user_id',Auth::id())->paginate(25);
        return view('order/cart', compact('cart'));
    }
    public function create(Request $request): RedirectResponse
    {
       return $this->cartService->createOrder($request);
    }

    public function destroy(): RedirectResponse
    {
        $cartItems = Cart::where('user_id', Auth::id());
        $cartItems->forceDelete();

        return redirect()->back()->with('success', 'Корзина очищена');
    }

}
