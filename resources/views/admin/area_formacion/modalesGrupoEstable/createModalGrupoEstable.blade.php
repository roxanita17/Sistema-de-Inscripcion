<!-- Modal Crear Municipio -->
<div class="modal fade" id="modalCrearGrupoEstable" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalCrearGrupoEstableLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCrearGrupoEstableLabel">Registrar Grupo Estable</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.area_formacion.modalesGrupoEstable.storeGrupoEstable') }}" method="POST" id="formCrearGrupoEstable">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre_grupo_estable" class="form-label">Nombre del grupo estable</label>
                        <input type="text" class="form-control" id="nombre_grupo_estable" name="nombre_grupo_estable" required>
                    </div>

                    @error('nombre_grupo_estable')
                        <div class="alert text-danger p-0 m-0">
                            <b>{{ 'Este campo es obligatorio.' }}</b>
                        </div>
                    @enderror

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="formCrearGrupoEstable">
                            Guardar
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>






