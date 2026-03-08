<?php

use Illuminate\Support\Facades\Route;
use Modules\Merchant\Http\Controllers\DashboardController;

Route::middleware(['auth', 'role:merchant'])->prefix('merchant')->name('merchant.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Product management
    Route::resource('products', \Modules\Merchant\Http\Controllers\ProductController::class);
    
    // Order management
    Route::get('/orders', [\Modules\Merchant\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\Modules\Merchant\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    
    // Reports
    Route::get('/reports/sales', [\Modules\Merchant\Http\Controllers\ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/sales/export', [\Modules\Merchant\Http\Controllers\ReportController::class, 'exportExcel'])->name('reports.sales.export');
    Route::get('/reports/analytics', [DashboardController::class, 'index'])->name('reports.analytics');
    
    // Shop settings
    Route::get('/shop', [\Modules\Merchant\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
    Route::post('/shop', [\Modules\Merchant\Http\Controllers\ShopController::class, 'update'])->name('shop.update');
});

// Merchant registration (public)
Route::get('/merchant/register', [\Modules\Merchant\Http\Controllers\MerchantRegistrationController::class, 'showRegistrationForm'])->name('merchant.register');
Route::post('/merchant/register', [\Modules\Merchant\Http\Controllers\MerchantRegistrationController::class, 'register'])->name('merchant.register.submit')->middleware('auth');
