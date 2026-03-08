<?php

use Illuminate\Support\Facades\Route;
use Modules\Rider\Http\Controllers\DashboardController;

Route::middleware(['auth', 'role:rider'])->prefix('rider')->name('rider.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Delivery management
    Route::get('/deliveries', [\Modules\Rider\Http\Controllers\DeliveryController::class, 'index'])->name('deliveries.index');
    Route::get('/deliveries/{delivery}', [\Modules\Rider\Http\Controllers\DeliveryController::class, 'show'])->name('deliveries.show');
    Route::post('/deliveries/{delivery}/update-status', [\Modules\Rider\Http\Controllers\DeliveryController::class, 'updateStatus'])->name('deliveries.update-status');
});

// Rider registration (public)
Route::get('/rider/register', [\Modules\Rider\Http\Controllers\RiderRegistrationController::class, 'showRegistrationForm'])->name('rider.register');
Route::post('/rider/register', [\Modules\Rider\Http\Controllers\RiderRegistrationController::class, 'register'])->name('rider.register.submit')->middleware('auth');
