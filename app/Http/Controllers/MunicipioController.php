<?php

namespace App\Http\Controllers;

use App\Models\Municipio;
use App\Models\Estado;
use Illuminate\Http\Request;

class MunicipioController extends Controller
{
    /**
     * Muestra la lista de municipios junto con los estados disponibles.
     */
    public function index()
    {
        // Obtener todos los estados activos y ordenarlos alfabéticamente
        $estados = Estado::where('status', true)->orderBy('nombre_estado', 'asc')->get();

        // Obtener todos los municipios existentes ordenados por nombre
        $municipios = Municipio::orderBy('nombre_municipio', 'asc')->get();

        // Retornar la vista con los datos necesarios
        return view('admin.municipio.index', compact('municipios', 'estados'));
    }

    /**
     * Muestra el modal para registrar un nuevo municipio.
     */
    public function createModal()
    {
        // Obtener los estados activos para mostrarlos en el formulario
        $estados = Estado::where('status', true)->orderBy('nombre_estado', 'asc')->get();

        // Retornar la vista del modal con los estados
        return view('admin.municipio.modales.createModal', compact('estados'));
    }

    /**
     * Devuelve los municipios que pertenecen a un estado específico (para selects dinámicos).
     */
    public function getByEstado($estado_id)
    {
        // Buscar municipios activos asociados al estado indicado
        $municipios = Municipio::where('estado_id', $estado_id)
                                ->where('status', true)
                                ->get(['id', 'nombre_municipio']);

        // Devolver los resultados en formato JSON
        return response()->json($municipios);
    }

    /**
     * Registra un nuevo municipio en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos ingresados por el usuario
        $validated = $request->validate([
            'nombre_municipio' => 'required|string|max:255',
            'estado_id' => 'required|exists:estados,id',
        ]);

        try {
            // Crear el nuevo municipio
            $municipio = new Municipio();
            $municipio->nombre_municipio = $validated['nombre_municipio'];
            $municipio->estado_id = $validated['estado_id'];
            $municipio->status = true;
            $municipio->save();

            // Mensaje de confirmación para el usuario
            return redirect()->route('admin.municipio.index')->with('success', 'El municipio fue registrado correctamente.');
        } catch (\Exception $e) {
            // Mensaje en caso de error
            return redirect()->route('admin.municipio.index')->with('error', 'Ocurrió un error al registrar el municipio: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza la información de un municipio existente.
     */
    public function update(Request $request, $id)
    {
        // Buscar el municipio a actualizar
        $municipio = Municipio::findOrFail($id);

        // Validar los nuevos datos ingresados
        $validated = $request->validate([
            'nombre_municipio' => 'required|string|max:255',
            'estado_id' => 'required|exists:estados,id',
        ]);

        try {
            // Actualizar la información del municipio
            $municipio->nombre_municipio = $validated['nombre_municipio'];
            $municipio->estado_id = $validated['estado_id'];
            $municipio->save();

            // Mensaje de éxito
            return redirect()->route('admin.municipio.index')->with('success', 'El municipio fue actualizado correctamente.');
        } catch (\Exception $e) {
            // Mensaje de error
            return redirect()->route('admin.municipio.index')->with('error', 'Ocurrió un error al actualizar el municipio: ' . $e->getMessage());
        }
    }

    /**
     * Desactiva un municipio (eliminación lógica).
     */
    public function destroy($id)
    {
        // Buscar el municipio a eliminar
        $municipio = Municipio::find($id);

        if ($municipio) {
            // Cambiar su estado a inactivo
            $municipio->update([
                'status' => false,
            ]);

            // Mensaje de confirmación
            return redirect()->route('admin.municipio.index')->with('success', 'El municipio fue eliminado correctamente.');
        }

        // Mensaje si no se encuentra el municipio
        return redirect()->route('admin.municipio.index')->with('error', 'No se encontró el municipio especificado.');
    }
}
