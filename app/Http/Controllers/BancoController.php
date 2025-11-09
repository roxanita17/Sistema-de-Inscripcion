<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    /**
     * Muestra el listado completo de bancos registrados.
     * 
     * Se obtienen todos los registros ordenados por el código del banco
     * y se envían a la vista correspondiente.
     */
    public function index()
    {
        // Se obtienen todos los bancos ordenados por código
        $bancos = Banco::orderBy('codigo_banco', 'asc')->get();

        // Se envían los datos a la vista
        return view('admin.banco.index', compact('bancos'));
    }

    /**
     * Crea un nuevo registro de banco.
     * 
     * Se valida que el código sea único y que el nombre sea válido.
     * Si la validación pasa, se guarda el nuevo banco con estado activo.
     */
    public function store(Request $request)
    {
        // Validación de campos
        $validated = $request->validate([
            // Se exige que el código sea numérico (1 a 4 dígitos) y único
            'codigo_banco' => 'required|digits_between:1,4|unique:bancos,codigo_banco',

            // El nombre es obligatorio y debe tener una longitud válida
            'nombre_banco' => 'required|string|max:255',
        ]);

        try {
            // Se crea una nueva instancia del modelo Banco
            $banco = new Banco();
            $banco->codigo_banco = $validated['codigo_banco'];
            $banco->nombre_banco = $validated['nombre_banco'];
            $banco->status = true; // Estado activo por defecto
            $banco->save();

            // Mensaje de éxito
            return redirect()
                ->route('admin.banco.index')
                ->with('success', 'Banco creado exitosamente.');
        } catch (\Exception $e) {
            // Manejo de excepciones en caso de error al guardar
            return redirect()
                ->route('admin.banco.index')
                ->with('error', 'Error al crear el banco: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza los datos de un banco existente.
     * 
     * Se valida que el nuevo código no se repita (excepto para el mismo registro)
     * y se actualizan los campos correspondientes.
     */
    public function update(Request $request, $id)
    {
        // Se busca el banco por su ID, o lanza error si no existe
        $banco = Banco::findOrFail($id);

        // Validación con exclusión del mismo ID en la regla de unicidad
        $validated = $request->validate([
            'codigo_banco' => 'required|digits_between:1,4|unique:bancos,codigo_banco,' . $banco->id,
            'nombre_banco' => 'required|string|max:255',
        ]);

        try {
            // Se actualizan los datos del banco
            $banco->codigo_banco = $validated['codigo_banco'];
            $banco->nombre_banco = $validated['nombre_banco'];
            $banco->save();

            // Mensaje de confirmación
            return redirect()
                ->route('admin.banco.index')
                ->with('success', 'Banco actualizado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error en la actualización
            return redirect()
                ->route('admin.banco.index')
                ->with('error', 'Error al actualizar el banco: ' . $e->getMessage());
        }
    }

    /**
     * Realiza una baja lógica de un banco.
     * 
     * En lugar de eliminar el registro, se marca como inactivo cambiando el estado.
     */
    public function destroy($id)
    {
        try {
            // Se busca el banco por ID
            $banco = Banco::find($id);

            if ($banco) {
                // Se desactiva el banco (baja lógica)
                $banco->update(['status' => false]);

                return redirect()
                    ->route('admin.banco.index')
                    ->with('success', 'Banco eliminado correctamente.');
            }

            // En caso de que no se encuentre el registro
            return redirect()
                ->route('admin.banco.index')
                ->with('error', 'Banco no encontrado.');
        } catch (\Exception $e) {
            // Manejo de errores en la operación de eliminación
            return redirect()
                ->route('admin.banco.index')
                ->with('error', 'Error al eliminar el banco: ' . $e->getMessage());
        }
    }
}
