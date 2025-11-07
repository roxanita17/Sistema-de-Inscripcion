@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Etnia Indigena</h1>
@stop

@section('content')
<div class="container mt-4">



@include('admin.etnia_indigena.modales.createModal')


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

    {{-- Botón para abrir la modal de crear etnia indigena --}}
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearEtniaIndigena">
        <i class="fas fa-plus"></i> Crear Etnia Indigena
    </button>

    {{-- Tabla de etnias indigenas --}}
    <div class="table-responsive">
        <table class="table table-striped align-middle text-center" id="tablaEtniaIndigena">
            <thead class="table-primary">
                <tr>
                    {{-- <th>N°</th> --}}
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbodyEtniaIndigena">
                @if ($etniaIndigena->isEmpty())
                                <tr>
                                    <td colspan="4" style="text-align: center;">No se encontraron etnias indigenas.</td>
                                </tr>
                            @endif
                @foreach ($etniaIndigena as $datos)
                @if ($datos->status == true)
                    <tr>
                        <td>{{ $datos->nombre }}</td>
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
                                <i class="fas fa-calendar-plus"></i>
                            </a>

                            @include('admin.etnia_indigena.modales.editModal')

                            <!-- Botón que abre el modal -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarEliminar{{ $datos->id }}" title="Inactivar">
                                <i class="fas fa-ban"></i>
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
                                            ¿Estás seguro de que deseas eliminar esta etnia indigena?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ url('admin/etnia_indigena/' . $datos->id) }}" method="POST">
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

<!-- Bootstrap 5 JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


@endsection


