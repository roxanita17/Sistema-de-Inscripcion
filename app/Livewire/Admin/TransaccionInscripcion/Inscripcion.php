<?php

namespace App\Livewire\Admin\TransaccionInscripcion;

use Livewire\Component;
use App\Services\InscripcionService;
use App\Services\DocumentoService;
use App\Repositories\InscripcionRepository;
use App\Repositories\RepresentanteRepository;
use App\DTOs\InscripcionData;
use App\Exceptions\InscripcionException;
use Illuminate\Database\QueryException;


class Inscripcion extends Component
{
    protected InscripcionService $inscripcionService;
    protected DocumentoService $documentoService;
    protected InscripcionRepository $inscripcionRepository;
    protected RepresentanteRepository $representanteRepository;

    /* ============================================================
       PROPIEDADES
       ============================================================ */
    public $alumnoId;
    public $padreId;
    public $madreId;
    public $representanteLegalId;
    public $gradoId;
    public $seccion_id = null;

    public $infoCupos = null;
    public $alumnoSeleccionado = null;
    public $padreSeleccionado = null;
    public $madreSeleccionado = null;
    public $representanteLegalSeleccionado = null;

    public $padres = [];
    public $madres = [];
    public $representantes = [];
    public $instituciones = [];
    public $grados = [];
    public $secciones = [];
    public $expresiones_literarias = [];

    public $documentos = [];
    public array $documentosFaltantes = [];
    public ?string $observaciones = null;
    public $numero_zonificacion;
    public $institucion_procedencia_id;
    public $expresion_literaria_id;
    public $anio_egreso;
    public $anio_escolar_id;
    public $acepta_normas_contrato = false;
    public $seleccionarTodos = false;

    // Discapacidades
    public $discapacidades = [];
    public $discapacidadSeleccionada = null;
    public $discapacidadesAgregadas = [];

    public $documentosDisponibles = [];
    public $documentosEtiquetas = [];

    public string $estadoDocumentos = '';
    public string $statusInscripcion = '';

    public bool $esPrimerGrado = true;

    public string $tipo_inscripcion = 'nuevo_ingreso';

    public bool $gradoSinCupos = false;
    public string $mensajeCupos = '';


    /* ============================================================
       BOOT & MOUNT
       ============================================================ */
    public function boot(
        InscripcionService $inscripcionService,
        DocumentoService $documentoService,
        InscripcionRepository $inscripcionRepository,
        RepresentanteRepository $representanteRepository
    ) {
        $this->inscripcionService = $inscripcionService;
        $this->documentoService = $documentoService;
        $this->inscripcionRepository = $inscripcionRepository;
        $this->representanteRepository = $representanteRepository;
    }



    public function mount()
    {
        $this->acepta_normas_contrato = true;
        $this->discapacidadesAgregadas = [];
        $this->discapacidadSeleccionada = null;
        $this->documentosDisponibles = $this->documentoService->obtenerDocumentosDisponibles();
        $this->documentosEtiquetas = $this->documentoService->obtenerEtiquetas();
        $this->tipo_inscripcion = 'nuevo_ingreso';
        $this->cargarDatosIniciales();
    }

    /* ============================================================
       VALIDACIÓN 
       ============================================================ */
    public function rules()
    {
        return [
            'numero_zonificacion' => [
                'nullable',
                'regex:/^\d+$/'
            ],
            'institucion_procedencia_id' => 'required|exists:institucion_procedencias,id',
            'expresion_literaria_id' => 'required|exists:expresion_literarias,id',
            'gradoId' => [
                'required',
                'exists:grados,id',
                function ($attribute, $value, $fail) {
                    if (!$this->inscripcionService->verificarCuposDisponibles($value)) {
                        $fail('El grado seleccionado ha alcanzado el límite de cupos disponibles.');
                    }
                }
            ],
            'seccion_id' => $this->esPrimerGrado
                ? 'nullable'
                : 'required|exists:seccions,id',

            'documentos' => 'array',
            'documentos.*' => 'string',
            'acepta_normas_contrato' => 'accepted',
            'anio_egreso' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (!$this->inscripcionService->validarAnioEgreso($value)) {
                        $fail('El año de egreso debe ser 7 años antes del año actual.');
                    }
                }
            ],
        ];
    }

    protected $messages = [
        'tipo_inscripcion.required' => 'Debe seleccionar el tipo de inscripción.',
        'tipo_inscripcion.in' => 'El tipo de inscripción no es válido.',

        'numero_zonificacion.regex' => 'El número de zonificación solo puede contener números.',

        'institucion_procedencia_id.required' => 'Debe seleccionar una institución de procedencia.',
        'institucion_procedencia_id.exists' => 'La institución de procedencia seleccionada no es válida.',

        'expresion_literaria_id.required' => 'Debe seleccionar una expresión literaria.',
        'expresion_literaria_id.exists' => 'La expresión literaria seleccionada no es válida.',

        'gradoId.required' => 'Debe seleccionar un grado.',
        'gradoId.exists' => 'El grado seleccionado no es válido.',

        'seccion_id.required' => 'Debe seleccionar una sección.',
        'seccion_id.exists' => 'La sección seleccionada no es válida.',

        'documentos.array' => 'El formato de los documentos seleccionados no es válido.',
        'documentos.*.string' => 'Uno o más documentos seleccionados no son válidos.',

        'acepta_normas_contrato.accepted' =>
        'Debe aceptar las normas del contrato para continuar.',

        'anio_egreso.required' => 'Debe indicar el año de egreso.',
        'anio_egreso.date' => 'El año de egreso debe ser 7 años antes del actual.',

    ];


    public function updated($propertyName)
    {
        if ($propertyName !== 'gradoId') {
            $this->validateOnly($propertyName);
        }
    }


    /* ============================================================
       CARGAS DE DATOS
       ============================================================ */
    public function cargarDatosIniciales()
    {
        $datos = $this->inscripcionRepository->obtenerDatosIniciales();

        $this->instituciones = $datos['instituciones'];
        $this->expresiones_literarias = $datos['expresiones_literarias'];
        $this->grados = $datos['grados'];
        $this->padres = $this->representanteRepository->obtenerPorGenero('Masculino');
        $this->madres = $this->representanteRepository->obtenerPorGenero('Femenino');
        $this->representantes = $this->representanteRepository->obtenerRepresentantesLegales();

        $this->discapacidades = \App\Models\Discapacidad::where('status', true)
            ->orderBy('nombre_discapacidad', 'asc')
            ->get();
    }

    /* ============================================================
       MÉTODOS UPDATED PARA CARGAR DETALLES 
       ============================================================ */

    /**
     * Se ejecuta cuando cambia el padreId en el select
     */
    public function updatedPadreId($value)
    {
        $this->padreSeleccionado = $value
            ? $this->representanteRepository->obtenerConRelaciones($value)
            : null;
    }

    /**
     * Se ejecuta cuando cambia el madreId en el select
     */
    public function updatedMadreId($value)
    {
        $this->madreSeleccionado = $value
            ? $this->representanteRepository->obtenerConRelaciones($value)
            : null;
    }

    /**
     * Se ejecuta cuando cambia el representanteLegalId en el select
     */
    public function updatedRepresentanteLegalId($value)
    {
        $this->representanteLegalSeleccionado = $value
            ? $this->representanteRepository->obtenerRepresentanteLegalConRelaciones($value)
            : null;
        $this->evaluarDocumentosVisual();
    }

    /* ============================================================
       ACTUALIZACIÓN DE SELECTS (PARA EVENTOS PERSONALIZADOS)
       ============================================================ */
    public function actualizarPadreSelect($data = null)
    {
        $id = $data['value'] ?? null;
        $this->padreId = $id;
        $this->padreSeleccionado = $id
            ? $this->representanteRepository->obtenerConRelaciones($id)
            : null;
    }

    public function actualizarMadreSelect($data = null)
    {
        $id = $data['value'] ?? null;
        $this->madreId = $id;
        $this->madreSeleccionado = $id
            ? $this->representanteRepository->obtenerConRelaciones($id)
            : null;
    }

    public function actualizarRepresentanteLegalSelect($data = null)
    {
        $id = $data['value'] ?? null;
        $this->representanteLegalId = $id;
        $this->representanteLegalSeleccionado = $id
            ? $this->representanteRepository->obtenerRepresentanteLegalConRelaciones($id)
            : null;
    }

    /* ============================================================
       MANEJO DE DOCUMENTOS
       ============================================================ */
    public function updatedSeleccionarTodos($value)
    {
        $this->documentos = $value ? $this->documentosDisponibles : [];

        $this->evaluarDocumentosVisual();
        $this->recalcularObservaciones();
    }

    public function updatedDocumentos()
    {
        $this->evaluarDocumentosVisual();
        $this->recalcularObservaciones();
    }

    private function validarDocumentosEnTiempoReal(): void
    {
        $this->resetErrorBag('documentos');

        $evaluacion = $this->documentoService->evaluarEstadoDocumentos(
            $this->documentos,
            $this->requiereAutorizacion(),
            $this->esPrimerGrado
        );

        $this->documentosFaltantes = $evaluacion['faltantes'];
    }

    private function actualizarObservacionesPorDocumentos()
    {
        $this->recalcularObservaciones();
    }


    private function requiereAutorizacion(): bool
    {
        return !$this->padreId && !$this->madreId;
    }

    private function evaluarDocumentosVisual(): void
    {
        $evaluacion = $this->documentoService->evaluarEstadoDocumentos(
            $this->documentos,
            $this->requiereAutorizacion(),
            $this->esPrimerGrado
        );

        $this->documentosFaltantes = $evaluacion['faltantes'];
        $this->estadoDocumentos = $evaluacion['estado_documentos'];
        $this->statusInscripcion = $evaluacion['status_inscripcion'];

        $this->seleccionarTodos =
            count($this->documentos) === count($this->documentosDisponibles);
    }

    private function recalcularObservaciones(): void
    {
        $observaciones = [];

        // Observaciones por documentos
        $obsDocumentos = $this->documentoService->generarObservaciones(
            $this->documentos,
            !$this->padreId && !$this->madreId,
            $this->esPrimerGrado
        );

        if ($obsDocumentos) {
            $observaciones[] = $obsDocumentos;
        }

        // Observaciones por discapacidades
        $obsDiscapacidades = $this->generarObservacionesDiscapacidades();
        if ($obsDiscapacidades) {
            $observaciones[] = $obsDiscapacidades;
        }

        // Unir todo
        $this->observaciones = implode(PHP_EOL . PHP_EOL, $observaciones);
    }

    private function generarObservacionesDiscapacidades(): ?string
    {
        $nombres = [];

        // Discapacidades ya guardadas (si existe alumno)
        if ($this->alumnoId) {
            $alumno = \App\Models\Alumno::with('discapacidades')->find($this->alumnoId);

            if ($alumno) {
                $nombres = $alumno->discapacidades
                    ->pluck('nombre_discapacidad')
                    ->toArray();
            }
        }

        // Discapacidades agregadas en esta inscripción
        foreach ($this->discapacidadesAgregadas as $discapacidad) {
            $nombres[] = $discapacidad['nombre'];
        }

        $nombres = array_unique($nombres);

        if (empty($nombres)) {
            return null;
        }

        return 'Discapacidades registradas:' . PHP_EOL .
            implode(PHP_EOL, $nombres);
    }

    /* ============================================================
       INFORMACIÓN DE CUPOS
       ============================================================ */
    public function updatedGradoId($value)
    {
        $this->resetErrorBag('gradoId');
        $this->gradoSinCupos = false;
        $this->mensajeCupos = '';

        if (!$value) {
            $this->infoCupos = null;
            $this->secciones = [];
            $this->seccion_id = null;
            return;
        }

        $this->infoCupos = $this->inscripcionService->obtenerInfoCupos($value);

        if ($this->infoCupos['cupos_disponibles'] <= 0) {
            $this->gradoSinCupos = true;
            $this->mensajeCupos = 'Este grado ha alcanzado el máximo de cupos disponibles.';
            $this->addError('gradoId', $this->mensajeCupos);
            return;
        }

        $grado = \App\Models\Grado::find($value);
        $this->esPrimerGrado = ((int) $grado->numero_grado === 1);

        if (!$this->esPrimerGrado) {
            $this->secciones = \App\Models\Seccion::where('grado_id', $value)
                ->where('status', true)
                ->orderBy('nombre')
                ->get();
        } else {
            $this->secciones = [];
            $this->seccion_id = null;
        }

        $this->validarDocumentosEnTiempoReal();
        $this->evaluarDocumentosVisual();
        $this->recalcularObservaciones();
    }


    /* ============================================================
       REGISTRO DE DISCAPACIDADES
       ============================================================ */

    /**
     * Agrega una discapacidad a la lista temporal
     */
    public function agregarDiscapacidad()
    {
        $this->validate([
            'discapacidadSeleccionada' => 'required|exists:discapacidads,id'
        ], [
            'discapacidadSeleccionada.required' => 'Debe seleccionar una discapacidad.',
            'discapacidadSeleccionada.exists' => 'La discapacidad seleccionada no es válida.'
        ]);

        // Verificar si ya está agregada
        if (collect($this->discapacidadesAgregadas)->contains('id', $this->discapacidadSeleccionada)) {
            $this->addError('discapacidadSeleccionada', 'Esta discapacidad ya ha sido agregada.');
            return;
        }

        // Buscar la discapacidad y agregarla
        $discapacidad = \App\Models\Discapacidad::find($this->discapacidadSeleccionada);

        if ($discapacidad) {
            $this->discapacidadesAgregadas[] = [
                'id' => $discapacidad->id,
                'nombre' => $discapacidad->nombre_discapacidad
            ];

            // Limpiar selección
            $this->discapacidadSeleccionada = null;
            $this->resetErrorBag('discapacidadSeleccionada');

            $this->recalcularObservaciones();

            session()->flash('success_temp', 'Discapacidad agregada correctamente.');
        }
    }

    /**
     * Elimina una discapacidad de la lista temporal
     */
    public function eliminarDiscapacidad($index)
    {
        if (isset($this->discapacidadesAgregadas[$index])) {
            $discapacidad = $this->discapacidadesAgregadas[$index];
            unset($this->discapacidadesAgregadas[$index]);

            // Reindexar el array
            $this->discapacidadesAgregadas = array_values($this->discapacidadesAgregadas);

            $this->recalcularObservaciones();

            session()->flash('success_temp', "Discapacidad '{$discapacidad['nombre']}' eliminada.");
        }
    }

    /**
     * Guarda las discapacidades del alumno en la tabla intermedia
     */
    private function guardarDiscapacidadesAlumno($alumnoId)
    {
        foreach ($this->discapacidadesAgregadas as $discapacidad) {
            \App\Models\DiscapacidadEstudiante::create([
                'alumno_id' => $alumnoId,
                'discapacidad_id' => $discapacidad['id'],
                'status' => true
            ]);
        }
    }


    /* ============================================================
       REGISTRO DE INSCRIPCIÓN
       ============================================================ */
    public function registrar()
    {
        if (!$this->validarRepresentantes()) {
            return;
        }

        $this->validate();

        try {
            $dto = $this->crearInscripcionDTO();
            $inscripcion = $this->inscripcionService->registrar($dto);

            session()->flash('success', 'Inscripción registrada exitosamente.');
            return redirect()->route('admin.transacciones.inscripcion.index');
        } catch (InscripcionException $e) {

            //  Error de negocio (bonito)
            session()->flash('error', $e->getMessage());
        } catch (QueryException $e) {

            //  Error SQL controlado
            session()->flash(
                'error',
                'No se pudo completar la inscripción. Verifique los datos ingresados.'
            );
        } catch (\Throwable $e) {

            //  Error inesperado
            report($e); // LOG, no pantalla
            session()->flash(
                'error',
                'No se pudo completar la inscripción. Verifique los datos ingresados.'
            );
        }
    }


    public function finalizar()
    {
        if (!$this->acepta_normas_contrato) {
            $this->addError('acepta_normas_contrato', 'Debe aceptar las normas para continuar.');
            return;
        }

        if (!$this->validarRepresentantes()) {
            return;
        }

        $this->dispatch('solicitarDatosAlumno');
    }

    public function guardarTodo($datos = [])
    {
        if (empty($datos)) {
            return session()->flash('error', 'No se recibieron datos del alumno.');
        }

        try {
            $dto = $this->crearInscripcionDTO();
            $inscripcion = $this->inscripcionService->registrar($dto);

            session()->flash('success', 'Inscripción registrada exitosamente.');
            return redirect()->route('admin.transacciones.inscripcion.index');
        } catch (InscripcionException $e) {

            // Error de negocio (bonito)
            session()->flash('error', $e->getMessage());
        } catch (QueryException $e) {

            // Error SQL controlado
            session()->flash(
                'error',
                'No se pudo completar la inscripción. Verifique los datos ingresados.'
            );
        } catch (\Throwable $e) {

            // Error inesperado
            report($e); // LOG, no pantalla
            session()->flash(
                'error',
                'No se pudo completar la inscripción. Verifique los datos ingresados.'
            );
        }
    }

    /* ============================================================
       HELPERS PRIVADOS
       ============================================================ */
    private function validarRepresentantes(): bool
    {
        if (!$this->padreId && !$this->madreId && !$this->representanteLegalId) {
            session()->flash('error', 'Debe seleccionar al menos un representante.');
            return false;
        }
        return true;
    }

    private function crearInscripcionDTO(): InscripcionData
    {
        return new InscripcionData([
            'tipo_inscripcion' => $this->tipo_inscripcion,
            'anio_escolar_id' => $this->anio_escolar_id,
            'alumno_id' => $this->alumnoId,
            'numero_zonificacion' => $this->numero_zonificacion,
            'institucion_procedencia_id' => $this->institucion_procedencia_id,
            'anio_egreso' => $this->anio_egreso,
            'expresion_literaria_id' => $this->expresion_literaria_id,
            'grado_id' => $this->gradoId,
            'seccion_id' => $this->seccion_id,
            'padre_id' => $this->padreId,
            'madre_id' => $this->madreId,
            'representante_legal_id' => $this->representanteLegalId,
            'documentos' => $this->documentos,
            'observaciones' => $this->observaciones,
            'acepta_normas_contrato' => $this->acepta_normas_contrato,
        ]);
    }

    /* ============================================================
       LISTENERS
       ============================================================ */
    protected $listeners = [
        'recibirDatosAlumno' => 'guardarTodo',
        'padreSeleccionadoEvento' => 'actualizarPadreSelect',
        'acepta_normas_contrato' => 'actualizarEstadoBoton'
    ];

    public function actualizarEstadoBoton($value)
    {
        $this->acepta_normas_contrato = $value;
        $this->validateOnly('acepta_normas_contrato');
    }

    /* ============================================================
       NAVEGACIÓN
       ============================================================ */
    public function irACrearRepresentante()
    {
        session()->put('inscripcion_temp', [
            'alumnoId' => $this->alumnoId,
            'padreId' => $this->padreId,
            'madreId' => $this->madreId,
            'representanteLegalId' => $this->representanteLegalId,
            'gradoId' => $this->gradoId,
            'observaciones' => $this->observaciones,
            'documentos' => $this->documentos,
        ]);

        return redirect()->route('representante.formulario', ['from' => 'inscripcion']);
    }



    public function render()
    {
        return view('livewire.admin.transaccion-inscripcion.inscripcion');
    }
}
