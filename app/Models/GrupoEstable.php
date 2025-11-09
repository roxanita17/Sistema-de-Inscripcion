<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoEstable extends Model
{
    /** @use HasFactory<\Database\Factories\GrupoEstableFactory> */
    use HasFactory;

    protected $table = 'grupo_estables';

    protected $fillable = [
        'nombre_grupo_estable',
        'status',
    ];
}
