<?php

namespace App\Http\Controllers;

use App\Models\EstudiosRealizado;
use Illuminate\Http\Request;

class EstudiosRealizadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estudiosRealizados = EstudiosRealizado::where('status', true)->orderBy('estudios', 'asc')->paginate(10);
        return view('admin.estudios_realizados.index', compact('estudiosRealizados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'estudios' => 'required|string|max:255',
        ]);

        // Verificar si ya existe un área de formación activa con el mismo nombre
        $existe = EstudiosRealizado::where('estudios', $validated['estudios'])
            ->where('status', true)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.estudios_realizados.index')
                ->with('error', 'Ya existe un área de formación activa con este nombre.');
        }

        try {
            $estudiosRealizados = new EstudiosRealizado();
            $estudiosRealizados->estudios = $validated['estudios'];
            $estudiosRealizados->status = true;
            $estudiosRealizados->save();

            return redirect()
                ->route('admin.estudios_realizados.index')
                ->with('success', 'Estudio realizado creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.estudios_realizados.index')
                ->with('error', 'Error al crear el estudio realizado: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $estudiosRealizados = EstudiosRealizado::findOrFail($id);

        $validated = $request->validate([
            'estudios' => 'required|string|max:255',
        ]);

        // Verificar si ya existe otra área de formación activa con el mismo nombre
        $existe = EstudiosRealizado::where('estudios', $validated['estudios'])
            ->where('status', true)
            ->where('id', '!=', $estudiosRealizados->id)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.estudios_realizados.index')
                ->with('error', 'Ya existe un estudio realizado activo con este nombre.');
        }

        try {
            $estudiosRealizados->estudios = $validated['estudios'];
            $estudiosRealizados->save();

            return redirect()
                ->route('admin.estudios_realizados.index')
                ->with('success', 'Estudio realizado actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.estudios_realizados.index')
                ->with('error', 'Error al actualizar el estudio realizado: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Buscar el registro a desactivar
        $estudiosRealizados = EstudiosRealizado::find($id);

        if ($estudiosRealizados) {
            // Cambiar el estado a inactivo
            $estudiosRealizados->update(['status' => false]);

            // Mensaje de éxito para el usuario
            return redirect()
                ->route('admin.estudios_realizados.index')
                ->with('success', 'El estudio realizado fue eliminado correctamente.');
        }

        // Mensaje si el registro no existe
        return redirect()
            ->route('admin.estudios_realizados.index')
            ->with('error', 'No se encontró el estudio realizado especificado.');
    }
}
