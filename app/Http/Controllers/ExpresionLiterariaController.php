<?php

namespace App\Http\Controllers;

use App\Models\ExpresionLiteraria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Para registrar mensajes en la terminal

class ExpresionLiterariaController extends Controller
{
        /**
     * Verifica si hay un año escolar activo
     */
    private function verificarAnioEscolar()
    {
        return \App\Models\AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();
    }
    
    /**
     * Verifica si ya existe una expresión literaria con la letra proporcionada
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verificarExistencia(Request $request)
    {
        try {
            $request->validate([
                'letra_expresion_literaria' => ['required', 'regex:/^[A-Za-z]$/', 'max:1'],
            ]);
            
            // Convertir a mayúscula para la verificación
            $letra = strtoupper($request->letra_expresion_literaria);
            
            // Verificar si ya existe una expresión literaria activa con esta letra
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

    /**
     * Muestra la lista de todas las expresiones literarias registradas.
     */
    public function index()
    {
        // Se obtienen todas las expresiones literarias ordenadas alfabéticamente
        $expresionLiteraria = ExpresionLiteraria::where('status', true)
            ->orderBy('letra_expresion_literaria', 'asc')
            ->paginate(10);

        // Verificar si hay año escolar activo
        $anioEscolarActivo = $this->verificarAnioEscolar();

        // Se retorna la vista principal con los datos
        return view('admin.expresion_literaria.index', compact('expresionLiteraria', 'anioEscolarActivo'));
    }

    /**
     * Guarda una nueva expresión literaria en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación del campo, debe ser una sola letra del alfabeto
        $validated = $request->validate([
            'letra_expresion_literaria' => ['required', 'regex:/^[A-Za-z]$/', 'max:1'],
        ]);

        // Si existe uno con "status = true", no se permite crear un duplicado.
        $existe = ExpresionLiteraria::where('letra_expresion_literaria', $validated['letra_expresion_literaria'])
            ->where('status', true)
            ->exists();

        // Si se encuentra un duplicado activo, se impide la actualización.
        if ($existe) {
            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('error', 'Ya existe una expresión literaria activa con este valor.');
        }

        try {
            // Se crea el registro con la letra en mayúscula
            ExpresionLiteraria::create([
                'letra_expresion_literaria' => strtoupper($request->letra_expresion_literaria),
                'status' => 1,
            ]);

            // Se registra la acción en la terminal
            info('Se ha creado una nueva expresión literaria: ' . strtoupper($request->letra_expresion_literaria));

            // Mensaje para el usuario
            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('success', 'Expresión literaria creada exitosamente.');
        } catch (\Exception $e) {
            // Registro del error en la terminal
            info('Error al crear una nueva expresión literaria: ' . $e->getMessage());

            // Mensaje de error para el usuario
            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('error', 'Error al crear la expresión literaria: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza una expresión literaria existente.
     */
    public function update(Request $request, $id)
    {
        $expresionLiteraria = ExpresionLiteraria::findOrFail($id);
        // Validación: debe ser una sola letra
        $validated = $request->validate([
            'letra_expresion_literaria' => ['required', 'regex:/^[A-Za-z]$/', 'max:1'],
        ]);

        // Se verifica si existe otro registro activo con el mismo número de prefijo,
        // excluyendo el registro actual (para evitar conflictos al editar).
        $existe = ExpresionLiteraria::where('letra_expresion_literaria', $validated['letra_expresion_literaria'])
            ->where('status', true)
            ->where('id', '!=', $expresionLiteraria->id)
            ->exists();

        // Si se encuentra un duplicado activo, se impide la actualización.
        if ($existe) {
            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('error', 'Ya existe otra expresión literaria activa con este valor.');
        }

        try {   
            // Se actualiza la letra de la expresión
            $expresionLiteraria->update([
                'letra_expresion_literaria' => strtoupper($validated['letra_expresion_literaria']),
            ]);

            // Registro en la terminal
            info('Expresión literaria actualizada: ID ' . $expresionLiteraria->id);

            // Mensaje para el usuario
            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('success', 'Expresión literaria actualizada correctamente.');
        } catch (\Exception $e) {
            // Registro del error en la terminal
            info('Error al actualizar expresión literaria con ID ' . $expresionLiteraria->id . ': ' . $e->getMessage());

            // Mensaje visible al usuario
            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('error', 'Error al actualizar la expresión literaria: ' . $e->getMessage());
        }
    }

    /**
     * Marca una expresión literaria como inactiva (eliminación lógica).
     */
    public function destroy($id)
    {
        try {
            $expresionLiteraria = ExpresionLiteraria::findOrFail($id);
            // Se marca el registro como inactivo
            $expresionLiteraria->update(['status' => false]);

            // Mensaje en la terminal
            info('Expresión literaria eliminada (inactiva): ID ' . $expresionLiteraria->id);

            // Mensaje para el usuario
            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('success', 'Expresión literaria eliminada correctamente.');
        } catch (\Exception $e) {
            // Registro de error
            info('Error al eliminar expresión literaria con ID ' . $id . ': ' . $e->getMessage());

            // Mensaje de error al usuario
            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('error', 'Error al eliminar la expresión literaria: ' . $e->getMessage());
        }
    }
}
