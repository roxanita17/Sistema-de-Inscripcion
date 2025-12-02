<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AnioEscolarController;
use App\Http\Controllers\RepresentanteController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\EtniaIndigenaController;
use App\Http\Controllers\OcupacionController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\AreaFormacionController;
use App\Http\Controllers\ExpresionLiterariaController;
use App\Http\Controllers\DiscapacidadController;
use App\Http\Controllers\GradoAreaFormacionController;
use App\Http\Controllers\PrefijoTelefonoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EstudiosRealizadoController;
use App\Http\Controllers\AreaEstudioRealizadoController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\NuevoIngresoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\DocenteAreaGradoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\EntradasPercentilController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ============================================
// RUTAS PROTEGIDAS POR AUTENTICACIÓN
// ============================================

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // ===== AÑO ESCOLAR (SIEMPRE ACCESIBLE - SIN VERIFICACIÓN) =====
    Route::get('anio_escolar', [AnioEscolarController::class, 'index'])->name('anio_escolar.index');
    Route::post('anio_escolar/modales/store', [AnioEscolarController::class, 'store'])->name('anio_escolar.modales.store');
    Route::post('anio_escolar/{id}/extender', [AnioEscolarController::class, 'extender'])->name('anio_escolar.modales.extender');
    Route::delete('anio_escolar/{id}', [AnioEscolarController::class, 'destroy'])->name('anio_escolar.destroy');

    // ===== BANCOS =====
    Route::get('banco', [BancoController::class, 'index'])->name('banco.index');

    Route::middleware(['verificar.anio.escolar'])->group(function () {
        Route::post('banco/modales/store', [BancoController::class, 'store'])->name('banco.modales.store');
        Route::post('banco/{id}/update', [BancoController::class, 'update'])->name('banco.modales.update');
        Route::delete('banco/{id}', [BancoController::class, 'destroy'])->name('banco.destroy');
    });

    // ===== ETNIA INDÍGENA =====
    Route::get('etnia_indigena', [EtniaIndigenaController::class, 'index'])->name('etnia_indigena.index');

    Route::middleware(['verificar.anio.escolar'])->group(function () {
        Route::post('etnia_indigena/modales/store', [EtniaIndigenaController::class, 'store'])->name('etnia_indigena.modales.store');
        Route::post('etnia_indigena/{id}/update', [EtniaIndigenaController::class, 'update'])->name('etnia_indigena.modales.update');
        Route::delete('etnia_indigena/{id}', [EtniaIndigenaController::class, 'destroy'])->name('etnia_indigena.destroy');
    });

    // ===== OCUPACIÓN =====
    Route::get('ocupacion', [OcupacionController::class, 'index'])->name('ocupacion.index');

    Route::middleware(['verificar.anio.escolar'])->group(function () {
        Route::post('ocupacion/modales/store', [OcupacionController::class, 'store'])->name('ocupacion.modales.store');
        Route::post('ocupacion/{id}/update', [OcupacionController::class, 'update'])->name('ocupacion.modales.update');
        Route::delete('ocupacion/{id}', [OcupacionController::class, 'destroy'])->name('ocupacion.destroy');
    });

    // ===== ESTADO (LIVEWIRE) =====
    Route::get('estado', function () {
        return view('admin.estado.index', [
            'anioEscolarActivo' => \App\Models\AnioEscolar::activos()
                ->where('cierre_anio_escolar', '>=', now())
                ->exists()
        ]);
    })->name('estado.index');

    // ===== MUNICIPIO (LIVEWIRE) =====
    Route::get('municipio', function () {
        return view('admin.municipio.index', [
            'anioEscolarActivo' => \App\Models\AnioEscolar::activos()
                ->where('cierre_anio_escolar', '>=', now())
                ->exists()
        ]);
    })->name('municipio.index');

    // ===== LOCALIDAD (LIVEWIRE) =====
    Route::get('localidad', function () {
        return view('admin.localidad.index', [
            'anioEscolarActivo' => \App\Models\AnioEscolar::activos()
                ->where('cierre_anio_escolar', '>=', now())
                ->exists()
        ]);
    })->name('localidad.index');

    // ===== INSTITUCIÓN DE PROCEDENCIA (LIVEWIRE)=====
    Route::get('institucion_procedencia', function () {
        return view('admin.institucion_procedencia.index', [
            'anioEscolarActivo' => \App\Models\AnioEscolar::activos()
                ->where('cierre_anio_escolar', '>=', now())
                ->exists()
        ]);
    })->name('institucion_procedencia.index');


    // ===== GRADO =====
    Route::get('grado', [GradoController::class, 'index'])->name('grado.index');

    Route::middleware(['verificar.anio.escolar'])->group(function () {
        Route::post('grado/modales/store', [GradoController::class, 'store'])->name('grado.modales.store');
        Route::post('grado/{id}/update', [GradoController::class, 'update'])->name('grado.modales.update');
        Route::delete('grado/{id}', [GradoController::class, 'destroy'])->name('grado.destroy');
    });

    // ===== ÁREA DE FORMACIÓN =====
    Route::get('area_formacion', [AreaFormacionController::class, 'index'])->name('area_formacion.index');

    Route::middleware(['verificar.anio.escolar'])->group(function () {
        Route::post('area_formacion/modales/store', [AreaFormacionController::class, 'store'])->name('area_formacion.modales.store');
        Route::post('area_formacion/{id}/update', [AreaFormacionController::class, 'update'])->name('area_formacion.modales.update');
        Route::delete('area_formacion/{id}', [AreaFormacionController::class, 'destroy'])->name('area_formacion.destroy');
    });

    // ===== GRUPO ESTABLE =====
    Route::middleware(['verificar.anio.escolar'])->group(function () {
        Route::post('area_formacion/modalesGrupoEstable/storeGrupoEstable', [AreaFormacionController::class, 'storeGrupoEstable'])->name('area_formacion.modalesGrupoEstable.storeGrupoEstable');
        Route::post('area_formacion/{id}/updateGrupoEstable', [AreaFormacionController::class, 'updateGrupoEstable'])->name('area_formacion.modalesGrupoEstable.updateGrupoEstable');
        Route::delete('grupo_estable/{id}', [AreaFormacionController::class, 'destroyGrupoEstable'])->name('area_formacion.modalesGrupoEstable.destroyGrupoEstable');
    });

    // ===== EXPRESIÓN LITERARIA =====
    Route::get('expresion_literaria', [ExpresionLiterariaController::class, 'index'])->name('expresion_literaria.index');

    Route::middleware(['verificar.anio.escolar'])->group(function () {
        Route::post('expresion_literaria/modales/store', [ExpresionLiterariaController::class, 'store'])->name('expresion_literaria.modales.store');
        Route::post('expresion_literaria/{id}/update', [ExpresionLiterariaController::class, 'update'])->name('expresion_literaria.modales.update');
        Route::delete('expresion_literaria/{id}', [ExpresionLiterariaController::class, 'destroy'])->name('expresion_literaria.destroy');
    });

    // ===== DISCAPACIDAD =====
    Route::get('discapacidad', [DiscapacidadController::class, 'index'])->name('discapacidad.index');

    Route::middleware(['verificar.anio.escolar'])->group(function () {
        Route::post('discapacidad/modales/store', [DiscapacidadController::class, 'store'])->name('discapacidad.modales.store');
        Route::post('discapacidad/{id}/update', [DiscapacidadController::class, 'update'])->name('discapacidad.modales.update');
        Route::delete('discapacidad/{id}', [DiscapacidadController::class, 'destroy'])->name('discapacidad.destroy');
    });

    // ===== GRADO ÁREA FORMACIÓN (TRANSACCIÓN) =====
    Route::get('transacciones/grado_area_formacion', [GradoAreaFormacionController::class, 'index'])->name('transacciones.grado_area_formacion.index');

    Route::middleware(['verificar.anio.escolar'])->group(function () {
        Route::post('transacciones/grado_area_formacion/modales/store', [GradoAreaFormacionController::class, 'store'])->name('transacciones.grado_area_formacion.modales.store');
        Route::post('transacciones/grado_area_formacion/{id}/update', [GradoAreaFormacionController::class, 'update'])->name('transacciones.grado_area_formacion.modales.update');
        Route::delete('transacciones/grado_area_formacion/{id}', [GradoAreaFormacionController::class, 'destroy'])->name('transacciones.grado_area_formacion.destroy');
    });

    // ===== PREFIJO DE TELÉFONO =====
    Route::get('prefijo_telefono', [PrefijoTelefonoController::class, 'index'])->name('prefijo_telefono.index');

    Route::middleware(['verificar.anio.escolar'])->group(function () {
        Route::post('prefijo_telefono/modales/store', [PrefijoTelefonoController::class, 'store'])->name('prefijo_telefono.modales.store');
        Route::post('prefijo_telefono/{id}/update', [PrefijoTelefonoController::class, 'update'])->name('prefijo_telefono.modales.update');
        Route::delete('prefijo_telefono/{id}', [PrefijoTelefonoController::class, 'destroy'])->name('prefijo_telefono.destroy');
    });

    // ===== ROLES =====
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('roles/permisos/{id}', [RoleController::class, 'permisos'])->name('roles.permisos');

    Route::middleware(['verificar.anio.escolar'])->group(function () {
        Route::post('roles/modales/store', [RoleController::class, 'store'])->name('roles.modales.store');
        Route::post('roles/{id}/update', [RoleController::class, 'update'])->name('roles.modales.update');
        Route::delete('roles/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    });

    // ===== ESTUDIOS REALIZADOS =====
    Route::get('estudios_realizados', [EstudiosRealizadoController::class, 'index'])->name('estudios_realizados.index');

    Route::middleware(['verificar.anio.escolar'])->group(function () {
        Route::post('estudios_realizados/modales/store', [EstudiosRealizadoController::class, 'store'])->name('estudios_realizados.modales.store');
        Route::post('estudios_realizados/{id}/update', [EstudiosRealizadoController::class, 'update'])->name('estudios_realizados.modales.update');
        Route::delete('estudios_realizados/{id}', [EstudiosRealizadoController::class, 'destroy'])->name('estudios_realizados.destroy');
    });

    // ===== ÁREA ESTUDIO REALIZADO (TRANSACCIÓN) =====
    Route::get('transacciones/area_estudio_realizado', [AreaEstudioRealizadoController::class, 'index'])->name('transacciones.area_estudio_realizado.index');

    Route::middleware(['verificar.anio.escolar'])->group(function () {
        Route::post('transacciones/area_estudio_realizado/modales/store', [AreaEstudioRealizadoController::class, 'store'])->name('transacciones.area_estudio_realizado.modales.store');
        Route::post('transacciones/area_estudio_realizado/{id}/update', [AreaEstudioRealizadoController::class, 'update'])->name('transacciones.area_estudio_realizado.modales.update');
        Route::delete('transacciones/area_estudio_realizado/{id}', [AreaEstudioRealizadoController::class, 'destroy'])->name('transacciones.area_estudio_realizado.destroy');
    });

    // ===== DOCENTE ======
    Route::get('docente', [DocenteController::class, 'index'])->name('docente.index');

    Route::middleware(['verificar.anio.escolar'])->group(function () {
        Route::get('docente/create', [DocenteController::class, 'create'])->name('docente.create');
        Route::post('docente/store', [DocenteController::class, 'store'])->name('docente.store');
        Route::get('docente/{id}/edit', [DocenteController::class, 'edit'])->name('docente.edit');
        Route::post('docente/{id}/update', [DocenteController::class, 'update'])->name('docente.update');
        Route::delete('docente/{id}', [DocenteController::class, 'destroy'])->name('docente.destroy');
        Route::get('docente/{id}/estudios', [DocenteController::class, 'estudios'])->name('docente.estudios');
        Route::post('docente/{id}/estudiosEdit', [DocenteController::class, 'estudiosEdit'])->name('docente.estudiosEdit');
    });

        // ===== TRANSACCION DOCENTE ======
    Route::get('transacciones/docente_area_grado', [DocenteAreaGradoController::class, 'index'])->name('transacciones.docente_area_grado.index');

    Route::middleware(['verificar.anio.escolar'])->group(function () {
        Route::get('transacciones/docente_area_grado/create', [DocenteAreaGradoController::class, 'create'])->name('transacciones.docente_area_grado.create');
        Route::post('transacciones/docente_area_grado/store', [DocenteAreaGradoController::class, 'store'])->name('transacciones.docente_area_grado.store');
        Route::get('transacciones/docente_area_grado/{id}/edit', [DocenteAreaGradoController::class, 'edit'])->name('transacciones.docente_area_grado.edit');
        Route::post('transacciones/docente_area_grado/{id}/update', [DocenteAreaGradoController::class, 'update'])->name('transacciones.docente_area_grado.update');
        Route::delete('transacciones/docente_area_grado/{id}', [DocenteAreaGradoController::class, 'destroy'])->name('transacciones.docente_area_grado.destroy');
        Route::delete('transacciones/docente_area_grado/{id}/destroy-asignacion', [DocenteAreaGradoController::class, 'destroyAsignacion'])->name('transacciones.docente_area_grado.destroyAsignacion');
    });

    // ===== DASHBOARD ======

    // ===== ALUMNOS ======
    Route::get('alumnos', [AlumnoController::class, 'index'])->name('alumnos.index');

    Route::get('alumnos/create', [AlumnoController::class, 'create'])->name('alumnos.create');

    Route::post('alumnos/store', [AlumnoController::class, 'store'])->name('alumnos.store');

    Route::get('alumnos/{id}/edit', [AlumnoController::class, 'edit'])->name('alumnos.edit');

    Route::post('alumnos/{id}/update', [AlumnoController::class, 'update'])->name('alumnos.update');
    
    Route::delete('alumnos/{id}', [AlumnoController::class, 'destroy'])->name('alumnos.destroy');

    // ===== INSCRIPCION ======
    Route::get('transacciones/inscripcion', [InscripcionController::class, 'index'])
        ->name('transacciones.inscripcion.index');

    Route::post('transacciones/inscripcion/{grado}/generar-secciones', [InscripcionController::class, 'generarSecciones'])->name('transacciones.inscripcion.generar.secciones');



    //===== PERCENTIL ======
    Route::get('transacciones/percentil', [EntradasPercentilController::class, 'index'])->name('transacciones.percentil.index');
});




// RUTAS PARA EL PROCESO DE INSCRIPCION DE NUEVO INGRESO----------------------------------------------------------
            Route::prefix('admin/inscripcion')->group(function () {
        //  Formulario del estudiante
        Route::get('/estudiante', [NuevoIngresoController::class, 'showEstudianteForm'])
            ->name('admin.inscripcion.estudiante')
            ->middleware(["auth"]);

          Route::post('/estudiante/store', [NuevoIngresoController::class, 'storeEstudiante'])
        ->name('inscripcion.store.estudiante')
        ->middleware(["auth"]);

    //  Formulario del representante
    Route::get('/representante', [NuevoIngresoController::class, 'showRepresentanteForm'])
        ->name('inscripcion.representante')
        ->middleware(["auth"]);

    // Guardar datos del representante en sesión (Paso 2) - RUTA CORREGIDA
    Route::post('/representante/store', [NuevoIngresoController::class, 'storeRepresentante'])
        ->name('inscripcion.store.representante')
        ->middleware(["auth"]);

    // Formulario final de inscripción
    Route::get('/final', [NuevoIngresoController::class, 'showFinalForm'])
        ->name('inscripcion.final')
        ->middleware(["auth"]);

    // Completar inscripción (transacción final)
    Route::post('/completar', [NuevoIngresoController::class, 'completarInscripcion'])
        ->name('inscripcion.completar')
        ->middleware(["auth"]);

        // Página de inscripción completada
        Route::get('/completada', [NuevoIngresoController::class, 'completada'])
            ->name('inscripcion.completada')
            ->middleware(["auth"]);

        // EMpezar de nuevo Inscripcion
        Route::post('/reset', [NuevoIngresoController::class, 'resetInscripcion'])
            ->name('inscripcion.reset')
            ->middleware(["auth"]);

    });

    // NUEVO INGRESO 
    Route::prefix('admin/nuevo_ingreso')->group(function () {
    // Página principal (listado)
    Route::get('/', [NuevoIngresoController::class, 'index'])
        ->name('admin.nuevo_ingreso.index')
        ->middleware(['auth']);
    // Listar y buscar inscripciones
    Route::get('/listar', [NuevoIngresoController::class, 'listarInscripciones'])
        ->name('admin.inscripciones.listar')
        ->middleware(["auth"]);

    Route::get('/buscar', [NuevoIngresoController::class, 'buscar'])
        ->name('admin.nuevo_ingreso.buscar')
        ->middleware(["auth"]);

    // Ver detalles de una inscripción
    Route::get('/detalle/{id}', [NuevoIngresoController::class, 'verDetalle'])
        ->name('admin.inscripciones.detalle')
        ->middleware(["auth"]);

    // Cambiar estado de inscripción (ya no la uso por que pa que xd )
    Route::post('/cambiar-estado/{id}', [NuevoIngresoController::class, 'cambiarEstado'])
        ->name('admin.inscripciones.cambiarEstado')
        ->middleware(["auth"]);

    // Editar y eliminar inscripciones
       Route::get('/editar/{id}', [NuevoIngresoController::class, 'editar'])->name('admin.nuevo_ingreso.editar');
    Route::put('/actualizar/{id}', [NuevoIngresoController::class, 'actualizar'])->name('admin.nuevo_ingreso.actualizar');
    Route::delete('/eliminar/{id}', [NuevoIngresoController::class, 'eliminar'])->name('admin.nuevo_ingreso.eliminar');

});

    // --------

    Route::get("admin/estudiante/inicio",[EstudianteController::class, 'estudianteView'])->name("admin.estudiante.inicio");
    Route::get("admin/estudiante/formulario",[EstudianteController::class, 'formularioEstudianteView'])->name("admin.estudiante.formulario")->middleware(["auth"]);


    // ===== ESTUDIANTE =====

    Route::prefix("admin/estudiante")->group(function(){
        Route::get("/formularioEstudiante/{id}",[EstudianteController::class, 'formularioEstudianteView'])->name("estudiante.formulario.editar")->middleware(["auth"]);

        Route::post("/verificar-cedula", [EstudianteController::class,"verificarCedula"])->name("admin.estudiante.verificar-cedula")->middleware(["auth"]);

        Route::post("/save",[EstudianteController::class, 'save'])->middleware(["auth"]);

        // Si alguien accede por GET accidentalmente, redirigir al formulario
        Route::get('/save', function () {
            return redirect()->route('admin.estudiante.formulario');
        })->middleware(['auth']);

        Route::delete("/eliminar/{id}",[EstudianteController::class, 'eliminar'])->middleware(["auth"]);
        // para consultar un estudiante

        Route::get('/consultar/{id}',[EstudianteController::class,"consultar"])->middleware(["auth"]);
        Route::get('/listar',[EstudianteController::class,"listar"])->middleware(["auth"]); // Para listar TODOS los estudiantes
        // filtros y búsquedas
        Route::get('/filtrar',[EstudianteController::class,'filtrar'])->name('estudiante.filtrar')->middleware(['auth']);
        Route::get('/buscar',[EstudianteController::class,'buscar'])->name('estudiante.buscar')->middleware(['auth']);
    });


// ======  REPRESENTANTE  ======
Route::middleware(['auth'])->prefix('representante')->name('representante.')->group(function() {
    // Vista principal (listado)
    Route::get('/', [RepresentanteController::class, 'index'])->name('index');

    // Formulario de creación
    Route::get('/formulario', [RepresentanteController::class, 'mostrarFormulario'])->name('formulario');

    // Guardar / actualizar representante (manejado por el método save del controlador)
    Route::post('/save', [RepresentanteController::class, 'save'])->name('save');

    // Formulario de edición de un representante específico
    Route::get('/{id}/editar', [RepresentanteController::class, 'mostrarFormularioEditar'])->name('editar');

    // Eliminar representante
    Route::delete('/{id}', [RepresentanteController::class, 'delete'])->name('destroy');

    // Búsqueda por cédula (AJAX)
    Route::get('/buscar-cedula', [RepresentanteController::class, 'buscarPorCedula'])->name('buscar_cedula');

    // Consultar un representante específico (AJAX)
    Route::get('/consultar', [RepresentanteController::class, 'consultar'])->name('consultar');

    // Filtrar representantes (AJAX)
    Route::get('/filtrar', [RepresentanteController::class, 'filtar'])->name('filtrar');

        // Verificar cédula duplicada (AJAX)
        Route::get('/verificar-cedula', [RepresentanteController::class, 'verificarCedula'])->name('verificar_cedula');

    // Generar reporte PDF
    Route::get('/reporte-pdf', [RepresentanteController::class, 'reportePDF'])->name('reporte_pdf');

});

    
 
