<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitucionProcedencia extends Model
{
    /** @use HasFactory<\Database\Factories\InstitucionProcedenciaFactory> */
    use HasFactory;

    protected $table = "institucion_procedencias";

    protected $fillable = [
        'nombre_institucion',
        'localidad_id',
        'pais_id',
        'status',
    ];

    public function localidad(){
    return $this->belongsTo(Localidad::class, "localidad_id", "id");
    }

    public function municipio(){
    return $this->belongsTo(Municipio::class, "municipio_id", "id");
    }

    public function estado(){
        return $this->belongsTo(Estado::class, "estado_id", "id");
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, "pais_id", "id");
    }
}

