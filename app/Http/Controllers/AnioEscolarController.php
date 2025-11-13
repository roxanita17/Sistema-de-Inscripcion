<?php

namespace App\Http\Controllers;

use App\Models\AnioEscolar;
use Illuminate\Http\Request;

class AnioEscolarController extends Controller
{
    /**
     * Muestra el listado de años escolares registrados.
     */
    public function index()
    {
        $escolar = AnioEscolar::paginate(10);
        return view('admin.anio_escolar.index', compact('escolar'));

    }

    /**
     * Registra un nuevo año escolar en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inicio_anio_escolar' => 'required|date',
            'cierre_anio_escolar' => 'required|date|after:inicio_anio_escolar',
        ]);

        // Verificar si ya existe un año escolar activo con las mismas fechas
        $existe = AnioEscolar::where('inicio_anio_escolar', $validated['inicio_anio_escolar'])
            ->where('cierre_anio_escolar', $validated['cierre_anio_escolar'])
            ->where('status', 'Activo')
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('error', 'Ya existe un año escolar activo con esas fechas.');
        }

        try {
            $anioEscolar = new AnioEscolar();
            $anioEscolar->inicio_anio_escolar = $validated['inicio_anio_escolar'];
            $anioEscolar->cierre_anio_escolar = $validated['cierre_anio_escolar'];
            $anioEscolar->status = 'Activo';
            $anioEscolar->save();

            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('success', 'Año escolar creado correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('error', 'Error al crear el año escolar: ' . $e->getMessage());
        }
    }

    /**
     * Extiende la fecha de cierre de un año escolar existente.
     */
    public function extender(Request $request, $id)
    {
        $anioEscolar = AnioEscolar::findOrFail($id);

        $validated = $request->validate([
            'cierre_anio_escolar' => 'required|date|after_or_equal:' . $anioEscolar->inicio_anio_escolar,
        ]); 

        // Verificar si ya existe otro año escolar activo con la misma fecha de cierre
        $existe = AnioEscolar::where('inicio_anio_escolar', $anioEscolar->inicio_anio_escolar)
            ->where('cierre_anio_escolar', $validated['cierre_anio_escolar'])
            ->where('status', 'Activo')
            ->where('id', '!=', $anioEscolar->id)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('error', 'Ya existe otro año escolar activo con esas fechas.');
        }

        try {
            $anioEscolar->cierre_anio_escolar = $validated['cierre_anio_escolar'];
            $anioEscolar->status = 'Extendido';
            $anioEscolar->save();

            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('success', 'Año escolar actualizado correctamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('error', 'Error al actualizar el año escolar: ' . $e->getMessage());
        }
    }

    /**
     * Marca un año escolar como inactivo (baja lógica).
     */
    public function destroy($id)
    {
        try {
            $anioEscolar = AnioEscolar::find($id);

            if ($anioEscolar) {
                $anioEscolar->update(['status' => 'Inactivo']);

                return redirect()
                    ->route('admin.anio_escolar.index')
                    ->with('success', 'Año escolar inactivado correctamente.');
            }

            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('error', 'Año escolar no encontrado.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('error', 'Error al eliminar el año escolar: ' . $e->getMessage());
        }
    }
}
