{{-- Modal Ver Detalles del Representante --}}
<div class="modal fade" id="modalVerDetalleRegistro" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="modalVerDetalleRegistroLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content modal-modern">

            <!-- Cabecera del modal -->
            <div class="modal-header-view">
                <div class="d-flex align-items-center justify-content-center gap-2 w-100">
                    <h5 class="modal-title-view text-white mb-0" id="modalVerDetalleRegistroLabel">
                        <i class="fas fa-user-tie me-2"></i>
                        <span>Detalles del Representante</span>
                    </h5>
                    <span id="tipo-representante-badge" class="badge fs-6"></span>
                </div>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Cuerpo del modal -->
            <div class="modal-body-view p-4">
                <div class="row g-4">
                    <!-- Columna izquierda - Datos Personales -->
                    <div class="col-lg-6">
                        <div class="details-card h-100">
                            
                            <h6 class="section-title">
                                <i class="fas fa-id-badge"></i> Identificación
                            </h6>

                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-id-card"></i> Tipo de Documento
                                </span>
                                <span class="detail-value" id="modal-tipo-documento">N/A</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-id-card"></i> Número de Cédula
                                </span>
                                <span class="detail-value fw-bold" id="modal-numero_documento">N/A</span>
                            </div>

                            <h6 class="section-title">
                                <i class="fas fa-user"></i> Datos Personales
                            </h6>

                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-user"></i> Nombres Completos
                                </span>
                                <span class="detail-value">
                                    <span id="modal-primer-nombre">N/A</span>
                                    <span id="modal-segundo-nombre"></span>
                                    <span id="modal-tercer-nombre"></span>
                                </span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-user"></i> Apellidos Completos
                                </span>
                                <span class="detail-value">
                                    <span id="modal-primer-apellido">N/A</span>
                                    <span id="modal-segundo-apellido"></span>
                                </span>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-calendar-alt"></i> Fecha de Nacimiento
                                        </span>
                                        <span class="detail-value" id="modal-fecha-nacimiento">N/A</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-venus-mars"></i> Género
                                        </span>
                                        <span class="detail-value" id="modal-genero">N/A</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Columna derecha - Contacto y Ubicación -->
                    <div class="col-lg-6">
                        <div class="details-card h-100">
                            
                            <h6 class="section-title">
                                <i class="fas fa-phone-alt"></i> Contacto y Ubicación
                            </h6>
                            
                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-phone"></i> Teléfono Principal
                                </span>
                                <span class="detail-value" id="modal-telefono">N/A</span>
                            </div>
                            
                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-phone"></i> Teléfono Secundario
                                </span>
                                <span class="detail-value" id="modal-telefono-dos">N/A</span>
                            </div>

                            <div class="detail-item" id="correo-detail-item" style="display: none;">
                                <span class="detail-label">
                                    <i class="fas fa-envelope"></i> Correo Electrónico
                                </span>
                                <span class="detail-value" id="modal-correo">N/A</span>
                            </div>

                            <h6 class="section-title">
                                <i class="fas fa-map-marker-alt"></i> Ubicación
                            </h6>

                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-map-marker-alt"></i> Pais
                                </span>
                                <span class="detail-value" id="modal-estado">N/A</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-map-marker-alt"></i> Estado
                                </span>
                                <span class="detail-value" id="modal-estado">N/A</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-map-marker-alt"></i> Municipio
                                </span>
                                <span class="detail-value" id="modal-municipio">N/A</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-map-marker-alt"></i> Parroquia
                                </span>
                                <span class="detail-value" id="modal-parroquia">N/A</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-home"></i> Dirección de Habitación
                                </span>
                                <span class="detail-value" id="modal-direccion">N/A</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Fila adicional - Información Laboral y Familiar -->
                <div class="row g-4 mt-2">
                    <div class="col-lg-6">
                        <div class="details-card">
                            
                            <h6 class="section-title">
                                <i class="fas fa-briefcase"></i> Información Laboral
                            </h6>
                            
                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-briefcase"></i> Ocupación
                                </span>
                                <span class="detail-value" id="modal-ocupacion">N/A</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-home"></i> Convive con el estudiante
                                </span>
                                <span class="detail-value">
                                    <span id="modal-convive" class="badge">N/A</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de representante legal (visible solo si aplica) -->
                    <div id="legal-info-section" class="col-lg-12" style="display: none;">
                        <div class="details-card">
                            
                            <h6 class="section-title">
                                <i class="fas fa-gavel"></i> Datos de Representante Legal
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-user-tag"></i> Parentesco
                                        </span>
                                        <span class="detail-value" id="modal-parentesco">N/A</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-id-card-alt"></i> Carnet de la Patria
                                        </span>
                                        <span class="detail-value">
                                            <span id="modal-carnet-afiliado" class="badge">N/A</span>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4" id="campo-codigo">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-hashtag"></i> Código Carnet
                                        </span>
                                        <span class="detail-value" id="modal-codigo">N/A</span>
                                    </div>
                                </div>

                                <div class="col-md-4" id="campo-serial">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-barcode"></i> Serial Carnet
                                        </span>
                                        <span class="detail-value" id="modal-serial">N/A</span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-users-cog"></i> Pertenece a organización
                                        </span>
                                        <span class="detail-value">
                                            <span id="modal-pertenece-org" class="badge">N/A</span>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-12" id="campo-organizacion" style="display: none;">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-building"></i> Organización
                                        </span>
                                        <span class="detail-value" id="modal-org-pertenece">N/A</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-credit-card"></i> Tipo de Cuenta
                                        </span>
                                        <span class="detail-value" id="modal-tipo-cuenta">N/A</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-university"></i> Banco
                                        </span>
                                        <span class="detail-value" id="modal-banco">N/A</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie del modal -->
            <div class="modal-footer-view">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>