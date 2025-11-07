<!-- Modal Crear Año Escolar -->
<div class="modal fade" id="modalCrearAnioEscolar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalCrearAnioEscolarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCrearAnioEscolarLabel">Registrar Año Escolar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.anio_escolar.modales.store') }}" method="POST">
                    @csrf
                    <div id="contenedorAlertaCrear"></div>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><span class="text-danger">*</span> Desde</span>
                        <input type="date" class="form-control" id="inicio_anio_escolar" name="inicio_anio_escolar">
                    </div>
                    <div id="inicio_anio_escolar_error" class="text-danger mb-2"></div>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><span class="text-danger">*</span> Hasta</span>
                        <input type="date" class="form-control" id="cierre_anio_escolar" name="cierre_anio_escolar">
                    </div>
                    <div id="cierre_anio_escolar_error" class="text-danger mb-2"></div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                    </div>

                </form>
            </div>

            

        </div>
    </div>
</div>

