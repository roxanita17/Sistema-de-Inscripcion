<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use App\Models\Municipio;
use App\Models\Estado;
use Illuminate\Http\Request;

class LocalidadController extends Controller
{
    /**
     * Muestra la lista de localidades existentes junto con sus municipios y estados.
     */
    public function index()
    {
        // Obtener todos los municipios y estados activos ordenados alfabéticamente
        $municipios = Municipio::where('status', true)->orderBy('nombre_municipio', 'asc')->get();
        $estados = Estado::where('status', true)->orderBy('nombre_estado', 'asc')->get();

        // Obtener todas las localidades con sus relaciones correspondientes
        $localidades = Localidad::orderBy('nombre_localidad', 'asc')->with(['estado', 'municipio'])->get();

        // Enviar los datos a la vista
        return view('admin.localidad.index', compact('localidades', 'municipios', 'estados'));
    }

    /**
     * Muestra el modal de creación de una nueva localidad.
     */
    public function createModal()
    {
        // Obtener municipios y estados activos para mostrarlos en el formulario modal
        $municipios = Municipio::where('status', true)->orderBy('nombre_municipio', 'asc')->get();
        $estados = Estado::where('status', true)->orderBy('nombre', 'asc')->get();

        // Retornar la vista del modal con los datos
        return view('admin.localidad.modales.createModal', compact('municipios', 'estados'));
    }

    /**
     * Devuelve las localidades pertenecientes a un municipio específico.
     */
    public function getByMunicipio($municipio_id)
    {
        // Buscar localidades activas que pertenezcan al municipio indicado
        $localidades = Localidad::where('municipio_id', $municipio_id)
                                ->where('status', true)
                                ->get(['id', 'nombre_localidad']);

        // Devolver los resultados en formato JSON
        return response()->json($localidades);
    }

    /**
     * Registra una nueva localidad en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre_localidad' => 'required|string|max:255',
            'municipio_id' => 'required|exists:municipios,id',
        ]);

        try {
            // Crear el nuevo registro de localidad
            $localidad = new Localidad();
            $localidad->nombre_localidad = $validated['nombre_localidad'];
            $localidad->municipio_id = $validated['municipio_id'];
            $localidad->status = true;
            $localidad->save();

            // Mensaje de confirmación para el usuario
            return redirect()->route('admin.localidad.index')->with('success', 'La localidad fue registrada correctamente.');
        } catch (\Exception $e) {
            // Mensaje de error si ocurre algún problema al guardar
            return redirect()->route('admin.localidad.index')->with('error', 'Ocurrió un error al registrar la localidad: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza la información de una localidad existente.
     */
    public function update(Request $request, $id)
    {
        // Buscar la localidad a actualizar
        $localidad = Localidad::findOrFail($id);

        // Validar los nuevos datos ingresados por el usuario
        $validated = $request->validate([
            'nombre_localidad' => 'required|string|max:255',
            'municipio_id' => 'required|exists:municipios,id',
        ]);

        try {
            // Actualizar los datos de la localidad
            $localidad->nombre_localidad = $validated['nombre_localidad'];
            $localidad->municipio_id = $validated['municipio_id'];
            $localidad->status = true;
            $localidad->save();

            // Mensaje de confirmación
            return redirect()->route('admin.localidad.index')->with('success', 'La localidad fue actualizada correctamente.');
        } catch (\Exception $e) {
            // Mensaje en caso de error
            return redirect()->route('admin.localidad.index')->with('error', 'Ocurrió un error al actualizar la localidad: ' . $e->getMessage());
        }
    }

    /**
     * Desactiva una localidad (eliminación lógica).
     */
    public function destroy($id)
    {
        // Buscar la localidad que se desea desactivar
        $localidad = Localidad::find($id);

        if ($localidad) {
            // Cambiar su estado a inactiva
            $localidad->update([
                'status' => false,
            ]);

            // Mensaje de confirmación
            return redirect()->route('admin.localidad.index')->with('success', 'La localidad fue eliminada correctamente.');
        }

        // Mensaje si no se encuentra la localidad
        return redirect()->route('admin.localidad.index')->with('error', 'No se encontró la localidad especificada.');
    }
}
