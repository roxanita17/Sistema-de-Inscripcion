<?php

namespace App\Livewire\Admin\Alumnos;

use Livewire\Component;
use App\Models\Alumno;
use App\Models\Discapacidad;
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
use Livewire\Attributes\Validate;

class AlumnoEdit extends Component
{
    public $alumnoId;
    public $persona_id;
    public $alumnoSeleccionado;

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

    // UI dinámico para documento
    public $documento_maxlength = 8;
    public $documento_pattern = '[0-9]+';
    public $documento_placeholder = '12345678';
    public $documento_inputmode = 'numeric';

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

    // Para mostrar discapacidades
    public $discapacidadesAlumno = [];
    public $discapacidadesAgregadas = [];
    public $discapacidadSeleccionada;
    public $discapacidades = [];

    public $enModoEdicion = false;
    public bool $soloEdicion = false;

    /* ============================================================
       =====================   VALIDACIÓN   ========================
       ============================================================ */
    protected function rules()
    {
        return [
            // Persona
            'tipo_documento_id' => 'required|exists:tipo_documentos,id',
            'numero_documento' => [
                'required',
                'unique:personas,numero_documento,' . $this->persona_id,
                function ($attribute, $value, $fail) {
                    switch ((int) $this->tipo_documento_id) {
                        // V - Venezolano (ID 1)
                        case 1:
                            if (!ctype_digit($value)) {
                                $fail('La cédula debe contener solo números.');
                            }
                            if (strlen($value) > 8) {
                                $fail('La cédula venezolana debe tener máximo 8 dígitos.');
                            }
                            break;

                        // E - Extranjero (ID 2)
                        case 2:
                            if (!ctype_alnum($value)) {
                                $fail('La cédula de extranjero debe ser alfanumérica.');
                            }
                            if (strlen($value) > 12 || strlen($value) < 8) {
                                $fail('La cédula de extranjero debe tener entre 8 y 12 caracteres.');
                            }
                            break;

                        // CE - Cédula Especial (ID 3)
                        case 3:
                            if (!ctype_digit($value)) {
                                $fail('La cédula especial debe contener solo números.');
                            }
                            if (strlen($value) > 12 || strlen($value) < 10) {
                                $fail('La cédula especial debe tener entre 10 y 12 dígitos.');
                            }
                            break;
                    }
                }
            ],

            'primer_nombre' => 'required|string|max:50',
            'primer_apellido' => 'required|string|max:50',
            'segundo_nombre' => 'nullable|string|max:50',
            'tercer_nombre' => 'nullable|string|max:50',
            'segundo_apellido' => 'nullable|string|max:50',
            'genero_id' => 'required|exists:generos,id',

            // Fecha nacimiento y edad
            'fecha_nacimiento' => [
                'required',
                'date',
                'before:today',
                function ($attribute, $value, $fail) {
                    $edad = Carbon::parse($value)->age;
                    if ($edad < 10 || $edad > 18) {
                        $fail('La edad debe estar entre 10 y 18 años.');
                    }
                }
            ],

            // Datos físicos
            'talla_estudiante' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $valor = (float) str_replace(',', '.', $value);

                    if ($valor <= 0) {
                        $fail('La estatura no es válida.');
                    }

                    // Si parece cm
                    if ($valor > 3 && ($valor < 50 || $valor > 250)) {
                        $fail('La estatura en cm debe estar entre 50 y 250.');
                    }

                    // Si parece metros
                    if ($valor <= 3 && ($valor < 0.5 || $valor > 2.5)) {
                        $fail('La estatura en metros debe estar entre 0.50 y 2.50.');
                    }
                }
            ],
            'peso_estudiante' => 'required|numeric|between:2,300',
            'talla_camisa_id' => 'required|exists:tallas,id',
            'talla_pantalon_id' => 'required|exists:tallas,id',
            'talla_zapato' => 'required|integer',

            // Residencia
            'estado_id' => 'required|exists:estados,id',
            'municipio_id' => 'required|exists:municipios,id',
            'localidad_id' => 'required|exists:localidads,id',

            // Otros
            'lateralidad_id' => 'required|exists:lateralidads,id',
            'orden_nacimiento_id' => 'required|exists:orden_nacimientos,id',
            'etnia_indigena_id' => 'nullable|exists:etnia_indigenas,id',
        ];
    }

    protected $messages = [
        'tipo_documento_id.required' => 'Debe seleccionar tipo de documento',
        'numero_documento.required' => 'Debe ingresar la cédula',
        'numero_documento.unique' => 'Esta cédula ya está registrada en el sistema',
        'primer_nombre.required' => 'Debe ingresar el primer nombre',
        'primer_nombre.max' => 'El nombre no puede exceder 50 caracteres',
        'primer_apellido.required' => 'Debe ingresar el primer apellido',
        'primer_apellido.max' => 'El apellido no puede exceder 50 caracteres',
        'genero_id.required' => 'Debe seleccionar un género',
        'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
        'fecha_nacimiento.before' => 'La fecha debe ser anterior a hoy',
        'talla_estudiante.required' => 'La estatura es requerida',
        'talla_estudiante.numeric' => 'La estatura debe ser un número',
        'talla_estudiante.between' => 'La estatura debe estar entre 0.50 y 3.00 metros',
        'peso_estudiante.required' => 'El peso es requerido',
        'peso_estudiante.numeric' => 'El peso debe ser un número',
        'peso_estudiante.between' => 'El peso debe estar entre 2 y 300 kg',
        'talla_camisa_id.required' => 'Debe seleccionar una talla de camisa',
        'talla_zapato.required' => 'Debe seleccionar una talla de zapato',
        'talla_zapato.integer' => 'La talla debe ser un número entero',
        'talla_pantalon_id.required' => 'Debe seleccionar una talla de pantalón',
        'estado_id.required' => 'Debe seleccionar un estado',
        'municipio_id.required' => 'Debe seleccionar un municipio',
        'localidad_id.required' => 'Debe seleccionar una localidad',
        'lateralidad_id.required' => 'Debe seleccionar la lateralidad',
        'orden_nacimiento_id.required' => 'Debe seleccionar el orden de nacimiento',
    ];

    // Validación en tiempo real
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedTipoDocumentoId($value)
    {
        // Limpiar la cédula al cambiar tipo
        $this->numero_documento = null;
        $this->resetErrorBag('numero_documento');

        switch ((int) $value) {
            // V
            case 1:
                $this->documento_maxlength = 8;
                $this->documento_pattern = '[0-9]+';
                $this->documento_placeholder = '12345678';
                $this->documento_inputmode = 'numeric';
                break;

            // E
            case 2:
                $this->documento_maxlength = 12;
                $this->documento_pattern = '[A-Za-z0-9]+';
                $this->documento_placeholder = 'AB1234567890';
                $this->documento_inputmode = 'text';
                break;

            // CE
            case 3:
                $this->documento_maxlength = 12;
                $this->documento_pattern = '[0-9]+';
                $this->documento_placeholder = '123456789012';
                $this->documento_inputmode = 'numeric';
                break;

            default:
                $this->documento_maxlength = 8;
                $this->documento_pattern = '[0-9]+';
                $this->documento_placeholder = '';
                $this->documento_inputmode = 'numeric';
        }
    }

    public function updatedNumeroDocumento()
    {
        if ($this->tipo_documento_id) {
            $this->validateOnly('numero_documento');
        }
    }

    public function updatedPrimerNombre()
    {
        $this->validateOnly('primer_nombre');
    }

    public function updatedPrimerApellido()
    {
        $this->validateOnly('primer_apellido');
    }

    public function updatedGeneroId()
    {
        $this->validateOnly('genero_id');
    }

    public function updatedFechaNacimiento($value)
    {
        $this->calcularEdad($value);
        $this->validateOnly('fecha_nacimiento');
    }

    public function formatearEstatura()
    {
        // Quita todo menos números
        $valor = preg_replace('/\D/', '', $this->talla_estudiante);

        if (strlen($valor) >= 2) {
            $this->talla_estudiante = substr($valor, 0, -2) . '.' . substr($valor, -2);
        }
    }

    public function validarEstatura()
    {
        $this->validateOnly('talla_estudiante');
    }


    public function mount($alumnoId,  $soloEdicion = false)
    {
        $this->alumnoId = $alumnoId;
        $this->cargarDatosIniciales();
        $this->soloEdicion = $soloEdicion;

        if ($this->soloEdicion) {
            $this->enModoEdicion = true;
        }
        $this->cargarAlumno();
        $this->cargarDiscapacidades();
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

        // Cargar discapacidades disponibles
        $this->discapacidades = Discapacidad::where('status', true)
            ->orderBy('nombre_discapacidad', 'asc')
            ->get();
    }

    private function cargarAlumno()
    {
        $alumno = Alumno::with('persona.localidad.municipio.estado')->findOrFail($this->alumnoId);
        $persona = $alumno->persona;

        // Datos de persona
        $this->persona_id = $persona->id;
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

    private function cargarDiscapacidades()
    {
        $alumno = \App\Models\Alumno::with('discapacidades')->find($this->alumnoId);

        if ($alumno && $alumno->discapacidades) {
            $this->discapacidadesAlumno = $alumno->discapacidades->map(function ($disc) {
                return [
                    'id' => $disc->id,
                    'nombre' => $disc->nombre_discapacidad
                ];
            })->toArray();
        }
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
        // Copiar discapacidades actuales al array de edición
        $this->discapacidadesAgregadas = $this->discapacidadesAlumno;
    }

    public function cancelarEdicion()
    {
        $this->enModoEdicion = false;
        $this->cargarAlumno();
        $this->cargarDiscapacidades();
        // Limpiar selección de discapacidad
        $this->discapacidadSeleccionada = null;
        $this->resetErrorBag();
    }

    /**
     * Agrega una discapacidad a la lista temporal
     */
    public function agregarDiscapacidad()
    {
        $this->validate([
            'discapacidadSeleccionada' => 'required|exists:discapacidads,id'
        ], [
            'discapacidadSeleccionada.required' => 'Debe seleccionar una discapacidad.',
            'discapacidadSeleccionada.exists' => 'La discapacidad seleccionada no es válida.'
        ]);

        if (collect($this->discapacidadesAgregadas)->contains('id', $this->discapacidadSeleccionada)) {
            $this->addError('discapacidadSeleccionada', 'Esta discapacidad ya ha sido agregada.');
            return;
        }

        $discapacidad = Discapacidad::find($this->discapacidadSeleccionada);

        if ($discapacidad) {
            // Agregar a la lista temporal
            $nueva = [
                'id' => $discapacidad->id,
                'nombre' => $discapacidad->nombre_discapacidad
            ];

            $this->discapacidadesAgregadas[] = $nueva;

            // Guardar en DB
            \App\Models\DiscapacidadEstudiante::updateOrCreate(
                [
                    'alumno_id' => $this->alumnoId,
                    'discapacidad_id' => $discapacidad->id
                ],
                ['status' => true]
            );

            // **Actualizar la lista que se muestra en la vista**
            $this->discapacidadesAlumno[] = $nueva;

            // Limpiar selección
            $this->discapacidadSeleccionada = null;
            $this->resetErrorBag('discapacidadSeleccionada');

            session()->flash('success_temp', 'Discapacidad agregada correctamente.');
        }
    }

    /**
     * Elimina una discapacidad de la lista temporal
     */
    public function eliminarDiscapacidad($index)
    {
        if (isset($this->discapacidadesAgregadas[$index])) {
            $discapacidad = $this->discapacidadesAgregadas[$index];

            // Marcar como inactiva en DB
            \App\Models\DiscapacidadEstudiante::where('alumno_id', $this->alumnoId)
                ->where('discapacidad_id', $discapacidad['id'])
                ->update(['status' => false]);

            // Quitar de las listas temporales y de la vista
            unset($this->discapacidadesAgregadas[$index]);

            // También actualizar la lista mostrada
            $this->discapacidadesAlumno = array_values(
                array_filter($this->discapacidadesAlumno, fn($d) => $d['id'] != $discapacidad['id'])
            );

            // Reindexar
            $this->discapacidadesAgregadas = array_values($this->discapacidadesAgregadas);

            session()->flash('success_temp', "Discapacidad '{$discapacidad['nombre']}' eliminada.");
        }
    }

    /**
     * Guarda las discapacidades del alumno
     */
    private function guardarDiscapacidades()
    {
        // Primero, inactivar todas las discapacidades actuales
        \App\Models\DiscapacidadEstudiante::where('alumno_id', $this->alumnoId)
            ->update(['status' => false]);

        // Luego, agregar o reactivar las discapacidades seleccionadas
        foreach ($this->discapacidadesAgregadas as $discapacidad) {
            \App\Models\DiscapacidadEstudiante::updateOrCreate(
                [
                    'alumno_id' => $this->alumnoId,
                    'discapacidad_id' => $discapacidad['id']
                ],
                [
                    'status' => true
                ]
            );
        }
    }

    public function guardar()
    {
        // Validación básica
        if (!$this->localidad_id) {
            session()->flash('error', 'Debe seleccionar una localidad.');
            return;
        }

        $this->validate();

        try {
            DB::beginTransaction();

            $persona = Persona::findOrFail($this->persona_id);
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
                'estatura' =>  $this->talla_estudiante,
                'lateralidad_id' => $this->lateralidad_id,
                'orden_nacimiento_id' => $this->orden_nacimiento_id,
                'etnia_indigena_id' => $this->etnia_indigena_id,
            ]);

            // Guardar discapacidades
            $this->guardarDiscapacidades();

            DB::commit();

            $this->enModoEdicion = false;
            $this->cargarDiscapacidades(); // Recargar para actualizar la vista
            $this->dispatch('actualizarAlumno');
            session()->flash('success', 'Datos del alumno y discapacidades actualizados correctamente.');
            // Redireccion condicionada
            if ($this->soloEdicion) {
                return redirect()->route('admin.alumnos.index');
            }
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
