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
        // Se obtienen todas las ocupaciones registradas (activas e inactivas)
        // y se ordenan alfabéticamente por nombre.
        $ocupacion = Ocupacion::orderBy('nombre_ocupacion', 'asc')->where('status', true)->paginate(10);

        // Se retorna la vista principal con la colección de ocupaciones.
        return view("admin.ocupacion.index", compact("ocupacion"));
    }

    /**
     * Registra una nueva ocupación en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos del formulario.
        $validated = $request->validate([
            'nombre_ocupacion' => 'required|string|max:255',
        ]);

        // Verificar si ya existe una ocupación activa con el mismo nombre.
        $existe = Ocupacion::where('nombre_ocupacion', $validated['nombre_ocupacion'])
            ->where('status', true)
            ->exists();

        // Si ya existe una ocupación activa con el mismo nombre, se devuelve un error.
        if ($existe) {
            return redirect()
                ->route('admin.ocupacion.index')
                ->with('error', 'Ya existe una ocupación activa con este nombre.');
        }

        try {
            // Crear una nueva instancia del modelo y asignar los valores.
            $ocupacion = new Ocupacion();
            $ocupacion->nombre_ocupacion = $validated['nombre_ocupacion'];
            $ocupacion->status = true;
            $ocupacion->save();

            // Redirigir con un mensaje de éxito.
            return redirect()->route('admin.ocupacion.index')
                ->with('success', 'La ocupación fue registrada correctamente.');
        } catch (\Exception $e) {
            // Captura de errores y notificación al usuario.
            return redirect()->route('admin.ocupacion.index')
                ->with('error', 'Ocurrió un error al registrar la ocupación: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza la información de una ocupación existente.
     */
    public function update(Request $request, $id)
    {
        // Buscar la ocupación a modificar; si no existe, lanza error 404.
        $ocupacion = Ocupacion::findOrFail($id);

        // Validar los datos ingresados en el formulario.
        $validated = $request->validate([
            'nombre_ocupacion' => 'required|string|max:255',
        ]);

        // Verificar si ya existe otra ocupación activa con el mismo nombre,
        // excluyendo el registro actual.
        $existe = Ocupacion::where('nombre_ocupacion', $validated['nombre_ocupacion'])
            ->where('status', true)
            ->where('id', '!=', $ocupacion->id)
            ->exists();

        // Si existe duplicado activo, se cancela la actualización.
        if ($existe) {
            return redirect()
                ->route('admin.ocupacion.index')
                ->with('error', 'Ya existe otra ocupación activa con este nombre.');
        }

        try {
            // Actualizar los datos de la ocupación.
            $ocupacion->nombre_ocupacion = $validated['nombre_ocupacion'];
            $ocupacion->save();

            // Redirigir con mensaje de éxito.
            return redirect()->route('admin.ocupacion.index')
                ->with('success', 'La ocupación fue actualizada correctamente.');
        } catch (\Exception $e) {
            // Si ocurre un error en la actualización, se informa al usuario.
            return redirect()->route('admin.ocupacion.index')
                ->with('error', 'Ocurrió un error al actualizar la ocupación: ' . $e->getMessage());
        }
    }

    /**
     * Desactiva una ocupación (eliminación lógica del registro).
     */
    public function destroy($id)
    {
        // Buscar la ocupación a eliminar.
        $ocupacion = Ocupacion::find($id);

        // Verificar si existe el registro.
        if ($ocupacion) {
            // Cambiar el estado a falso (eliminación lógica).
            $ocupacion->update(['status' => false]);

            // Redirigir con mensaje de confirmación.
            return redirect()->route('admin.ocupacion.index')
                ->with('success', 'La ocupación fue eliminada correctamente.');
        }

        // Si no se encontró la ocupación, se informa al usuario.
        return redirect()->route('admin.ocupacion.index')
            ->with('error', 'No se encontró la ocupación especificada.');
    }
}
