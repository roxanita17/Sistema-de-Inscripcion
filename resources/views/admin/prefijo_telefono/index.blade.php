@extends('adminlte::page')

@section('css')
    {{-- Estilos modernos reutilizados del sistema --}}
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">

@stop

@section('title', 'Gestión de Prefijos de Telefono')

@section('content_header')
    {{-- Encabezado principal de la página --}}
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <h1 class="title-main">Gestión de Prefijos de Telefono</h1>
                    <p class="title-subtitle">Administración de los prefijos</p>
                </div>
            </div>

            {{-- Botón que abre la ventana modal para crear un nuevo prefijo --}}
            <button type="button"
                    class="btn-create" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalCrear"
                    @if(!$anioEscolarActivo) disabled @endif
                    title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Nuevo Prefijo' }}">
                <i class="fas fa-plus"></i>
                <span>Nuevo Prefijo</span>
            </button>
        </div>
    </div>
@stop

@section('content')
<div class="main-container">

    {{-- Modal para crear un nuevo prefijo --}}
    @include('admin.prefijo_telefono.modales.createModal')

    {{-- Alerta si NO hay año escolar activo --}}
    @if (!$anioEscolarActivo)
        <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                <div>
                    <h5 class="alert-heading mb-1">Atención: No hay año escolar activo</h5>
                    <p class="mb-0">
                        Puedes ver los registros, pero <strong>no podrás crear, editar o eliminar</strong> hasta que se registre un año escolar activo.
                        <a href="{{ route('admin.anio_escolar.index') }}" class="alert-link">Ir a Año Escolar</a>
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Sección de alertas de éxito o error --}}
    @if (session('success') || session('error'))
        <div class="alerts-container">
            @if (session('success'))
                <div class="alert-modern alert-success alert alert-dismissible fade show" role="alert">
                    <div class="alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="alert-content">
                        <h4>Éxito</h4>
                        <p>{{ session('success') }}</p>
                    </div>
                    <button type="button" class="alert-close btn-close" data-bs-dismiss="alert" aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-modern alert-error alert alert-dismissible fade show" role="alert">
                    <div class="alert-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="alert-content">
                        <h4>Error</h4>
                        <p>{{ session('error') }}</p>
                    </div>
                    <button type="button" class="alert-close btn-close" data-bs-dismiss="alert" aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
        </div>
    @endif 

    {{-- Contenedor principal de la tabla de prefijo--}}
    <div class="card-modern">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-list-ul"></i>
                </div>
                <div>
                    <h3>Listado de Prefijos</h3>
                    <p>{{ $prefijos->total() }} registros encontrados</p>
                </div>
            </div>
            <div class="header-right">
                <div class="date-badge">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ now()->translatedFormat('d M Y') }}</span>
                </div>
            </div>

                           <div class="header-right">
                <!-- --------------------------- -->

@php
    $anioActivo = \App\Models\AnioEscolar::activos()->first();
    $anioExtendido = \App\Models\AnioEscolar::where('status', 'Extendido')->first();
    $mostrarAnio = $anioActivo ?? $anioExtendido;
@endphp

@if($mostrarAnio)
    <div class="d-flex align-items-center justify-content-between bg-light rounded px-2 py-1  border">
        <div class="d-flex align-items-center">
            <span class="badge bg-primary rounded me-2 py-1 px-2" style="font-size: 0.7rem;">
                <i class="fas fa-calendar-check me-1"></i>
                
                Año Escolar
            </span>
            
            <div class="d-flex align-items-center" style="font-size: 0.8rem;">
                <span class="text-muted me-2">
                    <i class="fas fa-play-circle text-primary me-1"></i>
                    {{ \Carbon\Carbon::parse($mostrarAnio->inicio_anio_escolar)->format('d/m/Y') }}
                </span>
                
                <span class="text-muted me-2">
                    <i class="fas fa-flag-checkered text-danger me-1"></i>
                    {{ \Carbon\Carbon::parse($mostrarAnio->cierre_anio_escolar)->format('d/m/Y') }}
                </span>
                
                
            </div>
        </div>
    </div>
@else
    <div class="d-flex align-items-center justify-content-between bg-warning bg-opacity-10 rounded px-2 py-1  border border-warning">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle text-warning me-1" style="font-size: 0.8rem;"></i>
            <span class="fw-semibold" style="font-size: 0.8rem;">Sin año activo</span>
        </div>
        
    </div>
@endif
<!-- --------------------------- -->

            </div>

        </div>

        {{-- Cuerpo de la tarjeta con la tabla --}}
        <div class="card-body-modern">
            <div class="table-wrapper">
                <table class="table-modern overflow-hidden hidden">
                    <thead>
                        <tr style="text-align: center">
                            <th style="text-align: center">Prefijo</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center">
                        {{-- Si no hay grados, se muestra mensaje vacío --}}
                        @if ($prefijos->isEmpty())
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-inbox"></i>
                                        </div>
                                        <h4>No hay grados registrados</h4>
                                        <p>Agrega un nuevo grado con el botón superior</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            {{-- Se recorren los grados existentes --}}
                            @foreach ($prefijos as $index => $datos)
                                <tr class="  row-12" style="text-align: center">                                    
                                    <td class="title-main">{{ $datos->prefijo}}</td>
                                    <td>
                                        @if ($datos->status)
                                            <span class="status-badge status-active">
                                                <span class="status-dot"></span>
                                                Activo
                                            </span>
                                        @else
                                            <span class="status-badge status-inactive">
                                                <span class="status-dot"></span>
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">

                                            {{-- Editar prefijo --}}
                                            <button class="action-btn btn-edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewModalEditar{{ $datos->id }}"
                                                title="Editar"
                                                @if(!$anioEscolarActivo) disabled @endif
                                                title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Editar Prefijo' }}">
                                                <i class="fas fa-pen"></i>
                                            </button>

                                            {{-- Eliminar prefijo --}}
                                            <button class="action-btn btn-delete"
                                                data-bs-toggle="modal" data-bs-target="#confirmarEliminar{{ $datos->id }}"
                                                title="Eliminar"
                                                @if(!$anioEscolarActivo) disabled @endif
                                                title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Eliminar Prefijo' }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                            
                                    </td>
                                </tr>

                                {{-- Ruta modal de editar --}}
                                @include('admin.prefijo_telefono.modales.editModal')

                                {{-- Modal de confirmación para eliminar --}}
                                    <div class="modal fade" id="confirmarEliminar{{ $datos->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $datos->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content modal-modern">
                                                <div class="modal-header-delete">
                                                    <div class="modal-icon-delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </div>
                                                    <h5 class="modal-title-delete">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body-delete">
                                                    <p>¿Deseas eliminar este prefijo?</p>
                                                    <p class="delete-warning">
                                                        Esta acción no se puede deshacer.
                                                    </p>
                                                </div>
                                                <div class="modal-footer-delete">
                                                    <form action="{{ url('admin/prefijo_telefono/' . $datos->id) }}" method="POST" class="w-100">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="footer-buttons">
                                                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn-modal-delete">Eliminar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Paginación moderna --}}
<x-pagination :paginator="$prefijos" />

@endsection

@section('js')
<!-- Incluir el archivo de validaciones -->
<script src="{{ asset('js/validations/prefijoTelefono.js') }}"></script>

<script>
    // Inicializar tooltips de Bootstrap
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection
