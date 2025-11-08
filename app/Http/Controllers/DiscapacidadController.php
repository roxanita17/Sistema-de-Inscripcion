<?php

namespace App\Http\Controllers;

use App\Models\Discapacidad;
use Illuminate\Http\Request;

class DiscapacidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discapacidad = Discapacidad::orderBy('nombre_discapacidad', 'asc')->get();
        return view('admin.discapacidad.index', compact('discapacidad'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_discapacidad' => 'required|string|max:255',
        ]);

        $discapacidad = new Discapacidad();
        $discapacidad->nombre_discapacidad = $validated['nombre_discapacidad'];
        $discapacidad->status = true;
        $discapacidad->save();

        return redirect()->route('admin.discapacidad.index')->with('success', 'Discapacidad creado correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $discapacidad = Discapacidad::findOrFail($id);

        $validated = $request->validate([
            'nombre_discapacidad' => 'required|string|max:255',
        ]);
        try {

            $discapacidad->nombre_discapacidad = $validated['nombre_discapacidad'];
            $discapacidad->save();

            return redirect()->route('admin.discapacidad.index')->with('success', 'Discapacidad actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.discapacidad.index')->with('error', 'Error al actualizar la discapacidad: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $discapacidad = Discapacidad::find($id);
        if ($discapacidad) {
            $discapacidad->update([
                'status' => false,
            ]);
            return redirect()->route('admin.discapacidad.index')->with('success', 'Discapacidad eliminado correctamente.');
        }

        return redirect()->route('admin.discapacidad.index')->with('error', 'Discapacidad no encontrado.');
    }
}
