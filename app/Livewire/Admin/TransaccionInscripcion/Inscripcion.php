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

class Inscripcion extends Component
{
    /* ============================================================
       ===============   PROPIEDADES DEL PRINCIPALES  ===============
       ============================================================ */

    // IDs seleccionados en selects
    public $alumnoId;
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
    public $alumnos = [];
    public $padres = [];
    public $madres = [];
    public $representantes = [];
    public $grados = 1;

    // Documentos seleccionados
    public $documentos = [];

    // Campos propios del formulario
    public $fecha_inscripcion;
    public $observaciones;

    /* ============================================================
       =====================   VALIDACIÃ“N   ========================
       ============================================================ */

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
        'fecha_inscripcion.required' => 'La fecha de inscripciÃ³n es obligatoria',
    ];

    /* ============================================================
       =====================   MOUNT   ============================
       ============================================================ */

    public function mount()
    {
        // 1) SI HAY DATOS EN SESIÃ“N, cargarlos primero
        if (session()->has('inscripcion_temp')) {
            $data = session()->get('inscripcion_temp');

            $this->alumnoId = $data['alumnoId'] ?? null;
            $this->padreId = $data['padreId'] ?? null;
            $this->madreId = $data['madreId'] ?? null;
            $this->representanteLegalId = $data['representanteLegalId'] ?? null;
            $this->gradoId = $data['gradoId'] ?? 1;
            $this->fecha_inscripcion = $data['fecha_inscripcion'] ?? now()->format('Y-m-d');
            $this->observaciones = $data['observaciones'] ?? null;
            $this->documentos = $data['documentos'] ?? [];
        } else {
            $this->fecha_inscripcion = now()->format('Y-m-d');
        }

        // 2) AHORA cargar las listas
        $this->cargarAlumnos();
        $this->cargarPadres();
        $this->cargarMadres();
        $this->cargarRepresentantesLegales();

        // 3) Cargar automÃ¡ticamente los detalles segÃºn los ID restaurados
        if ($this->alumnoId) {
            $this->updatedAlumnoId($this->alumnoId);
        }
        if ($this->padreId) {
            $this->updatedPadreId($this->padreId);
        }
        if ($this->madreId) {
            $this->updatedMadreId($this->madreId);
        }
        if ($this->representanteLegalId) {
            $this->updatedRepresentanteLegalId($this->representanteLegalId);
        }
    }

    /* ============================================================
       =======  MÃ‰TODOS DE CARGA DE LISTAS (SELECTS) ==============
       ============================================================ */

    /**
     * Cargar lista de alumnos
     */
    public function cargarAlumnos()
    {
        $this->alumnos = Alumno::with(['persona.tipoDocumento', 'persona.genero'])
            ->whereHas('persona', fn($q) => $q->where('status', true))
            ->get()
            ->map(fn($alumno) => [
                'id' => $alumno->id,
                'nombre_completo' =>
                $alumno->persona->primer_nombre . ' ' .
                    ($alumno->persona->segundo_nombre ? $alumno->persona->segundo_nombre . ' ' : '') .
                    $alumno->persona->primer_apellido . ' ' .
                    ($alumno->persona->segundo_apellido ?? ''),
                'numero_documento' => $alumno->persona->numero_documento,
                'tipo_documento' => $alumno->persona->tipoDocumento->nombre ?? 'N/A'
            ]);
    }

    /**
     * Cargar padres (masculino)
     */
    public function cargarPadres()
    {
        $this->padres = $this->obtenerRepresentantesPorGenero('Masculino');
    }

    /**
     * Cargar madres (femenino)
     */
    public function cargarMadres()
    {
        $this->madres = $this->obtenerRepresentantesPorGenero('Femenino');
    }

    /**
     * Obtener representantes por gÃ©nero
     */
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

    /**
     * Cargar representantes legales
     */
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
       =========  MÃ‰TODOS updated() PARA CARGAR DETALLES ==========
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

        // Verificar inscripciÃ³n activa
        $inscripcionExistente = ModeloInscripcion::where('alumno_id', $value)
            ->where('status', true)
            ->first();

        if ($inscripcionExistente) {
            session()->flash('warning', 'Este alumno ya tiene una inscripciÃ³n activa.');
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

    protected $listeners = ['recibirDatosAlumno' => 'guardarTodo'];

    /* ============================================================
       =========  MÃ‰TODO registrar() â€“ guardar inscripciÃ³n SOLO
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
            // Documentos requeridos
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
                'grado_id' => 1,
                'padre_id' => $this->padreId ?: null,
                'madre_id' => $this->madreId ?: null,
                'representante_legal_id' => $this->representanteLegalId,
                'documentos' => $this->documentos ?? [],
                'estado_documentos' => empty($faltantes) ? 'Completos' : 'Incompletos',
                'fecha_inscripcion' => $this->fecha_inscripcion,
                'observaciones' => $this->observaciones,
                'status' => $estadoInscripcion,
            ]);

            DB::commit();

            session()->flash('success', 'InscripciÃ³n registrada exitosamente.');
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
       FUNCION guardarTodo() (Guardar Alumno y InscripciÃ³n en 1 acciÃ³n)
       ============================================================ */

    public function guardarTodo($datos = [])
    {
        if (empty($datos)) {
            return session()->flash('error', 'No se recibieron datos del alumno.');
        }

        DB::beginTransaction();

        try {
            // Crear persona
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

            // Crear alumno
            $alumno = Alumno::create([
                'persona_id' => $persona->id,
                'numero_zonificacion' => $datos['numero_zonificacion'] ?? null,
                'institucion_procedencia_id' => $datos['institucion_procedencia_id'],
                'anio_egreso' => $datos['anio_egreso'],
                'expresion_literaria_id' => $datos['expresion_literaria_id'],
                'talla_camisa' => $datos['talla_camisa'],
                'talla_pantalon' => $datos['talla_pantalon'],
                'talla_zapato' => $datos['talla_zapato'],
                'peso' => $datos['peso_estudiante'],
                'estatura' => $datos['talla_estudiante'],
                'lateralidad_id' => $datos['lateralidad_id'],
                'orden_nacimiento_id' => $datos['orden_nacimiento_id'],
                'status' => 'Activo',
            ]);

            // Crear inscripciÃ³n
            ModeloInscripcion::create([
                'alumno_id' => $alumno->id,
                'grado_id' => $this->grados,
                'padre_id' => $this->padreId ?: null,
                'madre_id' => $this->madreId ?: null,
                'representante_legal_id' => $this->representanteLegalId ?: null,
                'documentos' => $this->documentos ?? [],
                'estado_documentos' => empty(array_diff([
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
                ], $this->documentos ?? [])) ? 'Completos' : 'Incompletos',
                'fecha_inscripcion' => $this->fecha_inscripcion,
                'observaciones' => $this->observaciones,
                'status' => 'Activo',
            ]);

            DB::commit();

            session()->flash('success', 'Inscripcion guardada exitosamente.');
            return redirect()->route('admin.transacciones.inscripcion.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al registrar: ' . $e->getMessage());
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