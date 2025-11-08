<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discapacidad extends Model
{
    /** @use HasFactory<\Database\Factories\DiscapacidadFactory> */
    use HasFactory;
    protected $table = 'discapacidads';
    protected $fillable = [
        'nombre_discapacidad',
        'status',
    ];
    
}
