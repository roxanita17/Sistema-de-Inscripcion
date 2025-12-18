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
    
    /**
     * Relación uno a muchos con la tabla intermedia (para usar whereHas)
     */
    public function gradoAreaFormacion()
    {
        return $this->hasMany(GradoAreaFormacion::class, 'grado_id', 'id');
    }




}
