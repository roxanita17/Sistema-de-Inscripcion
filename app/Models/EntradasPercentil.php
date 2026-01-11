<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EjecucionesPercentil;

class EntradasPercentil extends Model
{
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

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }
    
    public function ejecucion()
    {
        return $this->belongsTo(
            EjecucionesPercentil::class,
            'ejecucion_percentil_id'
        );
    }
}
