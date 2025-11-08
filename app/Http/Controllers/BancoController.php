<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bancos = Banco::orderBy('codigo_banco', 'asc')->get();
        return view('admin.banco.index', compact('bancos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_banco' => 'required|digits_between:1,4|unique:bancos,codigo_banco',

            'nombre_banco' => 'required|string|max:255',
        ]);
        try {

            $banco = new Banco();
            $banco->codigo_banco = $validated['codigo_banco'];
            $banco->nombre_banco = $validated['nombre_banco'];
            $banco->status = true;
            $banco->save();

            return redirect()->route('admin.banco.index')->with('success', 'Banco creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.banco.index')->with('error', 'Error al crear el banco: ' . $e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $banco = Banco::findOrFail($id);

        $validated = $request->validate([
            'codigo_banco' => 'required|digits_between:1,4|unique:bancos,codigo_banco,' . $banco->id,

            'nombre_banco' => 'required|string|max:255',
        ]);
        try {

            $banco->codigo_banco = $validated['codigo_banco'];
            $banco->nombre_banco = $validated['nombre_banco'];
            $banco->save();

            return redirect()->route('admin.banco.index')->with('success', 'Banco actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('admin.banco.index')->with('error', 'Error al actualizar el banco: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banco = Banco::find($id);
        if ($banco) {
            $banco->update([
                'status' => false,
            ]);
            return redirect()->route('admin.banco.index')->with('success', 'Banco eliminado correctamente.');
        }

        return redirect()->route('admin.banco.index')->with('error', 'Banco no encontrado.');
    }
}
