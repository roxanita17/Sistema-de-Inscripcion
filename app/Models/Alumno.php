<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Persona;
use App\Models\OrdenNacimiento;
use App\Models\Discapacidad;
use App\Models\Lateralidad;
use App\Models\EtniaIndigena;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Alumno extends Model

{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'etnia_indigena_id',
        'orden_nacimiento_id',
        'lateralidad_id',
        'persona_id',
        'talla_camisa_id',
        'talla_pantalon_id',
        'talla_zapato',
        'peso',
        'estatura',
        'status',
    ];

    protected function estatura(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ((float)$value == (int)$value) {
                    return (int)$value;
                }
                return rtrim(rtrim($value, '0'), '.');
            },
            set: function ($value) {
                if ($value === null || $value === '') {
                    return null;
                }
                $value = str_replace(',', '.', (string) $value);
                if (!is_numeric($value)) {
                    return null;
                }
                $value = (float) $value;
                if ($value > 3) {
                    return round($value / 100, 2);
                }
                return round($value, 2);
            }
        );
    }

    public function ordenNacimiento()
    {
        return $this->belongsTo(OrdenNacimiento::class, 'orden_nacimiento_id', 'id');
    }

    public function lateralidad()
    {
        return $this->belongsTo(Lateralidad::class, 'lateralidad_id', 'id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }

    public function etniaIndigena()
    {
        return $this->belongsTo(EtniaIndigena::class, 'etnia_indigena_id', 'id');
    }

    public function prefijoTelefono()
    {
        return $this->belongsTo(PrefijoTelefono::class, 'prefijo_id', 'id');
    }

    public function tallaCamisa()
    {
        return $this->belongsTo(Talla::class, 'talla_camisa_id');
    }

    public function tallaPantalon()
    {
        return $this->belongsTo(Talla::class, 'talla_pantalon_id');
    }

    public function discapacidades()
    {
        return $this->belongsToMany(
            Discapacidad::class,
            'discapacidad_estudiantes',
            'alumno_id',
            'discapacidad_id'
        )
            ->withPivot('status')
            ->wherePivot('status', true)
            ->withTimestamps();
    }

    public function discapacidadEstudiante()
    {
        return $this->hasMany(DiscapacidadEstudiante::class, 'alumno_id', 'id');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'alumno_id', 'id');
    }

    public function inscripcionProsecucions()
    {
        return $this->hasManyThrough(
            InscripcionProsecucion::class,
            Inscripcion::class,
            'alumno_id',
            'inscripcion_id',
            'id',
            'id'
        );
    }

    public function inscripcionActiva()
    {
        return $this->hasOne(Inscripcion::class, 'alumno_id', 'id')
            ->where('status', true)
            ->latest('fecha_inscripcion');
    }

    public function inscripcionAnterior(int $anioActualId)
    {
        $inscripcionBase = $this->inscripciones()
            ->where('anio_escolar_id', '<', $anioActualId)
            ->orderByDesc('anio_escolar_id')
            ->first();

        $inscripcionProsecucion = InscripcionProsecucion::whereHas(
            'inscripcion',
            fn($q) => $q->where('alumno_id', $this->id)
        )
            ->where('anio_escolar_id', '<', $anioActualId)
            ->orderByDesc('anio_escolar_id')
            ->with('grado')
            ->first();

        if ($inscripcionBase && $inscripcionProsecucion) {
            return $inscripcionBase->anio_escolar_id > $inscripcionProsecucion->anio_escolar_id
                ? $inscripcionBase
                : $inscripcionProsecucion;
        }
        return $inscripcionBase ?? $inscripcionProsecucion;
    }

    public function ultimaInscripcion()
    {
        return $this->inscripciones()
            ->where('status', 'Activo')
            ->orderByDesc('anio_escolar_id')
            ->orderByDesc('created_at')
            ->first();
    }



    public function ultimaInscripcionAntesDe(int $anioActualId)
    {
        $base = $this->inscripciones()
            ->where('anio_escolar_id', '<', $anioActualId)
            ->with('grado')
            ->orderByDesc('anio_escolar_id')
            ->first();

        $prosecucion = InscripcionProsecucion::whereHas(
            'inscripcion',
            fn($q) => $q->where('alumno_id', $this->id)
        )
            ->where('anio_escolar_id', '<', $anioActualId)
            ->with('grado')
            ->orderByDesc('anio_escolar_id')
            ->first();

        if ($base && $prosecucion) {
            return $base->anio_escolar_id > $prosecucion->anio_escolar_id
                ? $base
                : $prosecucion;
        }
        return $base ?? $prosecucion;
    }

    public function ultimaInscripcionConRepresentantes()
    {
        return $this->inscripciones()
            ->where('status', 'Activo')
            ->where(function ($q) {
                $q->whereNotNull('representante_legal_id')
                    ->orWhereNotNull('padre_id')
                    ->orWhereNotNull('madre_id');
            })
            ->orderBy('anio_escolar_id')
            ->first();
    }


    public function materiasPendientesHistoricas()
    {
        return ProsecucionArea::whereHas('inscripcionProsecucion.inscripcion', function ($q) {
            $q->where('alumno_id', $this->id);
        })
            ->where('status', 'pendiente')
            ->with([
                'gradoAreaFormacion.area_formacion',
                'gradoAreaFormacion.grado'
            ])
            ->get();
    }

    public function materiasPendientesUltimaProsecucion()
    {
        $ultimaProsecucion = $this->inscripcionProsecucions()
            ->where('inscripcion_prosecucions.status', 'Activo')
            ->orderByDesc('anio_escolar_id')
            ->orderByDesc('created_at')
            ->first();

        if (!$ultimaProsecucion) {
            return collect();
        }

        return $ultimaProsecucion->prosecucionAreas()
            ->where('status', 'pendiente')
            ->with([
                'gradoAreaFormacion.area_formacion',
                'gradoAreaFormacion.grado',
            ])
            ->get();
    }



    public function scopeBuscar($query, $buscar)
    {
        if (!empty($buscar)) {
            $query->whereHas('persona', function ($q) use ($buscar) {
                $q->where('primer_nombre', 'LIKE', "%{$buscar}%")
                    ->orWhere('primer_apellido', 'LIKE', "%{$buscar}%")
                    ->orWhere('numero_documento', 'LIKE', "%{$buscar}%");
            });
        }
        return $query;
    }

    public static function ReportePDF($genero = null, $tipo_documento = null)
    {
        $query = DB::table("alumnos")
            ->select(
                'alumnos.id',
                'alumnos.talla_camisa',
                'alumnos.talla_pantalon',
                'alumnos.talla_zapato',
                'alumnos.peso',
                'alumnos.estatura',
                'personas.primer_nombre',
                'personas.segundo_nombre',
                'personas.tercer_nombre',
                'personas.primer_apellido',
                'personas.segundo_apellido',
                'personas.numero_documento',
                'personas.fecha_nacimiento',
                'generos.genero as nombre_genero',
                'tipo_documentos.nombre as tipo_documento',
                'pais.nameES as pais',

                'etnia_indigenas.nombre as etnia',
                'lateralidads.lateralidad',
                'orden_nacimientos.orden_nacimiento'
            )
            ->join("personas", "personas.id", "=", "alumnos.persona_id")
            ->leftJoin("orden_nacimientos", "orden_nacimientos.id", "=", "alumnos.orden_nacimiento_id")
            ->leftJoin("etnia_indigenas", "etnia_indigenas.id", "=", "alumnos.etnia_indigena_id")
            ->leftJoin("lateralidads", "lateralidads.id", "=", "alumnos.lateralidad_id")
            ->leftJoin("generos", "generos.id", "=", "personas.genero_id")
            ->leftJoin("tipo_documentos", "tipo_documentos.id", "=", "personas.tipo_documento_id")
            ->leftJoin("localidads", "localidads.id", "=", "personas.localidad_id")
            ->leftJoin("estados", "estados.id", "=", "localidads.estado_id")
            ->leftJoin("pais", "pais.id", "=", "estados.pais_id");

        if ($genero) {
            $query->where("generos.genero", $genero);
        }

        if ($tipo_documento) {
            $query->where("tipo_documentos.nombre", $tipo_documento);
        }
        return $query->get();
    }

    public static function eliminar($id)
    {
        return DB::transaction(function () use ($id) {

            $alumno = Alumno::with('inscripciones')->findOrFail($id);

            $alumno->update([
                'status' => false,
            ]);
            $alumno->inscripciones()
                ->whereIn('status', ['Activo', 'Pendiente'])
                ->update([
                    'status' => 'Inactivo',
                    'updated_at' => now(),
                ]);
            return true;
        });
    }
}
