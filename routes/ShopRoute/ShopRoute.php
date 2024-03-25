<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [MainController::class, 'index'])->name('main.index');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/success', [App\Http\Controllers\SuccessController::class, 'index'])->name('success');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index')->middleware('user');
Auth::routes();


