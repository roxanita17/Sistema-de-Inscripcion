<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use Illuminate\Http\Request;

class GradoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grados = Grado::all();
        return view('admin.grado.index', compact('grados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero_grado' => 'required|digits_between:1,4',
        ]);
        try {

            $grado = new Grado();
            $grado->numero_grado = $validated['numero_grado'];
            $grado->status = true;
            $grado->save();

            return redirect()->route('admin.grado.index')->with('success', 'Grado creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.grado.index')->with('error', 'Error al crear el grado: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
                $grado = Grado::findOrFail($id);

        $validated = $request->validate([
            'numero_grado' => 'required|digits_between:1,4|unique:grados,numero_grado,' . $grado->id,
        ]);
        try {

            $grado->numero_grado = $validated['numero_grado'];
            $grado->save();

            return redirect()->route('admin.grado.index')->with('success', 'Grado actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.grado.index')->with('error', 'Error al actualizar el grado: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $grado = Grado::find($id);
        if ($grado) {
            $grado->update([
                'status' => false,
            ]);
            return redirect()->route('admin.grado.index')->with('success', 'Grado eliminado correctamente.');
        }

        return redirect()->route('admin.grado.index')->with('error', 'Grado no encontrado.');
    }
}
