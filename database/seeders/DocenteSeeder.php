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
                'status' => true,
            ],
            [
                'codigo' => '2002',
                'dependencia' => 'Escuela Basica 24 de Julio',
                'persona_id' => 12,
                'status' => true,
            ],
            [
                'codigo' => '2003',
                'dependencia' => 'Escuela Basica Tricentenaria',
                'persona_id' => 13,
                'status' => true,
            ],
            [
                'codigo' => '2004',
                'dependencia' => 'Escuela Basica 24 de Julio',
                'persona_id' => 14,
                'status' => true,
            ],
            [
                'codigo' => '2005',
                'dependencia' => 'Escuela Basica Tricentenaria',
                'persona_id' => 15,
                'status' => true,
            ],
            [
                'codigo' => '2006',
                'dependencia' => 'Liceo General Juan Guilermo Iribarren',
                'persona_id' => 16,
                'status' => true,
            ],
            [
                'codigo' => '2007',
                'dependencia' => 'Escuela Basica Tricentenaria',
                'persona_id' => 17,
                'status' => true,
            ],
            [
                'codigo' => '2008',
                'dependencia' => 'Escuela Basica 24 de Julio',
                'persona_id' => 18,
                'status' => true,
            ],
            [
                'codigo' => '2009',
                'dependencia' => 'Liceo General Juan Guilermo Iribarren',
                'persona_id' => 19,
                'status' => true,
            ],
            [
                'codigo' => '2010',
                'dependencia' => 'Liceo General Juan Guilermo Iribarren',
                'persona_id' => 20,
                'status' => true,
            ],
        ];

        foreach ($docentes as $docente) {
            Docente::create($docente);
        }

        $this->command->info('Seeder de 10 docentes ejecutado correctamente.');
    }
}
