<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProsecucionArea;
use Carbon\Carbon;

class ProsecucionAreaSeeder extends Seeder
{
    public function run(): void
    {
        { 

            // Crear datos específicos de nuevo ingreso
            ProsecucionArea::create([
                'inscripcion_prosecucion_id' => 1,
                'grado_area_formacion_id' => 1,
                'status' => 'Pendiente',
            ]);
            ProsecucionArea::create([
                'inscripcion_prosecucion_id' => 2,
                'grado_area_formacion_id' => 13,
                'status' => 'Pendiente',
            ]);

            
        }

        $this->command->info('Seeder de Areas de Prosecucion ejecutado correctamente.');
    }
}
