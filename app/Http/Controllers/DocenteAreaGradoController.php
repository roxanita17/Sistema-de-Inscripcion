<?php

namespace App\Http\Controllers;

use App\Models\DetalleDocenteEstudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Docente;
use App\Models\AreaEstudioRealizado;
use App\Models\DocenteAreaGrado;
use Illuminate\Support\Facades\Log;


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
    public function index()
    {
        $buscar = request('buscar');

        $docentes = Docente::with([
            'persona',
            'asignacionesAreas.areaEstudios.areaFormacion',
        ])
            ->whereHas('asignacionesAreasActivas')
            ->whereHas('persona', fn($q) => $q->where('status', true))
            ->where('status', true)
            ->buscar($buscar)
            ->paginate(10);

        $anioEscolarActivo = $this->verificarAnioEscolar();

        return view('admin.transacciones.docente_area_grado.index', compact(
            'docentes',
            'anioEscolarActivo',
            'buscar'
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
}
