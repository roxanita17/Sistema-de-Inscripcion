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
                
                
                'talla_camisa' => 40,
                'talla_pantalon' => 38,
                'talla_zapato' => 41,
                'peso' => 62,
                'estatura' => 168,
                'orden_nacimiento_id' => 1,
                'lateralidad_id' => 1,
                'persona_id' => 1,
                'status' => 'Activo',
            ],
            [
                
                
                'talla_camisa' => 42,
                'talla_pantalon' => 40,
                'talla_zapato' => 43,
                'peso' => 70,
                'estatura' => 175,
                'orden_nacimiento_id' => 2,
                'lateralidad_id' => 2,
                'persona_id' => 2,
                'status' => 'Activo',
            ],
            [
                
                
                'talla_camisa' => 38,
                'talla_pantalon' => 36,
                'talla_zapato' => 40,
                'peso' => 58,
                'estatura' => 160,
                'orden_nacimiento_id' => 3,
                'lateralidad_id' => 1,
                'persona_id' => 3,
                'status' => 'Activo',
            ],
            [
                
                
                'talla_camisa' => 44,
                'talla_pantalon' => 42,
                'talla_zapato' => 44,
                'peso' => 78,
                'estatura' => 182,
                'orden_nacimiento_id' => 1,
                'lateralidad_id' => 2,
                'persona_id' => 4,
                'status' => 'Activo',
            ],
            [
                
                
                'talla_camisa' => 39,
                'talla_pantalon' => 38,
                'talla_zapato' => 41,
                'peso' => 60,
                'estatura' => 165,
                'orden_nacimiento_id' => 2,
                'lateralidad_id' => 1,
                'persona_id' => 5,
                'status' => 'Activo',
            ],
            [
                
                
                'talla_camisa' => 41,
                'talla_pantalon' => 39,
                'talla_zapato' => 42,
                'peso' => 66,
                'estatura' => 170,
                'orden_nacimiento_id' => 1,
                'lateralidad_id' => 2,
                'persona_id' => 6,
                'status' => 'Activo',
            ],
            [
                
                
                'talla_camisa' => 43,
                'talla_pantalon' => 42,
                'talla_zapato' => 44,
                'peso' => 80,
                'estatura' => 185,
                'orden_nacimiento_id' => 3,
                'lateralidad_id' => 1,
                'persona_id' => 7,
                'status' => 'Activo',
            ],
            [
                
                
                'talla_camisa' => 37,
                'talla_pantalon' => 36,
                'talla_zapato' => 38,
                'peso' => 52,
                'estatura' => 155,
                'orden_nacimiento_id' => 2,
                'lateralidad_id' => 2,
                'persona_id' => 8,
                'status' => 'Activo',
            ],
            [
                
                
                'talla_camisa' => 40,
                'talla_pantalon' => 38,
                'talla_zapato' => 41,
                'peso' => 64,
                'estatura' => 170,
                'orden_nacimiento_id' => 1,
                'lateralidad_id' => 1,
                'persona_id' => 9,
                'status' => 'Activo',
            ],
            [
                
                
                'talla_camisa' => 42,
                'talla_pantalon' => 40,
                'talla_zapato' => 43,
                'peso' => 72,
                'estatura' => 178,
                'orden_nacimiento_id' => 3,
                'lateralidad_id' => 2,
                'persona_id' => 10,
                'status' => 'Activo',
            ],
        ];

        foreach ($alumnos as $alumno) {
            Alumno::create($alumno);
        }

        $this->command->info('Seeder de 10 alumnos ejecutado correctamente.');
    }
}
