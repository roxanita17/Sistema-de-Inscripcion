<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    /** @use HasFactory<\Database\Factories\GradoFactory> */
    use HasFactory;
    protected $table = 'grados';

    protected $fillable = [
        'numero_grado',
        'capacidad_max',
        'min_seccion',
        'max_seccion', 
        'status',
    ];

    public function areas_formacion()
    {
        return $this->belongsToMany(AreaFormacion::class, 'grado_area_formacions')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function total(){
        return Grado::where('status', true)->count();
    }
}
