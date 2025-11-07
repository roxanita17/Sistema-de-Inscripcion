<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados = Estado::all();
        return view('admin.estado.index', compact('estados'));
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
            'nombre_estado' => 'required|string|max:255',
        ]);
        try {

            $estado = new Estado();
            $estado->nombre_estado = $validated['nombre_estado'];
            $estado->status = true;
            $estado->save();

            return redirect()->route('admin.estado.index')->with('success', 'Estado creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.estado.index')->with('error', 'Error al crear el estado: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Estado $estado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estado $estado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estado $estado,$id)
    {
        $estado = Estado::findOrFail($id);

        $validated = $request->validate([
            'nombre_estado' => 'required|string|max:255',
        ]);
        try {

            $estado->nombre_estado = $validated['nombre_estado'];
            $estado->save();

            return redirect()->route('admin.estado.index')->with('success', 'Estado actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.estado.index')->with('error', 'Error al actualizar el estado: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estado $estado,$id)
    {
        $estado = Estado::find($id);
        if ($estado) {
            $estado->update([
                'status' => false,
            ]);
            return redirect()->route('admin.estado.index')->with('success', 'Estado eliminado correctamente.');
        }

        return redirect()->route('admin.estado.index')->with('error', 'Estado no encontrado.');
    }
}
