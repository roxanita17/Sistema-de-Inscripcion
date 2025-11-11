@extends('adminlte::page')

@section('title', 'Asignación de Áreas de Formación')

@section('content_header')
    <h1>Asignación de Áreas de Formación a Títulos Universitarios</h1>
@stop

@section('content')
<div class="container mt-4">

    {{-- Incluir modal para crear nueva asignación --}}
    @include('admin.transacciones.area_estudio_realizado.modales.createModal')

    {{-- Contenedor de alertas --}}
    <div id="contenedorAlertas">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        @endif
    </div>

    {{-- Botón para abrir la modal de crear asignación --}}
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCrearAsignacion">
        <i class="fas fa-plus"></i> Nueva Asignación
    </button>

    {{-- Tabla de asignaciones --}}
    <div class="table-responsive">
        <table class="table table-striped align-middle text-center" id="tablaAreaEstudio">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Área de Formación</th>
                    <th>Título Universitario</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($areaEstudioRealizado as $index => $datos)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $datos->area_formacion->nombre_area_formacion ?? 'Sin área' }}</td>
                        <td>{{ $datos->estudio_realizado->titulo_universitario ?? 'Sin título' }}</td>
                        <td>
                            @if ($datos->status)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            {{-- Ver detalles --}}
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $datos->id }}" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            @include('admin.transacciones.area_estudio_realizado.modales.showModal')

                            {{-- Editar --}}
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#viewModalEditar{{ $datos->id }}" title="Editar">
                                <i class="fas fa-pen text-white"></i>
                            </button>
                            @include('admin.transacciones.area_estudio_realizado.modales.editModal')

                            {{-- Eliminar / Inactivar --}}
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $datos->id }}" title="Eliminar">
                                <i class="fas fa-trash text-white"></i>
                            </button>

                            {{-- Modal de confirmación de eliminación --}}
                            <div class="modal fade" id="deleteModal{{ $datos->id }}" tabindex="-1" aria-labelledby="deleteLabel{{ $datos->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteLabel{{ $datos->id }}">Confirmar eliminación</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            ¿Seguro que deseas eliminar esta asignación?
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ url('admin/transacciones/area_estudio_realizado/' . $datos->id) }}" method="POST">
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
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No se encontraron asignaciones registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
