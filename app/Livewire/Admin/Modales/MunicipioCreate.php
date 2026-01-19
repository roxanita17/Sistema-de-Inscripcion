<?php

namespace App\Livewire\Admin\Modales;

use Livewire\Component;
use App\Models\Pais;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\AnioEscolar;

class MunicipioCreate extends Component
{
    public $nombre_municipio;
    public $pais_id;
    public $estado_id;

    public $paises = [];
    public $estados = [];

    protected $rules = [
        'nombre_municipio' => 'required|string|max:255',
        'pais_id' => 'required|integer|exists:pais,id',
        'estado_id' => 'required|integer|exists:estados,id',
    ];

    protected $messages = [
        'nombre_municipio.required' => 'El nombre del municipio es requerido',
        'pais_id.required' => 'Debe seleccionar un país',
        'estado_id.required' => 'Debe seleccionar un estado',
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
    }

    public function store()
    {
        $anioEscolarActivo = AnioEscolar::activos()
            ->where('cierre_anio_escolar', '>=', now())
            ->exists();

        if (!$anioEscolarActivo) {
            $this->addError('general', 'Debe registrar un año escolar activo para realizar esta acción.');
            return;
        }

        try {
            $this->validate();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return;
        }

        $existe = Municipio::where('nombre_municipio', $this->nombre_municipio)
            ->where('estado_id', $this->estado_id)
            ->where('status', true)
            ->exists();

        if ($existe) {
            $this->addError('nombre_municipio', 'Ya existe un municipio con ese nombre en este estado.');
            return;
        }

        try {
            $municipio = Municipio::create([
                'nombre_municipio' => $this->nombre_municipio,
                'estado_id' => $this->estado_id,
                'status' => true,
            ]);

            session()->flash('success', 'Municipio creado exitosamente.');

            $this->dispatch(
                'municipioCreado',
                id: $municipio->id,
                estado_id: $municipio->estado_id
            );


            $this->dispatch('cerrarModalDespuesDe', ['delay' => 1500]);

            $this->resetInputFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Error al crear el municipio: ' . $e->getMessage());
        }
    }

    public function resetInputFields()
    {
        $this->nombre_municipio = '';
        $this->pais_id = null;
        $this->estado_id = null;
        $this->estados = [];

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.modales.municipio-create');
    }
}
