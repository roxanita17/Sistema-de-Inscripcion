<?php

namespace App\Livewire\Admin\TransaccionInscripcion;

use Livewire\Component;
use App\Models\Inscripcion;
use App\Models\Grado;
use App\Models\Seccion;
use App\Models\InstitucionProcedencia;
use App\Models\ExpresionLiteraria;
use App\Repositories\RepresentanteRepository;
use App\Services\DocumentoService;
use App\Services\InscripcionService;
use Illuminate\Support\Facades\DB;

class InscripcionEdit extends Component
{
    protected InscripcionService $inscripcionService;
    protected RepresentanteRepository $representanteRepository;
    protected DocumentoService $documentoService;

    // ID de la inscripción
    public $inscripcionId;

    // IDs de relaciones
    public $alumnoId;
    public $padreId;
    public $madreId;
    public $representanteLegalId;
    public $gradoId;
    public $seccionId;

    // Datos seleccionados para mostrar
    public $alumnoSeleccionado = null;
    public $padreSeleccionado = null;
    public $madreSeleccionado = null;
    public $representanteLegalSeleccionado = null;

    // Listas para selects
    public $padres = [];
    public $madres = [];
    public $representantes = [];
    public $grados = [];
    public $secciones = [];
    public $instituciones = [];
    public $expresiones_literarias = [];

    // Datos de la inscripción
    public $numero_zonificacion;
    public $institucion_procedencia_id;
    public $expresion_literaria_id;
    public $anio_egreso;
    public $documentos = [];
    public $observaciones;
    public $acepta_normas_contrato = false;

    public $esPrimerGrado = true;

    // Para manejo de documentos
    public $documentosDisponibles = [];
    public $documentosEtiquetas = [];
    public $documentosFaltantes = [];
    public $seleccionarTodos = false;
    public $estadoDocumentos = '';
    public $statusInscripcion = '';

    public function boot(
        InscripcionService $inscripcionService,
        RepresentanteRepository $representanteRepository,
        DocumentoService $documentoService
    ) {
        $this->inscripcionService = $inscripcionService;
        $this->representanteRepository = $representanteRepository;
        $this->documentoService = $documentoService;
    }

    public function rules()
    {
        return [
            'gradoId' => [
                'required',
                'exists:grados,id',
                function ($attribute, $value, $fail) {
                    if (!$this->inscripcionService->verificarCuposDisponibles($value)) {
                        $fail('El grado seleccionado ha alcanzado el límite de cupos disponibles.');
                    }
                }
            ],
            'seccionId' => [
                function ($attr, $value, $fail) {
                    if (!$this->esPrimerGrado && !$value) {
                        $fail('Debe seleccionar una sección.');
                    }

                    if ($value) {
                        $existe = Seccion::where('id', $value)
                            ->where('grado_id', $this->gradoId)
                            ->where('status', true)
                            ->exists();

                        if (!$existe) {
                            $fail('La sección seleccionada no pertenece al grado.');
                        }
                    }
                }
            ],

            'padreId' => 'nullable|exists:representantes,id',
            'madreId' => 'nullable|exists:representantes,id',
            'representanteLegalId' => 'required|exists:representantes,id',

            'documentos' => 'array',
            'documentos.*' => 'in:' . implode(',', $this->documentosDisponibles),

            'numero_zonificacion' => [
                'nullable',
                'regex:/^\d+$/'
            ],
            'institucion_procedencia_id' => 'nullable|exists:institucion_procedencias,id',
            'expresion_literaria_id' => 'nullable|exists:expresion_literarias,id',

            'anio_egreso' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    if (!$this->inscripcionService->validarAnioEgreso($value)) {
                        $fail('El año de egreso debe ser 7 años antes del año actual.');
                    }
                }
            ],

            'acepta_normas_contrato' => 'accepted',
        ];
    }

    protected $messages = [
        'gradoId.required' => 'Debe seleccionar un grado.',
        'gradoId.exists' => 'El grado seleccionado no es válido.',

        'documentos.array' => 'Formato inválido de documentos.',
        'documentos.*.in' => 'Uno o más documentos no son válidos.',

        'numero_zonificacion.regex' =>
        'El número de zonificación solo puede contener números.',

        'institucion_procedencia_id.exists' =>
        'La institución seleccionada no es válida.',

        'expresion_literaria_id.exists' =>
        'La expresión literaria seleccionada no es válida.',

        'anio_egreso.required' => 'Debe indicar el año de egreso.',
        'anio_egreso.date' => 'El año de egreso debe ser 7 años antes del actual.',

        'representanteLegalId.required' =>
        'Debe seleccionar un representante legal obligatoriamente.',

        'representanteLegalId.exists' =>
        'El representante legal seleccionado no es válido.',

        'acepta_normas_contrato.accepted' =>
        'Debe aceptar las normas del contrato.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount($inscripcionId)
    {
        $this->inscripcionId = $inscripcionId;

        // Cargar documentos disponibles
        $this->documentosDisponibles = $this->documentoService->obtenerDocumentosDisponibles();
        $this->documentosEtiquetas = $this->documentoService->obtenerEtiquetas();

        $this->cargarDatosIniciales();
        $this->cargarInscripcion();
    }

    private function cargarDatosIniciales()
    {
        $this->grados = Grado::where('status', true)
            ->orderBy('numero_grado', 'asc')
            ->get();

        $this->instituciones = InstitucionProcedencia::where('status', true)->get();
        $this->expresiones_literarias = ExpresionLiteraria::where('status', true)->get();

        $this->padres = $this->representanteRepository->obtenerPorGenero('Masculino');
        $this->madres = $this->representanteRepository->obtenerPorGenero('Femenino');
        $this->representantes = $this->representanteRepository->obtenerRepresentantesLegales();
    }

    private function cargarInscripcion()
    {
        $inscripcion = Inscripcion::with([
            'alumno.persona',
            'grado',
            'seccion',
            'padre.persona',
            'madre.persona',
            'representanteLegal.representante.persona',
            'nuevoIngreso'
        ])->findOrFail($this->inscripcionId);

        // Datos básicos
        $this->alumnoId = $inscripcion->alumno_id;
        $this->gradoId = $inscripcion->grado_id;
        $this->seccionId = $inscripcion->seccion_id;
        $this->padreId = $inscripcion->padre_id;
        $this->madreId = $inscripcion->madre_id;
        $this->representanteLegalId = $inscripcion->representante_legal_id;
        $this->documentos = $inscripcion->documentos ?? [];
        $this->observaciones = $inscripcion->observaciones;
        $this->acepta_normas_contrato = $inscripcion->acepta_normas_contrato;

        // Datos de nuevo ingreso
        if ($inscripcion->nuevoIngreso) {
            $this->numero_zonificacion = $inscripcion->nuevoIngreso->numero_zonificacion;
            $this->institucion_procedencia_id = $inscripcion->nuevoIngreso->institucion_procedencia_id;
            $this->expresion_literaria_id = $inscripcion->nuevoIngreso->expresion_literaria_id;
            $this->anio_egreso = $inscripcion->nuevoIngreso->anio_egreso;
        }
 
        // Cargar datos seleccionados
        $this->alumnoSeleccionado = $inscripcion->alumno;
        $this->padreSeleccionado = $inscripcion->padre;
        $this->madreSeleccionado = $inscripcion->madre;
        $this->representanteLegalSeleccionado = $inscripcion->representanteLegal;

        // Verificar si es primer grado
        $grado = Grado::find($this->gradoId);
        $this->esPrimerGrado = ((int) $grado->numero_grado === 1);

        // Cargar secciones del grado
        $this->cargarSecciones($this->gradoId);

        // Evaluar estado de documentos
        $this->evaluarDocumentosVisual();
        $this->actualizarObservacionesPorDocumentos();
    }

    private function evaluarDocumentosVisual(): void
    {
        $evaluacion = $this->documentoService->evaluarEstadoDocumentos(
            $this->documentos,
            !$this->padreId && !$this->madreId,
            $this->esPrimerGrado
        );

        $this->documentosFaltantes = $evaluacion['faltantes'];
        $this->estadoDocumentos = $evaluacion['estado_documentos'];
        $this->statusInscripcion = $evaluacion['status_inscripcion'];

        $this->seleccionarTodos =
            count($this->documentos) === count($this->documentosDisponibles);
    }


    public function updatedGradoId($value)
    {
        if (!$value) {
            $this->secciones = [];
            $this->seccionId = null;
            return;
        }

        $grado = Grado::find($value);
        $this->esPrimerGrado = ((int) $grado->numero_grado === 1);

        if (!$this->esPrimerGrado) {
            $this->cargarSecciones($value);
        } else {
            $this->secciones = [];
            $this->seccionId = null;
        }
    }

    private function cargarSecciones($gradoId)
    {
        $this->secciones = Seccion::where('grado_id', $gradoId)
            ->where('status', true)
            ->orderBy('nombre')
            ->get();
    }

    public function updatedPadreId($value)
    {
        $this->padreSeleccionado = $value
            ? $this->representanteRepository->obtenerConRelaciones($value)
            : null;
    }

    public function updatedMadreId($value)
    {
        $this->madreSeleccionado = $value
            ? $this->representanteRepository->obtenerConRelaciones($value)
            : null;
    }

    public function updatedRepresentanteLegalId($value)
    {
        $this->representanteLegalSeleccionado = $value
            ? $this->representanteRepository->obtenerRepresentanteLegalConRelaciones($value)
            : null;

        // Re-evaluar documentos cuando cambian los representantes
        $this->evaluarDocumentosVisual();
    }

    public function updatedSeleccionarTodos($value)
    {
        $this->documentos = $value ? $this->documentosDisponibles : [];
        $this->evaluarDocumentosVisual();
    }

    public function updatedDocumentos()
    {
        $this->sincronizarDocumentos();
        $this->evaluarDocumentosVisual();
        $this->actualizarObservacionesPorDocumentos();
    }

    private function actualizarObservacionesPorDocumentos(): void
    {
        $this->observaciones = $this->documentoService->generarObservaciones(
            $this->documentos,
            !$this->padreId && !$this->madreId,
            $this->esPrimerGrado
        );
    }


    private function sincronizarDocumentos(): void
    {
        $requiereAutorizacion = !$this->padreId && !$this->madreId;

        $evaluacion = $this->documentoService->evaluarEstadoDocumentos(
            $this->documentos,
            $requiereAutorizacion,
            $this->esPrimerGrado
        );

        // NO marcar automáticamente, solo recalcular faltantes
        $this->documentosFaltantes = $evaluacion['faltantes'];
    }



    private function validarRepresentantes(): bool
    {
        if (!$this->padreId && !$this->madreId && !$this->representanteLegalId) {
            session()->flash('error', 'Debe seleccionar al menos un representante.');
            return false;
        }
        return true;
    }

    private function validarNuevoIngreso(Inscripcion $inscripcion): bool
    {
        if (!$inscripcion->nuevoIngreso) {
            return true;
        }

        if (
            !$this->institucion_procedencia_id ||
            !$this->expresion_literaria_id ||
            !$this->anio_egreso
        ) {
            session()->flash(
                'error',
                'Debe completar todos los datos de nuevo ingreso.'
            );
            return false;
        }

        return true;
    }



    public function actualizar()
    {
        // Validación básica
        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('error', 'No se pudo guardar la inscripción. Revise los campos obligatorios.');
            throw $e;
        }

        if (!$this->gradoId) {
            session()->flash('error', 'Debe seleccionar un grado.');
            return;
        }

        if (!$this->esPrimerGrado && !$this->seccionId) {
            session()->flash('error', 'Debe seleccionar una sección.');
            return;
        }

        if (!$this->padreId && !$this->madreId && !$this->representanteLegalId) {
            session()->flash('error', 'Debe seleccionar al menos un representante.');
            return;
        }

        if (!$this->acepta_normas_contrato) {
            session()->flash('error', 'Debe aceptar las normas del contrato.');
            return;
        }

        if (!$this->validarRepresentantes()) {
            return;
        }



        try {
            DB::beginTransaction();

            // Re-evaluar documentos antes de guardar
            $requiereAutorizacion = !$this->padreId && !$this->madreId;

            $evaluacion = $this->documentoService->evaluarEstadoDocumentos(
                $this->documentos,
                $requiereAutorizacion,
                $this->esPrimerGrado
            );

            $inscripcion = Inscripcion::findOrFail($this->inscripcionId);
            if (!$evaluacion['puede_guardar']) {
                DB::rollBack();
                session()->flash(
                    'error',
                    'No se puede guardar la inscripción. Faltan documentos obligatorios.'
                );
                return;
            }
            if (!$this->validarNuevoIngreso($inscripcion)) {
                return;
            }
            // Actualizar inscripción
            $inscripcion->update([
                'grado_id' => $this->gradoId,
                'seccion_id' => $this->seccionId,
                'padre_id' => $this->padreId ?: null,
                'madre_id' => $this->madreId ?: null,
                'representante_legal_id' => $this->representanteLegalId ?: null,
                'documentos' => $this->documentos,
                'estado_documentos' => $evaluacion['estado_documentos'],
                'status' => $evaluacion['status_inscripcion'],
                'observaciones' => $this->observaciones,
                'acepta_normas_contrato' => $this->acepta_normas_contrato,
            ]);

            // Actualizar nuevo ingreso
            if ($inscripcion->nuevoIngreso) {
                $inscripcion->nuevoIngreso->update([
                    'numero_zonificacion' => $this->numero_zonificacion,
                    'institucion_procedencia_id' => $this->institucion_procedencia_id,
                    'expresion_literaria_id' => $this->expresion_literaria_id,
                    'anio_egreso' => $this->anio_egreso,
                ]);
            }

            DB::commit();

            session()->flash('success', 'Inscripción actualizada exitosamente. Estado de documentos: ' . $evaluacion['estado_documentos']);
            return redirect()->route('admin.transacciones.inscripcion.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    protected $listeners = [
        'actualizarAlumno' => 'manejarActualizacionAlumno'
    ];

    public function manejarActualizacionAlumno()
    {
        // Recargar datos del alumno después de actualizar
        $inscripcion = Inscripcion::with('alumno.persona')->find($this->inscripcionId);
        $this->alumnoSeleccionado = $inscripcion->alumno;

        session()->flash('success', 'Datos del alumno actualizados correctamente.');
    }

    public function render()
    {
        return view('livewire.admin.transaccion-inscripcion.inscripcion-edit');
    }
}
