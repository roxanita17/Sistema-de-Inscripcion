<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndiceEstatura extends Model
{
    /** @use HasFactory<\Database\Factories\IndiceEstaturaFactory> */
    use HasFactory;

    protected $table = 'indices_estaturas';
    protected $fillable = [
        'indice',
        'min_cm',
        'max_cm',
        'status',
    ];
}
