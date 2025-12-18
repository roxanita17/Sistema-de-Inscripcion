<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Models\EntradasPercentil;
use App\Models\Seccion;
use App\Models\AnioEscolar;

class Inscripcion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inscripcions';

    protected $fillable = [
        'anio_escolar_id',
        'alumno_id',
        'grado_id',
        'seccion_id',
        'padre_id',
        'madre_id',
        'representante_legal_id',
        'documentos',
        'estado_documentos',
        'observaciones',
        'numero_zonificacion',
        'institucion_procedencia_id',
        'expresion_literaria_id',
        'anio_egreso',
        'acepta_normas_contrato',
        'status',
    ];

    protected $casts = [
        'documentos' => 'array',
        'status' => 'string',
    ];

    public function expresionLiteraria()
    {
        return $this->belongsTo(ExpresionLiteraria::class, 'expresion_literaria_id', 'id');
    }

    public function institucionProcedencia()
    {
        return $this->belongsTo(InstitucionProcedencia::class, 'institucion_procedencia_id', 'id');
    }

    /**
     * Relación con EntradasPercentil
     */
    public function entradaPercentil()
    {
        return $this->hasOne(EntradasPercentil::class, 'inscripcion_id');
    }

    public function seccion()
    {
        return $this->hasOne(Seccion::class, 'id', 'seccion_id');
    }

    /**
     * Relación con Sección a través de EntradasPercentil
     */
    public function seccionAsignada()
    {
        return $this->hasOneThrough(
            Seccion::class,
            EntradasPercentil::class,
            'inscripcion_id', // Foreign key on EntradasPercentil table
            'id', // Foreign key on Seccion table
            'id', // Local key on Inscripcion table
            'seccion_id' // Local key on EntradasPercentil table
        );
    }
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

    public function anioEscolar()
    {
        return $this->belongsTo(AnioEscolar::class, 'anio_escolar_id', 'id');
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
     * Scope: Inscripciones del año escolar activo o extendido
     */
    public function scopeAnioEscolarVigente($query)
    {
        return $query->whereHas('anioEscolar', function ($q) {
            $q->whereIn('status', ['Activo', 'Extendido']);
        });
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

    /**
     * Obtiene todos los datos relacionados con la inscripción incluyendo alumno, representantes, etc.
     * 
     * @return array
     */
    public function obtenerDatosCompletos()
    {
        // Cargar todas las relaciones necesarias
        $this->load([
            'alumno.persona',
            'alumno.ordenNacimiento',
            'alumno.discapacidad',
            'alumno.etniaIndigena',
            'alumno.lateralidad',
            'grado',
            'seccion',
            'padre.persona',
            'madre.persona',
            'representanteLegal.representante.persona',
            'representanteLegal.banco',
            'institucionProcedencia',
            'expresionLiteraria',
            'seccionAsignada'
        ]);

        // Construir el array con todos los datos
        $datos = [
            'inscripcion' => $this->toArray(),
            'alumno' => $this->alumno ? $this->alumno->toArray() : null,
            'persona_alumno' => $this->alumno && $this->alumno->persona ? $this->alumno->persona->toArray() : null,
            'grado' => $this->grado ? $this->grado->toArray() : null,
            'seccion' => $this->seccion ? $this->seccion->toArray() : null,
            'padre' => $this->padre ? $this->padre->toArray() : null,
            'persona_padre' => $this->padre && $this->padre->persona ? $this->padre->persona->toArray() : null,
            'madre' => $this->madre ? $this->madre->toArray() : null,
            'persona_madre' => $this->madre && $this->madre->persona ? $this->madre->persona->toArray() : null,
            'representante_legal' => $this->representanteLegal ? $this->representanteLegal->toArray() : null,
            'persona_representante_legal' => $this->representanteLegal && $this->representanteLegal->persona ? $this->representanteLegal->persona->toArray() : null,
            'institucion_procedencia' => $this->institucionProcedencia ? $this->institucionProcedencia->toArray() : null,
            'expresion_literaria' => $this->expresionLiteraria ? $this->expresionLiteraria->toArray() : null,
            'seccion_asignada' => $this->seccionAsignada ? $this->seccionAsignada->toArray() : null,
            'datos_adicionales' => [
                'orden_nacimiento' => $this->alumno && $this->alumno->ordenNacimiento ? $this->alumno->ordenNacimiento->toArray() : null,
                'discapacidad' => $this->alumno && $this->alumno->discapacidad ? $this->alumno->discapacidad->toArray() : null,
                'etnia_indigena' => $this->alumno && $this->alumno->etniaIndigena ? $this->alumno->etniaIndigena->toArray() : null,
                'lateralidad' => $this->alumno && $this->alumno->lateralidad ? $this->alumno->lateralidad->toArray() : null,
            ]
        ];

        return $datos;
    }

    public static function inactivar($id)
    {
        return DB::transaction(function () use ($id) {

            $inscripcion = Inscripcion::with('alumno')->findOrFail($id);

            // Inactivar la inscripción
            $inscripcion->update([
                'status' => 'Inactivo',
            ]);

            // Inactivar el alumno relacionado
            if ($inscripcion->alumno) {
                $inscripcion->alumno->update([
                    'status' => false,
                ]);
            }

            return true;
        });
    }
}
