{{-- Modal Ver Detalles del Representante --}}
<div class="modal fade" id="modalVerDetalleRegistro" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="modalVerDetalleRegistroLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-modern">

            {{-- Cabecera del modal --}}
            <div class="modal-header-view">
                <div class="modal-icon-view">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h5 class="modal-title-view" id="modalVerDetalleRegistroLabel">
                    Detalles del Representante
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cuerpo del modal --}}
            <div class="modal-body-view">
                <div class="details-card">

                    {{-- Datos personales --}}
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-id-card"></i>
                            Primer Nombre
                        </span>
                        <span class="detail-value" id="modal-primer-nombre"></span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-id-card"></i>
                            Segundo Nombre
                        </span>
                        <span class="detail-value" id="modal-segundo-nombre"></span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-id-card"></i>
                            Primer Apellido
                        </span>
                        <span class="detail-value" id="modal-primer-apellido"></span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-id-card"></i>
                            Segundo Apellido
                        </span>
                        <span class="detail-value" id="modal-segundo-apellido"></span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-id-badge"></i>
                            C.I.
                        </span>
                        <span class="detail-value" id="modal-numero_documento"></span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-calendar-alt"></i>
                            Fecha de Nacimiento
                        </span>
                        <span class="detail-value" id="modal-lugar-nacimiento"></span>
                    </div>

                    {{-- Contacto --}}
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-phone"></i>
                            Teléfono
                        </span>
                        <span class="detail-value" id="modal-telefono"></span>
                    </div>

                    <div class="detail-item" id="correo-detail-item">
                        <span class="detail-label">
                            <i class="fas fa-envelope"></i>
                            Correo
                        </span>
                        <span class="detail-value" id="modal-correo"></span>
                    </div>

                    {{-- Relación familiar --}}
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-briefcase"></i>
                            Ocupación
                        </span>
                        <span class="detail-value" id="modal-ocupacion"></span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-home"></i>
                            Convive con el estudiante
                        </span>
                        <span class="detail-value" id="modal-convive"></span>
                    </div>

                    {{-- Sección de representante legal (visible solo si aplica) --}}
                    <div id="legal-info-section" style="display: none;">
                        <div style="border-top: 2px dashed var(--gray-200); margin: 1rem 0;"></div>

                        <h6 class="text-warning mb-3">
                            <i class="fas fa-gavel me-2"></i>Datos de Representante Legal
                        </h6>

                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-user-tag"></i>
                                Parentesco
                            </span>
                            <span class="detail-value" id="modal-parentesco"></span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-id-card-alt"></i>
                                Carnet de la Patria
                            </span>
                            <span class="detail-value" id="modal-carnet-afiliado" class="badge"></span>
                        </div>

                        <div class="detail-item" id="campo-codigo">
                            <span class="detail-label">
                                <i class="fas fa-hashtag"></i>
                                Código
                            </span>
                            <span class="detail-value" id="modal-codigo"></span>
                        </div>

                        <div class="detail-item" id="campo-serial">
                            <span class="detail-label">
                                <i class="fas fa-barcode"></i>
                                Serial
                            </span>
                            <span class="detail-value" id="modal-serial"></span>
                        </div>

                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-users-cog"></i>
                                Pertenece a organización
                            </span>
                            <span class="detail-value" id="modal-pertenece-org" class="badge"></span>
                        </div>

                        <div class="detail-item" id="campo-organizacion">
                            <span class="detail-label">
                                <i class="fas fa-building"></i>
                                Organización
                            </span>
                            <span class="detail-value" id="modal-org-pertenece"></span>
                        </div>
                    </div>

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
