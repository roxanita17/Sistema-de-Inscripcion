<div wire:ignore.self class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form wire:submit.prevent="update">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="modalEditarLabel">
                        Editar Municipio
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Select Estado --}}
                    <label for="estado_id" class="form-label">Estado</label>
                    <select wire:model.live="estado_id" id="estado_id" class="form-control" data-live-search="true" title="Seleccione un estado" required>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}" {{ old('estado_id', $estado_id) == $estado->id ? 'selected' : '' }}>{{ $estado->nombre_estado }}</option>
                        @endforeach
                    </select>
                    @error('estado_id') <span class="text-danger">{{ $message }}</span> @enderror

                    {{-- Input Nombre Municipio --}}
                    <label for="nombre_municipio" class="form-label">Nombre del Municipio</label>
                    <input type="text" wire:model.live="nombre_municipio" id="nombre_municipio" class="form-control">
                    @error('nombre_municipio') <span class="text-danger">{{ $message }}</span> @enderror

                    {{-- Botones --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

