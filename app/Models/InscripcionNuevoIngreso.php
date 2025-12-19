<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InscripcionNuevoIngreso extends Model
{
    use HasFactory;
    
    protected $table = 'inscripcion_nuevo_ingresos';

    protected $fillable = [
        'numero_zonificacion',
        'inscripcion_id',
        'institucion_procedencia_id',
        'expresion_literaria_id',
        'anio_egreso',
    ];


    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class, 'inscripcion_id', 'id');
    }

    public function expresionLiteraria()
    {
        return $this->belongsTo(ExpresionLiteraria::class, 'expresion_literaria_id', 'id');
    }

    public function institucionProcedencia()
    {
        return $this->belongsTo(InstitucionProcedencia::class, 'institucion_procedencia_id', 'id');
    }
}
