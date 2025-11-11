<!-- Modal Crear Localidad -->
<div wire:ignore.self class="modal fade" id="modalCrearLocalidad" tabindex="-1" aria-labelledby="modalCrearLocalidadLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="store">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Localidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    {{-- Select Estado --}}
                    <label for="estado_id" class="form-label">Estado</label>
                    <select wire:model.live="estado_id" id="estado_id" class="form-control" required>
                        <option value="">Seleccione un estado</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                        @endforeach
                    </select>
                    @error('estado_id') <span class="text-danger">{{ $message }}</span> @enderror

                    {{-- Select Municipio dependiente --}}
                    <label for="municipio_id" class="form-label mt-3">Municipio</label>
                    <select wire:model.live="municipio_id" id="municipio_id" class="form-control" required>
                        <option value="">Seleccione un municipio</option>
                        @foreach ($municipios as $municipio)
                            <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
                        @endforeach
                    </select>
                    @error('municipio_id') <span class="text-danger">{{ $message }}</span> @enderror

                    {{-- Input Localidad --}}
                    <label for="nombre_localidad" class="form-label mt-3">Nombre de la Localidad</label>
                    <input type="text" wire:model.defer="nombre_localidad" id="nombre_localidad" class="form-control" required>
                    @error('nombre_localidad') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
