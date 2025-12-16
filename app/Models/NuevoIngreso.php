<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class NuevoIngreso extends Model
{
    use SoftDeletes;

    protected $table = 'nuevo_ingresos';

    protected $fillable = [
        'estudiante_id',
        'representante_id',
        'representante_padre_id',
        'representante_madre_id',
        'representante_legal_id',
        'ano_escolar_id',
        'fecha_inscripcion',
        'grado_academico',
        // 'seccion_academico',
        'documentos_entregados',
        'observaciones',
        'status',
    ];

    // Relaciones
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function representante()
    {
        return $this->belongsTo(Representante::class);
    }

    public function padre()
    {
        return $this->belongsTo(Representante::class, 'representante_padre_id');
    }

    public function madre()
    {
        return $this->belongsTo(Representante::class, 'representante_madre_id');
    }

    public function representanteLegal()
    {
        return $this->belongsTo(RepresentanteLegal::class, 'representante_legal_id');
    }

    public function anoEscolar()
    {
        return $this->belongsTo(AnoEscolar::class, 'ano_escolar_id');
    }




public static function guardarInscripcionCompleta($datosEstudiante, $datosRepresentante, $datosFinal)
{

    Log::info('Estructura datos estudiante:', array_keys($datosEstudiante));
    Log::info('Estructura datos representante:', array_keys($datosRepresentante));
    Log::info('Estructura datos final:', array_keys($datosFinal));

    try {
        DB::beginTransaction();

        // verifiquemos que ya existe una persona con esa cédula (estudiante)
        $personaEstudianteExistente = DB::table('personas')
            ->where('tipo_documento_id', $datosEstudiante['tipo_documento_id'])
            ->where('numero_documento', $datosEstudiante['numero_documento'])
            ->first();

        if ($personaEstudianteExistente) {
            // Actualizar persona existente
            DB::table('personas')
                ->where('id', $personaEstudianteExistente->id)
                ->update([
                    'fecha_nacimiento_personas' => $datosEstudiante['fecha_nacimiento_personas'],
                    'primer_nombre' => $datosEstudiante['primer_nombre'],
                    'segundo_nombre' => $datosEstudiante['segundo_nombre'] ?? null,
                    'tercer_nombre' => $datosEstudiante['tercer_nombre'] ?? null,
                    'primer_apellido' => $datosEstudiante['primer_apellido'],
                    'segundo_apellido' => $datosEstudiante['segundo_apellido'] ?? null,
                    'genero_id' => $datosEstudiante['genero_id'],
                    // 'direccion_persona' => $datosEstudiante['direccion_persona'],
                    'updated_at' => now(),
                ]);
            $personaEstudianteId = $personaEstudianteExistente->id;
        } else {
            // Crear nueva persona del estudiante
            $personaEstudianteId = DB::table('personas')->insertGetId([
                'tipo_documento_id' => $datosEstudiante['tipo_documento_id'],
                'numero_documento' => $datosEstudiante['numero_documento'],
                'fecha_nacimiento' => $datosEstudiante['fecha_nacimiento'],
                'primer_nombre' => $datosEstudiante['primer_nombre'],
                'segundo_nombre' => $datosEstudiante['segundo_nombre'] ?? null,
                'tercer_nombre' => $datosEstudiante['tercer_nombre'] ?? null,
                'primer_apellido' => $datosEstudiante['primer_apellido'],
                'segundo_apellido' => $datosEstudiante['segundo_apellido'] ?? null,
                'genero_id' => $datosEstudiante['genero_id'],
                // 'direccion_persona' => $datosEstudiante['direccion_persona'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //  verifiquemos que ya existe un estudiante para esta persona
        $estudianteExistente = DB::table('estudiantes')
            ->where('persona_id', $personaEstudianteId)
            ->first();

        // Datos básicos del estudiante
        $datosEstudianteDB = [
            'persona_id' => $personaEstudianteId,
            'institucion_id' => $datosEstudiante['institucion_id'],
            'orden_nacimiento_estudiante' => $datosEstudiante['orden_nacimiento_estudiante'],
            'talla_camisa' => $datosEstudiante['talla_camisa'],
            'talla_pantalon' => $datosEstudiante['talla_pantalon'],
            'talla_zapato' => $datosEstudiante['talla_zapato'],
            'talla_estudiante' => $datosEstudiante['talla_estudiante'],
            'peso_estudiante' => $datosEstudiante['peso_estudiante'],
            'numero_zonificacion_plantel' => $datosEstudiante['numero_zonificacion_plantel'] ?? null,
            'ano_ergreso_estudiante' => $datosEstudiante['ano_ergreso_estudiante'],
            'expresion_literaria' => $datosEstudiante['expresion_literaria'],
            'lateralidad_estudiante' => $datosEstudiante['lateralidad_estudiante'],
            'documentos_estudiante' => $datosEstudiante['documento_estudiante'] ?? null,
            'status' => 'En Espera',
            'updated_at' => now(),
        ];



        if ($estudianteExistente) {
            DB::table('estudiantes')
                ->where('id', $estudianteExistente->id)
                ->update($datosEstudianteDB);
            $estudianteId = $estudianteExistente->id;
        } else {
            $datosEstudianteDB['created_at'] = now();
            $estudianteId = DB::table('estudiantes')->insertGetId($datosEstudianteDB);
        }

        //  Verificamos que ya existe una persona con esa cédula (representante)
        $personaRepresentanteExistente = DB::table('personas')
            ->where('tipo_documento_id', $datosRepresentante['tipo_documento_id'])
            ->where('numero_documento', $datosRepresentante['numero_documento'])
            ->first();

        if ($personaRepresentanteExistente) {
            // Actualizar persona existente
            DB::table('personas')
                ->where('id', $personaRepresentanteExistente->id)
                ->update([
                    'fecha_nacimiento_personas' => $datosRepresentante['fecha_nacimiento_personas'],
                    'primer_nombre' => $datosRepresentante['primer_nombre'],
                    'segundo_nombre' => $datosRepresentante['segundo_nombre'] ?? null,
                    'tercer_nombre' => $datosRepresentante['tercer_nombre'] ?? null,
                    'primer_apellido' => $datosRepresentante['primer_apellido'],
                    'segundo_apellido' => $datosRepresentante['segundo_apellido'] ?? null,
                    'genero_id' => $datosRepresentante['genero_id'],
                    // 'lugar_nacimiento_persona' => $datosRepresentante['lugar_nacimiento_persona'],
                    // 'prefijo_telefono_personas' => $datosRepresentante['prefijo_telefono_personas'],
                    'telefono' => $datosRepresentante['telefono'],
                    'updated_at' => now(),
                ]);
            $personaRepresentanteId = $personaRepresentanteExistente->id;
        } else {
            // Crear nueva persona del representante
            $personaRepresentanteId = DB::table('personas')->insertGetId([
                'tipo_documento_id' => $datosRepresentante['tipo_documento_id'],
                'numero_documento' => $datosRepresentante['numero_documento'],
                'fecha_nacimiento' => $datosRepresentante['fecha_nacimiento'],
                'primer_nombre' => $datosRepresentante['primer_nombre'],
                'segundo_nombre' => $datosRepresentante['segundo_nombre'] ?? null,
                'tercer_nombre' => $datosRepresentante['tercer_nombre'] ?? null,
                'primer_apellido' => $datosRepresentante['primer_apellido'],
                'segundo_apellido' => $datosRepresentante['segundo_apellido'] ?? null,
                'genero_id' => $datosRepresentante['genero_id'],
                // 'lugar_nacimiento_persona' => $datosRepresentante['lugar_nacimiento_persona'],
                // 'prefijo_telefono_personas' => $datosRepresentante['prefijo_telefono_personas'],
                'telefono' => $datosRepresentante['telefono'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //  verificamos que  ya existe un representante para esta persona
        $representanteExistente = DB::table('representantes')
            ->where('persona_id', $personaRepresentanteId)
            ->first();

        if ($representanteExistente) {
            // Actualizar representante existente
            DB::table('representantes')
                ->where('id', $representanteExistente->id)
                ->update([
                    'ocupacion_representante' => $datosRepresentante['ocupacion_representante'],
                    'convivenciaestudiante_representante' => $datosRepresentante['convivenciaestudiante_representante'],
                    'updated_at' => now(),
                ]);
            $representanteId = $representanteExistente->id;
        } else {
            // Crear nuevo representante
            $representanteId = DB::table('representantes')->insertGetId([
                'persona_id' => $personaRepresentanteId,
                'ocupacion_representante' => $datosRepresentante['ocupacion_representante'],
                'convivenciaestudiante_representante' => $datosRepresentante['convivenciaestudiante_representante'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Log::info('Persona estudiante procesada:', ['id' => $personaEstudianteId]);
        Log::info('Estudiante procesado:', ['id' => $estudianteId ?? 'nuevo']);
        Log::info('Persona representante procesada:', ['id' => $personaRepresentanteId]);
        Log::info('Representante procesado:', ['id' => $representanteId ?? 'nuevo']);

        //  Crear nuevo registro de ingreso
        Log::info('Creando registro de nuevo ingreso...');
        $nuevoIngresoId = DB::table('nuevo_ingresos')->insertGetId([
            'estudiante_id' => $estudianteId,
            'representante_id' => $representanteId,
            'ano_escolar_id' => $datosFinal['ano_escolar'],
            'fecha_inscripcion' => $datosFinal['fecha_inscripcion'],
            'grado_academico' => $datosFinal['grado_academico'],
            // 'seccion_academico' => $datosFinal['seccion_academico'],
            'documentos_entregados' => json_encode($datosFinal['documentos']),
            'observaciones' => $datosFinal['observaciones'] ?? null,
            'status' => 'pendiente',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Log::info('Nuevo ingreso creado:', ['id' => $nuevoIngresoId]);

        DB::commit();

        return [true, 'Inscripción de nuevo ingreso completada exitosamente', $nuevoIngresoId];

    } catch (Exception $e) {
        DB::rollBack();
        Log::error('Error en guardarInscripcionCompleta: ' . $e->getMessage());
        Log::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());

        return [false, 'Error al completar la inscripción: ' . $e->getMessage()];
    }
}

public static function obtenerDatosInscripcion($buscar = null)
{
    $query = DB::table('nuevo_ingresos')
        ->select(
            'nuevo_ingresos.*',
            'estudiantes.id as estudiante_id',
            'estudiantes.institucion_id',
            'estudiantes.orden_nacimiento_estudiante',
            'estudiantes.talla_camisa',
            'estudiantes.talla_pantalon',
            'estudiantes.talla_zapato',
            'estudiantes.talla_estudiante',
            'estudiantes.peso_estudiante',
            'estudiantes.numero_zonificacion_plantel',
            'estudiantes.ano_ergreso_estudiante',
            'estudiantes.expresion_literaria',
            'estudiantes.lateralidad_estudiante',
            'estudiantes.documentos_estudiante',
            'estudiantes.status as estudiante_status',
            'estudiantes.created_at as estudiante_created_at',
            'estudiantes.updated_at as estudiante_updated_at',
            'estudiante_persona.id as estudiante_persona_id',
            'estudiante_persona.tipo_documento_id as estudiante_tipo_numero_documento',
            'estudiante_persona.numero_documento as estudiante_numero_documento',
            'estudiante_persona.fecha_nacimiento as estudiante_fecha_nacimiento',
            'estudiante_persona.primer_nombre as estudiante_nombre1',
            'estudiante_persona.segundo_nombre as estudiante_nombre2',
            'estudiante_persona.tercer_nombre as estudiante_nombre3',
            'estudiante_persona.primer_apellido as estudiante_apellido1',
            'estudiante_persona.segundo_apellido as estudiante_apellido2',
            'estudiante_persona.genero_id as estudiante_sexo',
            // 'estudiante_persona.direccion_persona as estudiante_direccion',
            // 'estudiante_persona.lugar_nacimiento_persona as estudiante_lugar_nacimiento',
            // 'estudiante_persona.prefijo_telefono_personas as estudiante_prefijo_telefono',
            'estudiante_persona.telefono as estudiante_telefono',
            'estudiante_persona.created_at as estudiante_persona_created_at',
            'estudiante_persona.updated_at as estudiante_persona_updated_at',
            'representantes.id as representante_id',
            'representantes.ocupacion_representante',
            'representantes.convivenciaestudiante_representante',
            'representantes.created_at as representante_created_at',
            'representantes.updated_at as representante_updated_at',
            'representante_persona.id as representante_persona_id',
            'representante_persona.tipo_documento_id as representante_tipo_numero_documento',
            'representante_persona.numero_documento as representante_numero_documento',
            'representante_persona.fecha_nacimiento as representante_fecha_nacimiento',
            'representante_persona.primer_nombre as representante_nombre1',
            'representante_persona.segundo_nombre as representante_nombre2',
            'representante_persona.tercer_nombre as representante_nombre3',
            'representante_persona.primer_apellido as representante_apellido1',
            'representante_persona.segundo_apellido as representante_apellido2',
            'representante_persona.genero_id as representante_sexo',
            // 'representante_persona.lugar_nacimiento_persona as representante_lugar_nacimiento',
            // 'representante_persona.prefijo_telefono_personas as representante_prefijo_telefono',
            'representante_persona.telefono as representante_telefono',
            'representante_persona.created_at as representante_persona_created_at',
            'representante_persona.updated_at as representante_persona_updated_at',

            'anio_escolars.id as ano_escolar_id',

            'anio_escolars.inicio_anio_escolar',
            'anio_escolars.cierre_anio_escolar',
            'anio_escolars.status as status'
        )
        ->leftJoin('estudiantes', 'nuevo_ingresos.estudiante_id', '=', 'estudiantes.id')
        ->leftJoin('personas as estudiante_persona', 'estudiantes.persona_id', '=', 'estudiante_persona.id')
        ->leftJoin('representantes', 'nuevo_ingresos.representante_id', '=', 'representantes.id')
        ->leftJoin('personas as representante_persona', 'representantes.persona_id', '=', 'representante_persona.id')
        ->leftJoin('anio_escolars', 'nuevo_ingresos.ano_escolar_id', '=', 'anio_escolars.id');

    if ($buscar) {
        $query->where(function($q) use ($buscar) {
            $q->where('estudiante_persona.primer_nombre', 'LIKE', "%{$buscar}%")
              ->orWhere('estudiante_persona.segundo_nombre', 'LIKE', "%{$buscar}%")
              ->orWhere('estudiante_persona.tercer_nombre', 'LIKE', "%{$buscar}%")
              ->orWhere('estudiante_persona.primer_apellido', 'LIKE', "%{$buscar}%")
              ->orWhere('estudiante_persona.segundo_apellido', 'LIKE', "%{$buscar}%")
              ->orWhere('estudiante_persona.numero_documento', 'LIKE', "%{$buscar}%");
        });
    }

    return $query->orderBy('nuevo_ingresos.created_at', 'desc')->get();
}


// Actualizar una inscripción existente-----------------------------------------------------------------------------------------
 public static function actualizarInscripcion($id, $datosEstudiante, $datosRepresentante, $datosInscripcion)
    {
        Log::info('Actualizando inscripción ID: ' . $id);
        Log::info('Datos estudiante:', $datosEstudiante);
        Log::info('Datos representante:', $datosRepresentante);
        Log::info('Datos inscripción:', $datosInscripcion);

        try {
            DB::beginTransaction();

            // Obtener registro de nuevo ingreso
            $nuevoIngreso = DB::table('nuevo_ingresos')->where('id', $id)->first();
            if (!$nuevoIngreso) {
                throw new \Exception('Inscripción no encontrada.');
            }

            // Actualizar persona del estudiante
            DB::table('personas')
                ->where('id', function($query) use ($nuevoIngreso) {
                    $query->select('persona_id')
                          ->from('estudiantes')
                          ->where('id', $nuevoIngreso->estudiante_id);
                })
                ->update([
                    'tipo_documento_id' => $datosEstudiante['tipo_documento_id'],
                    'numero_documento' => $datosEstudiante['numero_documento'],
                    'fecha_nacimiento' => $datosEstudiante['fecha_nacimiento'],
                    'primer_nombre' => $datosEstudiante['primer_nombre'],
                    'segundo_nombre' => $datosEstudiante['segundo_nombre'] ?? null,
                    'tercer_nombre' => $datosEstudiante['tercer_nombre'] ?? null,
                    'primer_apellido' => $datosEstudiante['primer_apellido'],
                    'segundo_apellido' => $datosEstudiante['segundo_apellido'] ?? null,
                    'genero_id' => $datosEstudiante['genero_id'],
                    // 'direccion_persona' => $datosEstudiante['direccion_persona'],
                    'updated_at' => now(),
                ]);

            // Actualizar estudiante
            $datosEstudianteDB = [
                'institucion_id' => $datosEstudiante['institucion_id'],
                'orden_nacimiento_estudiante' => $datosEstudiante['orden_nacimiento_estudiante'],
                'talla_camisa' => $datosEstudiante['talla_camisa'],
                'talla_pantalon' => $datosEstudiante['talla_pantalon'],
                'talla_zapato' => $datosEstudiante['talla_zapato'],
                'talla_estudiante' => $datosEstudiante['talla_estudiante'],
                'peso_estudiante' => $datosEstudiante['peso_estudiante'],
                'numero_zonificacion_plantel' => $datosEstudiante['numero_zonificacion_plantel'] ?? null,
                'ano_ergreso_estudiante' => $datosEstudiante['ano_ergreso_estudiante'],
                'expresion_literaria' => $datosEstudiante['expresion_literaria'],
                'lateralidad_estudiante' => $datosEstudiante['lateralidad_estudiante'],
                'updated_at' => now(),
            ];

            // Agregar campos opcionales si existen
            if (isset($datosEstudiante['cual_pueblo_indigna'])) {
                $datosEstudianteDB['cual_pueblo_indigna'] = $datosEstudiante['cual_pueblo_indigna'];
            }

            if (isset($datosEstudiante['discapacidad_estudiante'])) {
                $datosEstudianteDB['discapacidad_estudiante'] = $datosEstudiante['discapacidad_estudiante'];
            }

            DB::table('estudiantes')
                ->where('id', $nuevoIngreso->estudiante_id)
                ->update($datosEstudianteDB);

            // Actualizar persona del representante
            DB::table('personas')
                ->where('id', function($query) use ($nuevoIngreso) {
                    $query->select('persona_id')
                          ->from('representantes')
                          ->where('id', $nuevoIngreso->representante_id);
                })
                ->update([
                    'tipo_documento_id' => $datosRepresentante['rep_tipo_documento_id'],
                    'numero_documento' => $datosRepresentante['rep_numero_documento'],
                    'fecha_nacimiento' => $datosRepresentante['rep_fecha_nacimiento'],
                    'primer_nombre' => $datosRepresentante['rep_primer_nombre'],
                    'segundo_nombre' => $datosRepresentante['rep_segundo_nombre'] ?? null,
                    'tercer_nombre' => $datosRepresentante['rep_tercer_nombre'] ?? null,
                    'primer_apellido' => $datosRepresentante['rep_primer_apellido'],
                    'segundo_apellido' => $datosRepresentante['rep_segundo_apellido'] ?? null,
                    'genero_id' => $datosRepresentante['rep_genero_id'],
                    // 'lugar_nacimiento_persona' => $datosRepresentante['rep_lugar_nacimiento_persona'],
                    // 'prefijo_telefono_personas' => $datosRepresentante['rep_prefijo_telefono_personas'],
                    'telefono' => $datosRepresentante['telefono'],
                    'updated_at' => now(),
                ]);

            // Actualizar representante
            DB::table('representantes')
                ->where('id', $nuevoIngreso->representante_id)
                ->update([
                    'ocupacion_representante' => $datosRepresentante['rep_ocupacion_representante'],
                    'convivenciaestudiante_representante' => $datosRepresentante['rep_convivenciaestudiante_representante'],
                    'updated_at' => now(),
                ]);

            // Actualizar nuevo ingreso
            DB::table('nuevo_ingresos')
                ->where('id', $id)
                ->update([
                    'ano_escolar_id' => $datosInscripcion['ano_escolar_id'],
                    'fecha_inscripcion' => $datosInscripcion['fecha_inscripcion'],
                    'grado_academico' => $datosInscripcion['grado_academico'],
                    // 'seccion_academico' => $datosInscripcion['seccion_academico'],
                    // por que es un array lo convertimos a json
                    'documentos_entregados' => json_encode($datosInscripcion['documentos']),
                    'observaciones' => $datosInscripcion['observaciones'] ?? null,
                    'status' => $datosInscripcion['status'],
                    'updated_at' => now(),
                ]);

            DB::commit();

            Log::info('Inscripción actualizada exitosamente: ' . $id);

            return [
                'success' => true,
                'message' => 'Inscripción actualizada correctamente.'
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar inscripción: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Eliminar una inscripción
     */
    public static function eliminarInscripcion($id)
    {
        try {
            DB::beginTransaction();

            // Obtener el registro de nuevo ingreso
            $nuevoIngreso = DB::table('nuevo_ingresos')->where('id', $id)->first();

            if (!$nuevoIngreso) {
                return [
                    'success' => false,
                    'message' => 'Inscripción no encontrada.'
                ];
            }

            // Obtener IDs relacionados
            $estudianteId = $nuevoIngreso->estudiante_id;
            $representanteId = $nuevoIngreso->representante_id;

            // Obtener persona_ids
            $estudiante = DB::table('estudiantes')->where('id', $estudianteId)->first();
            $representante = DB::table('representantes')->where('id', $representanteId)->first();

            if (!$estudiante || !$representante) {
                throw new \Exception('Datos relacionados no encontrados.');
            }

            $personaEstudianteId = $estudiante->persona_id;
            $personaRepresentanteId = $representante->persona_id;

            // Eliminar nuevo ingreso
            DB::table('nuevo_ingresos')->where('id', $id)->delete();

            // Eliminar estudiante
            DB::table('estudiantes')->where('id', $estudianteId)->delete();

            // Eliminar representante
            DB::table('representantes')->where('id', $representanteId)->delete();

            // Eliminar personas (solo si no están siendo usadas en otros registros)
            $estudianteEnOtros = DB::table('estudiantes')->where('persona_id', $personaEstudianteId)->exists();
            $representanteEnOtros = DB::table('representantes')->where('persona_id', $personaRepresentanteId)->exists();

            if (!$estudianteEnOtros) {
                DB::table('personas')->where('id', $personaEstudianteId)->delete();
            }

            if (!$representanteEnOtros) {
                DB::table('personas')->where('id', $personaRepresentanteId)->delete();
            }

            DB::commit();

            Log::info('Inscripción eliminada exitosamente: ' . $id);

            return [
                'success' => true,
                'message' => 'Inscripción eliminada correctamente.'
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar inscripción: ' . $e->getMessage());
            throw $e;
        }
    }
}
