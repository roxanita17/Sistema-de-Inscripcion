@extends('adminlte::page')

@section('title', 'Representantes Eliminados')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@stop

@section('content_header')
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div>
                    <h1 class="title-main">Representantes Eliminados</h1>
                    <p class="title-subtitle">Listado de representantes eliminados del sistema</p>
                </div>
            </div>

            <a href="{{ route('representante.index') }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i>
                <span>Volver a la lista</span>
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Listado de Representantes Eliminados</h3>
                    </div>
                    
                    <div class="card-body-modern">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-wrapper">
                            <table class="table-modern overflow-hidden">
                                <thead>
                                    <tr style="text-align: center">
                                        <th style="text-align: center">Cédula</th>
                                        <th style="text-align: center">Nombre</th>
                                        <th style="text-align: center">Apellido</th>
                                        <th style="text-align: center">Teléfono</th>
                                        <th style="text-align: center">Estado</th>
                                        <th style="text-align: center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-representantes" style="text-align: center">
                                    @forelse($representantes as $rep)
                                        <tr>
                                            <td>{{ $rep->persona->numero_documento ?? 'N/A' }}</td>
                                            <td>{{ $rep->persona->primer_nombre ?? 'N/A' }} {{ $rep->persona->segundo_nombre ?? '' }}</td>
                                            <td>{{ $rep->persona->primer_apellido ?? 'N/A' }} {{ $rep->persona->segundo_apellido ?? '' }}</td>
                                            <td>{{ $rep->persona->telefono ?? 'N/A' }}</td>
                                            <td>
                                                @if($rep->status == 0)
                                                    <span class="badge bg-danger">Eliminado</span>
                                                @elseif($rep->status == 2)
                                                <span class="badge bg-info">Madre</span>
                                            @elseif($rep->status == 3)
                                                <span class="badge bg-primary">Padre</span>
                                            @else
                                                <span class="badge bg-success">Activo</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('representante.restaurar', $rep->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-sm btn-success" 
                                                    onclick="return confirm('¿Está seguro de restaurar este representante?')">
                                                    <i class="fas fa-undo"></i> Restaurar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay representantes eliminados</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $representantes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
