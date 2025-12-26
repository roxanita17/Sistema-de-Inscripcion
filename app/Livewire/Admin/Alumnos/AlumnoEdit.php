<?php

namespace App\Livewire\Admin\Alumnos;

use Livewire\Component;
use App\Models\Alumno;
use App\Models\Persona;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Localidad;
use App\Models\Talla;
use App\Models\Lateralidad;
use App\Models\OrdenNacimiento;
use App\Models\EtniaIndigena;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AlumnoEdit extends Component
{
    public $alumnoId;
    public $personaId;
    
    // Datos personales
    public $tipo_documento_id;
    public $numero_documento;
    public $primer_nombre;
    public $segundo_nombre;
    public $tercer_nombre;
    public $primer_apellido;
    public $segundo_apellido;
    public $genero_id;
    public $fecha_nacimiento;
    public $edad = 0;
    public $meses = 0;

    // Datos físicos
    public $talla_estudiante = '';
    public $peso_estudiante;
    public $talla_camisa_id;
    public $talla_zapato;
    public $talla_pantalon_id;

    // Lugar de nacimiento
    public $estado_id;
    public $municipio_id;
    public $localidad_id;

    // Otros
    public $lateralidad_id;
    public $orden_nacimiento_id;
    public $etnia_indigena_id;

    // Listas para selects
    public $tipos_documentos = [];
    public $generos = [];
    public $estados = [];
    public $municipios = [];
    public $localidades = [];
    public $tallas = [];
    public $lateralidades = [];
    public $orden_nacimientos = [];
    public $etnia_indigenas = [];

    public $enModoEdicion = false;

    public function mount($alumnoId)
    {
        $this->alumnoId = $alumnoId;
        $this->cargarDatosIniciales();
        $this->cargarAlumno();
    }

    private function cargarDatosIniciales()
    {
        $this->tipos_documentos = \App\Models\TipoDocumento::where('status', true)->get();
        $this->generos = \App\Models\Genero::where('status', true)->get();
        $this->estados = Estado::where('status', true)->get();
        $this->tallas = Talla::all();
        $this->lateralidades = Lateralidad::where('status', true)->get();
        $this->orden_nacimientos = OrdenNacimiento::where('status', true)->get();
        $this->etnia_indigenas = EtniaIndigena::where('status', true)->get();
    }

    private function cargarAlumno()
    {
        $alumno = Alumno::with('persona.localidad.municipio.estado')->findOrFail($this->alumnoId);
        $persona = $alumno->persona;

        // Datos de persona
        $this->personaId = $persona->id;
        $this->tipo_documento_id = $persona->tipo_documento_id;
        $this->numero_documento = $persona->numero_documento;
        $this->primer_nombre = $persona->primer_nombre;
        $this->segundo_nombre = $persona->segundo_nombre;
        $this->tercer_nombre = $persona->tercer_nombre;
        $this->primer_apellido = $persona->primer_apellido;
        $this->segundo_apellido = $persona->segundo_apellido;
        $this->genero_id = $persona->genero_id;
        $this->fecha_nacimiento = $persona->fecha_nacimiento->format('Y-m-d');

        // Datos físicos
        $this->talla_estudiante = $alumno->estatura;
        $this->peso_estudiante = $alumno->peso;
        $this->talla_camisa_id = $alumno->talla_camisa_id;
        $this->talla_zapato = $alumno->talla_zapato;
        $this->talla_pantalon_id = $alumno->talla_pantalon_id;

        // Ubicación (validar que exista localidad)
        if ($persona->localidad) {
            $this->localidad_id = $persona->localidad_id;
            
            if ($persona->localidad->municipio) {
                $this->municipio_id = $persona->localidad->municipio_id;
                $this->estado_id = $persona->localidad->municipio->estado_id;
                
                // Cargar municipios y localidades
                $this->cargarMunicipios($this->estado_id);
                $this->cargarLocalidades($this->municipio_id);
            }
        }

        // Otros
        $this->lateralidad_id = $alumno->lateralidad_id;
        $this->orden_nacimiento_id = $alumno->orden_nacimiento_id;
        $this->etnia_indigena_id = $alumno->etnia_indigena_id;

        // Calcular edad
        $this->calcularEdad($this->fecha_nacimiento);
    }

    public function updatedEstadoId($value)
    {
        $this->cargarMunicipios($value);
        $this->municipio_id = null;
        $this->localidad_id = null;
        $this->localidades = [];
    }

    public function updatedMunicipioId($value)
    {
        $this->cargarLocalidades($value);
        $this->localidad_id = null;
    }

    private function cargarMunicipios($estadoId)
    {
        $this->municipios = Municipio::where('estado_id', $estadoId)
            ->where('status', true)
            ->orderBy('nombre_municipio')
            ->get();
    }

    private function cargarLocalidades($municipioId)
    {
        $this->localidades = Localidad::where('municipio_id', $municipioId)
            ->where('status', true)
            ->orderBy('nombre_localidad')
            ->get();
    }

    public function updatedFechaNacimiento($value)
    {
        $this->calcularEdad($value);
    }

    private function calcularEdad($fecha)
    {
        if (!$fecha) return;

        try {
            $fechaNac = Carbon::parse($fecha);
            $hoy = Carbon::now();

            $this->edad = $fechaNac->diffInYears($hoy);
            $this->meses = $fechaNac->diffInMonths($hoy) % 12;
        } catch (\Exception $e) {
            $this->edad = 0;
            $this->meses = 0;
        }
    }

    public function habilitarEdicion()
    {
        $this->enModoEdicion = true;
    }

    public function cancelarEdicion()
    {
        $this->enModoEdicion = false;
        $this->cargarAlumno();
    }

    public function guardar()
    {
        // Validación básica
        if (!$this->localidad_id) {
            session()->flash('error', 'Debe seleccionar una localidad.');
            return;
        }

        try {
            DB::beginTransaction();

            $persona = Persona::findOrFail($this->personaId);
            $persona->update([
                'primer_nombre' => $this->primer_nombre,
                'segundo_nombre' => $this->segundo_nombre,
                'tercer_nombre' => $this->tercer_nombre,
                'primer_apellido' => $this->primer_apellido,
                'segundo_apellido' => $this->segundo_apellido,
                'tipo_documento_id' => $this->tipo_documento_id,
                'numero_documento' => $this->numero_documento,
                'genero_id' => $this->genero_id,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'localidad_id' => $this->localidad_id,
            ]);

            $alumno = Alumno::findOrFail($this->alumnoId);
            $alumno->update([
                'talla_camisa_id' => $this->talla_camisa_id,
                'talla_pantalon_id' => $this->talla_pantalon_id,
                'talla_zapato' => $this->talla_zapato,
                'peso' => $this->peso_estudiante,
                'estatura' => (float)$this->talla_estudiante,
                'lateralidad_id' => $this->lateralidad_id,
                'orden_nacimiento_id' => $this->orden_nacimiento_id,
                'etnia_indigena_id' => $this->etnia_indigena_id,
            ]);

            DB::commit();

            $this->enModoEdicion = false;
            $this->dispatch('actualizarAlumno');
            session()->flash('success', 'Datos del alumno actualizados correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.alumnos.alumno-edit');
    }
}