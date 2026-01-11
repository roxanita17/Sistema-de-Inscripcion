
<div class="modal fade" id="viewModal{{ $datos->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $datos->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-modern">
            <div class="modal-header-view">
                <div class="modal-icon-view">
                    <i class="fas fa-eye"></i>
                </div>
                <h5 class="modal-title-view" id="viewModalLabel{{ $datos->id }}">
                    Detalles del Año Escolar
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            
            <div class="modal-body-view">
                <div class="details-card">

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-id-badge"></i>
                            Número de Listado
                        </span>
                        <span class="detail-value">{{ $index + 1 }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-calendar-alt"></i>
                            Fecha de Inicio
                        </span>
                        <span class="detail-value">
                            {{ \Carbon\Carbon::parse($datos->inicio_anio_escolar)->format('d/m/Y') }}
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-calendar-check"></i>
                            Fecha de Cierre
                        </span>
                        <span class="detail-value">
                            {{ \Carbon\Carbon::parse($datos->cierre_anio_escolar)->format('d/m/Y') }}
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-clock"></i>
                            Duración
                        </span>
                        <span class="detail-value">
                            @php
                                $inicio = \Carbon\Carbon::parse($datos->inicio_anio_escolar);
                                $cierre = \Carbon\Carbon::parse($datos->cierre_anio_escolar);
                                $dias = $inicio->diffInDays($cierre);
                                $meses = floor($dias / 30);
                            @endphp
                            {{ $meses }} meses ({{ $dias }} días)
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-toggle-on"></i>
                            Estado del Año Escolar
                        </span>
                        <span class="detail-value">
                            @if ($datos->status == 'Activo')
                                <span class="badge-sm badge-status badge-active">Activo</span>
                            @elseif ($datos->status == 'Extendido')
                                <span class="badge-sm badge-status badge-extended">Extendido</span>
                            @else
                                <span class="badge-sm badge-status badge-inactive">Inactivo</span>
                            @endif
                        </span>
                    </div>

                    <div style="border-top: 2px dashed var(--gray-200); margin: 1rem 0;"></div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-calendar-plus"></i>
                            Fecha de Creación
                        </span>
                        <span class="detail-value">
                            {{ \Carbon\Carbon::parse($datos->created_at)->format('d/m/Y H:i:s') }}
                        </span>
                    </div>

                    @if ($datos->updated_at != $datos->created_at)
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-calendar-edit"></i>
                                Última Actualización
                            </span>
                            <span class="detail-value">
                                {{ \Carbon\Carbon::parse($datos->updated_at)->format('d/m/Y H:i:s') }}
                                <small
                                    style="display: block; color: var(--gray-700); font-size: 0.8rem; margin-top: 0.25rem;">
                                    ({{ \Carbon\Carbon::parse($datos->updated_at)->diffForHumans() }})
                                </small>
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="modal-footer-view">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times-circle"></i>
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
