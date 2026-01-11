<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    private function verificarAnioEscolar()
    {
        return \App\Models\AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();
    }

    public function index()
    {
        $bancos = Banco::where('status', true)->orderBy('nombre_banco', 'asc')->paginate(10);
        $anioEscolarActivo = $this->verificarAnioEscolar();
        return view('admin.banco.index', compact('bancos', 'anioEscolarActivo'));
    }   

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_banco' => 'required|digits_between:1,4',
            'nombre_banco' => 'required|string|max:255',
        ]);
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

    public function update(Request $request, $id)
    {
        $banco = Banco::findOrFail($id);
        $validated = $request->validate([
            'codigo_banco' => 'required|digits_between:1,4',
            'nombre_banco' => 'required|string|max:255',
        ]);
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

    public function verificarExistencia(Request $request)
    {
        try {
            $request->validate([
                'codigo' => 'nullable|digits_between:1,4',
                'nombre' => 'nullable|string|max:255',
            ]);
            $query = Banco::where('status', true);
            if ($request->has('codigo') && $request->codigo) {
                $query->where('codigo_banco', $request->codigo);
            }
            if ($request->has('nombre') && $request->nombre) {
                $query->where('nombre_banco', $request->nombre);
            }
            $existe = $query->exists();
            $mensaje = '';
            if ($existe) {
                if ($request->has('codigo') && $request->has('nombre') && $request->codigo && $request->nombre) {
                    $mensaje = 'Ya existe un banco activo con este código y nombre.';
                } elseif ($request->has('codigo') && $request->codigo) {
                    $mensaje = 'Ya existe un banco activo con este código.';
                } elseif ($request->has('nombre') && $request->nombre) {
                    $mensaje = 'Ya existe un banco activo con este nombre.';
                }
            }
            return response()->json([
                'success' => true,
                'existe' => $existe,
                'mensaje' => $mensaje
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar el banco',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}