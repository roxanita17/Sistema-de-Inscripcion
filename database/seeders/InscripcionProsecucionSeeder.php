<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inscripcion;
use App\Models\InscripcionProsecucion;
use App\Models\AnioEscolar;

class InscripcionProsecucionSeeder extends Seeder
{

    public function run(): void
    {
        $inscripcionAnterior = Inscripcion::findOrFail(1);

        $nuevaInscripcion = Inscripcion::create([
            'anio_escolar_id' => 2,
            'alumno_id' => $inscripcionAnterior->alumno_id,
            'grado_id' => 2,
            'seccion_id' => 6,

            // 🔥 COPIA REAL
            'padre_id' => $inscripcionAnterior->padre_id,
            'madre_id' => $inscripcionAnterior->madre_id,
            'representante_legal_id' => $inscripcionAnterior->representante_legal_id,

            'tipo_inscripcion' => 'prosecucion',
            'documentos' => $inscripcionAnterior->documentos,
            'estado_documentos' => 'Completo',
            'acepta_normas_contrato' => true,
            'status' => 'Activo',
        ]);


        InscripcionProsecucion::create([
            'inscripcion_id' => $nuevaInscripcion->id,
            'inscripcion_anterior_id' => $inscripcionAnterior->id,
            'anio_escolar_id' => 2,
            'grado_id' => 2,
            'seccion_id' => 6,
            'promovido' => true,
            'repite_grado' => false,
            'status' => 'Activo',
        ]);

        $nuevaInscripcion = Inscripcion::create([
            'anio_escolar_id' => 3,
            'alumno_id' => $inscripcionAnterior->alumno_id,
            'grado_id' => 3,
            'seccion_id' => 9,

            // 🔥 COPIA REAL
            'padre_id' => $inscripcionAnterior->padre_id,
            'madre_id' => $inscripcionAnterior->madre_id,
            'representante_legal_id' => $inscripcionAnterior->representante_legal_id,

            'tipo_inscripcion' => 'prosecucion',
            'documentos' => $inscripcionAnterior->documentos,
            'estado_documentos' => 'Completo',
            'acepta_normas_contrato' => true,
            'status' => 'Activo',
        ]);


        InscripcionProsecucion::create([
            'inscripcion_id' => $nuevaInscripcion->id,
            'inscripcion_anterior_id' => $inscripcionAnterior->id,
            'anio_escolar_id' => 3,
            'grado_id' => 3,
            'seccion_id' => 9,
            'promovido' => true,
            'repite_grado' => false,
            'status' => 'Activo',
        ]);
    }
}
