<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;

// Inicio (Home)
Breadcrumbs::for('home', function (Trail $trail) {
    $trail->push('Inicio', route('home'));
});

// Año Escolar
Breadcrumbs::for('admin.anio_escolar.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Año Escolar', route('admin.anio_escolar.index'));
});

// Banco
Breadcrumbs::for('admin.banco.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Banco', route('admin.banco.index'));
});

// Estado
Breadcrumbs::for('admin.estado.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Estado', route('admin.estado.index'));
});

// Municipio
Breadcrumbs::for('admin.municipio.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Municipio', route('admin.municipio.index'));
});

// Localidad
Breadcrumbs::for('admin.localidad.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Localidad', route('admin.localidad.index'));
});

// Etnia Indigena
Breadcrumbs::for('admin.etnia_indigena.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Etnia Indigena', route('admin.etnia_indigena.index'));
});

// Ocupacion
Breadcrumbs::for('admin.ocupacion.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Ocupacion', route('admin.ocupacion.index'));
});

// Grado
Breadcrumbs::for('admin.grado.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Grado', route('admin.grado.index'));
});

// Area de Formacion
Breadcrumbs::for('admin.area_formacion.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Area de Formacion', route('admin.area_formacion.index'));
});

// Expresion Literaria
Breadcrumbs::for('admin.expresion_literaria.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Expresion Literaria', route('admin.expresion_literaria.index'));
});

// Discapacidad
Breadcrumbs::for('admin.discapacidad.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Discapacidad', route('admin.discapacidad.index'));
});

// Grado Area Formacion
Breadcrumbs::for('admin.transacciones.grado_area_formacion.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Grado Area Formacion', route('admin.transacciones.grado_area_formacion.index'));
});

// Prefijo de telefono
Breadcrumbs::for('admin.prefijo_telefono.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Prefijo de telefono', route('admin.prefijo_telefono.index'));
});

// Rol
Breadcrumbs::for('admin.rol.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Roles', route('admin.rol.index'));
});

// Estudios Realizados
Breadcrumbs::for('admin.estudios_realizados.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Estudios Realizados', route('admin.estudios_realizados.index'));
});

// Area Estudio Realizado
Breadcrumbs::for('admin.transacciones.area_estudio_realizado.index', function (Trail $trail) {
    $trail->parent('home');
    $trail->push('Area Estudio Realizado', route('admin.transacciones.area_estudio_realizado.index'));
});

