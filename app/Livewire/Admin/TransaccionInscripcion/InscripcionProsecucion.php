<?php

namespace App\Livewire\Admin\TransaccionInscripcion;

use Livewire\Component;
use App\Models\AnioEscolar;
use App\Models\Inscripcion;
use App\Models\Alumno;
use App\Models\Grado;
use App\Models\Seccion;
use App\Models\ProsecucionArea;
use App\Models\InscripcionProsecucion as ModeloInscripcionProsecucion;
use Illuminate\Support\Facades\DB;

class InscripcionProsecucion extends Component
{
    /* ============================================================
       PROPIEDADES
       ============================================================ */

    // Alumno
    public $alumnoId;
    public $alumnoSeleccionado;
    public $alumnos = [];

    // Grados y Secciones
    public $grados = [];
    public $secciones = [];
    public $gradoAnteriorId = null;   // Grado que cursó el alumno
    public $gradoPromocionId = null;  // Grado al que será promovido
    public $seccion_id = null;
    public $esPrimerGrado = false;
    public $gradosPermitidos = [];

    // Materias
    public $materias = [];
    public $materiasSeleccionadas = [];

    // Otros datos
    public $repite_grado = false;
    public $acepta_normas_contrato = false;
    public $observaciones;

    /* ============================================================
       LISTENERS
       ============================================================ */

    protected $listeners = [
        'seleccionarAlumno' => 'seleccionarAlumno',
    ];

    /* ============================================================
       VALIDACIÓN
       ============================================================ */

    protected function rules()
    {
        return [
            'alumnoId' => 'required|exists:alumnos,id',
            'gradoPromocionId' => [
                'required',
                'exists:grados,id',
                function ($attribute, $value, $fail) {
                    if (!$this->validarGradoPermitido($value)) {
                        $fail('El grado seleccionado no es válido para este estudiante.');
                    }
                }
            ],
            'seccion_id' => $this->esPrimerGrado
                ? 'nullable'
                : 'required|exists:seccions,id',
            'materiasSeleccionadas' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    $pendientesActuales = count($this->materiasPendientesActuales());

                    if ($pendientesActuales >= 4 && !$this->repite_grado) {
                        $fail('Con 4 o más materias pendientes del grado actual el estudiante debe repetir grado.');
                    }
                }

            ],
            'acepta_normas_contrato' => 'accepted',
            'repite_grado' => 'boolean',
            'observaciones' => 'nullable|string|max:500',
        ];
    }

    protected $messages = [
        'alumnoId.required' => 'Debe seleccionar un estudiante.',
        'alumnoId.exists' => 'El estudiante seleccionado no es válido.',
        'gradoPromocionId.required' => 'Debe seleccionar el grado de promoción.',
        'gradoPromocionId.exists' => 'El grado seleccionado no existe.',
        'seccion_id.required' => 'Debe seleccionar una sección.',
        'seccion_id.exists' => 'La sección seleccionada no es válida.',
        'acepta_normas_contrato.accepted' => 'Debe aceptar las normas de convivencia para continuar.',
        'observaciones.max' => 'Las observaciones no pueden exceder 500 caracteres.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /* ============================================================
       MOUNT - INICIALIZACIÓN
       ============================================================ */

    public function mount()
    {
        $this->cargarDatosIniciales();
        $this->cargarGrados();
    }

    /* ============================================================
       CARGAS INICIALES
       ============================================================ */

    /**
     * Carga los alumnos elegibles para prosecución
     * Solo alumnos que cursaron el año anterior y no están inscritos en el actual
     */
    public function cargarDatosIniciales()
    {
        $anioActual = AnioEscolar::where('status', 'Activo')->first();

        if (!$anioActual) {
            $this->alumnos = collect();
            session()->flash('warning', 'No hay un año escolar activo.');
            return;
        }

        $anioAnterior = AnioEscolar::where('inicio_anio_escolar', '<', $anioActual->inicio_anio_escolar)
            ->orderByDesc('inicio_anio_escolar')
            ->first();

        if (!$anioAnterior) {
            $this->alumnos = collect();
            session()->flash('warning', 'No se encontró el año escolar anterior.');
            return;
        }

        $this->alumnos = Alumno::where(function ($q) use ($anioAnterior) {

            // Inscripción normal en el año anterior
            $q->whereHas('inscripciones', function ($q) use ($anioAnterior) {
                $q->where('inscripcions.anio_escolar_id', $anioAnterior->id);
            })

                // Prosecución en el año anterior
                ->orWhereHas('inscripcionProsecucions', function ($q) use ($anioAnterior) {
                    $q->where('inscripcion_prosecucions.anio_escolar_id', $anioAnterior->id);
                });
        })

            // No debe tener inscripción normal en el año actual
            ->whereDoesntHave('inscripciones', function ($q) use ($anioActual) {
                $q->where('inscripcions.anio_escolar_id', $anioActual->id);
            })

            // No debe tener prosecución en el año actual
            ->whereDoesntHave('inscripcionProsecucions', function ($q) use ($anioActual) {
                $q->where('inscripcion_prosecucions.anio_escolar_id', $anioActual->id);
            })

            ->with([
                'persona.tipoDocumento',
                'inscripciones.grado',
                'inscripcionProsecucions.grado'
            ])
            ->orderBy('id', 'asc')
            ->get();
    }



    /**
     * Carga todos los grados disponibles
     */
    public function cargarGrados()
    {
        $this->grados = Grado::where('status', true)
            ->orderBy('numero_grado', 'asc')
            ->get();
    }

    /**
     * Carga los grados permitidos según si repite o promueve
     */

    private function cargarGradosPermitidos()
    {
        if (!$this->gradoAnteriorId) {
            $this->gradosPermitidos = collect();
            return;
        }

        $gradoAnterior = Grado::where('id', $this->gradoAnteriorId)
            ->where('status', true)
            ->first();

        if (!$gradoAnterior) {
            $this->gradosPermitidos = collect();
            return;
        }

        // Si repite: solo el mismo grado
        if ($this->repite_grado) {
            $this->gradosPermitidos = collect([$gradoAnterior]);
            return;
        }

        // Si promueve: grado actual + siguiente
        $this->gradosPermitidos = Grado::where('status', true)
            ->whereIn('numero_grado', [
                $gradoAnterior->numero_grado,
                $gradoAnterior->numero_grado + 1,
            ])
            ->orderBy('numero_grado')
            ->get();
    }


    /* ============================================================
       SELECCIÓN DE ALUMNO
       ============================================================ */

    /**
     * Maneja la selección de un alumno
     */
    public function seleccionarAlumno($alumnoId)
    {
        $this->alumnoId = $alumnoId;

        $this->alumnoSeleccionado = Alumno::with([
            'persona.tipoDocumento',
            'inscripciones.grado'
        ])->find($alumnoId);

        if (!$this->alumnoSeleccionado) {
            session()->flash('error', 'No se pudo cargar el alumno seleccionado.');
            return;
        }

        // Cargar el grado anterior del alumno
        $this->cargarGradoDesdeInscripcionAnterior();
    }

    /**
     * Obtiene el último grado cursado por el alumno
     */
    private function cargarGradoDesdeInscripcionAnterior()
    {
        if (!$this->alumnoSeleccionado) return;

        $anioActual = AnioEscolar::where('status', 'Activo')->first();

        if (!$anioActual) return;

        $inscripcionAnterior = $this->alumnoSeleccionado->inscripcionAnterior($anioActual->id);

        if ($inscripcionAnterior && $inscripcionAnterior->grado) {
            $this->gradoAnteriorId = $inscripcionAnterior->grado->id;

            // Cargar grados permitidos
            $this->cargarGradosPermitidos();

            // Cargar materias del grado anterior
            $this->cargarMateriasParaProsecucion($this->gradoAnteriorId);
        }
    }

    /* ============================================================
       MANEJO DE MATERIAS
       ============================================================ */

    /**
     * Carga las materias del grado anterior + materias pendientes históricas
     */
    private function cargarMateriasParaProsecucion($gradoId)
    {
        $this->materias = [];

        // 1. Materias del grado anterior
        $grado = Grado::with('gradoAreaFormacion.area_formacion')
            ->find($gradoId);

        if ($grado) {
            foreach ($grado->gradoAreaFormacion->where('status', true) as $item) {
                $this->materias[] = [
                    'id' => $item->id,
                    'nombre' => $item->area_formacion->nombre_area_formacion,
                    'codigo' => $item->codigo,
                    'origen' => 'grado_actual',
                    'grado' => $grado->numero_grado,
                ];
            }
        }

        // 2. Materias pendientes de años anteriores
        $pendientes = $this->alumnoSeleccionado->materiasPendientesHistoricas();

        foreach ($pendientes as $pendiente) {
            $this->materias[] = [
                'id' => $pendiente->grado_area_formacion_id,
                'nombre' => $pendiente->gradoAreaFormacion->area_formacion->nombre_area_formacion,
                'codigo' => $pendiente->gradoAreaFormacion->codigo,
                'origen' => 'pendiente_anterior',
                'grado' => $pendiente->gradoAreaFormacion->grado->numero_grado,
            ];
        }

        // Eliminar duplicados por ID
        $this->materias = collect($this->materias)
            ->unique('id')
            ->sortBy('nombre')
            ->values()
            ->toArray();
    }

    /**
     * Se ejecuta cuando cambian las materias seleccionadas
     */
    public function updatedMateriasSeleccionadas()
    {
        // Validar si tiene Materias reprobadas sin aprobar
        if ($this->tieneMateriasArrastradasNoAprobadas()) {
            $this->repite_grado = true;
            $this->addError('materiasSeleccionadas', 'Tiene Materias reprobadas sin aprobar. Debe repetir grado.');
        } else {
            $this->validarMateriasPendientes();
        }

        $this->cargarGradosPermitidos();
    }

    /**
     * Valida la cantidad de materias pendientes
     */
    private function validarMateriasPendientes()
    {
        $this->resetErrorBag('materiasSeleccionadas');

        $pendientesActuales = $this->materiasPendientesActuales();
        $cantidadPendientes = count($pendientesActuales);

        if ($cantidadPendientes >= 4) {
            $this->repite_grado = true;
            $this->addError(
                'materiasSeleccionadas',
                'Con 4 o más materias pendientes del grado actual el estudiante debe repetir grado.'
            );
        } else {
            $this->repite_grado = false;
        }
    }

    /**
     * Verifica si tiene Materias reprobadas sin aprobar
     */
    private function tieneMateriasArrastradasNoAprobadas(): bool
    {
        $arrastradasIds = collect($this->materias)
            ->where('origen', 'pendiente_anterior')
            ->pluck('id');

        if ($arrastradasIds->isEmpty()) {
            return false;
        }

        $aprobadasArrastradas = collect($this->materiasSeleccionadas)
            ->intersect($arrastradasIds);

        return $aprobadasArrastradas->count() < $arrastradasIds->count();
    }


    private function materiasArrastradasSeleccionadas(): array
    {
        return collect($this->materias)
            ->where('origen', 'pendiente_anterior')
            ->pluck('id')
            ->intersect($this->materiasSeleccionadas)
            ->values()
            ->toArray();
    }

    private function materiasPendientesActuales(): array
    {
        return collect($this->materias)
            ->where('origen', 'grado_actual')
            ->pluck('id')
            ->intersect($this->materiasSeleccionadas)
            ->values()
            ->toArray();
    }


    /* ============================================================
       MANEJO DE GRADOS Y SECCIONES
       ============================================================ */

    /**
     * Se ejecuta cuando cambia el grado de promoción
     */
    public function updatedGradoPromocionId($value)
    {
        $this->seccion_id = null;
        $this->secciones = collect();

        if (!$value) return;

        $grado = Grado::find($value);
        if (!$grado) return;

        $this->esPrimerGrado = ((int) $grado->numero_grado === 1);

        // Cargar secciones si no es primer grado
        if (!$this->esPrimerGrado) {
            $this->secciones = Seccion::where('grado_id', $value)
                ->where('status', true)
                ->orderBy('nombre', 'asc')
                ->get();
        }

        $this->validarMateriasPendientes();
    }

    /**
     * Valida si el grado seleccionado está permitido
     */
    private function validarGradoPermitido($gradoId): bool
    {
        if ($this->gradosPermitidos->isEmpty()) {
            $this->cargarGradosPermitidos();
        }

        return $this->gradosPermitidos->contains('id', $gradoId);
    }

    private function alumnoYaPromovido($alumnoId, $anioActualId): bool
    {
        return Inscripcion::where('alumno_id', $alumnoId)
            ->where('anio_escolar_id', $anioActualId)
            ->exists()

            || ModeloInscripcionProsecucion::whereHas('inscripcion', function ($q) use ($alumnoId, $anioActualId) {
                $q->where('inscripcions.alumno_id', $alumnoId)
                    ->where('inscripcions.anio_escolar_id', $anioActualId);
            })->exists();
    }



    /* ============================================================
       GUARDAR INSCRIPCIÓN
       ============================================================ */

    /**
     * Finaliza y guarda la inscripción de prosecución
     */
    public function finalizar()
    {

        // Validar formulario
        $this->validate();

        // Obtener año escolar activo (ANTES de usarlo)
        $anioActual = AnioEscolar::where('status', 'Activo')->first();

        if (!$anioActual) {
            $this->addError('general', 'No hay un año escolar activo.');
            return;
        }

        // Validaciones adicionales
        if (!$this->validarAntesDeGuardar()) {
            return;
        }

        // Evitar duplicados
        if ($this->alumnoYaPromovido($this->alumnoId, $anioActual->id)) {
            $this->addError(
                'alumnoId',
                'Este estudiante ya fue inscrito o promovido en el año escolar actual.'
            );
            return;
        }

        DB::beginTransaction();

        try {
            $anioActual = AnioEscolar::where('status', 'Activo')->firstOrFail();

            $inscripcionAnterior = $this->alumnoSeleccionado
                ->inscripcionAnterior($anioActual->id);

            if (!$inscripcionAnterior) {
                throw new \Exception('No se encontró la inscripción anterior del alumno.');
            }

            // Crear inscripción de prosecución
            $prosecucion = ModeloInscripcionProsecucion::create([
                'inscripcion_id' => $inscripcionAnterior->id,
                'anio_escolar_id' => $anioActual->id,
                'grado_id' => $this->gradoPromocionId,
                'seccion_id' => $this->seccion_id,
                'promovido' => !$this->repite_grado,
                'repite_grado' => $this->repite_grado,
                'observaciones' => $this->observaciones,
                'acepta_normas_contrato' => $this->acepta_normas_contrato,
                'status' => 'Activo',
            ]);

            if ($this->seccion_id) {

                $seccion = Seccion::lockForUpdate()->find($this->seccion_id);

                if (!$seccion) {
                    throw new \Exception('La sección seleccionada no existe.');
                }

                // Capacidad máxima (del grado)
                $grado = Grado::findOrFail($this->gradoPromocionId);
                $capacidadMax = $grado->max_seccion ?? 35;

                if ($seccion->cantidad_actual >= $capacidadMax) {
                    throw new \Exception(
                        "La sección {$seccion->nombre} ya alcanzó su capacidad máxima ({$capacidadMax} alumnos)."
                    );
                }

                // ✅ SUMAR ESTUDIANTE
                $seccion->increment('cantidad_actual');
            }


            // Guardar estado de cada materia
            $this->guardarMateriasEstado($prosecucion->id);

            DB::commit();

            session()->flash('success', 'Inscripción por prosecución registrada correctamente.');
            return redirect()->route('admin.transacciones.inscripcion_prosecucion.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            session()->flash('error', 'Error al guardar la inscripción: ' . $e->getMessage());
        }
    }

    /**
     * Valida condiciones antes de guardar
     */
    private function validarAntesDeGuardar(): bool
    {
        // Arrastre BLOQUEA todo
        if ($this->tieneMateriasArrastradasNoAprobadas()) {
            $this->repite_grado = true;

            if ($this->gradoPromocionId != $this->gradoAnteriorId) {
                $this->addError(
                    'gradoPromocionId',
                    'El estudiante tiene materias reprobadas sin aprobar. Debe repetir el grado.'
                );
                return false;
            }
        }

        // Luego pendientes del grado actual
        $cantidadPendientes = count($this->materiasPendientesActuales());

        if ($cantidadPendientes >= 4) {
            $this->repite_grado = true;

            if ($this->gradoPromocionId != $this->gradoAnteriorId) {
                $this->addError(
                    'gradoPromocionId',
                    'Con 4 o más materias pendientes debe repetir el grado.'
                );
                return false;
            }
        }

        // Validar: Materias reprobadas sin aprobar → debe repetir
        if ($this->tieneMateriasArrastradasNoAprobadas()) {
            $this->repite_grado = true;

            if ($this->gradoPromocionId != $this->gradoAnteriorId) {
                $this->addError(
                    'gradoPromocionId',
                    'El estudiante tiene Materias reprobadas sin aprobar. Debe recursar el grado.'
                );
                return false;
            }
        }

        return true;
    }

    /**
     * Guarda el estado de cada materia (aprobada o pendiente)
     */
    private function guardarMateriasEstado($prosecucionId)
    {
        $materiasSeleccionadas = collect($this->materiasSeleccionadas);

        foreach ($this->materias as $materia) {
            ProsecucionArea::create([
                'inscripcion_prosecucion_id' => $prosecucionId,
                'grado_area_formacion_id' => $materia['id'],
                'status' => $materiasSeleccionadas->contains($materia['id'])
                    ? 'pendiente'
                    : 'aprobada',
            ]);
        }
    }

    /* ============================================================
       RENDER
       ============================================================ */

    public function render()
    {
        return view('livewire.admin.transaccion-inscripcion.inscripcion-prosecucion');
    }
}
