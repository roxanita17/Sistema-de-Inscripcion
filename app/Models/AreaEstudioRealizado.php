<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EstudiosRealizado;

class AreaEstudioRealizado extends Model
{
    use HasFactory;

    protected $table = "area_estudio_realizados";

    protected $fillable = [
        'area_formacion_id',
        'estudios_id',
        'status',
    ];

    // Relación: pertenece a un área de formación
    public function area_formacion()
    {
        return $this->belongsTo(AreaFormacion::class, 'area_formacion_id', 'id');
    }

    // Relación: pertenece a un título universitario (estudio realizado)
    public function estudio_realizado()
    {
        return $this->belongsTo(EstudiosRealizado::class, 'estudios_id', 'id');
    }
}

