<?php

namespace App\Http\Controllers;

use App\Models\EtniaIndigena;
use Illuminate\Http\Request;

class EtniaIndigenaController extends Controller
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
        $query = EtniaIndigena::query();
        if (!empty($buscar)) {
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                  ->orWhere('id', 'LIKE', "%{$buscar}%");
            });
        }
        $query->where('status', true);
        $etniaIndigena = $query->orderBy('nombre', 'asc')
            ->paginate(10)
            ->appends(request()->query());
        $anioEscolarActivo = $this->verificarAnioEscolar();
        return view("admin.etnia_indigena.index", compact(
            "etniaIndigena", 
            "anioEscolarActivo",
            'buscar'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        $existe = EtniaIndigena::where('nombre', $validated['nombre'])
            ->where('status', true)
            ->exists();
        if ($existe) {
            return redirect()
                ->route('admin.etnia_indigena.index')
                ->with('error', 'Ya existe una etnia indígena activa con este nombre.');
        }
        try {
            $etniaIndigena = new EtniaIndigena();
            $etniaIndigena->nombre = $validated['nombre'];
            $etniaIndigena->status = true;
            $etniaIndigena->save();
            return redirect()
                ->route('admin.etnia_indigena.index')
                ->with('success', 'La etnia indígena fue registrada correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.etnia_indigena.index')
                ->with('error', 'Ocurrió un error al registrar la etnia indígena: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $etniaIndigena = EtniaIndigena::findOrFail($id);
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        $existe = EtniaIndigena::where('nombre', $validated['nombre'])
            ->where('status', true)
            ->where('id', '!=', $etniaIndigena->id)
            ->exists();
        if ($existe) {
            return redirect()
                ->route('admin.etnia_indigena.index')
                ->with('error', 'Ya existe otra etnia indígena activa con este nombre.');
        }
        try {
            $etniaIndigena->nombre = $validated['nombre'];
            $etniaIndigena->save();
            return redirect()
                ->route('admin.etnia_indigena.index')
                ->with('success', 'La etnia indígena fue actualizada correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.etnia_indigena.index')
                ->with('error', 'Ocurrió un error al actualizar la etnia indígena: ' . $e->getMessage());
        }
    }

    public function verificarExistencia(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
            ]);
            $existe = EtniaIndigena::where('nombre', $request->nombre)
                ->where('status', true)
                ->exists();
            return response()->json([
                'success' => true,
                'existe' => $existe
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar la etnia indígena',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $etniaIndigena = EtniaIndigena::find($id);
        if ($etniaIndigena) {
            $etniaIndigena->update(['status' => false]);
            return redirect()
                ->route('admin.etnia_indigena.index')
                ->with('success', 'La etnia indígena fue eliminada correctamente.');
        }
        return redirect()
            ->route('admin.etnia_indigena.index')
            ->with('error', 'No se encontró la etnia indígena especificada.');
    }
}
