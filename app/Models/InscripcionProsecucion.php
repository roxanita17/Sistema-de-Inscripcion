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
        'anio_escolar_id',
        'grado_id',
        'seccion_id',
        'promovido',
        'repite_grado',
        'observaciones',
        'acepta_normas_contrato',
        'status',
    ];

    protected $casts = [
        'promovido' => 'boolean',
        'repite_grado' => 'boolean',
    ];

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class, 'inscripcion_id', 'id');
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class, 'grado_id', 'id');
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'seccion_id', 'id');
    }

    public function anioEscolar()
    {
        return $this->belongsTo(AnioEscolar::class, 'anio_escolar_id', 'id');
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    
}
