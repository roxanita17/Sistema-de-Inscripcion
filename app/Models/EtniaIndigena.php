<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EtniaIndigena extends Model
{
    protected $table = "etnia_indigenas";
    protected $fillable = [
        'nombre',
        'status',
    ];

    public function alumnos()
    {
        return $this->hasMany(Alumno::class, 'etnia_indigena_id', 'id');
    }
}
