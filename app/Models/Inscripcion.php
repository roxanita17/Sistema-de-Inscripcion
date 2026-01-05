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
        'acepta_normas_contrato',
        'status',
    ];

    protected $casts = [
        'documentos' => 'array',
        'status' => 'string',
    ];

    public function nuevoIngreso()
    {
        return $this->hasOne(
            InscripcionNuevoIngreso::class,
            'inscripcion_id'
        );
    }

    // App\Models\Inscripcion.php
    public function prosecucion()
    {
        return $this->hasOne(
            \App\Models\InscripcionProsecucion::class,
            'inscripcion_id'
        );
    }


    public function getTipoInscripcionAttribute()
    {
        if ($this->nuevoIngreso) {
            return 'nuevo_ingreso';
        }

        if ($this->prosecucion) {
            return 'prosecucion';
        }

        return null;
    }

    public function getGradoActualAttribute()
    {
        if ($this->nuevoIngreso) {
            return $this->grado;
        }

        if ($this->prosecucion) {
            return $this->prosecucion->grado;
        }

        return null;
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
        return $this->belongsTo(Seccion::class,  'seccion_id', 'id');
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
     * Scope: Inscripciones del año escolar o extendido
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
        $alumno = $this->alumno;

        return [
            'inscripcion' => $this->toArray(),
            'nuevo_ingreso' => $this->nuevoIngreso?->toArray(),
            'persona_alumno' => $alumno?->persona?->toArray(),
            'alumno' => $alumno?->toArray(),
            'datos_adicionales' => [
                'lateralidad' => $alumno?->lateralidad?->toArray(),

                'orden_nacimiento' => $alumno?->ordenNacimiento?->toArray(),

                'discapacidades' => $this->alumno
                    ?->discapacidades
                    ?->map(fn($d) => [
                        'id' => $d->id,
                        'nombre_discapacidad' => $d->nombre_discapacidad,
                    ])
                    ->toArray() ?? [],

                'etnia_indigena' => $alumno?->etniaIndigena?->toArray(),
            ],

            'persona_madre' => $this->madre?->persona?->toArray(),
            'madre' => $this->madre?->toArray(),

            'persona_padre' => $this->padre?->persona?->toArray(),
            'padre' => $this->padre?->toArray(),

            'representante_legal' => $this->representanteLegal?->load([
                'representante.persona',
                'banco'
            ])?->toArray(),

            'institucion_procedencia' => $this->nuevoIngreso?->institucionProcedencia?->toArray(),

            'expresion_literaria' => $this->nuevoIngreso?->expresionLiteraria?->toArray(),

            'grado' => $this->grado?->toArray(),
            'seccion' => $this->seccionAsignada?->toArray(),

        ];
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

    public static function restaurar($id)
    {
        return DB::transaction(function () use ($id) {

            $inscripcion = Inscripcion::with('alumno')->findOrFail($id);

            // Restaurar la inscripción
            $inscripcion->update([
                'status' => 'Activo',
            ]);

            // Restaurar el alumno relacionado
            if ($inscripcion->alumno) {
                $inscripcion->alumno->update([
                    'status' => true,
                ]);
            }

            return true;
        });
    }
}
