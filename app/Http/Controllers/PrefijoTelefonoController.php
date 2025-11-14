<?php

namespace App\Http\Controllers;

use App\Models\PrefijoTelefono;
use Illuminate\Http\Request;

class PrefijoTelefonoController extends Controller
{
    /**
     * Muestra el listado de todos los prefijos registrados,
     * tanto los activos como los inactivos (status = true / false).
     */
    public function index()
    {
        // Se obtienen todos los prefijos ordenados de forma ascendente por el número de prefijo
        $prefijos = PrefijoTelefono::where('status', true)->orderBy('prefijo', 'asc')->paginate(10);

        // Se retorna la vista con los datos obtenidos
        return view('admin.prefijo_telefono.index', compact('prefijos'));
    }

    /**
     * Registra un nuevo prefijo en la base de datos.
     */
    public function store(Request $request)
    {
        // Se validan los datos enviados por el usuario.
        // Solo se permiten números con una longitud entre 1 y 4 dígitos.
        $validated = $request->validate([
            'prefijo' => 'required|digits_between:1,4',
        ]);

        // Se verifica si ya existe un prefijo activo con el mismo número.
        // Si existe uno con "status = true", no se permite crear un duplicado.
        $existe = PrefijoTelefono::where('prefijo', $validated['prefijo'])
            ->where('status', true)
            ->exists();

        // Si ya existe un registro activo con el mismo prefijo, se muestra un mensaje de error.
        if ($existe) {
            return redirect()
                ->route('admin.prefijo_telefono.index')
                ->with('error', 'Este prefijo ya existe y está activo.');
        }

        try {
            // Se crea una nueva instancia del modelo PrefijoTelefono
            $prefijo = new PrefijoTelefono();

            // Se asigna el valor validado al campo correspondiente
            $prefijo->prefijo = $validated['prefijo'];

            // El campo "status" se establece como verdadero (activo)
            $prefijo->status = true;

            // Se guarda el nuevo registro en la base de datos
            $prefijo->save();

            // Se redirige con un mensaje de éxito
            return redirect()
                ->route('admin.prefijo_telefono.index')
                ->with('success', 'Prefijo creado correctamente.');
        } catch (\Exception $e) {
            // Si ocurre un error inesperado, se captura y se muestra un mensaje informativo
            return redirect()
                ->route('admin.prefijo_telefono.index')
                ->with('error', 'Ocurrió un error al crear el prefijo: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza la información de un prefijo existente.
     */
    public function update(Request $request, $id)
    {
        // Se busca el registro del prefijo por su ID.
        // Si no se encuentra, Laravel lanzará automáticamente un error 404.
        $prefijo = PrefijoTelefono::findOrFail($id);

        // Se validan los datos ingresados nuevamente.
        $validated = $request->validate([
            'prefijo' => 'required|digits_between:1,4',
        ]);

        // Se verifica si existe otro registro activo con el mismo número de prefijo,
        // excluyendo el registro actual (para evitar conflictos al editar).
        $existe = PrefijoTelefono::where('prefijo', $validated['prefijo'])
            ->where('status', true)
            ->where('id', '!=', $prefijo->id)
            ->exists();

        // Si se encuentra un duplicado activo, se impide la actualización.
        if ($existe) {
            return redirect()
                ->route('admin.prefijo_telefono.index')
                ->with('error', 'Ya existe otro prefijo activo con este valor.');
        }

        try {
            // Se actualiza el valor del prefijo con la nueva información
            $prefijo->prefijo = $validated['prefijo'];

            // Se guardan los cambios en la base de datos
            $prefijo->save();

            // Se muestra un mensaje de éxito al usuario
            return redirect()
                ->route('admin.prefijo_telefono.index')
                ->with('success', 'Prefijo actualizado correctamente.');
        } catch (\Exception $e) {
            // Si ocurre un error al actualizar, se muestra un mensaje de error detallado
            return redirect()
                ->route('admin.prefijo_telefono.index')
                ->with('error', 'Ocurrió un error al actualizar el prefijo: ' . $e->getMessage());
        }
    }

    /**
     * Realiza el eliminado lógico del prefijo (sin borrarlo de la base de datos).
     */
    public function destroy($id)
    {
        // Se busca el registro por su ID
        $prefijo = PrefijoTelefono::find($id);

        // Si el prefijo existe, se cambia su estado a inactivo (status = false)
        if ($prefijo) {
            $prefijo->update(['status' => false]);

            // Se redirige con un mensaje de éxito
            return redirect()
                ->route('admin.prefijo_telefono.index')
                ->with('success', 'Prefijo eliminado correctamente.');
        }

        // Si no se encuentra el registro, se devuelve un mensaje de error
        return redirect()
            ->route('admin.prefijo_telefono.index')
            ->with('error', 'El prefijo no fue encontrado.');
    }
}
