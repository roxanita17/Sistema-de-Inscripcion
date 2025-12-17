<!-- Modal Ver Asignaciones del datos -->
<div class="modal fade" id="viewModal{{ $datos->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $datos->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content modal-modern">

            <!-- HEADER -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewModalLabel{{ $datos->id }}">
                    <i class="fas fa-user-circle me-2"></i> Información del Docente y Asignaciones
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">

                <!-- ======================
                    DATOS BÁSICOS
                ======================= -->
                <h5 class="mb-3">
                    <i class="fas fa-id-badge text-primary"></i> Datos del Docente
                </h5>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Cédula:</strong>
                            {{ $datos->persona->tipoDocumento->nombre }}-{{ $datos->persona->numero_documento }}
                        </p>
                        <p><strong>Nombre completo:</strong>
                            {{ $datos->persona->primer_nombre }}
                            {{ $datos->persona->segundo_nombre }}
                            {{ $datos->persona->primer_apellido }}
                            {{ $datos->persona->segundo_apellido }}
                        </p>
                        <p><strong>Código Interno:</strong>
                            {{ $datos->codigo ?? 'No asignado' }}
                        </p>
                    </div>

                    <div class="col-md-6">

                        <p><strong>Correo:</strong>
                            {{ $datos->persona->email ?? 'Sin registrar' }}
                        </p>
                        <p><strong>Dependencia:</strong>
                            {{ $datos->dependencia ?? 'Sin especificar' }}
                        </p>
                    </div>
                </div>

                <!-- ======================
                    ESTUDIOS REALIZADOS
                ======================= -->
                <h5 class="mb-3">
                    <i class="fas fa-graduation-cap text-success"></i> Estudios Realizados
                </h5>

                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        @forelse ($datos->detalleEstudios as $est)
                            <p class="mb-1">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                {{ $est->estudiosRealizado->estudios }}
                            </p>
                        @empty
                            <p class="text-muted">No posee estudios registrados.</p>
                        @endforelse
                    </div>
                </div>

                <!-- ======================
                    ASIGNACIONES DE MATERIA + GRADO
                ======================= -->
                <h5 class="mb-3">
                    <i class="fas fa-book-open text-warning"></i> Asignaciones Académicas
                </h5>

                <div class="card shadow-sm">
                    <div class="card-body">

                        @forelse ($datos->asignacionesAreasActivas as $asignacion)
                            <div class="border-bottom pb-2 mb-3">

                                <p class="mb-1">
                                    <strong>Grado Área de Formación :</strong>
                                    {{ $asignacion->grado->numero_grado ?? 'N/A' }}
                                    {{ $asignacion->areaEstudios->areaFormacion->nombre_area_formacion ?? 'N/A' }}
                                </p>

                                <p class="mb-2 text-muted" style="font-size:.85rem;">
                                    Asignado el: {{ $asignacion->created_at->format('d/m/Y h:i A') }}
                                </p>
                            </div>
                        @empty
                            <p class="text-center text-muted">Este datos no tiene asignaciones activas.</p>
                        @endforelse

                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>

        </div>
    </div>
</div>
