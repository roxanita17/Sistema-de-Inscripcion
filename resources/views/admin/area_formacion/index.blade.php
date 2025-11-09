@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Área de formación</h1>
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
            <h2 class="card-title" style="font-size: 24px; margin: 10px;"><b>Materias</b></h2>


            <div class="card-tools">
                @include('admin.area_formacion.modales.createModal')
                {{-- Botón para abrir la modal de crear estado --}}
                <div class="d-flex justify-content-end" style="margin: 10px;">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearAreaFormacion">
                        <i class="fas fa-plus"></i> Crear Área de formación
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Tabla de años escolares --}}
        <div class="table-responsive">
            <table class="table table-striped align-middle text-center table-alignada" id="tablaAnioEscolar">
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
                                        <td colspan="3" style="text-align: center;">No se encontraron áreas de formación.</td>
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

    

    <div class="container mt-4 card card-outline card-info">
        <div>
            <h2 class="card-title" style="font-size: 24px; margin: 10px;"><b>Grupos de Creacion, Recreacion y Produccion</b></h2>


            <div class="card-tools">
                @include('admin.area_formacion.modalesGrupoEstable.createModalGrupoEstable')
                {{-- Botón para abrir la modal de crear estado --}}
                <div class="d-flex justify-content-end" style="margin: 10px;">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearGrupoEstable">
                    <i class="fas fa-plus"></i> Crear Grupo Estable
                    </button>
                </div>
            </div>
        </div>
        {{-- Tabla de grupos estable --}}
        <div class="table-responsive">
            <table class="table table-striped align-middle text-center table-alignada" id="tablaGrupoEstable">
                <thead class="table-primary">
                    <tr>
                        <th>Grupo estable</th>
                        <th>Status</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyGrupoEstable">
                    @if ($grupoEstable->isEmpty())
                                    <tr>
                                        <td colspan="3" style="text-align: center;">No se encontraron grupos estable.</td>
                                    </tr>
                                @endif
                    
                    @foreach ($grupoEstable as $grupo)
                    @if ($grupo->status == true)
                        <tr>
                            <td>{{ $grupo->nombre_grupo_estable }}</td>
                            <td>
                                @if ($grupo->status == true)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>

                                {{-- Editar --}}
                                <a href="#viewModalEditarGrupoEstable{{ $grupo->id }}" 
                                    class="btn btn-warning btn-sm" 
                                    title="Editar"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#viewModalEditarGrupoEstable{{ $grupo->id }}">
                                    <i class="fas fa-pen text-white" ></i>
                                </a>

                                @include('admin.area_formacion.modalesGrupoEstable.editModalGrupoEstable')

                                <!-- Eliminar -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarEliminar{{ $grupo->id }}" title="Inactivar">
                                    <i class="fas fa-trash text-white"></i>
                                </button>
                                <div class="modal fade" id="confirmarEliminar{{ $grupo->id }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{ $grupo->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas eliminar este grupo estable?
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ url('admin/area_formacion/' . $grupo->id) }}" method="POST">
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

@section('css')
    <style>
    .table-alignada {
        width: 100%;
        table-layout: fixed;
    }
    .table-alignada th,
    .table-alignada td {
        text-align: center;
        vertical-align: middle;
    }
    .table-alignada th:nth-child(1),
    .table-alignada td:nth-child(1) {
        width: 60%;
    }
    .table-alignada th:nth-child(2),
    .table-alignada td:nth-child(2) {
        width: 20%;
    }
    .table-alignada th:nth-child(3),
    .table-alignada td:nth-child(3) {
        width: 20%;
    }
    </style>

@endsection

