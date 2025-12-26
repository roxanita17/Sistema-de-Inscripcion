<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Persona;
use App\Models\Genero;
use App\Models\TipoDocumento;
use App\Models\Alumno;
use App\Models\InscripcionProsecucion;
use App\Models\Grado;
use App\Models\Seccion;
use Illuminate\Http\Request;

class InscripcionProsecucionController extends Controller
{
    public function index(Request $request)
    {
        $anioEscolarActivo = \App\Models\AnioEscolar::whereIn('status', ['Activo', 'Extendido'])->first();

        $buscar    = $request->buscar;
        $gradoId   = $request->grado_id;
        $seccionId = $request->seccion_id;

        $grados = Grado::where('status', true)
            ->orderBy('numero_grado')
            ->get();

        $secciones = collect();
        if ($gradoId) {
            $secciones = Seccion::where('grado_id', $gradoId)
                ->where('status', true)
                ->orderBy('nombre')
                ->get();
        }

        $prosecuciones = InscripcionProsecucion::with([
            // inscripción base
            'inscripcion.alumno.persona.tipoDocumento',
            'inscripcion.representanteLegal.representante.persona',

            // datos de prosecución
            'grado',
            'seccion',
            'anioEscolar',
        ])
            ->where('status', 'Activo')
            ->when(
                $anioEscolarActivo,
                fn($q) =>
                $q->where('anio_escolar_id', $anioEscolarActivo->id)
            )
            ->when(
                $gradoId,
                fn($q) =>
                $q->where('grado_id', $gradoId)
            )
            ->when(
                $seccionId,
                fn($q) =>
                $q->where('seccion_id', $seccionId)
            )
            ->when($buscar, function ($q) use ($buscar) {
                $q->whereHas('inscripcion.alumno.persona', function ($qq) use ($buscar) {
                    $qq->where('primer_nombre', 'like', "%$buscar%")
                        ->orWhere('primer_apellido', 'like', "%$buscar%")
                        ->orWhere('numero_documento', 'like', "%$buscar%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.transacciones.inscripcion_prosecucion.index', [
            'anioEscolarActivo' => (bool) $anioEscolarActivo,
            'anioEscolar' => $anioEscolarActivo,
            'prosecuciones' => $prosecuciones,
            'grados' => $grados,
            'secciones' => $secciones,
            'buscar' => $buscar,
            'gradoId' => $gradoId,
            'seccionId' => $seccionId,
        ]);
    }

    public function seccionesPorGrado($gradoId)
    {
        $secciones = Seccion::where('grado_id', $gradoId)
            ->where('status', true)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return response()->json($secciones);
    }



    // Add other methods as needed (create, store, edit, update, destroy)
}
