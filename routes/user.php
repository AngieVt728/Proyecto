<?php

use App\Http\Controllers\User\BagController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('user.home');
    Route::get('/products', [HomeController::class, 'products'])->name('user.products');
    Route::get('/orders', [HomeController::class, 'orders'])->name('user.orders');
    Route::get('/new-order', [HomeController::class, 'order'])->name('user.new-order');
    Route::post('/new-order', [HomeController::class, 'store'])->name('user.store-order');
    Route::resource('bags', BagController::class);
    Route::get('/profile', [HomeController::class, 'profile'])->name('user.profile');
});
