<?php

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group; 
use Illuminate\Support\Facades\Auth;

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



