<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTurnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hora' => [
                'required',
                'regex:/^\d{2}:\d{2}(:\d{2})?$/',
            ],
            'estado' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'hora.regex' => 'La hora debe tener formato HH:MM o HH:MM:SS.',
        ];
    }
}
