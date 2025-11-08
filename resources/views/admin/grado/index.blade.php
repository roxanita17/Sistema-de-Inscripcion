@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Grados</h1>
@stop

@section('content')
<div class="container mt-4">



@include('admin.grado.modales.createModal')


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

    {{-- Botón para abrir la modal de crear grado --}}
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearGrado">
        <i class="fas fa-plus"></i> Crear Grado
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
                @if ($grados->isEmpty())
                                <tr>
                                    <td colspan="4" style="text-align: center;">No se encontraron grados.</td>
                                </tr>
                            @endif
                @foreach ($grados as $datos)
                @if ($datos->status == true)
                    <tr>
                        <td>{{ $datos->numero_grado}}</td>
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
                                <i class="fas fa-pen text-white"></i>
                            </a>

                            @include('admin.grado.modales.editModal')

                            <!-- Eliminar -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarEliminar{{ $datos->id }}" title="Inactivar">
                                <i class="fas fa-trash text-white"></i>
                            </button>
                            <div class="modal fade" id="confirmarEliminar{{ $datos->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $datos->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel{{ $datos->id }}">
                                                Confirmar Inactivación</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Estás seguro de que deseas eliminar este grado?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ url('admin/grado/' . $datos->id) }}" method="POST">
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


