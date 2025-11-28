<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estudiante extends Model
{
    //
    use SoftDeletes;

    protected $table = "estudiantes";

    protected $fillable = [
            "id",
            "estado_id",
            "persona_id",
            "municipio_id",
            "localidad_id",
            "institucion_id",
            "orden_nacimiento_estudiante",
            'talla_estudiante',
            'peso_estudiante',
            'talla_camisa',
            'talla_zapato',
            'talla_pantalon',

            // "edad_estudiante",
            // "meses_estudiante",
            // "pueblo_indigena_estudiante",
            "cual_pueblo_indigna",
            // "talla_camisa_estudiante",
            // "talla_pantalon_estudiante",
            // "talla_zapato_estudiante",
            // "estatura_estudiante",
            // "peso_estudiante",
            // "posee_discapacidad_estudiante",
            "discapacidad_estudiante",
            "documentos_estudiante",
            "numero_zonificacion_plantel",
            // "intitucion_procedencia",
            "ano_ergreso_estudiante",
            "expresion_literaria",
            "lateralidad_estudiante",
            // "idEstado",
            // "idMunicipio",
            // "idparroquia",
            "DocumentosEstudiante",
    ];

        CONST STATUS_ACTIVO       ="Activo";
            CONST STATUS_INACTIVO   ="inactivo";
                CONST STATUS_EN_ESPERA    ="En Espera";



    public function persona(){
        return $this->belongsTo(Persona::class,"persona_id","id");
    }

        public function estado()
    {
        return $this->belongsTo(Estado::class, "estado_id", "id");
    }

    public function municipios()
    {
        return $this->belongsTo(Municipio::class, "municipio_id", "id");
    }

    // public function parroquia(){
    //     return $this->belongsTo(Parroquia::class,"parroquia_id","id");
    // }




    // public function representanteEstudiantes()
    // {
    //     return $this->hasMany(RepresentanteEstudiante::class, 'estudiante_id', 'id');
    // }

    // public function municipios(){
    //     return $this->hasMany(Municipio::class,"estado_id","id");
    // }


}
