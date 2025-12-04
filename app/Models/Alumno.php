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
        'numero_zonificacion',
        'institucion_procedencia_id',
        'expresion_literaria_id',
        'orden_nacimiento_id',
        'discapacidad_id',
        'etnia_indigena_id',
        'lateralidad_id',
        'persona_id',
        'anio_egreso',
        'talla_camisa',
        'talla_pantalon',
        'tallas_zapato',
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

    public function expresionLiteraria()
    {
        return $this->belongsTo(ExpresionLiteraria::class, 'expresion_literaria_id', 'id');
    }

    public function lateralidad()
    {
        return $this->belongsTo(Lateralidad::class, 'lateralidad_id', 'id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }

    public function institucionProcedencia()
    {
        return $this->belongsTo(InstitucionProcedencia::class, 'institucion_procedencia_id', 'id');
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

    //REPORTES

    public static function ReportePDF(){
        $query = DB::table("alumnos")
        ->select(
            // Datos del alumno
            'alumnos.id',
            'alumnos.talla_camisa',
            'alumnos.talla_pantalon',
            'alumnos.tallas_zapato',
            'alumnos.peso',
            'alumnos.estatura',
            'alumnos.anio_egreso',

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
            'expresion_literarias.letra_expresion_literaria',
            'orden_nacimientos.orden_nacimiento',
            'discapacidads.nombre_discapacidad',
            'institucion_procedencias.nombre_institucion'
        )
        ->join("personas", "personas.id", "=", "alumnos.persona_id")
        ->leftJoin("discapacidads", "discapacidads.id", "=", "alumnos.discapacidad_id")
        ->leftJoin("institucion_procedencias", "institucion_procedencias.id", "=", "alumnos.institucion_procedencia_id")
        ->leftJoin("orden_nacimientos", "orden_nacimientos.id", "=", "alumnos.orden_nacimiento_id")
        ->leftJoin("etnia_indigenas", "etnia_indigenas.id", "=", "alumnos.etnia_indigena_id")
        ->leftJoin("lateralidads", "lateralidads.id", "=", "alumnos.lateralidad_id")
        ->leftJoin("expresion_literarias", "expresion_literarias.id", "=", "alumnos.expresion_literaria_id")
        ->leftJoin("generos", "generos.id", "=", "personas.genero_id")
        ->leftJoin("tipo_documentos", "tipo_documentos.id", "=", "personas.tipo_documento_id");
        
        return $query->get();
    }

    public static function eliminar($id)
    {
        return DB::table('alumnos')
            ->where('id', $id)
            ->update([
                'status' => false,
                'updated_at' => now()
            ]);
    }


}


