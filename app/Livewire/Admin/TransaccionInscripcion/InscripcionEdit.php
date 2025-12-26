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
use Illuminate\Support\Facades\DB;

class InscripcionEdit extends Component
{
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
        RepresentanteRepository $representanteRepository,
        DocumentoService $documentoService
    ) {
        $this->representanteRepository = $representanteRepository;
        $this->documentoService = $documentoService;
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
        $this->evaluarDocumentos();
    }

    private function evaluarDocumentos()
    {
        $requiereAutorizacion = !$this->padreId && !$this->madreId;
        
        $evaluacion = $this->documentoService->evaluarEstadoDocumentos(
            $this->documentos,
            $requiereAutorizacion,
            $this->esPrimerGrado
        );

        $this->documentosFaltantes = $evaluacion['faltantes'];
        $this->estadoDocumentos = $evaluacion['estado_documentos'];
        $this->statusInscripcion = $evaluacion['status_inscripcion'];
        
        // Actualizar seleccionarTodos
        $this->seleccionarTodos = count($this->documentos) === count($this->documentosDisponibles);
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
        $this->evaluarDocumentos();
    }

    public function updatedSeleccionarTodos($value)
    {
        $this->documentos = $value ? $this->documentosDisponibles : [];
        $this->evaluarDocumentos();
    }

    public function updatedDocumentos()
    {
        $this->evaluarDocumentos();
    }

    public function actualizar()
    {
        // Validación básica
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

            // Actualizar inscripción
            $inscripcion->update([
                'grado_id' => $this->gradoId,
                'seccion_id' => $this->seccionId,
                'padre_id' => $this->padreId,
                'madre_id' => $this->madreId,
                'representante_legal_id' => $this->representanteLegalId,
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