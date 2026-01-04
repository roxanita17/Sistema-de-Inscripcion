<!-- Modal Ver Información de Prosecución - Histórico -->
<div class="modal fade" id="showModalProsecucion-{{ $datos->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content modal-modern shadow">

            <!-- HEADER -->
            <div class="modal-header modal-header-view">
                <div class="w-100 text-center">
                    <h5 class="modal-title-view mb-2">
                        <i class="fas fa-arrow-circle-up me-2"></i>
                        Inscripción por Prosecución
                    </h5>
                    <p class="mb-2" style="font-size: 0.95rem; opacity: 0.95;">
                        Año Escolar: 
                        {{ \Carbon\Carbon::parse($datos->anioEscolar->inicio_anio_escolar)->format('Y') }}
                        -
                        {{ \Carbon\Carbon::parse($datos->anioEscolar->cierre_anio_escolar)->format('Y') }}
                    </p>
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <span class="badge badge-status badge-{{ strtolower($datos->status) }}">
                            <i class="fas fa-circle-dot"></i>
                            {{ $datos->status }}
                        </span>
                        <span class="badge bg-white text-primary">
                            <i class="fas fa-graduation-cap"></i>
                            {{ $datos->grado->numero_grado ?? 'N/A' }}° Año
                        </span>
                        @if ($datos->seccion)
                            <span class="badge bg-white text-info">
                                <i class="fas fa-users"></i>
                                Sección {{ $datos->seccion->nombre }}
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
                    data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body modal-body-view">

                {{-- ========== DATOS DEL ESTUDIANTE ========== --}}
                <div class="mb-4">
                    <div class="section-title">
                        <i class="fas fa-user-graduate"></i>
                        <span>Información del Estudiante</span>
                    </div>
                    <div class="card mini-card shadow-sm border-0 p-3 mt-2">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-user"></i> Nombre Completo
                                    </span>
                                    <span class="detail-value fw-bold">
                                        {{ $datos->inscripcion->alumno->persona->primer_nombre ?? '' }}
                                        {{ $datos->inscripcion->alumno->persona->segundo_nombre ?? '' }}
                                        {{ $datos->inscripcion->alumno->persona->tercer_nombre ?? '' }}
                                        {{ $datos->inscripcion->alumno->persona->primer_apellido ?? '' }}
                                        {{ $datos->inscripcion->alumno->persona->segundo_apellido ?? '' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-id-card"></i> Cédula
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->inscripcion->alumno->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $datos->inscripcion->alumno->persona->numero_documento ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-calendar-alt"></i> Fecha de Nacimiento
                                    </span>
                                    <span class="detail-value">
                                        {{ \Carbon\Carbon::parse($datos->inscripcion->alumno->persona->fecha_nacimiento)->format('d/m/Y') ?? 'N/A' }}
                                        <small class="text-muted">
                                            ({{ \Carbon\Carbon::parse($datos->inscripcion->alumno->persona->fecha_nacimiento)->age }} años)
                                        </small>
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

                            <div class="col-md-12">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-map-marker-alt"></i> Lugar de Nacimiento
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->inscripcion->alumno->persona->localidad->municipio->estado->nombre_estado ?? 'N/A' }}
                                        / {{ $datos->inscripcion->alumno->persona->localidad->municipio->nombre_municipio ?? 'N/A' }}
                                        / {{ $datos->inscripcion->alumno->persona->localidad->nombre_localidad ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-weight"></i> Peso
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->inscripcion->alumno->peso ?? 'N/A' }} kg
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-ruler-vertical"></i> Estatura
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->inscripcion->alumno->estatura ?? 'N/A' }} cm
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-hand-paper"></i> Lateralidad
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->inscripcion->alumno->lateralidad->lateralidad ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-sort-numeric-up"></i> Orden de Nacimiento
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->inscripcion->alumno->ordenNacimiento->orden_nacimiento ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-shoe-prints"></i> Talla Zapato
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->inscripcion->alumno->talla_zapato ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-tshirt"></i> Talla Camisa
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->inscripcion->alumno->tallaCamisa->nombre ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-ruler"></i> Talla Pantalón
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->inscripcion->alumno->tallaPantalon->nombre ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            @if ($datos->inscripcion->alumno->etniaIndigena)
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-feather"></i> Etnia Indígena
                                        </span>
                                        <span class="detail-value">
                                            {{ $datos->inscripcion->alumno->etniaIndigena->nombre ?? 'Ninguna registrada' }}
                                        </span>
                                    </div>
                                </div>
                            @endif

                            @if ($datos->inscripcion->alumno->discapacidades && $datos->inscripcion->alumno->discapacidades->count() > 0)
                                <div class="col-md-6">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-wheelchair"></i> Discapacidades
                                        </span>
                                        <span class="detail-value">
                                            @foreach ($datos->inscripcion->alumno->discapacidades as $discapacidad)
                                                • {{ $discapacidad->nombre_discapacidad }}<br>
                                            @endforeach
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- DIVISOR -->
                <hr class="my-4" style="border-top: 2px dashed #e5e7eb;">

                {{-- ========== DATOS DE PROSECUCIÓN ========== --}}
                <div class="mb-4">
                    <div class="section-title">
                        <i class="fas fa-arrow-circle-up text-success"></i>
                        <span>Información de Prosecución</span>
                    </div>

                    <div class="row g-3 mt-2">
                        <div class="col-md-3">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body text-center" style="background: linear-gradient(135deg, #e0e7ff, #c7d2fe);">
                                    <div class="detail-item">
                                        <span class="detail-label text-primary">
                                            <i class="fas fa-layer-group"></i> Año Anterior
                                        </span>
                                        <span class="detail-value fw-bold text-primary" style="font-size: 1.25rem;">
                                            {{ $datos->inscripcion->grado->numero_grado ?? 'N/A' }}° Año
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body text-center" style="background: linear-gradient(135deg, #dbeafe, #bfdbfe);">
                                    <div class="detail-item">
                                        <span class="detail-label text-info">
                                            <i class="fas fa-arrow-right"></i> Año de Promoción
                                        </span>
                                        <span class="detail-value fw-bold text-info" style="font-size: 1.25rem;">
                                            {{ $datos->grado->numero_grado ?? 'N/A' }}° Año
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body text-center" style="background: {{ $datos->repite_grado ? 'linear-gradient(135deg, #fef3c7, #fde68a)' : 'linear-gradient(135deg, #d1fae5, #a7f3d0)' }};">
                                    <div class="detail-item">
                                        <span class="detail-label" style="color: {{ $datos->repite_grado ? '#92400e' : '#065f46' }};">
                                            <i class="fas {{ $datos->repite_grado ? 'fa-redo' : 'fa-check-circle' }}"></i> Estado
                                        </span>
                                        <span class="detail-value fw-bold" style="color: {{ $datos->repite_grado ? '#92400e' : '#065f46' }}; font-size: 1.1rem;">
                                            {{ $datos->repite_grado ? 'Repite Grado' : 'Promovido' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($datos->seccion)
                            <div class="col-md-3">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body text-center" style="background: linear-gradient(135deg, #f3e8ff, #e9d5ff);">
                                        <div class="detail-item">
                                            <span class="detail-label text-purple">
                                                <i class="fas fa-th-large"></i> Sección Asignada
                                            </span>
                                            <span class="detail-value fw-bold" style="font-size: 1.25rem;">
                                                {{ $datos->seccion->nombre }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-md-4">
                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-calendar"></i> Fecha de Inscripción
                                </span>
                                <span class="detail-value">
                                    {{ \Carbon\Carbon::parse($datos->created_at)->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-4">
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

                {{-- ========== ESTADO DE MATERIAS ========== --}}
                <div class="mb-4">
                    <div class="section-title">
                        <i class="fas fa-book text-info"></i>
                        <span>Estado de Materias</span>
                    </div>

                    @php
                        $materiasAprobadas = $datos->prosecucionAreas->where('status', 'aprobada');
                        $materiasPendientes = $datos->prosecucionAreas->where('status', 'pendiente');
                    @endphp

                    <div class="row g-3 mt-2">
                        @if ($materiasAprobadas->count() > 0)
                            <div class="col-md-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">
                                            <i class="fas fa-check-circle me-2"></i>
                                            Materias Aprobadas ({{ $materiasAprobadas->count() }})
                                        </h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($materiasAprobadas as $materia)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <i class="fas fa-book-open text-success me-2"></i>
                                                        {{ $materia->gradoAreaFormacion->areaFormacion->nombre_area_formacion ?? 'N/A' }}
                                                    </span>
                                                    <div>
                                                        <span class="badge bg-success me-2">
                                                            {{ $materia->gradoAreaFormacion->codigo ?? 'N/A' }}
                                                        </span>
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check"></i>
                                                        </span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($materiasPendientes->count() > 0)
                            <div class="col-md-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-header bg-warning text-dark">
                                        <h6 class="mb-0">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            Materias Pendientes ({{ $materiasPendientes->count() }})
                                        </h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($materiasPendientes as $materia)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <i class="fas fa-book text-warning me-2"></i>
                                                        {{ $materia->gradoAreaFormacion->areaFormacion->nombre_area_formacion ?? 'N/A' }}
                                                    </span>
                                                    <div>
                                                        <span class="badge bg-warning text-dark me-2">
                                                            {{ $materia->gradoAreaFormacion->codigo ?? 'N/A' }}
                                                        </span>
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-clock"></i>
                                                        </span>
                                                    </div>
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

                {{-- ========== REPRESENTANTES ========== --}}
                <div class="mb-4">
                    <div class="section-title">
                        <i class="fas fa-users"></i>
                        <span>Representantes</span>
                    </div>

                    <div class="row g-3 mt-2">
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
                                                {{ $datos->inscripcion->padre->persona->telefono_completo ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

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
                                                {{ $datos->inscripcion->madre->persona->telefono_completo ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

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
                                            <div class="col-md-4">
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
                                            <div class="col-md-2">
                                                <div class="detail-item">
                                                    <span class="detail-label">Parentesco</span>
                                                    <span class="detail-value">
                                                        {{ $datos->inscripcion->representanteLegal->parentesco ?? 'N/A' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="detail-item">
                                                    <span class="detail-label">Teléfono</span>
                                                    <span class="detail-value">
                                                        {{ $datos->inscripcion->representanteLegal->representante->persona->telefono_completo ?? 'N/A' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!$datos->inscripcion->padre && !$datos->inscripcion->madre && !$datos->inscripcion->representanteLegal)
                            <div class="col-12">
                                <div class="alert alert-warning text-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    No se han registrado representantes para este estudiante
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- DIVISOR -->
                <hr class="my-4" style="border-top: 2px dashed #e5e7eb;">

                {{-- ========== OBSERVACIONES ========== --}}
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