<?php

namespace LechugaNegra\AuthManager\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permitir que cualquier usuario intente iniciar sesión
    }

    public function rules(): array
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ];
    
        if (config('authmanager.recaptcha.enabled')) {
            $rules['recaptcha_token'] = 'required|string';
        }
    
        return $rules;
    }

    public function messages()
    {
        return [
            'email.required' => 'The email is required.',
            'email.email' => 'The email must be a valid email address.',
            'password.required' => 'The password is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 6 characters long.',
            'recaptcha_token.required' => 'The reCAPTCHA token is required.'
        ];
    }
}
