@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@stop

@section('title', 'Gestión de Asignaciones')

@section('content_header')
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <h1 class="title-main">Asignación de Docentes</h1>
                    <p class="title-subtitle">Gestión de materias, grados y secciones</p>
                </div>
            </div>

            @if ($percentilEjecutado)
                <a type="button" class="btn-create" href="{{ route('admin.transacciones.docente_area_grado.create') }}"
                    @if (!$anioEscolarActivo) disabled @endif
                    title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Nueva asignación' }}">
                    <i class="fas fa-plus"></i>
                    <span>Nueva Asignación</span>
                </a>
            @else
                 <a type="button" class="btn-create" disabled
                   >
                    <i class="fas fa-plus"></i>
                    <span>Nueva Asignación</span>
                </a>
            @endif
        </div>
    </div>
@stop

@section('content')
    <div class="main-container">
            {{-- Alerta si NO hay año escolar activo --}}
            @if (!$anioEscolarActivo)
                <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Atención: No hay año escolar activo</h5>
                            <p class="mb-0">
                                Puedes ver los registros, pero <strong>no podrás crear, editar o eliminar</strong> hasta que
                                se
                                registre un año escolar activo.
                                <a href="{{ route('admin.anio_escolar.index') }}" class="alert-link">Ir a Año Escolar</a>
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            @if (!$percentilEjecutado)
                <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Atención: Percentil no ejecutado</h5>
                            <p class="mb-0">
                                Debe ejecutar el percentil para poder realizar asignaciones de docentes. <strong>No podrás crear, editar o eliminar registros</strong> hasta que se ejecute el percentil.
                                <a href="{{ route('admin.transacciones.inscripcion.index') }}" class="alert-link">Ir a Inscripción</a>
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Sección de alertas --}}
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
                            <button type="button" class="alert-close btn-close" data-bs-dismiss="alert"
                                aria-label="Cerrar">
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
                            <button type="button" class="alert-close btn-close" data-bs-dismiss="alert"
                                aria-label="Cerrar">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Tabla de docentes --}}
            <div class="card-modern">
                <div class="card-header-modern">
                    <div class="header-left">
                        <div class="header-icon">
                            <i class="fas fa-list-ul"></i>
                        </div>
                        <div>
                            <h3>Listado de Docentes</h3>
                            <p>{{ $docentes->total() }} docentes registrados</p>
                        </div>
                    </div>

                    {{-- Buscador --}}
                    <form action="{{ route('admin.transacciones.docente_area_grado.index') }}">
                        <div class="form-group-modern mb-2">
                            <div class="search-modern">
                                <i class="fas fa-search"></i>
                                <input type="text" name="buscar" id="buscar" class="form-control-modern"
                                    placeholder="Buscar..." value="{{ request('buscar') }}">
                            </div>
                            <small class="form-text-modern" style="margin-top: 0.5rem; color: var(--gray-500);  ">
                                <i class="fas fa-info-circle"></i>
                                Buscar por cédula, nombre, apellido, código
                            </small>
                        </div>
                    </form>

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
    <div class="d-flex align-items-center justify-content-between bg-light rounded px-2 py-1 mb-2 border">
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
    <div class="d-flex align-items-center justify-content-between bg-warning bg-opacity-10 rounded px-2 py-1 mb-2 border border-warning">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle text-warning me-1" style="font-size: 0.8rem;"></i>
            <span class="fw-semibold" style="font-size: 0.8rem;">Sin año activo</span>
        </div>
        
    </div>
@endif
<!-- --------------------------- -->

            </div>

                    <div>
                        <button class="btn-modal-create" data-bs-toggle="modal" data-bs-target="#modalFiltros">
                            <i class="fas fa-filter"></i>
                            Filtros
                        </button>
                    </div>
                    
                </div>
            </div>

                <div class="card-body-modern">
                    <div class="table-wrapper">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th>Cédula</th>
                                    <th>Docente</th>
                                    <th style="text-align: center;">Estudios Realizados</th>
                                    <th style="text-align: center;">Áreas de Formación</th>
                                    <th style="text-align: center;">Años</th>
                                    <th style="text-align: center;">Secciones</th>
                                    <th style="text-align: center; width: 120px;">Estado</th>
                                    <th style="text-align: center; width: 150px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($docentes as $datos)
                                    <tr>
                                        {{-- Datos del docente --}}
                                        <td
                                            style="padding-left: 1rem; font-weight: 600; color: var(--gray-900); font-size: 0.95rem; text-align: center;">
                                            <span>
                                                {{ $datos->persona->tipoDocumento->nombre ?? ' ' }}-{{ $datos->persona->numero_documento }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="cell-content" style="gap: 0.75rem;">
                                                <div>
                                                    {{ $datos->persona->primer_nombre }}
                                                    {{ $datos->persona->primer_apellido }}
                                                </div>
                                            </div>
                                        </td>

                                        <td style="text-align: center;">
                                            @forelse($datos->detalleDocenteEstudio->where('status', true) as $detalle)
                                                <span class="badge-estudio-small"
                                                    title="{{ $detalle->estudiosRealizado->estudios }}">
                                                    <i class="fas fa-graduation-cap"></i>
                                                    {{ Str::limit($detalle->estudiosRealizado->estudios, 20) }}
                                                </span>
                                                @if (!$loop->last)
                                                    <br>
                                                @endif
                                            @empty
                                                <span class="text-muted" style="font-size: 0.85rem;">
                                                    <i class="fas fa-minus-circle"></i>
                                                    Sin estudios
                                                </span>
                                            @endforelse
                                        </td>

                                        {{-- Areas de formacion --}}
                                        <td style="text-align: center;">
                                            @php $asigs = $datos->asignacionesAreas->where('status', true); @endphp

                                            @forelse($asigs as $asign)
                                                <span style="font-weight: bold; margin-bottom: 2rem;"
                                                    title="{{ optional($asign->areaEstudios->areaFormacion)->nombre_area_formacion }}">
                                                    <i class="fas fa-graduation-cap"></i>
                                                    {{ Str::limit(optional($asign->areaEstudios->areaFormacion)->nombre_area_formacion ?? $asign->areaEstudios->id, 20) }}
                                                </span>
                                                @if (!$loop->last)
                                                    <br>
                                                @endif
                                            @empty
                                                <span class="text-muted" style="font-size: 0.85rem;">
                                                    <i class="fas fa-minus-circle"></i> Sin materias asignadas
                                                </span>
                                            @endforelse
                                        </td>

                                        {{-- Grados --}}
                                        <td style="text-align: center;">
                                            @php $asigs = $datos->asignacionesAreas->where('status', true); @endphp

                                            @forelse($asigs as $asign)
                                                <span style="font-weight: bold; margin-bottom: 2rem;"
                                                    title="{{ optional($asign->grado)->numero_grado }}">
                                                    <i class="fas "></i>
                                                    {{ $asign->grado->numero_grado }}
                                                </span>
                                                @if (!$loop->last)
                                                    <br>
                                                @endif
                                            @empty
                                                <span class="text-muted" style="font-size: 0.85rem;">
                                                    <i class="fas fa-minus-circle"></i> Sin años asignados
                                                </span>
                                            @endforelse
                                        </td>

                                        {{-- Secciones --}}
                                        <td style="text-align: center;">
                                            @php $asigs = $datos->asignacionesAreas->where('status', true); @endphp

                                            @forelse($asigs as $asign)
                                                <span style="font-weight: bold; margin-bottom: 2rem;"
                                                    title="{{ optional($asign->seccion)->nombre }}">
                                                    <i class="fas "></i>
                                                    {{ $asign->seccion->nombre }}
                                                </span>
                                                @if (!$loop->last)
                                                    <br>
                                                @endif
                                            @empty
                                                <span class="text-muted" style="font-size: 0.85rem;">
                                                    <i class="fas fa-minus-circle"></i> Sin secciones asignadas
                                                </span>
                                            @endforelse
                                        </td>

                                        {{-- Status --}}
                                        <td style="text-align: center;">
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
                                                                data-bs-target="#viewModal{{ $datos->id }}"
                                                                title="Ver detalles">
                                                                <i class="fas fa-eye me-2"></i>
                                                                Ver más
                                                            </button>
                                                        </li>

                                                        {{-- Editar --}}
                                                        <a class="dropdown-item d-flex align-items-center text-warning"
                                                            type="button"
                                                            href="{{ route('admin.transacciones.docente_area_grado.edit', $datos->id) }}"
                                                            title="Editar"
                                                            @if (!$anioEscolarActivo) disabled @endif
                                                            title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Editar' }}"
                                                            title="Editar ">
                                                            <i class="fas fa-pen me-2"></i>
                                                            Editar
                                                        </a>

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

                                                        {{-- Reporte PDF --}}
                                                        <li>
                                                            {{-- <a class="dropdown-item d-flex align-items-center text-danger"
                                                            type="button"
                                                            href="{{ route('admin.docente.reportePDF', $datos->id) }}"
                                                            target="_blank" title="Generar reporte PDF">
                                                            <i class="fas fa-file-pdf me-2"></i>
                                                            PDF
                                                        </a> --}}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>




                                        </td>
                                    </tr>
                                    {{-- Ruta de ver detalle --}}
                                    @include('admin.transacciones.docente_area_grado.modales.showModal')

                                    {{-- Modal de confirmación para eliminar --}}
                                    <div class="modal fade" id="confirmarEliminar{{ $datos->id }}" tabindex="-1"
                                        aria-labelledby="modalLabel{{ $datos->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content modal-modern">
                                                <div class="modal-header-delete">
                                                    <div class="modal-icon-delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </div>
                                                    <h5 class="modal-title-delete">Confirmar Inactivación</h5>
                                                    <button type="button" class="btn-close-modal"
                                                        data-bs-dismiss="modal" aria-label="Cerrar">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body-delete">
                                                    <p>¿Deseas inactivar esta asignación?</p>
                                                    <p class="delete-warning">
                                                        {{-- La asignación se marcará como inactiva pero los datos permanecerán en el
                                                    sistema. --}}
                                                    </p>
                                                </div>
                                                <div class="modal-footer-delete">
                                                    <form
                                                        action="{{ route('admin.transacciones.docente_area_grado.destroyAsignacion', $datos->id) }}"
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
                                @empty
                                    <tr>
                                        <td colspan="10">
                                            <div class="empty-state">
                                                <div class="empty-icon">
                                                    <i class="fas fa-user-slash"></i>
                                                </div>
                                                <h4>No hay docentes con materias y años asignados</h4>
                                                <p>Debe registrar docentes primero en el módulo de Docentes y asignarles
                                                    materias y años</p>
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
    @include('admin.transacciones.docente_area_grado.modales.filtroModal')

    {{-- Paginación --}}
    <x-pagination :paginator="$docentes" />



@endsection
