<div class="modal fade" id="viewModal{{ $datos->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $datos->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-modern">
            <div class="modal-header-view">
                <div class="modal-icon-view">
                    <i class="fas fa-eye"></i>
                </div>
                <h5 class="modal-title-view" id="viewModalLabel{{ $datos->id }}">
                    Detalles del Nivel Academico
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body-view">
                <div class="details-card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-sort-numeric-up"></i>
                                    Nivel Academico
                                </span>
                                <span class="detail-value">{{ $datos->numero_grado }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-users"></i>
                                    Capacidad máxima de cupos
                                </span>
                                <span class="detail-value">{{ $datos->capacidad_max }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-layer-group"></i>
                                    Mínimo de sección
                                </span>
                                <span class="detail-value">{{ $datos->min_seccion }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-layer-group"></i>
                                    Máximo de sección
                                </span>
                                <span class="detail-value">{{ $datos->max_seccion }}</span>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer-view">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>