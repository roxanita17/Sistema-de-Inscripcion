<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use App\Models\Municipio;
use App\Models\Estado;
use Illuminate\Http\Request;

class LocalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $municipios = Municipio::where('status', true)->get();
        $estados = Estado::where('status', true)->get();

        // 👇 Aquí está la corrección
        $localidades = Localidad::with(['estado', 'municipio'])->get();

        return view('admin.localidad.index', compact('localidades', 'municipios', 'estados'));
    }


    public function createModal()
    {
        $municipios = Municipio::where('status', true)->get();
        $estados = Estado::where('status', true)->get();
        return view('admin.localidad.modales.createModal', compact('municipios','estados'));
    }

    /**
     * Obtener localidades por municipio
     */
    public function getByMunicipio($municipio_id)
    {
        $localidades = Localidad::where('municipio_id', $municipio_id)
                                ->where('status', true)
                                ->get(['id', 'nombre_localidad']);

        return response()->json($localidades);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_localidad' => 'required|string|max:255',
            'municipio_id' => 'required|exists:municipios,id',
        ]);
        try {

            $localidad = new Localidad();
            $localidad->nombre_localidad = $validated['nombre_localidad'];
            $localidad->municipio_id = $validated['municipio_id'];
            $localidad->status = true;
            $localidad->save();

            return redirect()->route('admin.localidad.index')->with('success', 'Localidad creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.localidad.index')->with('error', 'Error al crear la localidad: ' . $e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Localidad $localidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Localidad $localidad)
    {
        //
    }
}