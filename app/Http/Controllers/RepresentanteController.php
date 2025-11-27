<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Persona;
use App\Models\Representante;
use App\Models\RepresentanteLegal;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Localidad;
use App\Models\Banco;
use App\Models\PrefijoTelefono;
use App\Models\Ocupacion;
use App\Models\TipoCuenta;
use App\Models\TipoDocumento;
use App\Models\AnoEscolar;
use App\Models\Genero;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RepresentanteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HELPER METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Verifica si existe un año escolar activo o extendido
     * 
     * @return bool
     */

    private function verificarAnioEscolar()
    {
        return \App\Models\AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();
    }

    /**
     * Obtiene el tipo de cuenta basado en la selección
     * 
     * @param string $tipo
     * @return string
     */
    private function obtenerTipoCuenta($tipo)
    {
        return $tipo === 'ahorro' ? 'Ahorro' : 'Corriente';
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Muestra la vista principal de representantes
     * 
     * @return \Illuminate\View\View
     */

    public function index()
    {
        $anioEscolarActivo = $this->verificarAnioEscolar();
        
        $representantes = \App\Models\Representante::with([
            'persona', 
            'legal' => function($query) {
                $query->with(['banco' => function($q) {
                    $q->select('id', 'nombre_banco');
                }]);
            },
            'estado',
            'municipios',
            'parroquia'
        ])->paginate(10);
        
        return view("admin.representante.representante", compact('representantes', 'anioEscolarActivo'));
    }

    /**
     * Muestra el formulario para crear un nuevo representante
     * 
     * @return \Illuminate\View\View
     */

    public function mostrarFormulario(){
        // Cargar estados con sus municipios y localidades anidadas
        $estados = Estado::with(['municipio' => function($query) {
            $query->with(['localidades'])->orderBy('nombre_municipio', 'ASC');
        }])->orderBy('nombre_estado', 'ASC')->get();
        
        $bancos = Banco::WHERE('status', true)->orderBy("nombre_banco","ASC")->get();
        $prefijos_telefono = PrefijoTelefono::WHERE('status', true)->orderBy("prefijo", "ASC")->get();
        $ocupaciones = Ocupacion::WHERE('status', true)->orderBy('nombre_ocupacion', 'ASC')->get();
        $tipoDocumentos = TipoDocumento::WHERE('status', true)->get();
        $generos = Genero::WHERE('status', true)->get();
        
        return view("admin.representante.formulario_representante", 
            compact('estados', 'bancos', 'prefijos_telefono', 'ocupaciones', 'tipoDocumentos', 'generos'));
    }


    /**
     * Muestra el formulario para editar un representante existente
     * 
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */

    public function mostrarFormularioEditar($id)
    {
        $representante = Representante::with([
            'persona', 
            'legal', 
            'legal.banco',
            'municipios',
            'parroquia'
        ])->find($id);
        
        if (!$representante) {
            return redirect()->route('vista.representante')->with('error', 'Representante no encontrado');
        }

        // Asegurar que la ocupación esté disponible en el objeto representante
        if ($representante->ocupacion_representante) {
            $representante->ocupacion_representante = $representante->ocupacion_representante;
        } elseif ($representante->persona && $representante->persona->ocupacion_representante) {
            $representante->ocupacion_representante = $representante->persona->ocupacion_representante;
        }

        // Logs para depuración
        Log::info('Datos del representante para edición:', [
            'id' => $representante->id,
            'ocupacion_representante' => $representante->ocupacion_representante,
            'persona' => $representante->persona ? [
                'id' => $representante->persona->id,
                'ocupacion_representante' => $representante->persona->ocupacion_representante ?? 'No definida'
            ] : 'Sin datos de persona'
        ]);

        $estados = Estado::query()->with("municipio")->orderBy("nombre_estado", "ASC")->get();
        $municipios = Municipio::with('localidades')->orderBy('nombre_municipio', 'ASC')->get();
        $parroquias_cargadas = Localidad::with('municipio.estado')->orderBy('nombre_localidad', 'ASC')->get();
        $bancos = Banco::where('status', true)->orderBy('nombre_banco', 'ASC')->get();
        $ocupaciones = Ocupacion::where('status', true)->orderBy('nombre_ocupacion', 'ASC')->get();
        $generos = Genero::where('status', true)->orderBy('genero', 'ASC')->get();
        $prefijos_telefono= PrefijoTelefono::where('status', true)->orderBy('prefijo', 'ASC')->get();
        
        return view("modules.representante.formulario_representante", compact(
            'representante', 'estados', 'municipios', 'parroquias_cargadas', 'bancos', 'generos', 'prefijos_telefono', 'ocupaciones'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | CRUD OPERATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Guarda o actualiza un representante
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    
    public function save(Request $request)
    {
    Log::info('=== INICIANDO GUARDADO DE REPRESENTANTE ===', [
        'request_data' => $request->all(),
        'method' => $request->method(),
        'wants_json' => $request->wantsJson(),
        'is_ajax' => $request->ajax(),
        'content_type' => $request->header('Content-Type')
    ]);

    // Verificar si es petición AJAX
    if ($request->ajax() || $request->wantsJson()) {
        Log::info('Es petición AJAX/JSON');

        // Convertir campos de ubicación a enteros para evitar problemas de validación
        $request->merge([
            'estado_id' => (int) $request->input('estado_id'),
            'municipio_id' => (int) $request->input('municipio_id'),
            'parroquia_id' => (int) $request->input('parroquia_id'),
        ]);

        // Debug: verificar si los IDs existen
        Log::info('Verificando existencia de IDs:', [
            'estado_id' => $request->estado_id,
            'estado_existe' => \DB::table('estados')->where('id', $request->estado_id)->exists(),
            'municipio_id' => $request->municipio_id,
            'municipio_existe' => \DB::table('municipios')->where('id', $request->municipio_id)->exists(),
            'parroquia_id' => $request->parroquia_id,
            'parroquia_existe' => \DB::table('parroquias')->where('id', $request->parroquia_id)->exists(),
        ]);

        // Validación completa con exists - usando los nombres que realmente envía el JS
        $validator = \Validator::make($request->all(), [
            'numero_cedula_persona' => 'required|string|min:1',
            'nombre_uno' => 'required|string|min:1',
            'apellido_uno' => 'required|string|min:1',
            'estado_id' => 'required|integer|min:1|exists:estados,id',
            'municipio_id' => 'required|integer|min:1|exists:municipios,id',
            'parroquia_id' => 'required|integer|min:1|exists:parroquias,id',
        ]);

        if ($validator->fails()) {
            Log::error('Errores de validación detallados', [
                'errors' => $validator->errors()->toArray(),
                'request_all' => $request->all(),
                'request_has' => [
                    'numero_cedula_persona' => $request->has('numero_cedula_persona') ? 'YES (' . $request->input('numero_cedula_persona') . ')' : 'NO',
                    'nombre_uno' => $request->has('nombre_uno') ? 'YES (' . $request->input('nombre_uno') . ')' : 'NO',
                    'apellido_uno' => $request->has('apellido_uno') ? 'YES (' . $request->input('apellido_uno') . ')' : 'NO',
                    'estado_id' => $request->has('estado_id') ? 'YES (' . $request->input('estado_id') . ')' : 'NO',
                    'municipio_id' => $request->has('municipio_id') ? 'YES (' . $request->input('municipio_id') . ')' : 'NO',
                    'parroquia_id' => $request->has('parroquia_id') ? 'YES (' . $request->input('parroquia_id') . ')' : 'NO',
                ],
                'validation_rules' => [
                    'numero_cedula_persona' => 'required|string|min:1',
                    'nombre_uno' => 'required|string|min:1',
                    'apellido_uno' => 'required|string|min:1',
                    'estado_id' => 'required|integer|min:1|exists:estados,id',
                    'municipio_id' => 'required|integer|min:1|exists:municipios,id',
                    'parroquia_id' => 'required|integer|min:1|exists:parroquias,id',
                ]
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }
    } else {
        // Validación normal para peticiones no AJAX
        $request->validate([
            'numero_cedula_persona' => 'required',
            'nombre_uno' => 'required',
            'apellido_uno' => 'required',
            'estado_id' => 'required|exists:estados,id',
            'municipio_id' => 'required|exists:municipios,id',
            'parroquia_id' => 'required|exists:parroquias,id',
        ]);
    }

    Log::info('Campos geográficos recibidos:', [
        'estado_id' => $request->estado_id,
        'municipio_id' => $request->municipio_id,
        'parroquia_id' => $request->parroquia_id
    ]);

    // VALIDACIÓN DE CÉDULA DUPLICADA
    $cedula = $request->input('numero_cedula_persona');
    $personaId = $request->id ?? $request->persona_id;

    // Buscar persona con la misma cédula, excluyendo la persona actual si estamos editando
    $query = Persona::where('numero_cedula_persona', $cedula);

    if ($personaId) {
        $query->where('id', '!=', $personaId);
    }

    $personaExistente = $query->first();

    if ($personaExistente) {
        Log::warning('Intento de registrar cédula duplicada', [
            'cedula' => $cedula,
            'persona_existente_id' => $personaExistente->id,
            'persona_actual_id' => $personaId
        ]);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => [
                    'numero_cedula_persona' => ['Esta cédula ya está registrada en el sistema']
                ]
            ], 422);
        } else {
            return redirect()->back()->withErrors(['numero_cedula_persona' => 'Esta cédula ya está registrada en el sistema'])->withInput();
        }
    }

    // Datos de persona
    $datosPersona = [
        "id" => $request->id ?? $request->persona_id,
        "nombre_uno" => $request->input('nombre_uno'),
        "nombre_dos" => $request->input('nombre_dos'),
        "nombre_tres" => $request->input('nombre_tres'),
        "apellido_uno" => $request->input('apellido_uno'),
        "apellido_dos" => $request->input('apellido_dos'),
        "sexo" => $request->input('sexo_representante'),
        "tipo_cedula_persona" => $request->input('tipo_cedula_persona'),
        "numero_cedula_persona" => $request->input('numero_cedula_persona'),
        "fecha_nacimiento_personas" => $request->input('fecha_nacimiento_personas'),
        "prefijo_telefono_personas" => $request->input('prefijo_telefono_personas'),
        "telefono_personas" => $request->input('telefono_personas'),
        "lugar_nacimiento_persona" => $request->input('lugar_nacimiento_persona'),
    ];

    if($request->has('codigo_telefono_persona')) {
        $datosPersona["codigo_telefono_persona"] = $request->codigo_telefono_persona;
    }

    // Datos de representante
    $datosRepresentante = [
        "estado_id" => $request->estado_id ?: 1,
        "municipio_id" => $request->municipio_id, // o un valor por defecto si es necesario
        "parroquia_id" => $request->parroquia_id,
        "ocupacion_representante" => $request->ocupacion_representante ?: 'No especificado',
        "convivenciaestudiante_representante" => $request->convivenciaestudiante_representante ?: 'no',
    ];

    if($request->representante_id){
        $datosRepresentante["id"] = $request->representante_id;
    }

    Log::info('Datos procesados:', [
        'datosPersona' => $datosPersona,
        'datosRepresentante' => $datosRepresentante,
        'es_representate_legal' => $request->es_representate_legal
    ]);

    // Datos de representante legal
    $perteneceOrganizacion = $request->pertenece_a_organizacion_representante ?: 0;
    $cualOrganizacion = '';
    if ($perteneceOrganizacion == 1) {
        $cualOrganizacion = $request->cual_organizacion_representante ?: '';
    }

    $datosRepresentanteLegal = [
        "banco_id" => $request->banco_id && $request->banco_id != '' ? $request->banco_id : null,
        "parentesco" => $request->parentesco ?: 'No especificado',
        "correo_representante" => $request->correo_representante ?: '',
        "pertenece_a_organizacion_representante" => $perteneceOrganizacion,
        "cual_organizacion_representante" => $cualOrganizacion,
        "carnet_patria_afiliado" => $request->carnet_patria_afiliado ?: 0,
        "serial_carnet_patria_representante" => $request->serial_carnet_patria_representante ?: '',
        "codigo_carnet_patria_representante" => !empty($request->codigo) ? (int)$request->codigo : null,
        "direccion_representante" => $request->direccion_representante ?: '',
        "estados_representante" => $request->estados_representante ?: '',
        "tipo_cuenta" => $this->obtenerTipoCuenta($request->input('tipo-cuenta', '')),
    ];

    if($request->representante_legal_id){
        $datosRepresentanteLegal["id"] = $request->representante_legal_id;
    }

    DB::beginTransaction();
    try {
        $persona = null;
        $isUpdate = false;

        // VERIFICAR SI ES ACTUALIZACIÓN O CREACIÓN
        if(!empty($datosPersona["id"])) {
            $persona = Persona::with(['representante', 'representante.legal'])->find($datosPersona["id"]);
            if($persona) {
                $isUpdate = true;
            }
        }

        if($isUpdate) {
            // === MODO ACTUALIZACIÓN ===
            Log::info('=== MODO ACTUALIZACIÓN ===');
            
            // 1. Actualizar persona
            $persona->update($datosPersona);
            Log::info('Persona actualizada: ID ' . $persona->id);

            // 2. Actualizar o crear representante
            if($persona->representante) {
                $persona->representante->update($datosRepresentante);
                Log::info('Representante actualizado: ID ' . $persona->representante->id);
            } else {
                $datosRepresentante["persona_id"] = $persona->id;
                $persona->representante()->create($datosRepresentante);
                $persona->load('representante'); // Recargar la relación
                Log::info('Representante creado: ID ' . $persona->representante->id);
            }

            // 3. Manejar representante legal
            if($request->es_representate_legal == true) {
                if($persona->representante->legal) {
                    $persona->representante->legal->update($datosRepresentanteLegal);
                    Log::info('Representante legal actualizado: ID ' . $persona->representante->legal->id);
                } else {
                    $datosRepresentanteLegal["representante_id"] = $persona->representante->id;
                    $persona->representante->legal()->create($datosRepresentanteLegal);
                    Log::info('Representante legal creado para representante ID: ' . $persona->representante->id);
                }
            } else {
                // Si no es representante legal pero existe, eliminarlo
                if($persona->representante->legal) {
                    $persona->representante->legal->delete();
                    Log::info('Representante legal eliminado');
                }
            }

            $mensaje = "Los datos del representante han sido actualizados exitosamente";

        } else {
            // === MODO CREACIÓN ===
            Log::info('=== MODO CREACIÓN ===');
            
            // 1. Crear persona
            $persona = Persona::create($datosPersona);
            Log::info('Persona creada: ID ' . $persona->id);

            // 2. Crear representante
            $datosRepresentante["persona_id"] = $persona->id;
            $representante = $persona->representante()->create($datosRepresentante);
            Log::info('Representante creado: ID ' . $representante->id);

            // 3. Crear representante legal si es necesario
            if($request->es_representate_legal == true) {
                $datosRepresentanteLegal["representante_id"] = $representante->id;
                $representante->legal()->create($datosRepresentanteLegal);
                Log::info('Representante legal creado');
            }

            $mensaje = "Representante registrado exitosamente";
        }

        // CARGAR RELACIONES PARA LA RESPUESTA
        $persona->load([
            'representante',
            'representante.legal',
            'representante.legal.banco'
        ]);

        DB::commit();
        
        return ApiResponse::success($persona, $mensaje, 200);

    } catch (\Throwable $th) {
        Log::error('Error en save representante: ' . $th->getMessage());
        Log::error('Stack trace: ' . $th->getTraceAsString());
        DB::rollBack();
        return ApiResponse::error("Error en el servidor al guardar el representante: " . $th->getMessage(), 500);
    }
}


    /**
     * Busca un representante por su número de cédula
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function buscarPorCedula(Request $request): JsonResponse
    {
        $cedula = $request->get('cedula');
        Log::info(" Buscando cédula: " . $cedula);
        
        if(!$cedula){
            return ApiResponse::error('Debe indicar la cédula', 422);
        }

        $persona = Persona::where('numero_cedula_persona', $cedula)->first();
        Log::info("Persona encontrada: " . ($persona ? 'SÍ (ID: ' . $persona->id . ')' : 'NO'));
        
        if(!$persona){
            return ApiResponse::error('No se encontró la cédula indicada', 404);
        }

        $representante = $persona->representante;
        Log::info("Representante encontrado: " . ($representante ? 'SÍ (ID: ' . $representante->id . ')' : 'NO'));

        if(!$representante){
            // Si no tiene registro de representante, crear uno básico para poder usarlo como progenitor
            Log::info("Creando registro de representante para progenitor");
            $representante = $persona->representante()->create([
                'estado_id' => 1, // Valor por defecto
                'municipio_id' => 1, // Valor por defecto
                'parroquia_id' => 1, // Valor por defecto
                'ocupacion_representante' => 'No especificado',
                'convivenciaestudiante_representante' => 'si', // Asumir que convive por ser progenitor
            ]);
            Log::info("Representante creado: ID " . $representante->id);
        } else {
            Log::info("DEBUG: Representante existente encontrado", [
                'representante_id' => $representante->id,
                'estado_id' => $representante->estado_id,
                'municipio_id' => $representante->municipio_id,
                'parroquia_id' => $representante->parroquia_id,
                'ocupacion_representante' => $representante->ocupacion_representante,
            ]);

            // Si el representante existe pero le faltan campos de ubicación, actualizarlos
            if (!$representante->municipio_id || !$representante->parroquia_id) {
                Log::info("DEBUG: Actualizando campos de ubicación faltantes");
                $representante->update([
                    'municipio_id' => $representante->municipio_id ?: 1,
                    'parroquia_id' => $representante->parroquia_id ?: 1,
                ]);
                Log::info("DEBUG: Campos actualizados", [
                    'nuevo_municipio_id' => $representante->municipio_id,
                    'nuevo_parroquia_id' => $representante->parroquia_id,
                ]);
            }
        }

        $representante->load('legal', 'persona', 'legal.banco');
        Log::info("Representante cargado con relaciones para envío");

        return ApiResponse::success($representante, 'Progenitor encontrado y habilitado como representante', 200);
    }

    /**
     * Consulta los datos de un representante específico
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function consultar(Request $request): JsonResponse
    {
        $representante = Representante::find($request->id);
        if (!$representante) {
            return ApiResponse::error("Error al consultar el representante: no ha sido encontrado", 404);
        }

        $representante->load(['persona', 'legal']);

        return ApiResponse::success($representante, "Representante consultado", 200);
    }

    /**
     * Filtra los representantes según los criterios de búsqueda
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filtar(Request $request)
    {
        $buscador=$request->buscador;
        // $parroquia_id=$request->parroquia_id;
        $consulta=Representante::query()->with(["persona","legal"]);

        if($buscador!=""){
            $consulta=$consulta->whereHas("persona",function($query) use ($buscador){
                $query->whereRaw("CONCAT(nombre_uno,' ',nombre_dos,' ',apellido_uno,' ',apellido_dos) LIKE ?", ["%{$buscador}%"])
                ->orWhere("numero_cedula_persona","like","%".$buscador."%")
                ->orWhere("nombre_uno","like","%".$buscador."%")
                ->orWhere("nombre_dos","like","%".$buscador."%")
                ->orWhere("apellido_uno","like","%".$buscador."%")
                ->orWhere("apellido_dos","like","%".$buscador."%");
            });
        }

        // if($parroquia_id!="null"){
        //     $consulta=$consulta->where("parroquia_id","=",$parroquia_id);
        // }

        $respuesta=$consulta->paginate(10);
        return ApiResponse::success($respuesta,"Estudiante consultado",200);
    }

    /**
     * Elimina un representante y sus datos relacionados
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        Log::info('=== INICIANDO ELIMINACIÓN DE REPRESENTANTE ===', ['id' => $request->id]);

        $representante = Representante::with(['persona', 'legal'])->find($request->id);
        if (!$representante) {
            return ApiResponse::error("Representante no encontrado", 404);
        }

        DB::beginTransaction();
        try {
            // Si tiene datos legales, eliminar primero
            if ($representante->legal) {
                $representante->legal->delete();
            }

            // Eliminar el representante
            $representante->delete();

            DB::commit();
            return ApiResponse::success(null, "Representante eliminado exitosamente", 200);
        } catch (\Throwable $th) {
            Log::error('Error al eliminar representante: ' . $th->getMessage());
            Log::error('Stack trace: ' . $th->getTraceAsString());
            DB::rollBack();
            return ApiResponse::error("Error al eliminar el representante: " . $th->getMessage(), 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Verifica si una cédula ya existe en la base de datos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verificarCedula(Request $request): JsonResponse
    {
        $cedula = $request->input('cedula');
        $personaId = $request->input('persona_id'); // Para excluir la persona actual en edición

        if (!$cedula) {
            return ApiResponse::error('Debe proporcionar una cédula', 422);
        }

        // Buscar persona con la misma cédula, excluyendo la persona actual si estamos editando
        $query = Persona::where('numero_cedula_persona', $cedula);

        if ($personaId) {
            $query->where('id', '!=', $personaId);
        }

        $personaExistente = $query->first();

        if ($personaExistente) {
            return ApiResponse::error('Esta cédula ya está registrada en el sistema', 409);
        }

        return ApiResponse::success(null, 'Cédula disponible', 200);
    }
}
