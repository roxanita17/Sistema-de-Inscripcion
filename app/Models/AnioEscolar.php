<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AnioEscolar extends Model
{
    use HasFactory;

    protected $table = 'anio_escolars';

    protected $fillable = [
        'inicio_anio_escolar',
        'cierre_anio_escolar',
        'extencion_anio_escolar', 
        'status',   
    ];

    protected $casts = [
        'inicio_anio_escolar' => 'date',
        'cierre_anio_escolar' => 'date',
        'extencion_anio_escolar' => 'date',
    ];

    // ========================================
    // SCOPES
    // ========================================

    /**
     * Obtener solo años escolares activos o extendidos
     */
    public function scopeActivos($query)
    {
        return $query->whereIn('status', ['Activo', 'Extendido']);
    }

    /**
     * Obtener años escolares inactivos
     */
    public function scopeInactivos($query)
    {
        return $query->where('status', 'Inactivo');
    }

    // ========================================
    // MÉTODOS ESTÁTICOS
    // ========================================

    /**
     * Inactiva automáticamente años escolares vencidos
     * 
     * @return int Cantidad de años inactivados
     */
    public static function inactivarVencidos(): int
    {
        $hoy = Carbon::today();
        $contador = 0;

        $aniosVencidos = self::activos()
            ->where('cierre_anio_escolar', '<', $hoy)
            ->get();

        foreach ($aniosVencidos as $anio) {
            $anio->marcarComoInactivo();
            $contador++;
            
            Log::info('Año escolar auto-inactivado', [
                'id' => $anio->id,
                'inicio' => $anio->inicio_anio_escolar->format('Y-m-d'),
                'cierre' => $anio->cierre_anio_escolar->format('Y-m-d'),
                'fecha_sistema' => $hoy->format('Y-m-d')
            ]);
        }

        return $contador;
    }

    // ========================================
    // MÉTODOS DE ACCIÓN
    // ========================================

    /**
     * Marca el año escolar como extendido
     */
    public function marcarComoExtendido(): void
    {
        $this->update(['status' => 'Extendido']);
    }

    /**
     * Marca el año escolar como inactivo
     */
    public function marcarComoInactivo(): void
    {
        $this->update(['status' => 'Inactivo']);
    }

    // ========================================
    // ACCESSORS (Atributos calculados)
    // ========================================

    /**
     * Obtiene el nombre legible del año escolar
     */
    public function getNombreCompletoAttribute(): string
    {
        return sprintf(
            '%s - %s',
            $this->inicio_anio_escolar->format('d/m/Y'),
            $this->cierre_anio_escolar->format('d/m/Y')
        );
    }

    /**
     * Calcula la duración en días
     */
    public function getDuracionDiasAttribute(): int
    {
        return $this->inicio_anio_escolar->diffInDays($this->cierre_anio_escolar);
    }

    /**
     * Calcula la duración en meses
     */
    public function getDuracionMesesAttribute(): int
    {
        return $this->inicio_anio_escolar->diffInMonths($this->cierre_anio_escolar);
    }

    /**
 * Valida si se puede crear un año escolar con fechas dadas.
 */
public static function puedeCrearConFechas($inicio, $cierre): array
{
    $inicio = Carbon::parse($inicio);
    $cierre = Carbon::parse($cierre);

    // Validación básica
    if ($inicio >= $cierre) {
        return [
            'valido' => false,
            'error' => 'La fecha de inicio no puede ser mayor o igual a la fecha de cierre.'
        ];
    }

    // Validar que no exista un año escolar que se superponga
    $existe = self::where(function ($q) use ($inicio, $cierre) {
        $q->whereBetween('inicio_anio_escolar', [$inicio, $cierre])
          ->orWhereBetween('cierre_anio_escolar', [$inicio, $cierre]);
    })
    ->whereIn('status', ['Activo', 'Extendido'])
    ->exists();

    if ($existe) {
        return [
            'valido' => false,
            'error' => 'Ya existe un año escolar que se superpone con estas fechas.'
        ];
    }

    return [
        'valido' => true,
        'error' => null
    ];
}

/**
 * Valida si se puede extender el año escolar a una nueva fecha.
 */
public function puedeExtenderA($nuevoCierre): array
{
    $nuevoCierre = Carbon::parse($nuevoCierre);

    if ($nuevoCierre <= $this->cierre_anio_escolar) {
        return [
            'valido' => false,
            'error' => 'La nueva fecha debe ser mayor a la fecha de cierre actual.'
        ];
    }

    return [
        'valido' => true,
        'error' => null
    ];
}

}