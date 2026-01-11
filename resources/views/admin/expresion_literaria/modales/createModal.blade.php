<div class="modal fade" id="modalCrear" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">

            <div class="modal-header-create">
                <div class="modal-icon-create">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5 class="modal-title-create" id="modalCrearLabel">Nuevo Expresión Literaria</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body-create">
                <form action="{{ route('admin.expresion_literaria.modales.store') }}" method="POST" id="formCrearExpresionLiteraria">
                    @csrf

                    <div id="contenedorAlertaCrear"></div>

                    <div class="form-group-modern">
                        <label for="letra_expresion_literaria" class="form-label-modern">
                            <i class="fas fa-hashtag me-2"></i> Letra
                        </label>
                        <input type="text" 
                               placeholder="Ingrese la letra de la expresión literaria"
                               class="form-control-modern" 
                               id="letra_expresion_literaria" 
                               name="letra_expresion_literaria"
                               type="text"
                               maxlength="1"
                               pattern="[A-Za-z]"
                               oninput="this.value = this.value.toUpperCase().replace(/[^A-Z]/g, '');"
                               title="Debe ingresar solo una letra (A-Z)"
                               required>
                        @error('letra_expresion_literaria')
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
