@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/view-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

    @stop

@section('title', 'Ver Docentes')

@section('content_header')
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-user-check"></i>
                </div>
                <div>
                    <h1 class="title-main">Paso 2 de 2. Registre el(los) estudios del docente</h1>
                    <p class="title-subtitle">Información registrada en el sistema</p>
                </div>
            </div>

            <a href="{{ route('admin.docente.index') }}" class="btn-create" style="background: var(--gray-700);">
                <i class="fas fa-arrow-left"></i>
                <span>Volver al Listado</span>
            </a>
        </div>
    </div>
@stop

@section('content')

<div class="main-container">

    {{-- CARD PRINCIPAL --}}
    <div class="card-modern">

        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <div>
                    <h3>Información del docentes</h3>
                    <p>Vista de solo lectura</p>
                </div>
            </div>
        </div>

        <div class="card-body-modern" style="padding: 2rem;">

            {{-- ===================== --}}
            {{-- IDENTIFICACIÓN --}}
            {{-- ===================== --}}
            <div class="section-title-modern">
                <i class="fas fa-id-card"></i> Datos de Identificación
            </div>

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="label-view">Tipo de documento</label>
                    <p class="data-view">
                        {{ $docentes->persona->tipoDocumento->nombre }}
                    </p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="label-view">Cédula</label>
                    <p class="data-view">
                        {{ $docentes->persona->cedula }}
                    </p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="label-view">Código</label>
                    <p class="data-view">
                        {{ $docentes->codigo ?? 'No asignado' }}
                    </p>
                </div>

            </div>

            {{-- ===================== --}}
            {{-- PERSONALES --}}
            {{-- ===================== --}}
            <div class="section-title-modern" style="margin-top: 2rem;">
                <i class="fas fa-user"></i> Datos Personales
            </div>

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="label-view">Primer nombre</label>
                    <p class="data-view">{{ $docentes->persona->primer_nombre }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="label-view">Segundo nombre</label>
                    <p class="data-view">{{ $docentes->persona->segundo_nombre ?? '—' }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="label-view">Primer apellido</label>
                    <p class="data-view">{{ $docentes->persona->primer_apellido }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="label-view">Género</label>
                    <p class="data-view">{{ $docentes->persona->genero->genero }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="label-view">Fecha de nacimiento</label>
                    <p class="data-view">{{ $docentes->persona->fecha_nacimiento }}</p>
                </div>

            </div>

            {{-- ===================== --}}
            {{-- CONTACTO --}}
            {{-- ===================== --}}
            <div class="section-title-modern" style="margin-top: 2rem;">
                <i class="fas fa-phone"></i> Información de Contacto
            </div>

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label class="label-view">Correo</label>
                    <p class="data-view">{{ $docentes->persona->email ?? '—' }}</p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="label-view">Teléfono</label>
                    <p class="data-view">
                        @if ($docentes->prefijoTelefono)
                            ({{ $docentes->prefijoTelefono->prefijo }}) {{ $docentes->primer_telefono }}
                        @else
                            Sin registrar
                        @endif
                    </p>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="label-view">Dependencia</label>
                    <p class="data-view">{{ $docentes->dependencia ?? '—' }}</p>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="label-view">Dirección</label>
                    <p class="data-view">{{ $docentes->persona->direccion ?? '—' }}</p>
                </div>

            </div>
        </div>
    </div>

    {{-- Registro de los estudios --}}
        <div class="">
            {{-- Llamamos el componente de livewire que va a agregar el estudio --}}
            <livewire:admin.docente.docente-estudio-realizado :docente="$docentes" />
        </div>
</div>

@endsection

<style>
    
</style>

@livewireStyles
@stack('css')


@livewireScripts
@stack('js')

