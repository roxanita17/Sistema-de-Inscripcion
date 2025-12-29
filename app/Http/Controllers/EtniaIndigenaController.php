<?php

namespace App\Http\Controllers;

use App\Models\EtniaIndigena;
use Illuminate\Http\Request;

class EtniaIndigenaController extends Controller
{
        /**
     * Verifica si hay un año escolar activo
     */
    private function verificarAnioEscolar()
    {
        return \App\Models\AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();
    }


    /**
     * Muestra la lista de etnias indígenas registradas.
     */
    public function index()
    {
        $buscar = request('buscar');
        
        // Construir la consulta base
        $query = EtniaIndigena::query();
        
        // Aplicar búsqueda
        if (!empty($buscar)) {
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                  ->orWhere('id', 'LIKE', "%{$buscar}%");
            });
        }
        
        // Filtrar solo activos
        $query->where('status', true);
        
        // Ordenar y paginar
        $etniaIndigena = $query->orderBy('nombre', 'asc')
                             ->paginate(10)
                             ->appends(request()->query());

        // Verificar si hay año escolar activo
        $anioEscolarActivo = $this->verificarAnioEscolar();

        // Retornar la vista principal con los datos obtenidos
        return view("admin.etnia_indigena.index", compact(
            "etniaIndigena", 
            "anioEscolarActivo",
            'buscar'
        ));
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
     * Verifica si ya existe una etnia indígena con el nombre proporcionado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verificarExistencia(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
            ]);

            $existe = EtniaIndigena::where('nombre', $request->nombre)
                ->where('status', true)
                ->exists();

            return response()->json([
                'success' => true,
                'existe' => $existe
            ]);

        } catch (\Exception $e) {
            \Log::error('Error en verificarExistencia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar la etnia indígena',
                'error' => $e->getMessage()
            ], 500);
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
