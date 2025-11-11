<!-- Modal Crear Municipio -->
<div wire:ignore.self class="modal fade" id="modalCrearMunicipio" tabindex="-1" aria-labelledby="modalCrearMunicipioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="store">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Municipio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="estado_id">Estado</label>
                    <select wire:model="estado_id" id="estado_id" class="form-control" data-live-search="true" title="Seleccione un estado" required>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                        @endforeach
                    </select>
                    @error('estado_id') <span class="text-danger">{{ $message }}</span> @enderror
                    
                    <label for="nombre_municipio">Nombre del Municipio</label>
                    <input type="text" wire:model.defer="nombre_municipio" class="form-control" id="nombre_municipio" required>
                    @error('nombre_municipio') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>



