<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use Illuminate\Http\Request;
use Livewire\WithPagination;


class PaisController extends Controller
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public function index()
    {
        $paises = Pais::orderBy('nameES', 'asc')->Paginate(10);
        return view('admin.pais.index', compact('paises'));
    }

    public function update(Request $request, $id)
    {
        $paises = Pais::findOrFail($id);
        $validated = $request->validate([
            'nombre_estado' => 'required|string|max:255',
        ]);
        $existe = Pais::where('nombre_pais', $validated['nombre_pais'])
            ->where('status', true)
            ->where('id', '!=', $paises->id)
            ->exists();
        if ($existe) {
            return redirect()
                ->route('admin.pais.index')
                ->with('error', 'Ya existe otro estado activo con este nombre.');
        }
        try {
            $paises->nombre_pais = $validated['nombre_pais'];
            $paises->save();
            info('El país con ID ' . $id . ' ha sido actualizado correctamente.');
            return redirect()
                ->route('admin.pais.index')
                ->with('success', 'País actualizado exitosamente.');
        } catch (\Exception $e) {
            info('Error al actualizar el país con ID ' . $id . ': ' . $e->getMessage());
            return redirect()
                ->route('admin.pais.index')
                ->with('error', 'Error al actualizar el país: ' . $e->getMessage());
        }
    }

    public function verificarExistencia(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
            ]);
            $existe = Pais::where('nombre_pais', $request->nombre)
                ->where('status', true)
                ->exists();
            return response()->json([
                'success' => true,
                'existe' => $existe
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar el estado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $estado = Pais::find($id);
        if ($estado) {
            $estado->update(['status' => false]);
            info('El país "' . $estado->nombre_pais . '" ha sido marcado como inactivo.');
            return redirect()
                ->route('admin.pais.index')
                ->with('success', 'País eliminado correctamente.');
        }
        info('No se encontró el país con ID ' . $id . ' para eliminar.');
        return redirect()
            ->route('admin.pais.index')
            ->with('error', 'País no encontrado.');
    }
}
