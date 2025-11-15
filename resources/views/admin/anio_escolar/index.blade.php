@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@stop

@section('title', 'Gestión de Años Escolares')

@section('content_header')
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-university"></i>
                </div>
                <div>
                    <h1 class="title-main">Gestión de Años Escolares</h1>
                    <p class="title-subtitle">Gestión de años escolares</p>
                </div>
            </div>

            <!-- Botón para abrir la modal de crear año escolar -->
            <button type="button" class="btn-create" data-bs-toggle="modal" data-bs-target="#modalCrearAnioEscolar">
                <i class="fas fa-plus"></i>
                <span>Nuevo Año Escolar</span>
            </button>
        </div>
    </div>

@stop

@section('content')
    {{-- Alerta si no hay año escolar activo --}}
    @php
        $anioEscolarActivo = \App\Models\AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();
    @endphp

    @if (!$anioEscolarActivo)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                <div>
                    <h5 class="alert-heading mb-1">No hay año escolar activo</h5>
                    <p class="mb-0">Debe registrar un año escolar activo para poder utilizar los demás módulos del sistema.</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Alertas de sesión --}}
    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle"></i>
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

        {{-- Tabla de años escolares --}}
        <div class="card-modern">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-list-ul"></i>
                    </div>
                    <div>
                        <h3>Listado de Años Escolares</h3>
                        <p>{{ $escolar->count() }} registros encontrados</p>
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
                    <table class="table-modern overflow-hidden hidden">
                        <thead>
                           <tr style="text-align: center">
                                <th width="60">#</th>
                                <th style="text-align: center">Inicio</th>
                                <th style="text-align: center">Cierre</th>
                                <th  style="text-align: center">Estado</th>
                                <th  style="text-align: center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center">
                            @forelse ($escolar as $index => $datos)
                                <tr class="table-row-hover row-12" style="text-align: center">
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        <span class="fw-semibold">{{ $datos->inicio_anio_escolar ?? '—' }}</span>
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar text-primary me-2"></i>
                                        <span class="fw-semibold">{{ $datos->cierre_anio_escolar ?? '—' }}</span>
                                    </td>
                                    <td>
                                        @if ($datos->status == 'Activo')
                                            <span class="status-badge status-active">
                                                <span class="status-dot"></span>
                                                Activo
                                            </span>
                                        @elseif ($datos->status == 'Extendido')
                                            <span class="status-badge status-extended">
                                                <span class="status-dot"></span>
                                                Extendido
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
                                            <button class="action-btn btn-view" data-bs-toggle="modal" data-bs-target="#viewModal{{ $datos->id }}" title="Ver Detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            

                                            {{-- Extender --}}
                                            <button type="button" class="action-btn btn-edit" data-bs-toggle="modal" data-bs-target="#viewModalExtender{{ $datos->id }}" title="Editar">
                                                <i class="fas fa-calendar-plus"></i>
                                            </button>
                                            

                                            {{-- Eliminar --}}
                                            <button type="button" class="action-btn btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $datos->id }}" title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>

                                        
                                    </td>
                                </tr>
                                {{-- Modal Crear --}}
                                @include('admin.anio_escolar.modales.createModal')

                                
                                {{-- Modal Extender --}}
                                @include('admin.anio_escolar.modales.extenderModal')

                                {{-- Modal Ver --}}
                                @include('admin.anio_escolar.modales.showModal')

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
                                                        <p class="delete-message">¿Estás seguro de que deseas eliminar este año escolar?</p>
                                                        <p class="delete-warning">
                                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                                            Esta acción no se puede deshacer
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer-delete">
                                                        <form action="{{ url('admin/anio_escolar/' . $datos->id) }}" method="POST" class="w-100">
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




    {{-- Contenedor de alertas --}}
{{--     <div id="contenedorAlertas"></div>
 --}}
    {{-- Tabla de años escolares --}}
    {{-- <div class="table-responsive">
        <table class="table table-striped align-middle text-center" id="tablaAnioEscolar">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Inicio</th>
                    <th>Cierre</th>
                    <th>Estado</th>
{{--                     <th>Creado por</th> 
                    <th>Fecha de creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbodyAnioEscolar">
                @foreach ($escolar as $datos)
                <tr>
                    <td>{{ $datos->id }}</td>
                    <td>{{ $datos->inicio_anio_escolar }}</td>
                    <td>{{ $datos->cierre_anio_escolar }}</td>
                    <td>
                        @if ($datos->status == 'Activo')
                            <span class="badge bg-success">Activo</span>
                        @elseif ($datos->status == 'Extendido')
                            <span class="badge bg-warning text-dark">Extendido</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </td>
{{--                     <td>{{ $datos->user->name ?? 'No registrado' }}</td> 
                    <td>{{ $datos->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        {{-- 🔹 Ver detalles 
                        <a href="#viewModal{{ $datos->id }}" 
                            class="btn btn-info btn-sm" 
                            title="Ver detalles"
                            data-bs-toggle="modal" 
                            data-bs-target="#viewModal{{ $datos->id }}">
                            <i class="fas fa-eye"></i>
                        </a>

                        @include('admin.anio_escolar.modales.showModal')

                        {{-- 🔹 Extender 
                        <a href="#viewModalExtender{{ $datos->id }}" 
                            class="btn btn-warning btn-sm" 
                            title="Extender"
                            data-bs-toggle="modal" 
                            data-bs-target="#viewModalExtender{{ $datos->id }}">
                            <i class="fas fa-calendar-plus"></i>
                        </a>

                        @include('admin.anio_escolar.modales.extenderModal')

                        <!-- Botón que abre el modal -->
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#confirmarEliminar{{ $datos->id }}" title="Inactivar">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                        <div class="modal fade" id="confirmarEliminar{{ $datos->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modalLabel{{ $datos->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLabel{{ $datos->id }}">
                                                            Confirmar Inactivación</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Cerrar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿Estás seguro de que deseas inactivar este año escolar?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ url('admin/anio_escolar/' . $datos->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit"
                                                                class="btn btn-danger">Inactivar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}
</div>

<x-pagination :paginator="$escolar" />


@endsection


