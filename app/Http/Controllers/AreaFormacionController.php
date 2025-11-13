<?php

namespace App\Http\Controllers;

use App\Models\AreaFormacion;
use App\Models\GrupoEstable;
use Illuminate\Http\Request;

class AreaFormacionController extends Controller
{
    /**
     * Muestra el listado de áreas de formación y grupos estables.
     */
    public function index()
    {
        // Traer solo materias activas y paginarlas (10 por página)
        $areaFormacion = AreaFormacion::where('status', true)->orderBy('nombre_area_formacion', 'asc')->paginate(5);

        // Traer solo grupos estables activos y paginarlos (10 por página)
        $grupoEstable = GrupoEstable::where('status', true)->orderBy('nombre_grupo_estable', 'asc')->paginate(5);

        return view('admin.area_formacion.index', compact('areaFormacion', 'grupoEstable'));
    }

    /**
     * Crea un nuevo registro de grupo estable.
     */
    public function storeGrupoEstable(Request $request)
    {
        $validated = $request->validate([
            'nombre_grupo_estable' => 'required|string|max:255',
        ]);

        // Verificar si ya existe un grupo estable activo con el mismo nombre
        $existe = GrupoEstable::where('nombre_grupo_estable', $validated['nombre_grupo_estable'])
            ->where('status', true)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.area_formacion.index')
                ->with('error', 'Ya existe un grupo estable activo con este nombre.');
        }

        try {
            $grupoEstable = new GrupoEstable();
            $grupoEstable->nombre_grupo_estable = $validated['nombre_grupo_estable'];
            $grupoEstable->status = true;
            $grupoEstable->save();

            return redirect()
                ->route('admin.area_formacion.index')
                ->with('success', 'Grupo estable creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.area_formacion.index')
                ->with('error', 'Error al crear el grupo estable: ' . $e->getMessage());
        }
    }

    /**
     * Crea una nueva área de formación.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_area_formacion' => 'required|string|max:255',
        ]);

        // Verificar si ya existe un área de formación activa con el mismo nombre
        $existe = AreaFormacion::where('nombre_area_formacion', $validated['nombre_area_formacion'])
            ->where('status', true)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.area_formacion.index')
                ->with('error', 'Ya existe un área de formación activa con este nombre.');
        }

        try {
            $areaFormacion = new AreaFormacion();
            $areaFormacion->nombre_area_formacion = $validated['nombre_area_formacion'];
            $areaFormacion->status = true;
            $areaFormacion->save();

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
     */
    public function updateGrupoEstable(Request $request, $id)
    {
        $validated = $request->validate([
            'nombre_grupo_estable' => 'required|string|max:255',
        ]);

        // Verificar si ya existe otro grupo estable activo con el mismo nombre
        $existe = GrupoEstable::where('nombre_grupo_estable', $validated['nombre_grupo_estable'])
            ->where('status', true)
            ->where('id', '!=', $id)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.area_formacion.index')
                ->with('error', 'Ya existe otro grupo estable activo con este nombre.');
        }

        try {
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
     */
    public function update(Request $request, $id)
    {
        $areaFormacion = AreaFormacion::findOrFail($id);

        $validated = $request->validate([
            'nombre_area_formacion' => 'required|string|max:255',
        ]);

        // Verificar si ya existe otra área de formación activa con el mismo nombre
        $existe = AreaFormacion::where('nombre_area_formacion', $validated['nombre_area_formacion'])
            ->where('status', true)
            ->where('id', '!=', $areaFormacion->id)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.area_formacion.index')
                ->with('error', 'Ya existe otra área de formación activa con este nombre.');
        }

        try {
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
     */
    public function destroyGrupoEstable($id)
    {
        try {
            $grupoEstable = GrupoEstable::find($id);

            if ($grupoEstable) {
                $grupoEstable->update(['status' => false]);

                return redirect()
                    ->route('admin.area_formacion.index')
                    ->with('success', 'Grupo estable eliminado correctamente.');
            }

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
