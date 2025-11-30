<?php

namespace App\Http\Controllers;
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
            // En este proyecto la parroquia se modela con Localidad (tabla localidads)
            'localidads'
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
            // Relación con localidad/parroquia en este proyecto
            'localidads'
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
        
        return view("admin.representante.formulario_representante", compact(
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

    // =============================================================
    // MAPEO DE CAMPOS DESDE EL FORMULARIO BLADE AL CONTROLADOR
    // =============================================================
    // Estos nombres vienen del formulario de representante en la vista
    // admin/representante/formulario_representante.blade.php

    $request->merge([
        // Identificación persona/representante
        'numero_cedula_persona' => $request->input('cedula-representante'),
        'nombre_uno'            => $request->input('primer-nombre-representante'),
        'nombre_dos'            => $request->input('segundo-nombre-representante'),
        'nombre_tres'           => $request->input('tercer-nombre-representante'),
        'apellido_uno'          => $request->input('primer-apellido-representante'),
        'apellido_dos'          => $request->input('segundo-apellido-representante'),

        // Fecha de nacimiento: tomar la del representante y, si está vacía, usar madre o padre
        'fecha_nacimiento_personas' => $request->input('fechaNacimiento-representante')
                                        ?: $request->input('fechaNacimiento')        // madre
                                        ?: $request->input('fechaNacimiento-padre'), // padre

        // Género del representante: tomar el del bloque de representante, y si viene vacío usar madre o padre
        'sexo_representante'    => $request->input('sexo-representante')
                                    ?: $request->input('sexo')           // madre
                                    ?: $request->input('genero-padre'),  // padre

        'tipo_cedula_persona'   => $request->input('tipo-ci-representante'),

        // Ubicación
        'estado_id'    => $request->input('idEstado-representante') ?: $request->input('idEstado-padre') ?: $request->input('idEstado'),
        'municipio_id' => $request->input('idMunicipio-representante') ?: $request->input('idMunicipio-padre') ?: $request->input('idMunicipio'),
        'parroquia_id' => $request->input('idparroquia-representante') ?: $request->input('idparroquia-padre') ?: $request->input('idparroquia'),

        // Teléfono (se almacena completo en Persona.telefono)
        'telefono_personas' => $request->input('telefono-representante'),

        // Ocupación y convivencia
        'ocupacion_representante'             => $request->input('ocupacion-representante'),
        'convivenciaestudiante_representante' => $request->input('convive-representante'),

        // Correo y organización (representante legal)
        'correo_representante'                    => $request->input('correo-representante'),
        'pertenece_a_organizacion_representante' => $request->input('pertenece-organizacion') === 'si' ? 1 : 0,
        'cual_organizacion_representante'        => $request->input('cual-organizacion'),

        // Mapeo de campos de carnet de la patria y banco desde el formulario
        'carnet_patria_afiliado'             => $request->input('carnet-patria'),
        'serial_carnet_patria_representante' => $request->input('serial'),
        'banco_id'                           => $request->input('banco-representante'),
        'direccion_representante'            => $request->input('direccion-habitacion'),

        // IDs para edición
        'persona_id'       => $request->input('persona-id-representante'),
        'representante_id' => $request->input('representante-id'),

        // En este formulario siempre tratamos al registro como representante legal
        'es_representate_legal' => true,
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
            'localidad_id' => $request->localidad_id,
            'localidad_existe' => \DB::table('localidads')->where('id', $request->localidad_id)->exists(),
        ]);

        // Validación completa con exists - usando los nombres que realmente envía el JS
        $validator = \Validator::make($request->all(), [
            'numero_cedula_persona' => 'required|string',
            'nombre_uno' => 'required|string|min:1',
            'apellido_uno' => 'required|string|min:1',
            'estado_id' => 'required|integer|min:1|exists:estados,id',
            'municipio_id' => 'required|integer|min:1|exists:municipios,id',
            // En este proyecto las parroquias se almacenan en la tabla "localidads"; permitir que sea opcional
            'parroquia_id' => 'nullable|integer|exists:localidads,id',
            // Campos obligatorios para Persona
            'sexo_representante' => 'required|exists:generos,id',
            'tipo_cedula_persona' => 'required|exists:tipo_documentos,id',
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
                    'parroquia_id' => 'required|integer|min:1|exists:localidads,id',
                    'sexo_representante' => 'required|exists:generos,id',
                    'tipo_cedula_persona' => 'required|exists:tipo_documentos,id',
                ]
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }
    } else {
        // Validación normal para peticiones no AJAX, pero con logging de errores
        $validator = \Validator::make($request->all(), [
            'numero_cedula_persona' => 'required',
            'nombre_uno' => 'required',
            'apellido_uno' => 'required',
            'estado_id' => 'required|exists:estados,id',
            'municipio_id' => 'required|exists:municipios,id',
            // En este proyecto las parroquias se almacenan en la tabla "localidads"; permitir que sea opcional
            'parroquia_id' => 'nullable|exists:localidads,id',
            'sexo_representante' => 'required|exists:generos,id',
            'tipo_cedula_persona' => 'required|exists:tipo_documentos,id',
        ]);

        if ($validator->fails()) {
            Log::error('Errores de validación (no AJAX)', [
                'errors' => $validator->errors()->toArray(),
                'request_all' => $request->all(),
            ]);

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    }

    Log::info('Campos geográficos recibidos:', [
        'estado_id' => $request->estado_id,
        'municipio_id' => $request->municipio_id,
        'parroquia_id' => $request->parroquia_id
    ]);

    // VALIDACIÓN DE CÉDULA DUPLICADA
    // En el modelo Persona la cédula se almacena en el campo numero_documento
    $cedula = $request->input('numero_cedula_persona');
    $personaId = $request->id ?? $request->persona_id;

    // Buscar persona con la misma cédula, excluyendo la persona actual si estamos editando
    $query = Persona::where('numero_documento', $cedula);

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
    // Adaptar los datos de Persona al esquema actual del modelo Persona
    $datosPersona = [
        "id" => $request->id ?? $request->persona_id,
        "primer_nombre" => $request->input('nombre_uno'),
        "segundo_nombre" => $request->input('nombre_dos'),
        "tercer_nombre" => $request->input('nombre_tres'),
        "primer_apellido" => $request->input('apellido_uno'),
        "segundo_apellido" => $request->input('apellido_dos'),
        "cedula" => $request->input('numero_cedula_persona'),
        "fecha_nacimiento" => $request->input('fecha_nacimiento_personas'),
        // Se asume que sexo_representante corresponde al id en la tabla generos
        "genero_id" => $request->input('sexo_representante'),
        // Localidad/parroquia seleccionada
        "localidad_id" => $request->input('parroquia_id'),
        // Teléfono completo
        "telefono" => $request->input('telefono_personas'),
        // Tipo de documento (foráneo a tipo_documentos)
        "tipo_documento_id" => $request->input('tipo_cedula_persona'),
        // Dirección de residencia (si se envía desde el formulario)
        "direccion" => $request->input('direccion_representante'),
        // Correo de contacto principal si viene en la petición
        "email" => $request->input('correo_representante'),
    ];

    // Campos adicionales del request que no existen en el modelo Persona se ignoran

    // Datos de representante
    $datosRepresentante = [
        "estado_id" => $request->estado_id ?: 1,
        "municipio_id" => $request->municipio_id,
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

            // 2. Actualizar o crear representante asociado a la persona
            $representante = Representante::where('persona_id', $persona->id)->first();

            if($representante) {
                $representante->update($datosRepresentante);
                Log::info('Representante actualizado: ID ' . $representante->id);
            } else {
                $datosRepresentante["persona_id"] = $persona->id;
                $representante = Representante::create($datosRepresentante);
                Log::info('Representante creado: ID ' . $representante->id);
            }

            // 3. Manejar representante legal
            if($request->es_representate_legal == true) {
                $representanteLegal = RepresentanteLegal::where('representante_id', $representante->id)->first();

                if($representanteLegal) {
                    $representanteLegal->update($datosRepresentanteLegal);
                    Log::info('Representante legal actualizado: ID ' . $representanteLegal->id);
                } else {
                    $datosRepresentanteLegal["representante_id"] = $representante->id;
                    RepresentanteLegal::create($datosRepresentanteLegal);
                    Log::info('Representante legal creado para representante ID: ' . $representante->id);
                }
            } else {
                // Si no es representante legal pero existe, eliminarlo
                RepresentanteLegal::where('representante_id', $representante->id)->delete();
                Log::info('Representante legal eliminado');
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
            $representante = Representante::create($datosRepresentante);
            Log::info('Representante creado: ID ' . $representante->id);

            // 3. Crear representante legal si es necesario
            if($request->es_representate_legal == true) {
                $datosRepresentanteLegal["representante_id"] = $representante->id;
                $representante->legal()->create($datosRepresentanteLegal);
                Log::info('Representante legal creado');
            }

            $mensaje = "Representante registrado exitosamente";
        }

        // =============================================================
        // CREACIÓN / ACTUALIZACIÓN DE MADRE COMO PERSONA + REPRESENTANTE
        // =============================================================

        $cedulaMadre = $request->input('cedula');
        if ($cedulaMadre) {
            Log::info('Procesando datos de la madre', ['cedula' => $cedulaMadre]);

            $personaMadre = Persona::firstOrNew(['numero_documento' => $cedulaMadre]);

            $personaMadre->primer_nombre    = $request->input('primer-nombre');
            $personaMadre->segundo_nombre   = $request->input('segundo-nombre');
            $personaMadre->tercer_nombre    = $request->input('tercer-nombre');
            $personaMadre->primer_apellido  = $request->input('primer-apellido');
            $personaMadre->segundo_apellido = $request->input('segundo-apellido');
            $personaMadre->fecha_nacimiento = $request->input('fechaNacimiento');
            $personaMadre->genero_id        = $request->input('sexo');
            $personaMadre->localidad_id     = $request->input('idparroquia');
            $personaMadre->telefono         = $request->input('telefono');
            $personaMadre->tipo_documento_id = $request->input('tipo-ci');
            $personaMadre->direccion        = $request->input('lugar-nacimiento');
            $personaMadre->status           = $personaMadre->status ?? true;

            $personaMadre->save();

            $representanteMadre = Representante::firstOrNew([
                'persona_id' => $personaMadre->id,
            ]);

            $representanteMadre->estado_id   = $request->input('idEstado');
            $representanteMadre->municipio_id = $request->input('idMunicipio');
            $representanteMadre->parroquia_id = $request->input('idparroquia');
            $representanteMadre->ocupacion_representante = $request->input('ocupacion-madre');
            $representanteMadre->convivenciaestudiante_representante = $request->input('convive') ?: 'no';

            $representanteMadre->save();

            Log::info('Madre guardada/actualizada como representante', [
                'persona_id' => $personaMadre->id,
                'representante_id' => $representanteMadre->id,
            ]);
        }

        // =============================================================
        // CREACIÓN / ACTUALIZACIÓN DE PADRE COMO PERSONA + REPRESENTANTE
        // =============================================================

        $cedulaPadre = $request->input('cedula-padre');
        if ($cedulaPadre) {
            Log::info('Procesando datos del padre', ['cedula' => $cedulaPadre]);

            $personaPadre = Persona::firstOrNew(['numero_documento' => $cedulaPadre]);

            $personaPadre->primer_nombre    = $request->input('primer-nombre-padre');
            $personaPadre->segundo_nombre   = $request->input('segundo-nombre-padre');
            $personaPadre->primer_apellido  = $request->input('primer-apellido-padre');
            $personaPadre->segundo_apellido = $request->input('segundo-apellido-padre');
            $personaPadre->fecha_nacimiento = $request->input('fechaNacimiento-padre');
            $personaPadre->genero_id        = $request->input('genero-padre');
            $personaPadre->localidad_id     = $request->input('idparroquia-padre');
            $personaPadre->telefono         = $request->input('telefono-padre');
            $personaPadre->tipo_documento_id = $request->input('tipo-ci-padre');
            $personaPadre->direccion        = $request->input('direccion-padre');
            $personaPadre->status           = $personaPadre->status ?? true;

            $personaPadre->save();

            $representantePadre = Representante::firstOrNew([
                'persona_id' => $personaPadre->id,
            ]);

            $representantePadre->estado_id    = $request->input('idEstado-padre');
            $representantePadre->municipio_id = $request->input('idMunicipio-padre');
            $representantePadre->parroquia_id = $request->input('idparroquia-padre');
            $representantePadre->ocupacion_representante = $request->input('ocupacion-padre');
            $representantePadre->convivenciaestudiante_representante = $request->input('convive-padre') ?: 'no';

            $representantePadre->save();

            Log::info('Padre guardado/actualizado como representante', [
                'persona_id' => $personaPadre->id,
                'representante_id' => $representantePadre->id,
            ]);
        }

        DB::commit();

        // Respuesta según tipo de petición
        if ($request->ajax() || $request->wantsJson()) {
            // Cargar representante asociado con sus relaciones para la respuesta
            $representanteResponse = Representante::with(['persona', 'legal', 'legal.banco'])
                ->where('persona_id', $persona->id)
                ->first();

            return response()->json([
                'status' => 'success',
                'message' => $mensaje,
                'data' => $representanteResponse,
            ], 200);
        }

        // Petición normal desde formulario HTML
        return redirect()->route('representante.index')->with('success', $mensaje);

    } catch (\Throwable $th) {
        Log::error('Error en save representante: ' . $th->getMessage());
        Log::error('Stack trace: ' . $th->getTraceAsString());
        DB::rollBack();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error en el servidor al guardar el representante: ' . $th->getMessage(),
            ], 500);
        }

        return redirect()
            ->back()
            ->withErrors(['general' => 'Error en el servidor al guardar el representante: ' . $th->getMessage()])
            ->withInput();
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
            // En el modelo Persona la cédula se almacena en numero_documento
        $cedula = $request->get('cedula');
        Log::info(" Buscando cédula: " . $cedula);
        
        if(!$cedula){
            return response()->json([
                'status' => 'error',
                'message' => 'Debe indicar la cédula',
            ], 422);
        }

        $persona = Persona::where('numero_documento', $cedula)->first();
        Log::info("Persona encontrada: " . ($persona ? 'SÍ (ID: ' . $persona->id . ')' : 'NO'));
        
        if(!$persona){
            return response()->json([
                'status' => 'error',
                'message' => 'No se encontró la cédula indicada',
            ], 404);
        }

        $representante = Representante::where('persona_id', $persona->id)->first();
        Log::info("Representante encontrado: " . ($representante ? 'SÍ (ID: ' . $representante->id . ')' : 'NO'));

        if(!$representante){
            // Si no tiene registro de representante, crear uno básico para poder usarlo como progenitor
            Log::info("Creando registro de representante para progenitor");
            $representante = Representante::create([
                'persona_id' => $persona->id,
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

        return response()->json([
            'status' => 'success',
            'message' => 'Progenitor encontrado y habilitado como representante',
            'data' => $representante,
        ], 200);
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
            return response()->json([
                'status' => 'error',
                'message' => 'Error al consultar el representante: no ha sido encontrado',
            ], 404);
        }

        $representante->load(['persona', 'legal']);

        return response()->json([
            'status' => 'success',
            'message' => 'Representante consultado',
            'data' => $representante,
        ], 200);
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
        return response()->json([
            'status' => 'success',
            'message' => 'Estudiante consultado',
            'data' => $respuesta,
        ], 200);
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
            return response()->json([
                'status' => 'error',
                'message' => 'Representante no encontrado',
            ], 404);
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
            return response()->json([
                'status' => 'success',
                'message' => 'Representante eliminado exitosamente',
            ], 200);
        } catch (\Throwable $th) {
            Log::error('Error al eliminar representante: ' . $th->getMessage());
            Log::error('Stack trace: ' . $th->getTraceAsString());
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Error al eliminar el representante: ' . $th->getMessage(),
            ], 500);
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
            return response()->json([
                'status' => 'error',
                'message' => 'Debe proporcionar una cédula',
            ], 422);
        }

        // Buscar persona con la misma cédula, excluyendo la persona actual si estamos editando
        $query = Persona::where('numero_documento', $cedula);

        if ($personaId) {
            $query->where('id', '!=', $personaId);
        }

        $personaExistente = $query->first();

        if ($personaExistente) {
            return response()->json([
                'status' => 'error',
                'message' => 'Esta cédula ya está registrada en el sistema',
            ], 409);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cédula disponible',
        ], 200);
    }
}
