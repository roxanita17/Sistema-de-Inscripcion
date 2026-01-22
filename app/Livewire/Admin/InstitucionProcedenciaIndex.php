<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InstitucionProcedencia;
use App\Models\Localidad;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\AnioEscolar;

class InstitucionProcedenciaIndex extends Component
{
    use WithPagination;

    public $institucion_id;
    public $nombre_institucion;
    public $estado_id;
    public $municipio_id;
    public $localidad_id;
    public $search = '';
    public $updateMode = false;

    public $anioEscolarActivo = false;
    public $municipios = [];
    public $localidades = [];
    public $modoModal = false;

    protected $rules = [
        'nombre_institucion' => 'required|string|max:255',
        'estado_id' => 'required|integer|exists:estados,id',
        'municipio_id' => 'required|integer|exists:municipios,id',
        'localidad_id' => 'required|integer|exists:localidads,id',
    ];

    public function mount($modoModal = false)
    {
        $this->modoModal = $modoModal;
        $this->verificarAnioEscolar();
    }

    private function verificarAnioEscolar()
    {
        $this->anioEscolarActivo = AnioEscolar::activos()
            ->where('cierre_anio_escolar', '>=', now())
            ->exists();
    }

    private function verificarAccion()
    {
        if (!$this->anioEscolarActivo) {
            session()->flash('warning', 'Debe registrar un Calendario Escolar activo para realizar esta acción.');
            return false;
        }
        return true;
    }

    // ========================================
    // LISTENERS DE CAMBIO (SELECTS DINÁMICOS)
    // ========================================

    /**
     * Cuando cambia el estado, cargar municipios de ese estado
     */
    public function updatedEstadoId($estadoId)
    {
        if ($estadoId) {
            $this->municipios = Municipio::where('estado_id', $estadoId)
                ->where('status', true)
                ->orderBy('nombre_municipio', 'asc')
                ->get();
        } else {
            $this->municipios = [];
        }

        // Reiniciar los selects dependientes
        $this->municipio_id = null;
        $this->localidad_id = null;
        $this->localidades = [];
    }

    /**
     * Cuando cambia el municipio, cargar localidades de ese municipio
     */
    public function updatedMunicipioId($municipioId)
    {
        if ($municipioId) {
            $this->localidades = Localidad::where('municipio_id', $municipioId)
                ->where('status', true)
                ->orderBy('nombre_localidad', 'asc')
                ->get();
        } else {
            $this->localidades = [];
        }

        // Reiniciar el select dependiente
        $this->localidad_id = null;
    }

    // ========================================
    // RENDER
    // ========================================

    public function render()
    {
        // Solo cargar estados (municipios y localidades se cargan dinámicamente)
        $estados = Estado::where('status', true)
            ->orderBy('nombre_estado', 'asc')
            ->get();

        $instituciones = InstitucionProcedencia::where('status', true)
            ->when($this->search, function ($query) {
                $query->where('nombre_institucion', 'like', '%' . $this->search . '%')
                    ->orWhereHas('localidad', function ($q) {
                        $q->where('nombre_localidad', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('localidad.municipio', function ($q) {
                        $q->where('nombre_municipio', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('localidad.municipio.estado', function ($q) {
                        $q->where('nombre_estado', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('nombre_institucion', 'asc')
            ->paginate(10);

        return view('livewire.admin.institucion-procedencia-index', compact('instituciones', 'estados'));
    }

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap-custom';
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    // ========================================
    // CRUD 
    // ========================================

    public function resetInputFields()
    {
        $this->institucion_id = null;
        $this->nombre_institucion = '';
        $this->estado_id = null;
        $this->municipio_id = null;
        $this->localidad_id = null;
        $this->municipios = [];
        $this->localidades = [];
        $this->updateMode = false;
    }


    public function store()
    {
        if (!$this->verificarAccion()) {
            return;
        }

        $this->validate();

        // Verificar duplicados
        if (InstitucionProcedencia::where('nombre_institucion', $this->nombre_institucion)
            ->where('localidad_id', $this->localidad_id)
            ->where('status', true)
            ->exists()
        ) {
            session()->flash('error', 'Ya existe una institución con ese nombre en esta localidad.');
            return;
        }

        $institucion = InstitucionProcedencia::create([
            'nombre_institucion' => $this->nombre_institucion,
            'localidad_id' => $this->localidad_id,
            'status' => true,
        ]);

        session()->flash('success', 'Institución creada correctamente.');
        $this->dispatch('cerrarModal');
        $this->resetInputFields();

        // NUEVO: Si está en modo modal, notificar al componente padre
        if ($this->modoModal) {
            $this->dispatch('institucionCreada', [
                'id' => $institucion->id,
                'nombre' => $institucion->nombre_institucion
            ]);
        }
    }

    public function edit($id)
    {
        if (!$this->verificarAccion()) {
            return;
        }

        $inst = InstitucionProcedencia::with('localidad.municipio.estado')->findOrFail($id);

        $this->institucion_id = $inst->id;
        $this->nombre_institucion = $inst->nombre_institucion;

        // Obtener estado, municipio y localidad desde las relaciones
        if ($inst->localidad && $inst->localidad->municipio && $inst->localidad->municipio->estado) {
            $this->estado_id = $inst->localidad->municipio->estado->id;
            $this->municipio_id = $inst->localidad->municipio->id;
            $this->localidad_id = $inst->localidad_id;

            // Cargar municipios del estado seleccionado
            $this->municipios = Municipio::where('estado_id', $this->estado_id)
                ->where('status', true)
                ->orderBy('nombre_municipio', 'asc')
                ->get();

            // Cargar localidades del municipio seleccionado
            $this->localidades = Localidad::where('municipio_id', $this->municipio_id)
                ->where('status', true)
                ->orderBy('nombre_localidad', 'asc')
                ->get();
        }

        $this->updateMode = true;
    }

    public function update()
    {
        if (!$this->verificarAccion()) {
            return;
        }

        $this->validate();

        $inst = InstitucionProcedencia::findOrFail($this->institucion_id);

        // Verificar duplicados (excepto el registro actual)
        $existe = InstitucionProcedencia::where('nombre_institucion', $this->nombre_institucion)
            ->where('localidad_id', $this->localidad_id)
            ->where('status', true)
            ->where('id', '!=', $this->institucion_id)
            ->exists();

        if ($existe) {
            session()->flash('error', 'Ya existe una institución con ese nombre en esta localidad.');
            return;
        }

        $inst->update([
            'nombre_institucion' => $this->nombre_institucion,
            'localidad_id' => $this->localidad_id,
        ]);

        session()->flash('success', 'Institución actualizada correctamente.');
        $this->dispatch('cerrarModal');
        $this->resetInputFields();
    }

    public function destroy($id)
    {
        if (!$this->verificarAccion()) {
            return;
        }

        $inst = InstitucionProcedencia::findOrFail($id);
        $inst->update(['status' => false]);

        session()->flash('success', 'Institución eliminada correctamente.');
        $this->dispatch('cerrarModal');
        $this->resetPage();
    }
}
