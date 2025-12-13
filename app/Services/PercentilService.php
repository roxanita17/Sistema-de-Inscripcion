<?php

namespace App\Services;

use App\Models\Inscripcion;
use App\Models\EntradasPercentil;
use App\Models\IndiceEdad;
use App\Models\IndicePeso;
use App\Models\IndiceEstatura;
use Carbon\Carbon;

class PercentilService
{
    /**
     * Crea una entrada de percentil desde una inscripción
     */
    public function crearEntradaDesdeInscripcion(Inscripcion $inscripcion)
    {
        $alumno = $inscripcion->alumno;
        $persona = $alumno->persona;

        // Calcular edad en meses
        $edadMeses = Carbon::parse($persona->fecha_nacimiento)->diffInMonths(now());
        
        // Obtener peso y estatura
        $pesoKg = $alumno->peso;
        $estaturaCm = $alumno->estatura;

        // Buscar índices en las tablas
        $indiceEdad = $this->buscarIndiceEdad($edadMeses);
        $indicePeso = $this->buscarIndicePeso($pesoKg);
        $indiceEstatura = $this->buscarIndiceEstatura($estaturaCm);

        // Calcular índice total
        $indiceTotal = $indiceEdad + $indicePeso + $indiceEstatura;

        // Crear entrada
        $entrada = EntradasPercentil::create([
            'edad_meses' => $edadMeses,
            'peso_kg' => $pesoKg,
            'estatura_cm' => $estaturaCm,
            'indice_edad' => $indiceEdad,
            'indice_peso' => $indicePeso,
            'indice_estatura' => $indiceEstatura,
            'indice_total' => $indiceTotal,
            'inscripcion_id' => $inscripcion->id,
            'seccion_id' => null,
            'ejecucion_percentil_id' => null,
            'status' => true,
        ]);

        return $entrada;
    }

    /**
     * Busca el índice de edad según los meses
     */
    private function buscarIndiceEdad($meses)
    {
        $indice = IndiceEdad::where('min_meses', '<=', $meses)
                            ->where('max_meses', '>=', $meses)
                            ->first();

        return $indice ? $indice->indice : 15; // valor por defecto medio
    }

    /**
     * Busca el índice de peso según los kg
     */
    private function buscarIndicePeso($peso)
    {
        $indice = IndicePeso::where('min_kg', '<=', $peso)
                            ->where('max_kg', '>=', $peso)
                            ->first();

        return $indice ? $indice->indice : 15; // valor por defecto medio
    }

    /**
     * Busca el índice de estatura según los cm
     */
    private function buscarIndiceEstatura($estatura)
    {
        $indice = IndiceEstatura::where('min_cm', '<=', $estatura)
                                ->where('max_cm', '>=', $estatura)
                                ->first();

        return $indice ? $indice->indice : 15; // valor por defecto medio
    }
}