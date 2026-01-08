<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table = 'estados';
    protected $fillable = [
        'pais_id',
        'nombre_estado',
        'status',
    ];

    public function pais(){
        return $this->belongsTo(Pais::class,"pais_id","id");
    }

    public function municipio(){
        return $this->hasMany(Municipio::class,"estado_id","id");
    }
}