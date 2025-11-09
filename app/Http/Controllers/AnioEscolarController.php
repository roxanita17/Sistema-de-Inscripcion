<?php

namespace App\Http\Controllers;

use App\Models\AnioEscolar;
use Illuminate\Http\Request;

class AnioEscolarController extends Controller
{
    /**
     * Muestra el listado de años escolares registrados.
     * 
     * Este método obtiene todos los registros de la tabla `anio_escolar`
     * y los envía a la vista principal para su visualización.
     */
    public function index()
    {
        // Se obtienen todos los registros del modelo AnioEscolar
        $escolar = AnioEscolar::all();

        // Retorna la vista principal con la colección de años escolares
        return view('admin.anio_escolar.index', compact('escolar'));
    }

    /**
     * Registra un nuevo año escolar en la base de datos.
     * 
     * Se valida que se envíen las fechas requeridas y luego se crea un nuevo
     * registro con estado "Activo" por defecto.
     */
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $validated = $request->validate([
            'inicio_anio_escolar' => 'required|date',
            'cierre_anio_escolar' => 'required|date|after:inicio_anio_escolar',
        ]);

        try {
            // Se crea un nuevo año escolar con los datos validados
            $anioEscolar = new AnioEscolar();
            $anioEscolar->inicio_anio_escolar = $validated['inicio_anio_escolar'];
            $anioEscolar->cierre_anio_escolar = $validated['cierre_anio_escolar'];
            $anioEscolar->status = 'Activo';
            $anioEscolar->save();

            // Mensaje de éxito al guardar correctamente
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('success', 'Año escolar creado correctamente.');
        } catch (\Exception $e) {
            // Captura de errores inesperados (por ejemplo, problemas con la BD)
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('error', 'Error al crear el año escolar: ' . $e->getMessage());
        }
    }

    /**
     * Extiende la fecha de cierre de un año escolar existente.
     * 
     * Se valida que la nueva fecha sea igual o posterior al inicio del año escolar
     * y luego se actualiza el registro con estado "Extendido".
     */
    public function extender(Request $request, $id)
    {
        // Se obtiene el registro correspondiente al año escolar
        $anioEscolar = AnioEscolar::findOrFail($id);

        // Validación: la nueva fecha debe ser igual o posterior al inicio original
        $validated = $request->validate([
            'cierre_anio_escolar' => 'required|date|after_or_equal:' . $anioEscolar->inicio_anio_escolar,
        ]);

        try {
            // Se actualiza el registro con la nueva fecha y estado
            $anioEscolar->cierre_anio_escolar = $validated['cierre_anio_escolar'];
            $anioEscolar->status = 'Extendido';
            $anioEscolar->save();

            // Redirige con mensaje de éxito
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('success', 'Año escolar actualizado correctamente.');
        } catch (\Exception $e) {
            // Si ocurre un error, se muestra un mensaje descriptivo
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('error', 'Error al actualizar el año escolar: ' . $e->getMessage());
        }
    }

    /**
     * Marca un año escolar como inactivo (baja lógica).
     * 
     * Este método no elimina físicamente el registro, solo cambia su estado a "Inactivo".
     * Si el ID no existe, muestra un mensaje de error.
     */
    public function destroy($id)
    {
        try {
            // Se busca el registro por su ID
            $anioEscolar = AnioEscolar::find($id);

            // Si se encuentra, se actualiza el estado a "Inactivo"
            if ($anioEscolar) {
                $anioEscolar->update([
                    'status' => 'Inactivo',
                ]);

                return redirect()
                    ->route('admin.anio_escolar.index')
                    ->with('success', 'Año escolar inactivado correctamente.');
            }

            // Si no se encuentra, se notifica al usuario
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('error', 'Año escolar no encontrado.');
        } catch (\Exception $e) {
            // Captura de errores inesperados durante la operación
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('error', 'Error al eliminar el año escolar: ' . $e->getMessage());
        }
    }
}
