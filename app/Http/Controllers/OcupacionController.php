<?php

namespace App\Http\Controllers;

use App\Models\Ocupacion;
use Illuminate\Http\Request;

class OcupacionController extends Controller
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

            $existe = Ocupacion::where('nombre_ocupacion', $request->nombre)
                ->where('status', true)
                ->exists();

            return response()->json([
                'success' => true,
                'existe' => $existe
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en verificarExistencia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar la ocupación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $buscar = request('buscar');
        $query = Ocupacion::query();
        
        if (!empty($buscar)) {
            $query->where(function($q) use ($buscar) {
                $q->where('nombre_ocupacion', 'LIKE', "%{$buscar}%")
                  ->orWhere('id', 'LIKE', "%{$buscar}%");
            });
        }
        
        $query->where('status', true);
        $ocupacion = $query->orderBy('nombre_ocupacion', 'asc')
                         ->paginate(10)
                         ->appends(request()->query());

        $anioEscolarActivo = $this->verificarAnioEscolar();
        return view("admin.ocupacion.index", compact(
            "ocupacion", 
            "anioEscolarActivo",
            'buscar'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_ocupacion' => 'required|string|max:255',
        ]);

        $existe = Ocupacion::where('nombre_ocupacion', $validated['nombre_ocupacion'])
            ->where('status', true)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.ocupacion.index')
                ->with('error', 'Ya existe una ocupación activa con este nombre.');
        }

        try {
            $ocupacion = new Ocupacion();
            $ocupacion->nombre_ocupacion = $validated['nombre_ocupacion'];
            $ocupacion->status = true;
            $ocupacion->save();

            return redirect()->route('admin.ocupacion.index')
                ->with('success', 'La ocupación fue registrada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.ocupacion.index')
                ->with('error', 'Ocurrió un error al registrar la ocupación: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $ocupacion = Ocupacion::findOrFail($id);
        $validated = $request->validate([
            'nombre_ocupacion' => 'required|string|max:255',
        ]);

        $existe = Ocupacion::where('nombre_ocupacion', $validated['nombre_ocupacion'])
            ->where('status', true)
            ->where('id', '!=', $ocupacion->id)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.ocupacion.index')
                ->with('error', 'Ya existe otra ocupación activa con este nombre.');
        }

        try {
            $ocupacion->nombre_ocupacion = $validated['nombre_ocupacion'];
            $ocupacion->save();

            return redirect()->route('admin.ocupacion.index')
                ->with('success', 'La ocupación fue actualizada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.ocupacion.index')
                ->with('error', 'Ocurrió un error al actualizar la ocupación: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $ocupacion = Ocupacion::find($id);

        if ($ocupacion) {
            $ocupacion->update(['status' => false]);

            return redirect()->route('admin.ocupacion.index')
                ->with('success', 'La ocupación fue eliminada correctamente.');
        }

        return redirect()->route('admin.ocupacion.index')
            ->with('error', 'No se encontró la ocupación especificada.');
    }
}
