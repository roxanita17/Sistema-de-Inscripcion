@extends('adminlte::page')

@section('css')
    {{-- Estilos modernos reutilizados del sistema --}}
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">

@stop

@section('title', 'Gestión de Docentes')

@section('content_header')
    {{-- Encabezado principal de la página --}}
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <h1 class="title-main">Gestión de Docentes</h1>
                    <p class="title-subtitle">Administración de los docentes</p>
                </div>
            </div>
            {{-- Botón que abre la ventana modal para crear una nueva docente --}}
            <a type="button"
                    class="btn-create"
                    href="{{ route('admin.docente.create') }}"
                    @if(!$anioEscolarActivo) disabled @endif
                    title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Crear nuevo registro' }}">
                <i class="fas fa-plus"></i>
                <span>Nuevo Docente</span>
            </a>
        </div>
    </div>
@stop

@section('content')
<div class="main-container">

    {{-- Modal para crear una nueva docente --}}
{{--     @include('admin.docente.modales.createModal')
 --}}
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

    {{-- Contenedor principal de la tabla de discapacidades --}}
    <div class="card-modern">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-list-ul"></i>
                </div>
                <div>
                    <h3>Listado de Docentes</h3>
                    <p>{{ $docentes->total() }} registros encontrados</p>
                </div>
            </div>
            {{-- Buscador --}}
            <form action="{{ route('admin.docente.index') }}">
                <div class="form-group-modern mb-2">
                    <div class="search-modern"> 
                        <i class="fas fa-search"></i>
                        <input type="text"
                        name="buscar"
                        id="buscar"
                        class="form-control-modern"
                        placeholder="Buscar..."
                        value="{{ request('buscar') }}"
                        >
                    </div>
                    <small class="form-text-modern" style="margin-top: 0.5rem; color: var(--gray-500);  ">
                            <i class="fas fa-info-circle"></i>
                            Buscar por cédula, nombre, apellido, código
                    </small>
                </div>
            </form>
            <div class="header-right">
                

            </div>
            

            <div class="header-right" style="display: flex; gap: 5px;">

                <a href="{{ route('admin.docente.reporteGeneralPDF') }}"
                    type="button"
                    class="btn-pdf"
                    target="_blank">
                    <i class="fas fa-file-pdf"></i> PDF General
                </a>
                <div class="date-badge">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ now()->translatedFormat('d M Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Cuerpo de la tarjeta con la tabla --}}
        <div class="card-body-modern">
            <div class="table-wrapper">
                <table class="table-modern overflow-hidden hidden">
                    <thead>
                        <tr style="text-align: center">
                            <th style="text-align: center">Cédula</th>
                            <th style="text-align: center">Nombre</th>
                            <th style="text-align: center">Apellido</th>
                            <th style="text-align: center">Código</th>
                            <th style="text-align: center">Correo</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center">
                        {{-- Si no hay docentes, se muestra mensaje vacío --}}
                        @if ($docentes->isEmpty())
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-inbox"></i> 
                                        </div>
                                        <h4>No hay docentes registrados</h4>
                                        <p>Agrega un nuevo docente con el botón superior</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            {{-- Se recorren las docentes existentes --}}
                            @foreach ($docentes as $datos)
                                <tr class="table-row-hover row-12" style="text-align: center">
                                    <td class="title-main">{{ $datos->persona->numero_documento }}</td>
                                    <td >{{ $datos->persona->primer_nombre }}</td>
                                    <td >{{ $datos->persona->primer_apellido }}</td>
                                    <td >{{ $datos->codigo }}</td>
                                    <td style="font-style: italic">{{ $datos->persona->email }}</td>
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

                                            {{-- Ver detalles --}}
                                            <button class="action-btn btn-view" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#viewModal{{ $datos->id }}" 
                                                title="Ver Detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            {{-- Editar grado --}}
                                            <a class="action-btn btn-edit"
                                                href="{{ route('admin.docente.edit', $datos->id) }}"
                                                title="Editar" 
                                                @if(!$anioEscolarActivo) disabled @endif
                                                title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Editar' }}">
                                                <i class="fas fa-pen"></i>
                                            </a>

                                            {{-- Eliminar grado --}}
                                            <button class="action-btn btn-delete"
                                                data-bs-toggle="modal"
                                                data-bs-target="#confirmarEliminar{{ $datos->id }}"
                                                title="Eliminar"
                                                @if(!$anioEscolarActivo) disabled @endif
                                                title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Eliminar' }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                            {{-- Botón de reporte individual --}}
                                            <a href="{{ route('admin.docente.reportePDF', $datos->id) }}" 
                                            class="action-btn btn-success" 
                                            title="Generar reporte PDF"
                                            target="_blank">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>

                                            
                                    </td>
                                </tr>
                                {{-- Modal de ver --}}
                                @include('admin.docente.modales.showModal')

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
                                                    <p>¿Deseas eliminar esta docente?</p>
                                                    <p class="delete-warning">
                                                        Esta acción no se puede deshacer.
                                                    </p>
                                                </div>
                                                <div class="modal-footer-delete">
                                                    <form action="{{ url('admin/docente/' . $datos->id) }}" method="POST" class="w-100">
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
<x-pagination :paginator="$docentes" />

@endsection
