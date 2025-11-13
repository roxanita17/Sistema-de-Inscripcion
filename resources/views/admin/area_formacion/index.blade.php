@extends('adminlte::page')

@section('css')
{{-- Estilos modernos reutilizados del sistema --}}
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@stop

@section('title', 'Gestión de Áreas de Formación')

@section('content_header')
{{-- Encabezado principal de la página --}}
<div class="content-header-modern">
    <div class="header-content">
        <div class="header-title">
            <div class="icon-wrapper">
                <i class="fas fa-book"></i>
            </div>
            <div>
                <h1 class="title-main">Gestión de Áreas de Formación</h1>
                <p class="title-subtitle">Administración de materias y grupos estables</p>
            </div>
        </div>
        <div class="header-right">
            <div class="date-badge">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ now()->translatedFormat('d M Y') }}</span>
            </div>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="main-container">

    {{-- Modal de crear área de formación --}}
    @include('admin.area_formacion.modales.createModal')

    {{-- Sección de alertas --}}
    @if (session('success') || session('error'))
        <div class="alerts-container">
            @if (session('success'))
                <div class="alert-modern alert-success alert alert-dismissible fade show" role="alert">
                    <div class="alert-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="alert-content">
                        <h4>Éxito</h4>
                        <p>{{ session('success') }}</p>
                    </div>
                    <button type="button" class="alert-close btn-close" data-bs-dismiss="alert">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert-modern alert-error alert alert-dismissible fade show" role="alert">
                    <div class="alert-icon"><i class="fas fa-exclamation-circle"></i></div>
                    <div class="alert-content">
                        <h4>Error</h4>
                        <p>{{ session('error') }}</p>
                    </div>
                    <button type="button" class="alert-close btn-close" data-bs-dismiss="alert">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
        </div>
    @endif

    {{-- Tabla de Áreas de Formación --}}
    <div class="card-modern">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon"><i class="fas fa-list-ul"></i></div>
                <div>
                    <h3>Materias activas</h3>
                    <p>{{ $areaFormacion->total() }} registros encontrados</p>
                </div>
            </div>
            
            {{-- Botón que abre la modal para crear un nuevo área --}}
            <button type="button" class="btn-create" data-bs-toggle="modal" data-bs-target="#modalCrearAreaFormacion">
                <i class="fas fa-plus"></i>
                <span>Nuevo Área</span>
            </button>
        </div>

        <div class="card-body-modern">
            <div class="table-wrapper">
                <table class="table-modern overflow-hidden hidden">
                    <thead>
                        <tr style="text-align: center">
                            <th>#</th>
                            <th>Área de formación</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center">
                        @if($areaFormacion->isEmpty())
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                                        <h4>No hay áreas de formación registradas</h4>
                                        <p>Agrega una nueva área de formación con el botón superior</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach($areaFormacion as $index => $datos)
                                @if($datos->status)
                                    <tr class="table-row-hover row-12">
                                        <td>{{ $index + 1 }}</td>
                                        <td class="title-main">{{ $datos->nombre_area_formacion }}</td>
                                        <td>
                                            <span class="status-badge status-active">
                                                <span class="status-dot"></span>
                                                Activo
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                {{-- Editar área --}}
                                                <button class="action-btn btn-edit" data-bs-toggle="modal" data-bs-target="#viewModalEditar{{ $datos->id }}" title="Editar">
                                                    <i class="fas fa-pen"></i>
                                                </button>

                                                {{-- Eliminar área --}}
                                                <button class="action-btn btn-delete" data-bs-toggle="modal" data-bs-target="#confirmarEliminar{{ $datos->id }}" title="Inactivar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Modal de editar --}}
                                    @include('admin.area_formacion.modales.editModal')

                                    {{-- Modal de confirmación para eliminar --}}
                                    <div class="modal fade" id="confirmarEliminar{{ $datos->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $datos->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content modal-modern">
                                                <div class="modal-header-delete">
                                                    <div class="modal-icon-delete"><i class="fas fa-trash-alt"></i></div>
                                                    <h5 class="modal-title-delete">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body-delete">
                                                    <p>¿Deseas eliminar esta área de formación?</p>
                                                    <p class="delete-warning">Esta acción no se puede deshacer.</p>
                                                </div>
                                                <div class="modal-footer-delete">
                                                    <form action="{{ route('admin.area_formacion.destroy', $datos->id) }}" method="POST" class="w-100">
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

                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Paginación moderna --}}
    <x-pagination :paginator="$areaFormacion" />



    {{-------                 -----------
               GRUPOS ESTABLES
    ----------                 ----------}}


    {{-- Modal para crear un nuevo grupo estable --}}
    @include('admin.area_formacion.modalesGrupoEstable.createModalGrupoEstable')

    {{-- Tabla de Grupos Estables --}}
    <div class="card-modern mt-3">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon"><i class="fas fa-list-ul"></i></div>
                <div>
                    <h3>Grupos Estables activos</h3>
                    <p>{{ $grupoEstable->total() }} registros encontrados</p>
                </div>
            </div>
            {{-- Botón que abre la modal para crear un nuevo grupo estable --}}
            <button type="button" class="btn-create" data-bs-toggle="modal" data-bs-target="#modalCrearGrupoEstable">
                <i class="fas fa-plus"></i>
                <span>Nuevo Grupo Estable</span>
            </button>
            
        </div>

        <div class="card-body-modern">
            <div class="table-wrapper">
                <table class="table-modern overflow-hidden hidden">
                    <thead>
                        <tr style="text-align: center">
                            <th style="text-align: center">#</th>
                            <th style="text-align: center">Grupo estable</th>
                            <th style="text-align: center">Estado</th>
                            <th style="text-align: center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center">
                        @if($grupoEstable->isEmpty())
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                                        <h4>No hay grupos estables registrados</h4>
                                        <p>Agrega un nuevo grupo estable con el botón superior</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach($grupoEstable as $index => $grupo)
                                @if($grupo->status)
                                    <tr class="table-row-hover row-12">
                                        <td>{{ $index + 1 }}</td>
                                        <td class="title-main">{{ $grupo->nombre_grupo_estable }}</td>
                                        <td>
                                            @if ($grupo->status)
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
                                        <td class="action-buttons">
                                            {{-- Editar grupo estable --}}
                                            <button class="action-btn btn-edit" data-bs-toggle="modal" data-bs-target="#viewModalEditarGrupoEstable{{ $grupo->id }}">
                                                <i class="fas fa-pen"></i>
                                            </button>

                                            {{-- Eliminar grupo estable --}}
                                            <button class="action-btn btn-delete" data-bs-toggle="modal" data-bs-target="#confirmarEliminarGrupo{{ $grupo->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- Modal de editar --}}
                                    @include('admin.area_formacion.modalesGrupoEstable.editModalGrupoEstable')

                                    {{-- Modal de confirmación para eliminar --}}
                                    <div class="modal fade" id="confirmarEliminarGrupo{{ $grupo->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $grupo->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content modal-modern">
                                                <div class="modal-header-delete">
                                                    <div class="modal-icon-delete"><i class="fas fa-trash-alt"></i></div>
                                                    <h5 class="modal-title-delete">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body-delete">
                                                    <p>¿Deseas eliminar este grupo estable?</p>
                                                    <p class="delete-warning">Esta acción no se puede deshacer.</p>
                                                </div>
                                                <div class="modal-footer-delete">
                                                    <form action="{{ route('admin.area_formacion.modalesGrupoEstable.destroyGrupoEstable', $grupo->id) }}" method="POST" class="w-100">
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

                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Paginación moderna --}}
    <x-pagination :paginator="$grupoEstable" />

</div>
@endsection
