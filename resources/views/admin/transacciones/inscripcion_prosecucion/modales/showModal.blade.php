<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@php
    $esPrimerGrado = ((int) ($datos->grado->numero_grado ?? 0)) === 1;
@endphp


<!-- Modal Ver Información de la Inscripción -->
<div class="modal fade" id="viewModal{{ $datos->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $datos->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content modal-modern shadow">

            <!-- HEADER -->
            <div class="modal-header modal-header-view">
                <div class="w-100 text-center">
                    @if ($datos->tipo_inscripcion === 'nuevo_ingreso')
                        <h5 class="modal-title-view mb-2">Información de la Inscripción</h5>
                        <p><b>Nuevo Ingreso</b></p>
                    @else
                        <h5 class="modal-title-view mb-2">Información de la Inscripción</h5>
                        <p><b>Prosecucion</b></p>
                    @endif

                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge badge-status badge-{{ strtolower($datos->status) }}">
                            {{ $datos->status }}
                        </span>
                        <span class="badge bg-white text-primary">
                            <i class="fas fa-graduation-cap"></i> {{ $datos->grado->numero_grado ?? 'N/A' }}
                        </span>
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
                                        <i class="fas fa-id-card"></i> Cedula
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->alumno->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $datos->alumno->persona->numero_documento ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-calendar-alt"></i> Fecha de Nacimiento
                                    </span>
                                    <span class="detail-value">
                                        {{ \Carbon\Carbon::parse($datos->alumno->persona->fecha_nacimiento)->format('d/m/Y') ?? 'N/A' }}
                                        <small
                                            class="text-muted">({{ \Carbon\Carbon::parse($datos->alumno->persona->fecha_nacimiento)->age }}
                                            años)</small>
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-user"></i> Nombre Completo
                                    </span>
                                    <span class="detail-value fw-bold">
                                        {{ $datos->alumno->persona->primer_nombre ?? '' }}
                                        {{ $datos->alumno->persona->segundo_nombre ?? '' }}
                                        {{ $datos->alumno->persona->primer_apellido ?? '' }}
                                        {{ $datos->alumno->persona->segundo_apellido ?? '' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-venus-mars"></i> Género
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->alumno->persona->genero->genero ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-weight"></i> Peso
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->alumno->peso ?? 'N/A' }} kg
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-ruler-vertical"></i> Estatura
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->alumno->estatura ?? 'N/A' }} cm
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-hand-paper"></i> Lateralidad
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->alumno->lateralidad->lateralidad ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-sort-numeric-up"></i> Orden de Nacimiento
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->alumno->ordenNacimiento->orden_nacimiento ?? 'N/A' }}
                                    </span>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-user"></i>Lugar de nacimiento
                                    </span>
                                    <span class="detail-value fw-bold">
                                        {{ $datos->alumno->persona->localidad->municipio->estado->nombre_estado ?? 'N/A' }}
                                        /
                                        {{ $datos->alumno->persona->localidad->municipio->nombre_municipio ?? 'N/A' }}
                                        /
                                        {{ $datos->alumno->persona->localidad->nombre_localidad ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fa-solid fa-text-height"></i> Talla Zapato
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->alumno->talla_zapato ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fa-solid fa-text-height"></i> Talla Camisa
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->alumno->tallaCamisa->nombre ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fa-solid fa-text-height"></i>Talla Pantalones
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->alumno->tallaPantalon->nombre ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                            @if ($datos->alumno->etniaIndigena)
                                <div class="col-md-6 mt-3">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-feather text-primary"></i> Etnia Indígena
                                        </span>

                                        @if ($datos->alumno->etniaIndigena->count() > 0)
                                            <div class="d-flex flex-wrap gap-2 mt-1">
                                                {{ $datos->alumno->etniaIndigena->nombre }}
                                            </div>
                                        @else
                                            <span class="detail-value text-muted">
                                                Ninguna registrada
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if ($datos->alumno->discapacidades)
                                <div class="col-md-6 mt-3">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-wheelchair text-primary"></i> Discapacidades
                                        </span>

                                        @if ($datos->alumno->discapacidades->count() > 0)
                                            <div class="d-flex flex-wrap gap-2 mt-1">
                                                @foreach ($datos->alumno->discapacidades as $discapacidad)
                                                        • {{ $discapacidad->nombre_discapacidad }} <br>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="detail-value text-muted">
                                                Ninguna registrada
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- DIVISOR -->
                    <hr class="my-4" style="border-top: 2px dashed #e5e7eb;">

                    <!-- ======================
                    SECCIÓN 2: REPRESENTANTES
                ======================= -->
                    <div class="mb-4">
                        <div class="section-title">
                            <i class="fas fa-users text-info"></i>
                            <span>Representantes</span>
                        </div>

                        <div class="row g-3 mt-2">
                            <!-- PADRE -->
                            @if ($datos->padre)
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
                                                    {{ $datos->padre->persona->primer_nombre ?? '' }}
                                                    {{ $datos->padre->persona->segundo_nombre ?? '' }}
                                                    {{ $datos->padre->persona->primer_apellido ?? '' }}
                                                    {{ $datos->padre->persona->segundo_apellido ?? '' }}
                                                </span>
                                            </div>
                                            <div class="detail-item mb-2">
                                                <span class="detail-label">Cédula</span>
                                                <span class="detail-value">
                                                    {{ $datos->padre->persona->tipoDocumento->nombre ?? '' }}-{{ $datos->padre->persona->numero_documento ?? '' }}
                                                </span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">Numero Telefonico</span>
                                                <span class="detail-value">
                                                    {{ $datos->padre->persona->prefijoTelefono->prefijo ?? 'N/A' }}-{{ $datos->padre->persona->telefono ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- MADRE -->
                            @if ($datos->madre)
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
                                                    {{ $datos->madre->persona->primer_nombre ?? '' }}
                                                    {{ $datos->madre->persona->segundo_nombre ?? '' }}
                                                    {{ $datos->madre->persona->primer_apellido ?? '' }}
                                                    {{ $datos->madre->persona->segundo_apellido ?? '' }}
                                                </span>
                                            </div>
                                            <div class="detail-item mb-2">
                                                <span class="detail-label">Cédula</span>
                                                <span class="detail-value">
                                                    {{ $datos->madre->persona->tipoDocumento->nombre ?? '' }}-{{ $datos->madre->persona->numero_documento ?? '' }}
                                                </span>
                                            </div>
                                            <div class="detail-item">
                                                <span class="detail-label">Numero Telefonico</span>
                                                <span class="detail-value">
                                                    {{ $datos->madre->persona->prefijoTelefono->prefijo ?? 'N/A' }}-{{ $datos->madre->persona->telefono ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- REPRESENTANTE LEGAL -->
                            @if ($datos->representanteLegal)
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
                                                            {{ $datos->representanteLegal->representante->persona->primer_nombre ?? '' }}
                                                            {{ $datos->representanteLegal->representante->persona->segundo_nombre ?? '' }}
                                                            {{ $datos->representanteLegal->representante->persona->primer_apellido ?? '' }}
                                                            {{ $datos->representanteLegal->representante->persona->segundo_apellido ?? '' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="detail-item">
                                                        <span class="detail-label">Cédula</span>
                                                        <span class="detail-value">
                                                            {{ $datos->representanteLegal->representante->persona->tipoDocumento->nombre ?? '' }}-{{ $datos->representanteLegal->representante->persona->numero_documento ?? '' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="detail-item">
                                                        <span class="detail-label">Parentesco</span>
                                                        <span class="detail-value">
                                                            {{ $datos->representanteLegal->parentesco ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="detail-item">
                                                        <span class="detail-label">Numero telefonico</span>
                                                        <span class="detail-value">
                                                            {{ $datos->representanteLegal->representante->persona->prefijoTelefono->prefijo ?? 'N/A' }}-{{ $datos->representanteLegal->representante->persona->telefono ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Si no hay representantes -->
                            @if (!$datos->padre && !$datos->madre && !$datos->representanteLegal)
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

                    <!-- ======================
                    SECCIÓN 3: DATOS DE INSCRIPCIÓN
                ======================= -->
                    <div class="mb-4">
                        <div class="section-title">
                            <i class="fas fa-file-signature text-success"></i>
                            <span>Datos de Inscripción</span>
                        </div>

                        <div class="row g-3 mt-2">
                            @if ($esPrimerGrado)
                                <div class="col-md-4">
                                    <div class="detail-item">
                                        <span class="detail-label">
                                            <i class="fas fa-hashtag"></i> N° Zonificación
                                        </span>
                                        <span
                                            class="detail-value">{{ $datos->nuevoIngreso->numero_zonificacion ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-calendar"></i> Fecha Inscripción
                                    </span>
                                    <span class="detail-value">
                                        {{ \Carbon\Carbon::parse($datos->fecha_inscripcion)->format('d/m/Y') ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-calendar-check"></i> Año Egreso
                                    </span>
                                    <span class="detail-value">
                                        {{ \Carbon\Carbon::parse($datos->nuevoIngreso->anio_egreso)->format('Y') ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-school"></i> Institución Procedencia
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->nuevoIngreso->institucionProcedencia->nombre_institucion ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-book"></i> Expresión Literaria
                                    </span>
                                    <span class="detail-value">
                                        {{ $datos->nuevoIngreso->expresionLiteraria->letra_expresion_literaria ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-12">
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
                    SECCIÓN 4: DOCUMENTOS
                ======================= -->
                    <div class="mb-4">
                        <div class="section-title">
                            <i class="fas fa-folder-open text-warning"></i>
                            <span>Documentos</span>
                            <span
                                class="badge ms-auto 
                            {{ $datos->estado_documentos === 'Completos' ? 'bg-success' : 'bg-warning' }}">
                                {{ $datos->estado_documentos ?? 'Sin información' }}
                            </span>
                        </div>

                        @php
                            $todosDocumentos = [
                                'partida_nacimiento' => [
                                    'label' => 'Partida de Nacimiento',
                                    'icon' => 'fa-file-alt',
                                    'obligatorio' => true,
                                ],

                                'constancia_aprobacion_primaria' => [
                                    'label' => 'Constancia Aprobación Primaria',
                                    'icon' => 'fa-stamp',
                                    'obligatorio' => true,
                                ],

                                'certificado_calificaciones' => [
                                    'label' => 'Certificado de Calificaciones',
                                    'icon' => 'fa-certificate',
                                    'obligatorio' => true,
                                ],

                                'boletin_6to_grado' => [
                                    'label' => 'Boletín 6to Grado',
                                    'icon' => 'fa-file-invoice',
                                    'obligatorio' => true,
                                ],

                                'notas_certificadas' => [
                                    'label' => 'Notas Certificadas',
                                    'icon' => 'fa-file-alt',
                                    'obligatorio' => !$esPrimerGrado,
                                ],
                                'liberacion_cupo' => [
                                    'label' => 'Liberación de Cupo',
                                    'icon' => 'fa-file-signature',
                                    'obligatorio' => !$esPrimerGrado,
                                ],

                                'copia_cedula_representante' => [
                                    'label' => 'Copia Cédula Representante',
                                    'icon' => 'fa-id-card',
                                    'obligatorio' => false,
                                ],

                                'copia_cedula_estudiante' => [
                                    'label' => 'Copia Cédula Estudiante',
                                    'icon' => 'fa-id-card',
                                    'obligatorio' => false,
                                ],

                                'foto_estudiante' => [
                                    'label' => 'Fotografía Estudiante',
                                    'icon' => 'fa-camera',
                                    'obligatorio' => false,
                                ],

                                'foto_representante' => [
                                    'label' => 'Fotografía Representante',
                                    'icon' => 'fa-camera',
                                    'obligatorio' => false,
                                ],
                                'carnet_vacunacion' => [
                                    'label' => 'Carnet de Vacunación',
                                    'icon' => 'fa-syringe',
                                    'obligatorio' => false,
                                ],
                                'autorizacion_tercero' => [
                                    'label' => 'Autorización Tercero',
                                    'icon' => 'fa-file-signature',
                                    'obligatorio' => false,
                                ],
                            ];
                            $documentosEntregados = is_array($datos->documentos)
                                ? $datos->documentos
                                : (json_decode($datos->documentos, true) ?:
                                []);
                        @endphp

                        @php
                            if ($esPrimerGrado) {
                                unset($todosDocumentos['notas_certificadas'], $todosDocumentos['liberacion_cupo']);
                            }
                        @endphp


                        <div class="row g-2 mt-2">
                            @foreach ($todosDocumentos as $key => $info)
                                @php
                                    $entregado = in_array($key, $documentosEntregados);
                                @endphp
                                <div class="col-md-6">
                                    <div
                                        class="documento-item {{ $entregado ? 'documento-entregado' : 'documento-faltante' }}">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="documento-icon">
                                                <i class="fas {{ $info['icon'] }}"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="documento-label">
                                                    {{ $info['label'] }}
                                                    @if ($info['obligatorio'])
                                                        <span class="badge badge-sm bg-danger ms-1">Obligatorio</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="documento-status">
                                                @if ($entregado)
                                                    <i class="fas fa-check-circle text-success"></i>
                                                @else
                                                    <i class="fas fa-times-circle text-danger"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
                    {{-- <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print me-2"></i>Imprimir
                </button> --}}
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Avatar del estudiante */
        .student-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        /* Estilos para documentos */
        .documento-item {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 2px solid;
            transition: all 0.2s ease;
        }

        .documento-entregado {
            background: #f0fdf4;
            border-color: #86efac;
        }

        .documento-faltante {
            background: #fef2f2;
            border-color: #fca5a5;
        }

        .documento-item:hover {
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .documento-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .documento-entregado .documento-icon {
            background: #dcfce7;
            color: #16a34a;
        }

        .documento-faltante .documento-icon {
            background: #fee2e2;
            color: #dc2626;
        }

        .documento-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
        }

        .documento-status {
            font-size: 1.25rem;
        }

        /* Badge pequeño */
        .badge-sm {
            font-size: 0.65rem;
            padding: 0.15rem 0.4rem;
        }

        /* Mini cards */
        .mini-card {
            background: #f9fafb;
            border-radius: 12px;
        }

        /* Mejoras responsive */
        @media (max-width: 768px) {
            .modal-xl {
                max-width: 95%;
            }

            .student-avatar {
                width: 60px;
                height: 60px;
                font-size: 2rem;
            }
        }
    </style>
