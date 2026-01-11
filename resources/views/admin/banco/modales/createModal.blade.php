<div class="modal fade" id="modalCrear" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">
            <div class="modal-header-create">
                <div class="modal-icon-create">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5 class="modal-title-create" id="modalCrearLabel">Nuevo Banco</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body-create">
                <form action="{{ route('admin.banco.modales.store') }}" method="POST" id="formCrearBanco">
                    @csrf
                    <div id="contenedorAlertaCrear"></div>
                    <div class="form-group-modern">
                        <label for="codigo_banco" class="form-label-modern">
                            <i class="fas fa-hashtag"></i>
                            Codigo
                        </label>
                        <input type="text" name="codigo_banco" inputmode="numeric" id="codigo_banco"
                            class="form-control-modern" placeholder="Ingrese el codigo" min="0" max="120"
                            pattern="[0-9]+" maxlength="4" oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                            required>
                        @error('codigo_banco')
                            <div class="error-message">
                                Este campo es obligatorio.
                            </div>
                        @enderror
                    </div>
                    <div class="form-group-modern">
                        <label for="nombre_banco" class="form-label-modern">
                            <i class="fas fa-hashtag me-2"></i> 
                            Nombre
                        </label>
                        <input type="text" class="form-control-modern" id="nombre_banco" name="nombre_banco"
                            type="text" inputmode="text" maxlength="100" placeholder="Ingrese el nombre del banco"
                            required>
                        @error('nombre_banco')
                            <div class="error-message">
                                Este campo es obligatorio.
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