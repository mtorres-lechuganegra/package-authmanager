<?php

namespace LechugaNegra\AuthManager\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LechugaNegra\AuthManager\Http\Requests\v1\LoginRequest;
use LechugaNegra\AuthManager\Services\AuthManagerService;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthManagerService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Inicia sesión y devuelve el token JWT.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            if (config('authmanager.recaptcha.enabled')) {
                if (empty($request->recaptcha_token) || !$this->authService->validateRecaptcha($request->recaptcha_token)) {
                    return response()->json(['error' => 'Invalid reCAPTCHA'], 403);
                }
            }

            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->authService->respondWithToken($token);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Obtiene el usuario autenticado.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {
            return response()->json(Auth::user(), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Validate token de autenticación.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function validate()
    {
        return response()->json(['validate' => true], 200);
    }

    /**
     * Refresca el token JWT.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            return $this->authService->respondWithToken(Auth::refresh());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Cierra la sesión del usuario.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            Auth::logout();
            return response()->json(['message' => 'Sesión cerrada correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
