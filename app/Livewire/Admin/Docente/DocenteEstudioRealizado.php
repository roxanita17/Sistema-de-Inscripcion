<?php

namespace App\Livewire\Admin\Docente;

use Livewire\Component;
use App\Models\Docente;
use App\Models\EstudiosRealizado;
use App\Models\DetalleDocenteEstudio;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DocenteEstudioRealizado extends Component
{
    public Docente $docente;
    public $estudiosId;
    public $estudios;
    public $estudiosAsignados = [];

    public $estudioSeleccionado = null;


    public function mount(Docente $docente)
    {
        $this->docente = $docente;
        $this->cargarDatos();
    }

    public function cargarDatos()
    {
        // Cargar estudios disponibles (activos)
        $this->estudios = EstudiosRealizado::where('status', true)
            ->orderBy('estudios', 'asc')
            ->get();

        // Cargar estudios ya asignados al docente
        $this->estudiosAsignados = $this->docente->detalleDocenteEstudio()
            ->with('estudiosRealizado')
            ->where('status', true)
            ->get();

        // Reiniciar formulario
        $this->reset('estudiosId');
    }
    
    public function agregarEstudio()
    {
        // Validación básica
        $this->validate([
            'estudiosId' => 'required|exists:estudios_realizados,id',
        ], [
            'estudiosId.required' => 'Debe seleccionar un estudio',
            'estudiosId.exists' => 'El estudio seleccionado no es válido',
        ]);

        DB::beginTransaction();
        try {
            // Verificar si ya existe la combinación docente-estudio
            $existe = DetalleDocenteEstudio::where('docente_id', $this->docente->id)
                ->where('estudios_id', $this->estudiosId)
                ->where('status', true)
                ->exists();

            if ($existe) {
                throw ValidationException::withMessages([
                    'estudiosId' => 'Este estudio ya está asignado al docente.'
                ]);
            }

            // Crear el registro en la tabla intermedia
            DetalleDocenteEstudio::create([
                'docente_id' => $this->docente->id,
                'estudios_id' => $this->estudiosId,
                'status' => true,
            ]);

            DB::commit();

            // Recargar datos
            $this->cargarDatos();

            // Mensaje de éxito
            session()->flash('success', 'Estudio agregado correctamente.');

            // Resetear el select de bootstrap
            $this->dispatch('resetSelect');
            
        } catch (ValidationException $e) {
            DB::rollBack();
            
            // Re-lanzar la excepción de validación para que Livewire la maneje
            throw $e;
            
        } catch (Exception $e) {
            DB::rollBack();
            
            session()->flash('error', 'Error al agregar el estudio: ' . $e->getMessage());
        }
    }

    public function eliminarEstudio($detalleId)
    {
        DB::beginTransaction();
        try {
            // Buscar el detalle
            $detalle = DetalleDocenteEstudio::where('id', $detalleId)
                ->where('docente_id', $this->docente->id)
                ->where('status', true)
                ->firstOrFail();

            // Eliminación lógica
            $detalle->update(['status' => false]);

            DB::commit();

            // Recargar datos
            $this->cargarDatos();

            session()->flash('success', 'Estudio eliminado correctamente.');
            
        } catch (Exception $e) {
            DB::rollBack();
            
            session()->flash('error', 'Error al eliminar el estudio: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.docente.docente-estudio-realizado');
    }
}