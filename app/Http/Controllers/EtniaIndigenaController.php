<?php

namespace App\Http\Controllers;

use App\Models\EtniaIndigena;
use Illuminate\Http\Request;

class EtniaIndigenaController extends Controller
{
    /**
     * Muestra la lista de etnias indígenas registradas.
     */
    public function index()
    {
        // Obtener todas las etnias indígenas ordenadas alfabéticamente
        $etniaIndigena = EtniaIndigena::orderBy('nombre', 'asc')->where('status', true)->paginate(10);

        // Retornar la vista principal con los datos obtenidos
        return view("admin.etnia_indigena.index", compact("etniaIndigena"));
    }

    /**
     * Registra una nueva etnia indígena en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos ingresados por el usuario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Verificar si ya existe una etnia activa con el mismo nombre
        $existe = EtniaIndigena::where('nombre', $validated['nombre'])
            ->where('status', true)
            ->exists();

        if ($existe) {
            // Mensaje si ya existe un registro activo con ese nombre
            return redirect()
                ->route('admin.etnia_indigena.index')
                ->with('error', 'Ya existe una etnia indígena activa con este nombre.');
        }

        try {
            // Crear una nueva instancia del modelo y guardar
            $etniaIndigena = new EtniaIndigena();
            $etniaIndigena->nombre = $validated['nombre'];
            $etniaIndigena->status = true;
            $etniaIndigena->save();

            // Mensaje de confirmación para el usuario
            return redirect()
                ->route('admin.etnia_indigena.index')
                ->with('success', 'La etnia indígena fue registrada correctamente.');
        } catch (\Exception $e) {
            // Mensaje en caso de error
            return redirect()
                ->route('admin.etnia_indigena.index')
                ->with('error', 'Ocurrió un error al registrar la etnia indígena: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza la información de una etnia indígena existente.
     */
    public function update(Request $request, $id)
    {
        // Buscar la etnia indígena a actualizar
        $etniaIndigena = EtniaIndigena::findOrFail($id);

        // Validar los datos ingresados
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        // Verificar si ya existe otra etnia activa con el mismo nombre
        $existe = EtniaIndigena::where('nombre', $validated['nombre'])
            ->where('status', true)
            ->where('id', '!=', $etniaIndigena->id)
            ->exists();

        if ($existe) {
            // Mensaje si ya existe otro registro activo con ese nombre
            return redirect()
                ->route('admin.etnia_indigena.index')
                ->with('error', 'Ya existe otra etnia indígena activa con este nombre.');
        }

        try {
            // Actualizar los datos del registro
            $etniaIndigena->nombre = $validated['nombre'];
            $etniaIndigena->save();

            // Mensaje de confirmación para el usuario
            return redirect()
                ->route('admin.etnia_indigena.index')
                ->with('success', 'La etnia indígena fue actualizada correctamente.');
        } catch (\Exception $e) {
            // Mensaje de error en caso de fallo
            return redirect()
                ->route('admin.etnia_indigena.index')
                ->with('error', 'Ocurrió un error al actualizar la etnia indígena: ' . $e->getMessage());
        }
    }

    /**
     * Desactiva una etnia indígena (eliminación lógica).
     */
    public function destroy($id)
    {
        // Buscar el registro a desactivar
        $etniaIndigena = EtniaIndigena::find($id);

        if ($etniaIndigena) {
            // Cambiar el estado a inactivo
            $etniaIndigena->update(['status' => false]);

            // Mensaje de éxito para el usuario
            return redirect()
                ->route('admin.etnia_indigena.index')
                ->with('success', 'La etnia indígena fue eliminada correctamente.');
        }

        // Mensaje si el registro no existe
        return redirect()
            ->route('admin.etnia_indigena.index')
            ->with('error', 'No se encontró la etnia indígena especificada.');
    }
}
