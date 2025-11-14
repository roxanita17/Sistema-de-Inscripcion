<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Estado;

class EstadoIndex extends Component
{
    use WithPagination;

    public $nombre_estado;
    public $estado_id;
    public $updateMode = false;
    public $search = '';

    protected $paginationTheme = 'bootstrap'; // O 'tailwind' según tu frontend

    protected $rules = [
        'nombre_estado' => 'required|string|max:255',
    ];

    public function render()
    {
        $estados = Estado::where('status', true)
            ->when($this->search, function ($query) {
                $query->where('nombre_estado', 'like', '%' . $this->search . '%');
            })
            ->orderBy('nombre_estado', 'asc')
            ->paginate(10);

        return view('livewire.admin.estado-index', compact('estados'));
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetInputFields()
    {
        $this->nombre_estado = '';
        $this->estado_id = null;
        $this->updateMode = false;
    }

    public function store()
    {
        $this->validate();

        // Evitar duplicados
        if (Estado::where('nombre_estado', $this->nombre_estado)->where('status', true)->exists()) {
            session()->flash('error', 'Ya existe un estado con ese nombre.');
            return;
        }

        Estado::create([
            'nombre_estado' => $this->nombre_estado,
            'status' => true,
        ]);

        session()->flash('success', 'Estado creado correctamente.');
        $this->dispatch('cerrarModal');
        $this->resetInputFields();

    }

    public function edit($id)
    {
        $estado = Estado::findOrFail($id);
        $this->estado_id = $id;
        $this->nombre_estado = $estado->nombre_estado;
        $this->updateMode = true;
    }

    public function update()
    {
        $this->validate();

        $estado = Estado::find($this->estado_id);
        $estado->update(['nombre_estado' => $this->nombre_estado]);

        session()->flash('success', 'Estado actualizado correctamente.');
        $this->dispatch('cerrarModal');
        $this->resetInputFields();
    }

    public function destroy($id)
    {
        $estado = Estado::findOrFail($id);
        $estado->update(['status' => false]);

        session()->flash('success', 'Estado eliminado correctamente.');

        $this->dispatch('cerrarModal');
        $this->resetPage();

    }
}
