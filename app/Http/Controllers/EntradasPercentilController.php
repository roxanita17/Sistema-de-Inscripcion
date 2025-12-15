<?php

namespace App\Http\Controllers;

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
        $anioEscolarActivo = $this->verificarAnioEscolar();

        $gradoId = $request->grado_id; // llega desde un botón o selector

        $entradasPercentil = EntradasPercentil::with(['inscripcion.alumno', 'seccion'])
            ->whereHas('inscripcion', function ($q) use ($gradoId) {
                if ($gradoId) {
                    $q->where('grado_id', $gradoId);
                }
            })->orderBy('seccion_id', 'asc')
            ->orderBy('indice_total', 'asc')
            ->paginate(10);

        $seccionesResumen = EntradasPercentil::select('seccion_id')
            ->with('seccion')
            ->whereHas('inscripcion', function ($q) use ($gradoId) {
                if ($gradoId) $q->where('grado_id', $gradoId);
            })
            ->groupBy('seccion_id')
            ->selectRaw('count(*) as total_estudiantes, seccion_id')
            ->get();

        return view('admin.transacciones.percentil.index', compact('entradasPercentil', 'anioEscolarActivo', 'gradoId', 'seccionesResumen'));
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
