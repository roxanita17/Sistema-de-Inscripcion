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


}


