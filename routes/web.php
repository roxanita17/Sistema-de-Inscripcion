<?php

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Group;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('admin/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');

Route::get('admin/anio_escolar', [App\Http\Controllers\AnioEscolarController::class, 'index'])->name('admin.anio_escolar.index');
Route::post('admin/anio_escolar/modales/store', [App\Http\Controllers\AnioEscolarController::class, 'store'])->name('admin.anio_escolar.modales.store');
Route::post('admin/anio_escolar/{id}/extender', [App\Http\Controllers\AnioEscolarController::class, 'extender'])->name('admin.anio_escolar.modales.extender');
Route::delete('/admin/anio_escolar/{id}', [App\Http\Controllers\AnioEscolarController::class, 'destroy'])->name('admin.anio_escolar.destroy');

Route::get('admin/etnia_indigena', [App\Http\Controllers\EtniaIndigenaController::class, 'index'])->name('admin.etnia_indigena.index');
Route::post('admin/etnia_indigena/modales/store', [App\Http\Controllers\EtniaIndigenaController::class, 'store'])->name('admin.etnia_indigena.modales.store');
Route::post('admin/etnia_indigena/{id}/update', [App\Http\Controllers\EtniaIndigenaController::class, 'update'])->name('admin.etnia_indigena.modales.update');
Route::delete('/admin/etnia_indigena/{id}', [App\Http\Controllers\EtniaIndigenaController::class, 'destroy'])->name('admin.etnia_indigena.destroy');

Route::get('admin/banco', [App\Http\Controllers\BancoController::class, 'index'])->name('admin.banco.index');
Route::post('admin/banco/modales/store', [App\Http\Controllers\BancoController::class, 'store'])->name('admin.banco.modales.store');
Route::post('admin/banco/{id}/update', [App\Http\Controllers\BancoController::class, 'update'])->name('admin.banco.modales.update');
Route::delete('/admin/banco/{id}', [App\Http\Controllers\BancoController::class, 'destroy'])->name('admin.banco.destroy');
