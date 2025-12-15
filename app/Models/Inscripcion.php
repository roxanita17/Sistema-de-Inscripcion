<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Inscripcion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inscripcions';

    protected $fillable = [
        'alumno_id',
        'grado_id',
        'padre_id',
        'madre_id',
        'representante_legal_id',
        'fecha_inscripcion',
        'documentos',
        'estado_documentos',
        'observaciones',
        'status',
    ];

    protected $casts = [
        'documentos' => 'array',
        'fecha_inscripcion' => 'date',
        'status' => 'string',
    ];

    /**
     * Relación con Alumno
     */
    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id', 'id');
    }

    /**
     * Relación con Grado
     */
    public function grado()
    {
        return $this->belongsTo(Grado::class, 'grado_id', 'id');
    }

    /**
     * Relación con Padre (Representante)
     */
    public function padre()
    {
        return $this->belongsTo(Representante::class, 'padre_id', 'id');
    }

    /**
     * Relación con Madre (Representante)
     */
    public function madre()
    {
        return $this->belongsTo(Representante::class, 'madre_id', 'id');
    }

    /**
     * Relación con Representante Legal
     */
    public function representanteLegal()
    {
        return $this->belongsTo(RepresentanteLegal::class, 'representante_legal_id', 'id');
    }

    /**
     * Obtener todos los representantes de la inscripción
     */
    public function representantes()
    {
        $representantes = collect();
        
        if ($this->padre) {
            $representantes->push([
                'tipo' => 'Padre',
                'representante' => $this->padre
            ]);
        }
        
        if ($this->madre) {
            $representantes->push([
                'tipo' => 'Madre',
                'representante' => $this->madre
            ]);
        }
        
        if ($this->representanteLegal) {
            $representantes->push([
                'tipo' => 'Representante Legal',
                'representante' => $this->representanteLegal
            ]);
        }
        
        return $representantes;
    }

    /**
     * Scope para buscar inscripciones
     */
    public function scopeBuscar($query, $buscar)
    {
        if (!empty($buscar)) {
            $query->whereHas('alumno.persona', function ($q) use ($buscar) {
                $q->where('primer_nombre', 'LIKE', "%{$buscar}%")
                  ->orWhere('primer_apellido', 'LIKE', "%{$buscar}%")
                  ->orWhere('numero_documento', 'LIKE', "%{$buscar}%");
            });
        }

        return $query;
    }

    /**
     * Scope para inscripciones activas
     */
    public function scopeActivas($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope para inscripciones por grado
     */
    public function scopePorGrado($query, $gradoId)
    {
        return $query->where('grado_id', $gradoId);
    }

    /**
     * Scope para inscripciones del año actual
     */
    public function scopeAnioActual($query)
    {
        return $query->whereYear('fecha_inscripcion', now()->year);
    }


    /**
     * Obtener representante principal (primero disponible)
     */
    public function getRepresentantePrincipalAttribute()
    {
        return $this->padre ?? $this->madre ?? $this->representanteLegal;
    }

    public static function eliminar($id)
    {
        return DB::table('inscripcions')
            ->where('id', $id)
            ->update([
                'status' => 'Inactivo',
                'updated_at' => now()
            ]);
    }

    /*
    * Obtener datos para reporte de inscripciones
    */
    /*public static function obtenerDatosInscripcion()
{
    $query = DB::table('inscripcions')
        ->select(
            'inscripcions.*',
            'alumnos.id as estudiante_id',
            'alumnos.institucion_id',
            'alumnos.orden_nacimiento_estudiante',
            'alumnos.talla_camisa',
            'alumnos.talla_pantalon',
            'alumnos.talla_zapato',
            'alumnos.talla_estudiante',
            'alumnos.peso_estudiante',
            'alumnos.numero_zonificacion_plantel',
            'alumnos.ano_ergreso_estudiante',
            'alumnos.expresion_literaria',
            'alumnos.lateralidad_estudiante',
            'alumnos.documentos_estudiante',
            'alumnos.status as estudiante_status',
            'alumnos.created_at as estudiante_created_at',
            'alumnos.updated_at as estudiante_updated_at',
            'alumnos.id as estudiante_persona_id',
            'alumnos_persona.tipo_documento_id as estudiante_tipo_numero_documento',
            'alumnos_persona.numero_documento as estudiante_numero_documento',
            'alumnos_persona.fecha_nacimiento as estudiante_fecha_nacimiento',
            'alumnos_persona.primer_nombre as estudiante_nombre1',
            'alumnos_persona.segundo_nombre as estudiante_nombre2',
            'alumnos_persona.tercer_nombre as estudiante_nombre3',
            'alumnos_persona.primer_apellido as estudiante_apellido1',
            'alumnos_persona.segundo_apellido as estudiante_apellido2',
            'alumnos_persona.genero_id as estudiante_sexo',
            'alumnos_persona.telefono as estudiante_telefono',
            'alumnos_persona.created_at as estudiante_persona_created_at',
            'alumnos_persona.updated_at as estudiante_persona_updated_at',
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

            'representante_persona.telefono as representante_telefono',
            'representante_persona.created_at as representante_persona_created_at',
            'representante_persona.updated_at as representante_persona_updated_at',

            'anio_escolars.id as ano_escolar_id',

            'anio_escolars.inicio_anio_escolar',
            'anio_escolars.cierre_anio_escolar',
            'anio_escolars.status as status'
        )
        ->leftJoin('alumnos', 'nuevo_ingresos.estudiante_id', '=', 'alumnos.id')
        ->leftJoin('personas as estudiante_persona', 'alumnos.persona_id', '=', 'estudiante_persona.id')
        ->leftJoin('representantes', 'nuevo_ingresos.representante_id', '=', 'representantes.id')
        ->leftJoin('personas as representante_persona', 'representantes.persona_id', '=', 'representante_persona.id')
        ->leftJoin('anio_escolars', 'nuevo_ingresos.ano_escolar_id', '=', 'anio_escolars.id');

    return $query->orderBy('nuevo_ingresos.created_at', 'desc')->get();
}*/
}