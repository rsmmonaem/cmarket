<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// Public routes
// Routes moved to Modules/Ecommerce, Modules/Admin, etc.

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Multi-layer Security OTP
    Route::get('/auth/otp-verify', [AuthController::class, 'showOtpVerifyForm'])->name('auth.otp.verify.form');
    Route::post('/auth/otp-verify', [AuthController::class, 'verifyLoginOtp'])->name('auth.otp.verify');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

