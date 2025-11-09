<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GradoAreaFormacion extends Model
{
    protected $table = 'grado_area_formacions';

    protected $fillable = [
        'codigo',
        'grado_id',
        'area_formacion_id',
        'status',
    ];

    // Cada asignación pertenece a un grado
    public function grado()
    {
        return $this->belongsTo(Grado::class, 'grado_id', 'id');
    }

    // Cada asignación pertenece a un área de formación
    public function area_formacion()
    {
        return $this->belongsTo(AreaFormacion::class, 'area_formacion_id', 'id');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->generarCodigo();
        });

        static::updating(function ($model) {
            if ($model->isDirty(['grado_id', 'area_formacion_id'])) {
                $model->generarCodigo();
            }
        });
    }

    protected function generarCodigo(): void
    {
        // Obtener número del grado
        $gradoNumero = null;
        if ($this->relationLoaded('grado') && $this->grado) {
            $gradoNumero = $this->grado->numero_grado;
        } else {
            $grado = Grado::find($this->grado_id);
            $gradoNumero = $grado?->numero_grado ?? 0;
        }
        $gradoNumero = (int) $gradoNumero;
        if ($gradoNumero < 0 || $gradoNumero > 999) {
            $gradoNumero = 0;
        }

        // Obtener el nombre del área de formación
        $nombreArea = null;
        if ($this->relationLoaded('area_formacion') && $this->area_formacion) {
            $nombreArea = $this->area_formacion->nombre_area_formacion;
        } else {
            $area = AreaFormacion::find($this->area_formacion_id);
            $nombreArea = $area?->nombre_area_formacion ?? '';
        }

        // Generar las iniciales de cada palabra (por ejemplo, "Ciencias Naturales" -> "CN")
        $palabras = preg_split('/\s+/', trim($nombreArea));
        $iniciales = '';
        foreach ($palabras as $palabra) {
            $iniciales .= mb_substr($palabra, 0, 1, 'UTF-8');
        }

        // Normalizar a caracteres ASCII y mayúsculas
        $prefix = Str::ascii($iniciales);
        $prefix = preg_replace('/[^A-Za-z]/u', '', $prefix);
        $prefix = Str::upper($prefix ?? '');

        // Si por alguna razón el nombre está vacío, rellenar con "XXX"
        $prefix = $prefix !== '' ? $prefix : 'XXX';

        // Formato del código: NNN-XXX (por ejemplo, "001-CN" o "002-CDLT")
        $codigoBase = sprintf('%03d-%s', $gradoNumero, $prefix);

        // En caso de duplicado, agregar un número incremental
        $contador = 1;
        $codigoFinal = $codigoBase;
        while (self::where('codigo', $codigoFinal)->exists()) {
            $codigoFinal = $codigoBase . $contador;
            $contador++;
        }

        $this->codigo = $codigoFinal;
    }
}