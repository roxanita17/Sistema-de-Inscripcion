<div>
    @if (session()->has('success') || session()->has('error') || session()->has('warning'))
        <div class="alerts-container mb-3">
            @if (session()->has('success'))
                <div class="alert-modern alert-success alert alert-dismissible fade show">
                    <div class="alert-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="alert-content">
                        <h4>Éxito</h4>
                        <p>{{ session('success') }}</p>
                    </div>
                    <button type="button" class="alert-close btn-close" data-bs-dismiss="alert">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert-modern alert-error alert alert-dismissible fade show">
                    <div class="alert-icon"><i class="fas fa-exclamation-circle"></i></div>
                    <div class="alert-content">
                        <h4>Error</h4>
                        <p>{{ session('error') }}</p>
                    </div>
                    <button type="button" class="alert-close btn-close" data-bs-dismiss="alert">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
            @if (session()->has('warning'))
                <div class="alert-modern alert-warning alert alert-dismissible fade show">
                    <div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div>
                    <div class="alert-content">
                        <h4>Advertencia</h4>
                        <p>{{ session('warning') }}</p>
                    </div>
                    <button type="button" class="alert-close btn-close" data-bs-dismiss="alert">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
        </div>
    @endif

    <div class="card-modern mb-4">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb);">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div>
                    <h3>Paso 1: Seleccionar Estudiante</h3>
                    <p>Seleccione el estudiante que desea inscribir por prosecución</p>
                </div>
            </div>
        </div>
        <div class="card-body-modern" style="padding: 2rem;">
            <div class="row">
                <div class="col-md-12" wire:ignore>
                    <label class="form-label-modern">
                        <i class="fas fa-search"></i>
                        Buscar Estudiante
                        <span class="required-badge">*</span>
                    </label>
                    <select id="alumno_select"
                        class="form-control-modern selectpicker @error('alumnoId') is-invalid @enderror"
                        data-live-search="true" data-size="8" data-width="100%">
                        <option value="">Seleccione un estudiante</option>
                        @foreach ($alumnos as $alumno)
                            @php
                                $anioActual = \App\Models\AnioEscolar::whereIn('status',[ 'Activo', 'Extendido'])->first();
                                $inscripcionAnterior = $alumno->ultimaInscripcionAntesDe($anioActual->id);
                                $gradoAnterior = $inscripcionAnterior?->grado?->numero_grado;
                            @endphp
                            <option value="{{ $alumno->id }}"
                                data-subtext="{{ $alumno->persona->tipoDocumento->nombre ?? '' }}
                                -{{ $alumno->persona->numero_documento }} 
                                {{ $gradoAnterior ? ' | ' . $gradoAnterior . ' ° nivel academico' : '' }}">
                                {{ $alumno->persona->primer_nombre }} {{ $alumno->persona->primer_apellido }}
                            </option>
                        @endforeach
                    </select>
                    @error('alumnoId')
                        <div class="invalid-feedback-modern" style="display:block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            @if ($alumnoSeleccionado && $gradoAnteriorId)
                <div class="card-modern mb-4 mt-4">
                    <div class="card-header-modern">
                        <div class="header-left">
                            <div class="header-icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div>
                                <h3>Datos del Estudiante</h3>
                                <p>Información personal del estudiante inscrito</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body-modern" style="padding: 2rem;">
                        <livewire:admin.alumnos.alumno-edit :alumnoId="$alumnoId" :key="'alumno-edit-' . $alumnoId" />
                    </div>
                </div>
                @php
                    $ins = $inscripcionAnterior;
                @endphp
                <div class="card-body-modern" style="padding: 0;">
                    @if ($ins && ($ins->padre || $ins->madre || $ins->representanteLegal))
                        <div class="card-modern mb-4">
                            <div class="card-header-modern">
                                <div class="header-left">
                                    <div class="header-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <h3>Representantes del Estudiante</h3>
                                        <p>Información de padres y responsables legales</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body-modern" style="padding: 1.25rem;">
                                @if ($ins->padre)
                                    <div class="representante-card">
                                        <div class="representante-badge-wrapper">
                                            <span class="representante-badge representante-padre">
                                                <i class="fas fa-user"></i>
                                                PADRE
                                            </span>
                                        </div>

                                        <div class="representante-grid">
                                            <!-- Columna Izquierda -->
                                            <div class="representante-column">
                                                <div class="info-block">
                                                    <div class="info-block-header">
                                                        <i class="fas fa-id-card"></i>
                                                        <span>Identificación</span>
                                                    </div>
                                                    <div class="info-row-inline">
                                                        <div class="info-col">
                                                            <span class="info-key">Documento:</span>
                                                            <span class="info-val">
                                                                {{ $ins->padre->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $ins->padre->persona->numero_documento }}
                                                            </span>
                                                        </div>
                                                        <div class="info-col">
                                                            <span class="info-key">Telefono:</span>
                                                            <span class="info-val">
                                                                {{ $ins->padre->persona->telefono_completo }}
                                                            </span>
                                                        </div>
                                                        @if ($ins->padre->persona->telefono_dos_completo)
                                                            <div class="info-col">
                                                                <span class="info-key">Segundo Telefono:</span>
                                                                <span class="info-val">
                                                                    {{ $ins->padre->persona->telefono_dos_completo }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Columna Derecha -->
                                            <div class="representante-column">
                                                <div class="info-block">
                                                    <div class="info-block-header">
                                                        <i class="fas fa-user"></i>
                                                        <span>Informacion personal</span>
                                                    </div>
                                                    <div class="info-row-inline">
                                                        <div class="info-col">
                                                            <span class="info-key">Nombre:</span>
                                                            <span class="info-val">
                                                                {{ $ins->padre->persona->primer_nombre }}
                                                                {{ $ins->padre->persona->segundo_nombre }}
                                                                {{ $ins->padre->persona->primer_apellido }}
                                                                {{ $ins->padre->persona->segundo_apellido }}
                                                            </span>
                                                        </div>
                                                        <div class="info-col">
                                                            <span class="info-key">Ocupacion:</span>
                                                            <span class="info-val">
                                                                {{ $ins->padre->ocupacion->nombre_ocupacion }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($ins->madre)
                                    <div class="representante-card">
                                        <div class="representante-badge-wrapper">
                                            <span class="representante-badge representante-madre">
                                                <i class="fas fa-user"></i>
                                                MADRE
                                            </span>
                                        </div>

                                        <div class="representante-grid">
                                            <!-- Columna Izquierda -->
                                            <div class="representante-column">
                                                <div class="info-block">
                                                    <div class="info-block-header">
                                                        <i class="fas fa-id-card"></i>
                                                        <span>Identificación</span>
                                                    </div>
                                                    <div class="info-row-inline">
                                                        <div class="info-col">
                                                            <span class="info-key">Documento:</span>
                                                            <span class="info-val">
                                                                {{ $ins->madre->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $ins->madre->persona->numero_documento }}
                                                            </span>
                                                        </div>
                                                        <div class="info-col">
                                                            <span class="info-key">Telefono:</span>
                                                            <span class="info-val">
                                                                {{ $ins->madre->persona->telefono_completo }}
                                                            </span>
                                                        </div>
                                                        @if ($ins->madre->persona->telefono_dos_completo)
                                                            <div class="info-col">
                                                                <span class="info-key">Segundo Telefono:</span>
                                                                <span class="info-val">
                                                                    {{ $ins->madre->persona->telefono_dos_completo }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Columna Derecha -->
                                            <div class="representante-column">
                                                <div class="info-block">
                                                    <div class="info-block-header">
                                                        <i class="fas fa-user"></i>
                                                        <span>Informacion personal</span>
                                                    </div>
                                                    <div class="info-row-inline">
                                                        <div class="info-col">
                                                            <span class="info-key">Nombre:</span>
                                                            <span class="info-val">
                                                                {{ $ins->madre->persona->primer_nombre }}
                                                                {{ $ins->madre->persona->segundo_nombre }}
                                                                {{ $ins->madre->persona->primer_apellido }}
                                                                {{ $ins->madre->persona->segundo_apellido }}
                                                            </span>
                                                        </div>
                                                        <div class="info-col">
                                                            <span class="info-key">Ocupacion:</span>
                                                            <span class="info-val">
                                                                {{ $ins->madre->ocupacion->nombre_ocupacion }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($ins->representanteLegal)
                                    <div class="representante-card">
                                        <div class="representante-badge-wrapper">
                                            <span class="representante-badge representante-legal">
                                                <i class="fas fa-gavel"></i>
                                                REPRESENTANTE LEGAL
                                            </span>
                                        </div>

                                        <div class="representante-grid">
                                            <!-- Columna Izquierda -->
                                            <div class="representante-column">
                                                <div class="info-block">
                                                    <div class="info-block-header">
                                                        <i class="fas fa-id-card"></i>
                                                        <span>Identificación</span>
                                                    </div>
                                                    <div class="info-row-inline">
                                                        <div class="info-col">
                                                            <span class="info-key">Documento:</span>
                                                            <span class="info-val">
                                                                {{ $ins->representanteLegal->representante->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $ins->representanteLegal->representante->persona->numero_documento }}
                                                            </span>
                                                        </div>
                                                        <div class="info-col">
                                                            <span class="info-key">Telefono:</span>
                                                            <span class="info-val">
                                                                {{ $ins->representanteLegal->representante->persona->telefono_completo }}
                                                            </span>
                                                        </div>
                                                        @if ($ins->representanteLegal->representante->persona->telefono_dos_completo)
                                                            <div class="info-col">
                                                                <span class="info-key">Segundo Telefono:</span>
                                                                <span class="info-val">
                                                                    {{ $ins->representanteLegal->representante->persona->telefono_dos_completo }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Columna Derecha -->
                                            <div class="representante-column">
                                                <div class="info-block">
                                                    <div class="info-block-header">
                                                        <i class="fas fa-user"></i>
                                                        <span>Informacion personal</span>
                                                    </div>
                                                    <div class="info-row-inline">
                                                        <div class="info-col">
                                                            <span class="info-key">Nombre:</span>
                                                            <span class="info-val">
                                                                {{ $ins->representanteLegal->representante->persona->primer_nombre }}
                                                                {{ $ins->representanteLegal->representante->persona->segundo_nombre }}
                                                                {{ $ins->representanteLegal->representante->persona->primer_apellido }}
                                                                {{ $ins->representanteLegal->representante->persona->segundo_apellido }}
                                                            </span>
                                                        </div>
                                                        <div class="info-col">
                                                            <span class="info-key">Ocupacion:</span>
                                                            <span class="info-val">
                                                                {{ $ins->representanteLegal->representante->ocupacion->nombre_ocupacion }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        {{-- Información Legal Adicional --}}
                                        <div class="legal-info-section">
                                            <div class="info-block-header">
                                                <i class="fas fa-file-contract"></i>
                                                <span>Información Legal</span>
                                            </div>
                                            <div class="legal-grid">
                                                <div class="info-col">
                                                    <span class="info-key">Parentesco:</span>
                                                    <span
                                                        class="info-val">{{ $ins->representanteLegal->parentesco ?? 'N/A' }}</span>
                                                </div>
                                                <div class="info-col">
                                                    <span class="info-key">Correo:</span>
                                                    <span
                                                        class="info-val">{{ $ins->representanteLegal->correo_representante ?? 'N/A' }}</span>
                                                </div>
                                                @if ($ins->representanteLegal->pertenece_a_organizacion_representante)
                                                    <div class="info-col">
                                                        <span class="info-key">Organización:</span>
                                                        <span
                                                            class="info-val">{{ $ins->representanteLegal->cual_organizacion_representante ?? 'N/A' }}</span>
                                                    </div>
                                                @endif
                                                <div class="info-col">
                                                    <span class="info-key">Carnet Patria:</span>
                                                    <span
                                                        class="info-val-badge {{ $ins->representanteLegal->carnet_patria_afiliado ? 'badge-yes' : 'badge-no' }}">
                                                        {{ $ins->representanteLegal->carnet_patria_afiliado ? 'Sí' : 'No' }}
                                                    </span>
                                                </div>
                                                @if ($ins->representanteLegal->carnet_patria_afiliado)
                                                    <div class="info-col">
                                                        <span class="info-key">Serial:</span>
                                                        <span
                                                            class="info-val">{{ $ins->representanteLegal->serial_carnet_patria_representante ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="info-col">
                                                        <span class="info-key">Código:</span>
                                                        <span
                                                            class="info-val">{{ $ins->representanteLegal->codigo_carnet_patria_representante ?? 'N/A' }}</span>
                                                    </div>
                                                @endif
                                                <div class="info-col">
                                                    <span class="info-key">Banco:</span>
                                                    <span
                                                        class="info-val">{{ $ins->representanteLegal->banco->nombre_banco ?? 'N/A' }}</span>
                                                </div>
                                                <div class="info-col">
                                                    <span class="info-key">Tipo Cuenta:</span>
                                                    <span
                                                        class="info-val">{{ $ins->representanteLegal->tipo_cuenta ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="alert alert-info mt-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-info-circle fa-2x"></i>
                            <div>
                                <strong>NIvel academico cursado:</strong>
                                {{ $grados->firstWhere('id', $gradoAnteriorId)?->numero_grado ?? 'N/A' }} °
                            </div>
                            <div>
                                <strong>Sección:</strong>
                                {{ $inscripcionAnterior->seccion->nombre ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if ($alumnoSeleccionado)
        <div class="card-modern mb-4">
            @php
                $materiasArrastradas = collect($materias)->where('origen', 'pendiente_anterior')->sortBy('nombre');
                $materiasActuales = collect($materias)->where('origen', 'grado_actual')->sortBy('nombre');
                $idsArrastradas = $materiasArrastradas->pluck('id')->toArray();
                $pendientesActuales = collect($materiasSeleccionadas)->diff($idsArrastradas)->count();
            @endphp
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i class="fas fa-book"></i>
                    </div>
                    <div>
                        <h3>Paso 2: Areas de formacion</h3>
                    </div>
                </div>
            </div>
            <div class="card-body-modern" style="padding: 2rem;">
                @if (count($materias) > 0)
                    @if ($materiasArrastradas->isNotEmpty())
                        <div class="materias-section mb-4">
                            <div class="section-header-warning mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <h5 class="mb-0">Areas de formacion reprobadas</h5>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle"></i>
                                    El estudiante tiene areas de formacion reprobadas de niveles academicos anteriores. Debe
                                    aprobarlas todas;
                                    de lo contrario, deberá repetir el nivel academico completo.
                                    <b>MARQUE</b> las áreas de formación que el estudiante <b>APROBÓ</b>
                                </small>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <div class="checkbox-item-modern">
                                        <input type="checkbox" id="select_all_arrastradas"
                                            wire:model.live="seleccionarTodasArrastradas" class="checkbox-modern">
                                        <label for="select_all_arrastradas" class="checkbox-label-modern">
                                            Seleccionar todas como <span class="text-success">APROBADAS</span>
                                        </label>
                                    </div>
                                </div>

                                @foreach ($materiasArrastradas as $materia)
                                    <div class="col-md-6 mb-3">
                                        <div class="checkbox-item-modern border-warning bg-warning-light">
                                            <input type="checkbox" wire:model.live="materiasSeleccionadas"
                                                value="{{ $materia['id'] }}" id="materia_{{ $materia['id'] }}"
                                                class="checkbox-modern checkbox-warning">

                                            <label for="materia_{{ $materia['id'] }}" class="checkbox-label-modern">
                                                <div class="d-flex justify-content-between align-items-center w-100">
                                                    <div>
                                                        <div class="d-flex align-items-center gap-2 mb-1">
                                                            <strong>{{ $materia['nombre'] }}</strong>
                                                        </div>
                                                        <small class="text-muted">
                                                            <i class="fas fa-tag"></i> Código:
                                                            {{ $materia['codigo'] }}
                                                            |
                                                            <i class="fas fa-layer-group"></i> Nivel academico:
                                                            {{ $materia['grado'] }}°
                                                        </small>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="divider-section my-4">
                            <hr class="divider-line">
                        </div>
                    @endif
                    @if ($materiasActuales->isNotEmpty())
                        <div class="materias-section">
                            <div class="section-header-primary mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-book-open"></i>
                                    <h5 class="mb-0">Materias del Nivel Academico Actual</h5>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle"></i>
                                    <b>MARQUE</b> las materias que el estudiante <b>APROBÓ</b>
                                </small>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <div class="checkbox-item-modern">
                                        <input type="checkbox" id="select_all_actuales"
                                            wire:model.live="seleccionarTodasActuales" class="checkbox-modern">
                                        <label for="select_all_actuales" class="checkbox-label-modern">
                                            Seleccionar todas como <span class="text-success">APROBADAS</span>
                                        </label>
                                    </div>
                                </div>
                                @foreach ($materiasActuales as $materia)
                                    <div class="col-md-6 mb-3">
                                        <div class="checkbox-item-modern">
                                            <input type="checkbox" wire:model.live="materiasSeleccionadas"
                                                value="{{ $materia['id'] }}" id="materia_{{ $materia['id'] }}"
                                                class="checkbox-modern">

                                            <label for="materia_{{ $materia['id'] }}" class="checkbox-label-modern">
                                                <div class="d-flex justify-content-between align-items-center w-100">
                                                    <div>
                                                        <strong>{{ $materia['nombre'] }}</strong>
                                                        <br>
                                                        <small class="text-muted">
                                                            <i class="fas fa-tag"></i> Código:
                                                            {{ $materia['codigo'] }} |
                                                            <i class="fas fa-layer-group"></i> Nivel academico:
                                                            {{ $materia['grado'] }}°
                                                        </small>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        No hay materias disponibles para este estudiante.
                    </div>
                @endif
            </div>
        </div>
        <div class="card-modern mb-4">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h3>Paso 3: Nivel Academico y Sección</h3>
                        <p>Seleccione el nivel academico al que será promovido el estudiante</p>
                    </div>
                </div>
            </div>
            <div class="card-body-modern" style="padding: 2rem;">
                <div class="row">
                    @if ($mensajeSugerencia)
                        <div class="alert alert-info mt-2">
                            <i class="fas fa-lightbulb"></i>
                            {{ $mensajeSugerencia }}
                        </div>
                    @endif
                    <div class="col-md-4">
                        <label for="grado_promocion" class="form-label-modern">
                            <i class="fas fa-layer-group"></i>
                            Nivel Academico de Promoción
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model.live="gradoPromocionId" id="grado_promocion"
                            class="form-control-modern @error('gradoPromocionId') is-invalid @enderror">
                            <option value="">Seleccione un nivel academico</option>
                            @foreach ($grados as $grado)
                                <option value="{{ $grado->id }}">
                                    {{ $grado->numero_grado }}°
                                </option>
                            @endforeach
                        </select>
                        @error('gradoPromocionId')
                            <div class="invalid-feedback-modern" style="display: block;">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        @if ($repite_grado)
                            <small class="form-text text-danger">
                                <i class="fas fa-info-circle"></i>
                                El estudiante debe repetir el mismo nivel academico
                            </small>
                        @endif
                    </div>
                    @if (!$esPrimerGrado && $gradoPromocionId)
                        <div class="col-md-4">
                            <label for="seccion" class="form-label-modern">
                                <i class="fas fa-th-large"></i>
                                Sección
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model.live="seccion_id" id="seccion"
                                class="form-control-modern @error('seccion_id') is-invalid @enderror">
                                <option value="">Seleccione una sección</option>
                                @foreach ($secciones as $seccion)
                                    <option value="{{ $seccion->id }}">
                                        Sección {{ $seccion->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('seccion_id')
                                <div class="invalid-feedback-modern" style="display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @endif
                    <div class="col-md-4">
                        <label for="fecha" class="form-label-modern">
                            <i class="fas fa-calendar"></i>
                            Fecha de Inscripción
                        </label>
                        <input type="datetime-local" value="{{ now('America/Caracas')->format('Y-m-d\TH:i') }}"
                            class="form-control-modern" disabled>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <label for="observaciones" class="form-label-modern">
                            <i class="fas fa-comment"></i>
                            Observaciones
                        </label>
                        <textarea wire:model.live="observaciones" id="observaciones"
                            class="form-control-modern @error('observaciones') is-invalid @enderror" rows="3"
                            placeholder="Agregue observaciones adicionales sobre la inscripción (opcional)" maxlength="500"></textarea>
                        @error('observaciones')
                            <div class="invalid-feedback-modern" style="display: block;">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        <small class="form-text text-muted">
                            {{ strlen($observaciones ?? '') }}/500 caracteres
                        </small>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="checkbox-item-modern">
                            <input type="checkbox" id="acepta_normas_contrato"
                                wire:model.live="acepta_normas_contrato" class="checkbox-modern">

                            <label for="acepta_normas_contrato" class="checkbox-label-modern">
                                He leído y acepto
                                <a class="text-primary ms-1" data-bs-toggle="modal"
                                    data-bs-target="#modalContratoConvivencia" style="text-decoration: none;">
                                    las normas de convivencia
                                </a>
                                <span class="required-badge ms-1">*</span>
                            </label>
                        </div>
                        @error('acepta_normas_contrato')
                            <div class="invalid-feedback-modern" style="display: block;">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="card-modern">
            <div class="card-body-modern" style="padding: 2rem;">
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('admin.transacciones.inscripcion_prosecucion.index') }}"
                        class="btn-cancel-modern">
                        <i class="fas fa-arrow-left"></i>
                        Cancelar
                    </a>
                    <button type="button" wire:click="finalizar" class="btn-primary-modern"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="finalizar">
                            <i class="fas fa-save"></i>
                            Guardar
                        </span>
                        <span wire:loading wire:target="finalizar">
                            <i class="fas fa-spinner fa-spin"></i>
                            Guardando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif
    @include('admin.transacciones.inscripcion.modales.showContratoModal')
    @push('js')
        <script>
            document.addEventListener('livewire:init', () => {

                const select = $('#alumno_select');

                select.selectpicker();

                select.on('changed.bs.select', function() {
                    const alumnoId = $(this).val();
                    Livewire.dispatch('seleccionarAlumno', {
                        alumnoId
                    });
                });

                Livewire.on('refreshSelectAlumno', () => {
                    select.selectpicker('destroy');
                    select.selectpicker();
                });

            });
        </script>
    @endpush
