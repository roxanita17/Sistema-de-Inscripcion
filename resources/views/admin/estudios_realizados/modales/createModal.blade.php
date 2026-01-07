<!-- Modal Crear Grado -->
<div class="modal fade" id="modalCrearEstudio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearEstudioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">

            {{-- Cabecera del modal --}}
            <div class="modal-header-create">
                <div class="modal-icon-create">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5 class="modal-title-create" id="modalCrearEstudioLabel">Nuevo Estudio Realizado</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cuerpo del modal con formulario --}}
            <div class="modal-body-create">
                <form action="{{ route('admin.estudios_realizados.modales.store') }}" method="POST" id="formCrearEstudiosRealizados">
                    @csrf
                    <input type="hidden" name="redirect_to" value="{{ url()->current() }}">


                    {{-- Contenedor para alertas de validación --}}
                    <div id="contenedorAlertaCrear"></div>

                    {{-- Nombre --}}
                    <div class="form-group-modern">
                        <label for="estudios" class="form-label-modern">
                            <i class="fas fa-hashtag me-2"></i> Nombre del estudio
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="estudios" 
                               name="estudios"
                               type="text"
                               inputmode="text"
                               maxlength="100"
                               placeholder="Ingrese el nombre del estudio realizado"
                               required>
                        @error('estudios')
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
