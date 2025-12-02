@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
    @livewireStyles
@stop

@section('title')
    {{ isset($estudiante_id) ? 'Editar Estudiante' : 'Registrar Estudiante' }}
@stop

@section('content_header')
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-user-{{ isset($alumno_id) ? 'edit' : 'plus' }}"></i>
                </div>
                <div>
                    <h1 class="title-main">
                        {{ isset($alumno_id) ? 'Editar Alumno' : 'Registrar Alumno' }}
                    </h1>
                    <p class="title-subtitle">Formulario de registro de estudiantes</p>
                </div>
            </div>
            <a href="{{ route('admin.estudiante.inicio') }}" class="btn-create" style="background: var(--gray-500);">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="main-container">
        <livewire:admin.alumnos.alumno-create />
    </div>
@stop

@section('js')
    @livewireScripts
    <script>
        // Auto-cerrar alertas después de 5 segundos
        setTimeout(function() {
            $('.alert-modern').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    </script>
@stop