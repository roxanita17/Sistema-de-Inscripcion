<!-- Modal Ver Información de la Inscripción -->
<div class="modal fade" id="viewModal{{ $datos->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $datos->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content modal-modern shadow">

            <!-- HEADER -->
            <div class="modal-header modal-header-view d-flex flex-column align-items-center text-center">
                <div class="modal-icon-view mb-2">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h5 class="modal-title modal-title-view">
                    Información de la Inscripción
                </h5>
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                    data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body modal-body-view">

                <!-- ======================
                    DATOS DEL ALUMNO
                ======================= -->
                <h5 class="mb-3 text-primary"><i class="fas fa-id-badge me-2"></i> Datos del Alumno</h5>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="details-card">
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-id-card"></i> Cédula</span>
                                <span
                                    class="detail-value">{{ $datos->alumno->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $datos->alumno->persona->numero_documento ?? 'N/A' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-user"></i> Nombre Completo</span>
                                <span class="detail-value">
                                    {{ $datos->alumno->persona->primer_nombre ?? '' }}
                                    {{ $datos->alumno->persona->segundo_nombre ?? '' }}
                                    {{ $datos->alumno->persona->primer_apellido ?? '' }}
                                    {{ $datos->alumno->persona->segundo_apellido ?? '' }}
                                </span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-graduation-cap"></i> Grado Inscrito</span>
                                <span class="detail-value">{{ $datos->grado->numero_grado ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="details-card">
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-male"></i> Padre</span>
                                <span
                                    class="detail-value">{{ $datos->padre ? $datos->padre->persona->primer_nombre . ' ' . $datos->padre->persona->primer_apellido : 'No registrado' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-female"></i> Madre</span>
                                <span
                                    class="detail-value">{{ $datos->madre ? $datos->madre->persona->primer_nombre . ' ' . $datos->madre->persona->primer_apellido : 'No registrada' }}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label"><i class="fas fa-user-tie"></i> Representante Legal</span>
                                <span
                                    class="detail-value">{{ $datos->representanteLegal ? $datos->representanteLegal->representante->persona->primer_nombre . ' ' . $datos->representanteLegal->representante->persona->primer_apellido : 'No registrado' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ======================
                    DOCUMENTOS ENTREGADOS
                ======================= -->
                <h5 class="mb-3 text-success">
                    <i class="fas fa-file-alt me-2"></i> Documentos Entregados
                    <span
                        class="badge-status {{ $datos->estado_documentos == 'Completos' ? 'badge-active' : 'badge-extended' }}">
                        {{ $datos->estado_documentos }}
                    </span>
                </h5>

                <div class="row g-3 mb-4">
                    @php
                        $todosDocumentos = [
                            'partida_nacimiento' => 'Partida de Nacimiento',
                            'copia_cedula_representante' => 'Copia Cédula del Representante',
                            'copia_cedula_estudiante' => 'Copia Cédula del Estudiante',
                            'boletin_6to_grado' => 'Boletín 6to Grado',
                            'certificado_calificaciones' => 'Certificado de Calificaciones',
                            'constancia_aprobacion_primaria' => 'Constancia de Aprobación Primaria',
                            'foto_estudiante' => 'Fotografía Estudiante',
                            'foto_representante' => 'Fotografía Representante',
                            'carnet_vacunacion' => 'Carnet de Vacunación',
                            'autorizacion_tercero' => 'Autorización Tercero',
                        ];

                        // Convertir documentos en array
                        $documentosEntregados = is_array($datos->documentos)
                            ? $datos->documentos
                            : (json_decode($datos->documentos, true) ?:
                            []);
                    @endphp

                    @foreach ($todosDocumentos as $key => $label)
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">
                                    <i
                                        class="fas fa-{{ in_array($key, $documentosEntregados) ? 'check-circle text-success' : 'times-circle text-danger' }}"></i>
                                    {{ $label }}
                                </span>
                                <span
                                    class="detail-value">{{ in_array($key, $documentosEntregados) ? 'Entregado' : 'Faltante' }}</span>
                            </div>
                        </div>
                    @endforeach 
                </div>

                <!-- ======================
                    OBSERVACIONES
                ======================= -->
                <h5 class="mb-3 text-warning"><i class="fas fa-comment me-2"></i> Observaciones</h5>
                <div class="details-card">
                    <div class="detail-item">
                        <span class="detail-value">{{ $datos->observaciones ?? 'Sin observaciones' }}</span>
                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer modal-footer-view">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>

        </div>
    </div>
</div>
