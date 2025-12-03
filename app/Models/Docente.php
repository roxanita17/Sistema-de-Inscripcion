<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        'persona_id',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeBuscar($query, $buscar)
    {
        if (!empty($buscar)) {
            $query->whereHas('persona', function ($q) use ($buscar) {
                $q->where(DB::raw("CONCAT(primer_nombre, ' ', primer_apellido)"), 'LIKE', "%{$buscar}%")
                ->orWhere('numero_documento', 'LIKE', "%{$buscar}%")
                ->orWhere('primer_nombre', 'LIKE', "%{$buscar}%")
                ->orWhere('primer_apellido', 'LIKE', "%{$buscar}%")
                ->orWhere('codigo', 'LIKE', "%{$buscar}%");
            });
        }

        return $query;
    }

    /**
     * Relación con DetalleDocenteEstudio
     */
    public function detalleDocenteEstudio()
    {
        return $this->hasMany(DetalleDocenteEstudio::class, 'docente_id', 'id');
    }

    /**
     * Relación directa con estudios realizados (many-to-many)
     */
    public function estudiosRealizados()
    {
        return $this->belongsToMany(
            EstudiosRealizado::class,
            'detalle_docente_estudios',
            'docente_id',
            'estudios_id'
        );
    }

    public function asignacionesAreas() 
    {
        // hasManyThrough(Target, Through, firstKeyOnThrough, secondKeyOnTarget, localKey, secondLocalKey)
        return $this->hasManyThrough(
            DocenteAreaGrado::class,
            DetalleDocenteEstudio::class,
            'docente_id',                    // FK en detalle_docente_estudios que apunta a docentes.id
            'docente_estudio_realizado_id',  // FK en docente_area_grados que apunta a detalle_docente_estudios.id
            'id',                            // PK local en docentes
            'id'                             // PK local en detalle_docente_estudios
        );
    }

    public function asignacionesAreasActivas()
    {
        return $this->asignacionesAreas()->where('docente_area_grados.status', true);
    }

    public function docenteAreaGrado()
    {
        return $this->hasMany(DocenteAreaGrado::class, 'docente_estudio_realizado_id');
    }


    public function detalleEstudios()
    {
        return $this->hasMany(DetalleDocenteEstudio::class, 'docente_id', 'id')->where('status', true);
    }

    /**
     * Relación con Persona
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }


    /**
     * Accessor para obtener el nombre completo
     */
    public function getNombreCompletoAttribute()
    {
        if (!$this->persona) {
            return '';
        }
        
        return trim(
            $this->persona->primer_nombre . ' ' .
            ($this->persona->segundo_nombre ?? '') . ' ' .
            ($this->persona->tercer_nombre ?? '') . ' ' .
            $this->persona->primer_apellido . ' ' .
            ($this->persona->segundo_apellido ?? '')
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