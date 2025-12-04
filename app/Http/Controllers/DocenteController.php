<?php

namespace App\Http\Controllers;

use App\Models\DetalleDocenteEstudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Docente;
use App\Models\Persona;
use App\Models\Genero;
use App\Models\PrefijoTelefono;
use App\Models\TipoDocumento;
use App\Models\EstudiosRealizado;
use App\Models\DocenteEstudioRealizado;
use Barryvdh\DomPDF\Facade\Pdf;

class DocenteController extends Controller
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
     * Muestra el listado de docentes
     */
    public function index()
    {
        $buscar = request('buscar');
        $personas = Persona::all();
        $prefijos = PrefijoTelefono::all();

        $docentes = Docente::with(['persona'])
            ->whereHas('persona', function($query) {
                $query->where('status', true);
            })
            ->where('status', true)
            ->buscar($buscar)
            ->paginate(10);

        $anioEscolarActivo = $this->verificarAnioEscolar();

        return view('admin.docente.index', compact('docentes', 'anioEscolarActivo', 'personas', 'buscar'));
    }

    /**
     * Muestra el formulario de creación
     */
    public function create()
    {
        $personas = Persona::all();
        $prefijos = PrefijoTelefono::all();
        $generos = Genero::all();
        $tipoDocumentos = TipoDocumento::all();
        $docentes = Docente::all();

        return view('admin.docente.create', compact('personas', 'prefijos', 'generos', 'tipoDocumentos', 'docentes'));
    }

    /**
     * Guarda un nuevo docente
     */
    public function store(Request $request)
    {
        // VALIDACIÓN
        $validated = $request->validate([
            'tipo_documento_id' => 'required|exists:tipo_documentos,id',
            'numero_documento' => 'required|string|max:20',
            'primer_nombre' => 'required|string|max:50',
            'segundo_nombre' => 'nullable|string|max:50',
            'tercer_nombre' => 'nullable|string|max:50',
            'primer_apellido' => 'required|string|max:50',
            'segundo_apellido' => 'nullable|string|max:50',
            'genero' => 'required|exists:generos,id',
            'fecha_nacimiento' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            ],
            'correo' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:255',
            'prefijo_id' => 'nullable|exists:prefijo_telefonos,id',
            'primer_telefono' => 'nullable|string|max:20',
            'segundo_telefono' => 'nullable|string|max:20',
            'codigo' => 'nullable|numeric',
            'dependencia' => 'nullable|string|max:100',
        ], [
            'tipo_documento_id.required' => 'El tipo de documento es obligatorio',
            'numero_documento.required' => 'La cédula es obligatoria',
            'numero_documento.unique' => 'Esta cédula ya está registrada',
            'primer_nombre.required' => 'El primer nombre es obligatorio',
            'primer_apellido.required' => 'El primer apellido es obligatorio',
            'genero.required' => 'El género es obligatorio',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
            'fecha_nacimiento.before_or_equal' => 'La fecha de nacimiento debe corresponder a una persona mayor de 18 años',
            'correo.email' => 'El correo electrónico no tiene un formato válido',
        ]);

        DB::beginTransaction();

        try {
            // 1. GUARDAR PERSONA
            $persona = Persona::create([
                'primer_nombre' => $request->primer_nombre,
                'segundo_nombre' => $request->segundo_nombre,
                'tercer_nombre' => $request->tercer_nombre,
                'primer_apellido' => $request->primer_apellido,
                'segundo_apellido' => $request->segundo_apellido,
                'numero_documento' => $request->numero_documento ,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'direccion' => $request->direccion,
                'email' => $request->correo,
                'status' => true,
                'tipo_documento_id' => $request->tipo_documento_id,
                'genero_id' => $request->genero,
                'localidad_id' => null,
                'prefijo_id' => $request->prefijo_id,
            ]);

            // 2. GUARDAR DOCENTE
            $docente = Docente::create([
                'primer_telefono' => $request->primer_telefono,
                'codigo' => $request->codigo,
                'dependencia' => $request->dependencia,
                'persona_id' => $persona->id,
                'status' => true,
            ]);

            DB::commit();

            return redirect()->route('admin.docente.estudios', $docente->id)
                ->with('success', 'Docente registrado correctamente, ahora puede agregar sus estudios.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el formulario de edición
     */
    public function edit($id)
    {
        $docente = Docente::with('persona')->findOrFail($id);
        $prefijos = PrefijoTelefono::all();
        $generos = Genero::all();
        $tipoDocumentos = TipoDocumento::all();

        return view('admin.docente.edit', compact('docente', 'prefijos', 'generos', 'tipoDocumentos'));
    }

    /**
     * Actualiza un docente existente
     */
    public function update(Request $request, $id)
    {
        $docente = Docente::findOrFail($id);
        $persona = $docente->persona;

        // VALIDACIÓN (excluyendo la cédula actual)
        $validated = $request->validate([
            'tipo_documento_id' => 'required|exists:tipo_documentos,id',
            'numero_documento' => 'required|string|max:20' . $persona->numero_documento,
            'primer_nombre' => 'required|string|max:50',
            'segundo_nombre' => 'nullable|string|max:50',
            'tercer_nombre' => 'nullable|string|max:50',
            'primer_apellido' => 'required|string|max:50',
            'segundo_apellido' => 'nullable|string|max:50',
            'genero' => 'required|exists:generos,id',
            'fecha_nacimiento' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            ],
            'correo' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:255',
            'prefijo_id' => 'nullable|exists:prefijo_telefonos,id',
            'primer_telefono' => 'nullable|string|max:20',
            'codigo' => 'nullable|numeric',
            'dependencia' => 'nullable|string|max:100',
        ], [
            'tipo_documento_id.required' => 'El tipo de documento es obligatorio',
            'numero_documento.required' => 'La cédula es obligatoria',
            'numero_documento.unique' => 'Esta cédula ya está registrada',
            'primer_nombre.required' => 'El primer nombre es obligatorio',
            'primer_apellido.required' => 'El primer apellido es obligatorio',
            'genero.required' => 'El género es obligatorio',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
            'fecha_nacimiento.before_or_equal' => 'La fecha de nacimiento debe corresponder a una persona mayor de 18 años',
            'correo.email' => 'El correo electrónico no tiene un formato válido',
        ]);

        DB::beginTransaction();

        try {
            // 1. ACTUALIZAR PERSONA
            $persona->update([
                'primer_nombre' => $request->primer_nombre,
                'segundo_nombre' => $request->segundo_nombre,
                'tercer_nombre' => $request->tercer_nombre,
                'primer_apellido' => $request->primer_apellido,
                'segundo_apellido' => $request->segundo_apellido,
                'numero_documento' => $request->numero_documento,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'direccion' => $request->direccion,
                'email' => $request->correo,
                'tipo_documento_id' => $request->tipo_documento_id,
                'genero_id' => $request->genero,
                'prefijo_id' => $request->prefijo_id,
            ]);

            // 2. ACTUALIZAR DOCENTE
            $docente->update([
                'primer_telefono' => $request->primer_telefono,
                'codigo' => $request->codigo,
                'dependencia' => $request->dependencia,
            ]);

            DB::commit();

            return redirect()->route('admin.docente.estudios', $docente->id)
                ->with('success', 'Docente actualizado correctamente, ahora puede editar sus estudios.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

        /**
     * Muestra los detalles de un docente
     */
    public function show($id)
    {
        $docente = Docente::with([
                'persona.tipoDocumento',
                'persona.genero',
                'persona.prefijoTelefono',
                'detalleEstudios' => function ($q) {
                    $q->where('status', true);
                },
                'detalleEstudios.estudiosRealizado'
            ])
            ->findOrFail($id);

            return view('admin.docente.modales.showModal', compact('docente'));
        }

    /**
     * Registro de estudios del docente, componente livewire
     */
    public function estudios($id)
    {
        $docentes = Docente::with(['persona.tipoDocumento', 'persona.genero', 'persona.prefijoTelefono'])
            ->findOrFail($id);
        $estudios = EstudiosRealizado::all();
        $docenteEstudios = DetalleDocenteEstudio::all();

        return view('admin.docente.estudios', compact('docentes', 'estudios', 'docenteEstudios'));
    }

    /**
     * Eliminación lógica del docente y su persona
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $docente = Docente::findOrFail($id);
            $persona = $docente->persona;

            // ELIMINACIÓN LÓGICA
            $docente->update(['status' => false]);
            $persona->update(['status' => false]);

            DB::commit();

            return redirect()->route(route: 'admin.docente.index')
                ->with('success', 'Docente eliminado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }


public function reportePDF($id)
{
    try {
        // Cargar el docente con las relaciones necesarias
        $docente = Docente::with([
            'persona.tipoDocumento',
            'persona.genero',
            'detalleDocenteEstudio.estudiosRealizado'
        ])->findOrFail($id);

        // Verificar si se cargaron los datos de la persona
        if ($docente->persona) {
            // Cargar explícitamente las relaciones si no están cargadas
            if (!$docente->persona->relationLoaded('genero')) {
                $docente->persona->load('genero');
            }
            if (!$docente->persona->relationLoaded('tipoDocumento')) {
                $docente->persona->load('tipoDocumento');
            }

            // Mapear los datos de la persona al objeto docente
            $docente->tipo_documento = $docente->persona->tipoDocumento->nombre ?? 'N/A';
            $docente->numero_documento = $docente->persona->numero_documento ?? 'N/A';
            $docente->primer_nombre = $docente->persona->primer_nombre ?? 'N/A';
            $docente->segundo_nombre = $docente->persona->segundo_nombre ?? '';
            $docente->tercer_nombre = $docente->persona->tercer_nombre ?? '';
            $docente->primer_apellido = $docente->persona->primer_apellido ?? 'N/A';
            $docente->segundo_apellido = $docente->persona->segundo_apellido ?? '';
            $docente->fecha_nacimiento = $docente->persona->fecha_nacimiento ?? 'N/A';
            $docente->genero = $docente->persona->genero ? $docente->persona->genero->genero : 'N/A';
            $docente->email = $docente->persona->email ?? 'N/A';
            $docente->direccion = $docente->persona->direccion ?? 'N/A';
            $docente->telefono = $docente->primer_telefono ?? $docente->segundo_telefono ?? 'N/A';
        }

        // Para depuración
        // return response()->json($docente);

        $pdf = PDF::loadView('admin.docente.reportes.individual_PDF', [
            'docente' => $docente
        ]);

        return $pdf->stream('docente_' . ($docente->numero_documento ?? $docente->id) . '.pdf');

    } catch (\Exception $e) {
        return response('Error al generar el PDF: ' . $e->getMessage(), 500);
    }
}

public function reporteGeneralPDF()
{
    try {
        $docentes = Docente::with([
            'persona.tipoDocumento',
            'persona.genero',
            'detalleDocenteEstudio.estudiosRealizado'
        ])->get()->map(function($docente) {
            if ($docente->persona) {
                // Mapear los datos de la persona al objeto docente
                $docente->tipo_documento = $docente->persona->tipoDocumento->nombre ?? 'N/A';
                $docente->numero_documento = $docente->persona->numero_documento ?? 'N/A';
                $docente->primer_nombre = $docente->persona->primer_nombre ?? 'N/A';
                $docente->segundo_nombre = $docente->persona->segundo_nombre ?? '';
                $docente->tercer_nombre = $docente->persona->tercer_nombre ?? '';
                $docente->primer_apellido = $docente->persona->primer_apellido ?? 'N/A';
                $docente->segundo_apellido = $docente->persona->segundo_apellido ?? '';
                $docente->fecha_nacimiento = $docente->persona->fecha_nacimiento ?? 'N/A';
                $docente->genero = $docente->persona->genero ? $docente->persona->genero->genero : 'N/A';
                $docente->email = $docente->persona->email ?? 'N/A';
                $docente->direccion = $docente->persona->direccion ?? 'N/A';
                $docente->telefono = $docente->primer_telefono ?? $docente->persona->telefono ?? 'N/A';
            }
            return $docente;
        });

        $pdf = PDF::loadView('admin.docente.reportes.general_pdf', [
            'docentes' => $docentes
        ]);

        return $pdf->stream('docentes_general.pdf');
    } catch (\Exception $e) {
        return response('Error al generar el PDF: ' . $e->getMessage(), 500);
    }
}

    }


