<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderListController;
use Illuminate\Support\Facades\Route;

//Order
Route::get('/admin/orders', AdminController::class)->name('orders')
    ->middleware('admin');
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order_id}', [OrderListController::class, 'show'])
    ->name('order_list.show');
Route::post('/order/{order}/cancel', [OrderController::class, 'cancelOrder'])
    ->name('order.cancel')
    ->middleware('user');
Route::post('/order/{order}/updateOrderState', [OrderController::class, 'updateOrderState'])
    ->name('order.updateState')
    ->middleware('admin');

//Cart
Route::post('/create', [CartController::class, 'create'])
    ->name('order.create')
    ->middleware('user');
Route::delete('/destroy', [CartController::class, 'destroy'])
    ->name('cart.destroy')
    ->middleware('user');

