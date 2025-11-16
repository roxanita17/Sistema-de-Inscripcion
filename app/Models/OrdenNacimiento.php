<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenNacimiento extends Model
{
    use HasFactory;

    protected $table = 'orden_nacimientos';

    protected $fillable = [
        'orden_nacimiento',
        'status',
    ];
}
