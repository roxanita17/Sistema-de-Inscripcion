<!-- Modal Editar Estado -->
<div wire:ignore.self class="modal fade" id="modalEditar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">

            {{-- Cabecera del modal --}}
            <div class="modal-header-edit">
                <div class="modal-icon-edit">
                    <i class="fas fa-pen"></i>
                </div>
                <h5 class="modal-title-edit" id="modalEditarLabel">Editar Pais</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cuerpo del modal con formulario --}}
            <div class="modal-body-edit">
                <form wire:submit.prevent="update" id="formEditarEstado">

                    {{-- Contenedor para alertas de validación --}}
                    <div id="contenedorAlertaEditar"></div>

                    <div class="form-group-modern">
                        <label for="nameES_crear" class="form-label-modern">
                            <i class="fas fa-hashtag me-2"></i> Codigo ISO
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="nameES_crear" 
                               wire:model.defer="iso2"
                               inputmode="text"
                               maxlength="100"
                               placeholder="JP, US, MX"
                               required>
                        @error('iso2')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Nombre del Estado --}}
                    <div class="form-group-modern">
                        <label for="nameES_crear" class="form-label-modern">
                            <i class="fas fa-flag me-2"></i> Nombre del Pais
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="nameES_crear" 
                               wire:model.defer="nameES"
                               inputmode="text"
                               maxlength="100"
                               placeholder="Ingrese el nombre del pais"
                               required>
                        @error('nameES')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Botones --}}
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
