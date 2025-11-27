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
        'prefijo_id',
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
                ->orWhere('cedula', 'LIKE', "%{$buscar}%")
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