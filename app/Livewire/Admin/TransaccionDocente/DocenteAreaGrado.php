<?php

namespace App\Livewire\Admin\TransaccionDocente;

use Livewire\Component;
use App\Models\Docente;
use App\Models\AreaEstudioRealizado;
use App\Models\Grado;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\DocenteAreaGrado as ModeloDocenteAreaGrado;

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

    public $asignaciones = [];

    public $modoEditar = false;

    public $asignacionAEliminar = null;



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
            $this->cargarGrados();
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
            'grado'
        ])
        ->whereHas('detalleDocenteEstudio', function($q) {
            $q->where('docente_id', $this->docenteSeleccionado->id);
        })
        ->where('status', true)
        ->get();
    }


    /**
     * EVENTO PRINCIPAL: SELECCIONA DOCENTE
     * (solo se usa en modo normal)
     */
    public function seleccionarDocente()
    {
        $this->validate([
            'docenteId' => 'required|exists:docentes,id',
        ]);

        $this->docenteSeleccionado = Docente::with([
            'persona.tipoDocumento',
            'persona.genero',
            'persona.prefijoTelefono',
            'detalleDocenteEstudio.estudiosRealizado'
        ])->find($this->docenteId);

        $this->cargarMateriasPorEstudios();
        $this->cargarGrados();
        $this->cargarAsignaciones();

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
     * CARGA LISTA DE GRADOS
     */
    public function cargarGrados()
    {
        $this->grados = Grado::where('status', true)
            ->orderBy('numero_grado', 'asc')
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
        ]);

        DB::beginTransaction();
        try {
            $area = AreaEstudioRealizado::findOrFail($this->materiaId);

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

            // Validar duplicado
            $existe = ModeloDocenteAreaGrado::where([
                'docente_estudio_realizado_id' => $detalleEstudio->id,
                'area_estudio_realizado_id' => $this->materiaId,
                'grado_id' => $this->gradoId,
                'status' => true,
            ])->exists();

            if ($existe) {
                throw ValidationException::withMessages([
                    'materiaId' => 'Esta materia ya está asignada a este grado para el docente.'
                ]);
            }

            // Crear asignación
            ModeloDocenteAreaGrado::create([
                'docente_estudio_realizado_id' => $detalleEstudio->id,
                'area_estudio_realizado_id' => $this->materiaId,
                'grado_id' => $this->gradoId,
                'status' => true,
            ]);

            DB::commit();
            $this->cargarAsignaciones();
            $this->reset(['materiaId', 'gradoId']);
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


    /**
     * LIMPIAR TODO EL FORMULARIO
     */
    public function limpiarSeleccion()
    {
        $this->reset([
            'docenteId',
            'docenteSeleccionado',
            'materiaId',
            'gradoId',
            'materias',
            'grados',
            'asignaciones'
        ]);

        $this->dispatch('resetSelect');
    }


    /**
     * RENDERIZA LA VISTA
     */
    public function render()
    {
        return view('livewire.admin.transaccion-docente.docente-area-grado');
    }
}
