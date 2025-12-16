<?php

namespace Database\Seeders;

use App\Models\DocenteAreaGrado as ModelsDocenteAreaGrado;
use Illuminate\Database\Seeder;

class DocenteAreaGrado extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $detalles = [

            [
                'docente_estudio_realizado_id'  => 1,
                'area_estudio_realizado_id' => 1, 
                'grado_id'      => 1,
            ],
            [
                'docente_estudio_realizado_id'  => 2,
                'area_estudio_realizado_id' => 2, 
                'grado_id'      => 1,
            ],
            [
                'docente_estudio_realizado_id'  => 3,
                'area_estudio_realizado_id' => 3, 
                'grado_id'      => 1,
            ],
            [
                'docente_estudio_realizado_id'  => 4,
                'area_estudio_realizado_id' => 4, 
                'grado_id'      => 1,
            ],
            [
                'docente_estudio_realizado_id'  => 5,
                'area_estudio_realizado_id' => 5,
                'grado_id'      => 1,
            ],
            [
                'docente_estudio_realizado_id'  => 6,
                'area_estudio_realizado_id' => 6,
                'grado_id'      => 1,
            ],
            [
                'docente_estudio_realizado_id'  => 7,
                'area_estudio_realizado_id' => 7,
                'grado_id'      => 1,
            ],
            [
                'docente_estudio_realizado_id'  => 8,
                'area_estudio_realizado_id' =>  8,
                'grado_id'      => 1,
            ],
            [
                'docente_estudio_realizado_id'  => 9,
                'area_estudio_realizado_id' => 9,
                'grado_id'      => 1,
            ],
            [
                'docente_estudio_realizado_id'  => 10,
                'area_estudio_realizado_id' => 10,
                'grado_id'      => 1,
            ],
            [
                'docente_estudio_realizado_id'  => 1,
                'area_estudio_realizado_id' => 4,
                'grado_id'      => 1,
            ],
            [
                'docente_estudio_realizado_id'  => 2,
                'area_estudio_realizado_id' => 6,
                'grado_id'      => 1,
            ],

        ];

        foreach ($detalles as $detalle) {
            ModelsDocenteAreaGrado::create($detalle);
            
        }

        $this->command->info('Seeder de 10 Detalles de Docente y Estudios ejecutado correctamente.');
    }
}
