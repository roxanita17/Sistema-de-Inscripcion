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
use Barryvdh\DomPDF\Facade\Pdf;


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
        'estado',
        'municipios',  // Relación en Representante (plural)
        'localidads',  // Relación en Representante (plural)
        'legal' => function($query) {
            $query->with(['banco', 'prefijo']);
        }
    ])->findOrFail($id);

    // Cargar estados con sus relaciones
    $estados = Estado::where('status', true)
        ->with(['municipio' => function($query) {
            $query->where('status', true)
                  ->with(['localidades' => function($q) {
                      $q->where('status', true);
                  }]);
        }])
        ->orderBy('nombre_estado', 'ASC')
        ->get();
        
    // Cargar municipios para el select
    $municipios = Municipio::where('status', true)
        ->orderBy('nombre_municipio', 'ASC')
        ->get();
        
    $bancos = Banco::where('status', true)
        ->orderBy('nombre_banco', 'ASC')
        ->get();
        
    $ocupaciones = Ocupacion::where('status', true)
        ->orderBy('nombre_ocupacion', 'ASC')
        ->get();
        
    $generos = Genero::where('status', true)
        ->orderBy('genero', 'ASC')
        ->get();
        
    $prefijos_telefono = PrefijoTelefono::where('status', true)
        ->orderBy('prefijo', 'ASC')
        ->get();
        
    $tipoDocumentos = TipoDocumento::where('status', true)
        ->orderBy('nombre', 'ASC')
        ->get();

    // localidades
    $parroquias_cargadas = Localidad::where('status', true)
        ->orderBy('nombre_localidad', 'ASC')
        ->get();

    return view("admin.representante.modales.editarModal", compact(
        'representante', 
        'estados', 
        'municipios',  // Asegúrate de incluir esta variable
        'bancos', 
        'ocupaciones', 
        'generos', 
        'prefijos_telefono', 
        'tipoDocumentos',
        'parroquias_cargadas'
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

    \Log::info('=== ACCEDIENDO A save() ===');
    \Log::info('Route name:', [$request->route()->getName()]);
    \Log::info('Route action:', [$request->route()->getActionName()]);
    \Log::info('Request path:', [$request->path()]);
    \Log::info('Request method:', [$request->method()]);
        // Determinar si es una actualización o creación
        $isUpdate = $request->has('id') || $request->has('representante_id');
        $id = $request->input('id', $request->input('representante_id'));
        
        Log::info('=== ' . ($isUpdate ? 'ACTUALIZANDO' : 'CREANDO') . ' REPRESENTANTE ===', [
            'request_data' => $request->all(),
            'method' => $request->method(),
            'wants_json' => $request->wantsJson(),
            'is_ajax' => $request->ajax(),
            'content_type' => $request->header('Content-Type'),
            'is_update' => $isUpdate,
            'id' => $id
        ]);

    // Verificar si es un progenitor que también es representante
    $tipoRepresentante = $request->input('tipo_representante');
    $esProgenitorRepresentante = ($tipoRepresentante === 'progenitor_representante');
        
    // Determinar si estamos usando datos de la madre o del padre
    $numero_documentoRepresentante = $request->input('numero_documento-representante');
    $numero_documentoMadre = $request->input('numero_documento');
    $numero_documentoPadre = $request->input('numero_documento-padre');
        
    $usandoDatosMadre = !empty($numero_documentoMadre) && $numero_documentoMadre === $numero_documentoRepresentante;
    $usandoDatosPadre = !empty($numero_documentoPadre) && $numero_documentoPadre === $numero_documentoRepresentante;
    $numero_documentoProgenitor = null;
    $tipoProgenitor = null;
        
    if ($usandoDatosMadre) {
        $numero_documentoProgenitor = $numero_documentoMadre;
        $tipoProgenitor = 'madre';
    } elseif ($usandoDatosPadre) {
        $numero_documentoProgenitor = $numero_documentoPadre;
        $tipoProgenitor = 'padre';
    }
        
    // Si es progenitor representante pero no se pudo determinar la cédula, intentar con la cédula del representante
    if ($esProgenitorRepresentante && !$numero_documentoProgenitor && $numero_documentoRepresentante) {
        // Verificar si la cédula del representante coincide con la madre o el padre
        if ($numero_documentoRepresentante === $numero_documentoMadre) {
            $numero_documentoProgenitor = $numero_documentoMadre;
            $tipoProgenitor = 'madre';
            $usandoDatosMadre = true;
        } elseif ($numero_documentoRepresentante === $numero_documentoPadre) {
            $numero_documentoProgenitor = $numero_documentoPadre;
            $tipoProgenitor = 'padre';
            $usandoDatosPadre = true;
        }
    }
        
    Log::info('Tipo de representante:', [
        'tipo_representante' => $tipoRepresentante,
        'esProgenitorRepresentante' => $esProgenitorRepresentante,
        'usandoDatosMadre' => $usandoDatosMadre,
        'usandoDatosPadre' => $usandoDatosPadre,
        'numero_documentoProgenitor' => $numero_documentoProgenitor,
        'tipoProgenitor' => $tipoProgenitor,
        'numero_documentoRepresentante' => $numero_documentoRepresentante,
        'numero_documentoMadre' => $numero_documentoMadre,
        'numero_documentoPadre' => $numero_documentoPadre
    ]);

    // =============================================================
    // MAPEO DE CAMPOS DESDE EL FORMULARIO BLADE AL CONTROLADOR
    // =============================================================
    // Estos nombres vienen del formulario de representante en la vista
    // admin/representante/formulario_representante.blade.php

    $request->merge([
        // Identificación persona/representante
        'numero_numero_documento_persona' => $request->input('numero_documento-representante'),
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

        'tipo_numero_documento_persona'   => $request->input('tipo-ci-representante'),

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
            'numero_numero_documento_persona' => 'required|string',
            'nombre_uno' => 'required|string|min:1',
            'apellido_uno' => 'required|string|min:1',
            'estado_id' => 'required|integer|min:1|exists:estados,id',
            'municipio_id' => 'required|integer|min:1|exists:municipios,id',
            // En este proyecto las parroquias se almacenan en la tabla "localidads"; permitir que sea opcional
            'parroquia_id' => 'nullable|integer|exists:localidads,id',
            // Campos obligatorios para Persona
            'sexo_representante' => 'required|exists:generos,id',
            'tipo_numero_documento_persona' => 'required|exists:tipo_documentos,id',
        ]);

        if ($validator->fails()) {
            Log::error('Errores de validación detallados', [
                'errors' => $validator->errors()->toArray(),
                'request_all' => $request->all(),
                'request_has' => [
                    'numero_numero_documento_persona' => $request->has('numero_numero_documento_persona') ? 'YES (' . $request->input('numero_numero_documento_persona') . ')' : 'NO',
                    'nombre_uno' => $request->has('nombre_uno') ? 'YES (' . $request->input('nombre_uno') . ')' : 'NO',
                    'apellido_uno' => $request->has('apellido_uno') ? 'YES (' . $request->input('apellido_uno') . ')' : 'NO',
                    'estado_id' => $request->has('estado_id') ? 'YES (' . $request->input('estado_id') . ')' : 'NO',
                    'municipio_id' => $request->has('municipio_id') ? 'YES (' . $request->input('municipio_id') . ')' : 'NO',
                    'parroquia_id' => $request->has('parroquia_id') ? 'YES (' . $request->input('parroquia_id') . ')' : 'NO',
                ],
                'validation_rules' => [
                    'numero_numero_documento_persona' => 'required|string|min:1',
                    'nombre_uno' => 'required|string|min:1',
                    'apellido_uno' => 'required|string|min:1',
                    'estado_id' => 'required|integer|min:1|exists:estados,id',
                    'municipio_id' => 'required|integer|min:1|exists:municipios,id',
                    'parroquia_id' => 'required|integer|min:1|exists:localidads,id',
                    'sexo_representante' => 'required|exists:generos,id',
                    'tipo_numero_documento_persona' => 'required|exists:tipo_documentos,id',
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
            'numero_numero_documento_persona' => 'required',
            'nombre_uno' => 'required',
            'apellido_uno' => 'required',
            'estado_id' => 'required|exists:estados,id',
            'municipio_id' => 'required|exists:municipios,id',
            // En este proyecto las parroquias se almacenan en la tabla "localidads"; permitir que sea opcional
            'parroquia_id' => 'nullable|exists:localidads,id',
            'sexo_representante' => 'required|exists:generos,id',
            'tipo_numero_documento_persona' => 'required|exists:tipo_documentos,id',
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
    $numero_documento = $request->input('numero_numero_documento_persona');
    $personaId = $request->id ?? $request->persona_id;

    // Buscar persona con la misma cédula, excluyendo la persona actual si estamos editando
    $query = Persona::where('numero_documento', $numero_documento);

    if ($personaId) {
        $query->where('id', '!=', $personaId);
    }

    $personaExistente = $query->first();

    // Solo validar cédula duplicada si NO es un caso de progenitor como representante
    if ($personaExistente && !$esProgenitorRepresentante) {
        Log::warning('Intento de registrar cédula duplicada', [
            'numero_documento' => $numero_documento,
            'persona_existente_id' => $personaExistente->id,
            'persona_actual_id' => $personaId,
            'esProgenitorRepresentante' => $esProgenitorRepresentante
        ]);

        if ($request->ajax()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => [
                    'numero_numero_documento_persona' => ['Esta cédula ya está registrada en el sistema']
                ]
            ], 422);
        } else {
            return redirect()->back()->withErrors(['numero_numero_documento_persona' => 'Esta cédula ya está registrada en el sistema'])->withInput();
        }
    }

    // Datos de persona
    // Adaptar los datos de Persona al esquema actual del modelo Persona
    $datosPersona = [
        "id" => $request->id ?? $request->persona_id,
        "primer_nombre" => $request->input('nombre_uno'),
        "segundo_nombre" => $request->input('nombre_dos'),
        "prefijo_id" => $request->input('prefijo-representante'), // Añadir prefijo_id
        "tercer_nombre" => $request->input('nombre_tres'),
        "primer_apellido" => $request->input('apellido_uno'),
        "segundo_apellido" => $request->input('apellido_dos'),
        "numero_documento" => $request->input('numero_numero_documento_persona'),
        "fecha_nacimiento" => $request->input('fecha_nacimiento_personas'),
        // Se asume que sexo_representante corresponde al id en la tabla generos
        "genero_id" => $request->input('sexo_representante'),
        // Localidad/parroquia seleccionada
        "localidad_id" => $request->input('parroquia_id'),
        // Teléfono completo
        "telefono" => $request->input('telefono_personas'),
        // Tipo de documento (foráneo a tipo_documentos)
        "tipo_documento_id" => $request->input('tipo_numero_documento_persona'),
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
        $representante = null;

        // CASO ESPECIAL: Progenitor como representante
        if ($esProgenitorRepresentante) {
            if (!$numero_documentoProgenitor) {
                $errorMsg = 'No se pudo determinar la cédula del progenitor. Asegúrese de que la cédula del representante coincida con la de la madre o el padre.';
                Log::error($errorMsg, [
                    'numero_documento_representante' => $numero_documentoRepresentante,
                    'numero_documento_madre' => $numero_documentoMadre,
                    'numero_documento_padre' => $numero_documentoPadre
                ]);
                throw new \Exception($errorMsg);
            }
            
            Log::info('Procesando progenitor como representante', [
                'numero_documento' => $numero_documentoProgenitor,
                'tipo_progenitor' => $tipoProgenitor
            ]);
            
            // 1. Verificar si los datos del formulario están completos
            $fechaNacimiento = $request->input('fecha-nacimiento-padre');
            $prefijoId = $request->input('prefijo-padre'); // Obtener el prefijo del padre
            
            $datosCompletos = !empty($datosPersona['primer_nombre']) && 
                             !empty($datosPersona['primer_apellido']) && 
                             !empty($fechaNacimiento);
            
            // Asegurarse de que los campos obligatorios estén en el formato correcto
            if ($fechaNacimiento) {
                $datosPersona['fecha_nacimiento'] = $fechaNacimiento;
            }
            
            // Incluir el prefijo_id en los datos de la persona
            if ($prefijoId) {
                $datosPersona['prefijo_id'] = $prefijoId;
            }
            
            if ($datosCompletos) {
                Log::info('Usando datos completos del formulario para el progenitor', [
                    'numero_documento' => $numero_documentoProgenitor,
                    'nombres' => $datosPersona['primer_nombre'] . ' ' . $datosPersona['primer_apellido']
                ]);
                
                // Crear o actualizar con los datos del formulario
                $persona = Persona::updateOrCreate(
                    ['numero_documento' => $numero_documentoProgenitor],
                    $datosPersona
                );
                $isUpdate = true;
            } else {
                // 2. Si los datos del formulario no están completos, buscar en la base de datos
                Log::info('Buscando datos del progenitor en la base de datos', [
                    'numero_documento' => $numero_documentoProgenitor
                ]);
                
                $persona = Persona::where('numero_documento', $numero_documentoProgenitor)->first();
                
                if ($persona) {
                    $isUpdate = true;
                    Log::info('Progenitor encontrado en la base de datos', [
                        'persona_id' => $persona->id,
                        'nombres' => $persona->nombre_uno . ' ' . $persona->apellido_uno
                    ]);
                    
                    // Actualizar solo los campos que no están vacíos en el formulario
                    $camposActualizables = [
                        'telefono_personas', 'correo_persona', 'direccion_habitacion',
                        'estado_id', 'municipio_id', 'parroquia_id'
                    ];
                    
                    foreach ($camposActualizables as $campo) {
                        if (!empty($datosPersona[$campo])) {
                            $persona->$campo = $datosPersona[$campo];
                        }
                    }
                    
                    $persona->save();
                } else {
                    // 3. Si no se encuentra en la base de datos, crear un nuevo registro con los datos disponibles
                    Log::info('Creando nuevo registro para el progenitor', [
                        'numero_documento' => $numero_documentoProgenitor,
                        'tipo_progenitor' => $tipoProgenitor
                    ]);
                    
                    // Asegurarse de que los campos requeridos tengan valores por defecto si están vacíos
                    $datosPersona = array_merge([
                        'numero_documento' => $numero_documentoProgenitor,
                        'status' => true,
                        'tipo_documento_id' => $datosPersona['tipo_documento_id'] ?? 1, // Valor por defecto para tipo de documento
                        'genero_id' => $datosPersona['genero_id'] ?? 1, // Valor por defecto para género
                        'localidad_id' => $datosPersona['localidad_id'] ?? 1, // Valor por defecto para localidad
                        'prefijo_id' => $datosPersona['prefijo_id'] ?? 1, // Valor por defecto para prefijo
                        'primer_nombre' => $datosPersona['primer_nombre'] ?? 'SIN NOMBRE',
                        'primer_apellido' => $datosPersona['primer_apellido'] ?? 'SIN APELLIDO',
                        'fecha_nacimiento' => $datosPersona['fecha_nacimiento'] ?? now()->format('Y-m-d')
                    ], $datosPersona);
                    
                    try {
                        $persona = Persona::create($datosPersona);
                        $isUpdate = false;
                        
                        Log::info('Nuevo registro creado para el progenitor', [
                            'persona_id' => $persona->id,
                            'numero_documento' => $persona->numero_documento,
                            'nombres' => $persona->primer_nombre . ' ' . $persona->primer_apellido
                        ]);
                    } catch (\Exception $e) {
                        $errorMsg = "Error al crear el registro del {$tipoProgenitor} con cédula {$numero_documentoProgenitor}: " . $e->getMessage();
                        Log::error($errorMsg, [
                            'exception' => $e,
                            'datos_persona' => $datosPersona
                        ]);
                        
                        return response()->json([
                            'success' => false,
                            'message' => $errorMsg
                        ], 500);
                    }
                }
            }
            
            // Buscar o crear el representante
            $representante = Representante::updateOrCreate(
                ['persona_id' => $persona->id],
                $datosRepresentante
            );
            
            Log::info('Datos del representante actualizados', [
                'persona_id' => $persona->id,
                'representante_id' => $representante->id,
                'tipo_progenitor' => $tipoProgenitor,
                'usando_datos_formulario' => $datosCompletos ? 'Sí' : 'No',
                'usando_datos_bd' => !$datosCompletos ? 'Sí' : 'No'
            ]);
        } 
        // VERIFICAR SI ES ACTUALIZACIÓN O CREACIÓN NORMAL
        elseif (!empty($datosPersona["id"])) {
            $persona = Persona::with(['representante', 'representante.legal'])->find($datosPersona["id"]);
            if($persona) {
                $isUpdate = true;
            }
        }

        if($isUpdate && !$esProgenitorRepresentante) {
            // === MODO ACTUALIZACIÓN NORMAL (no para progenitor como representante) ===
            Log::info('=== MODO ACTUALIZACIÓN NORMAL ===');
            
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
        } elseif ($esProgenitorRepresentante) {
            // Ya se manejó el caso de progenitor como representante, solo registrar
            Log::info('=== MODO PROGENITOR COMO REPRESENTANTE ===');
            Log::info('Datos del progenitor actualizados como representante', [
                'persona_id' => $persona->id,
                'representante_id' => $representante->id
            ]);

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

        $numero_documentoMadre = $request->input('numero_documento');
        if ($numero_documentoMadre) {
            Log::info('Procesando datos de la madre', ['numero_documento' => $numero_documentoMadre]);

            $personaMadre = Persona::firstOrNew(['numero_documento' => $numero_documentoMadre]);

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
            $personaMadre->prefijo_id       = $request->input('prefijo');
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

        $numero_documentoPadre = $request->input('numero_documento-padre');
        if ($numero_documentoPadre) {
            Log::info('Procesando datos del padre', ['numero_documento' => $numero_documentoPadre]);

            $personaPadre = Persona::firstOrNew(['numero_documento' => $numero_documentoPadre]);

            $personaPadre->primer_nombre    = $request->input('primer-nombre-padre');
            $personaPadre->segundo_nombre   = $request->input('segundo-nombre-padre');
            $personaPadre->primer_apellido  = $request->input('primer-apellido-padre');
            $personaPadre->segundo_apellido = $request->input('segundo-apellido-padre');
            $personaPadre->fecha_nacimiento = $request->input('fecha-nacimiento-padre');
            $personaPadre->genero_id        = $request->input('sexo-padre');
            $personaPadre->localidad_id     = $request->input('idparroquia-padre');
            $personaPadre->telefono         = $request->input('telefono-padre');
            $personaPadre->tipo_documento_id = $request->input('tipo-ci-padre');
            $personaPadre->prefijo_id       = $request->input('prefijo-padre');
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
    public function buscarPornumero_documento(Request $request): JsonResponse
    {
            // En el modelo Persona la cédula se almacena en numero_documento
        $numero_documento = $request->get('numero_documento');
        Log::info(" Buscando cédula: " . $numero_documento);
        
        if(!$numero_documento){
            return response()->json([
                'status' => 'error',
                'message' => 'Debe indicar la cédula',
            ], 422);
        }

        $persona = Persona::where('numero_documento', $numero_documento)->first();
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
                ->orWhere("numero_numero_documento_persona","like","%".$buscador."%")
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
     * Elimina (borrado suave) un representante y sus datos relacionados
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $id): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $representanteId = $id ?? $request->id ?? $request->input('id');
        Log::info('=== INICIANDO ELIMINACIÓN DE REPRESENTANTE ===', ['id' => $representanteId]);

        $representante = Representante::with(['persona', 'legal'])->find($representanteId);
        if (!$representante) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Representante no encontrado',
                ], 404);
            }

            return redirect()->route('representante.index')
                ->with('error', 'Representante no encontrado');
        }

        DB::beginTransaction();
        try {
            // Si tiene datos legales, eliminar primero (soft delete también)
            if ($representante->legal) {
                $representante->legal->delete();
            }

            // Eliminar (soft delete) el representante
            $representante->delete();
            
            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Representante eliminado exitosamente'
                ]);
            }

            return redirect()->route('representante.index')
                ->with('success', '¡El representante ha sido eliminado exitosamente!');
                
        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error('Error al eliminar representante: ' . $th->getMessage(), [
                'exception' => $th,
                'trace' => $th->getTraceAsString()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error al eliminar el representante: ' . $th->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Error al eliminar el representante: ' . $th->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDACIONES
    |--------------------------------------------------------------------------
    */

    /**
     * Verifica si una cédula ya existe en la base de datos
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verificarnumero_documento(Request $request): JsonResponse
    {
        $numero_documento = $request->input('numero_documento');
        $personaId = $request->input('persona_id'); // Para excluir la persona actual en edición

        if (!$numero_documento) {
            return response()->json([
                'status' => 'error',
                'message' => 'Debe proporcionar una cédula',
            ]);
        }

        // Buscar persona con la misma cédula, excluyendo la persona actual si estamos editando
        $query = Persona::where('numero_documento', $numero_documento);

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
    /*
    |--------------------------------------------------------------------------
    | REPORTES
    |--------------------------------------------------------------------------
    */

    public function reportePDF(Request $request)
    {
        $filtro = $request->all();
        $representantes = Representante::reportePDF($filtro);

        if($representantes->isEmpty()){
            return response()->json('No se encontraron representantes', 404);
        }


        $pdf = PDF::loadView('admin.representante.reportes.general_pdf', compact('representantes'));
        return $pdf->stream('representantes.pdf');
    }

}
