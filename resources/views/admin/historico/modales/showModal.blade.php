@php
    $esPrimerGrado = ((int) ($datos->grado->numero_grado ?? 0)) === 1;
@endphp

<div class="modal fade" id="viewModal{{ $datos->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content modal-modern shadow">
            
            {{-- HEADER --}}
            <div class="modal-header modal-header-view">
                <div class="w-100 text-center">
                    <h5 class="modal-title-view mb-2">
                        <i class="fas fa-star me-2"></i>
                        Inscripción - Nuevo Ingreso
                    </h5>
                    <div class="d-flex justify-content-center gap-2 mt-2">
                        <span class="badge-modal badge-modal-success">
                            <i class="fas fa-check-circle"></i>
                            {{ $datos->status }}
                        </span>
                        <span class="badge-modal badge-modal-primary">
                            <i class="fas fa-graduation-cap"></i>
                            {{ $datos->grado->numero_grado }}° Año
                        </span>
                        <span class="badge-modal badge-modal-info">
                            <i class="fas fa-calendar"></i>
                            {{ \Carbon\Carbon::parse($datos->created_at)->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" 
                        data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body modal-body-view p-4">

                {{-- ========== AÑO ESCOLAR ========== --}}
                <div class="section-card mb-3">
                    <div class="section-card-header">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Año Escolar</span>
                    </div>
                    <div class="section-card-body">
                        <div class="data-grid">
                            <div class="data-item">
                                <span class="data-label">Período:</span>
                                <span class="data-value">
                                    {{ \Carbon\Carbon::parse($datos->anioEscolar->inicio_anio_escolar)->format('d/m/Y') }}
                                    <i class="fas fa-arrow-right mx-2 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($datos->anioEscolar->cierre_anio_escolar)->format('d/m/Y') }}
                                </span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">Estado:</span>
                                <span class="data-value">
                                    <span class="badge-inline badge-{{ $datos->anioEscolar->status === 'Activo' ? 'success' : 'warning' }}">
                                        {{ $datos->anioEscolar->status }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ========== DATOS DEL ESTUDIANTE ========== --}}
                <div class="section-card mb-3">
                    <div class="section-card-header">
                        <i class="fas fa-user-graduate"></i>
                        <span>Información del Estudiante</span>
                    </div>
                    <div class="section-card-body">
                        <div class="data-grid">
                            <div class="data-item">
                                <span class="data-label">Nombre Completo:</span>
                                <span class="data-value highlight">
                                    {{ $datos->alumno->persona->primer_nombre }}
                                    {{ $datos->alumno->persona->segundo_nombre }}
                                    {{ $datos->alumno->persona->tercer_nombre }}
                                    {{ $datos->alumno->persona->primer_apellido }}
                                    {{ $datos->alumno->persona->segundo_apellido }}
                                </span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">Tipo y Número de Documento:</span>
                                <span class="data-value">
                                    {{ $datos->alumno->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $datos->alumno->persona->numero_documento }}
                                </span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">Fecha de Nacimiento:</span>
                                <span class="data-value">
                                    {{ \Carbon\Carbon::parse($datos->alumno->persona->fecha_nacimiento)->format('d/m/Y') }}
                                    <small class="text-muted">
                                        ({{ \Carbon\Carbon::parse($datos->alumno->persona->fecha_nacimiento)->age }} años)
                                    </small>
                                </span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">Género:</span>
                                <span class="data-value">{{ $datos->alumno->persona->genero->genero ?? 'N/A' }}</span>
                            </div>
                            @if($datos->alumno->persona->lugar_nacimiento)
                                <div class="data-item">
                                    <span class="data-label">Lugar de Nacimiento:</span>
                                    <span class="data-value">{{ $datos->alumno->persona->lugar_nacimiento }}</span>
                                </div>
                            @endif
                            @if($datos->alumno->persona->nacionalidad)
                                <div class="data-item">
                                    <span class="data-label">Nacionalidad:</span>
                                    <span class="data-value">{{ $datos->alumno->persona->nacionalidad }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Datos Adicionales del Alumno --}}
                        <div class="subsection-divider">
                            <span>Datos Complementarios</span>
                        </div>
                        <div class="data-grid">
                            @if($datos->alumno->lateralidad)
                                <div class="data-item">
                                    <span class="data-label">Lateralidad:</span>
                                    <span class="data-value">{{ $datos->alumno->lateralidad->nombre ?? 'N/A' }}</span>
                                </div>
                            @endif
                            @if($datos->alumno->ordenNacimiento)
                                <div class="data-item">
                                    <span class="data-label">Orden de Nacimiento:</span>
                                    <span class="data-value">{{ $datos->alumno->ordenNacimiento->nombre ?? 'N/A' }}</span>
                                </div>
                            @endif
                            @if($datos->alumno->talla_camisa)
                                <div class="data-item">
                                    <span class="data-label">Talla de Camisa:</span>
                                    <span class="data-value">{{ $datos->alumno->talla_camisa }}</span>
                                </div>
                            @endif
                            @if($datos->alumno->talla_pantalon)
                                <div class="data-item">
                                    <span class="data-label">Talla de Pantalón:</span>
                                    <span class="data-value">{{ $datos->alumno->talla_pantalon }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ========== DATOS DE INSCRIPCIÓN ========== --}}
                <div class="section-card mb-3">
                    <div class="section-card-header">
                        <i class="fas fa-file-signature"></i>
                        <span>Datos de la Inscripción</span>
                    </div>
                    <div class="section-card-body">
                        <div class="data-grid">
                            <div class="data-item">
                                <span class="data-label">Grado Inscrito:</span>
                                <span class="data-value">
                                    <span class="badge-inline badge-primary">
                                        {{ $datos->grado->numero_grado }}° Año
                                    </span>
                                </span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">Sección Asignada:</span>
                                <span class="data-value">
                                    <span class="badge-inline badge-info">
                                        Sección {{ $datos->seccionAsignada->nombre ?? 'Sin asignar' }}
                                    </span>
                                </span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">Fecha de Inscripción:</span>
                                <span class="data-value">
                                    {{ \Carbon\Carbon::parse($datos->created_at)->format('d/m/Y H:i') }}
                                </span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">Acepta Normas:</span>
                                <span class="data-value">
                                    <span class="badge-inline badge-{{ $datos->acepta_normas_contrato ? 'success' : 'danger' }}">
                                        {{ $datos->acepta_normas_contrato ? 'Sí' : 'No' }}
                                    </span>
                                </span>
                            </div>
                        </div>
                        
                        @if($datos->observaciones)
                            <div class="subsection-divider">
                                <span>Observaciones</span>
                            </div>
                            <div class="observaciones-box">
                                {{ $datos->observaciones }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ========== DATOS DE NUEVO INGRESO ========== --}}
                <div class="section-card mb-3">
                    <div class="section-card-header">
                        <i class="fas fa-school"></i>
                        <span>Información de Nuevo Ingreso</span>
                    </div>
                    <div class="section-card-body">
                        <div class="data-grid">
                            <div class="data-item">
                                <span class="data-label">Institución de Procedencia:</span>
                                <span class="data-value">
                                    {{ $datos->nuevoIngreso->institucionProcedencia->nombre ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="data-item">
                                <span class="data-label">Año de Egreso:</span>
                                <span class="data-value">{{ $datos->nuevoIngreso->anio_egreso ?? 'N/A' }}</span>
                            </div>
                            @if($datos->nuevoIngreso->expresionLiteraria)
                                <div class="data-item">
                                    <span class="data-label">Expresión Literaria:</span>
                                    <span class="data-value">
                                        {{ $datos->nuevoIngreso->expresionLiteraria->nombre ?? 'N/A' }}
                                    </span>
                                </div>
                            @endif
                            @if($datos->nuevoIngreso->numero_zonificacion)
                                <div class="data-item">
                                    <span class="data-label">Número de Zonificación:</span>
                                    <span class="data-value">{{ $datos->nuevoIngreso->numero_zonificacion }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ========== REPRESENTANTES ========== --}}
                <div class="section-card mb-3">
                    <div class="section-card-header">
                        <i class="fas fa-users"></i>
                        <span>Representantes</span>
                    </div>
                    <div class="section-card-body p-0">
                        
                        {{-- PADRE --}}
                        @if($datos->padre)
                            <div class="representante-item">
                                <div class="representante-badge-container">
                                    <span class="representante-badge representante-padre">
                                        <i class="fas fa-user"></i>
                                        PADRE
                                    </span>
                                </div>
                                <div class="representante-content">
                                    <div class="data-grid-2">
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Documento:</span>
                                            <span class="data-value-sm">
                                                {{ $datos->padre->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $datos->padre->persona->numero_documento }}
                                            </span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Nombre:</span>
                                            <span class="data-value-sm">
                                                {{ $datos->padre->persona->primer_nombre }}
                                                {{ $datos->padre->persona->segundo_nombre }}
                                                {{ $datos->padre->persona->primer_apellido }}
                                                {{ $datos->padre->persona->segundo_apellido }}
                                            </span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Teléfono:</span>
                                            <span class="data-value-sm">{{ $datos->padre->persona->telefono ?? 'N/A' }}</span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Ocupación:</span>
                                            <span class="data-value-sm">{{ $datos->padre->ocupacion->nombre_ocupacion ?? 'N/A' }}</span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Dirección:</span>
                                            <span class="data-value-sm">
                                                {{ $datos->padre->estado->nombre_estado ?? 'N/A' }},
                                                {{ $datos->padre->municipios->nombre_municipio ?? 'N/A' }},
                                                {{ $datos->padre->localidads->nombre_localidad ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Convive:</span>
                                            <span class="badge-inline badge-{{ $datos->padre->convivenciaestudiante_representante ? 'success' : 'danger' }}">
                                                {{ $datos->padre->convivenciaestudiante_representante ? 'Sí' : 'No' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- MADRE --}}
                        @if($datos->madre)
                            <div class="representante-item">
                                <div class="representante-badge-container">
                                    <span class="representante-badge representante-madre">
                                        <i class="fas fa-user"></i>
                                        MADRE
                                    </span>
                                </div>
                                <div class="representante-content">
                                    <div class="data-grid-2">
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Documento:</span>
                                            <span class="data-value-sm">
                                                {{ $datos->madre->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $datos->madre->persona->numero_documento }}
                                            </span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Nombre:</span>
                                            <span class="data-value-sm">
                                                {{ $datos->madre->persona->primer_nombre }}
                                                {{ $datos->madre->persona->segundo_nombre }}
                                                {{ $datos->madre->persona->primer_apellido }}
                                                {{ $datos->madre->persona->segundo_apellido }}
                                            </span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Teléfono:</span>
                                            <span class="data-value-sm">{{ $datos->madre->persona->telefono ?? 'N/A' }}</span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Ocupación:</span>
                                            <span class="data-value-sm">{{ $datos->madre->ocupacion->nombre_ocupacion ?? 'N/A' }}</span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Dirección:</span>
                                            <span class="data-value-sm">
                                                {{ $datos->madre->estado->nombre_estado ?? 'N/A' }},
                                                {{ $datos->madre->municipios->nombre_municipio ?? 'N/A' }},
                                                {{ $datos->madre->localidads->nombre_localidad ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Convive:</span>
                                            <span class="badge-inline badge-{{ $datos->madre->convivenciaestudiante_representante ? 'success' : 'danger' }}">
                                                {{ $datos->madre->convivenciaestudiante_representante ? 'Sí' : 'No' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- REPRESENTANTE LEGAL --}}
                        @if($datos->representanteLegal)
                            <div class="representante-item">
                                <div class="representante-badge-container">
                                    <span class="representante-badge representante-legal">
                                        <i class="fas fa-gavel"></i>
                                        REPRESENTANTE LEGAL
                                    </span>
                                </div>
                                <div class="representante-content">
                                    <div class="data-grid-2">
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Documento:</span>
                                            <span class="data-value-sm">
                                                {{ $datos->representanteLegal->representante->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $datos->representanteLegal->representante->persona->numero_documento }}
                                            </span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Nombre:</span>
                                            <span class="data-value-sm">
                                                {{ $datos->representanteLegal->representante->persona->primer_nombre }}
                                                {{ $datos->representanteLegal->representante->persona->segundo_nombre }}
                                                {{ $datos->representanteLegal->representante->persona->primer_apellido }}
                                                {{ $datos->representanteLegal->representante->persona->segundo_apellido }}
                                            </span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Parentesco:</span>
                                            <span class="data-value-sm">{{ $datos->representanteLegal->parentesco ?? 'N/A' }}</span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Correo:</span>
                                            <span class="data-value-sm">{{ $datos->representanteLegal->correo_representante ?? 'N/A' }}</span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Teléfono:</span>
                                            <span class="data-value-sm">{{ $datos->representanteLegal->representante->persona->telefono ?? 'N/A' }}</span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Ocupación:</span>
                                            <span class="data-value-sm">{{ $datos->representanteLegal->representante->ocupacion->nombre_ocupacion ?? 'N/A' }}</span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Dirección:</span>
                                            <span class="data-value-sm">
                                                {{ $datos->representanteLegal->representante->persona->estado->nombre_estado ?? 'N/A' }},
                                                {{ $datos->representanteLegal->representante->persona->municipios->nombre_municipio ?? 'N/A' }},
                                                {{ $datos->representanteLegal->representante->persona->localidads->nombre_localidad ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="data-item-compact">
                                            <span class="data-label-sm">Convive:</span>
                                            <span class="badge-inline badge-{{ $datos->representanteLegal->representante->convivenciaestudiante_representante ? 'success' : 'danger' }}">
                                                {{ $datos->representanteLegal->representante->convivenciaestudiante_representante ? 'Sí' : 'No' }}
                                            </span>
                                        </div>
                                        @if($datos->representanteLegal->banco)
                                            <div class="data-item-compact">
                                                <span class="data-label-sm">Banco:</span>
                                                <span class="data-value-sm">{{ $datos->representanteLegal->banco->nombre_banco }}</span>
                                            </div>
                                        @endif
                                        @if($datos->representanteLegal->tipo_cuenta)
                                            <div class="data-item-compact">
                                                <span class="data-label-sm">Tipo Cuenta:</span>
                                                <span class="data-value-sm">{{ $datos->representanteLegal->tipo_cuenta }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- ========== DOCUMENTOS ========== --}}
                @if($datos->documentos)
                    <div class="section-card mb-3">
                        <div class="section-card-header">
                            <i class="fas fa-file-alt"></i>
                            <span>Documentos</span>
                        </div>
                        <div class="section-card-body">
                            <div class="data-item">
                                <span class="data-label">Estado de Documentos:</span>
                                <span class="data-value">
                                    <span class="badge-inline badge-{{ $datos->estado_documentos === 'Completo' ? 'success' : 'warning' }}">
                                        {{ $datos->estado_documentos ?? 'Pendiente' }}
                                    </span>
                                </span>
                            </div>
                            <div class="subsection-divider">
                                <span>Archivos Adjuntos</span>
                            </div>
                            <ul class="documentos-list">
                                @foreach($datos->documentos as $doc)
                                    <li>
                                        <i class="fas fa-file-pdf text-danger"></i>
                                        {{ $doc }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer modal-footer-view">
                <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cerrar
                </button>
            </div>

        </div>
    </div>
</div>

<style>
/* ========== MODAL BASE ========== */
.modal-modern .modal-content {
    border: none;
    border-radius: 12px;
}

.modal-header-view {
    background: linear-gradient(135deg, #4f46e5, #4338ca);
    color: white;
    padding: 1.5rem;
    border-radius: 12px 12px 0 0;
    position: relative;
}

.modal-title-view {
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
}

.modal-body-view {
    background: #f9fafb;
    max-height: 70vh;
    overflow-y: auto;
}

.modal-footer-view {
    background: white;
    padding: 1rem 1.5rem;
    border-top: 1px solid #e5e7eb;
}

/* ========== BADGES EN HEADER ========== */
.badge-modal {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.85rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.badge-modal-success {
    background: rgba(16, 185, 129, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.badge-modal-primary {
    background: rgba(59, 130, 246, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.badge-modal-info {
    background: rgba(236, 72, 153, 0.2);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* ========== SECTION CARDS ========== */
.section-card {
    background: white;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.section-card-header {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.85rem 1.25rem;
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    border-bottom: 2px solid #4f46e5;
    font-weight: 700;
    font-size: 0.95rem;
    color: #111827;
}

.section-card-header i {
    color: #4f46e5;
    font-size: 1.1rem;
}

.section-card-body {
    padding: 1.25rem;
}

/* ========== DATA GRID ========== */
.data-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1rem;
}

.data-grid-2 {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 0.75rem;
}

.data-item {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.data-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.data-value {
    font-size: 0.9rem;
    color: #111827;
    font-weight: 500;
    line-height: 1.4;
}

.data-value.highlight {
    font-weight: 700;
    color: #4f46e5;
    font-size: 1rem;
}

/* ========== DATA ITEMS COMPACTOS ========== */
.data-item-compact {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.data-label-sm {
    font-size: 0.7rem;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
}

.data-value-sm {
    font-size: 0.82rem;
    color: #111827;
    font-weight: 500;
}

/* ========== BADGES INLINE ========== */
.badge-inline {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.7rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.badge-success {
    background: #d1fae5;
    color: #065f46;
}

.badge-danger {
    background: #fee2e2;
    color: #991b1b;
}

.badge-primary {
    background: #dbeafe;
    color: #1e40af;
}

.badge-info {
    background: #e0e7ff;
    color: #4338ca;
}

.badge-warning {
    background: #fef3c7;
    color: #92400e;
}

/* ========== SUBSECTION DIVIDER ========== */
.subsection-divider {
    display: flex;
    align-items: center;
    margin: 1.25rem 0 0.75rem 0;
    padding-top: 1rem;
    border-top: 1px dashed #d1d5db;
}

.subsection-divider span {
    font-size: 0.85rem;
    font-weight: 600;
    color: #4b5563;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* ========== OBSERVACIONES BOX ========== */
.observaciones-box {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 1rem;
    font-size: 0.85rem;
    color: #374151;
    line-height: 1.5;
}

/* ========== REPRESENTANTES ========== */
.representante-item {
    border-bottom: 1px solid #e5e7eb;
    padding: 1rem 1.25rem;
}

.representante-item:last-child {
    border-bottom: none;
}

.representante-badge-container {
    display: flex;
    justify-content: center;
    margin-bottom: 1rem;
}

.representante-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.45rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.representante-padre {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
    border: 2px solid #93c5fd;
}

.representante-madre {
    background: linear-gradient(135deg, #fce7f3, #fbcfe8);
    color: #9f1239;
    border: 2px solid #f9a8d4;
}

.representante-legal {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
    border: 2px solid #6ee7b7;
}

.representante-content {
    background: #f9fafb;
    border-radius: 8px;
    padding: 1rem;
}

/* ========== DOCUMENTOS LIST ========== */
.documentos-list {
    list-style: none;
    padding: 0;
    margin: 0.75rem 0 0 0;
}

.documentos-list li {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.6rem 0.85rem;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    margin-bottom: 0.5rem;
    font-size: 0.82rem;
    color: #374151;
}

.documentos-list li:last-child {
    margin-bottom: 0;
}

.documentos-list li i {
    font-size: 1rem;
}

/* ========== BOTONES ========== */
.btn-modal-secondary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.25rem;
    background: #f3f4f6;
    color: #374151;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-modal-secondary:hover {
    background: #e5e7eb;
    transform: translateY(-1px);
}

/* ========== RESPONSIVE ========== */
@media (max-width: 768px) {
    .modal-xl {
        max-width: 95%;
    }
    
    .data-grid,
    .data-grid-2 {
        grid-template-columns: 1fr;
    }
    
    .section-card-body {
        padding: 1rem;
    }
}

/* ========== SCROLLBAR PERSONALIZADA ========== */
.modal-body-view::-webkit-scrollbar {
    width: 8px;
}

.modal-body-view::-webkit-scrollbar-track {
    background: #f3f4f6;
}

.modal-body-view::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 4px;
}

.modal-body-view::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}