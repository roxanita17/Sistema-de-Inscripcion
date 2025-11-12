<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudiosRealizado extends Model
{
    /** @use HasFactory<\Database\Factories\EstudiosRealizadoFactory> */
    use HasFactory;
    protected $table = 'estudios_realizados';
    protected $fillable = [
        'estudios',
        'status',
    ];
}
