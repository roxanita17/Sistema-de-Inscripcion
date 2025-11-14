<!-- Modal Crear Grado -->
<div class="modal fade" id="modalCrear" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">

            {{-- Cabecera del modal --}}
            <div class="modal-header-create">
                <div class="modal-icon-create">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5 class="modal-title-create" id="modalCrearLabel">Nuevo Prefijo</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cuerpo del modal con formulario --}}
            <div class="modal-body-create">
                <form action="{{ route('admin.prefijo_telefono.modales.store') }}" method="POST" id="formCrearPrefijo">
                    @csrf

                    {{-- Contenedor para alertas de validación --}}
                    <div id="contenedorAlertaCrear"></div>

                    {{-- Numero de grado --}}
                    <div class="form-group-modern">
                        <label for="prefijo" class="form-label-modern">
                            <i class="fas fa-hashtag me-2"></i> Número de Grado
                        </label>
                        <input input type="text"
                                class="form-control" 
                                id="prefijo" 
                                name="prefijo" 
                                inputmode="numeric" 
                                pattern="[0-9]+" 
                                maxlength="4" 
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')" 
                                placeholder="Ejemplo: 0412"
                                required>
                        @error('prefijo')
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
