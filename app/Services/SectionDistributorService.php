<?php

namespace App\Services;

use App\Models\Inscripcion;
use App\Models\Seccion;
use App\Models\EjecucionesPercentil;
use App\Services\PercentilService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SectionDistributorService
{
    protected $percentilService;

    public function __construct(PercentilService $percentilService)
    {
        $this->percentilService = $percentilService;
    }

    public function procesarGrado($grado)
    {
        return DB::transaction(function () use ($grado) {

            // 1. Inscripciones activas
            $inscripciones = Inscripcion::where('grado_id', $grado->id)
                ->where('status', 'Activo')
                ->with(['alumno.persona'])
                ->get();

            if ($inscripciones->isEmpty()) {
                throw new \Exception('No hay inscripciones activas para este grado');
            }

            // 2. Crear ejecución
            $ejecucion = EjecucionesPercentil::create([
                'total_evaluados' => $inscripciones->count(),
                'status' => true
            ]);

            // 3. Crear entradas percentil
            $entradas = collect();

            foreach ($inscripciones as $inscripcion) {
                try {
                    $entrada = $this->percentilService
                        ->crearEntradaDesdeInscripcion($inscripcion);

                    $entrada->ejecucion_percentil_id = $ejecucion->id;
                    $entrada->save();

                    $entradas->push($entrada);
                } catch (\Exception $e) {
                    Log::error(
                        "Error inscripción {$inscripcion->id}: {$e->getMessage()}"
                    );
                }
            }

            if ($entradas->isEmpty()) {
                throw new \Exception('No se pudo procesar ninguna inscripción');
            }

            // 4. Ordenar
            $ordenados = $entradas->sortBy('indice_total')->values();

            // 5. Calcular secciones
            $min = $grado->min_por_seccion ?? 20;
            $max = $grado->max_por_seccion ?? 30;
            $total = $ordenados->count();

            $numSecciones = (int) ceil($total / $max);

            if (($total / $numSecciones) < $min && $numSecciones > 1) {
                $numSecciones = (int) ceil($total / $min);
            }

            // 6. Crear secciones
            $secciones = collect();
            $letras = range('A', 'Z');

            for ($i = 0; $i < $numSecciones; $i++) {
                $secciones->push(
                    Seccion::create([
                        'nombre' => 'Sección ' . $letras[$i],
                        'cantidad_actual' => 0,
                        'grado_id' => $grado->id,
                        'ejecucion_percentil_id' => $ejecucion->id,
                        'status' => true
                    ])
                );
            }

            // 7. Distribuir estudiantes
$tamañoBase = (int) floor($total / $numSecciones);
$seccionesExtras = $total % $numSecciones;

$estudiantesAsignados = 0;

foreach ($secciones as $indexSeccion => $seccion) {
    // Las primeras secciones con extras llevan un estudiante más
    $tamañoSeccion = $tamañoBase + ($indexSeccion < $seccionesExtras ? 1 : 0);
    
    // Asignar estudiantes consecutivos de la lista ordenada
    for ($i = 0; $i < $tamañoSeccion; $i++) {
        $entrada = $ordenados[$estudiantesAsignados];
        
        $entrada->update(['seccion_id' => $seccion->id]);
        $seccion->increment('cantidad_actual');
        
        $estudiantesAsignados++;
    }
}

            return [
                'total_secciones' => $numSecciones,
                'estudiantes_procesados' => $total,
                'ejecucion_id' => $ejecucion->id
            ];
        });
    }
}
