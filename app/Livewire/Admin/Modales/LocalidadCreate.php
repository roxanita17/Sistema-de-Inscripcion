<?php

namespace App\Livewire\Admin\Modales;

use Livewire\Component;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Localidad;
use App\Models\AnioEscolar;
use App\Models\Pais;


class LocalidadCreate extends Component
{
    public $nombre_localidad;
    public $pais_id;
    public $estado_id;
    public $municipio_id;

    public $estados = [];
    public $municipios = [];
    public $paises = [];

    protected $rules = [
        'nombre_localidad' => 'required|string|max:255',
        'pais_id' => 'required|integer|exists:pais,id',
        'estado_id' => 'required|integer|exists:estados,id',
        'municipio_id' => 'required|integer|exists:municipios,id',
    ];


    protected $messages = [
        'nombre_localidad.required' => 'El nombre de la localidad es requerido',
        'pais_id.required' => 'Debe seleccionar un país',
        'estado_id.required' => 'Debe seleccionar un estado',
        'municipio_id.required' => 'Debe seleccionar un municipio',
    ];


    public function mount()
    {
        $this->paises = Pais::where('status', true)
            ->orderBy('nameES', 'asc')
            ->get();
    }

    public function updatedPaisId($paisId)
    {
        if ($paisId) {
            $this->estados = Estado::where('pais_id', $paisId)
                ->where('status', true)
                ->orderBy('nombre_estado', 'asc')
                ->get();
        } else {
            $this->estados = [];
        }

        $this->estado_id = null;
        $this->municipio_id = null;
        $this->municipios = [];
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
    }


    public function store()
    {
        $anioEscolarActivo = AnioEscolar::activos()
            ->where('cierre_anio_escolar', '>=', now())
            ->exists();

        if (!$anioEscolarActivo) {
            $this->addError('general', 'Debe registrar un Calendario Escolar activo para realizar esta acción.');
            return;
        }

        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return;
        }

        $existe = Localidad::where('nombre_localidad', $this->nombre_localidad)
            ->where('municipio_id', $this->municipio_id)
            ->where('status', true)
            ->exists();

        if ($existe) {
            $this->addError('nombre_localidad', 'Ya existe una localidad con ese nombre en este municipio.');
            return;
        }

        try {
            $localidad = Localidad::create([
                'nombre_localidad' => $this->nombre_localidad,
                'municipio_id' => $this->municipio_id,
                'status' => true,
            ]);

            session()->flash('success', 'Localidad creada exitosamente.');

            $this->dispatch('localidadCreada', [
                'id' => $localidad->id,
                'municipio_id' => $localidad->municipio_id,
            ]);

            $this->dispatch('cerrarModalDespuesDe', ['delay' => 1500]);

            $this->resetInputFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Error al crear la localidad: ' . $e->getMessage());
        }
    }

    public function resetInputFields()
    {
        $this->nombre_localidad = '';
        $this->pais_id = null;
        $this->estado_id = null;
        $this->municipio_id = null;

        $this->estados = [];
        $this->municipios = [];

        $this->resetErrorBag();
        $this->resetValidation();
    }


    public function render()
    {
        return view('livewire.admin.modales.localidad-create');
    }
}
