<?php

namespace App\Services;

use App\Models\Inscripcion;
use App\Models\EntradasPercentil;
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

    /**
     * Procesa un grado completo: calcula percentiles y distribuye en secciones
     */
    public function procesarGrado($grado)
    {
        return DB::transaction(function () use ($grado) {
            
            // 1. Obtener inscripciones activas del grado
            $inscripciones = Inscripcion::where('grado_id', $grado->id)
                ->where('status', true)
                ->with(['alumno.persona'])
                ->get();

            if ($inscripciones->isEmpty()) {
                throw new \Exception('No hay inscripciones activas para este grado');
            }

            // 2. Crear registro de ejecución
            $ejecucion = EjecucionesPercentil::create([
                'fecha_ejecucion' => now(),
                'total_evaluados' => $inscripciones->count(),
                'status' => true
            ]);

            // 3. Generar entradas de percentil para cada estudiante
            $entradas = collect();

            foreach ($inscripciones as $inscripcion) {
                try {
                    $entrada = $this->percentilService->crearEntradaDesdeInscripcion($inscripcion);
                    $entrada->ejecucion_percentil_id = $ejecucion->id;
                    $entrada->save();
                    $entradas->push($entrada);
                } catch (\Exception $e) {
                    Log::error("Error al procesar inscripción {$inscripcion->id}: " . $e->getMessage());
                    continue;
                }
            }

            if ($entradas->isEmpty()) {
                throw new \Exception('No se pudo procesar ninguna inscripción');
            }

            // 4. Ordenar por índice total (menor a mayor)
            $ordenados = $entradas->sortBy('indice_total')->values();

            // 5. Calcular número de secciones necesarias
            $min = $grado->min_por_seccion ?? 20;
            $max = $grado->max_por_seccion ?? 30;
            $totalEstudiantes = $ordenados->count();

            // Número de secciones basado en el máximo por sección
            $numSecciones = (int) ceil($totalEstudiantes / $max);

            // Ajustar si el promedio cae por debajo del mínimo
            $promedioEstudiantes = $totalEstudiantes / $numSecciones;
            
            if ($promedioEstudiantes < $min && $numSecciones > 1) {
                $numSecciones = (int) ceil($totalEstudiantes / $min);
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

            // 7. Distribuir estudiantes equitativamente
            // Los estudiantes con menor índice van primero
            $index = 0;

            foreach ($ordenados as $entrada) {
                $seccionIndex = $index % $numSecciones;
                $seccion = $secciones[$seccionIndex];

                $entrada->seccion_id = $seccion->id;
                $entrada->save();

                $seccion->cantidad_actual++;
                $seccion->save();

                $index++;
            }

            return [
                'total_secciones' => $numSecciones,
                'estudiantes_procesados' => $totalEstudiantes,
                'ejecucion_id' => $ejecucion->id
            ];
        });
    }

    /**
     * Valida que un grado tenga la configuración necesaria
     */
    public function validarGrado($grado)
    {
        if (!$grado->min_por_seccion || !$grado->max_por_seccion) {
            throw new \Exception('El grado debe tener configurados los valores mínimo y máximo de estudiantes por sección');
        }

        if ($grado->min_por_seccion > $grado->max_por_seccion) {
            throw new \Exception('El mínimo de estudiantes no puede ser mayor que el máximo');
        }

        return true;
    }
}