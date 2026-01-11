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
        'tipo_inscripcion',
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

    public function entradaPercentil()
    {
        return $this->hasOne(EntradasPercentil::class, 'inscripcion_id');
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class,  'seccion_id', 'id');
    }

    public function seccionAsignada()
    {
        return $this->hasOneThrough(
            Seccion::class,
            EntradasPercentil::class,
            'inscripcion_id',
            'id',
            'id',
            'seccion_id'
        );
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id', 'id');
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class, 'grado_id', 'id');
    }

    public function padre()
    {
        return $this->belongsTo(Representante::class, 'padre_id', 'id');
    }

    public function madre()
    {
        return $this->belongsTo(Representante::class, 'madre_id', 'id');
    }

    public function representanteLegal()
    {
        return $this->belongsTo(RepresentanteLegal::class, 'representante_legal_id', 'id');
    }

    public function anioEscolar()
    {
        return $this->belongsTo(AnioEscolar::class, 'anio_escolar_id', 'id');
    }

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

    public function scopeActivas($query)
    {
        return $query->where('status', true);
    }

    public function scopePorGrado($query, $gradoId)
    {
        return $query->where('grado_id', $gradoId);
    }

    public function scopeAnioActual($query)
    {
        return $query->whereYear('fecha_inscripcion', now()->year);
    }

    public function scopeAnioEscolarVigente($query)
    {
        return $query->whereHas('anioEscolar', function ($q) {
            $q->whereIn('status', ['Activo', 'Extendido']);
        });
    }

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

    public function obtenerDatosCompletos()
    {
        $alumno = $this->alumno?->load([
            'tallaCamisa',
            'tallaPantalon'
        ]);
        return [
            'inscripcion' => $this->toArray(),
            'nuevo_ingreso' => $this->nuevoIngreso?->toArray(),
            'persona_alumno' => $alumno?->persona?->toArray(),
            'alumno' => array_merge($alumno?->toArray() ?? [], [
                'talla_camisa' => $alumno?->tallaCamisa?->nombre,
                'talla_pantalon' => $alumno?->tallaPantalon?->nombre,
            ]),
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
            $inscripcion->update([
                'status' => 'Inactivo',
            ]);
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
            $inscripcion->update([
                'status' => 'Activo',
            ]);
            if ($inscripcion->alumno) {
                $inscripcion->alumno->update([
                    'status' => true,
                ]);
            }
            return true;
        });
    }
}
