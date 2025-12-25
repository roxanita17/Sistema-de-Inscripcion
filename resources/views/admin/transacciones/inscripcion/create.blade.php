@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
@stop

@section('title', 'Registrar Nuevo Ingreso')

@section('content_header')
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <h1 class="title-main">Registrar Nuevo Ingreso</h1>
                    <p class="title-subtitle">Formulario de inscripción de estudiantes</p>
                </div>
            </div>
            {{-- <div class="header-right" style="width: 15rem">
                    @if ($infoCupos)
                        <div class="cupos-box">
                            <div class="cupos-titulo">
                                {{ $infoCupos['nombre_grado'] }}
                            </div>

                            <div class="cupos-datos text-center">
                                <div>
                                    <span class="label">Cupos totales</span>
                                    <span class="valor">{{ $infoCupos['total_cupos'] }}</span>
                                </div>

                                <div>
                                    <span class="label">En uso</span>
                                    <span class="valor">{{ $infoCupos['cupos_ocupados'] }}</span>
                                </div>

                                <div>
                                    <span class="label">Disponibles</span>
                                    <span class="valor">{{ $infoCupos['cupos_disponibles'] }}</span>
                                </div>
                            </div>

                            <div class="cupos-barra">
                                <div class="cupos-barra-progreso
            {{ $infoCupos['porcentaje_ocupacion'] >= 90
                ? 'rojo'
                : ($infoCupos['porcentaje_ocupacion'] >= 70
                    ? 'amarillo'
                    : 'verde') }}"
                                    style="width: {{ $infoCupos['porcentaje_ocupacion'] }}%">
                                </div>
                            </div>
                        </div>
                    @endif
                </div> --}}
            <a href="{{ route('admin.transacciones.inscripcion.index') }}" 
               class="btn-create" style="background: var(--gray-500);">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="main-container">
        {{-- AÑO ESCOLAR --}}
        @php
            $anoActivo = App\Models\AnioEscolar::whereIn('status', ['Activo', 'Extendido'])->first();
        @endphp

        @if (!$anoActivo)
            <div class="alert alert-warning">
                <strong>No hay año escolar activo.</strong>
                <a href="{{ route('admin.anio_escolar.index') }}">Ir a Año Escolar</a>
            </div>
        @endif

        {{-- COMPOSICIÓN PRINCIPAL LIVEWIRE --}}
        <livewire:admin.transaccion-inscripcion.inscripcion />
    </div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%',
        });

        setTimeout(() => {
            $('.alert-modern').fadeOut('slow');
        }, 5000);
    });
</script>
@stop
