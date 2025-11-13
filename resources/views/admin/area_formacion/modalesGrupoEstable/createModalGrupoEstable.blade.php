<!-- Modal Crear Area de Formación -->
<div class="modal fade" id="modalCrearGrupoEstable" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearGrupoEstableLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">
            <div class="modal-header-create">
                <div class="modal-icon-create">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5 class="modal-title-create" id="modalCrearGrupoEstableLabel">Nuevo Grupo Estable</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body-create">
                <form id="formGrupoEstable" action="{{ route('admin.area_formacion.modalesGrupoEstable.storeGrupoEstable') }}" method="POST">
                    @csrf

                    <!-- Nombre del area de formación -->
                    <div class="form-group-modern">
                        <label for="nombre_grupo_estable" class="form-label-modern">
                            <i class="fas fa-book"></i>
                            Nombre del grupo estable
                        </label>
                        <input type="text" 
                            name="nombre_grupo_estable" 
                            id="nombre_grupo_estable" 
                            class="form-control-modern" 
                            placeholder="Ingrese el nombre del grupo estable"
                            required>
                        
                        @error('nombre_grupo_estable')
                            <div class="error-message">
                                Este campo es obligatorio.
                            </div>
                        @enderror
                    </div>              

                    {{-- Botones --}}
                    <div class="modal-footer-create">
                        <div class="footer-buttons">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>
                                Cancelar
                            </button>
                            <button type="submit" class="btn-modal-create">
                                <i class="fas fa-save me-1"></i>
                                Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
