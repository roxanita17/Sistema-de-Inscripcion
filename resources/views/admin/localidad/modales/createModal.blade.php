<!-- Modal Crear Estado -->
<div wire:ignore.self class="modal fade" id="modalCrear" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">

            {{-- Cabecera del modal --}}
            <div class="modal-header-create">
                <div class="modal-icon-create">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5 class="modal-title-create" id="modalCrearLabel">Nueva Localidad</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cuerpo del modal con formulario --}}
            <div class="modal-body-create">
                <form wire:submit.prevent="store" id="formCrearLocalidad">
                    
                    {{-- Contenedor para alertas de validación --}}
                    <div id="contenedorAlertaCrear"></div>

                    {{-- Select del estado --}}
                    <div class="form-group-modern">
                        <label for="estado_id" class="form-label-modern">
                            <i class="fas fa-tags"></i>
                            Estado
                        </label>
                        <select name="estado_id" 
                            wire:model.live="estado_id"
                            id="estado_id" 
                            class="form-control-modern " 
                            data-live-search="true"
                            title="Seleccione un estado"
                            required>
                            <option value="">Seleccione un estado</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                            @endforeach
                        </select>
                        @error('estado_id')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Select del municipio --}}
                    <div class="form-group-modern">
                        <label for="municipio_id" class="form-label-modern">
                            <i class="fas fa-tags"></i>
                            Municipio
                        </label>
                        <select name="municipio_id" 
                            wire:model.live="municipio_id"
                            id="municipio_id" 
                            class="form-control-modern " 
                            data-live-search="true"
                            title="Seleccione un municipio"
                            required>
                            <option value="">Seleccione un municipio</option>
                            @foreach ($municipios as $municipio)
                                <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
                            @endforeach
                        </select>
                        @error('municipio_id')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Nombre de la Localidad --}}
                    <div class="form-group-modern">
                        <label for="nombre_localidad_crear" class="form-label-modern">
                            <i class="fas fa-hashtag me-2"></i> Nombre de la Localidad
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="nombre_localidad_crear" 
                               wire:model.defer="nombre_localidad"
                               inputmode="text"
                               maxlength="100"
                               placeholder="Ingrese el nombre de la localidad"
                               required>
                        @error('nombre_localidad')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="modal-footer-create">
                        <div class="footer-buttons">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                Cancelar
                            </button>
                            <button type="submit" class="btn-modal-create">
                                Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


























<!-- Modal Crear Localidad -->
{{-- <div wire:ignore.self class="modal fade" id="modalCrearLocalidad" tabindex="-1" aria-labelledby="modalCrearLocalidadLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="store">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Localidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body"> --}}
                    {{-- Select Estado --}}
                    {{-- <label for="estado_id" class="form-label">Estado</label>
                    <select wire:model.live="estado_id" id="estado_id" class="form-control" required>
                        <option value="">Seleccione un estado</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                        @endforeach
                    </select>
                    @error('estado_id') <span class="text-danger">{{ $message }}</span> @enderror
 --}}
                    {{-- Select Municipio dependiente --}}
                   {{--  <label for="municipio_id" class="form-label mt-3">Municipio</label>
                    <select wire:model.live="municipio_id" id="municipio_id" class="form-control" required>
                        <option value="">Seleccione un municipio</option>
                        @foreach ($municipios as $municipio)
                            <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
                        @endforeach
                    </select>
                    @error('municipio_id') <span class="text-danger">{{ $message }}</span> @enderror
 --}}
                    {{-- Input Localidad --}}
     {{--                <label for="nombre_localidad" class="form-label mt-3">Nombre de la Localidad</label>
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
 --}}