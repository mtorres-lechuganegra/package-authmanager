<?php

namespace LechugaNegra\AuthManager\Services;

use Illuminate\Support\Facades\Http;

class AuthManagerService
{
    /**
     * Formatea la respuesta con el token JWT.
     *
     * @param string $token Token JWT generado.
     * @return \Illuminate\Http\JsonResponse Respuesta con token, tipo y expiración.
     */
    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60
        ]);
    }

    /**
     * Valida el token de reCAPTCHA con el servicio de Google.
     *
     * @param string $token  El token generado por el cliente (frontend) de reCAPTCHA.
     * @return bool Retorna true si el token es válido, false en caso contrario.
     */
    public function validateRecaptcha(string $token): bool
    {
        $secret = config('authmanager.recaptcha.secret_key');

        $response = Http::asForm()->post(config('authmanager.recaptcha.verify_url'), [
            'secret' => $secret,
            'response' => $token,
        ]);

        if ($response->ok() && $response->json('success') === true) {
            return true;
        }
    
        throw new \Exception('reCAPTCHA validation failed.');
    }
}
