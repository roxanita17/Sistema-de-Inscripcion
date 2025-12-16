<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historico extends Model
{
    /** @use HasFactory<\Database\Factories\HistoricoFactory> */
    use HasFactory;

    protected $table='historicos';
    protected $fillable = [
        'anio_escolar_id',
        'inscripcion_id',
        'entradas_percentil_id',
        'docente_area_grado_id',
    ];

    public function anioEscolar()
    {
        return $this->belongsTo(AnioEscolar::class);
    }

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class);
    }

    public function entradasPercentil()
    {
        return $this->belongsTo(EntradasPercentil::class);
    }

    public function docenteAreaGrado()
    {
        return $this->belongsTo(DocenteAreaGrado::class);
    }
}
