<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class AnioEscolar extends Model
{
    /** @use HasFactory<\Database\Factories\AnioEscolarFactory> */
    use HasFactory;
    protected $table = 'anio_escolars';

    protected $fillable = [
        'inicio_anio_escolar',
        'cierre_anio_escolar',
        'extencion_anio_escolar',
        'status',
    ];
}
