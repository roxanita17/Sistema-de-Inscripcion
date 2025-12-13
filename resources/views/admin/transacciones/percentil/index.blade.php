@extends('adminlte::page')

@section('css')
    {{-- Estilos modernos reutilizados del sistema --}}
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@stop

@section('title', 'Historial del Percentil')

@section('content_header')
    {{-- Encabezado principal de la página --}}
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <h1 class="title-main">Historial del Percentil</h1>
                </div>
            </div>
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
                            Puedes ver los registros, pero <strong>no podrás crear, editar o eliminar</strong>
                            entradasPercentil hasta que se registre un año escolar activo.
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

        {{-- Contenedor principal de la tabla de entradasPercentil --}}
        <div class="card-modern">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-list-ul"></i>
                    </div>
                    <div>
                        <h3>Listado del percentil</h3>
                    </div>
                </div>
                <div class="header-right">
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
                                <th style="text-align: center">Estudiante</th>
                                <th>Seccion</th>
                                <th>Indice Peso</th>
                                <th>Indice Altura</th>
                                <th>Indice Edad</th>
                                <th>Indice total</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center">
                            {{-- Si no hay entradasPercentil, se muestra mensaje vacío --}}
                            @if ($entradasPercentil->isEmpty())
                                <tr>
                                    <td colspan="8">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-inbox"></i>
                                            </div>
                                            <h4>No hay estudiantes asignados registrados</h4>
                                            <p>Agrega un nuevo estudiante con el botón superior</p>
                                        </div>
                                    </td>
                                </tr>
                            @else
                                {{-- Se recorren los entradasPercentil existentes --}}
                                @foreach ($entradasPercentil as $index => $datos)
                                    <tr class="table-row-hover row-12" style="text-align: center">

                                        <td>
                                            <div class="student-info">
                                                <div class="student-name">
                                                    
                                                    {{ $datos->inscripcion->alumno->persona->primer_nombre ?? '' }}
                                                    {{ $datos->inscripcion->alumno->persona->primer_apellido ?? '' }}
                                                </div>

                                                <div class="student-details">
                                                    <span>
                                                        
                                                        {{ $datos->inscripcion->alumno->peso }} kg
                                                    </span>
                                                    <span class="mx-2">|</span>
                                                    <span>
                                                        
                                                        {{ $datos->inscripcion->alumno->estatura }} cm
                                                    </span>
                                                    <span class="mx-2">|</span>
                                                    <span>
                                                        
                                                        {{ $datos->inscripcion->alumno->persona->fecha_nacimiento->age }}
                                                        años
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $datos->seccion->nombre }}</td>
                                        <style>
                                            .student-info {
                                                display: flex;
                                                flex-direction: column;
                                                gap: 4px;
                                            }

                                            .student-name {
                                                font-weight: 600;
                                                color: #2c3e50;
                                                font-size: 0.95rem;
                                            }

                                            .student-details {
                                                font-size: 0.8rem;
                                                color: #6c757d;
                                            }

                                            
                                        </style>
                                        <td>{{ $datos->indice_peso }}</td>
                                        <td>{{ $datos->indice_estatura }}</td>
                                        <td>{{ $datos->indice_edad }}</td>

                                        <td>
                                            {{ $datos->indice_total }}

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Paginación moderna --}}
            <div class="mt-3">
                <x-pagination :paginator="$entradasPercentil" />
            </div>
        </div>
    </div>

@endsection
