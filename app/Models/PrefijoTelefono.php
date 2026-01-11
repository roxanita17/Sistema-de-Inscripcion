<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrefijoTelefono extends Model
{
    use HasFactory;

    protected $table = "prefijo_telefonos";

    protected $fillable = [
        'prefijo',
        'status',
    ];
}
