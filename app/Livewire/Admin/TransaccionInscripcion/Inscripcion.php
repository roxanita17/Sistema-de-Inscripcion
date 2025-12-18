<?php

namespace App\Livewire\Admin\TransaccionInscripcion;

use Livewire\Component;
use App\Services\InscripcionService;
use App\Services\DocumentoService;
use App\Repositories\InscripcionRepository;
use App\Repositories\RepresentanteRepository;
use App\DTOs\InscripcionData;

class Inscripcion extends Component
{
    protected InscripcionService $inscripcionService;
    protected DocumentoService $documentoService;
    protected InscripcionRepository $inscripcionRepository;
    protected RepresentanteRepository $representanteRepository;

    /* ============================================================
       PROPIEDADES
       ============================================================ */
    public $inscripcion_id;
    public $alumnoId;
    public $padreId;
    public $madreId;
    public $representanteLegalId;
    public $gradoId;

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
    public $expresiones_literarias = [];

    public $documentos = [];
    public array $documentosFaltantes = [];

    public $observaciones;
    public $numero_zonificacion;
    public $institucion_procedencia_id;
    public $expresion_literaria_id;
    public $anio_egreso;
    public $anio_escolar_id;
    public $acepta_normas_contrato = false;
    public $seleccionarTodos = false;

    public $documentosDisponibles = [];
    public $documentosEtiquetas = [];

    public bool $esPrimerGrado = true;

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
        $this->documentosDisponibles = $this->documentoService->obtenerDocumentosDisponibles();
        $this->documentosEtiquetas = $this->documentoService->obtenerEtiquetas();

        $this->cargarDatosIniciales();
    }

    /* ============================================================
       VALIDACIÓN
       ============================================================ */
    public function rules()
    {
        return [
            'inscripcion_id' => 'required|exists:inscripcions,id',
            'numero_zonificacion' => $this->esPrimerGrado
                ? 'required|numeric'
                : 'nullable',

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

        'inscripcion_id.required' => 'Debe seleccionar una inscripción.',
        'inscripcion_id.exists' => 'La inscripción seleccionada no es válida.',

        'numero_zonificacion.required' => 'El número de zonificación es obligatorio.',
        'numero_zonificacion.numeric' => 'El número de zonificación debe ser un valor numérico.',

        'institucion_procedencia_id.required' => 'Debe seleccionar una institución de procedencia.',
        'institucion_procedencia_id.exists' => 'La institución de procedencia seleccionada no es válida.',

        'expresion_literaria_id.required' => 'Debe seleccionar una expresión literaria.',
        'expresion_literaria_id.exists' => 'La expresión literaria seleccionada no es válida.',

        'gradoId.required' => 'Debe seleccionar un grado.',
        'gradoId.exists' => 'El grado seleccionado no es válido.',



        'documentos.array' => 'El formato de los documentos seleccionados no es válido.',
        'documentos.*.string' => 'Uno o más documentos seleccionados no son válidos.',

        'acepta_normas_contrato.accepted' =>
        'Debe aceptar las normas del contrato para continuar.',

        'anio_egreso.required' => 'Debe indicar el año de egreso.',
        'anio_egreso.date' => 'El año de egreso debe ser 7 años antes del actual.',

    ];


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
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
    }

    /* ============================================================
       MÉTODOS UPDATED PARA CARGAR DETALLES 
       ============================================================ */

    /**
     * Se ejecuta cuando cambia el alumnoId en el select
     */
    public function updatedAlumnoId($value)
    {
        if (!$value) {
            $this->alumnoSeleccionado = null;
            return;
        }

        $this->alumnoSeleccionado = \App\Models\Alumno::with([
            'persona.tipoDocumento',
            'persona.genero',
            'ordenNacimiento',
            'lateralidad',
            'alumno.persona.localidad.municipio',
            'alumno.persona.localidad.estado',
        ])->find($value);

        // Verificar si ya tiene inscripción activa
        $inscripcionExistente = \App\Models\Inscripcion::where('alumno_id', $value)
            ->where('status', 'Activo')
            ->first();

        if ($inscripcionExistente) {
            session()->flash('warning', 'Este alumno ya tiene una inscripción activa.');
        }
    }

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
        $this->validarDocumentosEnTiempoReal();
        $this->actualizarObservacionesPorDocumentos();
    }

    public function updatedDocumentos()
    {
        $this->seleccionarTodos = count($this->documentos) === count($this->documentosDisponibles);
        $this->validarDocumentosEnTiempoReal();
        $this->actualizarObservacionesPorDocumentos();
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

        if (!$evaluacion['puede_guardar']) {
            $this->addError(
                'documentos',
                'Debe seleccionar los documentos obligatorios para continuar.'
            );
        }
    }

    private function actualizarObservacionesPorDocumentos()
    {
        $this->observaciones = $this->documentoService->generarObservaciones(
            $this->documentos,
            $this->requiereAutorizacion(),
            $this->esPrimerGrado
        );
    }

    private function requiereAutorizacion(): bool
    {
        return !$this->padreId && !$this->madreId;
    }

    /* ============================================================
       INFORMACIÓN DE CUPOS
       ============================================================ */
    public function updatedGradoId($value)
    {
        if (!$value) {
            $this->infoCupos = null;
            return;
        }

        $this->infoCupos = $this->inscripcionService->obtenerInfoCupos($value);

        // ⚠️ Asumimos que grado 1 es primer grado
        $grado = \App\Models\Grado::find($value);

        $this->esPrimerGrado = ((int) $grado->numero_grado === 1);

        // Limpiar campos que no aplican
        if (!$this->esPrimerGrado) {
            $this->numero_zonificacion = null;
        }

        // Revalidar documentos cuando cambia el grado
        $this->validarDocumentosEnTiempoReal();
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
            $this->inscripcionService->registrar($dto);

            session()->flash('success', 'Inscripción registrada exitosamente.');
            session()->forget('inscripcion_temp');

            return redirect()->route('admin.transacciones.inscripcion.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
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
            $this->inscripcionService->registrarConAlumno($datos, $dto);

            session()->flash('success', 'Inscripción guardada exitosamente.');
            return redirect()->route('admin.transacciones.inscripcion.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al registrar: ' . $e->getMessage());
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
            'anio_escolar_id' => $this->anio_escolar_id,
            'alumno_id' => $this->alumnoId,
            'numero_zonificacion' => $this->numero_zonificacion,
            'institucion_procedencia_id' => $this->institucion_procedencia_id,
            'anio_egreso' => $this->anio_egreso,
            'expresion_literaria_id' => $this->expresion_literaria_id,
            'grado_id' => $this->gradoId,
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
