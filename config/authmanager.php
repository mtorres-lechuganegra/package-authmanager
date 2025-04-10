<?php

return [
    /*
    |--------------------------------------------------------------------------
    | User entity
    |--------------------------------------------------------------------------
    |
    | Modelo de Usuario para la gestión de autenticación.
    |
    */
    'user_entity' => [
        'model' => App\Models\User::class,
        'table' => 'users'
    ],

    /*
    |--------------------------------------------------------------------------
    | JWT Secret
    |--------------------------------------------------------------------------
    |
    | La clave secreta utilizada para firmar el JWT.
    | Esto debe ser lo suficientemente largo y secreto.
    |
    */
    'jwt_secret' => env('JWT_SECRET', 'your_secret_key'),

    /*
    |--------------------------------------------------------------------------
    | Token Expiration
    |--------------------------------------------------------------------------
    |
    | Tiempo de expiración del token en minutos.
    |
    */
    'token_expiration' => env('JWT_EXPIRATION', 60),  // 60 minutos

    /*
    |--------------------------------------------------------------------------
    | Refresh Token Expiration
    |--------------------------------------------------------------------------
    |
    | Tiempo de expiración del token de refresco en días.
    |
    */
    'refresh_token_expiration' => env('JWT_REFRESH_EXPIRATION', 30),  // 30 días
];