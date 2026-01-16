<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProsecucionArea;
use Carbon\Carbon;

class ProsecucionAreaSeeder extends Seeder
{
    public function run(): void
    {
             $prosecucionesAreas = [
            // Alumno 1: 1° → 2°
            [
                'id' => 1,
                'inscripcion_prosecucion_id' => 1,
                'grado_area_formacion_id' => 1,
                'status' => 'Aprobado',
            ],
            
        ];

        foreach ($prosecucionesAreas as $prosecucionArea) {
            ProsecucionArea::create($prosecucionArea);
        }
    }
}
