<?php

namespace App\Http\Controllers;

use App\Models\Discapacidad;
use Illuminate\Http\Request;

class DiscapacidadController extends Controller
{
    private function verificarAnioEscolar()
    {
        return \App\Models\AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();
    }
    
    public function verificarExistencia(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
            ]);
            $existe = Discapacidad::where('nombre_discapacidad', $request->nombre)
                ->where('status', true)
                ->exists();
            return response()->json([
                'success' => true,
                'existe' => $existe
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar la discapacidad',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $buscar = request('buscar');
        $query = Discapacidad::query();
        if (!empty($buscar)) {
            $query->where(function($q) use ($buscar) {
                $q->where('nombre_discapacidad', 'LIKE', "%{$buscar}%")
                  ->orWhere('id', 'LIKE', "%{$buscar}%");
            });
        }
        $query->where('status', true);
        $discapacidad = $query->orderBy('nombre_discapacidad', 'asc')
            ->paginate(10)
            ->appends(request()->query());
        $anioEscolarActivo = $this->verificarAnioEscolar();
        return view('admin.discapacidad.index', compact(
            'discapacidad', 
            'anioEscolarActivo',
            'buscar'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_discapacidad' => 'required|string|max:255',
        ]);
        $existe = Discapacidad::where('nombre_discapacidad', $validated['nombre_discapacidad'])
            ->where('status', true)
            ->exists();
        if ($existe) {
            return redirect()
                ->route('admin.discapacidad.index')
                ->with('error', 'Esta discapacidad ya está registrada.');
        }
        try {
            $discapacidad = new Discapacidad();
            $discapacidad->nombre_discapacidad = $validated['nombre_discapacidad'];
            $discapacidad->status = true;
            $discapacidad->save();
            return redirect()
                ->route('admin.discapacidad.index')
                ->with('success', 'Discapacidad creada correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.discapacidad.index')
                ->with('error', 'Error al crear la discapacidad: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $discapacidad = Discapacidad::findOrFail($id);
        $validated = $request->validate([
            'nombre_discapacidad' => 'required|string|max:255',
        ]);
        $existe = Discapacidad::where('nombre_discapacidad', $validated['nombre_discapacidad'])
            ->where('status', true)
            ->where('id', '!=', $id)
            ->exists();
        if ($existe) {
            return redirect()
                ->route('admin.discapacidad.index')
                ->with('error', 'No se puede actualizar: ya existe una discapacidad con este nombre.');
        }
        try {
            $discapacidad->nombre_discapacidad = $validated['nombre_discapacidad'];
            $discapacidad->save();
            return redirect()
                ->route('admin.discapacidad.index')
                ->with('success', 'Discapacidad actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.discapacidad.index')
                ->with('error', 'Error al actualizar la discapacidad: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $discapacidad = Discapacidad::find($id);
            if ($discapacidad) {
                $discapacidad->update(['status' => false]);
                return redirect()
                    ->route('admin.discapacidad.index')
                    ->with('success', 'Discapacidad eliminada correctamente.');
            }
            return redirect()
                ->route('admin.discapacidad.index')
                ->with('error', 'Discapacidad no encontrada.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.discapacidad.index')
                ->with('error', 'Error al eliminar la discapacidad: ' . $e->getMessage());
        }
    }
}
