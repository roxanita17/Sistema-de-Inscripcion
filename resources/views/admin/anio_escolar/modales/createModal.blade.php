<!-- Modal Crear Año Escolar -->

<div class="modal fade" id="modalCrearAnioEscolar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearAnioEscolarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">
            <div class="modal-header-create">
                <div class="modal-icon-create">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5 class="modal-title-create" id="modalCrearAnioEscolarLabel">Nueva Año Escolar</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body-create">
                <form id="formAnioEscolar" action="{{ route('admin.anio_escolar.modales.store') }}" method="POST">
                    @csrf

                    <div class="form-group-modern">
                        <label for="inicio_anio_escolar" class="form-label-modern">
                            <i class="fas fa-calendar-day me-2"></i> Desde
                        </label>
                        <input type="date" class="form-control-modern" id="inicio_anio_escolar" name="inicio_anio_escolar" required>
                    </div>

                    <div class="form-group-modern">
                        <label for="cierre_anio_escolar" class="form-label-modern">
                            <i class="fas fa-calendar-check me-2"></i> Hasta
                        </label>
                        <input type="date" class="form-control-modern" id="cierre_anio_escolar" name="cierre_anio_escolar" required>
                    </div>
                    <div id="cierre_anio_escolar_error" class="text-danger mb-2"></div>
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
                           