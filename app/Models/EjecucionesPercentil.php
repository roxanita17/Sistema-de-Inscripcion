<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EjecucionesPercentil extends Model
{
    /** @use HasFactory<\Database\Factories\EjecucionesPercentilFactory> */
    use HasFactory;

    protected $table = 'ejecuciones_percentils';
    protected $fillable = [
        'total_evaluados',
        'status',
    ];
}
