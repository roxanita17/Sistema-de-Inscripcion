<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use Illuminate\Http\Request;
use Livewire\WithPagination;


class PaisController extends Controller
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Se obtienen todos los países ordenados alfabéticamente por su nombre
        $paises = Pais::orderBy('nameES', 'asc')->Paginate(10);

        // Se retorna la vista con los registros encontrados
        return view('admin.pais.index', compact('paises'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Se busca el registro existente por su ID
        $paises = Pais::findOrFail($id);

        // Se validan los datos recibidos desde el formulario
        $validated = $request->validate([
            'nombre_estado' => 'required|string|max:255',
        ]);

        // Verificar si ya existe otro estado activo con el mismo nombre
        $existe = Pais::where('nombre_pais', $validated['nombre_pais'])
            ->where('status', true)
            ->where('id', '!=', $paises->id)
            ->exists();

        if ($existe) {
            // Si existe otro estado activo con el mismo nombre, se muestra un mensaje de error
            return redirect()
                ->route('admin.pais.index')
                ->with('error', 'Ya existe otro estado activo con este nombre.');
        }

        try {
            // Se actualiza el nombre del estado con el valor validado
            $paises->nombre_pais = $validated['nombre_pais'];
            $paises->save();

            // Mensaje en la terminal confirmando la actualización
            info('El país con ID ' . $id . ' ha sido actualizado correctamente.');
            // Se redirige con mensaje de éxito
            return redirect()
                ->route('admin.pais.index')
                ->with('success', 'País actualizado exitosamente.');
        } catch (\Exception $e) {
            // Mensaje en la terminal si ocurre un error
            info('Error al actualizar el país con ID ' . $id . ': ' . $e->getMessage());

            // Se redirige con mensaje de error
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
            \Log::error('Error en verificarExistencia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar el estado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Se busca el estado por su ID
        $estado = Pais::find($id);

        // Si se encuentra el registro, se actualiza su estatus a inactivo
        if ($estado) {
            $estado->update(['status' => false]);

            // Mensaje en la terminal para seguimiento
            info('El país "' . $estado->nombre_pais . '" ha sido marcado como inactivo.');

            // Se redirige con mensaje de éxito visible al usuario
            return redirect()
                ->route('admin.pais.index')
                ->with('success', 'País eliminado correctamente.');
        }

        // Si el registro no existe, se informa en la terminal
        info('No se encontró el país con ID ' . $id . ' para eliminar.');

        // Y se redirige con mensaje de error
        return redirect()
            ->route('admin.pais.index')
            ->with('error', 'País no encontrado.');
    }
}
