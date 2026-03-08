<?php

use Illuminate\Support\Facades\Route;
use Modules\Customer\Http\Controllers\DashboardController;

Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');
    
    // Income & Network (Locked until verified)
    Route::middleware(['wallet_verified'])->group(function () {
        Route::get('/commissions', [DashboardController::class, 'commissions'])->name('commissions');
        Route::get('/designation', [DashboardController::class, 'designation'])->name('designation');
        Route::get('/generations', [\Modules\Customer\Http\Controllers\GenerationController::class, 'index'])->name('generations');
        Route::post('/upgrade/voucher', [\Modules\Customer\Http\Controllers\GenerationController::class, 'upgradeWithVoucher'])->name('upgrade.voucher');
        
        // Withdrawal system
        Route::get('/withdrawals', [\Modules\Customer\Http\Controllers\WithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::post('/withdrawals/request', [\Modules\Customer\Http\Controllers\WithdrawalController::class, 'request'])->name('withdrawals.request');
    });
});
