<!-- Modal Crear Grado -->
<div class="modal fade" id="modalCrear" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">

            {{-- Cabecera del modal --}}
            <div class="modal-header-create">
                <div class="modal-icon-create">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5 class="modal-title-create" id="modalCrearLabel">Nuevo Etnia Indígena</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cuerpo del modal con formulario --}}
            <div class="modal-body-create">
                <form action="{{ route('admin.etnia_indigena.modales.store') }}" method="POST" id="formCrear">
                    @csrf

                    {{-- Contenedor para alertas de validación --}}
                    <div id="contenedorAlertaCrear"></div>

                    {{-- Nombre --}}
                    <div class="form-group-modern">
                        <label for="nombre" class="form-label-modern">
                            <i class="fas fa-hashtag me-2"></i> Nombre de la Etnia Indígena
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="nombre" 
                               name="nombre" 
                               inputmode="text" 
                               pattern="[a-zA-Z ]+" 
                               maxlength="50" 
                               placeholder="Ingrese el nombre de la etnia indígena"
                               required>
                        @error('nombre')
                            <div class="error-message">
                                Este campo es obligatorio.
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
