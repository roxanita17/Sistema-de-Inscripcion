<?php

namespace App\Http\Controllers;

use App\Models\AnioEscolar;
use App\Models\EntradasPercentil;
use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Grado;
use App\Services\SectionDistributorService;
use App\Models\Seccion;
use Illuminate\Support\Facades\DB;

class EntradasPercentilController extends Controller
{
    /**
     * Verifica si hay un año escolar activo
     */
    private function verificarAnioEscolar()
    {
        return \App\Models\AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $hayAnioActivo = $this->verificarAnioEscolar();

        $gradoId = $request->grado_id; // llega desde un botón o selector

        $anioEscolarActivo = AnioEscolar::whereIn('status', ['Activo', 'Extendido'])->first();

        $entradasPercentil = EntradasPercentil::with(['inscripcion.alumno', 'seccion'])
            ->whereHas('ejecucion', function ($q) use ($anioEscolarActivo) {
                $q->where('anio_escolar_id', $anioEscolarActivo->id);
            })
            ->whereHas('inscripcion', function ($q) use ($gradoId) {
                if ($gradoId) {
                    $q->where('grado_id', $gradoId);
                }
            })
            ->orderBy('seccion_id')
            ->orderBy('indice_total')
            ->paginate(10);


        $seccionesResumen = EntradasPercentil::selectRaw('seccion_id, COUNT(*) as total_estudiantes')
            ->with('seccion')
            ->whereHas('ejecucion', function ($q) use ($anioEscolarActivo) {
                $q->where('anio_escolar_id', $anioEscolarActivo->id);
            })
            ->when($gradoId, function ($q) use ($gradoId) {
                $q->whereHas('inscripcion', fn($qq) => $qq->where('grado_id', $gradoId));
            })
            ->groupBy('seccion_id')
            ->get();


        return view(
            'admin.transacciones.percentil.index',
            compact('entradasPercentil', 'hayAnioActivo', 'gradoId', 'seccionesResumen', 'anioEscolarActivo')
        );
    }


    public function store(Inscripcion $inscripcion)
    {
        $entrada = app(\App\Services\PercentilService::class)
            ->crearEntradaDesdeInscripcion($inscripcion);

        return response()->json($entrada);
    }

    public function ejecutar(Request $request, SectionDistributorService $distributor)
    {
        $request->validate([
            'grado_id' => 'required|exists:grados,id'
        ]);

        // 1. Verificar año escolar activo
        if (!$this->verificarAnioEscolar()) {
            return back()->with('error', 'No existe un año escolar activo.');
        }

        $grado = Grado::findOrFail($request->grado_id);

        try {


            // 3. Ejecutar percentil + distribución
            $resultado = $distributor->procesarGrado($grado);

            return back()->with(
                'success',
                "Percentil ejecutado correctamente. 
             Estudiantes procesados: {$resultado['estudiantes_procesados']}, 
             Secciones creadas: {$resultado['total_secciones']}"
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
