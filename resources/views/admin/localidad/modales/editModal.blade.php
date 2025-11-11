{{-- Modal para Editar una Localidad --}}
<div wire:ignore.self class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="update">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="modalEditarLabel">
                        Editar Localidad
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    {{-- Select Estado --}}
                    <label for="estado_id" class="form-label">Estado</label>
                    <select wire:model.live="estado_id" id="estado_id" class="form-control" data-live-search="true" title="Seleccione un estado" required>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                        @endforeach
                    </select>
                    @error('estado_id') <span class="text-danger">{{ $message }}</span> @enderror

                    {{-- Select Municipio --}}
                    <label for="municipio_id" class="form-label">Municipio</label>
                    <select wire:model.live="municipio_id" id="municipio_id" class="form-control" data-live-search="true" title="Seleccione un municipio" required>
                        @foreach ($municipios as $municipio)
                            <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
                        @endforeach
                    </select>
                    @error('municipio_id') <span class="text-danger">{{ $message }}</span> @enderror

                    {{-- Input Nombre Localidad --}}
                    <label for="nombre_localidad" class="form-label">Nombre de la Localidad</label>
                    <input type="text" wire:model.live="nombre_localidad" id="nombre_localidad" class="form-control" required>
                    @error('nombre_localidad') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
