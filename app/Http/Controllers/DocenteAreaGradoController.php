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
        $docentes = Docente::with([
                'persona',
                'asignacionesAreas.areaEstudios.areaFormacion', // cargar relaciones para mostrar materia -> areaFormacion
            ])
            ->whereHas('asignacionesAreasActivas')
            ->whereHas('persona', fn($q) => $q->where('status', true))
            ->where('status', true)
            ->paginate(10);

        $anioEscolarActivo = $this->verificarAnioEscolar();

        return view('admin.transacciones.docente_area_grado.index', compact('docentes', 'anioEscolarActivo'));
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
     * Eliminación lógica del docente y su persona
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            // Buscar docente con persona (si no existe fallará)
            $docente = Docente::with('persona')->findOrFail($id);
            $persona = $docente->persona;

            // Inactivar registros dependientes que puedan bloquear (en vez de borrar)
            // 1) DetalleDocenteEstudio
            DetalleDocenteEstudio::where('docente_id', $docente->id)
                ->update(['status' => false]);

            // 2) Asignaciones DocenteAreaGrado que referencien a los detalles del docente
            DocenteAreaGrado::whereHas('detalleDocenteEstudio', function($q) use ($docente) {
                $q->where('docente_id', $docente->id);
            })->update(['status' => false]);

            // Inactivar docente y persona (el enfoque actual es lógica vía campo `status`)
            $docente->update(['status' => false]);

            if ($persona) {
                $persona->update(['status' => false]);
            }

            DB::commit();

            return redirect()->route('admin.transacciones.docente_area_grado.index')
                ->with('success', 'Docente eliminado (inactivado) correctamente.');

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            return back()->with('error', 'Error de base de datos: ' . $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }

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
