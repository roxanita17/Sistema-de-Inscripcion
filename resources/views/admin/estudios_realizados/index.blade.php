@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Estudios Realizados de Docentes</h1>
@stop

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@section('content')
    <div class="container mt-4 card card-outline card-info">

        {{-- Contenedor de alertas --}}
        <div id="contenedorAlertas">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                </div>
            @endif
        </div>

        <div>
            <h2 class="card-title" style="font-size: 24px; margin: 10px;"><b>Estudios Realizados</b></h2>


            <div class="card-tools">
                @include('admin.estudios_realizados.modales.createModal')
                {{-- Botón para abrir la modal de crear estado --}}
                <div class="d-flex justify-content-end" style="margin: 10px;">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearEstudiosRealizados">
                        <i class="fas fa-plus"></i> Crear
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Tabla de años escolares --}}
        <div class="table-responsive">
            <table class="table table-striped align-middle text-center table-alignada" id="tablaAnioEscolar">
                <thead class="table-primary">
                    <tr>
                        <th>Nombre</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyAnioEscolar">
                    @if ($estudiosRealizados->isEmpty())
                                    <tr>
                                        <td colspan="3" style="text-align: center;">No se encontraron estudios realizados.</td>
                                    </tr>
                                @endif
                    
                    @foreach ($estudiosRealizados as $datos)
                    @if ($datos->status == true)
                        <tr>
                            <td>{{ $datos->titulo_universitario }}</td>
                            <td>
                                @if ($datos->status == true)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>

                                {{-- Editar --}}
                                <a href="#viewModalEditar{{ $datos->id }}" 
                                    class="btn btn-warning btn-sm" 
                                    title="Editar"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#viewModalEditar{{ $datos->id }}">
                                    <i class="fas fa-pen text-white" ></i>
                                </a>

                                @include('admin.estudios_realizados.modales.editModal')

                                <!-- Eliminar -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarEliminar{{ $datos->id }}" title="Inactivar">
                                    <i class="fas fa-trash text-white"></i>
                                </button>
                                <div class="modal fade" id="confirmarEliminar{{ $datos->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $datos->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas eliminar esta estudio realizado?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ url('admin/estudios_realizados/' . $datos->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

