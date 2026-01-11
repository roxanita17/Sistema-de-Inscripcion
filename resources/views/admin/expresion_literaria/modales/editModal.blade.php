<div class="modal fade" id="viewModalEditar{{ $datos->id }}" tabindex="-1" aria-labelledby="viewModalEditarLabel{{ $datos->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">
            <div class="modal-header-edit">
                <div class="modal-icon-edit">
                    <i class="fas fa-pen"></i>
                </div>
                <h5 class="modal-title-edit" id="viewModalEditarLabel{{ $datos->id }}">
                    Editar Expresión Literalia
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body-edit">
                <form action="{{ route('admin.expresion_literaria.modales.update', $datos->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $datos->id }}">
                    <div class="form-group-modern">
                        <label for="letra_expresion_literaria_{{ $datos->id }}" class="form-label-modern">
                            Letra de la Expresión Literalia
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="letra_expresion_literaria_{{ $datos->id }}" 
                               name="letra_expresion_literaria" 
                               type="text"
                               inputmode="text"
                               maxlength="1"
                               placeholder="Edite la letra de la expresión literaria"
                               pattern="[A-Za-z]"
                               oninput="this.value = this.value.toUpperCase().replace(/[^A-Z]/g, '');"
                               title="Debe ingresar solo una letra (A-Z)"
                               value="{{ $datos->letra_expresion_literaria }}" 
                               required>
                        @error('letra_expresion_literaria')
                            <div class="error-message">
                                Este campo es obligatorio.
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
