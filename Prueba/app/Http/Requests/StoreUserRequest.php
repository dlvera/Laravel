<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'identifier' => 'required|numeric|unique:users',
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/'
            ],
            'phone' => 'nullable|digits:10',
            'cedula' => 'required|string|max:11',
            'birth_date' => 'required|date|before_or_equal:-18 years',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, un número y un carácter especial.',
            'birth_date.before_or_equal' => 'El usuario debe ser mayor de 18 años.',
        ];
    }
}