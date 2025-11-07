<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use App\Models\Estado;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = Estado::where('status', true)->get();
        $municipios = Municipio::all();
        return view('admin.municipio.index', compact('municipios','estados'));
    }

    public function createModal()
    {
        $estados = Estado::where('status', true)->get();
        return view('admin.municipio.modales.createModal', compact('estados'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'nombre_municipio' => 'required|string|max:255',
            'estado_id' => 'required|exists:estados,id',
        ]);
        try {

            $municipio = new Municipio();
            $municipio->nombre_municipio = $validated['nombre_municipio'];
            $municipio->estado_id = $validated['estado_id'];
            $municipio->status = true;
            $municipio->save();

            return redirect()->route('admin.municipio.index')->with('success', 'Municipio creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.municipio.index')->with('error', 'Error al crear el municipio: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Municipio $municipio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Municipio $municipio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $municipio = Municipio::findOrFail($id);

        $validated = $request->validate([
            'nombre_municipio' => 'required|string|max:255',
            'estado_id' => 'required|exists:estados,id',
        ]);
        try {

            $municipio->nombre_municipio = $validated['nombre_municipio'];
            $municipio->estado_id = $validated['estado_id'];
            $municipio->save();

            return redirect()->route('admin.municipio.index')->with('success', 'Municipio actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.municipio.index')->with('error', 'Error al actualizar el municipio: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $municipio = Municipio::find($id);
        if ($municipio) {
            $municipio->update([
                'status' => false,
            ]);
            return redirect()->route('admin.municipio.index')->with('success', 'Municipio eliminado correctamente.');
        }

        return redirect()->route('admin.municipio.index')->with('error', 'Municipio no encontrado.');
    }
}
