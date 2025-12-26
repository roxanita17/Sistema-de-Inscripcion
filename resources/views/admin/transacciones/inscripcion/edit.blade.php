@extends('adminlte::page')

@section('title', 'Editar Inscripción')

@section('content_header')
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h1 class="title-main">Editar Inscripción</h1>
                    <p class="title-subtitle">Modificar datos de inscripción de nuevo ingreso</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="main-container">
        <livewire:admin.transaccion-inscripcion.inscripcion-edit :inscripcionId="$inscripcion->id" />
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@stop