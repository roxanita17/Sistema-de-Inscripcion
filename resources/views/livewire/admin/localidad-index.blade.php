<div class="container mt-4">
    {{-- Contenedor de alertas --}}
    <div id="contenedorAlertas">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-dismiss="alert" aria-hidden="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-dismiss="alert" aria-hidden="Close"></button>
            </div>
        @endif
    </div>
    <input type="text" class="form-control mb-3" placeholder="Buscar..." wire:model.live="search">

    {{-- Botón para abrir la modal de crear estado --}}
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearLocalidad">
        <i class="fas fa-plus"></i> Crear Localidad
    </button>

    @include('admin.localidad.modales.createModal')
    @include('admin.localidad.modales.editModal')

    {{-- Tabla de años escolares --}}
    <div class="table-responsive">
        <table class="table table-striped align-middle text-center" id="tablaAnioEscolar">
            <thead class="table-primary">
                <tr>
                    {{-- <th>N°</th> --}}
                    <th>Localidad</th>
                    <th>Municipio</th>
                    <th>Estado</th>
                    <th>Status</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbodyAnioEscolar">
                @if ($localidades->isEmpty())
                    <tr>
                        <td colspan="5" style="text-align: center;">No se encontraron localidades.</td>
                    </tr>
                @endif

                @foreach ($localidades as $datos)
                    @if ($datos->status == true)
                        <tr>
                            <td>{{ $datos->nombre_localidad }}</td>
                            <td>{{ $datos->municipio->nombre_municipio }}</td>
                            <td>{{ $datos->municipio->estado->nombre_estado }}</td>
                            <td>
                                @if ($datos->status == true)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                {{-- Editar --}}
                                <button wire:click="edit({{ $datos->id }})" class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#modalEditar">
                                    <i class="fas fa-pen text-white"></i>
                                </button>

                                {{-- Eliminar --}}
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#confirmarEliminar{{ $datos->id }}">
                                    <i class="fas fa-trash text-white"></i>
                                </button>

                                {{-- Modal de confirmación --}}
                                <div class="modal fade" id="confirmarEliminar{{ $datos->id }}" tabindex="-1"
                                    aria-labelledby="modalLabel{{ $datos->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                ¿Estás seguro de eliminar esta localidad?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button wire:click="destroy({{ $datos->id }})"
                                                    class="btn btn-danger">Eliminar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">{{ $localidades->links() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
