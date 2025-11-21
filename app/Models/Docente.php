<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';
    
    protected $fillable = [
        'primer_telefono',
        'segundo_telefono',
        'codigo',
        'dependencia',
        'status',
        'prefijo_id',
        'persona_id',
        'status' => 'boolean',

    ];

    /**
     * Relación con Persona
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }

    /**
     * Relación con PrefijoTelefono
     */
    public function prefijoTelefono()
    {
        return $this->belongsTo(PrefijoTelefono::class, 'prefijo_id', 'id');
    }

    /**
     * Accessor para obtener el nombre completo
     */
    public function getNombreCompletoAttribute()
    {
        return trim(
            $this->persona->primer_nombre . ' ' .
            $this->persona->segundo_nombre . ' ' .
            $this->persona->tercer_nombre . ' ' .
            $this->persona->primer_apellido . ' ' .
            $this->persona->segundo_apellido
        );
    }

    /**
     * Accessor para obtener el teléfono completo
     */
    public function getTelefonoCompletoAttribute()
    {
        $prefijo = $this->prefijoTelefono->prefijo ?? '';
        return $prefijo . $this->primer_telefono;
    }
}