<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    /**
     * Muestra el listado completo de bancos registrados.
     */
    public function index()
    {
        // Se obtienen todos los bancos ordenados por código
        $bancos = Banco::orderBy('codigo_banco', 'asc')->get();

        // Se envían los datos a la vista
        return view('admin.banco.index', compact('bancos'));
    }

    /**
     * Crea un nuevo registro de banco.
     */
    public function store(Request $request)
    {
        // Validación de campos
        $validated = $request->validate([
            'codigo_banco' => 'required|digits_between:1,4',
            'nombre_banco' => 'required|string|max:255',
        ]);

        // Verificar si ya existe un banco activo con el mismo código
        $existe = Banco::where('codigo_banco', $validated['codigo_banco'])
            ->where('status', true)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.banco.index')
                ->with('error', 'Ya existe un banco activo con este código.');
        }

        try {
            $banco = new Banco();
            $banco->codigo_banco = $validated['codigo_banco'];
            $banco->nombre_banco = $validated['nombre_banco'];
            $banco->status = true;
            $banco->save();

            return redirect()
                ->route('admin.banco.index')
                ->with('success', 'Banco creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.banco.index')
                ->with('error', 'Error al crear el banco: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza los datos de un banco existente.
     */
    public function update(Request $request, $id)
    {
        $banco = Banco::findOrFail($id);

        $validated = $request->validate([
            'codigo_banco' => 'required|digits_between:1,4',
            'nombre_banco' => 'required|string|max:255',
        ]);

        // Verificar si ya existe otro banco activo con el mismo código
        $existe = Banco::where('codigo_banco', $validated['codigo_banco'])
            ->where('status', true)
            ->where('id', '!=', $banco->id)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.banco.index')
                ->with('error', 'Ya existe otro banco activo con este código.');
        }

        try {
            $banco->codigo_banco = $validated['codigo_banco'];
            $banco->nombre_banco = $validated['nombre_banco'];
            $banco->save();

            return redirect()
                ->route('admin.banco.index')
                ->with('success', 'Banco actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.banco.index')
                ->with('error', 'Error al actualizar el banco: ' . $e->getMessage());
        }
    }

    /**
     * Realiza una baja lógica de un banco.
     */
    public function destroy($id)
    {
        try {
            $banco = Banco::find($id);

            if ($banco) {
                $banco->update(['status' => false]);

                return redirect()
                    ->route('admin.banco.index')
                    ->with('success', 'Banco eliminado correctamente.');
            }

            return redirect()
                ->route('admin.banco.index')
                ->with('error', 'Banco no encontrado.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.banco.index')
                ->with('error', 'Error al eliminar el banco: ' . $e->getMessage());
        }
    }
}
