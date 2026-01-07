<?php

namespace App\Livewire\Admin\Modales;

use Livewire\Component;
use App\Models\InstitucionProcedencia;
use App\Models\Localidad;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\AnioEscolar;

class InstitucionProcedenciaCreate extends Component
{
    public $nombre_institucion;
    public $estado_id;
    public $municipio_id;
    public $localidad_id;

    public $municipios = [];
    public $localidades = [];
    public $estados = [];

    protected $rules = [
        'nombre_institucion' => 'required|string|max:255',
        'estado_id' => 'required|integer|exists:estados,id',
        'municipio_id' => 'required|integer|exists:municipios,id',
        'localidad_id' => 'required|integer|exists:localidads,id',
    ];

    public function mount()
    {
        $this->estados = Estado::where('status', true)
            ->orderBy('nombre_estado', 'asc')
            ->get();
    }

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

        $this->municipio_id = null;
        $this->localidad_id = null;
        $this->localidades = [];
    }

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

        $this->localidad_id = null;
    }

    public function store()
    {
        $anioEscolarActivo = AnioEscolar::activos()
            ->where('cierre_anio_escolar', '>=', now())
            ->exists();

        if (!$anioEscolarActivo) {
            session()->flash('error', 'Debe registrar un año escolar activo para realizar esta acción.');
            return;
        }

        $this->validate();

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

        session()->flash('success', 'Institución creada exitosamente.');

        $this->dispatch('institucionCreada', [
            'id' => $institucion->id,
            'nombre' => $institucion->nombre_institucion,
            'localidad_id' => $institucion->localidad_id
        ]);

        $this->dispatch('cerrarModalDespuesDe', ['delay' => 1500]);

        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->nombre_institucion = '';
        $this->estado_id = null;
        $this->municipio_id = null;
        $this->localidad_id = null;
        $this->municipios = [];
        $this->localidades = [];
    }

    public function render()
    {
        return view('livewire.admin.modales.institucion-procedencia-create');
    }
}
