<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProsecucionArea extends Model
{
    use HasFactory;

    protected $table = 'prosecucion_areas';

    protected $fillable = [
        'inscripcion_prosecucion_id',
        'grado_area_formacion_id',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function inscripcionProsecucion()
    {
        return $this->belongsTo(InscripcionProsecucion::class, 'inscripcion_prosecucion_id', 'id');
    }

    public function gradoAreaFormacion()
    {
        return $this->belongsTo(GradoAreaFormacion::class, 'grado_area_formacion_id', 'id');
    }
}
