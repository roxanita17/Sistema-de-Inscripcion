<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EjecucionesPercentil extends Model
{
    /** @use HasFactory<\Database\Factories\EjecucionesPercentilFactory> */
    use HasFactory;

    protected $table = 'ejecuciones_percentils';
    protected $fillable = [
        'total_evaluados',
        'status',
    ];

        /**
     * Relación con Secciones
     */
    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'ejecucion_percentil_id');
    }

    /**
     * Relación con EntradasPercentil
     */
    public function entradas()
    {
        return $this->hasMany(EntradasPercentil::class, 'ejecucion_percentil_id');
    }
}
