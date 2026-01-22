<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
        /**
     * Verifica si hay un Calendario Escolar activo
     */
    private function verificarAnioEscolar()
    {
        return \App\Models\AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('name', 'asc')
            ->paginate(10);

        // Verificar si hay Calendario Escolar activo
        $anioEscolarActivo = $this->verificarAnioEscolar();

        return view('admin.roles.index', compact('roles', 'anioEscolarActivo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);

        // Verificar si ya existe una discapacidad con el mismo nombre
        // Si existe uno con "status = true", no se permite crear un duplicado.
        /* $existe = Role::where('name', $validated['name_rol'])
            ->where('status', true)
            ->exists();

        // Si ya existe un registro activo con el mismo prefijo, se muestra un mensaje de error.
        if ($existe) {
            return redirect()
                ->route('admin.roles.index')
                ->with('error', 'Esta rol ya está registrado.');
        } */

        try {
            // Crear nueva discapacidad
            $role = new Role();
            $role->name = $validated['name'];
            $role->guard_name = 'web';
            $role->save();

            // Retornar mensaje de éxito
            return redirect()
                ->route('admin.roles.index')
                ->with('success', 'Rol creado correctamente.');
        } catch (\Exception $e) {
            // Manejo de errores durante la inserción
            return redirect()
                ->route('admin.roles.index')
                ->with('error', 'Error al crear el rol: ' . $e->getMessage());
        }    
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
        ]);

        try {
            // Crear nueva discapacidad
            $role = Role::findOrFail($id);
            $role->name = $validated['name'];
            $role->guard_name = 'web';
            $role->save();

            // Retornar mensaje de éxito
            return redirect()
                ->route('admin.roles.index')
                ->with('success', 'Rol actualizado correctamente.');
        } catch (\Exception $e) {
            // Manejo de errores durante la inserción
            return redirect()
                ->route('admin.roles.index')
                ->with('error', 'Error al actualizar el rol: ' . $e->getMessage());
        }    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Crear nueva discapacidad
            $role = Role::find($id);
            $role->delete();

            // Retornar mensaje de éxito
            return redirect()
                ->route('admin.roles.index')
                ->with('success', 'Rol eliminado correctamente.');
        } catch (\Exception $e) {
            // Manejo de errores durante la inserción
            return redirect()
                ->route('admin.roles.index')
                ->with('error', 'Error al eliminar el rol: ' . $e->getMessage());
        }    
    }
}
