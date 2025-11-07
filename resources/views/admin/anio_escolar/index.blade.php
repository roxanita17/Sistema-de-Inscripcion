@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Año Escolar</h1>
@stop

@section('content')
<div class="container mt-4">

    <!-- Botón para abrir la modal de crear año escolar -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearAnioEscolar">
    <i class="fas fa-plus"></i> Crear Año Escolar
</button>

@include('admin.anio_escolar.modales.createModal')


    {{-- Contenedor de alertas --}}
    <div id="contenedorAlertas"></div>

    {{-- Tabla de años escolares --}}
    <div class="table-responsive">
        <table class="table table-striped align-middle text-center" id="tablaAnioEscolar">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Inicio</th>
                    <th>Cierre</th>
                    <th>Estado</th>
{{--                     <th>Creado por</th> --}}
                    <th>Fecha de creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbodyAnioEscolar">
                @foreach ($escolar as $datos)
                <tr>
                    <td>{{ $datos->id }}</td>
                    <td>{{ $datos->inicio_anio_escolar }}</td>
                    <td>{{ $datos->cierre_anio_escolar }}</td>
                    <td>
                        @if ($datos->status == 'Activo')
                            <span class="badge bg-success">Activo</span>
                        @elseif ($datos->status == 'Extendido')
                            <span class="badge bg-warning text-dark">Extendido</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </td>
{{--                     <td>{{ $datos->user->name ?? 'No registrado' }}</td> --}}
                    <td>{{ $datos->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        {{-- 🔹 Ver detalles --}}
                        <a href="#viewModal{{ $datos->id }}" 
                            class="btn btn-info btn-sm" 
                            title="Ver detalles"
                            data-bs-toggle="modal" 
                            data-bs-target="#viewModal{{ $datos->id }}">
                            <i class="fas fa-eye"></i>
                        </a>

                        @include('admin.anio_escolar.modales.showModal')

                        {{-- 🔹 Extender --}}
                        <a href="#viewModalExtender{{ $datos->id }}" 
                            class="btn btn-warning btn-sm" 
                            title="Extender"
                            data-bs-toggle="modal" 
                            data-bs-target="#viewModalExtender{{ $datos->id }}">
                            <i class="fas fa-calendar-plus"></i>
                        </a>

                        @include('admin.anio_escolar.modales.extenderModal')

                        <!-- Botón que abre el modal -->
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#confirmarEliminar{{ $datos->id }}" title="Inactivar">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                        <div class="modal fade" id="confirmarEliminar{{ $datos->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modalLabel{{ $datos->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLabel{{ $datos->id }}">
                                                            Confirmar Inactivación</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Cerrar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿Estás seguro de que deseas inactivar este año escolar?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ url('admin/anio_escolar/' . $datos->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit"
                                                                class="btn btn-danger">Inactivar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap 5 JS + Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


@endsection


