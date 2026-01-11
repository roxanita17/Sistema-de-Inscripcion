<?php

namespace App\Http\Controllers;

use App\Models\ExpresionLiteraria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\AnioEscolar;

class ExpresionLiterariaController extends Controller
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
                'letra_expresion_literaria' => ['required', 'regex:/^[A-Za-z]$/', 'max:1'],
            ]);
            
            $letra = strtoupper($request->letra_expresion_literaria);
            
            $existe = ExpresionLiteraria::where('letra_expresion_literaria', $letra)
                ->where('status', true)
                ->exists();

            return response()->json([
                'success' => true,
                'existe' => $existe
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en verificarExistencia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar la expresión literaria',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $expresionLiteraria = ExpresionLiteraria::where('status', true)
            ->orderBy('letra_expresion_literaria', 'asc')
            ->paginate(10);

        $anioEscolarActivo = $this->verificarAnioEscolar();

        return view('admin.expresion_literaria.index', compact('expresionLiteraria', 'anioEscolarActivo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'letra_expresion_literaria' => ['required', 'regex:/^[A-Za-z]$/', 'max:1'],
        ]);

        $existe = ExpresionLiteraria::where('letra_expresion_literaria', $validated['letra_expresion_literaria'])
            ->where('status', true)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('error', 'Ya existe una expresión literaria activa con este valor.');
        }

        try {
            ExpresionLiteraria::create([
                'letra_expresion_literaria' => strtoupper($request->letra_expresion_literaria),
                'status' => 1,
            ]);

            info('Se ha creado una nueva expresión literaria: ' . strtoupper($request->letra_expresion_literaria));

            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('success', 'Expresión literaria creada exitosamente.');
        } catch (\Exception $e) {
            info('Error al crear una nueva expresión literaria: ' . $e->getMessage());

            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('error', 'Error al crear la expresión literaria: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $expresionLiteraria = ExpresionLiteraria::findOrFail($id);
        $validated = $request->validate([
            'letra_expresion_literaria' => ['required', 'regex:/^[A-Za-z]$/', 'max:1'],
        ]);

        $existe = ExpresionLiteraria::where('letra_expresion_literaria', $validated['letra_expresion_literaria'])
            ->where('status', true)
            ->where('id', '!=', $expresionLiteraria->id)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('error', 'Ya existe otra expresión literaria activa con este valor.');
        }

        try {
            $expresionLiteraria->update([
                'letra_expresion_literaria' => strtoupper($validated['letra_expresion_literaria']),
            ]);

            info('Expresión literaria actualizada: ID ' . $expresionLiteraria->id);

            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('success', 'Expresión literaria actualizada correctamente.');
        } catch (\Exception $e) {
            info('Error al actualizar expresión literaria con ID ' . $expresionLiteraria->id . ': ' . $e->getMessage());

            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('error', 'Error al actualizar la expresión literaria: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $expresionLiteraria = ExpresionLiteraria::findOrFail($id);
            $expresionLiteraria->update(['status' => false]);

            info('Expresión literaria eliminada (inactiva): ID ' . $expresionLiteraria->id);

            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('success', 'Expresión literaria eliminada correctamente.');
        } catch (\Exception $e) {
            info('Error al eliminar expresión literaria con ID ' . $id . ': ' . $e->getMessage());

            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('error', 'Error al eliminar la expresión literaria: ' . $e->getMessage());
        }
    }
}
