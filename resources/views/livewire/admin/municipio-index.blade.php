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

    {{-- Botón para abrir modal --}}
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearMunicipio">
        <i class="fas fa-plus"></i> Crear Municipio
    </button>

    {{-- ✅ INCLUYE LAS MODALES DENTRO DEL MISMO DIV PRINCIPAL --}}
    @include('admin.municipio.modales.createModal')
    @include('admin.municipio.modales.editModal')

    {{-- Tabla --}}
    <div class="table-responsive mt-3">
        <table class="table table-striped align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>Municipio</th>
                    <th>Estado</th>
                    <th>Status</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($municipios as $datos)
                    @if ($datos->status)
                        <tr>
                            <td>{{ $datos->nombre_municipio }}</td>
                            <td>{{ $datos->estado->nombre_estado }}</td>
                            <td>
                                <span class="badge bg-success">Activo</span>
                            </td>
                            <td>
                                <button wire:click="edit({{ $datos->id }})" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar">
                                    <i class="fas fa-pen text-white"></i>
                                </button>

                                {{-- Eliminar --}}
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmarEliminar{{ $datos->id }}">
                                    <i class="fas fa-trash text-white"></i>
                                </button>

                                {{-- Modal de confirmación --}}
                                <div class="modal fade" id="confirmarEliminar{{ $datos->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $datos->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                ¿Estás seguro de eliminar este municipio?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button wire:click="destroy({{ $datos->id }})" class="btn btn-danger">Eliminar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="4">No se encontraron municipios.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">{{ $municipios->links() }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

</div> {{-- 🔚 Cierre del div raíz único --}}
