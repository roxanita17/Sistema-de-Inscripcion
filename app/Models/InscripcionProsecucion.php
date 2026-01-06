<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscripcionProsecucion extends Model
{
    use HasFactory;

    protected $table = 'inscripcion_prosecucions';

    protected $fillable = [
        'inscripcion_id',
        'anio_escolar_id',
        'grado_id',
        'seccion_id',
        'promovido',
        'repite_grado',
        'observaciones',
        'acepta_normas_contrato',
        'status',
    ];

    protected $casts = [
        'promovido' => 'boolean',
        'repite_grado' => 'boolean',
    ];

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class, 'inscripcion_id', 'id');
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class, 'grado_id', 'id');
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'seccion_id', 'id');
    }

    public function anioEscolar()
    {
        return $this->belongsTo(AnioEscolar::class, 'anio_escolar_id', 'id');
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function prosecucionAreas()
    {
        return $this->hasMany(
            ProsecucionArea::class,
            'inscripcion_prosecucion_id'
        );
    }

    public function getGradoInscritoAttribute()
    {
        return $this->grado;
    }

    public function representantes()
    {
        return $this->hasMany(Representante::class);
    }


    public static function inactivar($prosecucionId)
    {
        return DB::transaction(function () use ($prosecucionId) {

            $prosecucion = self::with('inscripcion.alumno')
                ->findOrFail($prosecucionId);

            $prosecucion->update([
                'status' => 'Inactivo',
            ]);

            if ($prosecucion->inscripcion?->alumno) {
                $prosecucion->inscripcion->alumno->update([
                    'status' => false,
                ]);
            }

            return true;
        });
    }


    public static function restaurar($prosecucionId)
    {
        return DB::transaction(function () use ($prosecucionId) {

            $prosecucion = self::with('inscripcion.alumno')
                ->findOrFail($prosecucionId);

            $prosecucion->update([
                'status' => 'Activo',
            ]);

            if ($prosecucion->inscripcion?->alumno) {
                $prosecucion->inscripcion->alumno->update([
                    'status' => true,
                ]);
            }

            return true;
        });
    }

        public static function reporteGeneralPDF(array $filtros = [])
    {
        $anioEscolarId = $filtros['anio_escolar_id'] ?? null;
        $gradoId = $filtros['grado_id'] ?? null;
        $seccionId = $filtros['seccion_id'] ?? null;
        $estatusInscripcion = $filtros['status'] ?? null;
        $buscar = $filtros['buscar'] ?? null;

        return self::query()
            ->with([
                'inscripcion.alumno.persona.tipoDocumento',
                'inscripcion.alumno.persona.genero',
                'inscripcion.alumno.discapacidades',
                'inscripcion.alumno.etniaIndigena',
                'inscripcion.grado',
                'inscripcion.seccionAsignada',
                'inscripcion.representanteLegal.representante.persona',
                'grado',
                'seccion',
                'anioEscolar',
                'prosecucionAreas.gradoAreaFormacion.area_formacion',
            ])
            ->when($anioEscolarId, function ($q) use ($anioEscolarId) {
                $q->where('anio_escolar_id', $anioEscolarId);
            })
            ->when($gradoId, function ($q) use ($gradoId) {
                $q->where('grado_id', $gradoId);
            })
            ->when($seccionId, function ($q) use ($seccionId) {
                $q->where('seccion_id', $seccionId);
            })
            ->when($estatusInscripcion, function ($q) use ($estatusInscripcion) {
                $q->where('status', $estatusInscripcion);
            })
            ->when($buscar, function ($query, $buscar) {
                $query->whereHas('inscripcion.alumno.persona', function ($q) use ($buscar) {
                    $q->where(function ($subQuery) use ($buscar) {
                        $subQuery->where('primer_nombre', 'LIKE', "%{$buscar}%")
                              ->orWhere('segundo_nombre', 'LIKE', "%{$buscar}%")
                              ->orWhere('tercer_nombre', 'LIKE', "%{$buscar}%")
                              ->orWhere('primer_apellido', 'LIKE', "%{$buscar}%")
                              ->orWhere('segundo_apellido', 'LIKE', "%{$buscar}%")
                              ->orWhere('numero_documento', 'LIKE', "%{$buscar}%");
                    });
                });
            })
            ->with([
                'prosecucionAreas.gradoAreaFormacion.area_formacion',
            ])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
