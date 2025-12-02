<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndicePeso extends Model
{
    /** @use HasFactory<\Database\Factories\IndicePesoFactory> */
    use HasFactory;

    protected $table = 'indices_pesos';
    protected $fillable = [
        'indice',
        'min_kg',
        'max_kg',
        'status',
    ];
}
