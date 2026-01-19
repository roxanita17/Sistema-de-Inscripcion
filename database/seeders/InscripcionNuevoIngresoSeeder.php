<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InscripcionNuevoIngreso;
use Carbon\Carbon;

class InscripcionNuevoIngresoSeeder extends Seeder
{
    /**
     * Seed de detalles específicos de nuevo ingreso
     * Corresponde a las 10 inscripciones base (IDs 1-10)
     */
    public function run(): void
    {
        $nuevosIngresos = [
            // ============================================
            // PRIMER GRADO - Alumnos 1 y 2
            // ============================================
/*             [
                'id' => 1,
                'inscripcion_id' => 1,
                'numero_zonificacion' => 1001,
                'institucion_procedencia_id' => 1,
                'expresion_literaria_id' => 1,
                'anio_egreso' => Carbon::create(2023, 7, 15),
            ],
            [
                'id' => 2,
                'inscripcion_id' => 2,
                'numero_zonificacion' => 1002,
                'institucion_procedencia_id' => 1,
                'expresion_literaria_id' => 2,
                'anio_egreso' => Carbon::create(2023, 7, 15),
            ], */

            // ============================================
            // SEGUNDO GRADO - Alumnos 3 y 4
            // ============================================
/*             [
                'id' => 3,
                'inscripcion_id' => 3,
                'numero_zonificacion' => 2001,
                'institucion_procedencia_id' => 2,
                'expresion_literaria_id' => 1,
                'anio_egreso' => Carbon::create(2022, 7, 15),
            ],
            [
                'id' => 4,
                'inscripcion_id' => 4,
                'numero_zonificacion' => 2002,
                'institucion_procedencia_id' => 2,
                'expresion_literaria_id' => 3,
                'anio_egreso' => Carbon::create(2022, 7, 15),
            ], */

            // ============================================
            // TERCER GRADO - Alumnos 5 y 6
            // ============================================
/*             [
                'id' => 5,
                'inscripcion_id' => 5,
                'numero_zonificacion' => 3001,
                'institucion_procedencia_id' => 3,
                'expresion_literaria_id' => 2,
                'anio_egreso' => Carbon::create(2021, 7, 15),
            ],
            [
                'id' => 6,
                'inscripcion_id' => 6,
                'numero_zonificacion' => 3002,
                'institucion_procedencia_id' => 3,
                'expresion_literaria_id' => 1,
                'anio_egreso' => Carbon::create(2021, 7, 15),
            ], */

            // ============================================
            // CUARTO GRADO - Alumnos 7 y 8
            // ============================================
            [
                'id' => 7,
                'inscripcion_id' => 7,
                'numero_zonificacion' => 4001,
                'institucion_procedencia_id' => 1,
                'expresion_literaria_id' => 3,
                'anio_egreso' => Carbon::create(2020, 7, 15),
            ],
            [
                'id' => 8,
                'inscripcion_id' => 8,
                'numero_zonificacion' => 4002,
                'institucion_procedencia_id' => 2,
                'expresion_literaria_id' => 2,
                'anio_egreso' => Carbon::create(2020, 7, 15),
            ],

            // ============================================
            // QUINTO GRADO - Alumnos 9 y 10
            // ============================================
            [
                'id' => 9,
                'inscripcion_id' => 9,
                'numero_zonificacion' => 5001,
                'institucion_procedencia_id' => 3,
                'expresion_literaria_id' => 1,  
                'anio_egreso' => Carbon::create(2019, 7, 15),
            ],
            [
                'id' => 10,
                'inscripcion_id' => 10,
                'numero_zonificacion' => 5002,
                'institucion_procedencia_id' => 1,
                'expresion_literaria_id' => 3,
                'anio_egreso' => Carbon::create(2019, 7, 15),
            ],
        ];

        // Insertar los detalles de nuevo ingreso
        foreach ($nuevosIngresos as $nuevoIngreso) {
            InscripcionNuevoIngreso::create($nuevoIngreso);
        }

        $this->command->info('Detalles de Nuevo Ingreso creados: 10 registros');
        $this->command->info('Números de zonificación: 1001-1002 (1°), 2001-2002 (2°), etc.');
    }
}