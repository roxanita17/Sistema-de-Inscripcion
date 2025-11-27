<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Representante extends Model
{
    //
    use SoftDeletes;

    protected $table = "representantes";

    protected $fillable = [
        "persona_id",
        "estado_id",
        "ocupacion_representante",
        "convivenciaestudiante_representante",
        "municipio_id",
        "parroquia_id",
    ];


        public function estado()
    {
        return $this->belongsTo(Estado::class, "estado_id", "id");
    }

    public function municipios()
    {
        return $this->belongsTo(Municipio::class, "municipio_id", "id");
    }

    public function localidads(){
        return $this->belongsTo(Localidad::class,"parroquia_id","id");
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class,"persona_id","id");
    }

    public function ocupacion()
    {
        return $this->belongsTo(Ocupacion::class, "ocupacion_representante", "id");
    }

    public function legal()
    {
        return $this->hasOne(RepresentanteLegal::class, 'representante_id', 'id');
    }

}
