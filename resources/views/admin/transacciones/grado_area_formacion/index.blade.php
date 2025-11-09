@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Asignacion de Grados a Area de Formacion</h1>
@stop

@section('content')
<div class="container mt-4">



@include('admin.transacciones.grado_area_formacion.modales.createModal')


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
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearAsignacion">
        <i class="fas fa-plus"></i> Asignar Grado a Area de Formacion
    </button>

    {{-- Tabla de años escolares --}}
    <div class="table-responsive">
        <table class="table table-striped align-middle text-center" id="tablaGradoAreaFormacion">
            <thead class="table-primary">
                <tr>
                    {{-- <th>N°</th> --}}
                    <th>Codigo</th>
                    <th>Grado</th>
                    <th>Area de Formacion</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbodyGradoAreaFormacion">
                @if ($gradoAreaFormacion->isEmpty())
                                <tr>
                                    <td colspan="4" style="text-align: center;">No se encontraron grados.</td>
                                </tr>
                            @endif
                @foreach ($gradoAreaFormacion as $datos)
                @if ($datos->status == true)
                    <tr>
                        <td>{{ $datos->codigo}}</td>
                        <td>{{ $datos->grado->numero_grado}}</td>
                        <td>{{ $datos->area_formacion->nombre_area_formacion }}</td>
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
                            @include('admin.transacciones.grado_area_formacion.modales.showModal')

                            {{-- Editar --}}
                            <a href="#viewModalEditar{{ $datos->id }}" 
                                class="btn btn-warning btn-sm" 
                                title="Editar"
                                data-bs-toggle="modal" 
                                data-bs-target="#viewModalEditar{{ $datos->id }}">
                                <i class="fas fa-pen text-white"></i>
                            </a>

                            @include('admin.transacciones.grado_area_formacion.modales.editModal')

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
                                            <form action="{{ url('admin/transacciones/grado_area_formacion/' . $datos->id) }}" method="POST">
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


