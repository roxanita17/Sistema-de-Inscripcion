<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';
    
    protected $fillable = [
        'primer_nombre',
        'segundo_nombre',
        'tercer_nombre',
        'primer_apellido',
        'segundo_apellido',
        'numero_documento',
        'fecha_nacimiento',
        'direccion',
        'telefono',
        'email',
        'status',
        'tipo_documento_id',
        'genero_id',
        'localidad_id',
        'prefijo_id',
        'fecha_nacimiento' => 'date',
        'status' => 'boolean',
    ];



    /**
     * Relación con TipoDocumento
     */
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id', 'id');
    }

    /**
     * Relación con Genero
     */
    public function genero()
    {
        return $this->belongsTo(Genero::class, 'genero_id', 'id');
    }

    /**
     * Relación con Localidad
     */
    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'localidad_id', 'id');
    }

    /**
     * Relación inversa con Docente
     */
    public function docente()
    {
        return $this->hasOne(Docente::class, 'persona_id', 'id');
    }

    /**
     * Accessor para obtener el nombre completo
     */
    public function getNombreCompletoAttribute()
    {
        return trim(
            $this->primer_nombre . ' ' .
            $this->segundo_nombre . ' ' .
            $this->tercer_nombre . ' ' .
            $this->primer_apellido . ' ' .
            $this->segundo_apellido
        );
    }

    /**
     * Accessor para obtener edad
     */
    public function getEdadAttribute()
    {
        return $this->fecha_nacimiento->age ?? null;
    }
}