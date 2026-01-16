<?php

namespace App\Http\Controllers;

use App\Models\AreaFormacion;
use App\Models\Grado;
use App\Models\GradoAreaFormacion;
use Illuminate\Http\Request;

class GradoAreaFormacionController extends Controller
{
    private function verificarAnioEscolar()
    {
        return \App\Models\AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();
    }

    public function index()
    {
        $gradoAreaFormacion = GradoAreaFormacion::with([
            'grado',
            'area_formacion' => function ($query) {
                $query->select('id', 'nombre_area_formacion', 'siglas');
            }
        ])
            ->join('grados', 'grados.id', '=', 'grado_area_formacions.grado_id')
            ->orderBy('grados.numero_grado', 'asc')
            ->select('grado_area_formacions.*')
            ->paginate(10);
        $grados = Grado::where('status', true)
            ->orderBy('numero_grado', 'asc')
            ->get();
        $areaFormacion = AreaFormacion::where('status', true)
            ->orderBy('nombre_area_formacion', 'asc')
            ->select('id', 'nombre_area_formacion', 'siglas')
            ->get();
        $anioEscolarActivo = $this->verificarAnioEscolar();
        return view('admin.transacciones.grado_area_formacion.index', compact('gradoAreaFormacion', 'grados', 'areaFormacion', 'anioEscolarActivo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'grado_id' => 'required|exists:grados,id',
            'area_formacion_id' => 'required|exists:area_formacions,id',
        ]);
        $existe = GradoAreaFormacion::where('grado_id', $validated['grado_id'])
            ->where('area_formacion_id', $validated['area_formacion_id'])
            ->exists();
        if ($existe) {
            info('Intento de duplicar asignación grado-área');
            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('error', 'Esta asignación ya existe.');
        }
        try {
            $gradoAreaFormacion = new GradoAreaFormacion();
            $gradoAreaFormacion->grado_id = $validated['grado_id'];
            $gradoAreaFormacion->area_formacion_id = $validated['area_formacion_id'];
            $gradoAreaFormacion->status = true;
            $gradoAreaFormacion->save();
            info('Nueva asignación creada: Grado ID ' . $validated['grado_id'] . ', Área ID ' . $validated['area_formacion_id']);
            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('success', 'Asignación creada exitosamente.');
        } catch (\Exception $e) {
            info('Error al crear asignación: ' . $e->getMessage());
            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('error', 'Error al crear: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'grado_id' => 'required|exists:grados,id',
            'area_formacion_id' => 'required|exists:area_formacions,id',
        ]);
        $gradoAreaFormacion = GradoAreaFormacion::findOrFail($id);
        $existe = GradoAreaFormacion::where('grado_id', $validated['grado_id'])
            ->where('area_formacion_id', $validated['area_formacion_id'])
            ->where('id', '!=', $id)
            ->exists();
        if ($existe) {
            info('Intento de actualización duplicada para asignación ID ' . $id);
            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('error', 'No se puede actualizar: esta asignación ya existe.');
        }
        try {
            $gradoAreaFormacion->grado_id = $validated['grado_id'];
            $gradoAreaFormacion->area_formacion_id = $validated['area_formacion_id'];
            $gradoAreaFormacion->save();
            info('Asignación actualizada correctamente: ID ' . $id);
            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('success', 'Asignación actualizada exitosamente.');
        } catch (\Exception $e) {
            info('Error al actualizar asignación ID ' . $id . ': ' . $e->getMessage());
            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $gradoAreaFormacion = GradoAreaFormacion::findOrFail($id);
            $gradoAreaFormacion->delete();
            info('Asignación eliminada correctamente: ID ' . $id);
            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('success', 'Asignación eliminada exitosamente.');
        } catch (\Exception $e) {
            info('Error al eliminar asignación ID ' . $id . ': ' . $e->getMessage());
            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}
