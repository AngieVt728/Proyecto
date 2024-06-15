<?php

use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('user.home');
    Route::get('/products', [HomeController::class, 'products'])->name('user.products');
    Route::get('/orders', [HomeController::class, 'orders'])->name('user.orders');
});
