<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inscripcion;
use App\Models\AnioEscolar;

class InscripcionSeeder extends Seeder
{

    public function run(): void
    {
        $anioAnterior = AnioEscolar::find(1);

        if (!$anioAnterior) {
            $this->command->error('No existe el año escolar con ID 1');
            return;
        }

        $inscripciones = [
            // ============================================
            // Anio Escolar 1
            // ============================================
/*             [
                'id' => 1,
                'anio_escolar_id' => 1,
                'alumno_id' => 1,
                'grado_id' => 1,
                'seccion_id' => 1,
                'padre_id' => 1,
                'madre_id' => 2,
                'representante_legal_id' => 1,
                'tipo_inscripcion' => 'nuevo_ingreso',
                'documentos' => ["partida_nacimiento","copia_cedula_representante","copia_cedula_estudiante","boletin_6to_grado","certificado_calificaciones","constancia_aprobacion_primaria","foto_estudiante","foto_representante","carnet_vacunacion","autorizacion_tercero","notas_certificadas","liberacion_cupo"],
                'estado_documentos' => 'Completo',
                'observaciones' => 'Sin observaciones',
                'acepta_normas_contrato' => true,
                'status' => 'Activo',
            ],
            [
                'id' => 2,
                'anio_escolar_id' => 1,
                'alumno_id' => 2,
                'grado_id' => 1,
                'seccion_id' => 2,
                'padre_id' => 1,
                'madre_id' => 2,
                'representante_legal_id' => 1,
                'tipo_inscripcion' => 'nuevo_ingreso',
                'documentos' => ["partida_nacimiento","copia_cedula_representante","copia_cedula_estudiante","boletin_6to_grado","certificado_calificaciones","constancia_aprobacion_primaria","foto_estudiante","foto_representante","carnet_vacunacion","autorizacion_tercero","notas_certificadas","liberacion_cupo"],
                'estado_documentos' => 'Completo',
                'observaciones' => 'Sin observaciones',
                'acepta_normas_contrato' => true,
                'status' => 'Activo',
            ],
            [
                'id' => 3,
                'anio_escolar_id' => 1,
                'alumno_id' => 2,
                'grado_id' => 1,
                'seccion_id' => 2,
                'padre_id' => 1,
                'madre_id' => 2,
                'representante_legal_id' => 1,
                'tipo_inscripcion' => 'nuevo_ingreso',
                'documentos' => ["partida_nacimiento","copia_cedula_representante","copia_cedula_estudiante","boletin_6to_grado","certificado_calificaciones","constancia_aprobacion_primaria","foto_estudiante","foto_representante","carnet_vacunacion","autorizacion_tercero","notas_certificadas","liberacion_cupo"],
                'estado_documentos' => 'Completo',
                'observaciones' => 'Sin observaciones',
                'acepta_normas_contrato' => true,
                'status' => 'Activo',
            ], */

            // ============================================
            // Anio escolar 2
            // ============================================
/*             [
                'id' => 4,
                'anio_escolar_id' => 2,
                'alumno_id' => 3,
                'grado_id' => 2,
                'seccion_id' => 1, // Sección A
                'padre_id' => 1,
                'madre_id' => 2,
                'representante_legal_id' => 1,
                'tipo_inscripcion' => 'nuevo_ingreso',
                'documentos' => ["partida_nacimiento","copia_cedula_representante","copia_cedula_estudiante","boletin_6to_grado","certificado_calificaciones","constancia_aprobacion_primaria","foto_estudiante","foto_representante","carnet_vacunacion","autorizacion_tercero","notas_certificadas","liberacion_cupo"],
                'estado_documentos' => 'Completo',
                'observaciones' => 'Sin observaciones',
                'acepta_normas_contrato' => true,
                'status' => 'Activo',
            ],
            [
                'id' => 5,
                'anio_escolar_id' => 2,
                'alumno_id' => 4,
                'grado_id' => 2,
                'seccion_id' => 2, // Sección B
                'padre_id' => 1,
                'madre_id' => 2,
                'representante_legal_id' => 1,
                'tipo_inscripcion' => 'nuevo_ingreso',
                'documentos' => ["partida_nacimiento","copia_cedula_representante","copia_cedula_estudiante","boletin_6to_grado","certificado_calificaciones","constancia_aprobacion_primaria","foto_estudiante","foto_representante","carnet_vacunacion","autorizacion_tercero","notas_certificadas","liberacion_cupo"],
                'estado_documentos' => 'Completo',
                'observaciones' => 'Sin observaciones',
                'acepta_normas_contrato' => true,
                'status' => 'Activo',
            ],
            [
                'id' => 6,
                'anio_escolar_id' => 2,
                'alumno_id' => 6,
                'grado_id' => 3,
                'seccion_id' => 4, // Sección B
                'padre_id' => 1,
                'madre_id' => 2,
                'representante_legal_id' => 1,
                'tipo_inscripcion' => 'nuevo_ingreso',
                'documentos' => ["partida_nacimiento","copia_cedula_representante","copia_cedula_estudiante","boletin_6to_grado","certificado_calificaciones","constancia_aprobacion_primaria","foto_estudiante","foto_representante","carnet_vacunacion","autorizacion_tercero","notas_certificadas","liberacion_cupo"],
                'estado_documentos' => 'Completo',
                'observaciones' => 'Sin observaciones',
                'acepta_normas_contrato' => true,
                'status' => 'Activo',
            ], */

            // ============================================
            // Anio Escolar 3
            // ============================================
            [
                'id' => 7,
                'anio_escolar_id' => 3,
                'alumno_id' => 7,
                'grado_id' => 1,
                'seccion_id' => null, 
                'padre_id' => 1,
                'madre_id' => 2,
                'representante_legal_id' => 1,
                'tipo_inscripcion' => 'nuevo_ingreso',
                'documentos' => ["partida_nacimiento","copia_cedula_representante","copia_cedula_estudiante","boletin_6to_grado","certificado_calificaciones","constancia_aprobacion_primaria","foto_estudiante","foto_representante","carnet_vacunacion","autorizacion_tercero","notas_certificadas","liberacion_cupo"],
                'estado_documentos' => 'Completo',
                'observaciones' => 'Sin observaciones',
                'acepta_normas_contrato' => true,
                'status' => 'Activo',
            ],
            [
                'id' => 8,
                'anio_escolar_id' => 3,
                'alumno_id' => 8,
                'grado_id' => 1,
                'seccion_id' => null,
                'padre_id' => 1,
                'madre_id' => 2,
                'representante_legal_id' => 1,
                'tipo_inscripcion' => 'nuevo_ingreso',
                'documentos' => ["partida_nacimiento","copia_cedula_representante","copia_cedula_estudiante","boletin_6to_grado","certificado_calificaciones","constancia_aprobacion_primaria","foto_estudiante","foto_representante","carnet_vacunacion","autorizacion_tercero","notas_certificadas","liberacion_cupo"],
                'estado_documentos' => 'Completo',
                'observaciones' => 'Sin observaciones',
                'acepta_normas_contrato' => true,
                'status' => 'Activo',
            ],
            [
                'id' => 9,
                'anio_escolar_id' => 3,
                'alumno_id' => 9,
                'grado_id' => 1,
                'seccion_id' => null,
                'padre_id' => 1,
                'madre_id' => 2,
                'representante_legal_id' => 1,
                'tipo_inscripcion' => 'nuevo_ingreso',
                'documentos' =>["partida_nacimiento","copia_cedula_representante","copia_cedula_estudiante","boletin_6to_grado","certificado_calificaciones","constancia_aprobacion_primaria","foto_estudiante","foto_representante","carnet_vacunacion","autorizacion_tercero","notas_certificadas","liberacion_cupo"],
                'estado_documentos' => 'Completo',
                'observaciones' => 'Sin observaciones',
                'acepta_normas_contrato' => true,
                'status' => 'Activo',
            ],
            [
                'id' => 10,
                'anio_escolar_id' => 3,
                'alumno_id' => 10,
                'grado_id' => 1,
                'seccion_id' => null,
                'padre_id' => 1,
                'madre_id' => 2,
                'representante_legal_id' => 1,
                'tipo_inscripcion' => 'nuevo_ingreso',
                'documentos' => ["partida_nacimiento","copia_cedula_representante","copia_cedula_estudiante","boletin_6to_grado","certificado_calificaciones","constancia_aprobacion_primaria","foto_estudiante","foto_representante","carnet_vacunacion","autorizacion_tercero","notas_certificadas","liberacion_cupo"],
                'estado_documentos' => 'Completo',
                'observaciones' => 'Sin observaciones',
                'acepta_normas_contrato' => true,
                'status' => 'Activo',
            ],

        ];

        // Insertar las inscripciones
        foreach ($inscripciones as $inscripcion) {
            Inscripcion::create($inscripcion);
        }

        $this->command->info(' Inscripciones del año anterior creadas: 10 registros');
    }
}