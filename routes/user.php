<?php

use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/home', [HomeController::class, 'home'])->name('user.home');
});
