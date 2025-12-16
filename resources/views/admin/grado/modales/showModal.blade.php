{{-- Modal Ver Detalles del Grado --}}
<div class="modal fade" id="viewModal{{ $datos->id }}" tabindex="-1" 
     aria-labelledby="viewModalLabel{{ $datos->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-modern">

            {{-- Cabecera del modal --}}
            <div class="modal-header-view">
                <div class="modal-icon-view">
                    <i class="fas fa-eye"></i>
                </div>
                <h5 class="modal-title-view" id="viewModalLabel{{ $datos->id }}">
                    Detalles del Año
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cuerpo del modal --}}
            <div class="modal-body-view">
                <div class="details-card">

                    {{-- Número de grado --}}
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-sort-numeric-up"></i>
                            Año
                        </span>
                        <span class="detail-value">{{ $datos->numero_grado }}</span>
                    </div>

                    {{-- Capacidad máxima --}}
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-users"></i>
                            Capacidad máxima de cupos
                        </span>
                        <span class="detail-value">{{ $datos->capacidad_max }}</span>
                    </div>

                    {{-- Mínimo de sección --}}
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-layer-group"></i>
                            Mínimo de sección
                        </span>
                        <span class="detail-value">{{ $datos->min_seccion }}</span>
                    </div>

                    {{-- Máximo de sección --}}
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-layer-group"></i>
                            Máximo de sección
                        </span>
                        <span class="detail-value">{{ $datos->max_seccion }}</span>
                    </div>

                    {{-- Estado --}}
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-toggle-on"></i>
                            Estado
                        </span>
                        <span class="detail-value">
                            @if ($datos->status == true)
                                <span class="badge-status badge-active">Activo</span>
                            @else
                                <span class="badge-status badge-inactive">Inactivo</span>
                            @endif
                        </span>
                    </div>

                    {{-- Separador visual --}}
                    <div style="border-top: 2px dashed var(--gray-200); margin: 1rem 0;"></div>

                </div>
            </div>

            {{-- Pie del modal --}}
            <div class="modal-footer-view">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>
