@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Área de formación</h1>
@stop

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


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

    @include('admin.area_formacion.modales.createModal')
    {{-- Botón para abrir la modal de crear estado --}}
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearAreaFormacion">
        <i class="fas fa-plus"></i> Crear Área de formación
    </button>

    {{-- Tabla de años escolares --}}
    <div class="table-responsive">
        <table class="table table-striped align-middle text-center" id="tablaAnioEscolar">
            <thead class="table-primary">
                <tr>
                    <th>Área de formación</th>
                    <th>Status</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbodyAnioEscolar">
                @if ($areaFormacion->isEmpty())
                                <tr>
                                    <td colspan="4" style="text-align: center;">No se encontraron áreas de formación.</td>
                                </tr>
                            @endif
                
                @foreach ($areaFormacion as $datos)
                @if ($datos->status == true)
                    <tr>
                        <td>{{ $datos->nombre_area_formacion }}</td>
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

                            @include('admin.area_formacion.modales.editModal')

                            <!-- Eliminar -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarEliminar{{ $datos->id }}" title="Inactivar">
                                <i class="fas fa-trash text-white"></i>
                            </button>
                            <div class="modal fade" id="confirmarEliminar{{ $datos->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $datos->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            ¿Estás seguro de que deseas eliminar esta area de formación?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ url('admin/area_formacion/' . $datos->id) }}" method="POST">
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


