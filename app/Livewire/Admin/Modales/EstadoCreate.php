<?php

namespace App\Livewire\Admin\Modales;

use Livewire\Component;
use App\Models\Pais;
use App\Models\AnioEscolar;
use App\Models\Estado;

class EstadoCreate extends Component
{
    public $nombre_estado;
    public $pais_id;

    public $paises = [];

    protected $rules = [
        'nombre_estado' => 'required|string|max:255',
        'pais_id' => 'required|integer|exists:pais,id',
    ];

    protected $messages = [
        'nombre_estado.required' => 'El nombre del estado es requerido',
        'pais_id.required' => 'Debe seleccionar un país',
    ];

    public function mount()
    {
        $this->paises = Pais::where('status', true)
            ->orderBy('nameES', 'asc')
            ->get();
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

        $existe = Estado::where('nombre_estado', $this->nombre_estado)
            ->where('pais_id', $this->pais_id)
            ->where('status', true)
            ->exists();

        if ($existe) {
            $this->addError('nombre_estado', 'Ya existe un estado con ese nombre en este país.');
            return;
        }

        try {
            $estado = Estado::create([
                'nombre_estado' => $this->nombre_estado,
                'pais_id' => $this->pais_id,
                'status' => true,
            ]);

            session()->flash('success', 'estado creado exitosamente.');

            $this->dispatch('estadoCreado', [
                'id' => $estado->id,
                'pais_id' => $estado->pais_id,
            ]);

            $this->dispatch('cerrarModalDespuesDe', ['delay' => 1500]);

            $this->resetInputFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Error al crear el estado: ' . $e->getMessage());
        }
    }

    public function resetInputFields()
    {
        $this->nombre_estado = '';
        $this->pais_id = null;

        $this->resetErrorBag();
        $this->resetValidation();
    }




    public function render()
    {
        return view('livewire.admin.modales.estado-create');
    }
}
