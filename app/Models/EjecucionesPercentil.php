<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EjecucionesPercentil extends Model
{
    protected $table = 'ejecuciones_percentils';
    protected $fillable = [        
        'anio_escolar_id',
        'total_evaluados',
        'status',
    ];

    public function anioEscolar()
    {
        return $this->belongsTo(AnioEscolar::class, 'anio_escolar_id');
    }
    
    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'ejecucion_percentil_id');
    }

    public function entradas()
    {
        return $this->hasMany(EntradasPercentil::class, 'ejecucion_percentil_id');
    }
}
