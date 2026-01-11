<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table = 'localidads';
    
    protected $fillable = [
        'pais_id',
        'estado_id',
        'municipio_id',
        'nombre_localidad',
        'status',
    ];

    public function municipio(){
    return $this->belongsTo(Municipio::class, "municipio_id", "id");
    }

    public function estado(){
    return $this->belongsTo(Estado::class, "municipio_id", "id");
    }

    public function estadoThroughMunicipio(){
        return $this->municipio->estado();
    }
    
    public function pais()
    {
        return $this->belongsTo(Pais::class, "pais_id", "id");
    }
   
    
}
