<?php

namespace App\Http\Controllers;

use App\Models\Discapacidad;
use Illuminate\Http\Request;

class DiscapacidadController extends Controller
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
     * Muestra el listado de todas las discapacidades registradas.
     * 
     * Los registros se ordenan alfabéticamente por el nombre de la discapacidad
     * y se envían a la vista correspondiente.
     */
    public function index()
    {
        $discapacidad = Discapacidad::where('status', true)
            ->orderBy('nombre_discapacidad', 'asc')
            ->paginate(10);
        
        // Verificar si hay año escolar activo
        $anioEscolarActivo = $this->verificarAnioEscolar();
        
        return view('admin.discapacidad.index', compact('discapacidad', 'anioEscolarActivo'));
    }

    /**
     * Guarda una nueva discapacidad en la base de datos.
     * 
     * Se valida que el nombre sea requerido, de texto y que no exista ya
     * una discapacidad con el mismo nombre antes de crear un nuevo registro.
     */
    public function store(Request $request)
    {
        // Validación de los datos recibidos
        $validated = $request->validate([
            'nombre_discapacidad' => 'required|string|max:255',
        ]);

        // Verificar si ya existe una discapacidad con el mismo nombre
        // Si existe uno con "status = true", no se permite crear un duplicado.
        $existe = Discapacidad::where('nombre_discapacidad', $validated['nombre_discapacidad'])
            ->where('status', true)
            ->exists();

        // Si ya existe un registro activo con el mismo prefijo, se muestra un mensaje de error.
        if ($existe) {
            return redirect()
                ->route('admin.discapacidad.index')
                ->with('error', 'Esta discapacidad ya está registrada.');
        }

        try {
            // Crear nueva discapacidad
            $discapacidad = new Discapacidad();
            $discapacidad->nombre_discapacidad = $validated['nombre_discapacidad'];
            $discapacidad->status = true; // Se marca como activa por defecto
            $discapacidad->save();

            // Retornar mensaje de éxito
            return redirect()
                ->route('admin.discapacidad.index')
                ->with('success', 'Discapacidad creada correctamente.');
        } catch (\Exception $e) {
            // Manejo de errores durante la inserción
            return redirect()
                ->route('admin.discapacidad.index')
                ->with('error', 'Error al crear la discapacidad: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza los datos de una discapacidad existente.
     * 
     * Se valida el nuevo nombre, se evita duplicidad (ignorando el registro actual)
     * y se guardan los cambios en la base de datos.
     */
    public function update(Request $request, $id)
    {
        // Buscar el registro o lanzar error si no existe
        $discapacidad = Discapacidad::findOrFail($id);

        // Validación de los datos
        $validated = $request->validate([
            'nombre_discapacidad' => 'required|string|max:255',
        ]);

        // Verificar si ya existe otra discapacidad con el mismo nombre
        $existe = Discapacidad::where('nombre_discapacidad', $validated['nombre_discapacidad'])
            ->where('status', true)
            ->where('id', '!=', $id)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.discapacidad.index')
                ->with('error', 'No se puede actualizar: ya existe una discapacidad con este nombre.');
        }

        try {
            // Actualizar registro existente
            $discapacidad->nombre_discapacidad = $validated['nombre_discapacidad'];
            $discapacidad->save();

            return redirect()
                ->route('admin.discapacidad.index')
                ->with('success', 'Discapacidad actualizada exitosamente.');
        } catch (\Exception $e) {
            // Manejo de errores durante la actualización
            return redirect()
                ->route('admin.discapacidad.index')
                ->with('error', 'Error al actualizar la discapacidad: ' . $e->getMessage());
        }
    }

    /**
     * Realiza una baja lógica de una discapacidad.
     * 
     * En lugar de eliminar el registro físicamente, se marca como inactivo.
     */
    public function destroy($id)
    {
        try {
            // Buscar la discapacidad por ID
            $discapacidad = Discapacidad::find($id);

            if ($discapacidad) {
                // Marcar como inactiva (baja lógica)
                $discapacidad->update(['status' => false]);

                return redirect()
                    ->route('admin.discapacidad.index')
                    ->with('success', 'Discapacidad eliminada correctamente.');
            }

            // Si no se encuentra el registro
            return redirect()
                ->route('admin.discapacidad.index')
                ->with('error', 'Discapacidad no encontrada.');
        } catch (\Exception $e) {
            // Manejo de errores durante la eliminación
            return redirect()
                ->route('admin.discapacidad.index')
                ->with('error', 'Error al eliminar la discapacidad: ' . $e->getMessage());
        }
    }
}
