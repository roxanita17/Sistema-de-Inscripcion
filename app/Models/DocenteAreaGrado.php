<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DocenteAreaGrado extends Model
{
    protected $table = 'docente_area_grados';

    protected $fillable = [
        'docente_estudio_realizado_id',
        'area_estudio_realizado_id',
        'grado_id',
        'status',
    ];

// app/Models/Docente.php


// ...

/**
 * Scope para búsqueda general:
 * busca por persona (nombre/numero_documento), por estudios realizados y por materias/áreas asignadas.
 */
public function scopeBuscar($query, $buscar)
{
    if (empty($buscar)) {
        return $query;
    }

    $buscar = trim($buscar);

    return $query->where(function($q) use ($buscar) {
        // 1) Persona: nombre completo o cédula
        $q->whereHas('persona', function($p) use ($buscar) {
            $p->where(DB::raw("CONCAT(primer_nombre, ' ', primer_apellido)"), 'LIKE', "%{$buscar}%")
              ->orWhere('primer_nombre', 'LIKE', "%{$buscar}%")
              ->orWhere('primer_apellido', 'LIKE', "%{$buscar}%")
              ->orWhere('numero_documento', 'LIKE', "%{$buscar}%");
        });

        // 2) Estudios realizados del docente (DetalleDocenteEstudio -> EstudiosRealizado.estudios)
        $q->orWhereHas('areaEstudios', function($d) use ($buscar) {
            $d->whereHas('areaFormacion', function($e) use ($buscar) {
                $e->where('nombre_area_formacion', 'LIKE', "%{$buscar}%");
            });
        });
    });
}





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
