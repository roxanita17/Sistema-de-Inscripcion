<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Docente;

class DocenteSeeder extends Seeder
{
    public function run(): void
    {
        $docentes = [
            [
                'codigo' => '2001',
                'dependencia' => 'Liceo General Juan Guilermo Iribarren',
                'persona_id' => 11,
                'anio_escolar_id' => 1,
                'status' => true,
            ],

            [
                'codigo' => '2002',
                'dependencia' => 'Escuela Basica 24 de Julio',
                'persona_id' => 12,
                'anio_escolar_id' => 1,

                'status' => true,
            ],

            [
                'codigo' => '2003',
                'dependencia' => 'Escuela Basica Tricentenaria',
                'persona_id' => 13,
                'anio_escolar_id' => 1,

                'status' => true,
            ],

            [
                'codigo' => '2004',
                'dependencia' => 'Escuela Basica 24 de Julio',
                'persona_id' => 14,
                'anio_escolar_id' => 1,

                'status' => true,
            ],

            [
                'codigo' => '2005',
                'dependencia' => 'Escuela Basica Tricentenaria',
                'persona_id' => 15,
                'anio_escolar_id' => 2,
                'status' => true,
            ],

            [
                'codigo' => '2006',
                'dependencia' => 'Liceo General Juan Guilermo Iribarren',
                'persona_id' => 16,
                'anio_escolar_id' => 2,
                'status' => true,
            ],

            [
                'codigo' => '2007',
                'dependencia' => 'Escuela Basica Tricentenaria',
                'persona_id' => 17,
                'anio_escolar_id' => 2,
                'status' => true,
            ],

            [
                'codigo' => '2008',
                'dependencia' => 'Escuela Basica 24 de Julio',
                'persona_id' => 18,
                'anio_escolar_id' => 3,
                'status' => true,
            ],

            [
                'codigo' => '2009',
                'dependencia' => 'Liceo General Juan Guilermo Iribarren',
                'persona_id' => 19,
                'anio_escolar_id' => 3,
                'status' => true,
            ],
            
            [
                'codigo' => '2010',
                'dependencia' => 'Liceo General Juan Guilermo Iribarren',
                'persona_id' => 20,
                'anio_escolar_id' => 3,
                'status' => true,
            ],
        ];

        foreach ($docentes as $docente) {
            Docente::create($docente);
        }

        $this->command->info('Seeder de 10 docentes ejecutado correctamente.');
    }
}
