<?php

namespace App\Livewire\Admin\Alumnos;

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
use App\Models\ExpresionLiteraria;
use App\Models\Lateralidad;
use App\Models\InstitucionProcedencia;
use App\Models\AnioEscolar;

class AlumnoCreate extends Component
{
    use WithFileUploads;

    /* ============================================================
       ===============   PROPIEDADES DEL COMPONENTE  ===============
       ============================================================ */

    // IDs
    public $alumno_id;
    public $persona_id;

    // Procedencia
    public $numero_zonificacion;
    public $institucion_procedencia_id;
    public $expresion_literaria_id;
    public $anio_egreso;

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
    public $talla_estudiante;
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
    public $expresiones_literarias = [];
    public $lateralidades = [];
    public $lateralidad_id;
    public $orden_nacimiento_id;
    public $orden_nacimientos = [];
    public $estados = [];
    public $municipios = [];
    public $localidades = [];

    // Año escolar
    public $anioEscolarActivo = false;


    /* ============================================================
       =====================   VALIDACIÓN   ========================
       ============================================================ */
    protected function rules()
    {
        return [
            // Procedencia
            'numero_zonificacion' => 'required|numeric',
            'institucion_procedencia_id' => 'required|exists:institucion_procedencias,id',
            'expresion_literaria_id' => 'required|exists:expresion_literarias,id',

            'anio_egreso' => [
                'required',
                'date',
                // Validación personalizada del año
                function ($attribute, $value, $fail) {
                    $anio = Carbon::parse($value)->year;
                    $actual = Carbon::now()->year;

                    if ($anio > $actual) {
                        $fail('El año de egreso no puede ser futuro.');
                    } elseif ($anio < $actual - 7) {
                        $fail('El año de egreso no puede ser menor al año actual menos 7 años.');
                    }
                }
            ],

            // Persona
            'tipo_documento_id' => 'required|exists:tipo_documentos,id',
            'numero_documento' => 'required|string|max:15|unique:personas,numero_documento,' . $this->persona_id,
            'primer_nombre' => 'required|string|max:50',
            'primer_apellido' => 'required|string|max:50',
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
            'talla_estudiante' => 'required|numeric|between:50,250',
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
        ];
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
        $this->instituciones = InstitucionProcedencia::where('status', true)->get();
        $this->estados = Estado::where('status', true)->get();

        $this->expresiones_literarias = ExpresionLiteraria::where('status', true)->orderBy('letra_expresion_literaria')->get();
        $this->tipos_documentos = \App\Models\TipoDocumento::where('status', true)->get();
        $this->generos = \App\Models\Genero::where('status', true)->get();
        $this->lateralidades = Lateralidad::where('status', true)->get();
        $this->orden_nacimientos = OrdenNacimiento::where('status', true)->get();
    }


    /* ============================================================
       ======================   CARGA ALUMNO   =====================
       ============================================================ */
    public function cargarAlumno($id)
    {
        $alumno = Alumno::with('persona')->findOrFail($id);
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
        $this->numero_zonificacion = $alumno->numero_zonificacion;
        $this->institucion_procedencia_id = $alumno->institucion_procedencia_id;
        $this->expresion_literaria_id = $alumno->expresion_literaria_id;
        $this->anio_egreso = $alumno->anio_egreso->format('Y-m-d');

        $this->talla_camisa = $alumno->talla_camisa;
        $this->talla_pantalon = $alumno->talla_pantalon;
        $this->talla_zapato = $alumno->talla_zapato;
        $this->peso_estudiante = $alumno->peso;
        $this->talla_estudiante = $alumno->estatura;
        $this->lateralidad_id = $alumno->lateralidad_id;
        $this->orden_nacimiento_id = $alumno->orden_nacimiento_id;

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


    /* ============================================================
       ========================   GUARDAR   ========================
       ============================================================ */
    public function save()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            // Guardar persona
            $persona = Persona::updateOrCreate(
                ['id' => $this->persona_id],
                [
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
                    'status' => true,
                ]
            );

            // Guardar alumno
            Alumno::updateOrCreate(
                ['id' => $this->alumno_id],
                [
                    'persona_id' => $persona->id,
                    'numero_zonificacion' => $this->numero_zonificacion,
                    'institucion_procedencia_id' => $this->institucion_procedencia_id,
                    'anio_egreso' => $this->anio_egreso,
                    'expresion_literaria_id' => $this->expresion_literaria_id,
                    'talla_camisa' => $this->talla_camisa,
                    'talla_pantalon' => $this->talla_pantalon,
                    'talla_zapato' => $this->talla_zapato,
                    'peso' => $this->peso_estudiante,
                    'estatura' => $this->talla_estudiante,
                    'lateralidad_id' => $this->lateralidad_id,
                    'orden_nacimiento_id' => $this->orden_nacimiento_id,
                    'status' => 'Activo',
                ]
            );

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
