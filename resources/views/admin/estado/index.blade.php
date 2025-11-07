@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Estado</h1>
@stop

@section('content')
<div class="container mt-4">

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

    @include('admin.estado.modales.createModal')
    {{-- Botón para abrir la modal de crear estado --}}
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearEstado">
        <i class="fas fa-plus"></i> Crear Estado
    </button>

    {{-- Tabla de años escolares --}}
    <div class="table-responsive">
        <table class="table table-striped align-middle text-center" id="tablaAnioEscolar">
            <thead class="table-primary">
                <tr>
                    {{-- <th>N°</th> --}}
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbodyAnioEscolar">
                @if ($estados->isEmpty())
                                <tr>
                                    <td colspan="4" style="text-align: center;">No se encontraron estados.</td>
                                </tr>
                            @endif
                @foreach ($estados as $datos)
                @if ($datos->status == true)
                    <tr>
                        {{-- @if ($datos->status == true)
                            <td>{{ $loop->iteration }}</td>
                        @endif --}}
                        <td>{{ $datos->nombre}}</td>
                        <td>
                            @if ($datos->status == true)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            {{-- Ver detalles --}}
                            <a href="#viewModal{{ $datos->id }}" 
                                class="btn btn-info btn-sm" 
                                title="Ver detalles"
                                data-bs-toggle="modal" 
                                data-bs-target="#viewModal{{ $datos->id }}">
                                <i class="fas fa-eye"></i>
                            </a>


                            {{-- Editar --}}
                            <a href="#viewModalEditar{{ $datos->id }}" 
                                class="btn btn-warning btn-sm" 
                                title="Editar"
                                data-bs-toggle="modal" 
                                data-bs-target="#viewModalEditar{{ $datos->id }}">
                                <i class="fas fa-pen text-white" ></i>
                            </a>

                            @include('admin.estado.modales.editModal')

                            <!-- Botón que abre el modal -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarEliminar{{ $datos->id }}" title="Inactivar">
                                <i class="fas fa-trash text-white"></i>
                            </button>
                            <div class="modal fade" id="confirmarEliminar{{ $datos->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $datos->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            ¿Estás seguro de que deseas eliminar este estado?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ url('admin/estado/' . $datos->id) }}" method="POST">
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


