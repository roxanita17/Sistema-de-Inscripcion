<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Estudiante;
use App\Models\Persona;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Estado;
use App\Models\EtniaIndigena;
use App\Models\Institucion;
use App\Models\InstitucionProcedencia;
use App\Models\Localidad;
use App\Models\Municipio;
use App\Models\Parroquia;

class EstudianteController extends Controller
{
    //

    public function estudianteView(){

        return view("admin.estudiante.inicio");
    }



    public function formularioEstudianteView($id = null)
{
    $estados = Estado::with('municipio')->orderBy('nombre_estado')->get();
    $municipios = Municipio::with('localidades')->orderBy('nombre_municipio')->get();
    $parroquias = Localidad::with('municipio.estado')->orderBy('nombre_localidad')->get();

    $instituciones = InstitucionProcedencia::where('status', true)
                               ->orderBy('nombre_institucion', 'asc')
                               ->get();

    $etniasIndigenas = EtniaIndigena::orderBy('nombre', 'asc')->get();

    $estudiante = null;

    if ($id) {
        Log::info("Estudiante para editar con id =>{$id} ");
        $estudiante = Estudiante::with('persona')->find($id);

        if (!$estudiante) {
            Log::error("Estudiante no encontrado con ID: {$id}");
            abort(404, 'Estudiante no encontrado');
        }
    }

    return view("admin.estudiante.formulario", [
        'estados' => $estados,
        'parroquias_cargadas' => $parroquias,
        'municipios' => $municipios,
        'instituciones' => $instituciones,
        'estudiante' => $estudiante,
        'etniasIndigenas' => $etniasIndigenas,
    ]);
}



    // public function save(Request $request){

    //         // Asegurar que siempre retorne JSON
    // if (!$request->wantsJson() && !$request->ajax()) {
    //     return ApiResponse::error('Esta ruta solo acepta peticiones JSON', 400);
    // }

    //     // Mapeo de campos del formulario a columnas del modelo (acepta ambos nombres)
    //     $datosPersona=[
    //         "id"                        => $request->input('id'),
    //         "nombre_uno"                => $request->input('nombre_uno', $request->input('primer-nombre')),
    //         "nombre_dos"                => $request->input('nombre_dos', $request->input('segundo-nombre')),
    //         "apellido_uno"              => $request->input('apellido_uno', $request->input('primer-apellido')),
    //         "apellido_dos"              => $request->input('apellido_dos', $request->input('segundo-apellido')),
    //         "sexo"                      => $request->input('sexo'),
    //         "tipo_cedula_persona"       => $request->input('tipo_cedula_persona', $request->input('tipo-ci')),
    //         "numero_cedula_persona"     => $request->input('numero_cedula_persona', $request->input('cedula')),
    //         "fecha_nacimiento_personas" => $request->input('fecha_nacimiento_personas', $request->input('fechaNacimiento')),
    //         "direccion_persona"         => $request->input('direccion_persona'),
    //         // opcionales de teléfono/lugar si existen
    //         "codigo_telefono_persona"   => $request->input('codigo_telefono_persona'),
    //         "prefijo_telefono_personas" => $request->input('prefijo_telefono_personas'),
    //         "telefono_personas"         => $request->input('telefono_personas'),
    //         "lugar_nacimiento_persona"  => $request->input('lugar_nacimiento_persona'),
    //     ];

    //     // Normalización de radios y selects condicionales
    //     $puebloSiNo = $request->input('pueblo_indigena'); // 'si' | 'no'
    //     $cualPueblo = $request->input('cual_pueblo_indigna', $request->input('pueblo'));
    //     $saludSiNo  = $request->input('salud_estudiante'); // 'si' | 'no'
    //     $cualDiscap = $request->input('discapacidad_estudiante', $request->input('cual_discapacidad'));

    //     // datos de estudiante (mapeados)
    //     $datosEstudiante=[
    //         "estado_id"                   => $request->input('estado_id', $request->input('idEstado')),
    //         "municipio_id"                => $request->input('municipio_id', $request->input('idMunicipio')),
    //         "parroquia_id"                => $request->input('parroquia_id', $request->input('idparroquia')),
    //         "institucion_id"              => $request->input('institucion_id', $request->input('intitucion-procedencia')),
    //         "orden_nacimiento_estudiante" => $request->input('orden_nacimiento_estudiante', $request->input('orden-nacimiento-estudiante')),
    //         'talla_estudiante'             => $request->input('talla_estudiante'),
    //         'peso_estudiante'              => $request->input('peso_estudiante'),
    //         'talla_camisa'                 => $request->input('talla_camisa'),
    //         'talla_zapato'                 => $request->input('talla_zapato'),
    //         'talla_pantalon'               => $request->input('talla_pantalon'),
    //         "cual_pueblo_indigna"         => $puebloSiNo === 'si' ? $cualPueblo : null,
    //         "discapacidad_estudiante"     => $saludSiNo === 'si' ? $cualDiscap : null,
    //         "numero_zonificacion_plantel" => $request->input('numero_zonificacion_plantel', $request->input('numero-zonificacion-plantel')),
    //         "ano_ergreso_estudiante"      => $request->input('ano_ergreso_estudiante', $request->input('año-egreso')),
    //         "expresion_literaria"         => $request->input('expresion_literaria', $request->input('expresion-literaria')),
    //         "lateralidad_estudiante"      => $request->input('lateralidad_estudiante', $request->input('lateralidad-estudiante')),
    //     ];

    //     // Manejo de archivo documentos_estudiante (acepta name="documentos_estudiante" o id formFile)
    //     if ($request->hasFile('documentos_estudiante')) {
    //         $path = $request->file('documentos_estudiante')->store('estudiantes/documentos', 'public');
    //         $datosEstudiante['documentos_estudiante'] = $path;
    //     }

    //     DB::beginTransaction();
    //     try {
    //         $persona=null;
    //         $validarExistenciaEstudiante=Persona::find($datosPersona["id"]);
    //         if($validarExistenciaEstudiante){
    //             $persona=$validarExistenciaEstudiante;
    //         }
    //         else{
    //             $persona=Persona::create($datosPersona);
    //             $persona->save();
    //             $datosEstudiante["persona_id"]=$persona->id;
    //             $persona->estudiante()->create($datosEstudiante);
    //             $persona->estudiante;
    //             DB::commit();
    //             return ApiResponse::success($persona,"Estudiante registrado exitosamente",200);
    //         }

    //         $persona->update($datosPersona);
    //         $persona->estudiante->update($datosEstudiante);
    //         DB::commit();
    //         return ApiResponse::success($persona,"Los datos del estudiante a sido guardado exitosamente",200);
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         Log::error($th);
    //         DB::rollBack();
    //         return ApiResponse::error("Error en el servidor al crear el estudiante",500);
    //     }
    // }


//         public function save(Request $request)
//     {
//         // Validación de campos requeridos
//         $validator = \Validator::make($request->all(), [
//             'nombre_uno' => 'required|string|max:255',
//             'apellido_uno' => 'required|string|max:255',
//             'numero_cedula_persona' => 'required|string|max:8',
//             'tipo_cedula_persona' => 'required|string|in:V,E',
//             'fecha_nacimiento_personas' => 'required|date',
//             'sexo' => 'required|string|in:Masculino,Femenino',
//             'estado_id' => 'required|exists:estados,id',
//             'municipio_id' => 'required|exists:municipios,id',
//             'parroquia_id' => 'required|exists:localidads,id',
//             'institucion_id' => 'required|exists:institucion_procedencias,id',
//             'expresion_literaria' => 'required|string|in:A,B,C',
//             'ano_ergreso_estudiante' => 'required|date',
//             'orden_nacimiento_estudiante' => 'required|integer|between:1,6',
//             'lateralidad_estudiante' => 'required|string|in:izquierda,derecha,ambidiestro',
//             'talla_estudiante' => 'required|integer|between:120,180',
//             'peso_estudiante' => 'required|numeric|between:20,100',
//             'talla_camisa' => 'required|string|in:XS,S,M,L,XL',
//             'talla_zapato' => 'required|integer|between:30,45',
//             'talla_pantalon' => 'required|string|in:XS,S,M,L,XL',
//             'pueblo_indigena_estudiante' => 'required|string|in:si,no',
//             'posee_discapacidad_estudiante' => 'required|string|in:si,no',
//         ], [
//             'required' => 'El campo :attribute es obligatorio.',
//             'exists' => 'El :attribute seleccionado no es válido.',
//             'in' => 'El :attribute seleccionado no es válido.',
//             'between' => 'El :attribute debe estar entre :min y :max.',
//         ]);

//         if ($validator->fails()) {
//             return ApiResponse::error('Error de validación: ' . $validator->errors()->first(), 422);
//         }

//         // Verificar cédula duplicada
//         $cedula = $request->input('numero_cedula_persona');
//         $personaId = $request->input('id');

//         $cedulaExistente = Persona::where('numero_cedula_persona', $cedula);
//         if ($personaId) {
//             $cedulaExistente->where('id', '!=', $personaId);
//         }

//         if ($cedulaExistente->exists()) {
//             return ApiResponse::error('No se puede guardar el estudiante. La cédula ya está registrada en el sistema.', 409);
//         }

//         // Mapeo de campos del formulario a columnas del modelo
//         $datosPersona = [
//             "id"                        => $request->input('id'),
//             "nombre_uno"                => $request->input('nombre_uno'),
//             "nombre_dos"                => $request->input('nombre_dos'),
//             "apellido_uno"              => $request->input('apellido_uno'),
//             "apellido_dos"              => $request->input('apellido_dos'),
//             "sexo"                      => $request->input('sexo'),
//             "tipo_cedula_persona"       => $request->input('tipo_cedula_persona'),
//             "numero_cedula_persona"     => $request->input('numero_cedula_persona'),
//             "fecha_nacimiento_personas" => $request->input('fecha_nacimiento_personas'),
//             "direccion_persona"         => $request->input('direccion_persona'),
//             "codigo_telefono_persona"   => $request->input('codigo_telefono_persona'),
//             "prefijo_telefono_personas" => $request->input('prefijo_telefono_personas'),
//             "telefono_personas"         => $request->input('telefono_personas'),
//             "lugar_nacimiento_persona"  => $request->input('lugar_nacimiento_persona'),
//         ];

//         // Normalización de radios y selects condicionales
//         $puebloSiNo = $request->input('pueblo_indigena_estudiante');
//         $cualPueblo = $request->input('cual_pueblo_indigna');
//         $saludSiNo  = $request->input('posee_discapacidad_estudiante');
//         $cualDiscap = $request->input('discapacidad_estudiante');

//         // Validación condicional para campos que dependen de radios
//         if ($puebloSiNo === 'si' && empty($cualPueblo)) {
//             return ApiResponse::error('Debe seleccionar a qué pueblo indígena pertenece.', 422);
//         }

//         if ($saludSiNo === 'si' && empty($cualDiscap)) {
//             return ApiResponse::error('Debe especificar cuál discapacidad presenta.', 422);
//         }

//         // Datos de estudiante
//         $datosEstudiante = [
//             "estado_id"                   => $request->input('estado_id'),
//             "municipio_id"                => $request->input('municipio_id'),
//             "parroquia_id"                => $request->input('parroquia_id'),
//             "institucion_id"              => $request->input('institucion_id'),
//             "orden_nacimiento_estudiante" => $request->input('orden_nacimiento_estudiante'),
//             'talla_estudiante'            => $request->input('talla_estudiante'),
//             'peso_estudiante'             => $request->input('peso_estudiante'),
//             'talla_camisa'                => $request->input('talla_camisa'),
//             'talla_zapato'                => $request->input('talla_zapato'),
//             'talla_pantalon'              => $request->input('talla_pantalon'),
//             "cual_pueblo_indigna"         => $puebloSiNo === 'si' ? $cualPueblo : null,
//             "discapacidad_estudiante"     => $saludSiNo === 'si' ? $cualDiscap : null,
//             "numero_zonificacion_plantel" => $request->input('numero_zonificacion_plantel'),
//             "ano_ergreso_estudiante"      => $request->input('ano_ergreso_estudiante'),
//             "expresion_literaria"         => $request->input('expresion_literaria'),
//             "lateralidad_estudiante"      => $request->input('lateralidad_estudiante'),
//         ];

//         // Manejo de archivo documentos_estudiante
//         if ($request->hasFile('documentos_estudiante')) {
//             $validator = \Validator::make($request->all(), [
//                 'documentos_estudiante' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
//             ]);

//             if ($validator->fails()) {
//                 return ApiResponse::error('Error en el archivo: ' . $validator->errors()->first(), 422);
//             }

//             $path = $request->file('documentos_estudiante')->store('estudiantes/documentos', 'public');
//             $datosEstudiante['documentos_estudiante'] = $path;
//         }

//         DB::beginTransaction();
//         try {
//             $persona = null;
//             $esEdicion = !empty($datosPersona["id"]);

//             if ($esEdicion) {
//                 // Modo edición
//                 $persona = Persona::find($datosPersona["id"]);
//                 if (!$persona) {
//                     return ApiResponse::error('Persona no encontrada', 404);
//                 }

//                 $persona->update($datosPersona);
                
//                 if ($persona->estudiante) {
//                     $persona->estudiante->update($datosEstudiante);
//                 } else {
//                     $datosEstudiante["persona_id"] = $persona->id;
//                     $persona->estudiante()->create($datosEstudiante);
//                 }

//                 $mensaje = "Los datos del estudiante han sido actualizados exitosamente";
//             } else {
//                 // Modo creación
//                 $persona = Persona::create($datosPersona);
//                 $datosEstudiante["persona_id"] = $persona->id;
//                 $persona->estudiante()->create($datosEstudiante);
//                 $mensaje = "Estudiante registrado exitosamente";
//             }

//             // Cargar relaciones actualizadas
//             $persona->load('estudiante');

//             DB::commit();

//             return ApiResponse::success([
//                 'persona' => $persona,
//                 'estudiante' => $persona->estudiante,
//                 'id' => $persona->estudiante->id
//             ], $mensaje, 200);

//         } catch (\Throwable $th) {
//             DB::rollBack();
//             Log::error('Error al guardar estudiante: ' . $th->getMessage());
//             return ApiResponse::error("Error en el servidor al guardar el estudiante: " . $th->getMessage(), 500);
//         }
//     }

//     // Envoltorios REST para compatibilidad con rutas resource
//     public function store(Request $request): JsonResponse
//     {
//         return $this->save($request);
//     }

//     public function update(Request $request, string $id): JsonResponse
//     {
//         // Forzar id en el payload para reutilizar save
//         $request->merge(['id' => $id]);
//         return $this->save($request);
//     }

//     public function consultar(Request $request):JsonResponse{
//         $estudiante=Estudiante::find($request->id);
//         if(!$estudiante){
//             return ApiResponse::error("Error al consulta el estudiante no a sido encontrado",404);
//         }

//         $estudiante->persona;

//         return ApiResponse::success($estudiante,"Estudiante consultado",200);
//     }

//     // Alias corregido de 'filtar' => 'filtrar'
//     public function filtrar(Request $request){
//         $buscador=$request->buscador;
//         $parroquia_id=$request->parroquia_id;
//         $consulta=Estudiante::query()->with("persona");

//         if($buscador!=""){
//             $consulta=$consulta->whereHas("persona",function($query) use ($buscador){
//                 $query->whereRaw("CONCAT(nombre_uno,' ',nombre_dos,' ',apellido_uno,' ',apellido_dos) LIKE ?", ["%{$buscador}%"])
//                 ->orWhere("numero_cedula_persona","like","%".$buscador."%")
//                 ->orWhere("nombre_uno","like","%".$buscador."%")
//                 ->orWhere("nombre_dos","like","%".$buscador."%")
//                 ->orWhere("apellido_uno","like","%".$buscador."%")
//                 ->orWhere("apellido_dos","like","%".$buscador."%");
//             });
//         }

//         if($parroquia_id!="null"){
//             $consulta=$consulta->where("parroquia_id","=",$parroquia_id);
//         }

//         $respuesta=$consulta->paginate(10);
//         return ApiResponse::success($respuesta,"Estudiante consultado",200);
//     }

//     // Mantener compatibilidad con nombre previo 'filtar'
//     public function filtar(Request $request){
//         return $this->filtrar($request);
//     }

//     public function eliminar(Request $request){
//         DB::beginTransaction();
//         try{
//             // Buscamos al estudiante con la relacion de persona
//             $estudiante = Estudiante::with('persona')->find($request->id);

//             if(!$estudiante){
//                 return ApiResponse::error("Estudiante No Encontrado",404);
//             }

//             // Guardamos la referencia de la persona antes de eliminarla
//             $persona = $estudiante->persona;

//             // Eliminamos el estudiante
//             $estudiante->delete();

//             // Eliminamos tambien a la persona si no se esta utilizando en otras relaciones del sistema
//             $persona->delete();

//             DB::commit();

//             return ApiResponse::success(null,"Estudiante y datos personales han sido eliminados exitosamente",200);

//         }catch(\throwable $th){
//             DB::rollBack();
//             return ApiResponse::error("error al eliminar el estudiante",500);

//         }
//     }

//     public function listar(Request $request): JsonResponse
// {
//     try {
//         $estudiantes = Estudiante::with('persona')
//             ->orderBy('id', 'desc')
//             ->paginate(10);

//         return ApiResponse::success($estudiantes, "Lista de estudiantes obtenida exitosamente", 200);

//     } catch (\Exception $e) {
//         return ApiResponse::error("Error al obtener la lista de estudiantes: " . $e->getMessage(), 500);
//     }
// }

// public function ver(string $id): View
// {
//     $estudiante = Estudiante::with(['persona', 'estado', 'municipio', 'parroquia'])->find($id);

//     if (!$estudiante) {
//         abort(404, 'Estudiante no encontrado');
//     }

//     return view("modules.estudiante.inicio", compact('estudiante'));
// }

// // BUSCAR

// public function buscar(Request $request): JsonResponse
// {
//     $q = trim((string)$request->input('q', ''));

//     $consulta = Estudiante::query()->with('persona');

//     if ($q !== '') {
//         $consulta->whereHas('persona', function($sub) use ($q) {
//             $sub->where('numero_cedula_persona', 'like', "%$q%")
//                 ->orWhere('nombre_uno', 'like', "%$q%")
//                 ->orWhere('nombre_dos', 'like', "%$q%")
//                 ->orWhere('apellido_uno', 'like', "%$q%")
//                 ->orWhere('apellido_dos', 'like', "%$q%")
//                 ->orWhereRaw("CONCAT(nombre_uno,' ',nombre_dos,' ',apellido_uno,' ',apellido_dos) LIKE ?", ["%$q%"]);
//         });
//     }

//     $resultado = $consulta->orderByDesc('id')->paginate(10);
//     return ApiResponse::success($resultado, 'Resultados de búsqueda', 200);
// }



//     public function verificarCedula(Request $request): JsonResponse
// {
//     $cedula = $request->input('cedula');
//     $personaId = $request->input('persona_id');

//     if (!$cedula) {
//         return ApiResponse::error('Debe proporcionar una cédula', 422);
//     }

//     // Buscar persona con la misma cédula
//     $query = Persona::where('numero_cedula_persona', $cedula);

//     if ($personaId) {
//         $query->where('id', '!=', $personaId);
//     }

//     $personaExistente = $query->first();

//     if ($personaExistente) {
//         return ApiResponse::error('Esta cédula ya está registrada en el sistema', 409);
//     }

//     return ApiResponse::success(null, 'Cédula disponible', 200);
// }



    public function save(Request $request)
    {
        // // Validación de campos requeridos
        // $validator = \Validator::make($request->all(), [
        //     'primer_nombre' => 'required|string|max:255',
        //     'segundo_nombre' => 'required|string|max:255',
        //     'numero_cedula_persona' => 'required|string|max:8',
        //     'tipo_cedula_persona' => 'required|string|in:V,E',
        //     'fecha_nacimiento_personas' => 'required|date',
        //     'sexo' => 'required|string|in:Masculino,Femenino',
        //     'estado_id' => 'required|exists:estados,id',
        //     'municipio_id' => 'required|exists:municipios,id',
        //     'localidad_id' => 'required|exists:localidads,id',
        //     'institucion_id' => 'required|exists:institucion_procedencias,id',
        //     'expresion_literaria' => 'required|string|in:A,B,C',
        //     'ano_ergreso_estudiante' => 'required|date',
        //     'orden_nacimiento_estudiante' => 'required|integer|between:1,6',
        //     'lateralidad_estudiante' => 'required|string|in:izquierda,derecha,ambidiestro',
        //     'talla_estudiante' => 'required|integer|between:120,180',
        //     'peso_estudiante' => 'required|numeric|between:20,100',
        //     'talla_camisa' => 'required|string|in:XS,S,M,L,XL',
        //     'talla_zapato' => 'required|integer|between:30,45',
        //     'talla_pantalon' => 'required|string|in:XS,S,M,L,XL',
        //     'pueblo_indigena_estudiante' => 'required|string|in:si,no',
        //     'posee_discapacidad_estudiante' => 'required|string|in:si,no',
        // ], [
        //     'required' => 'El campo :attribute es obligatorio.',
        //     'exists' => 'El :attribute seleccionado no es válido.',
        //     'in' => 'El :attribute seleccionado no es válido.',
        //     'between' => 'El :attribute debe estar entre :min y :max.',
        // ]);

        // Validación de campos requeridos - ACEPTAR AMBOS NOMBRES
    $validator = \Validator::make($request->all(), [
        'nombre_uno' => 'required_without:primer-nombre|string|max:255',
        'primer-nombre' => 'required_without:nombre_uno|string|max:255',
        'apellido_uno' => 'required_without:primer-apellido|string|max:255',
        'primer-apellido' => 'required_without:apellido_uno|string|max:255',
        'numero_cedula_persona' => 'required_without_all:cedula,numero_documento|string|max:12',
        'cedula' => 'required_without_all:numero_cedula_persona,numero_documento|string|max:12',
        'numero_documento' => 'required_without_all:numero_cedula_persona,cedula|string|max:12',
        'tipo_documento_id' => 'required_without_all:tipo-ci,tipo_ci,tipo_documento|exists:tipo_documentos,id',
        'tipo-ci' => 'required_without_all:tipo_documento_id,tipo_ci,tipo_documento|string',
        'tipo_ci' => 'required_without_all:tipo_documento_id,tipo-ci,tipo_documento|string',
        'tipo_documento' => 'sometimes|string',
        'fecha_nacimiento_personas' => 'required_without:fechaNacimiento|date',
        'fechaNacimiento' => 'required_without:fecha_nacimiento_personas|date',
        'sexo' => 'required|string|in:Masculino,Femenino',
        'estado_id' => 'required_without:idEstado|exists:estados,id',
        'idEstado' => 'required_without:estado_id|exists:estados,id',
        'municipio_id' => 'required_without:idMunicipio|exists:municipios,id',
        'idMunicipio' => 'required_without:municipio_id|exists:municipios,id',
        'localidad_id' => 'required_without_all:parroquia_id,idparroquia|exists:localidads,id',
        'parroquia_id' => 'required_without_all:localidad_id,idparroquia|exists:localidads,id',
        'idparroquia' => 'required_without_all:localidad_id,parroquia_id|exists:localidads,id',
        'institucion_id' => 'required_without:intitucion-procedencia|exists:institucion_procedencias,id',
        'intitucion-procedencia' => 'required_without:institucion_id|exists:institucion_procedencias,id',
        'expresion_literaria' => 'required_without:expresion-literaria|string',
        'expresion-literaria' => 'required_without:expresion_literaria|string',
        'ano_ergreso_estudiante' => 'required_without:año-egreso|date',
        'año-egreso' => 'required_without:ano_ergreso_estudiante|date',
        'orden_nacimiento_estudiante' => 'required_without_all:orden-nacimiento-estudiante,orden_nacimiento,orden-nacimiento|integer|between:1,6',
        'orden-nacimiento-estudiante' => 'required_without_all:orden_nacimiento_estudiante,orden_nacimiento,orden-nacimiento|integer|between:1,6',
        'orden_nacimiento' => 'required_without_all:orden_nacimiento_estudiante,orden-nacimiento-estudiante,orden-nacimiento|integer|between:1,6',
        'orden-nacimiento' => 'required_without_all:orden_nacimiento_estudiante,orden-nacimiento-estudiante,orden_nacimiento|integer|between:1,6',
        'lateralidad_estudiante' => 'required_without:lateralidad-estudiante|string|in:izquierda,derecha,ambidiestro',
        'lateralidad-estudiante' => 'required_without:lateralidad_estudiante|string|in:izquierda,derecha,ambidiestro',
        'talla_estudiante' => 'required|integer|between:120,180',
        'peso_estudiante' => 'required|numeric|between:20,100',
        'talla_camisa' => 'required|string|in:XS,S,M,L,XL',
        'talla_zapato' => 'required|integer|between:30,45',
        'talla_pantalon' => 'required|string|in:XS,S,M,L,XL',
        'pueblo_indigena_estudiante' => 'required_without:pueblo_indigena|string|in:si,no',
        'pueblo_indigena' => 'required_without:pueblo_indigena_estudiante|string|in:si,no',
        'posee_discapacidad_estudiante' => 'required_without:salud_estudiante|string|in:si,no',
        'salud_estudiante' => 'required_without:posee_discapacidad_estudiante|string|in:si,no',
    ], [
        'required' => 'El campo :attribute es obligatorio.',
        'required_without' => 'El campo :attribute es obligatorio.',
        'exists' => 'El :attribute seleccionado no es válido.',
        'in' => 'El :attribute seleccionado no es válido.',
        'between' => 'El :attribute debe estar entre :min y :max.',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'Error de validación: ' . $validator->errors()->first()
        ], 422);
    }

    // Mapeo de Persona al esquema real del proyecto (Personas)
    // Acepta nombres alternos del formulario y los normaliza a columnas reales
    $numeroDocumento = $request->input('numero_documento', $request->input('numero_cedula_persona', $request->input('cedula')));
    $fechaNac        = $request->input('fecha_nacimiento', $request->input('fecha_nacimiento_personas', $request->input('fechaNacimiento')));
    $primerNombre    = $request->input('primer_nombre', $request->input('nombre_uno', $request->input('primer-nombre')));
    $segundoNombre   = $request->input('segundo_nombre', $request->input('nombre_dos', $request->input('segundo-nombre')));
    $tercerNombre    = $request->input('tercer_nombre', $request->input('nombre_tres', $request->input('tercer-nombre')));
    $primerApellido  = $request->input('primer_apellido', $request->input('apellido_uno', $request->input('primer-apellido')));
    $segundoApellido = $request->input('segundo_apellido', $request->input('apellido_dos', $request->input('segundo-apellido')));
    $direccion       = $request->input('direccion', $request->input('direccion_persona'));
    $localidadId     = $request->input('localidad_id', $request->input('parroquia_id', $request->input('idparroquia')));
    $estadoId        = $request->input('estado_id', $request->input('idEstado'));
    $municipioId     = $request->input('municipio_id', $request->input('idMunicipio'));
    $institucionId   = $request->input('institucion_id', $request->input('intitucion-procedencia'));
    // Normalizar orden de nacimiento desde múltiples aliases
    $ordenNacimiento = $request->input('orden_nacimiento_estudiante',
                        $request->input('orden-nacimiento-estudiante',
                        $request->input('orden_nacimiento',
                        $request->input('orden-nacimiento'))));
    $ordenNacimiento = is_null($ordenNacimiento) ? null : (int)$ordenNacimiento;
    // Normalizar año/fecha de egreso desde múltiples aliases (con y sin acento)
    $anoEgreso = $request->input('ano_ergreso_estudiante',
                  $request->input('año-egreso',
                  $request->input('ano-egreso')));

    // Resolver genero_id a partir de 'sexo' si no viene genero_id
    $generoId = $request->input('genero_id');
    if (!$generoId && $request->filled('sexo')) {
        $genero = \App\Models\Genero::where('genero', $request->input('sexo'))->first();
        if ($genero) { $generoId = $genero->id; }
    }

    // Asegurar tipo_documento_id: si no viene, resolver por 'tipo-ci' (V/E)
    $tipoDocumentoId = $request->input('tipo_documento_id');
    $tipoEntrada = $request->input('tipo-ci', $request->input('tipo_ci', $request->input('tipo_documento')));
    if (!$tipoDocumentoId && $tipoEntrada) {
        $tipoCiValor = strtoupper(trim((string)$tipoEntrada));
        // Tomamos el primer carácter para V/E
        $pref = strlen($tipoCiValor) > 0 ? substr($tipoCiValor, 0, 1) : '';
        // 1) Búsqueda exacta por 'V' o 'E'
        $td = $pref ? \App\Models\TipoDocumento::where('tipo_documento', $pref)->first() : null;
        // 2) Si no, búsqueda por prefijo (V%, E%) para valores como 'Venezolano'/'Extranjero'
        if (!$td && $pref) {
            $td = \App\Models\TipoDocumento::where('tipo_documento', 'like', $pref.'%')->first();
        }
        // 3) alias comunes por si el catálogo usa nombres completos
        if (!$td && $pref === 'V') {
            $td = \App\Models\TipoDocumento::whereIn('tipo_documento', ['V', 'VENEZOLANO', 'Venezolano'])->first();
        }
        if (!$td && $pref === 'E') {
            $td = \App\Models\TipoDocumento::whereIn('tipo_documento', ['E', 'EXTRANJERO', 'Extranjero'])->first();
        }
        // 4) Fallback: si no existe en catálogo y es V/E, crearlo para no bloquear el guardado
        if (!$td && in_array($pref, ['V','E'])) {
            $td = \App\Models\TipoDocumento::create([
                'tipo_documento' => $pref,
                'status' => true,
            ]);
        }
        if ($td) { $tipoDocumentoId = $td->id; }
    }
    // Si aún no hay tipo_documento_id, detener con 422 para evitar NOT NULL e informar valores disponibles
    if (!$tipoDocumentoId) {
        $disponibles = \App\Models\TipoDocumento::pluck('tipo_documento','id');
        return response()->json([
            'success' => false,
            'message' => 'No se pudo determinar el tipo de documento. Envíe "tipo_documento_id" válido o "tipo-ci" (V/E) que exista en tipo_documentos.',
            'tipos_disponibles' => $disponibles,
        ], 422);
    }

    $datosPersona = [
        'id'               => $request->input('id'),
        'primer_nombre'    => $primerNombre,
        'segundo_nombre'   => $segundoNombre,
        'tercer_nombre'    => $tercerNombre,
        'primer_apellido'  => $primerApellido,
        'segundo_apellido' => $segundoApellido,
        'numero_documento' => $numeroDocumento,
        'fecha_nacimiento' => $fechaNac,
        'direccion'        => $direccion,
        'localidad_id'     => $localidadId,
    ];
    if ($generoId) { $datosPersona['genero_id'] = $generoId; }
    if ($tipoDocumentoId) {
        $datosPersona['tipo_documento_id'] = $tipoDocumentoId;
    } elseif ($request->filled('tipo_documento_id')) {
        $datosPersona['tipo_documento_id'] = $request->input('tipo_documento_id');
    }

    // Normalización de radios y selects condicionales - ACEPTAR AMBOS NOMBRES
    $puebloSiNo = $request->input('pueblo_indigena_estudiante', $request->input('pueblo_indigena'));
    $cualPueblo = $request->input('cual_pueblo_indigna', $request->input('pueblo'));
    $saludSiNo  = $request->input('posee_discapacidad_estudiante', $request->input('salud_estudiante'));
    $cualDiscap = $request->input('discapacidad_estudiante', $request->input('cual_discapacidad'));

    // Validación condicional para campos que dependen de radios
    if ($puebloSiNo === 'si' && empty($cualPueblo)) {
        return response()->json([
            'success' => false,
            'message' => 'Debe seleccionar a qué pueblo indígena pertenece.'
        ], 422);
    }

    if ($saludSiNo === 'si' && empty($cualDiscap)) {
        return response()->json([
            'success' => false,
            'message' => 'Debe especificar cuál discapacidad presenta.'
        ], 422);
    }

    // Validar que las llaves foráneas principales existan tras la normalización
    if (empty($estadoId) || empty($municipioId) || empty($localidadId) || empty($institucionId)) {
        return response()->json([
            'success' => false,
            'message' => 'Faltan datos requeridos: estado, municipio, localidad o institución.'
        ], 422);
    }
    // Validar orden de nacimiento (1..6)
    if (empty($ordenNacimiento) || $ordenNacimiento < 1 || $ordenNacimiento > 6) {
        return response()->json([
            'success' => false,
            'message' => 'El orden de nacimiento es obligatorio y debe estar entre 1 y 6.'
        ], 422);
    }
    // Validar año/fecha de egreso (requerido)
    if (empty($anoEgreso)) {
        return response()->json([
            'success' => false,
            'message' => 'La fecha de egreso es obligatoria.'
        ], 422);
    }

    // Datos de estudiante - ACEPTAR AMBOS NOMBRES
    $datosEstudiante = [
        "estado_id"                   => $estadoId,
        "municipio_id"                => $municipioId,
        "localidad_id"                => $localidadId,
        "institucion_id"              => $institucionId,
        "orden_nacimiento_estudiante" => $ordenNacimiento,
        'talla_estudiante'            => $request->input('talla_estudiante'),
        'peso_estudiante'             => $request->input('peso_estudiante'),
        'talla_camisa'                => $request->input('talla_camisa'),
        'talla_zapato'                => $request->input('talla_zapato'),
        'talla_pantalon'              => $request->input('talla_pantalon'),
        "cual_pueblo_indigna"         => $puebloSiNo === 'si' ? $cualPueblo : null,
        "discapacidad_estudiante"     => $saludSiNo === 'si' ? $cualDiscap : null,
        "numero_zonificacion_plantel" => $request->input('numero_zonificacion_plantel', $request->input('numero-zonificacion-plantel')),
        "ano_ergreso_estudiante"      => $anoEgreso,
        "expresion_literaria"         => $request->input('expresion_literaria', $request->input('expresion-literaria')),
        "lateralidad_estudiante"      => $request->input('lateralidad_estudiante', $request->input('lateralidad-estudiante')),
    ];


        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . $validator->errors()->first()
            ], 422);
        }

        // Verificar documento duplicado contra columna real numero_documento
        $doc = $request->input('numero_documento', $request->input('numero_cedula_persona', $request->input('cedula')));
        $personaId = $request->input('id');

        $docExistente = Persona::where('numero_documento', $doc);
        if ($personaId) {
            $docExistente->where('id', '!=', $personaId);
        }

        if ($docExistente->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede guardar el estudiante. El documento ya está registrado en el sistema.'
            ], 409);
        }

        // $datosPersona ya fue construido más arriba con el esquema real (numero_documento, primer_nombre, etc.)
        $datosPersona = $datosPersona;

        // Normalización de radios y selects condicionales
        $puebloSiNo = $request->input('pueblo_indigena_estudiante');
        $cualPueblo = $request->input('cual_pueblo_indigna');
        $saludSiNo  = $request->input('posee_discapacidad_estudiante');
        $cualDiscap = $request->input('discapacidad_estudiante');

        // Validación condicional para campos que dependen de radios
        if ($puebloSiNo === 'si' && empty($cualPueblo)) {
            return response()->json([
                'success' => false,
                'message' => 'Debe seleccionar a qué pueblo indígena pertenece.'
            ], 422);
        }

        if ($saludSiNo === 'si' && empty($cualDiscap)) {
            return response()->json([
                'success' => false,
                'message' => 'Debe especificar cuál discapacidad presenta.'
            ], 422);
        }

        // Datos de estudiante
        $datosEstudiante = [
            "estado_id"                   => $estadoId,
            "municipio_id"                => $municipioId,
            "localidad_id"                => $localidadId,
            "institucion_id"              => $institucionId,
            "orden_nacimiento_estudiante" => $ordenNacimiento,
            'talla_estudiante'            => $request->input('talla_estudiante'),
            'peso_estudiante'             => $request->input('peso_estudiante'),
            'talla_camisa'                => $request->input('talla_camisa'),
            'talla_zapato'                => $request->input('talla_zapato'),
            'talla_pantalon'              => $request->input('talla_pantalon'),
            "cual_pueblo_indigna"         => $puebloSiNo === 'si' ? $cualPueblo : null,
            "discapacidad_estudiante"     => $saludSiNo === 'si' ? $cualDiscap : null,
            "numero_zonificacion_plantel" => $request->input('numero_zonificacion_plantel', $request->input('numero-zonificacion-plantel')),
            "ano_ergreso_estudiante"      => $anoEgreso,
            "expresion_literaria"         => $request->input('expresion_literaria', $request->input('expresion-literaria')),
            "lateralidad_estudiante"      => $request->input('lateralidad_estudiante', $request->input('lateralidad-estudiante')),
        ];

        // Manejo de archivo documentos_estudiante
        if ($request->hasFile('documentos_estudiante')) {
            $fileValidator = \Validator::make($request->all(), [
                'documentos_estudiante' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            ]);

            if ($fileValidator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error en el archivo: ' . $fileValidator->errors()->first()
                ], 422);
            }

            $path = $request->file('documentos_estudiante')->store('estudiantes/documentos', 'public');
            $datosEstudiante['documentos_estudiante'] = $path;
        }

        DB::beginTransaction();
        try {
            $persona = null;
            $esEdicion = !empty($datosPersona["id"]);

            if ($esEdicion) {
                // Modo edición
                $persona = Persona::find($datosPersona["id"]);
                if (!$persona) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Persona no encontrada'
                    ], 404);
                }

                $persona->update($datosPersona);

                // Actualizar o crear Estudiante por persona_id
                $estudiante = Estudiante::firstOrNew(['persona_id' => $persona->id]);
                $estudiante->fill($datosEstudiante);
                $estudiante->persona_id = $persona->id;
                $estudiante->save();

                $mensaje = "Los datos del estudiante han sido actualizados exitosamente";
            } else {
                // Modo creación
                $persona = Persona::create($datosPersona);
                $estudiante = new Estudiante($datosEstudiante);
                $estudiante->persona_id = $persona->id;
                $estudiante->save();
                $mensaje = "Estudiante registrado exitosamente";
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $mensaje,
                'data' => [
                    'persona' => $persona,
                    'estudiante' => $estudiante,
                    'id' => $estudiante->id
                ]
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error al guardar estudiante: ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Error en el servidor al guardar el estudiante: " . $th->getMessage()
            ], 500);
        }
    }

    // Envoltorios REST para compatibilidad con rutas resource
    public function store(Request $request): JsonResponse
    {
        return $this->save($request);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $request->merge(['id' => $id]);
        return $this->save($request);
    }

    public function consultar(Request $request): JsonResponse
    {
        $estudiante = Estudiante::with('persona')->find($request->id);
        if (!$estudiante) {
            return response()->json([
                'success' => false,
                'message' => "Error al consultar el estudiante no ha sido encontrado"
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => "Estudiante consultado",
            'data' => $estudiante
        ], 200);
    }

    public function filtrar(Request $request)
    {
        $buscador = $request->buscador;

        $respuesta = $consulta->paginate(10);
        return response()->json([
            'success' => true,
            'message' => "Estudiantes consultados",
            'data' => $respuesta
        ], 200);
    }

    // Mantener compatibilidad con nombre previo 'filtar'
    public function filtar(Request $request)
    {
        return $this->filtrar($request);
    }

    public function eliminar(Request $request)
    {
        DB::beginTransaction();
        try {
            $estudiante = Estudiante::with('persona')->find($request->id);

            if (!$estudiante) {
                return response()->json([
                    'success' => false,
                    'message' => "Estudiante No Encontrado"
                ], 404);
            }

            $persona = $estudiante->persona;
            $estudiante->delete();
            $persona->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Estudiante y datos personales han sido eliminados exitosamente"
            ], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Error al eliminar estudiante: ' . $th->getMessage());
            return response()->json([
                'success' => false,
                'message' => "Error al eliminar el estudiante"
            ], 500);
        }
    }

    public function listar(Request $request): JsonResponse
    {
        try {
            $estudiantes = Estudiante::with('persona')
                ->orderBy('id', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'message' => "Lista de estudiantes obtenida exitosamente",
                'data' => $estudiantes
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Error al obtener la lista de estudiantes: " . $e->getMessage()
            ], 500);
        }
    }

    public function ver(string $id): View
    {
        $estudiante = Estudiante::with(['persona', 'estado', 'municipio', 'parroquia'])->find($id);

        if (!$estudiante) {
            abort(404, 'Estudiante no encontrado');
        }

        return view("modules.estudiante.inicio", compact('estudiante'));
    }

    public function buscar(Request $request): JsonResponse
    {
        $q = trim((string)$request->input('q', ''));

        $consulta = Estudiante::query()->with('persona');

        if ($q !== '') {
            $consulta->whereHas('persona', function($sub) use ($q) {
                $sub->where('numero_documento', 'like', "%$q%")
                    ->orWhere('primer_nombre', 'like', "%$q%")
                    ->orWhere('segundo_nombre', 'like', "%$q%")
                    ->orWhere('primer_apellido', 'like', "%$q%")
                    ->orWhere('segundo_apellido', 'like', "%$q%")
                    ->orWhereRaw("CONCAT(primer_nombre,' ',segundo_nombre,' ',tercer_nombre,' ',primer_apellido,' ',segundo_apellido) LIKE ?", ["%$q%"]);
            });
        }

        $resultado = $consulta->orderByDesc('id')->paginate(10);
        return response()->json([
            'success' => true,
            'message' => 'Resultados de búsqueda',
            'data' => $resultado
        ], 200);
    }

    public function verificarCedula(Request $request): JsonResponse
    {
        $doc = $request->input('numero_documento', $request->input('cedula'));
        $personaId = $request->input('persona_id');

        if (!$doc) {
            return response()->json([
                'success' => false,
                'message' => 'Debe proporcionar un número de documento'
            ], 422);
        }

        $query = Persona::where('numero_documento', $doc);
        if ($personaId) {
            $query->where('id', '!=', $personaId);
        }

        $personaExistente = $query->first();
        if ($personaExistente) {
            return response()->json([
                'success' => false,
                'message' => 'Este documento ya está registrado en el sistema'
            ], 409);
        }

        return response()->json([
            'success' => true,
            'message' => 'Documento disponible'
        ], 200);
    }
}
