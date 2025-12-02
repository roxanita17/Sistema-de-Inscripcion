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

            <a type="button"
                    class="btn-create"
                    href="{{ route('admin.transacciones.docente_area_grado.create') }}"
                    @if(!$anioEscolarActivo) disabled @endif
                    title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Nueva asignación' }}">
                <i class="fas fa-plus"></i>
                <span>Nueva Asignación</span>
            </a>
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
                        Puedes ver los registros, pero <strong>no podrás crear, editar o eliminar</strong> hasta que se registre un año escolar activo.
                        <a href="{{ route('admin.anio_escolar.index') }}" class="alert-link">Ir a Año Escolar</a>
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
                <div class="date-badge">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ now()->translatedFormat('d M Y') }}</span>
                </div>
            </div>
        </div>

        <div class="card-body-modern">
            <div class="table-wrapper">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th >Cédula</th>
                            <th>Docente</th>
                            <th style="text-align: center;">Estudios Realizados</th>
                            <th style="text-align: center;">Áreas de Formación</th>
                            <th style="text-align: center; width: 120px;">Estado</th>
                            <th style="text-align: center; width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($docentes as $docente)
                            <tr class="table-row-hover">
                                
                                <td style="padding-left: 1rem; font-weight: 600; color: var(--gray-900); font-size: 0.95rem; text-align: center;">
                                    <span>
                                        {{ $docente->persona->tipoDocumento->nombre ?? ' ' }}-{{ $docente->persona->numero_documento }}
                                    </span>
                                </td>
                                
                                <td>
                                    <div class="cell-content" style="gap: 0.75rem;">
                                        <div >
                                            {{ $docente->persona->primer_nombre }}
                                            {{ $docente->persona->primer_apellido }}
                                        </div>
                                    </div>
                                </td>
                                
                                <td style="text-align: center;">
                                    @forelse($docente->detalleDocenteEstudio->where('status', true) as $detalle)
                                        <span class="badge-estudio-small" title="{{ $detalle->estudiosRealizado->estudios }}">
                                            <i class="fas fa-graduation-cap"></i>
                                            {{ Str::limit($detalle->estudiosRealizado->estudios, 20) }}
                                        </span>
                                        @if(!$loop->last)<br>@endif
                                    @empty
                                        <span class="text-muted" style="font-size: 0.85rem;">
                                            <i class="fas fa-minus-circle"></i>
                                            Sin estudios
                                        </span>
                                    @endforelse
                                </td>

                                <td style="text-align: center;">
                                    @php $asigs = $docente->asignacionesAreas->where('status', true); @endphp

                                    @forelse($asigs as $asign)
                                        <span class="badge-estudio-small" title="{{ optional($asign->areaEstudios->areaFormacion)->nombre_area_formacion }}">
                                            <i class="fas fa-graduation-cap"></i>
                                            {{ Str::limit(optional($asign->areaEstudios->areaFormacion)->nombre_area_formacion ?? $asign->areaEstudios->id, 20) }}
                                        </span>
                                        @if(!$loop->last) <br> @endif
                                    @empty
                                        <span class="text-muted" style="font-size: 0.85rem;">
                                            <i class="fas fa-minus-circle"></i> Sin materias asignadas
                                        </span>
                                    @endforelse
                                </td>

                                <td style="text-align: center;">
                                    @if ($docente->status)
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
                                                data-bs-target="#viewModal{{ $docente->id }}" 
                                                title="Ver Detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                        {{-- Editar grado --}}
                                        <a class="action-btn btn-edit"
                                            href="{{ route('admin.transacciones.docente_area_grado.edit', $docente->id) }}"
                                            title="Editar" 
                                            @if(!$anioEscolarActivo) disabled @endif
                                            title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Editar' }}">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        {{-- Eliminar grado --}}
                                        <button class="action-btn btn-delete"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#confirmarEliminar{{ $docente->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            {{-- Ruta de ver detalle --}}
                            @include('admin.transacciones.docente_area_grado.modales.showModal')

                             {{-- Modal de confirmación para eliminar --}}               
                            <div class="modal fade" id="confirmarEliminar{{ $docente->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $docente->id }}" aria-hidden="true">
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
                                            <form action="{{route('admin.transacciones.docente_area_grado.destroyAsignacion', $docente->id) }}" method="POST" class="w-100">
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
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-user-slash"></i>
                                        </div>
                                        <h4>No hay docentes con materias y grados asignados</h4>
                                        <p>Debe registrar docentes primero en el módulo de Docentes y asignarles materias y grados</p>
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

{{-- Paginación --}}
<x-pagination :paginator="$docentes" />



@endsection
