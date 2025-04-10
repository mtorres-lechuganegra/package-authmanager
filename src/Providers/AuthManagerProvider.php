<?php

namespace LechugaNegra\AuthManager\Providers;

use Illuminate\Support\ServiceProvider;
use LechugaNegra\AuthManager\Services\AuthManagerService;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider;

class AuthManagerProvider extends ServiceProvider
{
    /**
     * Realizar el registro de servicios.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('authmanager', function ($app) {
            return new AuthManagerService(JWTAuth::class);
        });

        // Registrar JWTAuth como servicio
        $this->app->register(LaravelServiceProvider::class);
    }

    /**
     * Realizar las configuraciones necesarias.
     *
     * @return void
     */
    public function boot()
    {
        // Publicar la configuración
        $this->publishes([
            __DIR__ . '/../../config/authmanager.php' => config_path('authmanager.php'),
        ], 'config');

        // Cargar rutas de api.php
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
    }
}
