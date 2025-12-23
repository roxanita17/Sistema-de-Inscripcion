<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inscripcion;
use App\Models\InscripcionNuevoIngreso;
use App\Models\AnioEscolar;
use App\Models\InscripcionProsecucion;
use Carbon\Carbon;

class InscripcionSeeder extends Seeder
{
    public function run(): void
    {
        $anioEscolar = AnioEscolar::first();

        if (!$anioEscolar) {
            $this->command->warn('No hay año escolar, seeder cancelado.');
            return;
        }

        for ($i = 1; $i <= 10; $i++) {

            // Crear inscripción
            $inscripcion = Inscripcion::create([
                'anio_escolar_id' => rand(1, 2),
                'alumno_id' => $i,
                'grado_id' => 1,
                'seccion_id' => null,

                'padre_id' => 1,
                'madre_id' => 2,
                'representante_legal_id' => 1,

                'tipo_inscripcion' => 'nuevo_ingreso',

                'documentos' => [
                    'partida_nacimiento',
                    'boletin',
                    'fotos'
                ],

                'estado_documentos' => 'Pendiente',
                'observaciones' => 'Inscripción por nuevo ingreso',
                'acepta_normas_contrato' => true,
                'status' => 'Activo',
            ]);

            // Crear datos específicos de nuevo ingreso
            InscripcionNuevoIngreso::create([
                'inscripcion_id' => $inscripcion->id,
                'numero_zonificacion' => $i,
                'institucion_procedencia_id' => rand(1, 3),
                'expresion_literaria_id' => rand(1, 3),
                'anio_egreso' => Carbon::create(2024, 7, 15),
            ]);
        }
        // Crear datos específicos de nuevo ingreso
        InscripcionProsecucion::create([
            'inscripcion_id' => 1,
            'promovido' => true,
            'grado_id' => 2,
            'seccion_id' => 2,
            'repite_grado' => false,
            'acepta_normas_contrato' => true,
            'anio_escolar_id' => 2,
            'observaciones' => 'Inscripción por nuevo ingreso',
            'status' => 'Activo',
        ]);

        $this->command->info('Seeder de Inscripción Nuevo Ingreso ejecutado correctamente.');
    }
}
