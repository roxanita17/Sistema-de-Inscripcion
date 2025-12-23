<?php

namespace App\Livewire\Admin\Alumnos;

use Illuminate\Support\Collection;


use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

// Modelos
use App\Models\Persona;
use App\Models\Alumno;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Localidad;
use App\Models\OrdenNacimiento;
use App\Models\Lateralidad;
use App\Models\AnioEscolar;
use App\Models\EtniaIndigena;

class AlumnoCreate extends Component
{
    use WithFileUploads;

    /* ============================================================
       ===============   PROPIEDADES DEL COMPONENTE  ===============
       ============================================================ */

    // IDs
    public $alumno_id;
    public $persona_id;

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
    public $talla_camisa;
    public $talla_zapato;
    public $talla_pantalon;

    // Lugar de nacimiento
    public $estado_id;
    public $municipio_id;
    public $localidad_id;

    // Listas para selects
    public $instituciones;
    public $tipos_documentos = [];
    public $generos = [];
    public $lateralidades = [];
    public $lateralidad_id;
    public $orden_nacimiento_id;
    public $orden_nacimientos = [];
    public $estados = [];
    public $municipios = [];
    public $localidades = [];
    public $etnia_indigenas = [];
    public $etnia_indigena_id;

    // Año escolar
    public $anioEscolarActivo = false;


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
            'talla_estudiante' => 'required|numeric|between:0.50,3.00',
            'peso_estudiante' => 'required|numeric|between:2,300',
            'talla_camisa' => 'required',
            'talla_zapato' => 'required|integer',
            'talla_pantalon' => 'required',

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
        'numero_documento.digits_between' => 'La cédula debe tener entre 6 y 8 dígitos',
        'numero_documento.unique' => 'Esta cédula ya está registrada en el sistema',
        'primer_nombre.required' => 'Debe ingresar un nombre',
        'primer_apellido.required' => 'Debe ingresar un apellido',
        'genero_id.required' => 'Debe seleccionar un genero',
        'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
        'fecha_nacimiento.before:today' => 'La edad debe estar entre los 10 y 18 años',
        'talla_estudiante.required' => 'Este campo es requerido',
        'talla_estudiante.numeric' => 'Este campo debe ser un número',
        'talla_estudiante.between' => 'Este campo debe estar entre 0.50 y 3.00',
        'peso_estudiante.required' => 'Este campo es requerido',
        'peso_estudiante.numeric' => 'Este campo debe ser un número',
        'peso_estudiante.between' => 'Este campo debe estar entre 2 y 300',
        'talla_camisa.required' => 'Este campo es requerido',
        'talla_zapato.required' => 'Este campo es requerido',
        'talla_zapato.integer' => 'Este campo debe ser un número',
        'talla_pantalon.required' => 'Este campo es requerido',
        'estado_id.required' => 'Este campo es requerido',
        'municipio_id.required' => 'Este campo es requerido',
        'localidad_id.required' => 'Este campo es requerido',
        'lateralidad_id.required' => 'Este campo es requerido',
        'orden_nacimiento_id.required' => 'Este campo es requerido',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedTipoDocumentoId($value)
    {
        // Limpiar la cédula al cambiar tipo
        $this->numero_documento = null;

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


    /* ============================================================
       ========================   MOUNT   ==========================
       ============================================================ */
    public function mount($alumno_id = null)
    {
        $this->verificarAnioEscolar();
        $this->alumno_id = $alumno_id;

        $this->cargarDatosIniciales();

        if ($alumno_id) {
            $this->cargarAlumno($alumno_id);
        }
    }


    /* ============================================================
       ===================   CARGAS INICIALES   ===================
       ============================================================ */
    private function verificarAnioEscolar()
    {
        // Verifica si hay un año escolar activo o extendido
        $this->anioEscolarActivo = AnioEscolar::whereIn('status', ['Activo', 'Extendido'])->exists();
    }

    public function cargarDatosIniciales()
    {
        // Listas para selects
        $this->estados = Estado::where('status', true)->get();

        $this->tipos_documentos = \App\Models\TipoDocumento::where('status', true)->get();
        $this->generos = \App\Models\Genero::where('status', true)->get();
        $this->lateralidades = Lateralidad::where('status', true)->get();
        $this->orden_nacimientos = OrdenNacimiento::where('status', true)->get();
        $this->etnia_indigenas = EtniaIndigena::where('status', true)->get();
    }


    /* ============================================================
       ======================   CARGA ALUMNO   =====================
       ============================================================ */
    public function cargarAlumno($id)
    {
        $alumno = Alumno::with(
            'persona',

        )->findOrFail($id);
        $persona = $alumno->persona;

        // Datos personales
        $this->persona_id = $persona->id;
        $this->tipo_documento_id = $persona->tipo_documento_id;
        $this->numero_documento = $persona->numero_documento;
        $this->fecha_nacimiento = $persona->fecha_nacimiento->format('Y-m-d');
        $this->primer_nombre = $persona->primer_nombre;
        $this->segundo_nombre = $persona->segundo_nombre;
        $this->tercer_nombre = $persona->tercer_nombre;
        $this->primer_apellido = $persona->primer_apellido;
        $this->segundo_apellido = $persona->segundo_apellido;
        $this->genero_id = $persona->genero_id;

        // Procedencia y datos físicos
        $this->talla_camisa = $alumno->talla_camisa;
        $this->talla_pantalon = $alumno->talla_pantalon;
        $this->talla_zapato = $alumno->talla_zapato;
        $this->peso_estudiante = $alumno->peso;
        $this->talla_estudiante = $alumno->estatura;
        $this->lateralidad_id = $alumno->lateralidad_id;
        $this->orden_nacimiento_id = $alumno->orden_nacimiento_id;
        $this->etnia_indigena_id = $alumno->etnia_indigena_id;

        // Actualiza selects dependientes
        $this->updatedEstadoId($persona->localidad->municipio->estado_id);
        $this->updatedMunicipioId($persona->localidad->municipio_id);

        // Calcula edad
        $this->updatedFechaNacimiento($this->fecha_nacimiento);
    }


    /* ============================================================
       ===============   SELECTS DEPENDIENTES (AJAX)   =============
       ============================================================ */
    public function updatedEstadoId($estadoId)
    {
        $this->municipios = Municipio::where('estado_id', $estadoId)
            ->where('status', true)
            ->orderBy('nombre_municipio')
            ->get();

        $this->municipio_id = null;
        $this->localidad_id = null;
        $this->localidades = [];
    }

    public function updatedMunicipioId($municipioId)
    {
        $this->localidades = Localidad::where('municipio_id', $municipioId)
            ->where('status', true)
            ->orderBy('nombre_localidad')
            ->get();

        $this->localidad_id = null;
    }


    /* ============================================================
       =====================   CALCULAR EDAD   =====================
       ============================================================ */
    public function updatedFechaNacimiento($value)
    {
        if (!$value) return;

        try {
            $fecha = Carbon::parse($value);
            $hoy = Carbon::now();

            $this->edad = $fecha->diffInYears($hoy);
            $this->meses = $fecha->diffInMonths($hoy) % 12;
        } catch (\Exception $e) {
            $this->edad = 0;
            $this->meses = 0;
        }
    }

    public function inscripcionAnterior($anioActualId)
    {
        return $this->inscripcionProsecucions()
            ->where('anio_escolar_id', '!=', $anioActualId)
            ->latest('anio_escolar_id')
            ->first()
            ?? $this->inscripciones()
            ->where('anio_escolar_id', '!=', $anioActualId)
            ->latest('anio_escolar_id')
            ->first();
    }



    /* ============================================================
       ========================   GUARDAR   ========================
       ============================================================ */
    public function save()
    {

        if (!$this->etnia_indigena_id) {
            $this->addError('etnia_indigena_id', 'Debe seleccionar una etnia indígena.');
            return;
        }
        $this->validate();

        try {
            DB::beginTransaction();


            // Guardar persona
            $persona = Persona::updateOrCreate(
                ['id' => $this->persona_id],
                [
                    'primer_nombre' => $this->primer_nombre,
                    'segundo_nombre' => $this->segundo_nombre ?? null,
                    'tercer_nombre' => $this->tercer_nombre ?? null,
                    'primer_apellido' => $this->primer_apellido,
                    'segundo_apellido' => $this->segundo_apellido ?? null,
                    'tipo_documento_id' => $this->tipo_documento_id,
                    'numero_documento' => $this->numero_documento,
                    'genero_id' => $this->genero_id,
                    'fecha_nacimiento' => $this->fecha_nacimiento,
                    'localidad_id' => $this->localidad_id,
                    'status' => true,
                ]
            );

            // Guardar alumno
            if ($this->alumno_id) {

                $alumno = Alumno::findOrFail($this->alumno_id);
                $alumno->update([
                    'persona_id' => $persona->id,
                    'talla_camisa' => $this->talla_camisa,
                    'talla_pantalon' => $this->talla_pantalon,
                    'talla_zapato' => $this->talla_zapato,
                    'peso' => $this->peso_estudiante,
                    'estatura' => (float)$this->talla_estudiante,
                    'lateralidad_id' => $this->lateralidad_id,
                    'orden_nacimiento_id' => $this->orden_nacimiento_id,
                    'etnia_indigena_id' => $this->etnia_indigena_id,
                    'status' => 'Activo',
                ]);
            } else {

                Alumno::create([
                    'persona_id' => $persona->id,
                    'talla_camisa' => $this->talla_camisa,
                    'talla_pantalon' => $this->talla_pantalon,
                    'talla_zapato' => $this->talla_zapato,
                    'peso' => $this->peso_estudiante,
                    'estatura' => (float)$this->talla_estudiante,
                    'lateralidad_id' => $this->lateralidad_id,
                    'orden_nacimiento_id' => $this->orden_nacimiento_id,
                    'etnia_indigena_id' => $this->etnia_indigena_id,
                    'status' => 'Activo',
                ]);
            }

            DB::commit();

            session()->flash('success', 'Alumno guardado exitosamente');
            return redirect()->route('admin.alumnos.index');
        } catch (\Exception $e) {

            DB::rollBack();
            session()->flash('error', 'Error al guardar: ' . $e->getMessage());
        }
    }


    /* ============================================================
       =========   COMUNICACIÓN CON COMPONENTE PADRE   ============
       ============================================================ */
    protected $listeners = [
        'solicitarDatosAlumno' => 'enviarDatosAlumno'
    ];

    public function enviarDatosAlumno()
    {
        // Validar sin guardar en BD
        $datos = $this->validate();

        // Enviar datos al componente padre (Inscripción)
        $this->dispatch('recibirDatosAlumno', datos: $datos);
    }


    /* ============================================================
       =========================   VISTA   =========================
       ============================================================ */
    public function render()
    {
        return view('livewire.admin.alumnos.alumno-create');
    }
}
