<!-- Modal Ver Información de la Inscripción por Prosecución -->
<div class="modal fade" id="viewModal{{ $datos->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $datos->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content modal-modern shadow">

            <!-- HEADER -->
            <div class="modal-header modal-header-view">
                <div class="w-100 text-center">
                    <h5 class="modal-title-view mb-2">Información de Inscripción por Prosecución</h5>
                    {{ \Carbon\Carbon::parse($datos->anioEscolar->inicio_anio_escolar)->year }}
                    -
                    {{ \Carbon\Carbon::parse($datos->anioEscolar->cierre_anio_escolar)->year }}
                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge badge-status badge-{{ strtolower($datos->status) }}">
                            {{ $datos->status }}
                        </span>
                        <span class="badge bg-white text-primary">
                            <i class="fas fa-graduation-cap"></i> {{ $datos->grado->numero_grado ?? 'N/A' }}° Grado
                        </span>
                        @if ($datos->seccion)
                            <span class="badge bg-white text-info">
                                <i class="fas fa-th-large"></i> Sección {{ $datos->seccion->nombre }}
                            </span>
                        @endif
                        @if ($datos->repite_grado)
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-redo"></i> Repite Grado
                            </span>
                        @else
                            <span class="badge bg-success">
                                <i class="fas fa-arrow-up"></i> Promovido
                            </span>
                        @endif
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                    data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body modal-body-view">

                <!-- ======================
                    SECCIÓN 1: DATOS DEL ESTUDIANTE
                ======================= -->
                <div class="mb-4">
                    <div class="section-title">
                        <i class="fas fa-user-graduate text-primary"></i>
                        <span>Datos del Estudiante</span>
                    </div>
                    <div class="card mini-card shadow-sm border-0 p-3 mt-2">
                        <div class="row g-3">
                            <!-- Información personal -->
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-id-card"></i> Cédula
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->inscripcion->alumno->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $datos->inscripcion->alumno->persona->numero_documento ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-calendar-alt"></i> Fecha de Nacimiento
                                    </span>
                                    <span class="detail-value">
                                        {{ \Carbon\Carbon::parse($datos->inscripcion->alumno->persona->fecha_nacimiento)->format('d/m/Y') ?? 'N/A' }}
                                        <small class="text-muted">
                                            ({{ \Carbon\Carbon::parse($datos->inscripcion->alumno->persona->fecha_nacimiento)->age }}
                                            años)
                                        </small>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-user"></i> Nombre Completo
                                    </span>
                                    <span class="detail-value fw-bold">
                                        {{ $datos->inscripcion->alumno->persona->primer_nombre ?? '' }}
                                        {{ $datos->inscripcion->alumno->persona->segundo_nombre ?? '' }}
                                        {{ $datos->inscripcion->alumno->persona->primer_apellido ?? '' }}
                                        {{ $datos->inscripcion->alumno->persona->segundo_apellido ?? '' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-venus-mars"></i> Género
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->inscripcion->alumno->persona->genero->genero ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-weight"></i> Peso
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->inscripcion->alumno->peso ?? 'N/A' }} kg
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-ruler-vertical"></i> Estatura
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->inscripcion->alumno->estatura ?? 'N/A' }} m
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-hand-paper"></i> Lateralidad
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->inscripcion->alumno->lateralidad->lateralidad ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-sort-numeric-up"></i> Orden de Nacimiento
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->inscripcion->alumno->ordenNacimiento->orden_nacimiento ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-map-marker-alt"></i> Lugar de nacimiento
                                    </span>
                                    <span class="detail-value fw-bold">
                                        {{ $datos->inscripcion->alumno->persona->localidad->municipio->estado->nombre_estado ?? 'N/A' }}
                                        /
                                        {{ $datos->inscripcion->alumno->persona->localidad->municipio->nombre_municipio ?? 'N/A' }}
                                        /
                                        {{ $datos->inscripcion->alumno->persona->localidad->nombre_localidad ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            @if ($datos->inscripcion->alumno->discapacidades && $datos->inscripcion->alumno->discapacidades->count() > 0)
                                <div class="col-md-12 mt-3">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-wheelchair text-primary"></i> Discapacidades
                                        </span>
                                        <div class="d-flex flex-wrap gap-2 mt-1">
                                            @foreach ($datos->inscripcion->alumno->discapacidades as $discapacidad)
                                                <span class="badge bg-info">
                                                    • {{ $discapacidad->nombre_discapacidad }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- DIVISOR -->
                <hr class="my-4" style="border-top: 2px dashed #e5e7eb;">

                <!-- ======================
                    SECCIÓN 2: DATOS DE PROSECUCIÓN
                ======================= -->
                <div class="mb-4">
                    <div class="section-title">
                        <i class="fas fa-arrow-circle-up text-success"></i>
                        <span>Información de Prosecución</span>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body bg-light">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-layer-group"></i> Año Anterior
                                        </span>
                                        <span class="detail-value fw-bold">
                                            {{ $datos->inscripcion->grado->numero_grado ?? 'N/A' }} Año
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body bg-light">
                                    <div class="detail-item">
                                        <span class="detail-label ">
                                            <i class="fas fa-arrow-right"></i> Año de Promoción
                                        </span>
                                        <span class="detail-value fw-bold ">
                                            {{ $datos->grado->numero_grado ?? 'N/A' }} Año
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body {{ $datos->repite_grado ? 'bg-warning' : 'bg-success' }}">
                                    <div class="detail-item">
                                        <span class="detail-label text-dark">
                                            <i
                                                class="fas {{ $datos->repite_grado ? 'fa-redo' : 'fa-check-circle' }}"></i>
                                            Estado
                                        </span>
                                        <span class="detail-value fw-bold text-dark">
                                            {{ $datos->repite_grado ? 'Repite Grado' : 'Promovido' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        @if ($datos->seccion)
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-th-large"></i> Sección Asignada
                                    </span>
                                    <span class="detail-value">
                                        Sección {{ $datos->seccion->nombre }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-file-contract"></i> Aceptó Normas
                                </span>
                                <span class="detail-value">
                                    @if ($datos->acepta_normas_contrato)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> Sí
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times"></i> No
                                        </span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DIVISOR -->
                <hr class="my-4" style="border-top: 2px dashed #e5e7eb;">

                <!-- ======================
                    SECCIÓN 3: MATERIAS
                ======================= -->
                <div class="mb-4">
                    <div class="section-title">
                        <i class="fas fa-book text-info"></i>
                        <span>Estado de Materias</span>
                    </div>

                    @php
                        $prosecucionAreas = $datos->prosecucionAreas ?? collect();

                        $materiasAprobadas = $datos->prosecucionAreas->where('status', 'aprobada');
                        $materiasPendientes = $datos->prosecucionAreas->where('status', 'pendiente');
                    @endphp

                    <div class="row g-3 mt-2">
                        <!-- Materias Aprobadas -->
                        @if ($materiasAprobadas->count() > 0)
                            <div class="col-md-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-check-circle me-2"></i>
                                            Materias Aprobadas ({{ $materiasAprobadas->count() }})
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($materiasAprobadas as $materia)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <i class="fas fa-book-open text-success me-2"></i>
                                                        {{ $materia->gradoAreaFormacion->area_formacion->nombre_area_formacion ?? 'N/A' }}
                                                    </span>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Materias Pendientes -->
                        @if ($materiasPendientes->count() > 0)
                            <div class="col-md-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header bg-warning text-dark">
                                        <h6 class="mb-0">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            Materias Pendientes ({{ $materiasPendientes->count() }})
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($materiasPendientes as $materia)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <i class="fas fa-book text-warning me-2"></i>
                                                        {{ $materia->gradoAreaFormacion->area_formacion->nombre_area_formacion ?? 'N/A' }}
                                                    </span>
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-clock"></i>
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($materiasAprobadas->count() == 0 && $materiasPendientes->count() == 0)
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No hay información de materias registradas
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- DIVISOR -->
                <hr class="my-4" style="border-top: 2px dashed #e5e7eb;">

                <!-- ======================
                    SECCIÓN 4: REPRESENTANTES
                ======================= -->
                <div class="mb-4">
                    <div class="section-title">
                        <i class="fas fa-users text-info"></i>
                        <span>Representantes</span>
                    </div>

                    <div class="row g-3 mt-2">
                        <!-- PADRE -->
                        @if ($datos->inscripcion->padre)
                            <div class="col-md-6">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-male me-2"></i>Padre
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="detail-item mb-2">
                                            <span class="detail-label">Nombre</span>
                                            <span class="detail-value">
                                                {{ $datos->inscripcion->padre->persona->primer_nombre ?? '' }}
                                                {{ $datos->inscripcion->padre->persona->segundo_nombre ?? '' }}
                                                {{ $datos->inscripcion->padre->persona->primer_apellido ?? '' }}
                                                {{ $datos->inscripcion->padre->persona->segundo_apellido ?? '' }}
                                            </span>
                                        </div>
                                        <div class="detail-item mb-2">
                                            <span class="detail-label">Cédula</span>
                                            <span class="detail-value">
                                                {{ $datos->inscripcion->padre->persona->tipoDocumento->nombre ?? '' }}-{{ $datos->inscripcion->padre->persona->numero_documento ?? '' }}
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Teléfono</span>
                                            <span class="detail-value">
                                                {{ $datos->inscripcion->padre->persona->prefijoTelefono->prefijo ?? 'N/A' }}-{{ $datos->inscripcion->padre->persona->telefono ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- MADRE -->
                        @if ($datos->inscripcion->madre)
                            <div class="col-md-6">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-header bg-danger text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-female me-2"></i>Madre
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="detail-item mb-2">
                                            <span class="detail-label">Nombre</span>
                                            <span class="detail-value">
                                                {{ $datos->inscripcion->madre->persona->primer_nombre ?? '' }}
                                                {{ $datos->inscripcion->madre->persona->segundo_nombre ?? '' }}
                                                {{ $datos->inscripcion->madre->persona->primer_apellido ?? '' }}
                                                {{ $datos->inscripcion->madre->persona->segundo_apellido ?? '' }}
                                            </span>
                                        </div>
                                        <div class="detail-item mb-2">
                                            <span class="detail-label">Cédula</span>
                                            <span class="detail-value">
                                                {{ $datos->inscripcion->madre->persona->tipoDocumento->nombre ?? '' }}-{{ $datos->inscripcion->madre->persona->numero_documento ?? '' }}
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Teléfono</span>
                                            <span class="detail-value">
                                                {{ $datos->inscripcion->madre->persona->prefijoTelefono->prefijo ?? 'N/A' }}-{{ $datos->inscripcion->madre->persona->telefono ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- REPRESENTANTE LEGAL -->
                        @if ($datos->inscripcion->representanteLegal)
                            <div class="col-md-12">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header bg-warning text-dark">
                                        <h6 class="mb-0">
                                            <i class="fas fa-user-tie me-2"></i>Representante Legal
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-5">
                                                <div class="detail-item">
                                                    <span class="detail-label">Nombre</span>
                                                    <span class="detail-value">
                                                        {{ $datos->inscripcion->representanteLegal->representante->persona->primer_nombre ?? '' }}
                                                        {{ $datos->inscripcion->representanteLegal->representante->persona->segundo_nombre ?? '' }}
                                                        {{ $datos->inscripcion->representanteLegal->representante->persona->primer_apellido ?? '' }}
                                                        {{ $datos->inscripcion->representanteLegal->representante->persona->segundo_apellido ?? '' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="detail-item">
                                                    <span class="detail-label">Cédula</span>
                                                    <span class="detail-value">
                                                        {{ $datos->inscripcion->representanteLegal->representante->persona->tipoDocumento->nombre ?? '' }}-{{ $datos->inscripcion->representanteLegal->representante->persona->numero_documento ?? '' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="detail-item">
                                                    <span class="detail-label">Parentesco</span>
                                                    <span class="detail-value">
                                                        {{ $datos->inscripcion->representanteLegal->parentesco ?? 'N/A' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Si no hay representantes -->
                        @if (!$datos->inscripcion->padre && !$datos->inscripcion->madre && !$datos->inscripcion->representanteLegal)
                            <div class="col-12">
                                <div class="alert alert-warning text-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    No se han registrado representantes
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- DIVISOR -->
                <hr class="my-4" style="border-top: 2px dashed #e5e7eb;">

                <!-- ======================
                    SECCIÓN 5: OBSERVACIONES
                ======================= -->
                <div class="mb-3">
                    <div class="section-title">
                        <i class="fas fa-comment-dots text-secondary"></i>
                        <span>Observaciones</span>
                    </div>

                    <div class="card shadow-sm border-0 mt-2">
                        <div class="card-body bg-light">
                            @if ($datos->observaciones)
                                <p class="mb-0" style="white-space: pre-line;">{{ $datos->observaciones }}</p>
                            @else
                                <p class="text-muted mb-0 text-center">
                                    <i class="fas fa-info-circle me-2"></i>Sin observaciones registradas
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer modal-footer-view">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

<style>
    /* Badges de estado */
    .badge-status {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
        font-weight: 600;
    }

    .badge-activo {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .badge-inactivo {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .badge-pendiente {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    /* Mini cards */
    .mini-card {
        background: #f9fafb;
        border-radius: 12px;
    }

    /* Section title */
    .section-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .section-title i {
        font-size: 1.5rem;
    }

    /* Detail items */
    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .detail-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-value {
        font-size: 0.9375rem;
        color: #111827;
    }

    /* Modal modern styles */
    .modal-modern {
        border-radius: 1rem;
        overflow: hidden;
    }

    .modal-title-view {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .modal-body-view {
        padding: 2rem;
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    .modal-footer-view {
        border-top: 1px solid #e5e7eb;
        padding: 1rem 2rem;
        background: #f9fafb;
    }

    /* List group custom */
    .list-group-item {
        border: none;
        border-bottom: 1px solid #f3f4f6;
        padding: 0.75rem 1rem;
    }

    .list-group-item:last-child {
        border-bottom: none;
    }

    /* Card headers */
    .card-header {
        font-weight: 600;
        padding: 0.75rem 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .modal-xl {
            max-width: 95%;
        }

        .modal-body-view {
            padding: 1rem;
        }
    }
</style>
