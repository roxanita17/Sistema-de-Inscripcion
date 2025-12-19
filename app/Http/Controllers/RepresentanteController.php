<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
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
        
        // Construir la consulta
        $query = \App\Models\Representante::with([
            'persona', 
            'legal' => function($query) {
                $query->with(['banco' => function($q) {
                    $q->select('id', 'nombre_banco');
                }]);
            },
            'estado',
            'municipios',
            'localidads'
        ]);
        
        // Solo mostrar representantes activos (status != 0) y no eliminados con soft delete
        $query->where('status', '!=', 0)
              ->whereNull('deleted_at');
        
        // Ejecutar la consulta con paginación
        $representantes = $query->paginate(10);
        
        return view("admin.representante.representante", compact('representantes', 'anioEscolarActivo'));
    }
    
    /**
     * Muestra la lista de representantes eliminados
     * 
     * @return \Illuminate\View\View
     */
    public function eliminados()
    {
        // Mostrar solo los que tienen status = 0 o han sido eliminados con soft delete
        $representantes = \App\Models\Representante::with([
            'persona',
            'estado',
            'municipios',
            'localidads'
        ])
        ->where(function($query) {
            $query->where('status', 0)
                  ->orWhereNotNull('deleted_at');
        })
        ->withTrashed()
        ->paginate(10);
        
        return view("admin.representante.eliminados", compact('representantes'));
    }
    
    /**
     * Restaura un representante eliminado
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restaurar($id)
    {
        // Buscar incluyendo los eliminados con soft delete
        $representante = Representante::withTrashed()->findOrFail($id);
        
        DB::beginTransaction();
        try {
            // Restaurar el soft delete si está eliminado
            if ($representante->trashed()) {
                $representante->restore();
            }
            
            // Cambiar a estado activo
            $representante->status = 1;
            $representante->save();
            
            // Si tiene datos legales, restaurarlos también
            if ($representante->legal) {
                if (method_exists($representante->legal, 'restore') && $representante->legal->trashed()) {
                    $representante->legal->restore();
                } elseif (isset($representante->legal->status)) {
                    $representante->legal->status = 1;
                    $representante->legal->save();
                }
            }
            
            DB::commit();
            
            return redirect()->route('representante.eliminados')
                ->with('success', 'Representante restaurado exitosamente');
                
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al restaurar representante: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Error al restaurar el representante: ' . $e->getMessage());
        }
    }


    
    /**
     * Muestra el formulario para crear un nuevo representante
     * 
     * @return \Illuminate\View\View
     */

    public function mostrarFormulario(){
        // Cargar estados con sus municipios y localidades anidadas
         $from = request('from');
        $estados = Estado::with(['municipio' => function($query) {
            $query->with(['localidades'])->orderBy('nombre_municipio', 'ASC');
        }])->orderBy('nombre_estado', 'ASC')->get();
        
        $bancos = Banco::WHERE('status', true)->orderBy("nombre_banco","ASC")->get();
        $prefijos_telefono = PrefijoTelefono::WHERE('status', true)->orderBy("prefijo", "ASC")->get();
        $ocupaciones = Ocupacion::WHERE('status', true)->orderBy('nombre_ocupacion', 'ASC')->get();
        $tipoDocumentos = TipoDocumento::WHERE('status', true)->get();
        $generos = Genero::WHERE('status', true)->get();
        
        return view("admin.representante.formulario_representante", 
            compact('estados', 'bancos', 'prefijos_telefono', 'ocupaciones', 'tipoDocumentos', 'generos', 'from'));
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
    
    /**
     * Parse a date string into Y-m-d format
     *
     * @param string|null $dateString
     * @return string|null
     */
    private function parseDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

        $formats = [
            'd/m/Y', 'd-m-Y', 'd.m.Y', // Common date formats
            'Y-m-d', 'Y/m/d', 'Y.m.d', // Alternative formats
        ];

        foreach ($formats as $format) {
            try {
                return \Carbon\Carbon::createFromFormat($format, $dateString)->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }
        }

        // If no format matched, try PHP's strtotime as a fallback
        try {
            return \Carbon\Carbon::parse($dateString)->format('Y-m-d');
        } catch (\Exception $e) {
            Log::error('Error al analizar la fecha: ' . $dateString, [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Validate if a date string matches any of the expected formats
     *
     * @param string $dateString
     * @return bool
     */
    private function isValidDate($dateString)
    {
        if (empty($dateString)) {
            return false;
        }

        $formats = ['d/m/Y', 'd-m-Y', 'd.m.Y', 'Y-m-d', 'Y/m/d', 'Y.m.d'];
        
        foreach ($formats as $format) {
            $d = \DateTime::createFromFormat($format, $dateString);
            if ($d && $d->format($format) === $dateString) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Handle the update of an existing representante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Find the representante to update
        $representante = Representante::with('persona')->findOrFail($id);
        $persona = $representante->persona;

        // Log the update attempt
        Log::info('=== ACTUALIZANDO REPRESENTANTE ===', [
            'representante_id' => $id,
            'persona_id' => $persona->id,
            'request_data' => $request->except(['_token', '_method', 'password']),
            'current_document' => $persona->numero_documento,
            'new_document' => $request->input('numero_documento-representante')
        ]);

        // Validate the request
        $rules = [
            'numero_documento-representante' => [
                'required',
                'string',
                'max:20',
                Rule::unique('personas', 'numero_documento')->ignore($persona->id),
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^\d{6,8}$/', $value)) {
                        $fail('El número de cédula debe contener entre 6 y 8 dígitos.');
                    }
                },
            ],
            'primer-nombre-representante' => 'required|string|max:50',
            'primer-apellido-representante' => 'required|string|max:50',
            'fecha-nacimiento-representante' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!$this->isValidDate($value)) {
                        $fail('El formato de la fecha debe ser DD/MM/YYYY');
                    }
                }
            ],
            'sexo-representante' => 'required|exists:generos,id',
            'tipo-ci-representante' => 'required|exists:tipo_documentos,id',
            'estado_id' => 'required|exists:estados,id',
            'municipio_id' => 'required|exists:municipios,id',
            'parroquia_id' => 'required|exists:localidads,id',
            'pertenece_organizacion' => 'sometimes|boolean',
            'cual_organizacion_representante' => 'required_if:pertenece_organizacion,1|nullable|string|max:255',
        ];

        $messages = [
            'required' => 'El campo :attribute es obligatorio.',
            'numero_documento-representante.unique' => 'Este número de cédula ya está registrado',
            'numero_documento-representante.regex' => 'El número de cédula debe contener entre 6 y 8 dígitos',
            'fecha-nacimiento-representante' => 'Formato de fecha inválido',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        // Start transaction
        DB::beginTransaction();

        try {
            // Update persona data
            $persona->update([
                'primer_nombre' => $request->input('primer-nombre-representante'),
                'segundo_nombre' => $request->input('segundo-nombre-representante'),
                'tercer_nombre' => $request->input('tercer-nombre-representante'),
                'primer_apellido' => $request->input('primer-apellido-representante'),
                'segundo_apellido' => $request->input('segundo-apellido-representante'),
                'numero_documento' => $request->input('numero_documento-representante'),
                'fecha_nacimiento' => $this->parseDate($request->input('fecha-nacimiento-representante')),
                'genero_id' => $request->input('sexo-representante'),
                'tipo_documento_id' => $request->input('tipo-ci-representante'),
                'prefijo_id' => $request->input('prefijo_telefono'),
                'telefono' => $request->input('telefono_movil'),
                'email' => $request->input('correo-representante'),
                'localidad_id' => $request->input('parroquia_id'),
            ]);

            // Update representante data
            $representante->update([
                'estado_id' => $request->input('estado_id'),
                'municipio_id' => $request->input('municipio_id'),
                'parroquia_id' => $request->input('parroquia_id'),
                'ocupacion_representante' => $request->input('ocupacion_id'),
                'convivenciaestudiante_representante' => $request->input('convive-representante', 'no'),
            ]);

            // Handle representante legal data
            $perteneceOrganizacion = $request->input('pertenece_organizacion') == '1';
            
            if ($perteneceOrganizacion) {
                // Only include organization data if the checkbox is checked
                $organizacionData = [
                    'pertenece_a_organizacion_representante' => true,
                    'cual_organizacion_representante' => $request->input('cual_organizacion_representante', '')
                ];
                
                if ($representante->legal) {
                    $representante->legal()->update($organizacionData);
                } else {
                    $representante->legal()->create($organizacionData);
                }
            } else if ($representante->legal) {
                // If checkbox is not checked but legal record exists, delete it
                $representante->legal()->delete();
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Representante actualizado exitosamente',
                'redirect' => route('representante.index')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar representante: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar el representante: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle the creation or update of a representante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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

        // Fecha de nacimiento: tomar la del representante y formatear correctamente
        'fecha_nacimiento' => $this->parseDate($request->input('fecha-nacimiento-representante')),
        'fecha_nacimiento_personas' => $this->parseDate($request->input('fecha-nacimiento-representante')),

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

        // Reglas de validación base para representantes
        $personaId = $request->input('persona_id');
        $currentDocument = $personaId ? Persona::find($personaId)->numero_documento : null;
        $newDocument = $request->input('numero_documento-representante');
        
        $rules = [
            'numero_documento-representante' => [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) use ($currentDocument, $newDocument, $personaId) {
                    // Solo validar si el documento ha cambiado
                    ($currentDocument !== $newDocument) && 
                    Rule::unique('personas', 'numero_documento')->ignore($personaId);
                    
                    if (!preg_match('/^\d{6,8}$/', $value)) {
                        $fail('El número de cédula debe contener entre 6 y 8 dígitos.');
                    }
                },
            ],
            'primer-nombre-representante' => 'required|string|max:50',
            'primer-apellido-representante' => 'required|string|max:50',
            'fecha-nacimiento-representante' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!$this->isValidDate($value)) {
                        $fail('El formato de la fecha debe ser DD/MM/YYYY');
                    }
                }
            ],
            'fecha_nacimiento' => 'required|date',
            'telefono-representante' => 'required|string|max:20',
            'sexo-representante' => 'required|in:M,F,O',
            'tipo-ci-representante' => 'required|exists:tipos_documentos,id',
            'estado_id' => 'required|exists:estados,id',
            'municipio_id' => 'required|exists:municipios,id',
            'parroquia_id' => 'required|exists:parroquias,id',
            'direccion-habitacion' => 'required|string|max:255',
            'convive-representante' => 'required|in:si,no',
            'ocupacion-representante' => 'required|exists:ocupacions,id',
            'correo-representante' => 'required|email|max:100',
            'estado_id' => 'required|exists:estados,id',
            'municipio_id' => 'required|exists:municipios,id',
            'parroquia_id' => 'nullable|exists:localidads,id',
            'sexo_representante' => 'required|exists:generos,id',
            'tipo_numero_documento_persona' => 'required|exists:tipo_documentos,id',
        ];

        // Mensajes de error personalizados
        $messages = [
            'primer-nombre-representante.required' => 'El primer nombre es obligatorio',
            'primer-apellido-representante.required' => 'El primer apellido es obligatorio',
            'fecha-nacimiento-representante.required' => 'La fecha de nacimiento es obligatoria',
            'fecha-nacimiento-representante.date_format' => 'El formato de fecha debe ser DD/MM/YYYY',
            'telefono-representante.required' => 'El teléfono es obligatorio',
            'sexo-representante.required' => 'El género es obligatorio',
            'tipo-ci-representante.required' => 'El tipo de documento es obligatorio',
            'estado_id.required' => 'El estado es obligatorio',
            'municipio_id.required' => 'El municipio es obligatorio',
            'parroquia_id.required' => 'La parroquia es obligatoria',
            'direccion-habitacion.required' => 'La dirección es obligatoria',
            'convive-representante.required' => 'Debe indicar si convive con el estudiante',
            'ocupacion-representante.required' => 'La ocupación es obligatoria',
            'correo-representante.required' => 'El correo electrónico es obligatorio',
            'correo-representante.email' => 'El correo electrónico no es válido',
            'numero_numero_documento_persona.required' => 'El número de cédula es obligatorio',
            'numero_numero_documento_persona.unique' => 'Este número de cédula ya está registrado',
            'numero_numero_documento_persona.required' => 'El número de documento es obligatorio',
            'primer-nombre-representante.required' => 'El primer nombre es obligatorio',
            'primer-apellido-representante.required' => 'El primer apellido es obligatorio',
            'fecha-nacimiento-representante.required' => 'La fecha de nacimiento es obligatoria',
            'fecha-nacimiento-representante' => 'El formato de la fecha debe ser DD/MM/YYYY',
            'telefono-representante.required' => 'El teléfono es obligatorio',
            'correo-representante.required' => 'El correo electrónico es obligatorio',
            'correo-representante.email' => 'El correo electrónico debe ser una dirección válida',
            'estado_id.required' => 'El estado es obligatorio',
            'municipio_id.required' => 'El municipio es obligatorio',
            'sexo_representante.required' => 'El género es obligatorio',
            'tipo_numero_documento_persona.required' => 'El tipo de documento es obligatorio',
        ];

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            $allErrors = $validator->errors()->all();
            
            Log::error('Errores de validación al guardar representante', [
                'errors' => $validator->errors()->toArray(),
                'all_errors' => $allErrors,
                'request_data' => $request->except(['_token', 'password', 'password_confirmation']),
                'error_message' => $errorMessage,
                'is_progenitor_representante' => $esProgenitorRepresentante,
                'tipo_representante' => $tipoRepresentante,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $errorMessage,
                    'errors' => $validator->errors(),
                    'all_errors' => $allErrors
                ], 422);
            }

            

            return redirect()->back()
                ->with('error', 'Error de validación: ' . $errorMessage)
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
    $numero_documento = $request->input('numero_documento-representante');
    $personaId = $request->id ?? $request->persona_id;

    // 1. Buscar si ya existe una persona con este número de documento
    $personaExistente = Persona::where('numero_documento', $numero_documento)
        ->when($personaId, function($q) use ($personaId) {
            $q->where('id', '!=', $personaId);
        })
        ->first();

    // 2. Si la persona existe, verificar si tiene representante activo
    if ($personaExistente) {
        $tieneRepresentanteActivo = $personaExistente->representante()
            ->where('status', '!=', 0)
            ->whereNull('deleted_at')
            ->exists();

        // 3. Si tiene representante activo y no es un caso de progenitor como representante, mostrar error
        if ($tieneRepresentanteActivo && !$esProgenitorRepresentante) {
            Log::warning('Intento de registrar cédula duplicada', [
                'numero_documento' => $numero_documento,
                'persona_existente_id' => $personaExistente->id,
                'persona_actual_id' => $personaId,
                'esProgenitorRepresentante' => $esProgenitorRepresentante,
                'tieneRepresentanteActivo' => $tieneRepresentanteActivo
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error de validación',
                    'errors' => [
                        'numero_documento-representante' => ['Esta cédula ya está registrada en el sistema']
                    ]
                ], 422);
            } else {
                return redirect()->back()
                    ->withErrors(['numero_documento-representante' => 'Esta cédula ya está registrada en el sistema'])
                    ->withInput();
            }
        }
        
        // 4. Si la persona existe pero no tiene representante activo, usamos su ID para actualizar
        $request->merge(['persona_id' => $personaExistente->id]);
        $request->merge(['persona-id-representante' => $personaExistente->id]);
    }

    // Datos de persona
    // Adaptar los datos de Persona al esquema actual del modelo Persona
    $tipoRepresentante = $request->input('tipo_representante');
    
    // Inicializar el array de datos de persona
    $datosPersona = [
        "id" => $request->id ?? $request->input('persona-id-representante')
    ];

    // Si es un representante legal que es la madre
    if ($tipoRepresentante === 'progenitor_madre_representante') {
        // Depuración: Mostrar todos los inputs recibidos
        Log::info('Inputs recibidos para madre:', $request->all());
        
        $datosPersona = array_merge($datosPersona, [
            "primer_nombre" => $request->input('primer-nombre'),
            "segundo_nombre" => $request->input('segundo-nombre'),
            "prefijo_id" => $request->input('prefijo'),
            "tercer_nombre" => $request->input('tercer-nombre'),
            "primer_apellido" => $request->input('primer-apellido'),
            "segundo_apellido" => $request->input('segundo-apellido'),
            "numero_documento" => $request->input('numero_documento'),
            "fecha_nacimiento" => $this->parseDate($request->input('fechaNacimiento')),
            "genero_id" => $request->input('sexo'),
            "localidad_id" => $request->input('idparroquia'),
            "telefono" => $request->input('telefono'),
            "tipo_documento_id" => $request->input('tipo-ci'),
            "direccion" => $request->input('direccion-habitacion'),
            "email" => $request->input('correo-representante'),
        ]);
        
        // Depuración: Mostrar los datos que se van a guardar
        Log::info('Datos procesados para madre:', $datosPersona);
    } 
    // Si el padre es el representante y la madre está ausente
    elseif ($request->input('estado_madre') === 'Ausente' && $tipoRepresentante === 'progenitor_padre_representante') {
        $datosPersona = array_merge($datosPersona, [
            "primer_nombre" => $request->input('primer-nombre-padre'),
            "segundo_nombre" => $request->input('segundo-nombre-padre'),
            "prefijo_id" => $request->input('prefijo-padre'),
            "tercer_nombre" => $request->input('tercer-nombre-padre'),
            "primer_apellido" => $request->input('primer-apellido-padre'),
            "segundo_apellido" => $request->input('segundo-apellido-padre'),
            "numero_documento" => $request->input('numero_documento-padre'),
            "fecha_nacimiento" => $this->parseDate($request->input('fecha-nacimiento-padre')),
            "genero_id" => $request->input('sexo-padre'),
            "localidad_id" => $request->input('idparroquia-padre'),
            "telefono" => $request->input('telefono-padre'),
            "tipo_documento_id" => $request->input('tipo-ci-padre'),
            "direccion" => $request->input('direccion-padre') ?? $request->input('direccion-habitacion'),
            "email" => $request->input('correo-padre') ?? $request->input('correo-representante'),
        ]);
    }
    // Caso por defecto (representante normal o no progenitor)
    else {
        $datosPersona = array_merge($datosPersona, [
            "primer_nombre" => $request->input('primer-nombre-representante'),
            "segundo_nombre" => $request->input('segundo-nombre-representante'),
            "prefijo_id" => $request->input('prefijo-representante'),
            "tercer_nombre" => $request->input('tercer-nombre-representante'),
            "primer_apellido" => $request->input('primer-apellido-representante'),
            "segundo_apellido" => $request->input('segundo-apellido-representante'),
            "numero_documento" => $request->input('numero_documento-representante'),
            "fecha_nacimiento" => $this->parseDate($request->input('fecha-nacimiento-representante')),
            "genero_id" => $request->input('sexo-representante'),
            "localidad_id" => $request->input('idparroquia-representante'),
            "telefono" => $request->input('telefono-representante'),
            "tipo_documento_id" => $request->input('tipo-ci-representante'),
            "direccion" => $request->input('direccion-habitacion'),
            "email" => $request->input('correo-representante'),
        ]);
    }

    // Campos adicionales del request que no existen en el modelo Persona se ignoran

    // Datos de representante
    $datosRepresentante = [
        "estado_id" => $request->estado_id ?: 1,
        "municipio_id" => $request->municipio_id,
        "parroquia_id" => $request->parroquia_id,
        "ocupacion_representante" => $request->input('ocupacion-madre') 
    ?: $request->input('ocupacion-padre') 
    ?: $request->input('ocupacion-representante') 
    ?: null,
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

    // Inicializar variables
    $mensaje = '';
    $persona = null;
    $isUpdate = false;
    $representante = null;
    
    DB::beginTransaction();
    try {

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
            
            // Determinar si es un progenitor (madre o padre) que también es representante legal
            $esProgenitorNoRepresentante = false;
            $tipoProgenitor = null;
            
            // Obtener el tipo de representante del request
            $tipoRepresentante = $request->input('tipo_representante');
            $esRepresentanteLegal = in_array($tipoRepresentante, ['representante_legal', 'progenitor_representante', 'progenitor_madre_representante', 'progenitor_padre_representante']);
            
            Log::info('Validando tipo de representante', [
                'tipo_representante' => $tipoRepresentante,
                'esRepresentanteLegal' => $esRepresentanteLegal,
                'numero_documento' => $request->input('numero_documento'),
                'numero_documento_representante' => $request->input('numero_documento-representante'),
                'numero_documento_padre' => $request->input('numero_documento-padre')
            ]);
            
            // Por defecto, asumimos que es representante legal (estado 1)
            $datosRepresentante['status'] = 1;
            
            // Verificar si es la madre (estado_madre = "Presente")
            if ($request->input('estado_madre') === 'Presente' && 
                $request->input('numero_documento') === $request->input('numero_documento-representante')) {
                
                $tipoProgenitor = 'madre';
                
                if ($esRepresentanteLegal) {
                    // Si es representante legal, mantener estado 1
                    Log::info('Madre es representante legal, manteniendo estado 1', [
                        'numero_documento' => $request->input('numero_documento-representante'),
                        'tipo_representante' => $tipoRepresentante
                    ]);
                } else {
                    // Si no es representante legal, marcar como madre (estado 3)
                    $esProgenitorNoRepresentante = true;
                    $datosRepresentante['status'] = 3;
                    Log::info('Madre no es representante legal, asignando estado 3', [
                        'numero_documento' => $request->input('numero_documento-representante'),
                        'tipo_representante' => $tipoRepresentante
                    ]);
                }
            } 
            // Verificar si es el padre (estado_padre = "Presente")
            elseif ($request->input('estado_padre') === 'Presente' && 
                   $request->input('numero_documento-padre') === $request->input('numero_documento-representante')) {
                
                $tipoProgenitor = 'padre';
                
                if ($esRepresentanteLegal) {
                    // Si es representante legal, mantener estado 1
                    Log::info('Padre es representante legal, manteniendo estado 1', [
                        'numero_documento' => $request->input('numero_documento-representante'),
                        'tipo_representante' => $tipoRepresentante
                    ]);
                } else {
                    // Si no es representante legal, marcar como padre (estado 2)
                    $esProgenitorNoRepresentante = true;
                    $datosRepresentante['status'] = 2;
                    Log::info('Padre no es representante legal, asignando estado 2', [
                        'numero_documento' => $request->input('numero_documento-representante'),
                        'tipo_representante' => $tipoRepresentante
                    ]);
                }
            }
            
            // Buscar o crear el representante
            $representante = Representante::updateOrCreate(
                ['persona_id' => $persona->id],
                $datosRepresentante
            );
            
            Log::info('Representante guardado/actualizado', [
                'id' => $representante->id,
                'persona_id' => $persona->id,
                'tipo' => $esProgenitorNoRepresentante ? 'Progenitor ' . $tipoProgenitor : 'Representante legal',
                'status' => $representante->status
            ]);
            
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
            Log::info('Actualizando persona con datos:', [
                'persona_id' => $persona->id,
                'datos_persona' => $datosPersona
            ]);
            
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
                    $representanteLegal = new RepresentanteLegal($datosRepresentanteLegal);
                    $representante->legal()->save($representanteLegal);
                    Log::info('Nuevo representante legal creado: ID ' . $representanteLegal->id);
                }
            } else if ($esProgenitorRepresentante && $request->es_representate_legal) {
                // Si es progenitor y además es representante legal
                $datosRepresentanteLegal["representante_id"] = $representante->id;
                $representanteLegal = new RepresentanteLegal($datosRepresentanteLegal);
                $representante->legal()->save($representanteLegal);
                Log::info('Progenitor registrado también como representante legal: ID ' . $representanteLegal->id);
            } else {
                // Si no es representante legal pero existe, eliminarlo
                $representante->legal()->delete();
                Log::info('Representante legal eliminado');
            }

            $mensaje = "Los datos del representante han sido actualizados exitosamente";
        } else {
            // Establecer mensaje para creación normal
            $mensaje = $isUpdate ? 'Representante actualizado exitosamente' : 'Representante creado exitosamente';
            // === MODO CREACIÓN ===
            Log::info('=== MODO CREACIÓN ===');
            
            // Asegurar que los campos requeridos tengan valores por defecto
            $datosPersona = array_merge([
                'primer_nombre' => $datosPersona['primer_nombre'] ?? 'SIN NOMBRE',
                'primer_apellido' => $datosPersona['primer_apellido'] ?? 'SIN APELLIDO',
                'fecha_nacimiento' => $datosPersona['fecha_nacimiento'] ?? now()->format('Y-m-d'),
                'tipo_documento_id' => $datosPersona['tipo_documento_id'] ?? 1,
                'genero_id' => $datosPersona['genero_id'] ?? 1,
                'localidad_id' => $datosPersona['localidad_id'] ?? 1,
                'prefijo_id' => $datosPersona['prefijo_id'] ?? 1,
                'status' => true
            ], $datosPersona);

            // 1. Crear persona
            Log::info('Creando nueva persona con datos:', [
                'datos_persona' => $datosPersona
            ]);
            
            $persona = Persona::create($datosPersona);
            Log::info('Persona creada: ID ' . $persona->id);

            // 2. Crear representante
            $datosRepresentante["persona_id"] = $persona->id;
            $representante = Representante::create($datosRepresentante);
            Log::info('Representante creado: ID ' . $representante->id);

            // 3. Manejar representante legal si es necesario
            if($request->es_representate_legal == true) {
                $datosRepresentanteLegal["representante_id"] = $representante->id;
                $representanteLegal = new RepresentanteLegal($datosRepresentanteLegal);
                $representante->legal()->save($representanteLegal);
                Log::info('Representante legal creado: ID ' . $representanteLegal->id);
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

            // Verificar si es representante legal para mantener el estado 1
            $esRepresentanteLegal = in_array($request->input('tipo_representante'), ['representante_legal', 'progenitor_representante', 'progenitor_madre_representante', 'progenitor_padre_representante']);
            
            Log::info('Guardando madre como representante', [
                'persona_id' => $personaMadre->id,
                'esRepresentanteLegal' => $esRepresentanteLegal,
                'tipo_representante' => $request->input('tipo_representante')
            ]);

            $representanteMadre->estado_id = $request->input('idEstado');
            
            // Mantener el estado 1 si es representante legal, de lo contrario asignar estado 3
            if ($esRepresentanteLegal) {
                $representanteMadre->status = 1; // Mantener como representante legal
                Log::info('Manteniendo estado 1 para madre representante legal', [
                    'numero_documento' => $numero_documentoMadre,
                    'tipo_representante' => $request->input('tipo_representante')
                ]);
            } else {
                $representanteMadre->status = 3; // Madre no representante legal
                Log::info('Asignando estado 3 a madre no representante legal', [
                    'numero_documento' => $numero_documentoMadre,
                    'tipo_representante' => $request->input('tipo_representante')
                ]);
            }
            $representanteMadre->municipio_id = $request->input('idMunicipio');
            $representanteMadre->parroquia_id = $request->input('idparroquia');
            $representanteMadre->ocupacion_representante = $request->input('ocupacion-madre');
            $representanteMadre->convivenciaestudiante_representante = $request->input('convive') ?: 'no';
            
            // Solo actualizar el estado si no es representante legal
            if ($request->input('estado_madre') === 'Presente' && !$esRepresentanteLegal) {
                $representanteMadre->status = 3; // Solo asignar estado 3 si no es representante legal
                Log::info('Asignando estado de madre (3) al representante', [
                    'numero_documento' => $numero_documentoMadre,
                    'representante_id' => $representanteMadre->id ?? 'nuevo'
                ]);
            } else {
                $representanteMadre->status = 1; // Estado por defecto
            }

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

            // Verificar si es representante legal para mantener el estado 1
            $esRepresentanteLegal = in_array($request->input('tipo_representante'), ['representante_legal', 'progenitor_representante', 'progenitor_madre_representante', 'progenitor_padre_representante']);
            
            Log::info('Guardando padre como representante', [
                'persona_id' => $personaPadre->id,
                'esRepresentanteLegal' => $esRepresentanteLegal,
                'tipo_representante' => $request->input('tipo_representante')
            ]);

            $representantePadre->estado_id    = $request->input('idEstado-padre');
            $representantePadre->municipio_id = $request->input('idMunicipio-padre');
            $representantePadre->parroquia_id = $request->input('idparroquia-padre');
            $representantePadre->ocupacion_representante = $request->input('ocupacion-padre');
            $representantePadre->convivenciaestudiante_representante = $request->input('convive-padre') ?: 'no';
            
            // Mantener el estado 1 si es representante legal, de lo contrario asignar estado 2
            if ($esRepresentanteLegal) {
                $representantePadre->status = 1; // Mantener como representante legal
                Log::info('Manteniendo estado 1 para padre representante legal', [
                    'numero_documento' => $numero_documentoPadre,
                    'tipo_representante' => $request->input('tipo_representante')
                ]);
            } else if ($request->input('estado_padre') === 'Presente') {
                $representantePadre->status = 2; // Solo asignar estado 2 si no es representante legal y está presente
                Log::info('Asignando estado 2 a padre no representante legal', [
                    'numero_documento' => $numero_documentoPadre,
                    'tipo_representante' => $request->input('tipo_representante')
                ]);
            } else {
                $representantePadre->status = 1; // Estado por defecto
            }

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

         // Si vino desde inscripcion, redirigir a la pantalla de Inscripción
            if ($request->input('from') === 'inscripcion') {
                return redirect()
                    ->route('admin.transacciones.inscripcion.create') // ruta de Inscripción en tu app
                    ->with('success', 'Representante creado. Puedes seleccionarlo ahora en Inscripción.');
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
    /**
     * Filtra los representantes según los criterios de búsqueda
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filtar(Request $request)
    {
        $buscador = $request->buscador ?? '';
        
        // Iniciar consulta con relaciones necesarias
        $consulta = Representante::query()->with('persona');

        if (!empty($buscador)) {
            $consulta = $consulta->whereHas('persona', function($query) use ($buscador) {
                $query->where(function($q) use ($buscador) {
                    $q->where('numero_documento', 'LIKE', "%{$buscador}%")
                      ->orWhere('primer_nombre', 'LIKE', "%{$buscador}%")
                      ->orWhere('segundo_nombre', 'LIKE', "%{$buscador}%")
                      ->orWhere('primer_apellido', 'LIKE', "%{$buscador}%")
                      ->orWhere('segundo_apellido', 'LIKE', "%{$buscador}%")
                      ->orWhereRaw("CONCAT(primer_nombre, ' ', COALESCE(segundo_nombre, ''), ' ', primer_apellido, ' ', COALESCE(segundo_apellido, '')) LIKE ?", ["%{$buscador}%"]);
                });
            });
        }

        // Ordenar por fecha de creación descendente (los más recientes primero)
        $consulta->orderBy('created_at', 'desc');

        // Paginar los resultados
        $respuesta = $consulta->paginate(10);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Representantes consultados correctamente',
            'data' => $respuesta,
        ], 200);
    }

    public function delete(Request $request, $id): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $representanteId = $id ?? $request->id ?? $request->input('id');
        Log::info('=== INICIANDO ELIMINACIÓN LÓGICA DE REPRESENTANTE ===', [
            'id' => $representanteId,
            'input' => $request->all()
        ]);

        $representante = Representante::with(['persona', 'legal'])->find($representanteId);
        
        Log::info('Representante encontrado:', [
            'id' => $representante ? $representante->id : null,
            'current_status' => $representante ? $representante->status : null
        ]);

        if (!$representante) {
            $error = 'Representante no encontrado';
            Log::error($error, ['id' => $representanteId]);
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $error,
                ], 404);
            }

            return redirect()->route('representante.index')
                ->with('error', $error);
        }

        DB::beginTransaction();
        try {
            // 1. Actualizar el estado a 0 (Eliminado)
            $representante->status = 0;
            $saved = $representante->save();
            
            Log::info('Actualización del estado a inactivo:', [
                'saved' => $saved,
                'new_status' => $representante->status,
                'updated_at' => $representante->updated_at
            ]);

            // 2. Aplicar soft delete
            $deleted = $representante->delete();
            Log::info('Soft delete aplicado:', ['deleted' => $deleted]);

            // 3. Manejar datos legales relacionados
            if ($representante->legal) {
                Log::info('Datos legales encontrados, actualizando...');
                
                // Si el modelo legal tiene soft delete, usarlo
                if (method_exists($representante->legal, 'delete')) {
                    $deletedLegal = $representante->legal->delete();
                    Log::info('Datos legales marcados como eliminados (soft delete):', ['deleted' => $deletedLegal]);
                } 
                // Si no tiene soft delete pero tiene campo status
                elseif (isset($representante->legal->status)) {
                    $representante->legal->status = 0;
                    $legalSaved = $representante->legal->save();
                    Log::info('Estado de datos legales actualizado a inactivo:', ['saved' => $legalSaved]);
                }
            }
            
            DB::commit();

            $response = [
                'status' => 'success',
                'message' => 'Representante eliminado correctamente',
                'data' => [
                    'id' => $representante->id,
                    'status' => 0,
                    'deleted_at' => $representante->deleted_at,
                    'updated_at' => $representante->updated_at
                ]
            ];
            
            Log::info('Eliminación exitosa:', $response);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json($response);
            }

            return redirect()->route('representante.index')
                ->with('success', '¡El representante ha sido eliminado correctamente!');
                
        } catch (\Throwable $th) {
            DB::rollBack();
            $errorMessage = 'Error al eliminar el representante: ' . $th->getMessage();
            \Log::error($errorMessage, [
                'exception' => $th,
                'trace' => $th->getTraceAsString(),
                'representante_id' => $representanteId
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $errorMessage
                ], 500);
        }

        return redirect()->back()
            ->with('error', $errorMessage);
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
        $query = Persona::where('numero_documento', $numero_documento)
            ->whereHas('representante', function($q) {
                // Solo verificar cédulas de representantes activos (status != 0 y no eliminados)
                $q->where('status', '!=', 0)
                  ->whereNull('deleted_at');
            });

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

        // Verificar si existe un registro con esta cédula pero está marcado como eliminado
        $registroEliminado = Persona::where('numero_documento', $numero_documento)
            ->whereHas('representante', function($q) {
                $q->where('status', 0)
                  ->orWhereNotNull('deleted_at');
            })
            ->when($personaId, function($q) use ($personaId) {
                $q->where('id', '!=', $personaId);
            })
            ->first();

        if ($registroEliminado) {
            return response()->json([
                'status' => 'info',
                'message' => 'Esta cédula pertenece a un registro previamente eliminado. Puede reutilizarla.',
                'puede_usar' => true,
                'persona' => $registroEliminado
            ]);
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
    
    // Ordenamos por la primera letra del primer apellido
    $representantes = $representantes->sortBy(function($item) {
        // Accedemos directamente a la propiedad si existe
        $primerApellido = $item->primer_apellido ?? 
                         ($item->persona->primer_apellido ?? '');
        return strtoupper(substr($primerApellido, 0, 1));
    });

    if($representantes->isEmpty()){
        return response()->json('No se encontraron representantes', 404);
    }

    $pdf = PDF::loadView('admin.representante.reportes.general_pdf', compact('representantes'));
    return $pdf->stream('representantes.pdf');
}

}
