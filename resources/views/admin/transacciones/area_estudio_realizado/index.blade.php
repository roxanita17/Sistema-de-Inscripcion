@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/createModal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/editModal.css') }}">
@stop





@section('title', 'Gestión de Áreas de Formación')

@section('content_header')
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-university"></i>
                </div>
                <div>
                    <h1 class="title-main">Áreas de Formación</h1>
                    <p class="title-subtitle">Gestión de asignaciones y títulos universitarios</p>
                </div>
            </div>
            <button type="button" class="btn-create" data-bs-toggle="modal" data-bs-target="#modalCrearAsignacion">
                <i class="fas fa-plus"></i>
                <span>Nueva Asignación</span>
            </button>
        </div>
    </div>
@stop

@section('content')
<div class="main-container">
    
    {{-- Incluir modal de creación --}}
    @include('admin.transacciones.area_estudio_realizado.modales.createModal')

    {{-- Alertas mejoradas --}}
    @if (session('success') || session('error'))
    <div class="alerts-container">
        @if (session('success'))
            <div class="alert-modern alert-success alert alert-dismissible fade show" role="alert">
                <div class="alert-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="alert-content">
                    <h4>¡Éxito!</h4>
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


    {{-- Tarjeta principal --}}
    <div class="card-modern">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-list-ul"></i>
                </div>
                <div>
                    <h3>Listado de Asignaciones</h3>
                    <p>{{ $areaEstudioRealizado->count() }} registros encontrados</p>
                </div>
            </div>
            <div class="header-right">
                <div class="date-badge">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ now()->translatedFormat('d M Y') }}</span>
                </div>
            </div>
        </div>

        <div class="card-body-modern">
            <div class="table-wrapper">
                <table class="table-modern overflow-hidden">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>Área de Formación</th>
                            <th>Título Universitario</th>
                            <th width="120">Estado</th>
                            <th width="180">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($areaEstudioRealizado as $index => $datos)
                            <tr class="table-row-hover">
                                <td>
                                    <div class="number-badge">{{ $index + 1 }}</div>
                                </td>
                                <td>
                                    <div class="cell-content">
                                        <i class="fas fa-bookmark text-primary me-2"></i>
                                        <span class="fw-semibold">{{ $datos->area_formacion->nombre_area_formacion ?? '—' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="cell-content">
                                        <i class="fas fa-graduation-cap text-secondary me-2"></i>
                                        <span>{{ $datos->estudio_realizado->estudios ?? '—' }}</span>
                                    </div>
                                </td>
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
                                        {{-- Ver --}}
                                        <button  class="action-btn btn-view" data-bs-toggle="modal" data-bs-target="#viewModal{{ $datos->id }}" title="Ver Detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @include('admin.transacciones.area_estudio_realizado.modales.showModal')

                                        {{-- Editar --}}
                                        <button type="button" class="action-btn btn-edit" data-bs-toggle="modal" data-bs-target="#viewModalEditar{{ $datos->id }}" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </button>

                                        {{-- Eliminar --}}
                                        <button type="button" class="action-btn btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $datos->id }}" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>

                                        {{-- Modal Eliminar --}}
                                        
                                    </div>
                                </td>
                            </tr>
                            @include( 'admin.transacciones.area_estudio_realizado.modales.editModal')

                            {{-- Modal Eliminar --}}
                            <div class="modal fade" id="deleteModal{{ $datos->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $datos->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content modal-modern">
                                        <div class="modal-header-delete">
                                            <div class="modal-icon-delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </div>
                                            <h5 class="modal-title-delete" id="deleteModalLabel{{ $datos->id }}">Confirmar Eliminación</h5>
                                            <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body-delete">
                                            <p class="delete-message">¿Estás seguro de que deseas eliminar esta asignación?</p>
                                            <p class="delete-warning">
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                Esta acción no se puede deshacer
                                            </p>
                                        </div>
                                        <div class="modal-footer-delete">
                                            <form action="{{ url('admin/transacciones/area_estudio_realizado/' . $datos->id) }}" method="POST" class="w-100">
                                                @csrf
                                                @method('DELETE')
                                                <div class="footer-buttons">
                                                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                                        Cancelar
                                                    </button>
                                                    <button type="submit" class="btn-modal-delete">
                                                        <i class="fas fa-trash me-1"></i>
                                                        Eliminar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-inbox"></i>
                                        </div>
                                        <h4>No hay asignaciones registradas</h4>
                                        <p>Comienza creando una nueva asignación usando el botón superior</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('css')
    
@endpush
@endsection