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

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    public function ejecucion_percentil()
    {
        return $this->belongsTo(EjecucionesPercentil::class);
    }
}
