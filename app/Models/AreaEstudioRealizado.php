<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AreaEstudioRealizado extends Model
{
    protected $table = 'area_estudio_realizados';

    protected $fillable = [
        'area_formacion_id',
        'estudios_id',
        'status',
    ];

    protected $casts = [
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
    }

    /**  Área de formación  */
    public function areaFormacion()
    {
        return $this->belongsTo(AreaFormacion::class, 'area_formacion_id', 'id');
    }

    /**  Estudio realizado  */
    public function estudiosRealizado()
    {
        return $this->belongsTo(EstudiosRealizado::class, 'estudios_id', 'id');
    }
}


