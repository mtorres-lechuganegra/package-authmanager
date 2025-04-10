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
        // Registrar archivo de configuración principal
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/authmanager.php',
            'authmanager'
        );
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
