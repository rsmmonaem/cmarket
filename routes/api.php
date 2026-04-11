<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\ApiAuthController;

Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/login/verify', [ApiAuthController::class, 'verifyOtp']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    
    Route::get('/users/search', [\App\Http\Controllers\Api\UserController::class, 'search'])->middleware('web', 'auth');
});
