<?php

namespace App\Livewire\Admin\TransaccionDocente;

use Livewire\Component;
use App\Models\Docente;
use App\Models\AreaEstudioRealizado;
use App\Models\Grado;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\DocenteAreaGrado as ModeloDocenteAreaGrado;
use App\Models\EjecucionesPercentil;
use App\Models\Seccion;

class DocenteAreaGrado extends Component
{
    /**
     * PROPIEDADES PRINCIPALES
     */


    public $docenteId;
    public $docentes = [];
    public $docenteSeleccionado = null;

    public $materiaId;
    public $materias = [];
    public $estudios = [];

    public $gradoId;
    public $grados = [];

    public $seccionId;
    public $secciones = [];

    public $asignaciones = [];

    public $modoEditar = false;

    public $asignacionAEliminar = null;

    public $percentilEjecutado = false;


    /**
     * LISTENERS PARA EVENTOS
     */
    protected $listeners = [
        'materiaSeleccionada' => 'actualizarGrados',
        'asignacionCreada' => 'manejarAsignacionCreada',
    ];

    /**
     * Maneja la creación de una nueva asignación área-estudio
     */
    public function manejarAsignacionCreada($data)
    {

        // Recargar las materias del docente para incluir la nueva asignación
        if ($this->docenteSeleccionado) {
            $this->cargarMateriasPorEstudios();

            session()->flash('success_temp', 'Nueva área-estudio disponible para asignar.');
        }
    }


    /**
     * MÉTODO QUE SE EJECUTA AL CARGAR EL COMPONENTE
     * Si se recibe $docenteId → Modo edición
     */
    public function mount($docenteId = null)
    {

        if ($docenteId) {

            $this->modoEditar = true;
            $this->docenteId = $docenteId;

            $this->cargarDatosDocente();
            $this->cargarMateriasPorEstudios();
            // No cargar grados aún - se cargarán cuando seleccione una materia
            $this->grados = collect(); // Inicializar como colección vacía
            $this->cargarSecciones();
            $this->cargarAsignaciones();
        } else {
            // Modo registro normal → cargar listado de docentes
            $this->cargarDocentes();
        }
    }


    /**
     * CARGA COMPLETA DEL PERFIL DEL DOCENTE
     */
    public function cargarDatosDocente()
    {
        $this->docenteSeleccionado = Docente::with([
            'persona',
            'persona.prefijoTelefono',
            'persona.prefijoDos',
            'persona.tipoDocumento',
            'persona.genero',
            'detalleEstudios.estudiosRealizado',
            'docenteAreaGrado.areaEstudios.areaFormacion',
            'docenteAreaGrado.grado'
        ])->findOrFail($this->docenteId);


        $this->estudios = $this->docenteSeleccionado->detalleEstudios;
        $this->asignaciones = $this->docenteSeleccionado->docenteAreaGrado;
    }



    /**
     * LISTADO DE DOCENTES PARA MODO NORMAL
     */
    public function cargarDocentes()
    {
        $this->docentes = Docente::with([
            'persona.tipoDocumento',
            'persona.genero',
            'persona.prefijoTelefono',
            'persona.prefijoDos',
            'detalleDocenteEstudio.estudiosRealizado'
        ])
            ->whereHas('persona', fn($q) => $q->where('status', true))
            ->where('status', true)
            ->orderBy('codigo', 'asc')
            ->get();
    }


    /**
     * CARGA ASIGNACIONES ACTUALES DEL DOCENTE
     */
    public function cargarAsignaciones()
    {
        if (!$this->docenteSeleccionado) {
            $this->asignaciones = collect();
            return;
        }

        $this->asignaciones = ModeloDocenteAreaGrado::with([
            'areaEstudios.areaFormacion',
            'grado',
            'seccion'
        ])
            ->whereHas('detalleDocenteEstudio', function ($q) {
                $q->where('docente_id', $this->docenteSeleccionado->id);
            })
            ->where('status', true)
            ->get();
    }

    public function getPuedeAgregarAsignacionProperty()
    {
        return $this->materiaId && $this->gradoId && $this->seccionId;
    }



    /**
     * EVENTO AUTOMÁTICO: Se ejecuta cuando cambia docenteId
     * Esta es la clave para la selección automática
     */
    public function updatedDocenteId($value)
    {
        if (!$value) {
            $this->reset([
                'docenteSeleccionado',
                'materiaId',
                'materias',
                'gradoId',
                'grados',
                'seccionId',
                'secciones',
                'asignaciones',
            ]);

            $this->dispatch('resetSelects');
            return;
        }

        $this->docenteSeleccionado = Docente::with([
            'persona.tipoDocumento',
            'persona.genero',
            'persona.prefijoTelefono',
            'persona.prefijoDos',
            'detalleDocenteEstudio.estudiosRealizado'
        ])->find($value);

        $this->reset([
            'materiaId',
            'gradoId',
            'seccionId',
            'grados',
            'secciones',
        ]);

        $this->cargarMateriasPorEstudios();

        $this->cargarAsignaciones();

        $this->dispatch('resetSelects');

        session()->flash('success', 'Docente seleccionado correctamente.');
    }



    /**
     * CARGA LAS MATERIAS DISPONIBLES SEGÚN LOS ESTUDIOS DEL DOCENTE
     */
    public function cargarMateriasPorEstudios()
    {
        if (!$this->docenteSeleccionado) {
            $this->materias = [];
            return;
        }

        // IDs de estudios del docente
        $estudiosIds = $this->docenteSeleccionado
            ->detalleDocenteEstudio()
            ->where('status', true)
            ->pluck('estudios_id')
            ->toArray();

        if (empty($estudiosIds)) {
            $this->materias = [];
            session()->flash('error', 'El docente no tiene estudios registrados.');
            return;
        }

        // Filtrar materias por estudios y ordenarlas por el nombre del área de formación
        $this->materias = AreaEstudioRealizado::with('areaFormacion')
            ->where('status', true)
            ->whereIn('estudios_id', $estudiosIds)
            ->get()
            ->sortBy('areaFormacion.nombre_area_formacion')
            ->values();
    }

    /**
     * CARGA LISTA DE GRADOS SEGÚN LA MATERIA SELECCIONADA
     */
    public function cargarGrados()
    {
        // Si no hay materia seleccionada, no cargar grados
        if (!$this->materiaId) {
            $this->grados = collect(); // Colección vacía
            return;
        }

        // Obtener el área de formación de la materia seleccionada
        $areaEstudio = AreaEstudioRealizado::with('areaFormacion')->find($this->materiaId);

        if (!$areaEstudio || !$areaEstudio->area_formacion_id) {
            $this->grados = collect();
            return;
        }

        $areaFormacionId = $areaEstudio->area_formacion_id;

        // Cargar solo los grados que tienen asignada esta área de formación
        $this->grados = Grado::where('status', true)
            ->whereHas('gradoAreaFormacion', function ($q) use ($areaFormacionId) {
                $q->where('area_formacion_id', $areaFormacionId)
                    ->where('status', true);
            })
            ->orderBy('numero_grado', 'asc')
            ->get();
    }

    /**
     * ACTUALIZA LOS GRADOS CUANDO CAMBIA LA MATERIA
     * Este método se ejecuta cuando el select de materias cambia
     */
    public function actualizarGrados()
    {
        // Resetear grado y sección al cambiar la materia
        $this->reset(['gradoId', 'seccionId']);

        // Limpiar secciones
        $this->secciones = collect();

        // Recargar grados
        $this->cargarGrados();

        $this->dispatch('resetGradoSeccion');
    }

    public function updated($property)
    {
        // No hacer nada aquí para evitar recargas innecesarias
    }

    public function hydrate()
    {
        // Asegurar que el docente esté siempre cargado
        if ($this->docenteId && !$this->docenteSeleccionado) {
            $this->cargarDatosDocente();
        }
    }

    /**
     * EVENTO: Al cambiar la materia desde el select (llamado manualmente)
     */
    public function updatedMateriaId()
    {
        // Asegurar que el docente esté cargado antes de actualizar grados
        if ($this->docenteId && !$this->docenteSeleccionado) {
            $this->cargarDatosDocente();
        }

        $this->actualizarGrados();
    }

    public function updatedGradoId()
    {
        // Resetear sección al cambiar grado
        $this->reset('seccionId');

        // Cargar secciones filtradas
        $this->cargarSecciones();
    }

    public function cargarSecciones()
    {
        if (!$this->gradoId) {
            $this->secciones = collect();
            return;
        }

        $this->secciones = Seccion::where('status', true)
            ->where('grado_id', $this->gradoId)
            ->orderBy('nombre', 'asc')
            ->get();
    }

    /**
     * REGISTRA UNA NUEVA ASIGNACIÓN
     */
    public function agregarAsignacion()
    {
        $this->validate([
            'materiaId' => 'required|exists:area_estudio_realizados,id',
            'gradoId' => 'required|exists:grados,id',
            'seccionId' => 'required|exists:seccions,id',
        ]);

        DB::beginTransaction();
        try {
            $area = AreaEstudioRealizado::findOrFail($this->materiaId);

            // Verificar que el grado esté relacionado con el área de formación de la materia
            $areaFormacionId = $area->area_formacion_id;
            $gradoTieneMateria = \App\Models\GradoAreaFormacion::where('grado_id', $this->gradoId)
                ->where('area_formacion_id', $areaFormacionId)
                ->where('status', true)
                ->exists();

            if (!$gradoTieneMateria) {
                throw ValidationException::withMessages([
                    'gradoId' => 'El nivel academico seleccionado no tiene asignada esta area de formacion en el sistema. Debe asignarla primero en Niveles Academicos - Areas de Formacion.'
                ]);
            }

            // Buscar el detalle estudio al que pertenece la materia
            $detalleEstudio = $this->docenteSeleccionado->detalleDocenteEstudio()
                ->where('estudios_id', $area->estudios_id)
                ->where('status', true)
                ->first();

            if (!$detalleEstudio) {
                throw ValidationException::withMessages([
                    'materiaId' => 'No se encontró el estudio correspondiente a esta materia.'
                ]);
            }

            // Validar duplicado para el mismo docente
            $existe = ModeloDocenteAreaGrado::where([
                'docente_estudio_realizado_id' => $detalleEstudio->id,
                'area_estudio_realizado_id' => $this->materiaId,
                'grado_id' => $this->gradoId,
                'seccion_id' => $this->seccionId,
                'status' => true,
            ])->exists();

            if ($existe) {
                throw ValidationException::withMessages([
                    'materiaId' => 'Esta area de formacion ya está asignada a este nivel academico y sección para este docente.'
                ]);
            }

            // Validar si la combinación materia-grado-sección ya está asignada a CUALQUIER docente
            // IMPORTANTE: Validar por el área de formación (materia base), no por el ID específico de area_estudio_realizado
            $areaFormacionId = AreaEstudioRealizado::where('id', $this->materiaId)
                ->value('area_formacion_id');

            if (!$areaFormacionId) {
                throw ValidationException::withMessages([
                    'materiaId' => 'No se pudo identificar el área de formación de esta materia.'
                ]);
            }

            // Buscar si existe una asignación con la misma área de formación, grado y sección
            $asignacionExistente = ModeloDocenteAreaGrado::where('grado_id', $this->gradoId)
                ->where('seccion_id', $this->seccionId)
                ->where('status', true)
                ->whereHas('areaEstudios', function ($q) use ($areaFormacionId) {
                    $q->where('area_formacion_id', $areaFormacionId);
                })
                ->with(['detalleDocenteEstudio.docente.persona'])
                ->first();

            if ($asignacionExistente) {
                $docenteExistente = $asignacionExistente->detalleDocenteEstudio->docente;

                // Si es el mismo docente, mensaje específico
                if ($docenteExistente->id == $this->docenteSeleccionado->id) {
                    throw ValidationException::withMessages([
                        'materiaId' => 'Ya tienes esta area de formacion asignada a este nivel academico y sección.'
                    ]);
                }

                // Si es otro docente, indicar quién la tiene
                $nombreDocente = $docenteExistente->persona->primer_nombre . ' ' . $docenteExistente->persona->primer_apellido;
                throw ValidationException::withMessages([
                    'materiaId' => "Esta area de formacion ya está asignada a este nivel academico y sección por el docente: {$nombreDocente}"
                ]);
            }

            // Crear asignación
            ModeloDocenteAreaGrado::create([
                'docente_estudio_realizado_id' => $detalleEstudio->id,
                'area_estudio_realizado_id' => $this->materiaId,
                'grado_id' => $this->gradoId,
                'seccion_id' => $this->seccionId,
                'status' => true,
            ]);

            DB::commit();
            $this->cargarAsignaciones();
            $this->reset(['materiaId', 'gradoId', 'seccionId']);
            $this->dispatch('resetSelects');

            session()->flash('success', 'Asignación registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al registrar la asignación: ' . $e->getMessage());
        }
    }


    /**
     * ELIMINACIÓN LÓGICA DE ASIGNACIÓN
     */
    public function eliminarAsignacion($asignacionId)
    {
        DB::beginTransaction();
        try {
            $asignacion = ModeloDocenteAreaGrado::findOrFail($asignacionId);
            $asignacion->update(['status' => false]);

            DB::commit();
            $this->cargarAsignaciones();

            session()->flash('success', 'Asignación eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al eliminar la asignación: ' . $e->getMessage());
        }
    }

    public function limpiarSeleccion()
    {
        $this->reset([
            'docenteId',
            'docenteSeleccionado',
            'materiaId',
            'gradoId',
            'seccionId',
            'materias',
            'grados',
            'secciones',
            'asignaciones'
        ]);

        $this->dispatch('resetSelect');
    }


    /**
     * RENDERIZA LA VISTA
     */
    public function render()
    {
        $totalGrados = Grado::where('status', true)->count();
        $totalSecciones = Seccion::where('status', true)->count();

        return view('livewire.admin.transaccion-docente.docente-area-grado', [
            'totalGrados' => $totalGrados,
            'totalSecciones' => $totalSecciones,
        ]);
    }
}
