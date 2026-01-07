<div class="modal fade" id="viewModalEditar{{ $datos->id }}" tabindex="-1" aria-labelledby="viewModalEditarLabel{{ $datos->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">

            <div class="modal-header-edit">
                <div class="modal-icon-edit">
                    <i class="fas fa-pen"></i>
                </div>
                <h5 class="modal-title-edit" id="viewModalEditarLabel{{ $datos->id }}">
                    Editar Prefijo
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body-edit">
                <form action="{{ route('admin.prefijo_telefono.modales.update', $datos->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $datos->id }}">

                    <div class="form-group-modern">
                        <label for="prefijo_{{ $datos->id }}" class="form-label-modern">
                            Número de prefijo
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="prefijo_{{ $datos->id }}" 
                               name="prefijo" 
                               inputmode="numeric" 
                               pattern="[0-9]+" 
                               maxlength="4" 
                               value="{{ $datos->prefijo }}" 
                               oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                               required>
                        @error('prefijo')
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