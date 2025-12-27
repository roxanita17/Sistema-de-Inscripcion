@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@stop

@section('title', 'Gestión de inscripciones')

@section('content_header')
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <h1 class="title-main">Gestión de inscripciones de prosecucion</h1>
                    <p class="title-subtitle">
                        Administración de las inscripciones de prosecucion
                    </p>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <a href="{{ route('admin.transacciones.inscripcion_prosecucion.create') }}"
                        class="btn-create" @if (!$anioEscolarActivo) disabled @endif
                        title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Crear nueva inscripción' }}">
                        <i class="fas fa-plus"></i>
                        <span>Inscripcion Prosecucion</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop


@section('content')
    <div class="main-container">
        @if (!$anioEscolarActivo)
            <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-1">Atención: No hay año escolar activo</h5>
                        <p class="mb-0">
                            Puedes ver los registros, pero <strong>no podrás crear, editar o eliminar</strong>
                            inscripciones.
                            <a href="{{ route('admin.anio_escolar.index') }}" class="alert-link">Ir a Año Escolar</a>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- ALERTAS --}}
        @if (session('success') || session('error'))
            <div class="alerts-container">
                @if (session('success'))
                    <div class="alert-modern alert-success alert alert-dismissible fade show">
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
                    <div class="alert-modern alert-error alert alert-dismissible fade show">
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

        {{-- Filtros activos --}}
        @if (request('grado_id') || request('seccion_id') || request('tipo_inscripcion'))
            <div class="card-modern filtros-simple mb-3">
                <div class="filtros-simple-content">

                    <div class="filtros-text">
                        <i class="fas fa-filter"></i>
                        <span>Filtros activos:</span>

                        @if (request('tipo_inscripcion'))
                            <span class="badge-filtros-small">
                                {{ request('tipo_inscripcion') == 'nuevo_ingreso' ? 'Nuevo Ingreso' : 'Prosecución' }}
                            </span>
                        @endif

                        @if (request('grado_id'))
                            <span class="badge-filtros-small">
                                Grado {{ $grados->find(request('grado_id'))->numero_grado ?? 'N/A' }}
                            </span>
                        @endif

                        @if (request('seccion_id'))
                            <span class="badge-filtros-small">
                                Sección {{ $secciones->find(request('seccion_id'))->nombre ?? 'N/A' }}
                            </span>
                        @endif
                    </div>

                    <a href="{{ route('admin.transacciones.inscripcion_prosecucion.index') }}" class="btn-clear-simple">
                        <i class="fas fa-times"></i>
                    </a>

                </div>
            </div>
        @endif




        <div class="card-modern">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon"><i class="fas fa-list-ul"></i></div>
                    <div>
                        <h3>Listado de inscripciones</h3>
                    </div>
                </div>

                {{-- Buscador --}}
                <form action="{{ route('admin.transacciones.inscripcion_prosecucion.index') }}">
                    {{-- Mantener filtros en búsqueda --}}
                    <input type="hidden" name="grado_id" value="{{ request('grado_id') }}">
                    <input type="hidden" name="seccion_id" value="{{ request('seccion_id') }}">
                    <input type="hidden" name="tipo_inscripcion" value="{{ request('tipo_inscripcion') }}">

                    <div class="form-group-modern mb-2">
                        <div class="search-modern">
                            <i class="fas fa-search"></i>
                            <input type="text" name="buscar" id="buscar" class="form-control-modern"
                                placeholder="Buscar..." value="{{ request('buscar') }}">
                        </div>
                    </div>
                </form>

                {{-- Boton de filtros --}}
                <div>
                    <button class="btn-modal-create" data-bs-toggle="modal" data-bs-target="#modalFiltros">
                        <i class="fas fa-filter"></i>
                        Filtros
                        @if (request('grado_id') || request('seccion_id') || request('tipo_inscripcion'))
                            <span class="badge bg-danger ms-1">
                                {{ collect([request('grado_id'), request('seccion_id'), request('tipo_inscripcion')])->filter()->count() }}
                            </span>
                        @endif
                    </button>
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
                    <table class="table-modern ">
                        <thead>
                            <tr class="text-center">
                                <th style="font-weight: bold">Cedula</th>
                                <th class="text-center">Estudiante</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Representante Legal</th>
                                <th class="text-center">Parentesco</th>
                                <th class="text-center">Año</th>
                                <th class="text-center">Sección</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="text-center">
                            @if ($prosecuciones->isEmpty())
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                                            <h4>No hay inscripciones registradas</h4>
                                            <p>
                                                @if (request('grado_id') || request('seccion_id') || request('tipo_inscripcion') || request('buscar'))
                                                    No se encontraron resultados con los filtros aplicados
                                                @else
                                                    Agrega una nueva inscripción con el botón superior
                                                @endif
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                @foreach ($prosecuciones as $datos)
                                    <tr class="row-12">

                                        {{-- NUMERO --}}
                                        <td style="font-weight: bold">
                                            {{ $datos->inscripcion->alumno->persona->tipoDocumento->nombre }}-{{ $datos->inscripcion->alumno->persona->numero_documento }}
                                        </td>

                                        {{-- ESTUDIANTE --}}
                                        <td class="tittle-main fw-bold">
                                            {{ $datos->inscripcion->alumno->persona->primer_nombre }}
                                            {{ $datos->inscripcion->alumno->persona->primer_apellido }}
                                            <br>
                                            <small>
                                                Edad: {{ $datos->inscripcion->alumno->persona->fecha_nacimiento->age }} |
                                                Peso: {{ $datos->inscripcion->alumno->peso }} |
                                                Estatura: {{ $datos->inscripcion->alumno->estatura }}
                                            </small>
                                        </td>

                                        {{-- TIPO DE INSCRIPCIÓN --}}
                                        <td class="text-center">
                                            <span class="badge bg-success">Prosecución</span>
                                        </td>


                                        {{-- REPRESENTANTE LEGAL --}}
                                        <td class="text-center">
                                            {{ $datos->inscripcion->representanteLegal->representante->persona->primer_nombre }}
                                            {{ $datos->inscripcion->representanteLegal->representante->persona->primer_apellido }}
                                        </td>

                                        {{-- PARENTESCO --}}
                                        <td class="text-center">
                                            {{ $datos->inscripcion->representanteLegal->parentesco ?? 'No especificado' }}
                                        </td>

                                        {{-- GRADO --}}
                                        <td class="text-center">
                                            {{ $datos->grado?->numero_grado ?? 'N/A' }}
                                        </td>


                                        {{-- SECCION --}}
                                        <td class="text-center">
                                            {{ $datos->seccion?->nombre ?? 'N/A' }}
                                        </td>

                                        {{-- STATUS --}}
                                        <td class="text-center">
                                            @if ($datos->status === 'Activo')
                                                <span class="status-badge status-active">
                                                    <span class="status-dot"></span> Activo
                                                </span>
                                            @elseif ($datos->status === 'Pendiente')
                                                <span class="status-badge status-pending">
                                                    <span class="status-dot"></span> Pendiente
                                                </span>
                                            @else
                                                <span class="status-badge status-inactive">
                                                    <span class="status-dot"></span> Inactivo
                                                </span>
                                            @endif
                                        </td>

                                        {{-- ACCIONES --}}
                                        <td>
                                            <div class="action-buttons">
                                                <div class="dropdown dropstart text-center">
                                                    <button
                                                        class="btn btn-light btn-sm rounded-circle shadow-sm action-btn"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>

                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                        {{-- Ver mas --}}
                                                        <li>
                                                            <button
                                                                class="dropdown-item d-flex align-items-center text-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#viewModal{{ $datos->id }}">
                                                                <i class="fas fa-eye me-2"></i>
                                                                Ver mas
                                                            </button>
                                                        </li>

                                                        {{-- Inactivar --}}
                                                        <li>
                                                            <button
                                                                class="dropdown-item d-flex align-items-center text-danger"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#confirmarEliminar{{ $datos->id }}"
                                                                @disabled(!$anioEscolarActivo)>
                                                                <i class="fas fa-ban me-2"></i>
                                                                Inactivar
                                                            </button>
                                                        </li>


                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Modal de ver --}}
                                    {{-- @include('admin.transacciones.inscripcion.modales.showModal') --}}
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- MODAL DE INACTIVACIÓN --}}
                @foreach ($prosecuciones as $datos)
                    <div class="modal fade" id="confirmarEliminar{{ $datos->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content modal-modern">

                                <div class="modal-header-delete">
                                    <div class="modal-icon-delete">
                                        <i class="fas fa-ban"></i>
                                    </div>
                                    <h5 class="modal-title-delete">Confirmar inactivación</h5>
                                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>

                                <div class="modal-body-delete">
                                    <p>¿Deseas inactivar esta inscripción?</p>
                                    <p class="delete-warning">
                                        El estudiante también será inactivado.
                                    </p>
                                </div>

                                <div class="modal-footer-delete">
                                    <form action="{{ route('admin.transacciones.inscripcion.destroy', $datos->id) }}"
                                        method="POST" class="w-100">
                                        @csrf
                                        @method('DELETE')

                                        <div class="footer-buttons">
                                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                                Cancelar
                                            </button>

                                            <button type="submit" class="btn-modal-delete">
                                                Inactivar
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Modal de filtros --}}
                @include('admin.transacciones.inscripcion_prosecucion.modales.filtroModal')
            </div>
            <div class="mt-3" style="display:flex; align-items:center; position:relative;">
                <div style="margin: 0 auto;">
                    <x-pagination :paginator="$prosecuciones" />
                </div>
            </div>
        </div>
    </div>
@endsection
