<?php

namespace App\Repositories;

use App\Models\InstitucionProcedencia;
use App\Models\ExpresionLiteraria;
use App\Models\Grado;

class InscripcionRepository
{
    public function obtenerDatosIniciales(): array
    {
        return [
            'instituciones' => InstitucionProcedencia::where('status', true)->get(),
            'expresiones_literarias' => ExpresionLiteraria::where('status', true)
                ->orderBy('letra_expresion_literaria')
                ->get(),
            'grados' => Grado::where('status', true)->get(),
        ];
    }
}