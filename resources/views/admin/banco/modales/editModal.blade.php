<!-- Modal Editar Banco -->
<div class="modal fade" id="viewModalEditar{{ $datos->id }}" tabindex="-1" aria-labelledby="viewModalEditarLabel{{ $datos->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">

            {{-- Cabecera del modal --}}
            <div class="modal-header-edit">
                <div class="modal-icon-edit">
                    <i class="fas fa-pen"></i>
                </div>
                <h5 class="modal-title-edit" id="viewModalEditarLabel{{ $datos->id }}">
                    Editar Banco
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cuerpo del modal con formulario --}}
            <div class="modal-body-edit">
                <form action="{{ route('admin.banco.modales.update', $datos->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $datos->id }}">

                    {{-- Codigo --}}
                    <div class="form-group-modern">
                        <label for="codigo_banco_{{ $datos->id }}" class="form-label-modern">
                            Codigo
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="codigo_banco_{{ $datos->id }}" 
                               name="codigo_banco" 
                               type="text"
                               inputmode="numeric"
                               pattern="[0-9]+"
                               maxlength="4"
                               placeholder="Edite el codigo"
                               value="{{ $datos->codigo_banco }}" 
                               required>
                        @error('codigo_banco')
                            <div class="error-message">
                                Este campo es obligatorio.
                            </div>
                        @enderror
                    </div>

                    {{-- Nombre --}}
                    <div class="form-group-modern">
                        <label for="nombre_banco_{{ $datos->id }}" class="form-label-modern">
                            Nombre
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="nombre_banco_{{ $datos->id }}" 
                               name="nombre_banco" 
                               type="text"
                               inputmode="text"
                               maxlength="100"
                               placeholder="Edite el nombre"
                               value="{{ $datos->nombre_banco }}" 
                               required>
                        @error('nombre_banco')
                            <div class="error-message">
                                Este campo es obligatorio.
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
