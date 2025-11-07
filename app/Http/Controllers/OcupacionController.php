<?php

namespace App\Http\Controllers;

use App\Models\Ocupacion;
use Illuminate\Http\Request;

class OcupacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ocupacion = Ocupacion::all();
        return view("admin.ocupacion.index", compact("ocupacion"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_ocupacion' => 'required|string|max:255',
        ]);

        $ocupacion = new Ocupacion();
        $ocupacion->nombre_ocupacion = $validated['nombre_ocupacion'];
        $ocupacion->status = true;
        $ocupacion->save();

        return redirect()->route('admin.ocupacion.index')->with('success', 'Ocupacion creado correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $ocupacion = Ocupacion::findOrFail($id);

        $validated = $request->validate([
            'nombre_ocupacion' => 'required|string|max:255',
        ]);
        try {

            $ocupacion->nombre_ocupacion = $validated['nombre_ocupacion'];
            $ocupacion->save();

            return redirect()->route('admin.ocupacion.index')->with('success', 'Ocupacion actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.ocupacion.index')->with('error', 'Error al actualizar el ocupacion: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ocupacion = Ocupacion::find($id);
        if ($ocupacion) {
            $ocupacion->update([
                'status' => false,
            ]);
            return redirect()->route('admin.ocupacion.index')->with('success', 'Ocupacion eliminado correctamente.');
        }

        return redirect()->route('admin.ocupacion.index')->with('error', 'Ocupacion no encontrado.');
    }
}
