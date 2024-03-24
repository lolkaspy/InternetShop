<?php

use Illuminate\Support\Facades\Route;

//Order
Route::get('/admin/orders', \App\Http\Controllers\AdminController::class)->name('orders')->middleware('admin');
Route::get('/orders', [\App\Http\Controllers\OrderController::class,'index'])->name('orders.index');
Route::get('/orders/{order_id}',[\App\Http\Controllers\OrderListController::class,'show'])->name('order_list.show');
Route::post('/order/{order}/cancel', [\App\Http\Controllers\OrderController::class,'cancelOrder'])->name('order.cancel')->middleware('user');
Route::post('/order/{order}/updateOrderState', [\App\Http\Controllers\OrderController::class,'updateOrderState'])->name('order.updateState')->middleware('admin');

//Cart
Route::post('/create',[\App\Http\Controllers\CartController::class,'create'])->name('order.create')->middleware('user');
Route::delete('/destroy',[\App\Http\Controllers\CartController::class,'destroy'])->name('cart.destroy')->middleware('user');

