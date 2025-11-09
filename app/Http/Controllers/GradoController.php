<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use Illuminate\Http\Request;

class GradoController extends Controller
{
    /**
     * Muestra la lista de grados existentes.
     */
    public function index()
    {
        // Obtener todos los grados ordenados ascendentemente por número
        $grados = Grado::orderBy('numero_grado', 'asc')->get();

        // Retornar la vista con los datos obtenidos
        return view('admin.grado.index', compact('grados'));
    }

    /**
     * Guarda un nuevo grado en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos ingresados por el usuario
        $validated = $request->validate([
            'numero_grado' => 'required|digits_between:1,4|unique:grados,numero_grado', 
            'capacidad_max' => 'required|digits_between:1,3',
            'min_seccion' => 'required|digits_between:1,2',
            'max_seccion' => 'required|digits_between:1,2',
        ]);

        try {
            // Crear el nuevo registro en la base de datos
            $grado = new Grado();
            $grado->numero_grado = $validated['numero_grado'];
            $grado->capacidad_max = $validated['capacidad_max'];
            $grado->min_seccion = $validated['min_seccion'];
            $grado->max_seccion = $validated['max_seccion'];
            $grado->status = true;
            $grado->save();

            // Mensaje de éxito para el usuario
            return redirect()->route('admin.grado.index')->with('success', 'Grado creado correctamente.');
        } catch (\Exception $e) {
            // Mensaje de error en caso de fallo
            return redirect()->route('admin.grado.index')->with('error', 'Ocurrió un error al crear el grado: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza los datos de un grado existente.
     */
    public function update(Request $request, $id)
    {
        // Buscar el grado a actualizar
        $grado = Grado::findOrFail($id);

        // Validar los nuevos datos ingresados por el usuario
        $validated = $request->validate([
            'numero_grado' => 'required|digits_between:1,4|unique:grados,numero_grado,' . $grado->id,
            'capacidad_max' => 'required|digits_between:1,3',
            'min_seccion' => 'required|digits_between:1,2',
            'max_seccion' => 'required|digits_between:1,2',
        ]);

        try {
            // Actualizar los campos del registro
            $grado->numero_grado = $validated['numero_grado'];
            $grado->capacidad_max = $validated['capacidad_max'];
            $grado->min_seccion = $validated['min_seccion'];
            $grado->max_seccion = $validated['max_seccion'];
            $grado->save();

            // Mensaje de éxito para el usuario
            return redirect()->route('admin.grado.index')->with('success', 'Grado actualizado correctamente.');
        } catch (\Exception $e) {
            // Mensaje de error si algo sale mal
            return redirect()->route('admin.grado.index')->with('error', 'Ocurrió un error al actualizar el grado: ' . $e->getMessage());
        }
    }

    /**
     * Desactiva un grado (borrado lógico).
     */
    public function destroy($id)
    {
        // Buscar el grado a eliminar
        $grado = Grado::find($id);

        if ($grado) {
            // Cambiar el estado del registro a inactivo
            $grado->update([
                'status' => false,
            ]);

            // Mensaje de éxito para el usuario
            return redirect()->route('admin.grado.index')->with('success', 'Grado eliminado correctamente.');
        }

        // Mensaje en caso de no encontrar el registro
        return redirect()->route('admin.grado.index')->with('error', 'El grado no fue encontrado.');
    }
}
