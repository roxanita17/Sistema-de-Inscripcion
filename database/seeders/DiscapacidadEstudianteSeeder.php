<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiscapacidadEstudiante;

class DiscapacidadEstudianteSeeder extends Seeder
{
    public function run(): void
    {
        $discapacidad_estudiantes = [
            [
                'alumno_id' => 1,
                'discapacidad_id' => 1,
                'status' => true,
            ],
            [
                'alumno_id' => 2,
                'discapacidad_id' => 2,
                'status' => true,
            ],
            [
                'alumno_id' => 3,
                'discapacidad_id' => 3,
                'status' => true,
            ],
            [
                'alumno_id' => 4,
                'discapacidad_id' => 4,
                'status' => true,
            ],
            [
                'alumno_id' => 5,
                'discapacidad_id' => 5,
                'status' => true,
            ],
            [
                'alumno_id' => 6,
                'discapacidad_id' => 6,
                'status' => true,
            ],
            [       
                'alumno_id' => 7,
                'discapacidad_id' => 7,
                'status' => true,
            ],
            [
                'alumno_id' => 8,
                'discapacidad_id' => 8,
                'status' => true,
            ],
            [
                'alumno_id' => 9,
                'discapacidad_id' => 9,
                'status' => true,
            ],
            [
                'alumno_id' => 10,
                'discapacidad_id' => 10,
                'status' => true,
            ],
        ];

        foreach ($discapacidad_estudiantes as $discapacidad_estudiante) {
            DiscapacidadEstudiante::create($discapacidad_estudiante);
        }

        $this->command->info('Seeder de 10 discapacidad_estudiantes ejecutado correctamente.');
    }
}
