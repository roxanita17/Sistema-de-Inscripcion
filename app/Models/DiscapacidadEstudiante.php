<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscapacidadEstudiante extends Model
{
    use HasFactory;

    protected $table = 'discapacidad_estudiantes';

    protected $fillable = [
        'discapacidad_id',
        'alumno_id',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /* ================= RELACIONES ================= */

    public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id', 'id');
    }

    public function discapacidad()
    {
        return $this->belongsTo(Discapacidad::class, 'discapacidad_id', 'id');
    }
}
