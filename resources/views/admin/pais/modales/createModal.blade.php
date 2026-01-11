<div wire:ignore.self class="modal fade" id="modalCrear" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">
            <div class="modal-header-create">
                <div class="modal-icon-create">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5 class="modal-title-create" id="modalCrearLabel">Nuevo Pais</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body-create">
                <form wire:submit.prevent="store" id="formCrearPais">
                    <div id="contenedorAlertaCrear"></div>
                    <div class="form-group-modern">
                        <label for="nameES_crear" class="form-label-modern">
                            <i class="fas fa-hashtag me-2"></i> Codigo ISO
                        </label>
                        <input type="text" class="form-control-modern" id="nameES_crear" wire:model.defer="iso2"
                            inputmode="text" maxlength="100" placeholder="JP, US, MX" required>
                        @error('iso2')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group-modern">
                        <label for="nameES_crear" class="form-label-modern">
                            <i class="fas fa-flag me-2"></i> Nombre del Pais
                        </label>
                        <input type="text" class="form-control-modern" id="nameES_crear" wire:model.defer="nameES"
                            inputmode="text" maxlength="100" placeholder="Ingrese el nombre del pais" required>
                        @error('nameES')
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
