<?php

namespace App\Http\Controllers;

use App\Models\PrefijoTelefono;
use Illuminate\Http\Request;
use App\Models\AnioEscolar;

class PrefijoTelefonoController extends Controller
{
    private function verificarAnioEscolar()
    {
        return AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();
    }

    public function index()
    {
        $prefijos = PrefijoTelefono::where('status', true)
            ->orderBy('prefijo', 'asc')
            ->paginate(10);

        $anioEscolarActivo = $this->verificarAnioEscolar();

        return view('admin.prefijo_telefono.index', compact('prefijos', 'anioEscolarActivo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prefijo' => 'required|digits_between:1,4',
        ]);

        $existe = PrefijoTelefono::where('prefijo', $validated['prefijo'])
            ->where('status', true)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.prefijo_telefono.index')
                ->with('error', 'Este prefijo ya existe y está activo.');
        }

        try {
            $prefijo = new PrefijoTelefono();
            $prefijo->prefijo = $validated['prefijo'];
            $prefijo->status = true;
            $prefijo->save();

            return redirect()
                ->route('admin.prefijo_telefono.index')
                ->with('success', 'Prefijo creado correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.prefijo_telefono.index')
                ->with('error', 'Ocurrió un error al crear el prefijo: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $prefijo = PrefijoTelefono::findOrFail($id);
        $validated = $request->validate([
            'prefijo' => 'required|digits_between:1,4',
        ]);

        $existe = PrefijoTelefono::where('prefijo', $validated['prefijo'])
            ->where('status', true)
            ->where('id', '!=', $prefijo->id)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.prefijo_telefono.index')
                ->with('error', 'Ya existe otro prefijo activo con este valor.');
        }

        try {
            $prefijo->prefijo = $validated['prefijo'];
            $prefijo->save();

            return redirect()
                ->route('admin.prefijo_telefono.index')
                ->with('success', 'Prefijo actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.prefijo_telefono.index')
                ->with('error', 'Ocurrió un error al actualizar el prefijo: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $prefijo = PrefijoTelefono::find($id);

        if ($prefijo) {
            $prefijo->update(['status' => false]);

            return redirect()
                ->route('admin.prefijo_telefono.index')
                ->with('success', 'Prefijo eliminado correctamente.');
        }

        return redirect()
            ->route('admin.prefijo_telefono.index')
            ->with('error', 'El prefijo no fue encontrado.');
    }

    public function verificarExistencia(Request $request)
    {
        try {
            $request->validate([
                'prefijo' => 'required|digits_between:1,4',
            ]);

            $existe = PrefijoTelefono::where('prefijo', $request->prefijo)
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
                'message' => 'Error al verificar el prefijo',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
