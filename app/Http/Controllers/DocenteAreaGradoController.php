<?php

namespace App\Http\Controllers;

use App\Models\DetalleDocenteEstudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Docente;
use App\Models\AreaEstudioRealizado;
use App\Models\DocenteAreaGrado;
use Illuminate\Support\Facades\Log;
use App\Models\Grado;
use \App\Models\Seccion;
use \App\Models\AreaFormacion;
use Barryvdh\DomPDF\Facade\Pdf;


class DocenteAreaGradoController extends Controller
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
     * Muestra el listado de docentes
     */
    public function index(Request $request)
    {
        $gradosEscolares = collect();
        $secciones = collect();
        $areasFormacion = collect();

        $gradoId = $request->grado_id;
        $seccionNombre = $request->seccion_id;
        $areaFormacionId = $request->area_formacion_id;


        $buscar = request('buscar');
        $docentes = Docente::with([
            'persona',
            'asignacionesAreas.areaEstudios.areaFormacion',
            'asignacionesAreas.grado',
            'asignacionesAreas.seccion',
        ])
        ->whereHas('asignacionesAreasActivas')
        ->whereHas('persona', fn($q) => $q->where('status', true))
        ->where('status', true)

        ->when($gradoId, function ($q) use ($gradoId) {
            $q->whereHas('asignacionesAreas', function ($sub) use ($gradoId) {
                $sub->where('docente_area_grados.grado_id', $gradoId)
                    ->where('docente_area_grados.status', true);
            });
        })


        ->when($seccionNombre, function ($q) use ($seccionNombre) {
            $q->whereHas('asignacionesAreas.seccion', function ($sub) use ($seccionNombre) {
                $sub->where('seccions.nombre', $seccionNombre)
                    ->where('seccions.status', true);
            });
        })

        ->when($areaFormacionId, function ($q) use ($areaFormacionId) {
            $q->whereHas('asignacionesAreas.areaEstudios', function ($sub) use ($areaFormacionId) {
                $sub->where('area_formacion_id', $areaFormacionId);
            });
        })

        ->buscar($buscar)
        ->paginate(10)
        ->withQueryString();


        $anioEscolarActivo = $this->verificarAnioEscolar();




        $gradosEscolares = Grado::where('status', true)
            ->orderBy('numero_grado')
            ->get();

        $secciones = Seccion::where('status', true)
            ->select('nombre')
            ->distinct()
            ->orderBy('nombre')
            ->get();

        $areasFormacion = AreaFormacion::where('status', true)
            ->orderBy('nombre_area_formacion')
            ->get();


        return view('admin.transacciones.docente_area_grado.index', compact(
            'docentes',
            'anioEscolarActivo',
            'buscar',
            'gradosEscolares',
            'secciones',
            'areasFormacion'
        ));


    }


    public function create()
    {
        return view('admin.transacciones.docente_area_grado.create');
    }

    public function edit($id)
    {
        return view('admin.transacciones.docente_area_grado.edit', [
            'docenteId' => $id
        ]);
    }

    /**
     * Eliminación lógica de la asignación
     */

    public function destroyAsignacion($id)
    {
        try {
            // Buscar TODAS las asignaciones del docente (no por id directo)
            $asignaciones = DocenteAreaGrado::whereHas('detalleDocenteEstudio', function ($q) use ($id) {
                $q->where('docente_id', $id);
            })->get();

            if ($asignaciones->isEmpty()) {
                return back()->with('error', 'No existen asignaciones activas para este docente.');
            }

            // Inactivar todas las asignaciones
            foreach ($asignaciones as $asg) {
                $asg->update(['status' => false]);
            }

            return redirect()
                ->route('admin.transacciones.docente_area_grado.index')
                ->with('success', 'Asignación(es) del docente eliminadas correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo eliminar la asignación: ' . $e->getMessage());
        }
    }

    /**
     * Generar reporte PDF general de docentes con asignaciones
     */
    public function reportePDFGeneral(Request $request)
    {
        $gradoId = $request->grado_id;
        $seccionNombre = $request->seccion_id;
        $areaFormacionId = $request->area_formacion_id;
        $buscar = $request->buscar;

        $docentes = Docente::with([
            'persona',
            'persona.genero',
            'persona.tipoDocumento',
            'asignacionesAreas.areaEstudios.areaFormacion',
            'asignacionesAreas.grado',
            'asignacionesAreas.seccion',
        ])
        ->whereHas('asignacionesAreasActivas')
        ->whereHas('persona', fn($q) => $q->where('status', true))
        ->where('status', true)

        ->when($gradoId, function ($q) use ($gradoId) {
            $q->whereHas('asignacionesAreas', function ($sub) use ($gradoId) {
                $sub->where('docente_area_grados.grado_id', $gradoId)
                    ->where('docente_area_grados.status', true);
            });
        })

        ->when($seccionNombre, function ($q) use ($seccionNombre) {
            $q->whereHas('asignacionesAreas.seccion', function ($sub) use ($seccionNombre) {
                $sub->where('seccions.nombre', $seccionNombre)
                    ->where('seccions.status', true);
            });
        })

        ->when($areaFormacionId, function ($q) use ($areaFormacionId) {
            $q->whereHas('asignacionesAreas.areaEstudios', function ($sub) use ($areaFormacionId) {
                $sub->where('area_formacion_id', $areaFormacionId);
            });
        })

        ->buscar($buscar)
        ->get();

        $pdf = Pdf::loadView('admin.transacciones.docente_area_grado.reportes.general_pdf', [
            'docentes' => $docentes
        ]);

        $pdf->setPaper('A4', 'landscape');
        $pdf->setOption('isPhpEnabled', true);

        return $pdf->stream('reporte_general_docentes_asignaciones.pdf');
    }
}
