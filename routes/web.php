<?php

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group; 
use Illuminate\Support\Facades\Auth;
use App\Livewire\Admin\EstadoIndex;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* Año Escolar */
Route::get('admin/anio_escolar', [App\Http\Controllers\AnioEscolarController::class, 'index'])->name('admin.anio_escolar.index');
Route::post('admin/anio_escolar/modales/store', [App\Http\Controllers\AnioEscolarController::class, 'store'])->name('admin.anio_escolar.modales.store');
Route::post('admin/anio_escolar/{id}/extender', [App\Http\Controllers\AnioEscolarController::class, 'extender'])->name('admin.anio_escolar.modales.extender');
Route::delete('/admin/anio_escolar/{id}', [App\Http\Controllers\AnioEscolarController::class, 'destroy'])->name('admin.anio_escolar.destroy');

/* Etnia Indigena */
Route::get('admin/etnia_indigena', [App\Http\Controllers\EtniaIndigenaController::class, 'index'])->name('admin.etnia_indigena.index');
Route::post('admin/etnia_indigena/modales/store', [App\Http\Controllers\EtniaIndigenaController::class, 'store'])->name('admin.etnia_indigena.modales.store');
Route::post('admin/etnia_indigena/{id}/update', [App\Http\Controllers\EtniaIndigenaController::class, 'update'])->name('admin.etnia_indigena.modales.update');
Route::delete('/admin/etnia_indigena/{id}', [App\Http\Controllers\EtniaIndigenaController::class, 'destroy'])->name('admin.etnia_indigena.destroy');

/* Ocupacion */
Route::get('admin/ocupacion', [App\Http\Controllers\OcupacionController::class, 'index'])->name('admin.ocupacion.index');
Route::post('admin/ocupacion/modales/store', [App\Http\Controllers\OcupacionController::class, 'store'])->name('admin.ocupacion.modales.store');
Route::post('admin/ocupacion/{id}/update', [App\Http\Controllers\OcupacionController::class, 'update'])->name('admin.ocupacion.modales.update');
Route::delete('/admin/ocupacion/{id}', [App\Http\Controllers\OcupacionController::class, 'destroy'])->name('admin.ocupacion.destroy');

/* Banco */
Route::get('admin/banco', [App\Http\Controllers\BancoController::class, 'index'])->name('admin.banco.index');
Route::post('admin/banco/modales/store', [App\Http\Controllers\BancoController::class, 'store'])->name('admin.banco.modales.store');
Route::post('admin/banco/{id}/update', [App\Http\Controllers\BancoController::class, 'update'])->name('admin.banco.modales.update');
Route::delete('/admin/banco/{id}', [App\Http\Controllers\BancoController::class, 'destroy'])->name('admin.banco.destroy');

/* Estado */
Route::get('admin/estado', [App\Http\Controllers\EstadoController::class, 'index'])->name('admin.estado.index');
Route::post('admin/estado/modales/store', [App\Http\Controllers\EstadoController::class, 'store'])->name('admin.estado.modales.store');
Route::post('admin/estado/{id}/update', [App\Http\Controllers\EstadoController::class, 'update'])->name('admin.estado.modales.update');
Route::delete('/admin/estado/{id}', [App\Http\Controllers\EstadoController::class, 'destroy'])->name('admin.estado.destroy');

/* Municipio */
Route::get('admin/municipio', [App\Http\Controllers\MunicipioController::class, 'index'])->name('admin.municipio.index');
Route::post('admin/municipio/modales/store', [App\Http\Controllers\MunicipioController::class, 'store'])->name('admin.municipio.modales.store');
Route::post('admin/municipio/{id}/update', [App\Http\Controllers\MunicipioController::class, 'update'])->name('admin.municipio.modales.update');
Route::delete('/admin/municipio/{id}', [App\Http\Controllers\MunicipioController::class, 'destroy'])->name('admin.municipio.destroy');

/* Localidad */
Route::get('admin/localidad', [App\Http\Controllers\LocalidadController::class, 'index'])->name('admin.localidad.index');
Route::post('admin/localidad/modales/store', [App\Http\Controllers\LocalidadController::class, 'store'])->name('admin.localidad.modales.store');
Route::post('admin/localidad/{id}/update', [App\Http\Controllers\LocalidadController::class, 'update'])->name('admin.localidad.modales.update');
Route::delete('/admin/localidad/{id}', [App\Http\Controllers\LocalidadController::class, 'destroy'])->name('admin.localidad.destroy'); 
Route::get('admin/localidad/municipios/{estado_id}', [App\Http\Controllers\MunicipioController::class, 'getByEstado']);
Route::get('admin/localidad/localidades/{municipio_id}', [App\Http\Controllers\LocalidadController::class, 'getByMunicipio']);

/* Grado */
Route::get('admin/grado', [App\Http\Controllers\GradoController::class, 'index'])->name('admin.grado.index');
Route::post('admin/grado/modales/store', [App\Http\Controllers\GradoController::class, 'store'])->name('admin.grado.modales.store');
Route::post('admin/grado/{id}/update', [App\Http\Controllers\GradoController::class, 'update'])->name('admin.grado.modales.update');
Route::delete('/admin/grado/{id}', [App\Http\Controllers\GradoController::class, 'destroy'])->name('admin.grado.destroy');

/* Area de Formacion */
Route::get('admin/area_formacion', [App\Http\Controllers\AreaFormacionController::class, 'index'])->name('admin.area_formacion.index');
Route::post('admin/area_formacion/modales/store', [App\Http\Controllers\AreaFormacionController::class, 'store'])->name('admin.area_formacion.modales.store');
Route::post('admin/area_formacion/{id}/update', [App\Http\Controllers\AreaFormacionController::class, 'update'])->name('admin.area_formacion.modales.update');
Route::delete('/admin/area_formacion/{id}', [App\Http\Controllers\AreaFormacionController::class, 'destroy'])->name('admin.area_formacion.destroy');

/* Grupo Estable */
Route::post('admin/area_formacion/modalesGrupoEstable/storeGrupoEstable', [App\Http\Controllers\AreaFormacionController::class, 'storeGrupoEstable'])->name('admin.area_formacion.modalesGrupoEstable.storeGrupoEstable');
Route::post('admin/area_formacion/{id}/updateGrupoEstable', [App\Http\Controllers\AreaFormacionController::class, 'updateGrupoEstable'])->name('admin.area_formacion.modalesGrupoEstable.updateGrupoEstable');
Route::delete('/admin/area_formacion/{id}', [App\Http\Controllers\AreaFormacionController::class, 'destroyGrupoEstable'])->name('admin.area_formacion.modalesGrupoEstable.destroyGrupoEstable');

/* Expresion Literaria */
Route::get('admin/expresion_literaria', [App\Http\Controllers\ExpresionLiterariaController::class, 'index'])->name('admin.expresion_literaria.index');
Route::post('admin/expresion_literaria/modales/store', [App\Http\Controllers\ExpresionLiterariaController::class, 'store'])->name('admin.expresion_literaria.modales.store');
Route::post('admin/expresion_literaria/{id}/update', [App\Http\Controllers\ExpresionLiterariaController::class, 'update'])->name('admin.expresion_literaria.modales.update');
Route::delete('/admin/expresion_literaria/{id}', [App\Http\Controllers\ExpresionLiterariaController::class, 'destroy'])->name('admin.expresion_literaria.destroy');

/* Discapacidad */
Route::get('admin/discapacidad', [App\Http\Controllers\DiscapacidadController::class, 'index'])->name('admin.discapacidad.index');
Route::post('admin/discapacidad/modales/store', [App\Http\Controllers\DiscapacidadController::class, 'store'])->name('admin.discapacidad.modales.store');
Route::post('admin/discapacidad/{id}/update', [App\Http\Controllers\DiscapacidadController::class, 'update'])->name('admin.discapacidad.modales.update');
Route::delete('/admin/discapacidad/{id}', [App\Http\Controllers\DiscapacidadController::class, 'destroy'])->name('admin.discapacidad.destroy');

/* Grado Area Formacion */
Route::get('admin/transacciones/grado_area_formacion', [App\Http\Controllers\GradoAreaFormacionController::class, 'index'])->name('admin.transacciones.grado_area_formacion.index');
Route::post('admin/transacciones/grado_area_formacion/modales/store', [App\Http\Controllers\GradoAreaFormacionController::class, 'store'])->name('admin.transacciones.grado_area_formacion.modales.store');
Route::post('admin/transacciones/grado_area_formacion/{id}/update', [App\Http\Controllers\GradoAreaFormacionController::class, 'update'])->name('admin.transacciones.grado_area_formacion.modales.update');
Route::delete('/admin/transacciones/grado_area_formacion/{id}', [App\Http\Controllers\GradoAreaFormacionController::class, 'destroy'])->name('admin.transacciones.grado_area_formacion.destroy');

/* Prefijo de telefono */
Route::get('admin/prefijo_telefono', [App\Http\Controllers\PrefijoTelefonoController::class, 'index'])->name('admin.prefijo_telefono.index');
Route::post('admin/prefijo_telefono/modales/store', [App\Http\Controllers\PrefijoTelefonoController::class, 'store'])->name('admin.prefijo_telefono.modales.store');
Route::post('admin/prefijo_telefono/{id}/update', [App\Http\Controllers\PrefijoTelefonoController::class, 'update'])->name('admin.prefijo_telefono.modales.update');
Route::delete('/admin/prefijo_telefono/{id}', [App\Http\Controllers\PrefijoTelefonoController::class, 'destroy'])->name('admin.prefijo_telefono.destroy');

/* Roles */
Route::get('admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('admin.roles.index');
Route::post('admin/roles/modales/store', [App\Http\Controllers\RoleController::class, 'store'])->name('admin.roles.modales.store');
Route::post('admin/roles/{id}/update', [App\Http\Controllers\RoleController::class, 'update'])->name('admin.roles.modales.update');
Route::delete('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('admin.roles.destroy');
Route::get('admin/roles/permisos/{id}', [App\Http\Controllers\RoleController::class, 'permisos'])->name('admin.roles.permisos');

/* Estudios Realizados */
Route::get('admin/estudios_realizados', [App\Http\Controllers\EstudiosRealizadoController::class, 'index'])->name('admin.estudios_realizados.index');
Route::post('admin/estudios_realizados/modales/store', [App\Http\Controllers\EstudiosRealizadoController::class, 'store'])->name('admin.estudios_realizados.modales.store');
Route::post('admin/estudios_realizados/{id}/update', [App\Http\Controllers\EstudiosRealizadoController::class, 'update'])->name('admin.estudios_realizados.modales.update');
Route::delete('/admin/estudios_realizados/{id}', [App\Http\Controllers\EstudiosRealizadoController::class, 'destroy'])->name('admin.estudios_realizados.destroy');

 