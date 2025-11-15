<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnioEscolarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'inicio_anio_escolar' => 'required|date',
            'cierre_anio_escolar' => 'required|date|after:inicio_anio_escolar',
        ];
    }

    public function messages(): array
    {
        return [
            'inicio_anio_escolar.required' => 'La fecha de inicio es obligatoria.',
            'inicio_anio_escolar.date' => 'La fecha de inicio debe ser válida.',
            'cierre_anio_escolar.required' => 'La fecha de cierre es obligatoria.',
            'cierre_anio_escolar.date' => 'La fecha de cierre debe ser válida.',
            'cierre_anio_escolar.after' => 'La fecha de cierre debe ser posterior a la fecha de inicio.',
        ];
    }
}