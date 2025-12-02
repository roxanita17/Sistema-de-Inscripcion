<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Representante;
use App\Models\RepresentanteLegal;
use App\Models\AnioEscolar;
use App\Models\Persona;
use App\Models\InstitucionProcedencia;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Localidad;
use App\Models\Banco;
use App\Models\EtniaIndigena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\NuevoIngreso;


class NuevoIngresoController extends Controller
{
    /**
     * la vista principal de nuevo ingreso
     */
    public function index()
    {
        $anoActivo = AnioEscolar::whereIn("status", [
            'Activo',
            'Extendido'
        ])->first();

        return view('admin.nuevo_ingreso.index', compact('anoActivo'));
    }

    /**
     * formulario de nuevo ingreso (para rutas que ya existen en el proyecto)
     */
    public function formulario()
    {
        $anoActivo = AnioEscolar::whereIn("status", [
            'Activo',
            'Extendido'
        ])->first();

        if (!$anoActivo) {
            return redirect()->route('admin.nuevo_ingreso.index')
                ->with('error', 'No hay año escolar activo para realizar inscripciones.');
        }

        // Redirigir al flujo de inscripción paso a paso
        return redirect()->route('admin.inscripcion.estudiante');
    }

    //  formulario del estudiante
    public function showEstudianteForm()
    {
        $estados = Estado::orderBy('nombre_estado', 'asc')->get();
        $municipios = Municipio::orderBy('nombre_municipio', 'asc')->get();
        $parroquias = Localidad::get();

        $instituciones = InstitucionProcedencia::where('status', true)
                                   ->orderBy('nombre_institucion', 'asc')
                                   ->get();

        $etniasIndigenas = EtniaIndigena::orderBy('nombre', 'asc')->get();

        // Limpiar sesión si es una nueva inscripción (osea que empieza de nuevo)
        if (!request()->has('continuar')) {
            Session::forget('inscripcion_data');
        }

        $instituciones = InstitucionProcedencia::all();
        $estados = Estado::all();
        $municipios = Municipio::all();
        $parroquias_cargadas = Localidad::all();
        $etniasIndigenas = EtniaIndigena::all();

        // Listas para selects (usar personas asociadas)
        $estudiantesLista = DB::table('estudiantes')
            ->join('personas', 'estudiantes.persona_id', '=', 'personas.id')
            ->leftJoin('tipo_documentos', 'personas.tipo_documento_id', '=', 'tipo_documentos.id')
            ->select(
                'estudiantes.id',
                DB::raw("COALESCE(tipo_documentos.tipo_documento, '') as tipo_documento"),
                'personas.numero_documento as numero_documento',
                'personas.primer_nombre as primer_nombre',
                'personas.primer_apellido as primer_apellido'
            )
            ->orderBy('personas.primer_apellido')
            ->get();

        $representantesLista = DB::table('representantes')
            ->join('personas', 'representantes.persona_id', '=', 'personas.id')
            ->leftJoin('tipo_documentos', 'personas.tipo_documento_id', '=', 'tipo_documentos.id')
            ->select(
                'representantes.id',
                DB::raw("COALESCE(tipo_documentos.tipo_documento, '') as tipo_documento"),
                'personas.numero_documento as numero_documento',
                'personas.primer_nombre as primer_nombre',
                'personas.primer_apellido as primer_apellido'
            )
            ->orderBy('personas.primer_apellido')
            ->get();

        $representantesLegalesLista = DB::table('representante_legal')
            ->join('representantes', 'representante_legal.representante_id', '=', 'representantes.id')
            ->join('personas', 'representantes.persona_id', '=', 'personas.id')
            ->leftJoin('tipo_documentos', 'personas.tipo_documento_id', '=', 'tipo_documentos.id')
            ->select(
                'representante_legal.id',
                DB::raw("COALESCE(tipo_documentos.tipo_documento, '') as tipo_documento"),
                'personas.numero_documento as numero_documento',
                'personas.primer_nombre as primer_nombre',
                'personas.primer_apellido as primer_apellido'
            )
            ->orderBy('personas.primer_apellido')
            ->get();

        // Logs de diagnóstico
        \Log::info('NuevoIngresoController@showEstudianteForm - conteos', [
            'estudiantes' => $estudiantesLista->count(),
            'representantes' => $representantesLista->count(),
            'representantes_legales' => $representantesLegalesLista->count(),
        ]);
        if ($estudiantesLista->count() === 0) {
            \Log::warning('No hay estudiantes con persona asociada o tipo_documento_id. Verificar datos en tablas estudiantes/personas/tipo_documentos.');
        }
        if ($representantesLista->count() === 0) {
            \Log::warning('No hay representantes con persona asociada. Verificar datos en tablas representantes/personas.');
        }
        if ($representantesLegalesLista->count() === 0) {
            \Log::warning('No hay registros en representante_legal vinculados a personas.');
        }

        return view('admin.nuevo_ingreso.formulario', compact(
            'instituciones',
            'estados',
            'municipios',
            'parroquias_cargadas',
            'etniasIndigenas',
            'estudiantesLista',
            'representantesLista',
            'representantesLegalesLista',
        ));
    }

    // Guardar datos del estudiante en sesión
    public function storeEstudiante(Request $request)
    {
        Log::info('NuevoIngresoController::storeEstudiante - Iniciando');
        Log::info('Datos recibidos:', $request->all());

        try {
            $validated = $request->validate([
                'tipo_numero_documento_persona' => 'required',
                'numero_numero_documento_persona' => 'required',
                'fecha_nacimiento_personas' => 'required|date',
                'primer_nombre' => 'required|string|max:255',
                'segundo_nombre' => 'nullable|string|max:255',
                'tercer_nombre' => 'nullable|string|max:255',
                'primer_apellido' => 'required|string|max:255',
                'segundo_apellido' => 'nullable|string|max:255',
                'tipo_documento_id' => 'required|exists:tipo_documentos,id',
                'genero_id' => 'required|exists:generos,id',
                'localidad_id' => 'required|exists:localidades,id',
                
                'lateralidad_estudiante' => 'required',
                'orden_nacimiento_estudiante' => 'required',
                'numero_zonificacion_plantel' => 'nullable|numeric',
                'institucion_id' => 'required|exists:instituciones,id',
                'expresion_literaria' => 'required|in:A,B,C',
                'ano_ergreso_estudiante' => 'required|date',
                'talla_estudiante' => 'required|numeric',
                'peso_estudiante' => 'required|numeric',
                'talla_camisa' => 'required|in:XS,S,M,L,XL',
                'talla_zapato' => 'required|integer|between:30,45',
                'talla_pantalon' => 'required|in:XS,S,M,L,XL',
                'direccion_persona' => 'required|string|max:500',
                'documentos_estudiante' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            ]);

            // Guardar en sesión
            Session::put('inscripcion_data.estudiante', $validated);
            Session::put('inscripcion_data.paso_actual', 2);

            // Guardar archivo si existe
            if ($request->hasFile('documentos_estudiante')) {
                $archivo = $request->file('documentos_estudiante');
                $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
                $archivo->storeAs('documentos_estudiantes', $nombreArchivo, 'public');
                Session::put('inscripcion_data.documento_estudiante', $nombreArchivo);
            }

            Log::info('NuevoIngresoController::storeEstudiante - Completado exitosamente');

            return response()->json([
                'success' => true,
                'message' => 'Datos del estudiante guardados correctamente',
                'redirect' => route('admin.inscripcion.representante')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('NuevoIngresoController::storeEstudiante - Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar datos del estudiante: ' . $e->getMessage()
            ], 500);
        }
    }

    //  formulario del representante
    public function showRepresentanteForm()
    {
        // Verificar que existe data del estudiante
        if (!Session::has('inscripcion_data.estudiante')) {
            return redirect()->route('admin.inscripcion.estudiante')
                ->with('error', 'Debe completar los datos del estudiante primero.');
        }

        $estados = Estado::all();
        $municipios = Municipio::all();
        $parroquias_cargadas = Parroquia::all();
        $bancos = Banco::all();

        return view('modules.estudiante.formulario_representante', compact(
            'estados',
            'municipios',
            'parroquias_cargadas',
            'bancos'
        ));
    }

    // Guardar datos del representante en sesión
    public function storeRepresentante(Request $request)
    {
        Log::info('NuevoIngresoController::storeRepresentante - Iniciando');
        Log::info('Datos recibidos:', $request->all());

        try {
            // campos de progenitor solamente
            $validated = $request->validate([
                'tipo_numero_documento_persona' => 'required|in:V,E,J',
                'numero_numero_documento_persona' => 'required|numeric|digits_between:1,8',
                'genero_id' => 'required|exists:generos,id',
                'primer_nombre' => 'required|string|max:255',
                'segundo_nombre' => 'nullable|string|max:255',
                'tercer_nombre' => 'nullable|string|max:255',
                'primer_apellido' => 'required|string|max:255',
                'segundo_apellido' => 'nullable|string|max:255',
                'tipo_documento_id' => 'required|exists:tipo_documentos,id',
                'genero_id' => 'required|exists:generos,id',
                'localidad_id' => 'required|exists:localidades,id',
                'fecha_nacimiento_personas' => 'required|date',
                'lugar_nacimiento_persona' => 'required|string|max:30',
                'estado_id' => 'required|exists:estados,id',
                'municipio_id' => 'required|exists:municipios,id',
                'parroquia_id' => 'required|exists:parroquias,id',
                'prefijo_telefono_personas' => 'required|in:0412,0414,0416,0424,0426',
                'telefono_personas' => 'required|numeric|digits_between:7,11',
                'ocupacion_representante' => 'required|string|max:255',
                'convivenciaestudiante_representante' => 'required|in:si,no',
            ]);

            // Forzar tipo progenitor
            $validated['tipo_representante'] = 'progenitor';



            // Guardar en sesión
            Session::put('inscripcion_data.representante', $validated);
            Session::put('inscripcion_data.paso_actual', 3);

            // Forzar guardado de sesión
            Session::save();

            Log::info('Datos guardados en sesión:', [
                'tiene_estudiante' => Session::has('inscripcion_data.estudiante'),
                'tiene_representante' => Session::has('inscripcion_data.representante'),
                'paso_actual' => Session::get('inscripcion_data.paso_actual'),
                'session_id' => Session::getId()
            ]);

            Log::info('NuevoIngresoController::storeRepresentante - Completado exitosamente');

            return response()->json([
                'success' => true,
                'message' => 'Datos del representante guardados correctamente',
                'redirect' => route('admin.inscripcion.final'),
                'debug' => [
                    'session_estudiante' => Session::has('inscripcion_data.estudiante'),
                    'session_representante' => Session::has('inscripcion_data.representante'),
                    'paso_actual' => Session::get('inscripcion_data.paso_actual')
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('NuevoIngresoController::storeRepresentante - Error de validación: ' . $e->getMessage());
            Log::error('Errores de validación:', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('NuevoIngresoController::storeRepresentante - Error general: ' . $e->getMessage());
            Log::error('Stack trace:', ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar datos del representante: ' . $e->getMessage()
            ], 500);
        }
    }

    // Mostrar formulario final de inscripción
    public function showFinalForm()
    {
        Log::info('NuevoIngresoController::showFinalForm - Verificando sesión');
        Log::info('Estado de sesión:', [
            'tiene_estudiante' => Session::has('inscripcion_data.estudiante'),
            'tiene_representante' => Session::has('inscripcion_data.representante'),
            'paso_actual' => Session::get('inscripcion_data.paso_actual', 'no definido'),
            'session_id' => Session::getId()
        ]);

        // Verificar que existen ambos datos de estudiante y representante
        if (!Session::has('inscripcion_data.estudiante') || !Session::has('inscripcion_data.representante')) {
            Log::warning('NuevoIngresoController::showFinalForm - Sesión incompleta, redirigiendo a estudiante');
            return redirect()->route('admin.inscripcion.estudiante')
                ->with('error', 'Debe completar todos los pasos de la inscripción.');
        }

        $data = Session::get('inscripcion_data');
        $anoActivo = AnioEscolar::whereIn('status', [
            'Activo',
            'Extendido'
        ])->first();

        if (!$anoActivo) {
            return redirect()->route('admin.inscripcion.estudiante')
                ->with('error', 'No hay año escolar activo para realizar inscripciones.');
        }

        Log::info('NuevoIngresoController::showFinalForm - Mostrando formulario final');
        return view('admin.inscripcion.final', compact('data', 'anoActivo'));
    }

    public function completarInscripcion(Request $request)
    {
        // Si vienen IDs seleccionados, usar flujo por selección (sin depender de sesión)
        if ($request->filled('estudiante_id')) {
            $validated = $request->validate([
                'estudiante_id' => 'required|exists:estudiantes,id',
                'representante_padre_id' => 'nullable|exists:representantes,id',
                'representante_madre_id' => 'nullable|exists:representantes,id',
                'representante_legal_id' => 'nullable|exists:representante_legal,id',
                'fecha_inscripcion' => 'required|date',
                'ano_escolar' => 'required|exists:anio_escolars,id',
                'grado_academico' => 'required|integer|between:1,5',
                'documentos' => 'required|array|min:1',
                'observaciones' => 'nullable|string|max:500',
            ]);

            $nuevo = NuevoIngreso::create([
                'estudiante_id' => $validated['estudiante_id'],
                'representante_id' => $validated['representante_padre_id'] ?? null, // compat
                'representante_padre_id' => $validated['representante_padre_id'] ?? null,
                'representante_madre_id' => $validated['representante_madre_id'] ?? null,
                'representante_legal_id' => $validated['representante_legal_id'] ?? null,
                'ano_escolar_id' => $validated['ano_escolar'],
                'fecha_inscripcion' => $validated['fecha_inscripcion'],
                'grado_academico' => $validated['grado_academico'],
                'documentos_entregados' => json_encode($validated['documentos']),
                'observaciones' => $validated['observaciones'] ?? null,
                'status' => 'pendiente',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Inscripción de nuevo ingreso creada correctamente.',
                'nuevo_ingreso_id' => $nuevo->id,
                'redirect' => route('admin.nuevo_ingreso.index')
            ]);
        }

        // Flujo anterior: Verificar que existen todos los datos en sesión
        if (!Session::has('inscripcion_data.estudiante') || !Session::has('inscripcion_data.representante')) {
            Log::error('Datos de sesión incompletos', [
                'tiene_estudiante' => Session::has('inscripcion_data.estudiante'),
                'tiene_representante' => Session::has('inscripcion_data.representante')
            ]);

            return response()->json([
                'success' => false,
                'message' => 'No se encontraron los datos de inscripción completos. Por favor, complete todos los pasos.'
            ], 400);
        }

        $validated = $request->validate([
            'fecha_inscripcion' => 'required|date',
            'ano_escolar' => 'required|exists:anio_escolars,id',
            'grado_academico' => 'required|integer|between:1,5',
            // 'seccion_academico' => 'nullable|in:A,B,C,D,E,F',
            'documentos' => 'required|array|min:1',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $inscripcionData = Session::get('inscripcion_data');

        try {
            // Pasar el documento del estudiante a los datos del estudiante
            $datosEstudiante = $inscripcionData['estudiante'];
            $datosEstudiante['documento_estudiante'] = $inscripcionData['documento_estudiante'] ?? null;

            Log::info('Intentando guardar inscripción completa...');

            // Usar  modelo para guardar toda la inscripción
            $resultado = NuevoIngreso::guardarInscripcionCompleta(
                $datosEstudiante,
                $inscripcionData['representante'],
                $validated
            );

            // Verificar la estructura del resultado
            if (is_array($resultado) && count($resultado) >= 2) {
                [$success, $message] = $resultado;
                $nuevoIngresoId = $resultado[2] ?? null;

                if ($success) {
                    // Limpiar sesión
                    Session::forget('inscripcion_data');

                    Log::info('Inscripción completada exitosamente', ['id' => $nuevoIngresoId]);

                    return response()->json([
                        'success' => true,
                        'message' => $message,
                        'nuevo_ingreso_id' => $nuevoIngresoId,
                        'redirect' => route('admin.inscripcion.completada')
                    ]);
                } else {
                    Log::error('Error al guardar inscripción:', ['message' => $message]);
                    return response()->json([
                        'success' => false,
                        'message' => $message
                    ], 500);
                }
            } else {
                Log::error('Resultado inesperado de guardarInscripcionCompleta:', ['resultado' => $resultado]);
                return response()->json([
                    'success' => false,
                    'message' => 'Error inesperado al procesar la inscripción.'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Excepción en completarInscripcion: ' . $e->getMessage());
            Log::error('File: ' . $e->getFile() . ' Line: ' . $e->getLine());

            return response()->json([
                'success' => false,
                'message' => 'Error al completar la inscripción: ' . $e->getMessage()
            ], 500);
        }
    }

    public function listarInscripciones(Request $request)
{
    try {
        $buscar = $request->get('search', '');
        $nuevosIngresos = NuevoIngreso::obtenerDatosInscripcion($buscar);

        $data = $nuevosIngresos->map(function($nuevoIngreso) {
            // Acceder directamente a las propiedades del objeto para construir el nombre completo
            $nombreCompleto = $nuevoIngreso->estudiante_nombre1 . ' ' .
                            ($nuevoIngreso->estudiante_nombre2 ? ' ' . $nuevoIngreso->estudiante_nombre2 : '') . ' ' .
                            ($nuevoIngreso->estudiante_nombre3 ? ' ' . $nuevoIngreso->estudiante_nombre3 : '') . ' ' .
                            $nuevoIngreso->estudiante_apellido1 . ' ' .
                            ($nuevoIngreso->estudiante_apellido2 ? ' ' . $nuevoIngreso->estudiante_apellido2 : '');

            $numero_documento = $nuevoIngreso->estudiante_tipo_numero_documento . '-' . $nuevoIngreso->estudiante_numero_documento;

            // Para el año escolar
            $anoEscolar = '';
            if ($nuevoIngreso->inicio_anio_escolar && $nuevoIngreso->cierre_anio_escolar) {
                $anoEscolar = $nuevoIngreso->inicio_anio_escolar . ' - ' . $nuevoIngreso->cierre_anio_escolar;
            }

            return [
                'id' => $nuevoIngreso->id,
                'estudiante_id' => $nuevoIngreso->estudiante_id,
                'nombre_completo' => trim($nombreCompleto),
                'numero_documento' => $numero_documento,
                'fecha_inscripcion' => $nuevoIngreso->fecha_inscripcion,
                'estado' => $nuevoIngreso->status,
                'grado' => $nuevoIngreso->grado_academico,
                // 'seccion' => $nuevoIngreso->seccion_academico,
                'ano_escolar' => $anoEscolar
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al cargar los nuevos ingresos: ' . $e->getMessage()
        ], 500);
    }
}

    public function cambiarEstado(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pendiente,completada,rechazada'
            ]);

            $nuevoIngreso = NuevoIngreso::find($id);

            if ($nuevoIngreso) {
                $nuevoIngreso->update([
                    'status' => $validated['status'],
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Estado actualizado correctamente.'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Registro de nuevo ingreso no encontrado.'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    // ver detalles de un nuevo ingreso
    public function verDetalle($id)
    {
        try {
            $nuevoIngreso = NuevoIngreso::with([
                'estudiante.persona',
                'representante.persona',
                'anoEscolar'
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $nuevoIngreso
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar los detalles: ' . $e->getMessage()
            ], 500);
        }
    }

    public function completada()
    {
        return view('inscripcion.completada');
    }

    // ---------------------------------------------------------------


public function editar($id)
{
    try {
        // Obtener nuevo ingreso con todos los datos relacionados
        $nuevoIngreso = DB::table('nuevo_ingresos')
            ->select(
                'nuevo_ingresos.*',
                'estudiantes.id as estudiante_id',
                'estudiantes.institucion_id',
                'estudiantes.orden_nacimiento_estudiante',
                'estudiantes.talla_camisa',
                'estudiantes.talla_pantalon',
                'estudiantes.talla_zapato',
                'estudiantes.talla_estudiante',
                'estudiantes.peso_estudiante',
                'estudiantes.numero_zonificacion_plantel',
                'estudiantes.ano_ergreso_estudiante',
                'estudiantes.expresion_literaria',
                'estudiantes.lateralidad_estudiante',
                'estudiantes.documentos_estudiante',
                'estudiantes.cual_pueblo_indigna',
                'estudiantes.discapacidad_estudiante',

                'estudiante_persona.id as estudiante_persona_id',
                'estudiante_persona.tipo_numero_documento_persona as estudiante_tipo_numero_documento',
                'estudiante_persona.numero_numero_documento_persona as estudiante_numero_documento',
                'estudiante_persona.fecha_nacimiento_personas as estudiante_fecha_nacimiento',
                'estudiante_persona.primer_nombre as estudiante_nombre1',
                'estudiante_persona.segundo_nombre as estudiante_nombre2',
                'estudiante_persona.tercer_nombre as estudiante_nombre3',
                'estudiante_persona.primer_apellido as estudiante_apellido1',
                'estudiante_persona.segundo_apellido as estudiante_apellido2',
                'estudiante_persona.genero_id as estudiante_sexo',
                'estudiante_persona.direccion_persona as estudiante_direccion',
                'representantes.id as representante_id',
                'representantes.ocupacion_representante',
                'representantes.convivenciaestudiante_representante',
                'representante_persona.id as representante_persona_id',
                'representante_persona.tipo_numero_documento_persona as representante_tipo_numero_documento',
                'representante_persona.numero_numero_documento_persona as representante_numero_documento',
                'representante_persona.fecha_nacimiento_personas as representante_fecha_nacimiento',
                'representante_persona.primer_nombre as representante_nombre1',
                'representante_persona.segundo_nombre as representante_nombre2',
                'representante_persona.tercer_nombre as representante_nombre3',
                'representante_persona.primer_apellido as representante_apellido1',
                'representante_persona.segundo_apellido as representante_apellido2',
                'representante_persona.genero_id as representante_sexo',
                'representante_persona.lugar_nacimiento_persona as representante_lugar_nacimiento',
                'representante_persona.prefijo_telefono_personas as representante_prefijo_telefono',
                'representante_persona.telefono_personas as representante_telefono'
            )
            ->leftJoin('estudiantes', 'nuevo_ingresos.estudiante_id', '=', 'estudiantes.id')
            ->leftJoin('personas as estudiante_persona', 'estudiantes.persona_id', '=', 'estudiante_persona.id')
            ->leftJoin('representantes', 'nuevo_ingresos.representante_id', '=', 'representantes.id')
            ->leftJoin('personas as representante_persona', 'representantes.persona_id', '=', 'representante_persona.id')
            ->where('nuevo_ingresos.id', $id)
            ->first();

        if (!$nuevoIngreso) {
            return redirect()->route('modules.nuevo_ingreso.index')
                ->with('error', 'Inscripción no encontrada.');
        }

        // Cargar datos para los formularios
        $instituciones = DB::table('instituciones')->where('status', true)->get();
        $anosEscolares = DB::table('anio_escolars')->whereIn('status', ['activo', 'extendido'])->get();

        return view('modules.nuevo_ingreso.editar', compact(
            'nuevoIngreso',
            'instituciones',
            'anosEscolares'
        ));

    } catch (\Exception $e) {
        Log::error('Error al cargar formulario de edición: ' . $e->getMessage());
        return redirect()->route('modules.nuevo_ingreso.index')
            ->with('error', 'Error al cargar el formulario de edición.');
    }
}

// para actualizar la inscripción completa
// public function actualizar(Request $request, $id)
// {

//     Log::info('ID de inscripción: ' . $id);
//     Log::info('Datos recibidos:', $request->all());

//     try {
//         DB::beginTransaction();

//         // Validar datos del estudiante
//         $datosEstudiante = $request->validate([
//             'tipo_numero_documento_persona' => 'required',
//             'numero_numero_documento_persona' => 'required',
//             'fecha_nacimiento_personas' => 'required|date',
//             'nombre_uno' => 'required|string|max:255',
//             'nombre_dos' => 'nullable|string|max:255',
//             'nombre_tres' => 'nullable|string|max:255',
//             'apellido_uno' => 'required|string|max:255',
//             'apellido_dos' => 'nullable|string|max:255',
//             'sexo' => 'required',
//             'lateralidad_estudiante' => 'required',
//             'orden_nacimiento_estudiante' => 'required',
//             'numero_zonificacion_plantel' => 'nullable|numeric',
//             'institucion_id' => 'required|exists:instituciones,id',
//             'expresion_literaria' => 'required|in:A,B,C',
//             'ano_ergreso_estudiante' => 'required|date',
//             'talla_estudiante' => 'required|numeric',
//             'peso_estudiante' => 'required|numeric',
//             'talla_camisa' => 'required|in:XS,S,M,L,XL',
//             'talla_zapato' => 'required|integer|between:30,45',
//             'talla_pantalon' => 'required|in:XS,S,M,L,XL',
//             'direccion_persona' => 'required|string|max:500',

//             'cual_pueblo_indigna' => 'nullable|string|max:255',

//             'discapacidad_estudiante' => 'nullable|string|max:255',
//         ]);

//         // Validar datos del representante
//         $datosRepresentante = $request->validate([
//             'rep_tipo_numero_documento_persona' => 'required|in:V,E,J',
//             'rep_numero_numero_documento_persona' => 'required|numeric|digits_between:1,8',
//             'rep_sexo' => 'required|in:Masculino,Femenino',
//             'rep_nombre_uno' => 'required|string|max:255',
//             'rep_nombre_dos' => 'nullable|string|max:255',
//             'rep_apellido_uno' => 'required|string|max:255',
//             'rep_apellido_dos' => 'nullable|string|max:255',
//             'rep_fecha_nacimiento_personas' => 'required|date',
//             'rep_lugar_nacimiento_persona' => 'required|string|max:30',
//             'rep_prefijo_telefono_personas' => 'required|in:0412,0414,0416,0424,0426',
//             'rep_telefono_personas' => 'required|numeric|digits_between:7,11',
//             'rep_ocupacion_representante' => 'required|string|max:255',
//             'rep_convivenciaestudiante_representante' => 'required|in:si,no',
//         ]);

//         // Validar datos de la inscripción
//         $datosInscripcion = $request->validate([
//             'fecha_inscripcion' => 'required|date',
//             'ano_escolar_id' => 'required|exists:anio_escolars,id',
//             'grado_academico' => 'required|integer|between:1,5',
//             'seccion_academico' => 'required|in:A,B,C,D,E,F',
//             'observaciones' => 'nullable|string|max:500',
//             'status' => 'required|in:pendiente,completada,rechazada',
//         ]);

//         // Obtener  registro  nuevo ingreso
//         $nuevoIngreso = DB::table('nuevo_ingresos')->where('id', $id)->first();
//         if (!$nuevoIngreso) {
//             throw new \Exception('Inscripción no encontrada.');
//         }

//         //  Actualizar persona del estudiante
//         DB::table('personas')
//             ->where('id', function($query) use ($nuevoIngreso) {
//                 $query->select('persona_id')
//                       ->from('estudiantes')
//                       ->where('id', $nuevoIngreso->estudiante_id);
//             })
//             ->update([
//                 'tipo_numero_documento_persona' => $datosEstudiante['tipo_numero_documento_persona'],
//                 'numero_numero_documento_persona' => $datosEstudiante['numero_numero_documento_persona'],
//                 'fecha_nacimiento_personas' => $datosEstudiante['fecha_nacimiento_personas'],
//                 'nombre_uno' => $datosEstudiante['nombre_uno'],
//                 'nombre_dos' => $datosEstudiante['nombre_dos'] ?? null,
//                 'nombre_tres' => $datosEstudiante['nombre_tres'] ?? null,
//                 'apellido_uno' => $datosEstudiante['apellido_uno'],
//                 'apellido_dos' => $datosEstudiante['apellido_dos'] ?? null,
//                 'sexo' => $datosEstudiante['sexo'],
//                 'direccion_persona' => $datosEstudiante['direccion_persona'],
//                 'updated_at' => now(),
//             ]);

//         //  Actualizar estudiante
//         $datosEstudianteDB = [
//             'institucion_id' => $datosEstudiante['institucion_id'],
//             'orden_nacimiento_estudiante' => $datosEstudiante['orden_nacimiento_estudiante'],
//             'talla_camisa' => $datosEstudiante['talla_camisa'],
//             'talla_pantalon' => $datosEstudiante['talla_pantalon'],
//             'talla_zapato' => $datosEstudiante['talla_zapato'],
//             'talla_estudiante' => $datosEstudiante['talla_estudiante'],
//             'peso_estudiante' => $datosEstudiante['peso_estudiante'],
//             'numero_zonificacion_plantel' => $datosEstudiante['numero_zonificacion_plantel'] ?? null,
//             'ano_ergreso_estudiante' => $datosEstudiante['ano_ergreso_estudiante'],
//             'expresion_literaria' => $datosEstudiante['expresion_literaria'],
//             'lateralidad_estudiante' => $datosEstudiante['lateralidad_estudiante'],
//             'updated_at' => now(),
//         ];

//         DB::table('estudiantes')
//             ->where('id', $nuevoIngreso->estudiante_id)
//             ->update($datosEstudianteDB);

//         // Actualizar persona del representante
//         DB::table('personas')
//             ->where('id', function($query) use ($nuevoIngreso) {
//                 $query->select('persona_id')
//                       ->from('representantes')
//                       ->where('id', $nuevoIngreso->representante_id);
//             })
//             ->update([
//                 'tipo_numero_documento_persona' => $datosRepresentante['rep_tipo_numero_documento_persona'],
//                 'numero_numero_documento_persona' => $datosRepresentante['rep_numero_numero_documento_persona'],
//                 'fecha_nacimiento_personas' => $datosRepresentante['rep_fecha_nacimiento_personas'],
//                 'nombre_uno' => $datosRepresentante['rep_nombre_uno'],
//                 'nombre_dos' => $datosRepresentante['rep_nombre_dos'] ?? null,
//                 'apellido_uno' => $datosRepresentante['rep_apellido_uno'],
//                 'apellido_dos' => $datosRepresentante['rep_apellido_dos'] ?? null,
//                 'sexo' => $datosRepresentante['rep_sexo'],
//                 'lugar_nacimiento_persona' => $datosRepresentante['rep_lugar_nacimiento_persona'],
//                 'prefijo_telefono_personas' => $datosRepresentante['rep_prefijo_telefono_personas'],
//                 'telefono_personas' => $datosRepresentante['rep_telefono_personas'],
//                 'updated_at' => now(),
//             ]);

//         //  Actualizar representante
//         DB::table('representantes')
//             ->where('id', $nuevoIngreso->representante_id)
//             ->update([
//                 'ocupacion_representante' => $datosRepresentante['rep_ocupacion_representante'],
//                 'convivenciaestudiante_representante' => $datosRepresentante['rep_convivenciaestudiante_representante'],
//                 'updated_at' => now(),
//             ]);

//         //  Actualizar nuevo ingreso
//         DB::table('nuevo_ingresos')
//             ->where('id', $id)
//             ->update([
//                 'ano_escolar_id' => $datosInscripcion['ano_escolar_id'],
//                 'fecha_inscripcion' => $datosInscripcion['fecha_inscripcion'],
//                 'grado_academico' => $datosInscripcion['grado_academico'],
//                 'seccion_academico' => $datosInscripcion['seccion_academico'],
//                 'observaciones' => $datosInscripcion['observaciones'] ?? null,
//                 'status' => $datosInscripcion['status'],
//                 'updated_at' => now(),
//             ]);

//         DB::commit();

//         Log::info('Inscripción actualizada exitosamente: ' . $id);

//         return response()->json([
//             'success' => true,
//             'message' => 'Inscripción actualizada correctamente.',
//             'redirect' => route('modules.nuevo_ingreso.index')
//         ]);

//     } catch (\Illuminate\Validation\ValidationException $e) {
//         DB::rollBack();
//         Log::error('Error de validación en actualización: ' . $e->getMessage());
//         return response()->json([
//             'success' => false,
//             'message' => 'Error de validación',
//             'errors' => $e->errors()
//         ], 422);
//     } catch (\Exception $e) {
//         DB::rollBack();
//         Log::error('Error al actualizar inscripción: ' . $e->getMessage());
//         return response()->json([
//             'success' => false,
//             'message' => 'Error al actualizar la inscripción: ' . $e->getMessage()
//         ], 500);
//     }
// }

// eliminar inscripción
// public function eliminar($id)
// {
//     try {
//         DB::beginTransaction();

//         // Obtener el registro de nuevo ingreso
//         $nuevoIngreso = DB::table('nuevo_ingresos')->where('id', $id)->first();

//         if (!$nuevoIngreso) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Inscripción no encontrada.'
//             ], 404);
//         }

//         // Obtener IDs relacionados
//         $estudianteId = $nuevoIngreso->estudiante_id;
//         $representanteId = $nuevoIngreso->representante_id;

//         // Obtener persona_ids
//         $estudiante = DB::table('estudiantes')->where('id', $estudianteId)->first();
//         $representante = DB::table('representantes')->where('id', $representanteId)->first();

//         $personaEstudianteId = $estudiante->persona_id;
//         $personaRepresentanteId = $representante->persona_id;

//         //  Eliminar nuevo ingreso
//         DB::table('nuevo_ingresos')->where('id', $id)->delete();

//         //  Eliminar estudiante
//         DB::table('estudiantes')->where('id', $estudianteId)->delete();

//         //  Eliminar representante
//         DB::table('representantes')->where('id', $representanteId)->delete();

//         //  Eliminar personas
//         $estudianteEnOtros = DB::table('estudiantes')->where('persona_id', $personaEstudianteId)->exists();
//         $representanteEnOtros = DB::table('representantes')->where('persona_id', $personaRepresentanteId)->exists();

//         if (!$estudianteEnOtros) {
//             DB::table('personas')->where('id', $personaEstudianteId)->delete();
//         }

//         if (!$representanteEnOtros) {
//             DB::table('personas')->where('id', $personaRepresentanteId)->delete();
//         }

//         DB::commit();

//         Log::info('Inscripción eliminada exitosamente: ' . $id);

//         return response()->json([
//             'success' => true,
//             'message' => 'Inscripción eliminada correctamente.'
//         ]);

//     } catch (\Exception $e) {
//         DB::rollBack();
//         Log::error('Error al eliminar inscripción: ' . $e->getMessage());
//         return response()->json([
//             'success' => false,
//             'message' => 'Error al eliminar la inscripción: ' . $e->getMessage()
//         ], 500);
//     }
// }


public function buscar(Request $request)
{
    if($request->ajax()){
        $query = $request->get('query', '');

        if(empty($query)) {
            return response()->json(['html' => '']);
        }

        try {
            $inscripciones = DB::table('nuevo_ingresos')
                ->select(
                    'nuevo_ingresos.*',
                    'estudiantes.id as estudiante_id',

                    'personas.primer_nombre',
                    'personas.segundo_nombre',
                    'personas.tercer_nombre',
                    'personas.primer_apellido',
                    'personas.segundo_apellido',
                    'personas.tipo_documento_id',
                    'personas.numero_documento',
                    'personas.genero_id'
                )
                ->join('estudiantes', 'nuevo_ingresos.estudiante_id', '=', 'estudiantes.id')
                ->join('personas', 'estudiantes.persona_id', '=', 'personas.id')
                ->where(function($q) use ($query) {
                    $q->where('personas.primer_nombre', 'LIKE', "%{$query}%")
                      ->orWhere('personas.segundo_nombre', 'LIKE', "%{$query}%")
                      ->orWhere('personas.tercer_nombre', 'LIKE', "%{$query}%")
                      ->orWhere('personas.primer_apellido', 'LIKE', "%{$query}%")
                      ->orWhere('personas.segundo_apellido', 'LIKE', "%{$query}%")
                      ->orWhere('personas.numero_documento', 'LIKE', "%{$query}%")
                      ->orWhere(DB::raw("CONCAT(personas.primer_nombre, ' ', personas.primer_apellido)"), 'LIKE', "%{$query}%");
                })
                ->orderBy('nuevo_ingresos.created_at', 'desc')
                ->get();

            $html = '';

            if($inscripciones->count() > 0) {
                foreach($inscripciones as $inscripcion) {
                    // Determinar clase de estado
                    $claseEstado = '';
                    $textoEstado = '';

                    switch($inscripcion->status) {
                        case 'pendiente':
                            $claseEstado = 'warning';
                            $textoEstado = 'Pendiente';
                            break;
                        case 'completada':
                            $claseEstado = 'success';
                            $textoEstado = 'Completada';
                            break;
                        case 'rechazada':
                            $claseEstado = 'danger';
                            $textoEstado = 'Rechazada';
                            break;
                        default:
                            $claseEstado = 'secondary';
                            $textoEstado = $inscripcion->status;
                    }

                    // Construir nombre completo para el estudiante en la tabla
                    $nombreCompleto = $inscripcion->primer_nombre . ' ' .
                                    ($inscripcion->segundo_nombre ? ' ' . $inscripcion->segundo_nombre : '') . ' ' .
                                    $inscripcion->tercer_nombre . ' ' .
                                    ($inscripcion->primer_apellido ? ' ' . $inscripcion->primer_apellido : '') . ' ' .
                                    ($inscripcion->segundo_apellido ? ' ' . $inscripcion->segundo_apellido : '');

                    $numero_documento = $inscripcion->tipo_documento_id . '-' . $inscripcion->numero_documento;
                    $fechaInscripcion = \Carbon\Carbon::parse($inscripcion->fecha_inscripcion)->format('d/m/Y');

                    $html .= "
                    <tr>
                        <td>
                            <div class='ms-3'>
                                <h6 class='mb-0'>{$inscripcion->id}</h6>
                            </div>
                        </td>
                        <td>
                            <div class='d-flex align-items-center'>
                                <div class='ms-3'>
                                    <h6 class='mb-0'>" . e(trim($nombreCompleto)) . "</h6>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class='badge bg-primary'>" . e($numero_documento) . "</span>
                        </td>
                        <td>
                            {$fechaInscripcion}
                        </td>
                        <td>
                            <span class='badge bg-{$claseEstado}'>
                                {$textoEstado}
                            </span>
                        </td>
                        <td>
                            <div class='btn-group' role='group'>
                                <button type='button' class='btn btn-info btn-sm' onclick='verDetalle({$inscripcion->id})' title='Ver detalles'>
                                    <i class='bi bi-eye'></i>
                                </button>
                                <button type='button' class='btn btn-primary btn-sm' onclick='editarInscripcion({$inscripcion->id})' title='Editar inscripción'>
                                    <i class='bi bi-pencil'></i>
                                </button>
                                <button type='button' class='btn btn-danger btn-sm' onclick='confirmarEliminacion({$inscripcion->id})' title='Eliminar inscripción'>
                                    <i class='bi bi-trash'></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    ";
                }
            } else {
                $html = "
                <tr>
                    <td colspan='6' class='text-center py-4'>
                        <div class='text-muted'>
                            <i class='bi bi-search display-4 d-block mb-2'></i>
                            <h5>No se encontraron resultados</h5>
                            <p class='mb-0'>No hay inscripciones que coincidan con \"<strong>" . e($query) . "</strong>\"</p>
                        </div>
                    </td>
                </tr>
                ";
            }

            return response()->json(['html' => $html]);

        } catch (\Exception $e) {
            Log::error('Error en búsqueda de inscripciones ' . $e->getMessage());

            return response()->json([
                'html' => "
                <tr>
                    <td colspan='6' class='text-center text-danger py-4'>
                        <i class='bi bi-exclamation-triangle display-4 d-block mb-2'></i>
                        <h5>Error en la búsqueda</h5>
                        <p class='mb-0'>Por favor, intente nuevamente</p>
                    </td>
                </tr>
                "
            ]);
        }
    }
}

  /**
     * Actualizar la inscripción completa
     */
    public function actualizar(Request $request, $id)
    {
        Log::info('ID de inscripción: ' . $id);
        Log::info('Datos recibidos:', $request->all());

        try {
            // Validar datos del estudiante
            $datosEstudiante = $request->validate([
                'tipo_numero_documento_persona' => 'required',
                'numero_numero_documento_persona' => 'required',
                'fecha_nacimiento_personas' => 'required|date',
                'primer_nombre' => 'required|string|max:255',
                'segundo_nombre' => 'nullable|string|max:255',
                'tercer_nombre' => 'nullable|string|max:255',
                'primer_apellido' => 'required|string|max:255',
                'segundo_apellido' => 'nullable|string|max:255',
                'tipo_documento_id' => 'required|exists:tipo_documentos,id',
                'genero_id' => 'required|exists:generos,id',
                'localidad_id' => 'required|exists:localidades,id',
                'genero_id' => 'required',
                'lateralidad_estudiante' => 'required',
                'orden_nacimiento_estudiante' => 'required',
                'numero_zonificacion_plantel' => 'nullable|numeric',
                'institucion_id' => 'required|exists:instituciones,id',
                'expresion_literaria' => 'required|in:A,B,C',
                'ano_ergreso_estudiante' => 'required|date',
                'talla_estudiante' => 'required|numeric',
                'peso_estudiante' => 'required|numeric',
                'talla_camisa' => 'required|in:XS,S,M,L,XL',
                'talla_zapato' => 'required|integer|between:30,45',
                'talla_pantalon' => 'required|in:XS,S,M,L,XL',
                'direccion_persona' => 'required|string|max:500',
                'cual_pueblo_indigna' => 'nullable|string|max:255',
                'discapacidad_estudiante' => 'nullable|string|max:255',
            ]);

            // Validar datos del representante
            $datosRepresentante = $request->validate([
                'rep_tipo_numero_documento_persona' => 'required|in:V,E,J',
                'rep_numero_numero_documento_persona' => 'required|numeric|digits_between:1,8',
                'rep_genero_id' => 'required|exists:generos,id',
                'rep_primer_nombre' => 'required|string|max:255',
                'rep_segundo_nombre' => 'nullable|string|max:255',
                'rep_tercer_nombre' => 'nullable|string|max:255',
                'rep_primer_apellido' => 'required|string|max:255',
                'rep_segundo_apellido' => 'nullable|string|max:255',
                'rep_tipo_documento_id' => 'required|exists:tipo_documentos,id',
                'rep_genero_id' => 'required|exists:generos,id',
                'rep_localidad_id' => 'required|exists:localidades,id',
                'rep_fecha_nacimiento_personas' => 'required|date',
                'rep_lugar_nacimiento_persona' => 'required|string|max:30',
                'rep_prefijo_telefono_personas' => 'required|in:0412,0414,0416,0424,0426',
                'rep_telefono_personas' => 'required|numeric|digits_between:7,11',
                'rep_ocupacion_representante' => 'required|string|max:255',
                'rep_convivenciaestudiante_representante' => 'required|in:si,no',
            ]);

            // Validar datos de la inscripción
            $datosInscripcion = $request->validate([
                'fecha_inscripcion' => 'required|date',
                'ano_escolar_id' => 'required|exists:anio_escolars,id',
                'grado_academico' => 'required|integer|between:1,5',
                // 'seccion_academico' => 'required|in:A,B,C,D,E,F',
                'documentos' => 'required|array|min:1',
            'documentos.*' => 'string',
                'observaciones' => 'nullable|string|max:500',
                'status' => 'required|in:pendiente,completada,rechazada',
            ]);

            // Llamar al modelo para actualizar
            $resultado = NuevoIngreso::actualizarInscripcion(
                $id,
                $datosEstudiante,
                $datosRepresentante,
                $datosInscripcion
            );

            return response()->json([
                'success' => true,
                'message' => 'Inscripción actualizada correctamente.',
                'redirect' => route('modules.nuevo_ingreso.index')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación en actualización: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al actualizar inscripción: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la inscripción: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar inscripción
     */
    public function eliminar($id)
    {
        try {
            // Llamar al modelo para eliminar
            $resultado = NuevoIngreso::eliminarInscripcion($id);

            if ($resultado['success']) {
                return response()->json([
                    'success' => true,
                    'message' => $resultado['message']
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $resultado['message']
                ], 404);
            }

        } catch (\Exception $e) {
            Log::error('Error al eliminar inscripción: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la inscripción: ' . $e->getMessage()
            ], 500);
        }
    }

}

