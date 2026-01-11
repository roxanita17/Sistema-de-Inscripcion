<?php

namespace App\Http\Controllers;

use App\Models\EstudiosRealizado;
use Illuminate\Http\Request;
use App\Models\AnioEscolar;

class EstudiosRealizadoController extends Controller
{
    private function verificarAnioEscolar()
    {
        return AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();
    }

    public function verificarExistencia(Request $request)
    {
        try {
            $request->validate([
                'estudios' => 'required|string|max:255',
            ]);

            $existe = EstudiosRealizado::where('estudios', $request->estudios)
                ->where('status', true)
                ->exists();

            return response()->json([
                'success' => true,
                'existe' => $existe
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar el estudio realizado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $buscar = request('buscar');

        $query = EstudiosRealizado::query();

        if (!empty($buscar)) {
            $query->where(function ($q) use ($buscar) {
                $q->where('estudios', 'LIKE', "%{$buscar}%")
                    ->orWhere('id', 'LIKE', "%{$buscar}%");
            });
        }

        $estudiosRealizados = $query->orderBy('estudios', 'asc')
            ->paginate(10)
            ->appends(request()->query());

        $anioEscolarActivo = $this->verificarAnioEscolar();

        return view('admin.estudios_realizados.index', compact(
            'estudiosRealizados',
            'anioEscolarActivo',
            'buscar'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'estudios' => 'required|string|max:255',
        ]);

        $existe = EstudiosRealizado::where('estudios', $validated['estudios'])
            ->where('status', true)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.estudios_realizados.index')
                ->with('error', 'Ya existe un área de formación activa con este nombre.');
        }

        try {
            $estudiosRealizados = new EstudiosRealizado();
            $estudiosRealizados->estudios = $validated['estudios'];
            $estudiosRealizados->status = true;
            $estudiosRealizados->save();

            return redirect($request->redirect_to ?? route('admin.estudios_realizados.index'))
                ->with('success', 'Estudio realizado creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.estudios_realizados.index')
                ->with('error', 'Error al crear el estudio realizado: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $estudiosRealizados = EstudiosRealizado::findOrFail($id);

        $validated = $request->validate([
            'estudios' => 'required|string|max:255',
        ]);

        $existe = EstudiosRealizado::where('estudios', $validated['estudios'])
            ->where('status', true)
            ->where('id', '!=', $estudiosRealizados->id)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.estudios_realizados.index')
                ->with('error', 'Ya existe un estudio realizado activo con este nombre.');
        }

        try {
            $estudiosRealizados->estudios = $validated['estudios'];
            $estudiosRealizados->save();

            return redirect()
                ->route('admin.estudios_realizados.index')
                ->with('success', 'Estudio realizado actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.estudios_realizados.index')
                ->with('error', 'Error al actualizar el estudio realizado: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $estudiosRealizados = EstudiosRealizado::find($id);

        if ($estudiosRealizados) {
            $estudiosRealizados->update(['status' => false]);

            return redirect()
                ->route('admin.estudios_realizados.index')
                ->with('success', 'El estudio realizado fue eliminado correctamente.');
        }

        return redirect()
            ->route('admin.estudios_realizados.index')
            ->with('error', 'No se encontró el estudio realizado especificado.');
    }
}
