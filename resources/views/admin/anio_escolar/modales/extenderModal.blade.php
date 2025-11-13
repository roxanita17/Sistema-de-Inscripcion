<!-- Modal Extender Año Escolar -->
<div class="modal fade" id="viewModalExtender{{ $datos->id }}" tabindex="-1"
    aria-labelledby="viewModalExtenderLabel{{ $datos->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">
            <div class="modal-header-edit">
                <div class="modal-icon-edit">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <h5 class="modal-title-edit" id="viewModalExtenderLabel{{ $datos->id }}">
                    Extender Año Escolar
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body-edit">
                <form action="{{ route('admin.anio_escolar.modales.extender', $datos->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $datos->id }}">

                    <!-- Inicio -->
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Inicio del Año Escolar
                        </label>
                        <input type="date" class="form-control-modern" value="{{ $datos->inicio_anio_escolar }}" readonly>
                    </div>

                    <!-- Cierre actual -->
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-clock me-2"></i>
                            Fecha de cierre actual
                        </label>
                        <input type="date" class="form-control-modern" value="{{ $datos->cierre_anio_escolar }}" readonly>
                    </div>

                    <!-- Nuevo cierre -->
                    <div class="form-group-modern">
                        <label class="form-label-modern text-danger">
                            <i class="fas fa-calendar-plus me-2"></i>
                            Extender hasta (nuevo cierre)
                        </label>
                        <input type="date" class="form-control-modern" id="extenderHasta{{ $datos->id }}" name="cierre_anio_escolar">
                        <div id="extender_error_{{ $datos->id }}" class="error-message d-none">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            La fecha de cierre no puede ser anterior al inicio.
                        </div>
                    </div>

                    <div class="modal-footer-edit">
                        <div class="footer-buttons">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </button>
                            <button type="submit" class="btn-modal-edit">
                                <i class="fas fa-save me-1"></i> Guardar Extensión
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
