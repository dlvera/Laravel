<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->is_admin;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'identifier' => 'required|numeric|unique:users,identifier',
            'phone' => 'nullable|digits:10',
            'document' => 'required|string|max:11',
            'birthdate' => 'required|date|before:-18 years',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
        ];
    }

    public function messages()
    {
        return [
            'birthdate.before' => 'El usuario debe ser mayor de 18 años.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ];
    }
}