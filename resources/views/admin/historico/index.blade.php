@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
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
                            <p>{{ $inscripciones->total() }} registros encontrados</p>
                        </div>
                    </div>

                    {{-- FILTRO --}}
                    <form method="GET" class="filter-inline">
                        <select name="anio_escolar_id" class="form-select form-control-modern"
                            onchange="this.form.submit()">
                            <option value="">Todos los años</option>
                            @foreach ($anios as $anio)
                                <option value="{{ $anio->id }}" {{ $anio->id == $anioEscolarId ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::parse($anio->inicio_anio_escolar)->format('Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse($anio->cierre_anio_escolar)->format('Y') }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                </div>
            </div>


            <div class="card-body-modern">
                <div class="table-wrapper">
                    <table class="table-modern">
                        <thead>
                            <tr class="text-center">
                                <th style="text-align: center">Año Escolar</th>
                                <th style="text-align: center">Alumno</th>
                                <th style="text-align: center">Grado</th>
                                <th style="text-align: center">Sección</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">

                            @forelse ($inscripciones as $inscripcion)
                                <tr>
                                    <td>{{ $inscripcion->anioEscolar ? \Carbon\Carbon::parse($inscripcion->anioEscolar->inicio_anio_escolar)->format('d/m/Y') : '—' }}
                                        -
                                        {{ $inscripcion->anioEscolar ? \Carbon\Carbon::parse($inscripcion->anioEscolar->cierre_anio_escolar)->format('d/m/Y') : '—' }}
                                    </td>
                                    <td>
                                        {{ $inscripcion->alumno->persona->primer_apellido }}
                                        {{ $inscripcion->alumno->persona->primer_nombre }}
                                    </td>
                                    <td>{{ $inscripcion->grado->numero_grado }}</td>
                                    <td>{{ $inscripcion->seccionAsignada->nombre ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox fa-2x"></i>
                                            <h4>No hay registros</h4>
                                            <p>Seleccione otro año escolar</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- PAGINACIÓN --}}
        <div class="mt-4">
            <x-pagination :paginator="$inscripciones" />
        </div>

    </div>
@endsection
