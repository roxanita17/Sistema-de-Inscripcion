<div wire:ignore.self class="modal fade" id="modalCrear" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">
            <div class="modal-header-create">
                <div class="modal-icon-create">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5 class="modal-title-create" id="modalCrearLabel">Nueva Localidad</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body-create">
                <form wire:submit.prevent="store" id="formCrearLocalidad">
                    <div id="contenedorAlertaCrear"></div>
                    <div class="form-group-modern">
                        <label for="pais_id" class="form-label-modern">
                            <i class="fas fa-tags"></i>
                            Pais
                        </label>
                        <select name="pais_id" wire:model.live="pais_id" id="pais_id" class="form-control-modern "
                            data-live-search="true" title="Seleccione un pais" required>
                            <option value="">Seleccione un pais</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->id }}">{{ $pais->nameES }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group-modern">
                        <label for="estado_id" class="form-label-modern">
                            <i class="fas fa-tags"></i>
                            Estado
                        </label>
                        <select name="estado_id" wire:model.live="estado_id" id="estado_id" @disabled(!$pais_id)
                            class="form-control-modern " data-live-search="true" title="Seleccione un estado" required>
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
                    <div class="form-group-modern">
                        <label for="municipio_id" class="form-label-modern">
                            <i class="fas fa-tags"></i>
                            Municipio
                        </label>
                        <select name="municipio_id" wire:model.live="municipio_id" id="municipio_id"
                            @disabled(!$estado_id) class="form-control-modern " data-live-search="true"
                            title="Seleccione un municipio" required>
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
                    <div class="form-group-modern">
                        <label for="nombre_localidad_crear" class="form-label-modern">
                            <i class="fas fa-hashtag me-2"></i> Nombre de la Localidad
                        </label>
                        <input type="text" class="form-control-modern" id="nombre_localidad_crear"
                            wire:model.defer="nombre_localidad" inputmode="text" maxlength="100"
                            placeholder="Ingrese el nombre de la localidad" required>
                        @error('nombre_localidad')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
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
