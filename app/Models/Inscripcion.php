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
        'numero_zonificacion',
        'institucion_procedencia_id',
        'expresion_literaria_id',
        'anio_egreso',
        'acepta_normas_contrato',
        'status',
    ];

    protected $casts = [
        'documentos' => 'array',
        'fecha_inscripcion' => 'date',
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
}
