<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumno;

class AlumnoSeeder extends Seeder
{
    public function run(): void
    {
        $alumnos = [
            [
                'talla_camisa_id' => 1,
                'talla_pantalon_id' => 2,
                'talla_zapato' => 41,
                'peso' => 62,
                'estatura' => 1.68,
                'orden_nacimiento_id' => 1,
                'lateralidad_id' => 1,
                'persona_id' => 1,
                'etnia_indigena_id' => 1,
                'status' => 'Activo',
            ],
            [
                'talla_camisa_id' => 1,
                'talla_pantalon_id' => 2,
                'talla_zapato' => 43,
                'peso' => 70,
                'estatura' => 1.75,
                'orden_nacimiento_id' => 2,
                'lateralidad_id' => 2,
                'persona_id' => 2,
                'etnia_indigena_id' => 1,
                'status' => 'Activo',
            ],
            [
                'talla_camisa_id' => 1,
                'talla_pantalon_id' => 2,
                'talla_zapato' => 40,
                'peso' => 58,
                'estatura' => 1.60,
                'orden_nacimiento_id' => 3,
                'lateralidad_id' => 1,
                'persona_id' => 3,
                'etnia_indigena_id' => 1,
                'status' => 'Activo',
            ],
            [
                'talla_camisa_id' => 1,
                'talla_pantalon_id' => 2,
                'talla_zapato' => 44,
                'peso' => 78,
                'estatura' => 1.82,
                'orden_nacimiento_id' => 1,
                'lateralidad_id' => 2,
                'persona_id' => 4,
                'etnia_indigena_id' => 1,
                'status' => 'Activo',
            ],
            [
                'talla_camisa_id' => 1,
                'talla_pantalon_id' => 2,
                'talla_zapato' => 41,
                'peso' => 60,
                'estatura' => 1.65,
                'orden_nacimiento_id' => 2,
                'lateralidad_id' => 1,
                'persona_id' => 5,
                'etnia_indigena_id' => 1,
                'status' => 'Activo',
            ],
            [
                'talla_camisa_id' => 1,
                'talla_pantalon_id' => 2,
                'talla_zapato' => 42,
                'peso' => 66,
                'estatura' => 1.70,
                'orden_nacimiento_id' => 1,
                'lateralidad_id' => 2,
                'persona_id' => 6,
                'etnia_indigena_id' => 1,
                'status' => 'Activo',
            ],
            [       
                'talla_camisa_id' => 1,
                'talla_pantalon_id' => 2,
                'talla_zapato' => 44,
                'peso' => 80,
                'estatura' => 1.85,
                'orden_nacimiento_id' => 3,
                'lateralidad_id' => 1,
                'persona_id' => 7,
                'etnia_indigena_id' => 1,
                'status' => 'Activo',
            ],
            [
                'talla_camisa_id' => 1,
                'talla_pantalon_id' => 2,
                'talla_zapato' => 38,
                'peso' => 52,
                'estatura' => 1.55,
                'orden_nacimiento_id' => 2,
                'lateralidad_id' => 2,
                'persona_id' => 8,
                'etnia_indigena_id' => 1,
                'status' => 'Activo',
            ],
            [
                'talla_camisa_id' => 1,
                'talla_pantalon_id' => 2,
                'talla_zapato' => 41,
                'peso' => 64,
                'estatura' => 1.70,
                'orden_nacimiento_id' => 1,
                'lateralidad_id' => 1,
                'persona_id' => 9,
                'etnia_indigena_id' => 1,
                'status' => 'Activo',
            ],
            [
                'talla_camisa_id' => 1,
                'talla_pantalon_id' => 2,
                'talla_zapato' => 43,
                'peso' => 72,
                'estatura' => 1.78,
                'orden_nacimiento_id' => 3,
                'lateralidad_id' => 2,
                'persona_id' => 10,
                'etnia_indigena_id' => 1,
                'status' => 'Activo',
            ],
        ];

        foreach ($alumnos as $alumno) {
            Alumno::create($alumno);
        }

        $this->command->info('Seeder de 10 alumnos ejecutado correctamente.');
    }
}
