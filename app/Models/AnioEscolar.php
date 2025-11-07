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
        'inicio_ano_escolar',
        'cierre_ano_escolar',
        'extencion_ano_escolar',
        'status',
    ];
}
