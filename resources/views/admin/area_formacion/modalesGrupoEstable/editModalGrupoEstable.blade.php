<!-- Modal Editar Area de Formación -->
<div class="modal fade" id="viewModalEditarGrupoEstable{{ $grupo->id }}" tabindex="-1" aria-labelledby="viewModalEditarLabel{{ $grupo->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">

            {{-- Cabecera del modal --}}
            <div class="modal-header-edit">
                <div class="modal-icon-edit">
                    <i class="fas fa-pen"></i>
                </div>
                <h5 class="modal-title-edit" id="viewModalEditarLabel{{ $grupo->id }}">
                    Editar Grupo Estable
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cuerpo del modal con formulario --}}
            <div class="modal-body-edit">
                <form action="{{ route('admin.area_formacion.modalesGrupoEstable.updateGrupoEstable', $grupo->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $grupo->id }}">

                    {{-- Nombre del grupo estable --}}
                    <div class="form-group-modern">
                        <label for="nombre_grupo_estable_{{ $grupo->id }}" class="form-label-modern">
                            Nombre del Grupo Estable
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="nombre_grupo_estable_{{ $grupo->id }}" 
                               name="nombre_grupo_estable" 
                               value="{{ $grupo->nombre_grupo_estable }}" 
                               required>
                        @error('nombre_grupo_estable')
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
