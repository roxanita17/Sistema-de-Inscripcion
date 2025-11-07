<!-- Modal Crear Año Escolar -->
<div class="modal fade" id="modalCrearEtniaIndigena" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalCrearEtniaIndigenaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCrearEtniaLabel">Registrar Etnia Indigena</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.etnia_indigena.modales.store') }}" method="POST">
                    @csrf
                    <div id="contenedorAlertaCrear"></div>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><span class="text-danger">*</span> Nombre</span>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    @error('nombre')
                        <div class="alert text-danger p-0 m-0">
                            <b>{{ 'Este campo es obligatorio.' }}</b>
                        </div>
                    @enderror

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </form>
            </div>

            

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


