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
    | ReCatpcha Setting
    |--------------------------------------------------------------------------
    |
    | Variables de configuración para la validaciónd e recaptcha
    |
    */
    'recaptcha' => [
        'enabled' => env('RECAPTCHA_ENABLED', false),
        'secret_key' => env('RECAPTCHA_SECRET_KEY'),
        'verify_url' => env('RECAPTCHA_VERIFY_URL', 'https://www.google.com/recaptcha/api/siteverify')
    ]
];