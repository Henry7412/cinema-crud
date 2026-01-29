<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignTurnosRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'turno_ids' => 'required|array',
            'turno_ids.*' => 'exists:turnos,id',
        ];
    }
}
