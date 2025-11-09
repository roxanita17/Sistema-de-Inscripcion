<?php

namespace App\Http\Controllers;

use App\Models\EtniaIndigena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Para mostrar mensajes en la terminal

class EtniaIndigenaController extends Controller
{
    /**
     * Muestra todos los registros de etnias indígenas.
     */
    public function index()
    {
        // Se obtienen todas las etnias indígenas ordenadas alfabéticamente por su nombre
        $etniaIndigena = EtniaIndigena::orderBy('nombre', 'asc')->get();

        // Se muestra la vista principal junto con los datos obtenidos
        return view("admin.etnia_indigena.index", compact("etniaIndigena"));
    }

    /**
     * Guarda una nueva etnia indígena en la base de datos.
     */
    public function store(Request $request)
    {
        // Se validan los datos recibidos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        try {
            // Se crea una nueva instancia del modelo EtniaIndigena
            $etniaIndigena = new EtniaIndigena();
            $etniaIndigena->nombre = $validated['nombre'];
            $etniaIndigena->status = true; // El registro se crea como activo
            $etniaIndigena->save();

            // Mensaje de registro en la terminal
            info('Se ha creado una nueva etnia indígena: ' . $etniaIndigena->nombre);

            // Se redirige al usuario con un mensaje de éxito
            return redirect()->route('admin.etnia_indigena.index')->with('success', 'Etnia indígena creada correctamente.');
        } catch (\Exception $e) {
            // Mensaje en la terminal en caso de error
            info('Error al crear una nueva etnia indígena: ' . $e->getMessage());

            // Mensaje de error visible al usuario
            return redirect()->route('admin.etnia_indigena.index')->with('error', 'Error al crear la etnia indígena: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza una etnia indígena existente.
     */
    public function update(Request $request, $id)
    {
        // Se busca la etnia indígena por su ID, o se lanza un error si no existe
        $etniaIndigena = EtniaIndigena::findOrFail($id);

        // Se validan los datos enviados desde el formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        try {
            // Se actualiza el nombre de la etnia con los nuevos datos
            $etniaIndigena->nombre = $validated['nombre'];
            $etniaIndigena->save();

            // Mensaje en la terminal informando del cambio
            info('La etnia indígena con ID ' . $id . ' ha sido actualizada correctamente.');

            // Se redirige con un mensaje de éxito visible al usuario
            return redirect()->route('admin.etnia_indigena.index')->with('success', 'Etnia indígena actualizada exitosamente.');
        } catch (\Exception $e) {
            // Mensaje en la terminal si ocurre un error durante la actualización
            info('Error al actualizar la etnia indígena con ID ' . $id . ': ' . $e->getMessage());

            // Se redirige con mensaje de error al usuario
            return redirect()->route('admin.etnia_indigena.index')->with('error', 'Error al actualizar la etnia indígena: ' . $e->getMessage());
        }
    }

    /**
     * Marca una etnia indígena como inactiva (eliminación lógica).
     */
    public function destroy($id)
    {
        // Se busca el registro según el ID proporcionado
        $etniaIndigena = EtniaIndigena::find($id);

        // Si el registro existe, se actualiza el estatus a falso (inactivo)
        if ($etniaIndigena) {
            $etniaIndigena->update(['status' => false]);

            // Mensaje de registro en la terminal
            info('La etnia indígena "' . $etniaIndigena->nombre . '" ha sido marcada como inactiva.');

            // Se informa al usuario del resultado
            return redirect()->route('admin.etnia_indigena.index')->with('success', 'Etnia indígena eliminada correctamente.');
        }

        // Si no se encuentra el registro, se informa en la terminal y al usuario
        info('No se encontró la etnia indígena con ID ' . $id . ' para eliminar.');
        return redirect()->route('admin.etnia_indigena.index')->with('error', 'Etnia indígena no encontrada.');
    }
}
