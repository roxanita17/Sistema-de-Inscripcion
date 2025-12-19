<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscripcionProsecucion extends Model
{
    use HasFactory;

    protected $table = 'inscripcion_prosecucions';

    protected $fillable = [
        'inscripcion_id',
        'promovido',
        'repite_grado',
    ];

    protected $casts = [
        'promovido' => 'boolean',
        'repite_grado' => 'boolean',
    ];

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class, 'inscripcion_id', 'id');
    }
}
