<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])
    ->name('product.show');
Route::post('/product/add-to-cart', [ProductController::class, 'addToCart'])
    ->name('product.addToCart')
    ->middleware('user');
