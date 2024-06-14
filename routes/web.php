<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\CommercialManagement\CustomerController;
use App\Http\Controllers\CommercialManagement\PaymentController;
use App\Http\Controllers\CommercialManagement\RetailOutletController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductInventory\ProductController;
use App\Http\Controllers\ProductInventory\RevenueController;
use App\Http\Controllers\ProductInventory\SaleController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\RawMaterialInventory\EntryController;
use App\Http\Controllers\RawMaterialInventory\OutflowController;
use App\Http\Controllers\RawMaterialInventory\RawMaterialController;
use App\Http\Controllers\RawMaterialInventory\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'about'])->name('profile.about');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('entries', EntryController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('outflows', OutflowController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('products', ProductController::class);
    Route::resource('raw-materials', RawMaterialController::class);
    Route::resource('retail-outlets', RetailOutletController::class);
    Route::resource('revenues', RevenueController::class);
    Route::resource('sales', SaleController::class);
    Route::resource('suppliers', SupplierController::class);
});

require __DIR__ . '/auth.php';
