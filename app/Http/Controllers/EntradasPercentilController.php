<?php

namespace App\Http\Controllers;

use App\Models\AnioEscolar;
use App\Models\EntradasPercentil;
use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Grado;
use App\Services\SectionDistributorService;
use App\Models\Seccion;
use Illuminate\Pagination\LengthAwarePaginator;
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
        $gradoId = $request->grado_id;

        $anioEscolarActivo = AnioEscolar::whereIn('status', ['Activo', 'Extendido'])->first();

        // 👉 SI NO HAY AÑO ESCOLAR
        if (!$anioEscolarActivo) {

            $entradasPercentil = new LengthAwarePaginator(
                collect(), // items
                0,         // total
                10,        // per page
                1,         // current page
                ['path' => request()->url(), 'query' => request()->query()]
            );

            return view(
                'admin.transacciones.percentil.index',
                [
                    'entradasPercentil' => $entradasPercentil,
                    'seccionesResumen' => collect(),
                    'gradoId' => $gradoId,
                    'anioEscolarActivo' => null,
                ]
            );
        }

        // 👉 SI HAY AÑO ESCOLAR
        $entradasPercentil = EntradasPercentil::with(['inscripcion.alumno', 'seccion'])
            ->whereHas('ejecucion', function ($q) use ($anioEscolarActivo) {
                $q->where('anio_escolar_id', $anioEscolarActivo->id);
            })
            ->when($gradoId, function ($q) use ($gradoId) {
                $q->whereHas('inscripcion', fn($qq) => $qq->where('grado_id', $gradoId));
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
            compact(
                'entradasPercentil',
                'gradoId',
                'seccionesResumen',
                'anioEscolarActivo'
            )
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

        if (!$this->verificarAnioEscolar()) {
            return back()->with('error', 'No existe un año escolar activo.');
        }

        $grado = Grado::findOrFail($request->grado_id);
        $anioEscolarActivo = AnioEscolar::whereIn('status', ['Activo', 'Extendido'])->first();

        $totalEstudiantes = Inscripcion::where('grado_id', $grado->id)
            ->whereIn('status', ['Activo', 'Pendiente'])
            ->where('anio_escolar_id', $anioEscolarActivo->id)
            ->count();

        // 🚫 Validación crítica
        if ($totalEstudiantes < $grado->min_seccion) {
            return back()->with(
                'error',
                "No se puede ejecutar el percentil. 
                Mínimo por sección: {$grado->min_seccion}. 
                Estudiantes actuales: {$totalEstudiantes}."
            );
        }

        try {
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
