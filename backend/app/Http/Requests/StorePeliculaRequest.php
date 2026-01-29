<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeliculaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|min:2',
            'fecha_publicacion' => 'required|date',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'estado' => 'boolean',
        ];
    }
}
