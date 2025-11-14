

<div class="container mt-4">

    {{-- Contenedor de alertas --}}
    <div id="contenedorAlertas">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="form-group-modern">
        <div style="position: relative;">
            <input type="text" 
                name="buscar" 
                id="buscar" 
                class="form-control-modern" 
                placeholder="Buscar..."
                wire:model.live="search"
                style="padding-left: 2.5rem;">
            <i class="fas fa-search" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--gray-300);"></i>
        </div>
    </div>

    {{-- <input type="text" class="form-control mb-3" placeholder="Buscar..." wire:model.live="search"> --}}

    {{-- Botón para crear estado (abre modal Livewire) --}}


    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCrearEstado">
        <i class="fas fa-plus"></i> Crear Estado
    </button>

    {{-- Modal para crear estado --}}
    @include('admin.estado.modales.createModal')

    {{-- Tabla de estados --}}
    <div class="table-responsive">
        <table class="table table-striped align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if ($estados->isEmpty())
                    <tr>
                        <td colspan="3" class="text-center">No se encontraron estados.</td>
                    </tr>
                @endif

                @foreach ($estados as $datos)
                    <tr>
                        <td>{{ $datos->nombre_estado }}</td>
                        <td>
                            @if ($datos->status)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            {{-- Editar --}}
                            <button wire:click="edit({{ $datos->id }})" class="btn btn-warning btn-sm" title="Editar"
                                data-bs-toggle="modal" data-bs-target="#modalEditarEstado">
                                <i class="fas fa-pen text-white"></i>
                            </button>

                            {{-- Eliminar --}}
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#confirmarEliminar{{ $datos->id }}" title="Inactivar">
                                <i class="fas fa-trash text-white"></i>
                            </button>
                            <div class="modal fade" id="confirmarEliminar{{ $datos->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="modalLabel{{ $datos->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            ¿Estás seguro de que deseas eliminar este estado?
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
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">{{ $estados->links() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Modal para editar estado --}}
    @include('admin.estado.modales.editModal')
</div>
