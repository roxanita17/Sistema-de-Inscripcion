<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discapacidad extends Model
{
    use HasFactory;
    protected $table = 'discapacidads';
    protected $fillable = [
        'nombre_discapacidad',
        'status',
    ];

    public function alumnos()
    {
        return $this->belongsToMany(
            Alumno::class,
            'discapacidad_estudiantes',
            'discapacidad_id',
            'alumno_id'
        )
            ->withPivot('status')
            ->withTimestamps();
    }
}
