<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleDocenteEstudio extends Model
{
    use HasFactory;

    protected $table = "detalle_docente_estudios";

    protected $fillable = [
        'docente_id',
        'estudios_id',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Relación: pertenece a un docente
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id', 'id');
    }

    /**
     * Relación: pertenece a un estudio realizado
     */
    public function estudiosRealizado()  // ← CAMBIADO el nombre
    {
        return $this->belongsTo(EstudiosRealizado::class, 'estudios_id', 'id');
    }
}