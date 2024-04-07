<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', MainController::class)
    ->name('main');
Route::get('/profile', ProfileController::class)
    ->name('profile');
Route::get('/success', [App\Http\Controllers\SuccessController::class, 'index'])
    ->name('success');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])
    ->name('cart.index')
    ->middleware('user');
Auth::routes();
