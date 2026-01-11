<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocupacion extends Model
{
    use HasFactory;

    protected $table = 'ocupacions';

    protected $fillable = [
        'nombre_ocupacion',
        'status',
    ];

    public function representantes()
    {
        return $this->hasMany(Representante::class, 'ocupacion_representante', 'id');
    }
}
