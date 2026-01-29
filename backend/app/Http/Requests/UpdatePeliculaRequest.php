<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePeliculaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'sometimes|required|string|min:2',
            'fecha_publicacion' => 'sometimes|required|date',
            'estado' => 'sometimes|boolean',
        ];
    }
}
