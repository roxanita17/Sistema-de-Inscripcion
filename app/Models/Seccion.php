<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EjecucionesPercentil;
use App\Models\Grado;

class Seccion extends Model
{
    /** @use HasFactory<\Database\Factories\SeccionFactory> */
    use HasFactory;
    protected $table = 'seccions';
    protected $fillable = [
        'nombre',
        'cantidad_actual',
        'grado_id',
        'ejecucion_percentil_id',
        'status',
    ];

    /**
     * Relación con Grado
     */
    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    /**
     * Relación con EjecucionesPercentil
     */
    public function ejecucionPercentil()
    {
        return $this->belongsTo(EjecucionesPercentil::class, 'ejecucion_percentil_id');
    }

    /**
     * Relación con EntradasPercentil
     */
    public function entradasPercentil()
    {
        return $this->hasMany(EntradasPercentil::class, 'seccion_id');
    }
}
