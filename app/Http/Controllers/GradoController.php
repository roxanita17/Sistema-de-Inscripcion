<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use Illuminate\Http\Request;

class GradoController extends Controller
{
    /**
     * Muestra la lista de grados existentes en el sistema.
     */
    public function index()
    {
        // Obtener todos los grados, ordenados por el número de grado de forma ascendente
        $grados = Grado::where('status', true)->orderBy('numero_grado', 'asc')->paginate(10);

        // Retornar la vista principal con los datos obtenidos
        return view('admin.grado.index', compact('grados'));
    }

    /**
     * Registra un nuevo grado en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos ingresados por el usuario
        $validated = $request->validate([
            'numero_grado' => 'required|digits_between:1,4',
            'capacidad_max' => 'required|digits_between:1,3',
            'min_seccion' => 'required|digits_between:1,2',
            'max_seccion' => 'required|digits_between:1,2',
        ]);

        $existe = Grado::where('numero_grado', $validated['numero_grado'])
            ->where('status', true)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.grado.index')
                ->with('error', 'Ya existe un grado con el mismo número.');
        }

        try {
            // Crear un nuevo registro de grado con los datos validados
            $grado = new Grado();
            $grado->numero_grado = $validated['numero_grado'];
            $grado->capacidad_max = $validated['capacidad_max'];
            $grado->min_seccion = $validated['min_seccion'];
            $grado->max_seccion = $validated['max_seccion'];
            $grado->status = true;
            $grado->save();

            // Retornar mensaje de éxito al usuario
            return redirect()
                ->route('admin.grado.index')
                ->with('success', 'El grado fue creado correctamente.');
        } catch (\Exception $e) {
            // Retornar mensaje de error en caso de excepción
            return redirect()
                ->route('admin.grado.index')
                ->with('error', 'Ocurrió un error al crear el grado: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza la información de un grado existente.
     */
    public function update(Request $request, $id)
    {
        // Buscar el registro del grado que se desea actualizar
        $grado = Grado::findOrFail($id);

        // Validar los nuevos datos ingresados por el usuario
        $validated = $request->validate([
            'numero_grado' => 'required|digits_between:1,4' . $grado->id,
            'capacidad_max' => 'required|digits_between:1,3',
            'min_seccion' => 'required|digits_between:1,2',
            'max_seccion' => 'required|digits_between:1,2',
        ]);

        $existe = Grado::where('numero_grado', $validated['numero_grado'])
            ->where('id', '!=', $grado->id)
            ->where('status', true)
            ->exists();

        if ($existe) {
            return redirect()
                ->route('admin.grado.index')
                ->with('error', 'Ya existe un grado con el mismo número.');
        }

        try {
            // Actualizar los valores del registro existente
            $grado->numero_grado = $validated['numero_grado'];
            $grado->capacidad_max = $validated['capacidad_max'];
            $grado->min_seccion = $validated['min_seccion'];
            $grado->max_seccion = $validated['max_seccion'];
            $grado->save();

            // Retornar mensaje de confirmación al usuario
            return redirect()
                ->route('admin.grado.index')
                ->with('success', 'El grado fue actualizado correctamente.');
        } catch (\Exception $e) {
            // Retornar mensaje de error si ocurre algún problema
            return redirect()
                ->route('admin.grado.index')
                ->with('error', 'Ocurrió un error al actualizar el grado: ' . $e->getMessage());
        }
    }

    /**
     * Desactiva un grado (eliminación lógica del registro).
     */
    public function destroy($id)
    {
        // Buscar el registro del grado que se desea desactivar
        $grado = Grado::find($id);

        if ($grado) {
            // Cambiar el estado del grado a inactivo
            $grado->update(['status' => false]);

            // Retornar mensaje de confirmación
            return redirect()
                ->route('admin.grado.index')
                ->with('success', 'El grado fue eliminado correctamente.');
        }

        // Retornar mensaje si no se encuentra el grado especificado
        return redirect()
            ->route('admin.grado.index')
            ->with('error', 'No se encontró el grado especificado.');
    }
}
