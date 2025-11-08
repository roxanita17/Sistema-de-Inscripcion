<?php

namespace App\Http\Controllers;

use App\Models\AreaFormacion;
use Illuminate\Http\Request;

class AreaFormacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areaFormacion = AreaFormacion::orderBy('nombre_area_formacion', 'asc')->get();
        return view('admin.area_formacion.index', compact('areaFormacion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_area_formacion' => 'required|string|max:255',
        ]);
        try {

            $areaFormacion = new AreaFormacion();
            $areaFormacion->nombre_area_formacion = $validated['nombre_area_formacion'];
            $areaFormacion->status = true;
            $areaFormacion->save();

            return redirect()->route('admin.area_formacion.index')->with('success', 'Area de formación creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.area_formacion.index')->with('error', 'Error al crear el area de formación: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $areaFormacion = AreaFormacion::findOrFail($id);

        $validated = $request->validate([
            'nombre_area_formacion' => 'required|string|max:255|unique:area_formacions,nombre_area_formacion,' . $areaFormacion->id,
        ]);
        try {

            $areaFormacion->nombre_area_formacion = $validated['nombre_area_formacion'];
            $areaFormacion->save();

            return redirect()->route('admin.area_formacion.index')->with('success', 'Area de formación actualizada exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.area_formacion.index')->with('error', 'Error al actualizar el area de formación: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $areaFormacion = AreaFormacion::find($id);
        if ($areaFormacion) {
            $areaFormacion->update([
                'status' => false,
            ]);
            return redirect()->route('admin.area_formacion.index')->with('success', 'Area de formación eliminada correctamente.');
        }

        return redirect()->route('admin.area_formacion.index')->with('error', 'Area de formación no encontrada.');
    }
}
