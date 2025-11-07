<?php

namespace App\Http\Controllers;

use App\Models\EtniaIndigena;
use Illuminate\Http\Request;

class EtniaIndigenaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etniaIndigena = EtniaIndigena::all();
        return view("admin.etnia_indigena.index", compact("etniaIndigena"));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $etniaIndigena = new EtniaIndigena();
        $etniaIndigena->nombre = $validated['nombre'];
        $etniaIndigena->status = true;
        $etniaIndigena->save();

        return redirect()->route('admin.etnia_indigena.index')->with('success', 'Etnia Indigena creado correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $etniaIndigena = EtniaIndigena::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        try {

            $etniaIndigena->nombre = $validated['nombre'];
            $etniaIndigena->save();

            return redirect()->route('admin.etnia_indigena.index')->with('success', 'Etnia Indigena actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.etnia_indigena.index')->with('error', 'Error al actualizar el etnia indigena: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $etniaIndigena = EtniaIndigena::find($id);
        if ($etniaIndigena) {
            $etniaIndigena->update([
                'status' => false,
            ]);
            return redirect()->route('admin.etnia_indigena.index')->with('success', 'Etnia Indigena eliminado correctamente.');
        }

        return redirect()->route('admin.etnia_indigena.index')->with('error', 'Etnia Indigena no encontrado.');
    }
}
