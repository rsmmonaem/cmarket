<?php

use Illuminate\Support\Facades\Route;
use Modules\Affiliate\Http\Controllers\AffiliateController;

Route::get('/ref/{code}', [AffiliateController::class, 'track'])->name('affiliate.track');
Route::get('/affiliate/register', [AffiliateController::class, 'register'])->name('affiliate.register');

// Affiliate Dashboard (auth required)
Route::middleware(['auth'])->prefix('affiliate')->name('affiliate.')->group(function () {
    Route::get('/dashboard', [AffiliateController::class, 'dashboard'])->name('dashboard');
    Route::get('/links', [AffiliateController::class, 'links'])->name('links');
    Route::post('/links/generate', [AffiliateController::class, 'generateLink'])->name('links.generate');
    Route::get('/commissions', [AffiliateController::class, 'commissions'])->name('commissions');
    Route::get('/analytics', [AffiliateController::class, 'analytics'])->name('analytics');
    Route::get('/withdraw', [AffiliateController::class, 'withdraw'])->name('withdraw');
    Route::post('/withdraw', [AffiliateController::class, 'requestWithdrawal'])->name('withdraw.request');
});
