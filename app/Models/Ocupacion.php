<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocupacion extends Model
{
    /** @use HasFactory<\Database\Factories\OcupacionFactory> */
    use HasFactory;

    protected $table = 'ocupacions';

    protected $fillable = [
        'nombre_ocupacion',
        'status',
    ];
}
