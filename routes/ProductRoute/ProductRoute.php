<?php

use Illuminate\Support\Facades\Route;

Route::get('/products', [\App\Http\Controllers\ProductController::class,'index'])->name('products.index');
Route::get('/products/{product:slug}', [\App\Http\Controllers\ProductController::class,'show'])->name('product.show');
Route::post('/product/add-to-cart', [\App\Http\Controllers\ProductController::class,'addToCart'])->name('product.addToCart')->middleware('user');
