<?php

namespace App\Livewire\Admin\Alumnos;

use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Persona;
use App\Models\Alumno;
use Illuminate\Support\Facades\DB;
use App\Models\InstitucionProcedencia;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Localidad;
use App\Models\EtniaIndigena;
use App\Models\Discapacidad;
use App\Models\OrdenNacimiento;
use App\Models\ExpresionLiteraria;
use App\Models\Lateralidad;
class AlumnoCreate extends Component
{
    use WithFileUploads;

    // IDs y referencias
    public $alumno_id;
    public $persona_id;
    
    // Plantel de Procedencia
    public $numero_zonificacion;
    public $institucion_procedencia_id;
    public $expresion_literaria_id;
    public $expresiones_literarias = [];
    public $anio_egreso;
    
    // Datos del Estudiante
    public $tipo_documento_id;
    public $tipos_documentos = [];
    public $numero_documento;
    public $fecha_nacimiento;
    public $edad = 0;
    public $meses = 0;
    public $primer_nombre;
    public $segundo_nombre;
    public $tercer_nombre;
    public $primer_apellido;
    public $segundo_apellido;
    public $genero_id;
    public $generos = [];
    public $lateralidad_id;
    public $lateralidades = [];
    public $orden_nacimiento_id;
    public $orden_nacimientos = [];
    
    // Lugar de Nacimiento
    public $estado_id;
    public $municipio_id;
    public $localidad_id;
    public $estados = [];
    public $municipios = [];
    public $localidades = [];
    
    // Descripciones Físicas
    public $talla_estudiante;
    public $peso_estudiante;
    public $talla_camisa;
    public $talla_zapato;
    public $talla_pantalon;
    
    // Pertenencia Étnica
   /*  public $pertenece_pueblo_indigena = 'no';
    public $cual_pueblo_indigena;
    public $etniasIndigenas = [];  */
    
    // Salud
  /*   public $presenta_discapacidad = 'no';
    public $cual_discapacidad;
    public $discapacidades = [];
    public $direccion; */
    
    // Datos para selects
    public $instituciones;

    protected $listeners = ['pertenecePuebloActualizado' => 'setPertenencia'];

/*     public function setPertenencia($val) {
        $this->pertenece_pueblo_indigena = $val;
    } */

    protected function rules()
    {
        $rules = [
            'institucion_procedencia_id' => 'required|exists:institucion_procedencias,id',
            'expresion_literaria_id' => 'required|exists:expresion_literarias,id',
            'anio_egreso' => [
                'required',
                'date',
                function($attribute, $value, $fail){
                    $anio = \Carbon\Carbon::parse($value)->year;
                    $anioActual = \Carbon\Carbon::now()->year;
                    if ($anio > $anioActual) {
                        $fail('El año de egreso no puede ser mayor al año actual');
                    } elseif ($anio < $anioActual - 7) {
                        $fail('El año de egreso no puede ser menor al año actual menos 7 años');
                    }
                }
            ],
            'tipo_documento_id' => 'required|exists:tipo_documentos,id',
            'numero_documento' => [
                'required',
                'string',
                'max:15',
                'unique:personas,numero_documento' . ($this->persona_id ? ',' . $this->persona_id : '')
            ],
            'fecha_nacimiento' => [
                'required',
                'date',
                'before:today',
                function($attribute, $value, $fail){
                    $fecha = Carbon::parse($value);
                    $edad = $fecha->age;

                    if ($edad < 10 || $edad > 18) {
                        $fail('La edad del alumno debe estar entre 10 y 18 años');
                    } 
                }
            ],
            'primer_nombre' => 'required|string|max:50',
            'primer_apellido' => 'required|string|max:50',
            'genero_id' => 'required|exists:generos,id',
            'lateralidad_id' => 'required|exists:lateralidads,id',
            'orden_nacimiento_id' => 'required|exists:orden_nacimientos,id',
            'estado_id' => 'required|exists:estados,id',
            'municipio_id' => 'required|exists:municipios,id',
            'localidad_id' => 'required|exists:localidads,id',
            'talla_estudiante' => 'required|numeric|between:50,250',
            'peso_estudiante' => 'required|numeric|between:2,300',
            'talla_camisa' => 'required',
            'talla_zapato' => 'required|integer',
            'talla_pantalon' => 'required',/* 
            'pertenece_pueblo_indigena' => 'required|in:si,no',
            'cual_pueblo_indigena' => 'required_if:pertenece_pueblo_indigena,si|nullable|exists:etnia_indigenas,id',
            'presenta_discapacidad' => 'required|in:si,no',
            'cual_discapacidad' => 'required_if:presenta_discapacidad,si|nullable|exists:discapacidads,id',
            'direccion' => 'required|string|max:500', */
        ];

        return $rules;
    }

    protected function messages()
    {
        $messages = [
            'expresion_literaria_id.required' => 'La expresión literaria es obligatoria',
            'anio_egreso.required' => 'El año de egreso es obligatorio',
            'anio_egreso.date' => 'El año de egreso debe ser una fecha',
            'anio_egreso.before' => 'El año de egreso debe ser anterior a la fecha actual',
            'anio_egreso.before_or_equal' => 'El año de egreso debe ser anterior o igual a la fecha actual',
            'tipo_documento_id.required' => 'El tipo de documento es obligatorio',
            'numero_documento.required' => 'El número de documento es obligatorio',
            'numero_documento.string' => 'El número de documento debe ser una cadena de texto',
            'numero_documento.max' => 'El número de documento debe tener un máximo de 8 caracteres',
            'numero_documento.unique' => 'El número de documento ya está registrado',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a la fecha actual',
            'fecha_nacimiento.before_or_equal' => 'La fecha de nacimiento debe ser anterior o igual a la fecha actual',
            'primer_nombre.required' => 'El nombre es obligatorio',
            'primer_nombre.string' => 'El nombre debe ser una cadena de texto',
            'primer_nombre.max' => 'El nombre debe tener un máximo de 50 caracteres',
            'primer_apellido.required' => 'El apellido es obligatorio',
            'primer_apellido.string' => 'El apellido debe ser una cadena de texto',
            'primer_apellido.max' => 'El apellido debe tener un máximo de 50 caracteres',
            'genero_id.required' => 'El género es obligatorio',
            'genero_id.exists' => 'El género no existe',
            'lateralidad_id.required' => 'La lateralidad es obligatoria',
            'lateralidad_id.exists' => 'La lateralidad no existe',
            'orden_nacimiento_id.required' => 'El orden de nacimiento es obligatorio',
            'orden_nacimiento_id.exists' => 'El orden de nacimiento no existe',
            'estado_id.required' => 'El estado es obligatorio',
            'estado_id.exists' => 'El estado no existe',
            'municipio_id.required' => 'El municipio es obligatorio',
            'municipio_id.exists' => 'El municipio no existe',
            'localidad_id.required' => 'La localidad es obligatoria',
            'localidad_id.exists' => 'La localidad no existe',
            'talla_estudiante.between' => 'La estatura debe estar entre 50 y 250 cm',
            'talla_camisa.required' => 'La talla de la camisa es obligatoria',
            'talla_camisa.string' => 'La talla de la camisa debe ser una cadena de texto',
            'talla_zapato.required' => 'La talla del zapato es obligatoria',
            'talla_zapato.integer' => 'La talla del zapato debe ser un número entero',
            'talla_pantalon.required' => 'La talla del pantalón es obligatoria',
            'talla_pantalon.string' => 'La talla del pantalón debe ser una cadena de texto',
            'peso_estudiante.between' => 'El peso debe estar entre 2 y 300 kg',
            'peso_estudiante.numeric' => 'El peso debe ser un número',
            'peso_estudiante.required' => 'El peso es obligatorio',

        ];

        return $messages;
    }

    public function mount($alumno_id = null)
    {
        $this->alumno_id = $alumno_id;
        $this->cargarDatosIniciales();
        
        if ($alumno_id) {
            $this->cargarAlumno($alumno_id);
        }

        $this->expresiones_literarias = \App\Models\ExpresionLiteraria::where('status', true)
            ->orderBy('letra_expresion_literaria', 'asc')
            ->get();

        $this->tipos_documentos = \App\Models\TipoDocumento::where('status', true)->get();
        $this->generos = \App\Models\Genero::where('status', true)->get();
        $this->lateralidades = \App\Models\Lateralidad::where('status', true)->get();
        $this->orden_nacimientos = \App\Models\OrdenNacimiento::where('status', true)->get();/* 
        $this->etniasIndigenas = \App\Models\EtniaIndigena::where('status', true)->get();
        $this->discapacidades = \App\Models\Discapacidad::where('status', true)->get(); */
    }

    public function cargarDatosIniciales()
    {
        $this->instituciones = \App\Models\InstitucionProcedencia::where('status', true)->get();
        $this->estados = \App\Models\Estado::where('status', true)->get();
    }

    public function cargarAlumno($id)
    {
        $alumno = Alumno::with('persona')->findOrFail($id);
        $persona = $alumno->persona;
        
        // Datos de Persona
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
        $this->localidad_id = $persona->localidad_id;
/*         $this->direccion = $persona->direccion;
 */        
        // Datos de Alumno
        $this->numero_zonificacion = $alumno->numero_zonificacion;
        $this->institucion_procedencia_id = $alumno->institucion_procedencia_id;
        $this->expresion_literaria_id = $alumno->expresion_literaria_id;
        $this->anio_egreso = $alumno->anio_egreso->format('Y-m-d');
        $this->talla_camisa = $alumno->talla_camisa;
        $this->talla_pantalon = $alumno->talla_pantalon;
        $this->talla_zapato = $alumno->tallas_zapato;
        $this->peso_estudiante = $alumno->peso;
        $this->talla_estudiante = $alumno->estatura;
        $this->lateralidad_id = $alumno->lateralidad_id;
        $this->orden_nacimiento_id = $alumno->orden_nacimiento_id;/* 
        $this->cual_discapacidad = $alumno->discapacidad_id;
        $this->cual_pueblo_indigena = $alumno->etnia_indigena_id; */
        
        // Actualizar selects dependientes
        $this->updatedEstadoId($persona->localidad->municipio->estado_id);
        $this->updatedMunicipioId($persona->localidad->municipio_id);
        
        // Actualizar banderas
   /*      $this->presenta_discapacidad = $alumno->discapacidad_id ? 'si' : 'no';
        $this->pertenece_pueblo_indigena = $alumno->etnia_indigena_id ? 'si' : 'no'; */
        
        // Calcular edad
        $this->updatedFechaNacimiento($this->fecha_nacimiento);
    }

    public function updatedEstadoId($estadoId)
    {
        $this->municipios = \App\Models\Municipio::where('estado_id', $estadoId)
            ->where('status', true)
            ->orderBy('nombre_municipio')
            ->get();
        $this->municipio_id = null;
        $this->localidad_id = null;
        $this->localidades = [];
    }

    public function updatedMunicipioId($municipioId)
    {
        $this->localidades = \App\Models\Localidad::where('municipio_id', $municipioId)
            ->where('status', true)
            ->orderBy('nombre_localidad')
            ->get();
        $this->localidad_id = null;
    }

    public function updatedFechaNacimiento($value)
    {
        if ($value) {
            try {
                $fechaNacimiento = \Carbon\Carbon::parse($value);
                $hoy = \Carbon\Carbon::now();
                $this->edad = $fechaNacimiento->diffInYears($hoy);
                $this->meses = $fechaNacimiento->diffInMonths($hoy) % 12;
            } catch (\Exception $e) {
                // En caso de error en el formato de fecha
                $this->edad = 0;
                $this->meses = 0;
            }
        }
    }

    public function save()
    {
        $this->validate($this->rules());
 
       /*  \Log::info('Datos del formulario:', [
            'pertenece_pueblo_indigena' => $this->pertenece_pueblo_indigena,
            'cual_pueblo_indigena' => $this->cual_pueblo_indigena,
            'presenta_discapacidad' => $this->presenta_discapacidad,
            'cual_discapacidad' => $this->cual_discapacidad,
        ]); */

        try {   
            DB::beginTransaction();
            
            // Crear o actualizar Persona
            $personaData = [
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
/*                 'direccion' => $this->direccion,
 */                'status' => true,
            ];

            $persona = Persona::updateOrCreate(['id' => $this->persona_id], $personaData);
            
            // Crear o actualizar Alumno
            $alumnoData = [
                'persona_id' => $persona->id,
                'numero_zonificacion' => $this->numero_zonificacion,
                'institucion_procedencia_id' => $this->institucion_procedencia_id,
                'anio_egreso' => $this->anio_egreso,
                'expresion_literaria_id' => $this->expresion_literaria_id,
                'talla_camisa' => $this->talla_camisa,
                'talla_pantalon' => $this->talla_pantalon,
                'tallas_zapato' => $this->talla_zapato,
                'peso' => $this->peso_estudiante,
                'estatura' => $this->talla_estudiante,
                'lateralidad_id' => $this->lateralidad_id,
                'orden_nacimiento_id' => $this->orden_nacimiento_id,/* 
                'discapacidad_id' => $this->presenta_discapacidad === 'si' ? $this->cual_discapacidad : null,
                'etnia_indigena_id' => $this->pertenece_pueblo_indigena === 'si' ? $this->cual_pueblo_indigena : null,  */               
                'status' => 'Activo',
            ];

            $alumno = Alumno::updateOrCreate(['id' => $this->alumno_id], $alumnoData);
            
            DB::commit();
            
            session()->flash('success', 'Alumno guardado exitosamente');
            return redirect()->route('admin.alumnos.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al guardar: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.alumnos.alumno-create');
    }

}