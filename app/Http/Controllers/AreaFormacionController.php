<?php

namespace App\Http\Controllers;

use App\Models\AreaFormacion;
use App\Models\GrupoEstable;
use Illuminate\Http\Request;

class AreaFormacionController extends Controller
{
    /**
     * Muestra el listado de áreas de formación y grupos estables.
     * 
     * Este método obtiene todos los registros activos o existentes
     * de las tablas relacionadas y los pasa a la vista correspondiente.
     */
    public function index()
    {
        // Se obtienen todos los grupos estables ordenados alfabéticamente
        $grupoEstable = GrupoEstable::orderBy('nombre_grupo_estable', 'asc')->get();

        // Se obtienen todas las áreas de formación ordenadas alfabéticamente
        $areaFormacion = AreaFormacion::orderBy('nombre_area_formacion', 'asc')->get();

        // Se retorna la vista con ambas colecciones de datos
        return view('admin.area_formacion.index', compact('areaFormacion', 'grupoEstable'));
    }

    /**
     * Crea un nuevo registro de grupo estable.
     * 
     * Se valida que el nombre sea correcto y no esté vacío, luego
     * se guarda en la base de datos con estado activo.
     */
    public function storeGrupoEstable(Request $request)
    {
        // Validación de campos requeridos
        $validated = $request->validate([
            'nombre_grupo_estable' => 'required|string|max:255',
        ]);

        try {
            // Se crea una nueva instancia del modelo
            $grupoEstable = new GrupoEstable();
            $grupoEstable->nombre_grupo_estable = $validated['nombre_grupo_estable'];
            $grupoEstable->status = true;
            $grupoEstable->save();

            // Mensaje de confirmación
            return redirect()
                ->route('admin.area_formacion.index')
                ->with('success', 'Grupo estable creado exitosamente.');
        } catch (\Exception $e) {
            // Manejo de errores (por ejemplo, problemas de conexión o validación)
            return redirect()
                ->route('admin.area_formacion.index')
                ->with('error', 'Error al crear el grupo estable: ' . $e->getMessage());
        }
    }

    /**
     * Crea una nueva área de formación.
     * 
     * Se valida el nombre y se registra con estado activo.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_area_formacion' => 'required|string|max:255',
        ]);

        try {
            // Se crea una nueva área de formación
            $areaFormacion = new AreaFormacion();
            $areaFormacion->nombre_area_formacion = $validated['nombre_area_formacion'];
            $areaFormacion->status = true;
            $areaFormacion->save();

            // Retorna con mensaje de éxito
            return redirect()
                ->route('admin.area_formacion.index')
                ->with('success', 'Área de formación creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.area_formacion.index')
                ->with('error', 'Error al crear el área de formación: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza los datos de un grupo estable.
     * 
     * Busca el grupo por su ID, valida el nuevo nombre y lo guarda.
     */
    public function updateGrupoEstable(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre_grupo_estable' => 'required|string|max:255',
        ]);

        try {
            // Se busca el grupo estable por su ID
            $grupoEstable = GrupoEstable::findOrFail($id);
            $grupoEstable->nombre_grupo_estable = $validated['nombre_grupo_estable'];
            $grupoEstable->save();

            return redirect()
                ->route('admin.area_formacion.index')
                ->with('success', 'Grupo estable actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.area_formacion.index')
                ->with('error', 'Error al actualizar el grupo estable: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza los datos de un área de formación.
     * 
     * Se valida que el nombre no esté duplicado antes de actualizar.
     */
    public function update(Request $request, $id)
    {
        // Se obtiene el registro existente
        $areaFormacion = AreaFormacion::findOrFail($id);

        // Validación: el nombre debe ser único excepto para el mismo registro
        $validated = $request->validate([
            'nombre_area_formacion' => 'required|string|max:255|unique:area_formacions,nombre_area_formacion,' . $areaFormacion->id,
        ]);

        try {
            // Se actualiza el campo correspondiente
            $areaFormacion->nombre_area_formacion = $validated['nombre_area_formacion'];
            $areaFormacion->save();

            return redirect()
                ->route('admin.area_formacion.index')
                ->with('success', 'Área de formación actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.area_formacion.index')
                ->with('error', 'Error al actualizar el área de formación: ' . $e->getMessage());
        }
    }

    /**
     * Realiza una baja lógica de un grupo estable.
     * 
     * En lugar de eliminar el registro, cambia su estado a inactivo.
     */
    public function destroyGrupoEstable($id)
    {
        try {
            $grupoEstable = GrupoEstable::find($id);

            if ($grupoEstable) {
                // Actualiza el estado en lugar de eliminarlo
                $grupoEstable->update(['status' => false]);

                return redirect()
                    ->route('admin.area_formacion.index')
                    ->with('success', 'Grupo estable eliminado correctamente.');
            }

            // En caso de no encontrar el registro
            return redirect()
                ->route('admin.area_formacion.index')
                ->with('error', 'Grupo estable no encontrado.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.area_formacion.index')
                ->with('error', 'Error al eliminar el grupo estable: ' . $e->getMessage());
        }
    }

    /**
     * Realiza una baja lógica de un área de formación.
     * 
     * Cambia el estado del registro a inactivo en lugar de eliminarlo.
     */
    public function destroy($id)
    {
        try {
            $areaFormacion = AreaFormacion::find($id);

            if ($areaFormacion) {
                $areaFormacion->update(['status' => false]);

                return redirect()
                    ->route('admin.area_formacion.index')
                    ->with('success', 'Área de formación eliminada correctamente.');
            }

            return redirect()
                ->route('admin.area_formacion.index')
                ->with('error', 'Área de formación no encontrada.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.area_formacion.index')
                ->with('error', 'Error al eliminar el área de formación: ' . $e->getMessage());
        }
    }
}
