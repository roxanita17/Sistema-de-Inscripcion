<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('admin/blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');

Route::get('admin/anio_escolar', [App\Http\Controllers\AnioEscolarController::class, 'index'])->name('anio_escolar.index');
Route::post('admin/anio_escolar', [App\Http\Controllers\AnioEscolarController::class, 'store'])->name('anio_escolar.store');



