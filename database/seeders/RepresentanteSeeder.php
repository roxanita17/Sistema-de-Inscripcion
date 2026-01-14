<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Representante;

class RepresentanteSeeder extends Seeder
{
    public function run(): void
    {
        $representantes = [
            [
                'persona_id' => 21,
                'estado_id' => 1,
                'municipio_id' => 1,
                'parroquia_id' => 1,
                'pais_id' => 1,
                'convivenciaestudiante_representante' => 'Si',
                'ocupacion_representante' => 6

            ],
            [
                'persona_id' => 22,
                'estado_id' => 1,
                'municipio_id' => 1,
                'parroquia_id' => 1,
                'pais_id' => 1,
                'convivenciaestudiante_representante' => 'Si',
                'ocupacion_representante' => 10

            ],
            [
                'persona_id' => 23,
                'estado_id' => 1,
                'municipio_id' => 1,
                'parroquia_id' => 1,
                'pais_id' => 1,
                'convivenciaestudiante_representante' => 'Si',
                'ocupacion_representante' => 1

            ],
            [
                'persona_id' => 24,
                'estado_id' => 1,
                'municipio_id' => 1,
                'parroquia_id' => 1,
                'pais_id' => 1,
                'convivenciaestudiante_representante' => 'No',
                'ocupacion_representante' => 18
            ],
            [
                'persona_id' => 25,
                'estado_id' => 1,
                'municipio_id' => 1,
                'parroquia_id' => 1,
                'pais_id' => 1,
                'convivenciaestudiante_representante' => 'No',
                'ocupacion_representante' => 50
            ],
            [
                'persona_id' => 26,
                'estado_id' => 1,
                'municipio_id' => 1,
                'parroquia_id' => 1,
                'pais_id' => 1,
                'convivenciaestudiante_representante' => 'No',
                'ocupacion_representante' => 7
            ],
            [
                'persona_id' => 27,
                'estado_id' => 1,
                'municipio_id' => 1,
                'parroquia_id' => 1,
                'pais_id' => 1,
                'convivenciaestudiante_representante' => 'No',
                'ocupacion_representante' => 18
            ],
            [
                'persona_id' => 28,
                'estado_id' => 1,
                'municipio_id' => 1,
                'parroquia_id' => 1,
                'pais_id' => 1,
                'convivenciaestudiante_representante' => 'No',
                'ocupacion_representante' => 18
            ]

            
        ];

        foreach ($representantes as $representante) {
            Representante::create($representante);
        }

        $this->command->info('Seeder de 10 representantes ejecutado correctamente.');
    }
}
