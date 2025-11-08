<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaFormacion extends Model
{
    /** @use HasFactory<\Database\Factories\AreaFormacionFactory> */
    use HasFactory;
    protected $table = 'area_formacions';

    protected $fillable = [
        'nombre_area_formacion',
        'status',
    ];
}
