<!-- Modal Crear Año Escolar -->
<div class="modal fade" id="modalCrearRol" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalCrearRolLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="modalCrearRolLabel">Registrar Rol</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.roles.modales.store') }}" method="POST" id="formCrearRol">
                    @csrf
                    <div id="contenedorAlertaCrear"></div>
                    <div class="form-group">
                        <label for="">Nombre del rol</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-user"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>

                    @error('name')
                        <div class="alert text-danger p-0 m-0">
                            <b>{{ 'Este campo es obligatorio.' }}</b>
                        </div>
                    @enderror

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="formCrearRol">
                            Guardar
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-arrow-left" style="margin-right: 5px;"></i>Cancelar
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


