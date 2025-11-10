<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitucionProcedencia extends Model
{
    /** @use HasFactory<\Database\Factories\InstitucionProcedenciaFactory> */
    use HasFactory;

    protected $table = "institucion_procedencias";

    protected $fillable = [
        'nombre_institucion',
        'status',
    ];
}
