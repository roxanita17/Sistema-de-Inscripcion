<?php

namespace App\Http\Controllers;

use App\Models\EstudiosRealizado;
use App\Models\AreaFormacion;
use App\Models\AreaEstudioRealizado;
use Illuminate\Http\Request;

class AreaEstudioRealizadoController extends Controller
{
    private function verificarAnioEscolar()
    {
        return \App\Models\AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();
    }

    public function index()
    {
        $buscar = request('buscar');
        $areaEstudioRealizado = AreaEstudioRealizado::with(['areaFormacion', 'estudiosRealizado'])
            ->join('area_formacions', 'area_formacions.id', '=', 'area_estudio_realizados.area_formacion_id')
            ->orderBy('area_formacions.nombre_area_formacion', 'asc')
            ->select('area_estudio_realizados.*')
            ->buscar($buscar)
            ->paginate(10);
        $area_formacion = AreaFormacion::where('status', true)
            ->orderBy('nombre_area_formacion', 'asc')
            ->get();
        $estudios = EstudiosRealizado::where('status', true)
            ->orderBy('estudios', 'asc')
            ->get();
        $anioEscolarActivo = $this->verificarAnioEscolar();
        return view(
            'admin.transacciones.area_estudio_realizado.index',
            compact('areaEstudioRealizado', 'area_formacion', 'estudios', 'anioEscolarActivo', 'buscar')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'area_formacion_id' => 'required|exists:area_formacions,id',
            'estudios_id' => 'required|exists:estudios_realizados,id',
        ]);
        $existe = AreaEstudioRealizado::where('area_formacion_id', $validated['area_formacion_id'])
            ->where('estudios_id', $validated['estudios_id'])
            ->exists();
        if ($existe) {
            info('Intento de duplicar asignación área-formación - título universitario');
            return redirect()
                ->route('admin.transacciones.area_estudio_realizado.index')
                ->with('error', 'Esta asignación ya existe.');
        }
        try {
            $areaEstudio = new AreaEstudioRealizado();
            $areaEstudio->area_formacion_id = $validated['area_formacion_id'];
            $areaEstudio->estudios_id = $validated['estudios_id'];
            $areaEstudio->status = true;
            $areaEstudio->save();
            info('Nueva asignación creada: Área ID ' . $validated['area_formacion_id'] . ', Título ID ' . $validated['estudios_id']);
            return redirect()
                ->route('admin.transacciones.area_estudio_realizado.index')
                ->with('success', 'Asignación creada exitosamente.');
        } catch (\Exception $e) {
            info('Error al crear asignación: ' . $e->getMessage());
            return redirect()
                ->route('admin.transacciones.area_estudio_realizado.index')
                ->with('error', 'Error al crear: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'area_formacion_id' => 'required|exists:area_formacions,id',
            'estudios_id' => 'required|exists:estudios_realizados,id',
        ]);
        $asignacion = AreaEstudioRealizado::findOrFail($id);
        $existe = AreaEstudioRealizado::where('area_formacion_id', $validated['area_formacion_id'])
            ->where('estudios_id', $validated['estudios_id'])
            ->where('id', '!=', $id)
            ->exists();
        if ($existe) {
            info("Intento de actualización duplicada para asignación ID {$id}");
            return redirect()
                ->route('admin.transacciones.area_estudio_realizado.index')
                ->with('error', 'No se puede actualizar: esta asignación ya existe.');
        }
        try {
            $asignacion->area_formacion_id = $validated['area_formacion_id'];
            $asignacion->estudios_id = $validated['estudios_id'];
            $asignacion->save();
            info("Asignación actualizada correctamente: ID {$id}");
            return redirect()
                ->route('admin.transacciones.area_estudio_realizado.index')
                ->with('success', 'Asignación actualizada exitosamente.');
        } catch (\Exception $e) {
            info("Error al actualizar asignación ID {$id}: " . $e->getMessage());
            return redirect()
                ->route('admin.transacciones.area_estudio_realizado.index')
                ->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $asignacion = AreaEstudioRealizado::findOrFail($id);
            $asignacion->delete();
            info("Asignación eliminada correctamente: ID {$id}");
            return redirect()
                ->route('admin.transacciones.area_estudio_realizado.index')
                ->with('success', 'Asignación eliminada exitosamente.');
        } catch (\Exception $e) {
            info("Error al eliminar asignación ID {$id}: " . $e->getMessage());
            return redirect()
                ->route('admin.transacciones.area_estudio_realizado.index')
                ->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}
