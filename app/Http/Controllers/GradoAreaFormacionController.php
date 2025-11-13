<?php

namespace App\Http\Controllers;

use App\Models\AreaFormacion;
use App\Models\Grado;
use App\Models\GradoAreaFormacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Para mostrar mensajes en la terminal

class GradoAreaFormacionController extends Controller
{
    /**
     * Muestra la lista de asignaciones entre grados y áreas de formación.
     */
    public function index()
    {
        // Se obtienen todas las asignaciones con sus relaciones, ordenadas por número de grado
        $gradoAreaFormacion = GradoAreaFormacion::with(['grado', 'area_formacion'])
            ->join('grados', 'grados.id', '=', 'grado_area_formacions.grado_id')
            ->orderBy('grados.numero_grado', 'asc')
            ->select('grado_area_formacions.*')
            ->paginate(10);

        // Se obtienen los grados activos
        $grados = Grado::where('status', true)
            ->orderBy('numero_grado', 'asc')
            ->get();

        // Se obtienen las áreas de formación activas
        $areaFormacion = AreaFormacion::where('status', true)
            ->orderBy('nombre_area_formacion', 'asc')
            ->get();

        // Se muestra la vista principal
        return view('admin.transacciones.grado_area_formacion.index', compact('gradoAreaFormacion', 'grados', 'areaFormacion'));
    }

    /**
     * Crea una nueva asignación entre grado y área de formación.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $validated = $request->validate([
            'grado_id' => 'required|exists:grados,id',
            'area_formacion_id' => 'required|exists:area_formacions,id',
        ]);

        // Se verifica si la asignación ya existe
        $existe = GradoAreaFormacion::where('grado_id', $validated['grado_id'])
            ->where('area_formacion_id', $validated['area_formacion_id'])
            ->exists();

        if ($existe) {
            info('Intento de duplicar asignación grado-área');
            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('error', 'Esta asignación ya existe.');
        }

        try {
            // Se crea la nueva relación
            $gradoAreaFormacion = new GradoAreaFormacion();
            $gradoAreaFormacion->grado_id = $validated['grado_id'];
            $gradoAreaFormacion->area_formacion_id = $validated['area_formacion_id'];
            $gradoAreaFormacion->status = true;
            $gradoAreaFormacion->save();

            // Mensaje en consola
            info('Nueva asignación creada: Grado ID ' . $validated['grado_id'] . ', Área ID ' . $validated['area_formacion_id']);

            // Mensaje para el usuario
            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('success', 'Asignación creada exitosamente.');
        } catch (\Exception $e) {
            // Registro del error en consola
            info('Error al crear asignación: ' . $e->getMessage());

            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('error', 'Error al crear: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza una asignación existente entre grado y área de formación.
     */
    public function update(Request $request, $id)
    {
        // Validación de los campos
        $validated = $request->validate([
            'grado_id' => 'required|exists:grados,id',
            'area_formacion_id' => 'required|exists:area_formacions,id',
        ]);

        $gradoAreaFormacion = GradoAreaFormacion::findOrFail($id);

        // Verifica duplicado (excluyendo el registro actual)
        $existe = GradoAreaFormacion::where('grado_id', $validated['grado_id'])
            ->where('area_formacion_id', $validated['area_formacion_id'])
            ->where('id', '!=', $id)
            ->exists();

        if ($existe) {
            info('Intento de actualización duplicada para asignación ID ' . $id);
            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('error', 'No se puede actualizar: esta asignación ya existe.');
        }

        try {
            // Se actualiza la asignación
            $gradoAreaFormacion->grado_id = $validated['grado_id'];
            $gradoAreaFormacion->area_formacion_id = $validated['area_formacion_id'];
            $gradoAreaFormacion->save();

            // Registro en consola
            info('Asignación actualizada correctamente: ID ' . $id);

            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('success', 'Asignación actualizada exitosamente.');
        } catch (\Exception $e) {
            // Registro del error
            info('Error al actualizar asignación ID ' . $id . ': ' . $e->getMessage());

            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    /**
     * Elimina una asignación (solo el registro intermedio, sin afectar otras tablas).
     */
    public function destroy($id)
    {
        try {
            // Se busca la asignación
            $gradoAreaFormacion = GradoAreaFormacion::findOrFail($id);
            $gradoAreaFormacion->delete();

            // Mensaje en consola
            info('Asignación eliminada correctamente: ID ' . $id);

            // Mensaje para el usuario
            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('success', 'Asignación eliminada exitosamente.');
        } catch (\Exception $e) {
            // Error registrado en consola
            info('Error al eliminar asignación ID ' . $id . ': ' . $e->getMessage());

            return redirect()
                ->route('admin.transacciones.grado_area_formacion.index')
                ->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}
