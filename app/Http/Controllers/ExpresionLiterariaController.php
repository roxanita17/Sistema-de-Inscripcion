<?php

namespace App\Http\Controllers;

use App\Models\ExpresionLiteraria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Para registrar mensajes en la terminal

class ExpresionLiterariaController extends Controller
{
    /**
     * Muestra la lista de todas las expresiones literarias registradas.
     */
    public function index()
    {
        // Se obtienen todas las expresiones literarias ordenadas alfabéticamente
        $expresionLiteraria = ExpresionLiteraria::orderBy('letra_expresion_literaria', 'asc')->get();

        // Se retorna la vista principal con los datos
        return view('admin.expresion_literaria.index', compact('expresionLiteraria'));
    }

    /**
     * Guarda una nueva expresión literaria en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación del campo, debe ser una sola letra del alfabeto
        $request->validate([
            'letra_expresion_literaria' => ['required', 'regex:/^[A-Za-z]$/', 'max:1'],
        ]);

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
        $request->validate([
            'letra_expresion_literaria' => ['required', 'regex:/^[A-Za-z]$/', 'max:1'],
        ]);

        try {   
            // Se actualiza la letra de la expresión
            $expresionLiteraria->update([
                'letra_expresion_literaria' => strtoupper($request->letra_expresion_literaria),
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
            info('Error al eliminar expresión literaria con ID ' . $expresionLiteraria->id . ': ' . $e->getMessage());

            // Mensaje de error al usuario
            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('error', 'Error al eliminar la expresión literaria: ' . $e->getMessage());
        }
    }
}
