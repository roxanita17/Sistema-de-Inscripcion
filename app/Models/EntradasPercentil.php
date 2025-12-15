<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntradasPercentil extends Model
{
    /** @use HasFactory<\Database\Factories\EntradasPercentilFactory> */
    use HasFactory;

    protected $table = 'entradas_percentils';
    protected $fillable = [
        'edad_meses',
        'peso_kg',
        'estatura_cm',
        'indice_edad',
        'indice_peso',
        'indice_estatura',
        'indice_total',
        'seccion_id',
        'ejecucion_percentil_id',
        'inscripcion_id',
        'status',
    ];

    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'seccion_id');
    }

    public function ejecucion_percentil()
    {
        return $this->belongsTo(EjecucionesPercentil::class);
    }

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }
}
