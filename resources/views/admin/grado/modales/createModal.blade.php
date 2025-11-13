<!-- Modal Crear Grado -->
<div class="modal fade" id="modalCrearGrado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearGradoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">

            {{-- Cabecera del modal --}}
            <div class="modal-header-create">
                <div class="modal-icon-create">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5 class="modal-title-create" id="modalCrearGradoLabel">Nuevo Grado</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cuerpo del modal con formulario --}}
            <div class="modal-body-create">
                <form action="{{ route('admin.grado.modales.store') }}" method="POST" id="formCrearGrado">
                    @csrf

                    {{-- Contenedor para alertas de validación --}}
                    <div id="contenedorAlertaCrear"></div>

                    {{-- Numero de grado --}}
                    <div class="form-group-modern">
                        <label for="numero_grado" class="form-label-modern">
                            <i class="fas fa-hashtag me-2"></i> Número de Grado
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="numero_grado" 
                               name="numero_grado" 
                               inputmode="numeric" 
                               pattern="[0-9]+" 
                               maxlength="2" 
                               oninput="this.value=this.value.replace(/[^0-9]/g,'')" 
                               required>
                        @error('numero_grado')
                            <div class="error-message">
                                Este campo es obligatorio.
                            </div>
                        @enderror
                    </div>

                    {{-- Capacidad máxima --}}
                    <div class="form-group-modern">
                        <label for="capacidad_max" class="form-label-modern">
                            <i class="fas fa-users me-2"></i> Capacidad Máxima de Cupos
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="capacidad_max" 
                               name="capacidad_max" 
                               inputmode="numeric" 
                               pattern="[0-9]+" 
                               maxlength="3" 
                               oninput="this.value=this.value.replace(/[^0-9]/g,'')" 
                               required>
                        @error('capacidad_max')
                            <div class="error-message">
                                Este campo es obligatorio.
                            </div>
                        @enderror
                    </div>

                    {{-- Mínimo de sección --}}
                    <div class="form-group-modern">
                        <label for="min_seccion" class="form-label-modern">
                            <i class="fas fa-layer-group me-2"></i> Mínimo de Sección
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="min_seccion" 
                               name="min_seccion" 
                               inputmode="numeric" 
                               pattern="[0-9]+" 
                               maxlength="2" 
                               oninput="this.value=this.value.replace(/[^0-9]/g,'')" 
                               required>
                        @error('min_seccion')
                            <div class="error-message">
                                Este campo es obligatorio.
                            </div>
                        @enderror
                    </div>

                    {{-- Máximo de sección --}}
                    <div class="form-group-modern">
                        <label for="max_seccion" class="form-label-modern">
                            <i class="fas fa-layer-group me-2"></i> Máximo de Sección
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="max_seccion" 
                               name="max_seccion" 
                               inputmode="numeric" 
                               pattern="[0-9]+" 
                               maxlength="2" 
                               oninput="this.value=this.value.replace(/[^0-9]/g,'')" 
                               required>
                        @error('max_seccion')
                            <div class="error-message">
                                Este campo es obligatorio.
                            </div>
                        @enderror
                    </div>

                    {{-- Pie del formulario --}}
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
