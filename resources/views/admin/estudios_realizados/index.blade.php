@extends('adminlte::page')

@section('css')
    {{-- Estilos modernos reutilizados del sistema --}}
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">

@stop

@section('title', 'Gestión de Estudios Realizados')

@section('content_header')
    {{-- Encabezado principal de la página --}}
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">

                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <h1 class="title-main">Gestión de Estudios Realizados</h1>
                    <p class="title-subtitle">Administración de los estudios realizados</p>
                </div>
            </div>

            {{-- Botón que abre la ventana modal para crear una nuevo estudio realizado --}}
            <button type="button" class="btn-create" data-bs-toggle="modal" data-bs-target="#modalCrearEstudio"
                @if (!$anioEscolarActivo) disabled @endif
                title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Nueva Asignación' }}">
                <i class="fas fa-plus"></i>
                <span>Nuevo Estudio Realizado</span>
            </button>
        </div>
    </div>
@stop

@section('content')
    <div class="main-container">

        {{-- Modal para crear una nuevo estudio realizado --}}
        @include('admin.estudios_realizados.modales.createModal')

        {{-- Alerta si NO hay año escolar activo --}}
        @if (!$anioEscolarActivo)
            <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-1">Atención: No hay año escolar activo</h5>
                        <p class="mb-0">
                            Puedes ver los registros, pero <strong>no podrás crear, editar o eliminar</strong> hasta que se
                            registre un año escolar activo.
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

        {{-- Contenedor principal de la tabla de estudios realizados --}}
        <div class="card-modern">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-list-ul"></i>
                    </div>
                    <div>
                        <h3>Listado de Estudios Realizados</h3>
                        <p>{{ $estudiosRealizados->total() }} registros encontrados</p>
                    </div>
                </div>
                {{-- Buscador --}}
                <form action="{{ route('admin.estudios_realizados.index') }}">
                    <div class="form-group-modern mb-2">
                        <div class="search-modern">
                            <i class="fas fa-search"></i>
                            <input type="text" name="buscar" id="buscar" class="form-control-modern"
                                placeholder="Buscar..." value="{{ request('buscar') }}">
                        </div>
                        <small class="form-text-modern" style="margin-top: 0.5rem; color: var(--gray-500);">
                            <i class="fas fa-info-circle"></i>
                            Buscar por nombre de estudio o ID
                        </small>
                    </div>
                </form>

                <div class="header-right">
                    <!-- --------------------------- -->

                    @php
                        $anioActivo = \App\Models\AnioEscolar::activos()->first();
                        $anioExtendido = \App\Models\AnioEscolar::where('status', 'Extendido')->first();
                        $mostrarAnio = $anioActivo ?? $anioExtendido;
                    @endphp

                    @if ($mostrarAnio)
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
                        <div
                            class="d-flex align-items-center justify-content-between bg-warning bg-opacity-10 rounded px-2 py-1  border border-warning">
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
                                <th style="text-align: center">#</th>
                                <th style="text-align: center">Estudio Realizado</th>
                                <th style="text-align: center">Estado</th>
                                <th style="text-align: center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center">
                            {{-- Si no hay estudios realizados, se muestra mensaje vacío --}}
                            @if ($estudiosRealizados->isEmpty())
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-inbox"></i>
                                            </div>
                                            <h4>No hay estudios realizados registrados</h4>
                                            <p>Agrega uno nuevo con el botón superior</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                {{-- Se recorren las estudios realizados existentes --}}
                                @foreach ($estudiosRealizados as $index => $datos)
                                    <tr class="  row-12" style="text-align: center">
                                        <td>{{ $index + 1 }}</td>
                                        <td class="title-main">{{ $datos->estudios }}</td>
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
                                            {{-- BOTONES DE ACCIONES --}}
                                            <div class="action-buttons">
                                                <div class="dropdown dropstart text-center">
                                                    <button
                                                        class="btn btn-light btn-sm rounded-circle shadow-sm action-btn"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                        {{-- Editar --}}
                                                        <li>
                                                            <button
                                                                class="dropdown-item d-flex align-items-center text-warning"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#viewModalEditar{{ $datos->id }}"
                                                                title="Editar"
                                                                @if (!$anioEscolarActivo) disabled @endif
                                                                title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Editar' }}">
                                                                <i class="fas fa-pen me-2"></i>
                                                                Editar
                                                            </button>
                                                        </li>

                                                        {{-- Inactivar --}}
                                                        <li>
                                                            <button
                                                                class="dropdown-item d-flex align-items-center text-danger"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#confirmarEliminar{{ $datos->id }}"
                                                                @disabled(!$anioEscolarActivo) title="Inactivar año escolar">
                                                                <i class="fas fa-ban me-2"></i>
                                                                Inactivar
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Ruta modal de editar --}}
                                    @include('admin.estudios_realizados.modales.editModal')

                                    {{-- Modal de confirmación para eliminar --}}
                                    <div class="modal fade" id="confirmarEliminar{{ $datos->id }}" tabindex="-1"
                                        aria-labelledby="modalLabel{{ $datos->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content modal-modern">
                                                <div class="modal-header-delete">
                                                    <div class="modal-icon-delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </div>
                                                    <h5 class="modal-title-delete">Confirmar Inactivacion</h5>
                                                    <button type="button" class="btn-close-modal"
                                                        data-bs-dismiss="modal" aria-label="Cerrar">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body-delete">
                                                    <p>¿Deseas inactivar este estudio realizado?</p>
                                                    <p class="delete-warning">

                                                    </p>
                                                </div>
                                                <div class="modal-footer-delete">
                                                    <form action="{{ url('admin/estudios_realizados/' . $datos->id) }}"
                                                        method="POST" class="w-100">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="footer-buttons">
                                                            <button type="button" class="btn-modal-cancel"
                                                                data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit"
                                                                class="btn-modal-delete">Inactivar</button>
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
    <x-pagination :paginator="$estudiosRealizados" />

    @push('js')
        <script src="{{ asset('js/validations/estudios_realizados.js') }}"></script>
    @endpush

@endsection
