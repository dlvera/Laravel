<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmailRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'subject' => 'required|string|max:255',
            'recipient' => 'required|email',
            'body' => 'required|string',
        ];
    }
}