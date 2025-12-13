<?php

namespace App\Livewire\Admin\TransaccionInscripcion;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Modelos
use App\Models\Alumno;
use App\Models\Representante;
use App\Models\RepresentanteLegal;
use App\Models\Grado;
use App\Models\Inscripcion as ModeloInscripcion;
use App\Models\ExpresionLiteraria;
use App\Models\InstitucionProcedencia;

class Inscripcion extends Component
{
    /* ============================================================
       ===============   PROPIEDADES DEL PRINCIPALES  ===============
       ============================================================ */

    // IDs seleccionados en selects
    public $inscripcion_id;
    public $padreId;
    public $madreId;
    public $representanteLegalId;
    public $gradoId;

    // Datos completos de los seleccionados
    public $alumnoSeleccionado = null;
    public $padreSeleccionado = null;
    public $madreSeleccionado = null;
    public $representanteLegalSeleccionado = null;

    // Listas para selects
    public $padres = [];
    public $madres = [];
    public $representantes = [];
    public $instituciones = [];
    public $grados = [];
    public $expresiones_literarias = [];

    // Documentos seleccionados
    public $documentos = [];

    // Campos propios del formulario
    public $fecha_inscripcion;
    public $observaciones;
    public $numero_zonificacion;
    public $institucion_procedencia_id;
    public $expresion_literaria_id;
    public $anio_egreso;
    public $acepta_normas_contrato = false;

    /* ============================================================
       =====================   VALIDACION   ========================
       ============================================================ */

    public function rules()
    {
        return [
            'inscripcion_id' => 'required|exists:inscripcions,id',
            'numero_zonificacion' => 'required|numeric',
            'institucion_procedencia_id' => 'required|exists:institucion_procedencias,id',
            'expresion_literaria_id' => 'required|exists:expresion_literarias,id',
            'gradoId' => [
                'required',
                'exists:grados,id',
                function ($attribute, $value, $fail) {
                    if (!$this->verificarCuposDisponibles($value)) {
                        $fail('El grado seleccionado ha alcanzado el límite de cupos disponibles.');
                    }
                }
            ],
            'fecha_inscripcion' => 'required|date',
            'documentos' => 'array',
            'documentos.*' => 'string',
            'acepta_normas_contrato' => 'accepted',
            'anio_egreso' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $anio = Carbon::parse($value)->year;
                    $actual = Carbon::now()->year;

                    if ($anio > $actual) {
                        $fail('El año de egreso no puede ser futuro.');
                    } elseif ($anio < $actual - 7) {
                        $fail('El año de egreso no puede ser menor al año actual menos 7 años.');
                    }
                }
            ],
        ];
    }

    protected $messages = [
        'inscripcion_id.required' => 'Debe seleccionar una inscripción',
        'gradoId.required' => 'Debe seleccionar un grado',
        'fecha_inscripcion.required' => 'La fecha de inscripción es obligatoria',
        'acepta_normas_contrato.accepted' => 'Debe aceptar las normas del contrato para continuar.',
        'numero_zonificacion' => 'Este campo no debe estar vacio',
        'expresion_literaria_id' => 'Debe seleccionar una expresión literaria',
        'anio_egreso' => 'Debe seleccionar un año de egreso',
        'institucion_procedencia_id' => 'Debe seleccionar una institucion de procedencia'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /* ============================================================
       ===============   VERIFICACIÓN DE CUPOS   ==================
       ============================================================ */

    /**
     * Verifica si hay cupos disponibles en el grado
     */
    private function verificarCuposDisponibles($gradoId)
    {
        $grado = Grado::find($gradoId);
        
        if (!$grado) {
            return false;
        }

        // Contar inscripciones activas para este grado
        $inscripcionesActivas = ModeloInscripcion::where('grado_id', $gradoId)
            ->where('status', 'Activo')
            ->count();

        // Verificar si se excede el límite (asumiendo que el campo es 'cupos' o 'limite_cupos')
        return $inscripcionesActivas < $grado->capacidad_max;
    }

    /**
     * Obtener información de cupos de un grado
     */
    public function obtenerInfoCupos($gradoId)
    {
        if (!$gradoId) {
            return null;
        }

        $grado = Grado::find($gradoId);
        
        if (!$grado) {
            return null;
        }

        $inscritos = ModeloInscripcion::where('grado_id', $gradoId)
            ->where('status', 'Activo')
            ->count();

        return [
            'total_cupos' => $grado->capacidad_max,
            'cupos_ocupados' => $inscritos,
            'cupos_disponibles' => $grado->capacidad_max - $inscritos,
            'porcentaje_ocupacion' => $grado->capacidad_max > 0 ? round(($inscritos / $grado->capacidad_max) * 100, 2) : 0
        ];
    }

    /* ============================================================
       =====================   MOUNT   ============================
       ============================================================ */

    public function mount()
    {
        $this->cargarRepresentantesLegales();
        $this->cargarDatosIniciales();
        $this->fecha_inscripcion = now()->format('Y-m-d');
    }

    /* ============================================================
       ===================   CARGAS INICIALES   ===================
       ============================================================ */

    public function cargarDatosIniciales()
    {
        $this->instituciones = InstitucionProcedencia::where('status', true)->get();
        $this->expresiones_literarias = ExpresionLiteraria::where('status', true)->orderBy('letra_expresion_literaria')->get();
        $this->grados = Grado::where('status', true)->get();
        $this->padres = $this->obtenerRepresentantesPorGenero('Masculino');
        $this->madres = $this->obtenerRepresentantesPorGenero('Femenino');
    }

    public function actualizarPadreSelect($data = null)
    {
        $id = $data['value'] ?? null;
        $this->padreId = $id;
        $this->padreSeleccionado = $id
            ? Representante::with(['persona.tipoDocumento', 'persona.genero', 'ocupacion'])->find($id)
            : null;
    }

    public function actualizarMadreSelect($data = null)
    {
        $id = $data['value'] ?? null;
        $this->madreId = $id;
        $this->madreSeleccionado = $id
            ? Representante::with(['persona.tipoDocumento', 'persona.genero', 'ocupacion'])->find($id)
            : null;
    }

    public function actualizarRepresentanteLegalSelect($data = null)
    {
        $id = $data['value'] ?? null;
        $this->representanteLegalId = $id;
        $this->representanteLegalSeleccionado = $id
            ? RepresentanteLegal::with(['representante.persona.tipoDocumento', 'representante.persona.genero', 'representante.ocupacion'])->find($id)
            : null;
    }

    private function obtenerRepresentantesPorGenero($genero)
    {
        return Representante::with(['persona.tipoDocumento', 'persona.genero'])
            ->whereHas(
                'persona',
                fn($q) =>
                $q->where('status', true)
                    ->whereHas('genero', fn($g) => $g->where('genero', $genero))
            )
            ->get()
            ->map(fn($rep) => [
                'id' => $rep->id,
                'nombre_completo' =>
                $rep->persona->primer_nombre . ' ' .
                    ($rep->persona->segundo_nombre ? $rep->persona->segundo_nombre . ' ' : '') .
                    $rep->persona->primer_apellido . ' ' .
                    ($rep->persona->segundo_apellido ?? ''),
                'numero_documento' => $rep->persona->numero_documento,
                'tipo_documento' => $rep->persona->tipoDocumento->nombre ?? 'N/A',
            ])
            ->toArray();
    }

    public function cargarRepresentantesLegales()
    {
        $this->representantes = RepresentanteLegal::with(['representante.persona.tipoDocumento', 'representante.persona.genero'])
            ->whereHas('representante.persona', fn($q) => $q->where('status', true))
            ->get()
            ->map(function ($repLegal) {
                $rep = $repLegal->representante;
                return [
                    'id' => $repLegal->id,
                    'nombre_completo' =>
                    $rep->persona->primer_nombre . ' ' .
                        ($rep->persona->segundo_nombre ? $rep->persona->segundo_nombre . ' ' : '') .
                        $rep->persona->primer_apellido . ' ' .
                        ($rep->persona->segundo_apellido ?? ''),
                    'numero_documento' => $rep->persona->numero_documento,
                    'tipo_documento' => $rep->persona->tipoDocumento->nombre ?? 'N/A',
                ];
            })
            ->toArray();
    }

    /* ============================================================
       =========  METODOS updated() PARA CARGAR DETALLES ==========
       ============================================================ */

    public function updatedAlumnoId($value)
    {
        if (!$value) {
            $this->alumnoSeleccionado = null;
            return;
        }

        $this->alumnoSeleccionado = Alumno::with([
            'persona.tipoDocumento',
            'persona.genero',
            'persona.localidad.municipio.estado',
            'ordenNacimiento',
            'lateralidad',
        ])->find($value);

        $inscripcionExistente = ModeloInscripcion::where('alumno_id', $value)
            ->where('status', true)
            ->first();

        if ($inscripcionExistente) {
            session()->flash('warning', 'Este alumno ya tiene una inscripción activa.');
        }
    }

    public function updatedPadreId($value)
    {
        $this->padreSeleccionado = $value
            ? Representante::with(['persona.tipoDocumento', 'persona.genero', 'ocupacion'])->find($value)
            : null;
    }

    public function updatedMadreId($value)
    {
        $this->madreSeleccionado = $value
            ? Representante::with(['persona.tipoDocumento', 'persona.genero', 'ocupacion'])->find($value)
            : null;
    }

    public function updatedRepresentanteLegalId($value)
    {
        $this->representanteLegalSeleccionado = $value
            ? RepresentanteLegal::with(['representante.persona.tipoDocumento', 'representante.persona.genero', 'representante.ocupacion'])->find($value)
            : null;
    }

    /* ============================================================
       =========  LISTENER (para recibir datos del formulario Alumno)
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
       =========  METODO registrar() guardar inscripción SOLO
       ============================================================ */

    public function registrar()
    {
        // Validar que haya al menos un representante
        if (!$this->padreId && !$this->madreId && !$this->representanteLegalId) {
            return session()->flash('error', 'Debe seleccionar al menos un representante.');
        }

        $this->validate();

        DB::beginTransaction();

        try {
            // Verificar cupos nuevamente antes de insertar
            if (!$this->verificarCuposDisponibles($this->gradoId)) {
                DB::rollBack();
                return session()->flash('error', 'El grado seleccionado ha alcanzado el límite de cupos disponibles.');
            }

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

            $faltantes = array_diff($documentosRequeridos, $this->documentos ?? []);
            $estadoInscripcion = empty($faltantes) ? 'Activo' : 'Pendiente';

            ModeloInscripcion::create([
                'alumno_id' => $this->alumnoId,
                'numero_zonificacion' => $this->numero_zonificacion,
                'institucion_procedencia_id' => $this->institucion_procedencia_id,
                'anio_egreso' => $this->anio_egreso,
                'expresion_literaria_id' => $this->expresion_literaria_id,
                'grado_id' => $this->gradoId,
                'padre_id' => $this->padreId ?: null,
                'madre_id' => $this->madreId ?: null,
                'representante_legal_id' => $this->representanteLegalId,
                'documentos' => $this->documentos ?? [],
                'estado_documentos' => empty($faltantes) ? 'Completos' : 'Incompletos',
                'fecha_inscripcion' => $this->fecha_inscripcion,
                'observaciones' => $this->observaciones,
                'acepta_normas_contrato' => $this->acepta_normas_contrato,
                'status' => $estadoInscripcion,
            ]);

            DB::commit();

            session()->flash('success', 'Inscripcion registrada exitosamente.');
            $this->limpiar();
            session()->forget('inscripcion_temp');

            return redirect()->route('admin.transacciones.inscripcion.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    /* ============================================================
       FUNCION finalizar() (pide datos del alumno al otro Livewire)
       ============================================================ */

    public function finalizar()
    {
        if (!$this->acepta_normas_contrato) {
            $this->addError(
                'acepta_normas_contrato',
                'Debe aceptar las normas para continuar.'
            );
            return;
        }
        if (!$this->padreId && !$this->madreId && !$this->representanteLegalId) {
            return session()->flash('error', 'Debe seleccionar al menos un representante.');
        }

        $this->dispatch('solicitarDatosAlumno');
    }

    public function irACrearRepresentante()
    {
        session()->put('inscripcion_temp', [
            'alumnoId' => $this->alumnoId,
            'padreId' => $this->padreId,
            'madreId' => $this->madreId,
            'representanteLegalId' => $this->representanteLegalId,
            'gradoId' => $this->gradoId,
            'fecha_inscripcion' => $this->fecha_inscripcion,
            'observaciones' => $this->observaciones,
            'documentos' => $this->documentos,
        ]);

        return redirect()->route('representante.formulario', ['from' => 'inscripcion']);
    }

    /* ============================================================
       FUNCION guardarTodo() (Guardar Alumno y Inscripción en 1 acción)
       ============================================================ */

    public function guardarTodo($datos = [])
    {
        if (empty($datos)) {
            return session()->flash('error', 'No se recibieron datos del alumno.');
        }

        // Verificar cupos antes de continuar
        if (!$this->verificarCuposDisponibles($this->gradoId)) {
            return session()->flash('error', 'El grado seleccionado ha alcanzado el límite de cupos disponibles.');
        }

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

        $faltantes = array_diff($documentosRequeridos, $this->documentos ?? []);
        $estadoInscripcion = empty($faltantes) ? 'Activo' : 'Pendiente';
        $estadoDocumentos  = empty($faltantes) ? 'Completos' : 'Incompletos';

        DB::beginTransaction();

        try {
            $persona = \App\Models\Persona::create([
                'primer_nombre' => $datos['primer_nombre'],
                'segundo_nombre' => $datos['segundo_nombre'] ?? null,
                'tercer_nombre' => $datos['tercer_nombre'] ?? null,
                'primer_apellido' => $datos['primer_apellido'],
                'segundo_apellido' => $datos['segundo_apellido'] ?? null,
                'tipo_documento_id' => $datos['tipo_documento_id'],
                'numero_documento' => $datos['numero_documento'],
                'genero_id' => $datos['genero_id'],
                'fecha_nacimiento' => $datos['fecha_nacimiento'],
                'localidad_id' => $datos['localidad_id'],
                'status' => true,
            ]);

            $alumno = Alumno::create([
                'persona_id' => $persona->id,
                'talla_camisa' => $datos['talla_camisa'],
                'talla_pantalon' => $datos['talla_pantalon'],
                'talla_zapato' => $datos['talla_zapato'],
                'peso' => $datos['peso_estudiante'],
                'estatura' => $datos['talla_estudiante'],
                'lateralidad_id' => $datos['lateralidad_id'],
                'orden_nacimiento_id' => $datos['orden_nacimiento_id'],
                'status' => 'Activo',
            ]);

            ModeloInscripcion::create([
                'alumno_id' => $alumno->id,
                'numero_zonificacion' => $this->numero_zonificacion,
                'institucion_procedencia_id' => $this->institucion_procedencia_id,
                'anio_egreso' => $this->anio_egreso,
                'expresion_literaria_id' => $this->expresion_literaria_id,
                'grado_id' => $this->gradoId,
                'padre_id' => $this->padreId ?: null,
                'madre_id' => $this->madreId ?: null,
                'representante_legal_id' => $this->representanteLegalId ?: null,
                'documentos' => $this->documentos ?? [],
                'estado_documentos' => $estadoDocumentos,
                'fecha_inscripcion' => $this->fecha_inscripcion,
                'observaciones' => $this->observaciones,
                'acepta_normas_contrato' => $this->acepta_normas_contrato,
                'status' => $estadoInscripcion,
            ]);

            DB::commit();

            session()->flash('success', 'Inscripcion guardada exitosamente.');
            return redirect()->route('admin.transacciones.inscripcion.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al registrar: ' . $e->getMessage());
        }
    }

    // En tu componente Livewire, puedes agregar:
    public function updatedGradoId($value)
    {
        if ($value) {
            $info = $this->obtenerInfoCupos($value);
            if ($info) {
                $this->dispatch('actualizarInfoCupos', $info);
            }
        }
    }

    /* ============================================================
       =================== FUNCION limpiar() ======================
       ============================================================ */

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

    /* ============================================================
       =================== FUNCION RENDER =========================
       ============================================================ */

    public function render()
    {
        return view('livewire.admin.transaccion-inscripcion.inscripcion');
    }
}