<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Persona;
use App\Models\OrdenNacimiento;
use App\Models\Discapacidad;
use App\Models\EtniaIndigena;
use App\Models\ExpresionLiteraria;
use App\Models\Lateralidad;

class Alumno extends Model

{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [

        'orden_nacimiento_id',
        'discapacidad_id',
        'etnia_indigena_id',
        'lateralidad_id',
        'persona_id',
        'talla_camisa',
        'talla_pantalon',
        'talla_zapato',
        'peso',
        'estatura',
        'status',
    ];


/*     protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeBuscar($query, $buscar)
    {
        if (!empty($buscar)) {
            $query->whereHas('areaFormacion', function ($q) use ($buscar) {
                $q->where('nombre_area_formacion', 'LIKE', "%{$buscar}%");

            });

            $query->orWhereHas('estudiosRealizado', function ($q) use ($buscar) {
                $q->where('estudios', 'LIKE', "%{$buscar}%");
            });
        }

        return $query;
    } */

    /**  Área de formación  */
    public function ordenNacimiento()
    {
        return $this->belongsTo(OrdenNacimiento::class, 'orden_nacimiento_id', 'id');
    }

    /**  Estudio realizado  */
    public function discapacidad()
    {
        return $this->belongsTo(Discapacidad::class, 'discapacidad_id', 'id');
    }

    public function etniaIndigena()
    {
        return $this->belongsTo(EtniaIndigena::class, 'etnia_indigena_id', 'id');
    }



    public function lateralidad()
    {
        return $this->belongsTo(Lateralidad::class, 'lateralidad_id', 'id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }

    public function prefijoTelefono()
    {
        return $this->belongsTo(PrefijoTelefono::class, 'prefijo_id', 'id');
    }

    /**
     * Relación con Inscripciones
     */
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'alumno_id', 'id');
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
