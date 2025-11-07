<?php

namespace App\Http\Controllers;

use App\Models\AnioEscolar;
use Illuminate\Http\Request;

class AnioEscolarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $escolar = AnioEscolar::all();
        return view('admin.anio_escolar.index', compact('escolar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inicio_anio_escolar' => 'required',
            'cierre_anio_escolar' => 'required',
        ]);

        $anioEscolar = new AnioEscolar();
        $anioEscolar->inicio_anio_escolar = $validated['inicio_anio_escolar'];
        $anioEscolar->cierre_anio_escolar = $validated['cierre_anio_escolar'];
        $anioEscolar->status = 'Activo';
        $anioEscolar->save();

        return redirect()->route('admin.anio_escolar.index')->with('success', 'Anio creado correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function extender(Request $request, $id)
    {
        $anioEscolar = AnioEscolar::findOrFail($id);

        $validated = $request->validate([
            'cierre_anio_escolar' => 'required|date|after_or_equal:' . $anioEscolar->inicio_anio_escolar,
        ]);

        $anioEscolar->cierre_anio_escolar = $validated['cierre_anio_escolar'];
        $anioEscolar->status = 'Extendido';
        $anioEscolar->save();

        return redirect()->route('admin.anio_escolar.index')->with('success', 'Año escolar actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $anioEscolar = AnioEscolar::find($id);
        if ($anioEscolar) {
            $anioEscolar->update([
                'status' => 'Inactivo',
            ]);
            return redirect()->route('admin.anio_escolar.index')->with('success', 'Anio eliminado correctamente.');
        }

        return redirect()->route('admin.anio_escolar.index')->with('error', 'Anio no encontrado.');
    }
}
