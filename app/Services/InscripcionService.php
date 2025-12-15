<?php

namespace App\Services;

use App\Models\Inscripcion;
use App\Models\Grado;
use App\Models\Alumno;
use App\Models\Persona;
use App\DTOs\InscripcionData;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InscripcionService
{
        public function __construct(
        private DocumentoService $documentoService
    ) {}

    public function verificarCuposDisponibles($gradoId): bool
    {
        $grado = Grado::find($gradoId);

        if (!$grado) {
            return false;
        }

        $inscripcionesActivas = Inscripcion::where('grado_id', $gradoId)
            ->where('status', 'Activo')
            ->count();

        return $inscripcionesActivas < $grado->capacidad_max;
    }

    public function obtenerInfoCupos($gradoId): ?array
    {
        $grado = Grado::find($gradoId);

        if (!$grado) {
            return null;
        }

        $inscritos = Inscripcion::where('grado_id', $gradoId)
            ->where('status', 'Activo')
            ->count();

        return [
            'total_cupos' => $grado->capacidad_max,
            'cupos_ocupados' => $inscritos,
            'cupos_disponibles' => $grado->capacidad_max - $inscritos,
            'porcentaje_ocupacion' => $grado->capacidad_max > 0
                ? round(($inscritos / $grado->capacidad_max) * 100, 2)
                : 0
        ];
    }

    public function validarAnioEgreso($anioEgreso): bool
    {
        $anio = Carbon::parse($anioEgreso)->year;
        $actual = Carbon::now()->year;

        return $anio <= $actual && $anio >= $actual - 7;
    }

    

    public function registrar(InscripcionData $data): Inscripcion
    {
        DB::beginTransaction();

        try {
            if (!$this->verificarCuposDisponibles($data->grado_id)) {
                throw new \Exception('El grado ha alcanzado el límite de cupos.');
            }

            $evaluacion = $this->documentoService->evaluarEstadoDocumentos(
                $data->documentos,
                !$data->padre_id && !$data->madre_id
            );

            if (!$evaluacion['puede_guardar']) {
                throw new \Exception('Faltan documentos obligatorios.');
            }


            $inscripcion = Inscripcion::create([
                'alumno_id' => $data->alumno_id,
                'numero_zonificacion' => $data->numero_zonificacion,
                'institucion_procedencia_id' => $data->institucion_procedencia_id,
                'anio_egreso' => $data->anio_egreso,
                'expresion_literaria_id' => $data->expresion_literaria_id,
                'grado_id' => $data->grado_id,
                'padre_id' => $data->padre_id,
                'madre_id' => $data->madre_id,
                'representante_legal_id' => $data->representante_legal_id,
                'documentos' => $data->documentos,
                'estado_documentos' => $evaluacion['estado_documentos'],
                'fecha_inscripcion' => $data->fecha_inscripcion,
                'observaciones' => $data->observaciones,
                'acepta_normas_contrato' => $data->acepta_normas_contrato,
                'status' => $evaluacion['status_inscripcion'],
            ]);

            DB::commit();

            return $inscripcion;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function registrarConAlumno(array $datosAlumno, InscripcionData $datosInscripcion): Inscripcion
    {
        DB::beginTransaction();

        try {
            $persona = Persona::create([
                'primer_nombre' => $datosAlumno['primer_nombre'],
                'segundo_nombre' => $datosAlumno['segundo_nombre'] ?? null,
                'tercer_nombre' => $datosAlumno['tercer_nombre'] ?? null,
                'primer_apellido' => $datosAlumno['primer_apellido'],
                'segundo_apellido' => $datosAlumno['segundo_apellido'] ?? null,
                'tipo_documento_id' => $datosAlumno['tipo_documento_id'],
                'numero_documento' => $datosAlumno['numero_documento'],
                'genero_id' => $datosAlumno['genero_id'],
                'fecha_nacimiento' => $datosAlumno['fecha_nacimiento'],
                'localidad_id' => $datosAlumno['localidad_id'],
                'status' => true,
            ]);

            $alumno = Alumno::create([
                'persona_id' => $persona->id,
                'talla_camisa' => $datosAlumno['talla_camisa'],
                'talla_pantalon' => $datosAlumno['talla_pantalon'],
                'talla_zapato' => $datosAlumno['talla_zapato'],
                'peso' => $datosAlumno['peso_estudiante'],
                'estatura' => $datosAlumno['talla_estudiante'],
                'lateralidad_id' => $datosAlumno['lateralidad_id'],
                'orden_nacimiento_id' => $datosAlumno['orden_nacimiento_id'],
                'status' => 'Activo',
            ]);

            $datosInscripcion->alumno_id = $alumno->id;
            $inscripcion = $this->registrar($datosInscripcion);

            DB::commit();

            return $inscripcion;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
