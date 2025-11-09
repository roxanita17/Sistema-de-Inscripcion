<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Para mostrar mensajes en la terminal

class EstadoController extends Controller
{
    /**
     * Muestra todos los registros de estados.
     */
    public function index()
    {
        // Se obtienen todos los estados ordenados alfabéticamente por su nombre
        $estados = Estado::orderBy('nombre_estado', 'asc')->get();

        // Se retorna la vista con los registros encontrados
        return view('admin.estado.index', compact('estados'));
    }

    /**
     * Guarda un nuevo estado en la base de datos.
     */
    public function store(Request $request)
    {
        // Se validan los datos enviados desde el formulario
        $validated = $request->validate([
            'nombre_estado' => 'required|string|max:255',
        ]);

        try {
            // Se crea una nueva instancia del modelo Estado
            $estado = new Estado();
            $estado->nombre_estado = $validated['nombre_estado'];
            $estado->status = true; // Por defecto, el estado se guarda como activo
            $estado->save();

            // Mensaje en la terminal para seguimiento
            info('Se ha creado un nuevo estado: ' . $estado->nombre_estado);

            // Se redirige con un mensaje de éxito visible al usuario
            return redirect()->route('admin.estado.index')->with('success', 'Estado creado exitosamente.');
        } catch (\Exception $e) {
            // Mensaje en la terminal en caso de error
            info('Error al crear un nuevo estado: ' . $e->getMessage());

            // Se redirige con un mensaje de error visible al usuario
            return redirect()->route('admin.estado.index')->with('error', 'Error al crear el estado: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza los datos de un estado existente.
     */
    public function update(Request $request, $id)
    {
        // Se busca el registro existente por su ID
        $estado = Estado::findOrFail($id);

        // Se validan los datos recibidos desde el formulario
        $validated = $request->validate([
            'nombre_estado' => 'required|string|max:255',
        ]);

        try {
            // Se actualiza el nombre del estado con el valor validado
            $estado->nombre_estado = $validated['nombre_estado'];
            $estado->save();

            // Mensaje en la terminal confirmando la actualización
            info('El estado con ID ' . $id . ' ha sido actualizado correctamente.');

            // Se redirige con mensaje de éxito
            return redirect()->route('admin.estado.index')->with('success', 'Estado actualizado exitosamente.');
        } catch (\Exception $e) {
            // Mensaje en la terminal si ocurre un error
            info('Error al actualizar el estado con ID ' . $id . ': ' . $e->getMessage());

            // Se redirige con mensaje de error
            return redirect()->route('admin.estado.index')->with('error', 'Error al actualizar el estado: ' . $e->getMessage());
        }
    }

    /**
     * Marca un estado como inactivo (eliminación lógica).
     */
    public function destroy($id)
    {
        // Se busca el estado por su ID
        $estado = Estado::find($id);

        // Si se encuentra el registro, se actualiza su estatus a inactivo
        if ($estado) {
            $estado->update(['status' => false]);

            // Mensaje en la terminal para seguimiento
            info('El estado "' . $estado->nombre_estado . '" ha sido marcado como inactivo.');

            // Se redirige con mensaje de éxito visible al usuario
            return redirect()->route('admin.estado.index')->with('success', 'Estado eliminado correctamente.');
        }

        // Si el registro no existe, se informa en la terminal
        info('No se encontró el estado con ID ' . $id . ' para eliminar.');

        // Y se redirige con mensaje de error
        return redirect()->route('admin.estado.index')->with('error', 'Estado no encontrado.');
    }
}
