<?php

namespace App\Http\Controllers;

use App\Models\Ocupacion;
use Illuminate\Http\Request;

class OcupacionController extends Controller
{
    /**
     * Muestra la lista de ocupaciones registradas en el sistema.
     */
    public function index()
    {
        // Obtener todas las ocupaciones activas y ordenarlas alfabéticamente
        $ocupacion = Ocupacion::orderBy('nombre_ocupacion', 'asc')->get();

        // Retornar la vista con los datos de ocupaciones
        return view("admin.ocupacion.index", compact("ocupacion"));
    }

    /**
     * Registra una nueva ocupación en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos enviados por el usuario
        $validated = $request->validate([
            'nombre_ocupacion' => 'required|string|max:255',
        ]);

        try {
            // Crear la nueva ocupación
            $ocupacion = new Ocupacion();
            $ocupacion->nombre_ocupacion = $validated['nombre_ocupacion'];
            $ocupacion->status = true;
            $ocupacion->save();

            // Mensaje de confirmación para el usuario
            return redirect()->route('admin.ocupacion.index')->with('success', 'La ocupación fue registrada correctamente.');
        } catch (\Exception $e) {
            // Mensaje de error si algo falla
            return redirect()->route('admin.ocupacion.index')->with('error', 'Ocurrió un error al registrar la ocupación: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza la información de una ocupación existente.
     */
    public function update(Request $request, $id)
    {
        // Buscar la ocupación a modificar
        $ocupacion = Ocupacion::findOrFail($id);

        // Validar los datos ingresados
        $validated = $request->validate([
            'nombre_ocupacion' => 'required|string|max:255',
        ]);

        try {
            // Actualizar los datos de la ocupación
            $ocupacion->nombre_ocupacion = $validated['nombre_ocupacion'];
            $ocupacion->save();

            // Mensaje de éxito
            return redirect()->route('admin.ocupacion.index')->with('success', 'La ocupación fue actualizada correctamente.');
        } catch (\Exception $e) {
            // Mensaje de error
            return redirect()->route('admin.ocupacion.index')->with('error', 'Ocurrió un error al actualizar la ocupación: ' . $e->getMessage());
        }
    }

    /**
     * Desactiva una ocupación (eliminación lógica del registro).
     */
    public function destroy($id)
    {
        // Buscar la ocupación a eliminar
        $ocupacion = Ocupacion::find($id);

        if ($ocupacion) {
            // Cambiar el estado a inactivo en lugar de eliminarlo definitivamente
            $ocupacion->update([
                'status' => false,
            ]);

            // Mensaje de confirmación para el usuario
            return redirect()->route('admin.ocupacion.index')->with('success', 'La ocupación fue eliminada correctamente.');
        }

        // Mensaje si la ocupación no se encuentra
        return redirect()->route('admin.ocupacion.index')->with('error', 'No se encontró la ocupación especificada.');
    }
}
