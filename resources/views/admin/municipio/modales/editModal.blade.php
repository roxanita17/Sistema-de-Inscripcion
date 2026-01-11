<div wire:ignore.self class="modal fade" id="modalEditar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">
            <div class="modal-header-edit">
                <div class="modal-icon-edit">
                    <i class="fas fa-pen"></i>
                </div>
                <h5 class="modal-title-edit" id="modalEditarLabel">Editar Municipio</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body-edit">
                <form wire:submit.prevent="update" id="formEditarEstado">
                    <div id="contenedorAlertaEditar"></div>
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
                        <select wire:model.live="estado_id" class="form-control-modern">
                            <option value="">Seleccione un estado</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}">
                                    {{ $estado->nombre_estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group-modern">
                        <label for="nombre_municipio_editar" class="form-label-modern">
                            <i class="fas fa-hashtag me-2"></i> Nombre del Municipio
                        </label>
                        <input type="text" class="form-control-modern" id="nombre_municipio_editar"
                            wire:model.live="nombre_municipio" inputmode="text" maxlength="100"
                            placeholder="Edite el nombre del municipio" required>
                        @error('nombre_municipio')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="modal-footer-edit">
                        <div class="footer-buttons">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                Cancelar
                            </button>
                            <button type="submit" class="btn-modal-edit">
                                Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
