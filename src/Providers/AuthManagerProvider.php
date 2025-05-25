<?php

namespace LechugaNegra\AuthManager\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
        ], 'authmanager-config');
        
        // Cargar rutas dinámicas según la versión especificada en config
        $this->loadVersionedRoutes();
    }

    /**
     * Carga el archivo de rutas correspondiente a la versión configurada.
     *
     * @return void
     */
    protected function loadVersionedRoutes()
    {
        $version = config('authmanager.version', 'v1');
        $routesPath = __DIR__ . "/../Routes/{$version}/api.php";

        if (file_exists($routesPath)) {
            Route::prefix("api/{$version}")
                ->group($routesPath);
        } else {
            throw new \Exception("Routes file not found for version '{$version}'.");
        }
    }
}
