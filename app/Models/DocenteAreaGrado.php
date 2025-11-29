<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocenteAreaGrado extends Model
{
    protected $table = 'docente_area_grados';

    protected $fillable = [
        'docente_estudio_realizado_id',
        'area_estudio_realizado_id',
        'grado_id',
        'status',
    ];

    // RELACIONES

    public function detalleDocenteEstudio()
    {
        return $this->belongsTo(DetalleDocenteEstudio::class, 'docente_estudio_realizado_id');
    }

    public function areaEstudios()
    {
        return $this->belongsTo(AreaEstudioRealizado::class, 'area_estudio_realizado_id');
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class, 'grado_id');
    }

}
