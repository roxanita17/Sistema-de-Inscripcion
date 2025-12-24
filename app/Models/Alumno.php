<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Persona;
use App\Models\OrdenNacimiento;
use App\Models\Discapacidad;
use App\Models\ExpresionLiteraria;
use App\Models\Lateralidad;
use App\Models\EtniaIndigena;

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

    /**
     * Relación muchos a muchos con discapacidades
     */
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

    /**
     * Relación directa con la tabla intermedia
     */
    public function discapacidadEstudiante()
    {
        return $this->hasMany(DiscapacidadEstudiante::class, 'alumno_id', 'id');
    }

    /**
     * Relación con Inscripciones
     */
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'alumno_id', 'id');
    }

    public function inscripcionProsecucions()
    {
        return $this->hasManyThrough(
            InscripcionProsecucion::class,
            Inscripcion::class,
            'alumno_id',        // FK en inscripcions
            'inscripcion_id',   // FK en inscripcion_prosecucions
            'id',               // PK en alumnos
            'id'                // PK en inscripcions
        );
    }

    /**
     * Obtener la inscripción activa del alumno
     */
    public function inscripcionActiva()
    {
        return $this->hasOne(Inscripcion::class, 'alumno_id', 'id')
            ->where('status', true)
            ->latest('fecha_inscripcion');
    }

    public function inscripcionAnterior(int $anioActualId)
    {
        // Última inscripción base (nuevo ingreso)
        $inscripcionBase = $this->inscripciones()
            ->where('anio_escolar_id', '<', $anioActualId)
            ->orderByDesc('anio_escolar_id')
            ->first();

        // Última prosecución
        $inscripcionProsecucion = InscripcionProsecucion::whereHas(
            'inscripcion',
            fn($q) => $q->where('alumno_id', $this->id)
        )
            ->where('anio_escolar_id', '<', $anioActualId)
            ->orderByDesc('anio_escolar_id')
            ->with('grado')
            ->first();

        // Comparar cuál es la más reciente
        if ($inscripcionBase && $inscripcionProsecucion) {
            return $inscripcionBase->anio_escolar_id > $inscripcionProsecucion->anio_escolar_id
                ? $inscripcionBase
                : $inscripcionProsecucion;
        }

        return $inscripcionBase ?? $inscripcionProsecucion;
    }


    public function ultimaInscripcionAntesDe(int $anioActualId)
    {
        // Última inscripción base
        $base = $this->inscripciones()
            ->where('anio_escolar_id', '<', $anioActualId)
            ->with('grado')
            ->orderByDesc('anio_escolar_id')
            ->first();

        // Última prosecución
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



    /**
     * Scope para buscar alumnos
     */
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

    //REPORTES

    public static function ReportePDF($genero = null, $tipo_documento = null)
    {
        $query = DB::table("alumnos")
            ->select(
                // Datos del alumno
                'alumnos.id',
                'alumnos.talla_camisa',
                'alumnos.talla_pantalon',
                'alumnos.talla_zapato',
                'alumnos.peso',
                'alumnos.estatura',

                // Datos de persona
                'personas.primer_nombre',
                'personas.segundo_nombre',
                'personas.tercer_nombre',
                'personas.primer_apellido',
                'personas.segundo_apellido',
                'personas.numero_documento',
                'personas.fecha_nacimiento',
                'generos.genero as nombre_genero',
                'tipo_documentos.nombre as tipo_documento',


                'etnia_indigenas.nombre as etnia',
                'lateralidads.lateralidad',
                'orden_nacimientos.orden_nacimiento',
                'discapacidads.nombre_discapacidad',
            )
            ->join("personas", "personas.id", "=", "alumnos.persona_id")
            ->leftJoin("discapacidads", "discapacidads.id", "=", "alumnos.discapacidad_id")
            ->leftJoin("orden_nacimientos", "orden_nacimientos.id", "=", "alumnos.orden_nacimiento_id")
            ->leftJoin("etnia_indigenas", "etnia_indigenas.id", "=", "alumnos.etnia_indigena_id")
            ->leftJoin("lateralidads", "lateralidads.id", "=", "alumnos.lateralidad_id")
            ->leftJoin("generos", "generos.id", "=", "personas.genero_id")
            ->leftJoin("tipo_documentos", "tipo_documentos.id", "=", "personas.tipo_documento_id");

        /*
            * Filtros
            */

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

            // 1. Inactivar alumno
            $alumno->update([
                'status' => false,
            ]);

            // 2. Inactivar inscripciones relacionadas (Activo o Pendiente)
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
