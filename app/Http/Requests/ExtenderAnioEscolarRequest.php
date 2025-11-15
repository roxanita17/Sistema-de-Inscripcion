<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExtenderAnioEscolarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cierre_anio_escolar' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'cierre_anio_escolar.required' => 'La nueva fecha de cierre es obligatoria.',
            'cierre_anio_escolar.date' => 'La fecha debe ser válida.',
        ];
    }
}