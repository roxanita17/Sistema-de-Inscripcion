<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndiceEdad extends Model
{
    use HasFactory;

    protected $table = 'indice_edads';
    protected $fillable = [
        'indice',
        'min_meses',
        'max_meses',
        'status',
    ];
}
