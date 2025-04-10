<?php

use Illuminate\Support\Facades\Route;
use LechugaNegra\AuthManager\Http\Controllers\AuthController;

Route::prefix('api/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth:api', 'guard:api'])->group(function () {
    Route::prefix('api/auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
