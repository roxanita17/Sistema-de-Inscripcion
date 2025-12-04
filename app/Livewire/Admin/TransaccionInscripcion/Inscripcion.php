<?php

namespace App\Livewire\Admin\TransaccionInscripcion;

use Livewire\Component;
use App\Models\Alumno;
use App\Models\Representante;
use App\Models\RepresentanteLegal;
use App\Models\Grado;
use App\Models\Inscripcion as ModeloInscripcion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Inscripcion extends Component
{
    
    // IDs seleccionados en los selects
    public $alumnoId;
    public $padreId;
    public $madreId;
    public $representanteLegalId;
    public $gradoId;

    // Datos completos de las selecciones
    public $alumnoSeleccionado = null;
    public $padreSeleccionado = null;
    public $madreSeleccionado = null;
    public $representanteLegalSeleccionado = null;

    // Listas para los selects
    public $alumnos = [];
    public $padres = [];
    public $madres = [];
    public $representantes = []; // Representantes legales
    public $grados = 1;

    public $documentos = [];

    // Campos del formulario
    public $fecha_inscripcion;
    public $observaciones;

    // Reglas y mensajes de validación
    protected $rules = [
        'alumnoId' => 'required|exists:alumnos,id',
        'gradoId' => 'nullable|integer|min:1',
        'fecha_inscripcion' => 'required|date',
        'documentos' => 'array',
        'documentos.*' => 'string',
    ];

    protected $messages = [
        'alumnoId.required' => 'Debe seleccionar un alumno',
        'gradoId.required' => 'Debe seleccionar un grado',
        'fecha_inscripcion.required' => 'La fecha de inscripción es obligatoria',
    ];

    // Método mount: inicializa datos
    public function mount()
    {
        $this->cargarAlumnos();
        $this->cargarPadres();
        $this->cargarMadres();
        $this->cargarRepresentantesLegales();
/*         $this->cargarGrados();
 */        
        // Establece la fecha actual como fecha por defecto
        $this->fecha_inscripcion = now()->format('Y-m-d');
    }

    // Métodos de carga de listas

    /**
     * Cargar lista de alumnos disponibles
     */
    public function cargarAlumnos()
    {
        $this->alumnos = Alumno::with(['persona.tipoDocumento', 'persona.genero'])
            ->whereHas('persona', fn($q) => $q->where('status', true))
            ->get()
            ->map(function($alumno) {
                return [
                    'id' => $alumno->id,
                    'nombre_completo' => $alumno->persona->primer_nombre . ' ' .
                                        ($alumno->persona->segundo_nombre ? $alumno->persona->segundo_nombre . ' ' : '') .
                                        $alumno->persona->primer_apellido . ' ' .
                                        ($alumno->persona->segundo_apellido ?? ''),
                    'numero_documento' => $alumno->persona->numero_documento,
                    'tipo_documento' => $alumno->persona->tipoDocumento->nombre ?? 'N/A'
                ];
            });
    }

    /**
     * Cargar lista de padres disponibles (solo masculino)
     */
    public function cargarPadres()
    {
        $this->padres = $this->obtenerRepresentantesPorGenero('Masculino');
    }

    /**
     * Cargar lista de madres disponibles (solo femenino)
     */
    public function cargarMadres()
    {
        $this->madres = $this->obtenerRepresentantesPorGenero('Femenino');
    }

    /**
     * Obtener representantes filtrando por género
     */
    private function obtenerRepresentantesPorGenero($genero)
    {
        return Representante::with(['persona.tipoDocumento', 'persona.genero'])
            ->whereHas('persona', function($q) use ($genero) {
                $q->where('status', true)
                  ->whereHas('genero', fn($q2) => $q2->where('genero', $genero));
            })
            ->get()
            ->map(function($rep) {
                return [
                    'id' => $rep->id,
                    'nombre_completo' => $rep->persona->primer_nombre . ' ' .
                                        ($rep->persona->segundo_nombre ? $rep->persona->segundo_nombre . ' ' : '') .
                                        $rep->persona->primer_apellido . ' ' .
                                        ($rep->persona->segundo_apellido ?? ''),
                    'numero_documento' => $rep->persona->numero_documento,
                    'tipo_documento' => $rep->persona->tipoDocumento->nombre ?? 'N/A',
                ];
            })->toArray();
    }

    /**
     * Cargar lista de representantes legales
     */
    public function cargarRepresentantesLegales()
    {
        $this->representantes = Representante::with(['persona.tipoDocumento', 'persona.genero'])
            ->whereHas('persona', fn($q) => $q->where('status', true))
            ->get()
            ->map(function($rep) {
                return [
                    'id' => $rep->id,
                    'nombre_completo' => $rep->persona->primer_nombre . ' ' .
                                        ($rep->persona->segundo_nombre ? $rep->persona->segundo_nombre . ' ' : '') .
                                        $rep->persona->primer_apellido . ' ' .
                                        ($rep->persona->segundo_apellido ?? ''),
                    'numero_documento' => $rep->persona->numero_documento,
                    'tipo_documento' => $rep->persona->tipoDocumento->nombre ?? 'N/A',
                ];
            })->toArray();
    }

    /**
     * Cargar lista de grados
     */
   /*  public function cargarGrados()
    {
        $this->grados = Grado::where('status', true)
            ->orderBy('numero_grado', 'asc')
            ->get();
    } */

    // Métodos de actualización de selects

    /**
     * Cuando se selecciona un alumno
     */
    public function updatedAlumnoId($value)
    {
        if ($value) {
            $this->alumnoSeleccionado = Alumno::with([
                'persona.tipoDocumento',
                'persona.genero',
                'persona.localidad.municipio.estado',
                'ordenNacimiento',
                'lateralidad',
            ])->find($value);

            // Verificar si ya tiene inscripción activa
            $inscripcionExistente = ModeloInscripcion::where('alumno_id', $value)
                ->where('status', true)
                ->first();

            if ($inscripcionExistente) {
                session()->flash('warning', 'Este alumno ya tiene una inscripción activa en ' . 
                                          $inscripcionExistente->grado->numero_grado . '° grado');
            }
        } else {
            $this->alumnoSeleccionado = null;
        }
    }

    /**
     * Cuando se selecciona un padre
     */
    public function updatedPadreId($value)
    {
        if ($value) {
            $this->padreSeleccionado = Representante::with([
                'persona.tipoDocumento',
                'persona.genero',
                'ocupacion',
            ])->find($value);
        } else {
            $this->padreSeleccionado = null;
        }
    }

    /**
     * Cuando se selecciona una madre
     */
    public function updatedMadreId($value)
    {
        if ($value) {
            $this->madreSeleccionado = Representante::with([
                'persona.tipoDocumento',
                'persona.genero',
                'ocupacion',
            ])->find($value);
        } else {
            $this->madreSeleccionado = null;
        } 
    }

    /**
     * Cuando se selecciona un representante legal
     */
    public function updatedRepresentanteLegalId($value)
    {
        if ($value) {
            $this->representanteLegalSeleccionado = RepresentanteLegal::with([
                'representante.persona.tipoDocumento',
                'representante.persona.genero',
                'representante.ocupacion',
            ])->find($value);
        } else {
            $this->representanteLegalSeleccionado = null;
        }
    }

    // Métodos de acción

    /**
     * Registrar la inscripción
     */
    public function registrar()
    {
        // Validación: al menos un representante
        if (!$this->padreId && !$this->madreId && !$this->representanteLegalId) {
            session()->flash('error', 'Debe seleccionar al menos un representante (padre, madre o representante legal)');
            return;
        }

        $this->validate();

        DB::beginTransaction();

        try {
            // Lista de todos los documentos requeridos
            $documentosRequeridos = [
                'partida_nacimiento',
                'copia_cedula_representante',
                'copia_cedula_estudiante',
                'boletin_6to_grado',
                'certificado_calificaciones',
                'constancia_aprobacion_primaria',
                'foto_estudiante',
                'foto_representante',
                'carnet_vacunacion',
                'autorizacion_tercero'
            ];

            // Verificar si faltan documentos
            $documentosFaltantes = array_diff($documentosRequeridos, $this->documentos ?? []);
            $todosLosDocumentos = empty($documentosFaltantes);
            
            // Determinar el estado de la inscripción
            $estadoInscripcion = $todosLosDocumentos ? 'Activo' : 'Pendiente';

            // Guardar inscripción
            $inscripcion = ModeloInscripcion::create([
                'alumno_id' => $this->alumnoId,
                'grado_id' => 1,
                'padre_id' => $this->padreId ?: null,
                'madre_id' => $this->madreId ?: null,
                'representante_legal_id' => $this->representanteLegalId ?: null,
                'documentos' => $this->documentos ?? [],
                'estado_documentos' => $todosLosDocumentos ? 'Completos' : 'Incompletos',
                'fecha_inscripcion' => $this->fecha_inscripcion,
                'observaciones' => $this->observaciones,
                'status' => $estadoInscripcion,
            ]);
            DB::commit();

            session()->flash('success', 'Inscripción registrada exitosamente');

            $this->limpiar();

            return redirect()->route('admin.transacciones.inscripcion.index');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al registrar la inscripción: ' . $e->getMessage());
        }
    }


    /**
     * Limpiar formulario y selecciones
     */
    public function limpiar()
    {
        $this->reset([
            'alumnoId',
            'padreId',
            'madreId',
            'representanteLegalId',
            'grados',
            'observaciones',
            'alumnoSeleccionado',
            'padreSeleccionado',
            'madreSeleccionado',
            'representanteLegalSeleccionado'
        ]);

        $this->fecha_inscripcion = now()->format('Y-m-d');
        $this->dispatch('resetSelects');
    }


    // Render
    public function render()
    {
        return view('livewire.admin.transaccion-inscripcion.inscripcion');
    }
}
