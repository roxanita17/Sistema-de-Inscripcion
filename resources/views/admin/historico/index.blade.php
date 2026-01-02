@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
@stop

@section('title', 'Histórico Académico')

@section('content_header')
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-history"></i>
                </div>
                <div>
                    <h1 class="title-main">Histórico Académico</h1>
                    <p class="title-subtitle">Consulta de registros por año escolar</p>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="main-container">
        {{-- TABLA DEL HISTÓRICO --}}
        <div class="card-modern">
            <div class="card-header-modern">
                <div class="d-flex justify-content-between align-items-center w-100">

                    {{-- TÍTULO --}}
                    <div class="header-left">
                        <div class="header-icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <div>
                            <h3>Registros académicos</h3>
                            <p>
                                {{ $tipo === 'docentes' ? $docentes->total() : $inscripciones->total() }}
                                registros encontrados
                            </p>

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
                            @if ($tipo === 'inscripciones')
                                <th>Año Escolar</th>
                                <th class="text-center">Alumno</th>
                                <th class="text-center">Año</th>
                                <th class="text-center">Sección</th>
                                <th class="text-center">Tipo de Inscripción</th>
                                <th class="text-center">Acciones</th>
                            @elseif($tipo === 'docentes')
                                <th>Año Escolar</th>
                                <th>Docente</th>
                                <th>Año</th>
                                <th>Área</th>
                                <th>Sección</th>
                            @endif
                        </thead>
                        <tbody class="text-center">

                            {{-- INSCRIPCIONES --}}
                            @if ($tipo === 'inscripciones')
                                @if ($modalidad === 'prosecucion')
                                    {{-- TABLA PARA PROSECUCIÓN --}}
                                    @forelse ($inscripciones as $prosecucion)
                                        <tr>
                                            {{-- Año Escolar de Prosecución --}}
                                            <td>
                                                {{ optional($prosecucion->anioEscolar)->inicio_anio_escolar
                                                    ? \Carbon\Carbon::parse($prosecucion->anioEscolar->inicio_anio_escolar)->format('d/m/Y')
                                                    : '—' }}
                                                -
                                                {{ optional($prosecucion->anioEscolar)->cierre_anio_escolar
                                                    ? \Carbon\Carbon::parse($prosecucion->anioEscolar->cierre_anio_escolar)->format('d/m/Y')
                                                    : '—' }}
                                            </td>

                                            {{-- Alumno --}}
                                            <td>
                                                {{ $prosecucion->inscripcion->alumno->persona->primer_apellido }}
                                                {{ $prosecucion->inscripcion->alumno->persona->primer_nombre }}
                                            </td>

                                            {{-- Grado al que fue promovido --}}
                                            <td>
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="badge bg-success mb-1">
                                                        {{ $prosecucion->grado->numero_grado }}° Grado
                                                    </span>
                                                    @if ($prosecucion->repite_grado)
                                                        <small class="text-danger">
                                                            <i class="fas fa-redo"></i> Repite
                                                        </small>
                                                    @else
                                                        <small class="text-success">
                                                            <i class="fas fa-arrow-up"></i> Promovido
                                                        </small>
                                                    @endif
                                                </div>
                                            </td>

                                            {{-- Sección Asignada --}}
                                            <td>{{ $prosecucion->seccion->nombre ?? '—' }}</td>

                                            {{-- Tipo --}}
                                            <td>
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-arrows-alt-v"></i> Prosecución
                                                </span>
                                            </td>

                                            {{-- Acciones (opcional) --}}
                                            <td>
                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#modalDetalleProsecucion{{ $prosecucion->id }}"
                                                    title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="empty-state">
                                                    <i class="fas fa-inbox fa-2x"></i>
                                                    <h4>No hay inscripciones de prosecución</h4>
                                                    <p>No se encontraron registros para el año escolar seleccionado</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                @elseif($modalidad === 'nuevo_ingreso')
                                    {{-- TABLA PARA NUEVO INGRESO --}}
                                    @forelse ($inscripciones as $inscripcion)
                                        <tr>
                                            {{-- Año Escolar --}}
                                            <td>
                                                {{ optional($inscripcion->anioEscolar)->inicio_anio_escolar
                                                    ? \Carbon\Carbon::parse($inscripcion->anioEscolar->inicio_anio_escolar)->format('d/m/Y')
                                                    : '—' }}
                                                -
                                                {{ optional($inscripcion->anioEscolar)->cierre_anio_escolar
                                                    ? \Carbon\Carbon::parse($inscripcion->anioEscolar->cierre_anio_escolar)->format('d/m/Y')
                                                    : '—' }}
                                            </td>

                                            {{-- Alumno --}}
                                            <td>
                                                {{ $inscripcion->alumno->persona->primer_apellido }}
                                                {{ $inscripcion->alumno->persona->primer_nombre }}
                                            </td>

                                            {{-- Grado --}}
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $inscripcion->grado->numero_grado }}° Año
                                                </span>
                                            </td>

                                            {{-- Sección --}}
                                            <td>{{ $inscripcion->seccionAsignada->nombre ?? '—' }}</td>

                                            {{-- Tipo --}}
                                            <td>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-star"></i> Nuevo Ingreso
                                                </span>
                                            </td>

                                            {{-- Acciones (opcional) --}}
                                            <td>
                                                <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#modalDetalleNuevoIngreso{{ $inscripcion->id }}"
                                                    title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="empty-state">
                                                    <i class="fas fa-inbox fa-2x"></i>
                                                    <h4>No hay inscripciones de nuevo ingreso</h4>
                                                    <p>No se encontraron registros para el año escolar seleccionado</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    {{-- TABLA PARA TODAS LAS INSCRIPCIONES (SIN FILTRO) --}}
                                    @forelse ($inscripciones as $inscripcion)
                                        <tr>
                                            {{-- Año Escolar --}}
                                            <td>
                                                {{ optional($inscripcion->anioEscolar)->inicio_anio_escolar
                                                    ? \Carbon\Carbon::parse($inscripcion->anioEscolar->inicio_anio_escolar)->format('d/m/Y')
                                                    : '—' }}
                                                -
                                                {{ optional($inscripcion->anioEscolar)->cierre_anio_escolar
                                                    ? \Carbon\Carbon::parse($inscripcion->anioEscolar->cierre_anio_escolar)->format('d/m/Y')
                                                    : '—' }}
                                            </td>

                                            {{-- Alumno --}}
                                            <td>
                                                {{ $inscripcion->alumno->persona->primer_apellido }}
                                                {{ $inscripcion->alumno->persona->primer_nombre }}
                                            </td>

                                            {{-- Grado --}}
                                            <td>
                                                @if ($inscripcion->prosecucion)
                                                    {{-- Si es prosecución, mostrar el grado de promoción --}}
                                                    <span class="badge bg-primary">
                                                        {{ $inscripcion->prosecucion->grado->numero_grado }}° Grado
                                                    </span>
                                                @else
                                                    {{-- Si es nuevo ingreso o base, mostrar el grado de la inscripción --}}
                                                    <span class="badge bg-info">
                                                        {{ $inscripcion->grado->numero_grado }}° Grado
                                                    </span>
                                                @endif
                                            </td>

                                            {{-- Sección --}}
                                            <td>
                                                @if ($inscripcion->prosecucion)
                                                    {{ $inscripcion->prosecucion->seccion->nombre ?? '—' }}
                                                @else
                                                    {{ $inscripcion->seccionAsignada->nombre ?? '—' }}
                                                @endif
                                            </td>

                                            {{-- Tipo --}}
                                            <td>
                                                @if ($inscripcion->prosecucion)
                                                    <span class="badge bg-primary">
                                                        <i class="fas fa-arrows-alt-v"></i> Prosecución
                                                    </span>
                                                @elseif ($inscripcion->nuevoIngreso)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-star"></i> Nuevo Ingreso
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">—</span>
                                                @endif
                                            </td>

                                            {{-- Acciones (opcional) --}}
                                            <td>
                                                <button class="btn btn-sm btn-info" title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <div class="empty-state">
                                                    <i class="fas fa-inbox fa-2x"></i>
                                                    <h4>No hay inscripciones</h4>
                                                    <p>No se encontraron registros para el año escolar seleccionado</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                @endif
                            @endif


                            {{-- DOCENTES --}}
                            @if ($tipo === 'docentes')
                                @forelse ($docentes as $docente)
                                    @php
                                        $grados = $docente->asignacionesAreas
                                            ->pluck('grado.numero_grado')
                                            ->filter()
                                            ->unique()
                                            ->implode(', ');

                                        $areas = $docente->asignacionesAreas
                                            ->pluck('areaEstudios.areaFormacion.nombre_area_formacion')
                                            ->filter()
                                            ->unique()
                                            ->implode(', ');

                                        // Si luego agregas sección:
                                        // ->pluck('seccion.nombre_seccion')

                                    @endphp

                                    <tr>
                                        {{-- Año escolar --}}
                                        <td>
                                            {{ optional($docente->anioEscolar)->inicio_anio_escolar
                                                ? \Carbon\Carbon::parse($docente->anioEscolar->inicio_anio_escolar)->format('d/m/Y')
                                                : '—' }}
                                            -
                                            {{ optional($docente->anioEscolar)->cierre_anio_escolar
                                                ? \Carbon\Carbon::parse($docente->anioEscolar->cierre_anio_escolar)->format('d/m/Y')
                                                : '—' }}
                                        </td>

                                        {{-- Docente --}}
                                        <td>
                                            {{ $docente->persona->primer_apellido }}
                                            {{ $docente->persona->primer_nombre }}
                                        </td>

                                        {{-- Grados --}}
                                        <td>
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($docente->asignacionesAreas->pluck('grado.numero_grado')->unique() as $grado)
                                                    <li>• {{ $grado }}</li>
                                                @endforeach
                                            </ul>
                                        </td>

                                        {{-- Áreas --}}
                                        <td>
                                            <ul class="list-unstyled mb-0">
                                                @foreach ($docente->asignacionesAreas->pluck('areaEstudios.areaFormacion.nombre_area_formacion')->unique() as $area)
                                                    <li>• {{ $area }}</li>
                                                @endforeach
                                            </ul>
                                        </td>

                                        {{-- Secciones --}}
                                        <td>
                                            —
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <div class="empty-state">
                                                <i class="fas fa-inbox fa-2x"></i>
                                                <h4>No hay docentes</h4>
                                                <p>Seleccione otro año escolar</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            @endif





                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        @include('admin.historico.modales.filtroModal')
        {{-- PAGINACIÓN --}}
        <div class="mt-4">
            <x-pagination :paginator="$tipo === 'docentes' ? $docentes : $inscripciones" />
        </div>

    </div>
@endsection
