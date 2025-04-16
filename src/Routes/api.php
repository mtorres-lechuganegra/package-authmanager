<?php

use Illuminate\Support\Facades\Route;
use LechugaNegra\AuthManager\Http\Controllers\AuthController;

Route::prefix('api/auth')->name('api.auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login'); // Inicia sesión
});

Route::middleware(['auth:api'])->group(function () {
    Route::prefix('api/auth')->name('api.auh.')->group(function () {
        Route::get('/me', [AuthController::class, 'me'])->name('me'); // Obtiene datos de usuario autenticado
        Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh'); // Refresca token de autenticación
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Cierra sesión
        Route::post('/validate', [AuthController::class, 'validate'])->name('validate'); // Valida token de autenticación
    });
});
