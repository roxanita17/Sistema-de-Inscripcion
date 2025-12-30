<div>
    {{-- ALERTAS --}}
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

    {{-- PASO 1: SELECCIONAR ESTUDIANTE --}}
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
                                $anioActual = \App\Models\AnioEscolar::where('status', 'Activo')->first();
                                $inscripcionAnterior = $alumno->ultimaInscripcionAntesDe($anioActual->id);
                                $gradoAnterior = $inscripcionAnterior?->grado?->numero_grado;
                            @endphp
                            <option value="{{ $alumno->id }}"
                                data-subtext="{{ $alumno->persona->tipoDocumento->nombre ?? '' }}
                                -{{ $alumno->persona->numero_documento }} 
                                {{ $gradoAnterior ? ' | ' . $gradoAnterior . ' Año' : '' }}">
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

            {{-- Información del alumno seleccionado --}}
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
                        <livewire:admin.alumnos.alumno-edit :alumnoId="$alumnoId" />
                    </div>
                </div>

                @php
                    $ins = $inscripcionAnterior;
                @endphp
                @if ($ins && ($ins->padre || $ins->madre || $ins->representanteLegal))
                    <div class="card-modern mb-4">
                        <div class="card-header-modern">
                            <div class="header-left">
                                <div class="header-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h3>Representantes del Estudiante</h3>
                                    <p>Padres o responsables legales</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-body-modern" style="padding: 0;">

                            @if ($ins->padre)
                                <div class="card-body-modern" style="padding: 0;">
                                    <div class="mb-3 text-center">
                                        <span class="status-parent status-badge px-4 py-2 mt-4">
                                            <i class="fas fa-user"></i> PADRE
                                        </span>
                                        <div class="details-grid">
                                            {{-- COLUMNA IZQUIERDA --}}
                                            <div class="details-section">
                                                {{-- Identificación --}}
                                                <div class="info-section">
                                                    <div class="section-header">
                                                        <i class="fas fa-id-badge"></i>
                                                        <h4>Datos de Identificación</h4>
                                                    </div>
                                                    <div class="info-group">
                                                        <div class="info-item">
                                                            <span class="info-label">
                                                                Documento
                                                            </span>
                                                            <span class="info-value">
                                                                {{ $ins->padre->persona->tipoDocumento->nombre ?? 'N/A' }}
                                                                -
                                                                {{ $ins->padre->persona->numero_documento }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Información Personal --}}
                                                <div class="info-section">
                                                    <div class="section-header">
                                                        <i class="fas fa-user"></i>
                                                        <h4>Información Personal</h4>
                                                    </div>

                                                    <div class="info-group">
                                                        <div class="info-item">
                                                            <span class="info-label">
                                                                Nombre Completo
                                                            </span>
                                                            <span class="info-value">
                                                                {{ $ins->padre->persona->primer_nombre }}
                                                                {{ $ins->padre->persona->segundo_nombre }}
                                                                {{ $ins->padre->persona->tercer_nombre }}
                                                                {{ $ins->padre->persona->primer_apellido }}
                                                                {{ $ins->padre->persona->segundo_apellido }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div
                                                        style="display:flex; justify-content:center; align-items:center; flex-direction:column;">
                                                        <div class="info-group pt-3"
                                                            style="display:flex; gap:2rem; flex-direction:row">
                                                            <div class="info-item" style="width: 15rem;">
                                                                <span class="info-label">
                                                                    Género
                                                                </span>
                                                                <span class="info-value">
                                                                    {{ $ins->padre->persona->genero->genero ?? 'N/A' }}
                                                                </span>
                                                            </div>

                                                            <div class="info-item" style="width: 15rem;">
                                                                <span class="info-label">
                                                                    Teléfono
                                                                </span>
                                                                <span class="info-value">
                                                                    {{ $ins->padre->persona->telefono ?? 'N/A' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            {{-- COLUMNA DERECHA --}}
                                            <div class="details-section">

                                                {{-- Ubicación --}}
                                                <div class="info-section">
                                                    <div class="section-header">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <h4>Ubicación</h4>
                                                    </div>

                                                    <div class="info-group">
                                                        <div class="info-item">
                                                            <span class="info-label">
                                                                Estado / Municipio / Localidad
                                                            </span>
                                                            <span class="info-value">
                                                                {{ $ins->padre->estado->nombre_estado ?? 'N/A' }},
                                                                {{ $ins->padre->municipios->nombre_municipio ?? 'N/A' }},
                                                                {{ $ins->padre->localidads->nombre_localidad ?? 'N/A' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Datos Laborales --}}
                                                <div class="info-section">
                                                    <div class="section-header">
                                                        <i class="fas fa-briefcase"></i>
                                                        <h4>Información Laboral</h4>
                                                    </div>

                                                    <div class="info-group">
                                                        <div class="info-item">
                                                            <span class="info-label">
                                                                Ocupación
                                                            </span>
                                                            <span class="info-value">
                                                                {{ $ins->padre->ocupacion->nombre_ocupacion ?? 'N/A' }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="info-group pt-3">
                                                        <div class="info-item">
                                                            <span class="info-label">
                                                                Convive con el Estudiante
                                                            </span>
                                                            <span class="info-value">
                                                                {{ $ins->padre->convivenciaestudiante_representante ? 'Sí' : 'No' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            <div class="rep-divider">
                                <i class="fas fa-users"></i>
                            </div>


                            @if ($ins->madre)
                                <div class="card-body-modern" style="padding: 0;">
                                    <div class="mb-3 text-center">
                                        <span class="status-parent status-badge px-4 py-2 mt-4">
                                            <i class="fas fa-user"></i> MADRE
                                        </span>
                                        <div class="details-grid">
                                            {{-- COLUMNA IZQUIERDA --}}
                                            <div class="details-section">
                                                {{-- Identificación --}}
                                                <div class="info-section">
                                                    <div class="section-header">
                                                        <i class="fas fa-id-badge"></i>
                                                        <h4>Datos de Identificación</h4>
                                                    </div>
                                                    <div class="info-group">
                                                        <div class="info-item">
                                                            <span class="info-label">
                                                                Documento
                                                            </span>
                                                            <span class="info-value">
                                                                {{ $ins->madre->persona->tipoDocumento->nombre ?? 'N/A' }}
                                                                -
                                                                {{ $ins->madre->persona->numero_documento }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Información Personal --}}
                                                <div class="info-section">
                                                    <div class="section-header">
                                                        <i class="fas fa-user"></i>
                                                        <h4>Información Personal</h4>
                                                    </div>

                                                    <div class="info-group">
                                                        <div class="info-item">
                                                            <span class="info-label">
                                                                Nombre Completo
                                                            </span>
                                                            <span class="info-value">
                                                                {{ $ins->madre->persona->primer_nombre }}
                                                                {{ $ins->madre->persona->segundo_nombre }}
                                                                {{ $ins->madre->persona->tercer_nombre }}
                                                                {{ $ins->madre->persona->primer_apellido }}
                                                                {{ $ins->madre->persona->segundo_apellido }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div
                                                        style="display:flex; justify-content:center; align-items:center; flex-direction:column;">
                                                        <div class="info-group pt-3"
                                                            style="display:flex; gap:2rem; flex-direction:row">
                                                            <div class="info-item" style="width: 15rem;">
                                                                <span class="info-label">
                                                                    Género
                                                                </span>
                                                                <span class="info-value">
                                                                    {{ $ins->madre->persona->genero->genero ?? 'N/A' }}
                                                                </span>
                                                            </div>

                                                            <div class="info-item" style="width: 15rem;">
                                                                <span class="info-label">
                                                                    Teléfono
                                                                </span>
                                                                <span class="info-value">
                                                                    {{ $ins->madre->persona->telefono ?? 'N/A' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            {{-- COLUMNA DERECHA --}}
                                            <div class="details-section">

                                                {{-- Ubicación --}}
                                                <div class="info-section">
                                                    <div class="section-header">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <h4>Ubicación</h4>
                                                    </div>

                                                    <div class="info-group">
                                                        <div class="info-item">
                                                            <span class="info-label">
                                                                Estado / Municipio / Localidad
                                                            </span>
                                                            <span class="info-value">
                                                                {{ $ins->madre->estado->nombre_estado ?? 'N/A' }},
                                                                {{ $ins->madre->municipios->nombre_municipio ?? 'N/A' }},
                                                                {{ $ins->madre->localidads->nombre_localidad ?? 'N/A' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Datos Laborales --}}
                                                <div class="info-section">
                                                    <div class="section-header">
                                                        <i class="fas fa-briefcase"></i>
                                                        <h4>Información Laboral</h4>
                                                    </div>

                                                    <div class="info-group">
                                                        <div class="info-item">
                                                            <span class="info-label">
                                                                Ocupación
                                                            </span>
                                                            <span class="info-value">
                                                                {{ $ins->madre->ocupacion->nombre_ocupacion ?? 'N/A' }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="info-group pt-3">
                                                        <div class="info-item">
                                                            <span class="info-label">
                                                                Convive con el Estudiante
                                                            </span>
                                                            <span class="info-value">
                                                                {{ $ins->madre->convivenciaestudiante_representante ? 'Sí' : 'No' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            <div class="rep-divider">
                                <i class="fas fa-users"></i>
                            </div>

                            @if ($ins->representanteLegal)
                                <div class="card-body-modern" style="padding: 0;">
                                    <div class="mb-3 text-center">
                                        <span class="status-parent status-badge px-4 py-2 mt-4">
                                            <i class="fas fa-user"></i>REPRESENTANTE LEGAL
                                        </span>
                                        <div class="details-grid">

                                            {{-- COLUMNA IZQUIERDA --}}
                                            <div class="details-section">

                                                {{-- Identificación --}}
                                                <div class="info-section">
                                                    <div class="section-header">
                                                        <i class="fas fa-id-badge"></i>
                                                        <h4>Datos de Identificación</h4>
                                                    </div>

                                                    <div class="info-group">
                                                        <div class="info-item">
                                                            <span class="info-label">
                                                                Documento
                                                            </span>
                                                            <span class="info-value">
                                                                {{ $ins->representanteLegal->representante->persona->tipoDocumento->nombre ?? 'N/A' }}
                                                                -
                                                                {{ $ins->representanteLegal->representante->persona->numero_documento }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Información Personal --}}
                                                <div class="info-section">
                                                    <div class="section-header">
                                                        <i class="fas fa-user"></i>
                                                        <h4>Información Personal</h4>
                                                    </div>

                                                    <div class="info-group">
                                                        <div class="info-item">
                                                            <span class="info-label">
                                                                Nombre Completo
                                                            </span>
                                                            <span class="info-value">
                                                                {{ $ins->representanteLegal->representante->persona->primer_nombre }}
                                                                {{ $ins->representanteLegal->representante->persona->segundo_nombre }}
                                                                {{ $ins->representanteLegal->representante->persona->tercer_nombre }}
                                                                {{ $ins->representanteLegal->representante->persona->primer_apellido }}
                                                                {{ $ins->representanteLegal->representante->persona->segundo_apellido }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div
                                                        style="display:flex; justify-content:center; align-items:center; flex-direction:column;">
                                                        <div class="info-group pt-3"
                                                            style="display:flex; gap:2rem; flex-direction:row">
                                                            <div class="info-item" style="width: 15rem;">
                                                                <span class="info-label">
                                                                    Género
                                                                </span>
                                                                <span class="info-value">
                                                                    {{ $ins->representanteLegal->representante->persona->genero->genero ?? 'N/A' }}
                                                                </span>
                                                            </div>

                                                            <div class="info-item" style="width: 15rem;">
                                                                <span class="info-label">
                                                                    Teléfono
                                                                </span>
                                                                <span class="info-value">
                                                                    {{ $ins->representanteLegal->representante->persona->telefono ?? 'N/A' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            {{-- COLUMNA DERECHA --}}
                                            <div class="details-section">

                                                {{-- Ubicación --}}
                                                <div class="info-section">
                                                    <div class="section-header">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <h4>Ubicación</h4>
                                                    </div>

                                                    <div class="info-group">
                                                        <div class="info-item">
                                                            <span class="info-label">
                                                                Estado / Municipio / Localidad
                                                            </span>
                                                            <span class="info-value">
                                                                {{ $ins->representanteLegal->representante->persona->estado->nombre_estado ?? 'N/A' }},
                                                                {{ $ins->representanteLegal->representante->persona->municipios->nombre_municipio ?? 'N/A' }},
                                                                {{ $ins->representanteLegal->representante->persona->localidads->nombre_localidad ?? 'N/A' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Datos Laborales --}}
                                                <div class="info-section">
                                                    <div class="section-header">
                                                        <i class="fas fa-briefcase"></i>
                                                        <h4>Información Laboral</h4>
                                                    </div>

                                                    <div class="info-group">
                                                        <div class="info-item">
                                                            <span class="info-label">
                                                                Ocupación
                                                            </span>
                                                            <span class="info-value">
                                                                {{ $ins->representanteLegal->representante->ocupacion->nombre_ocupacion ?? 'N/A' }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="info-group pt-3">
                                                        <div class="info-item">
                                                            <span class="info-label">
                                                                Convive con el Estudiante
                                                            </span>
                                                            <span class="info-value">
                                                                {{ $ins->representanteLegal->representante->convivenciaestudiante_representante ? 'Sí' : 'No' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Datos Legales --}}
                                    <div class="info-section mt-4">
                                        <div class="section-header">
                                            <i class="fas fa-gavel"></i>
                                            <h4>Información Legal</h4>
                                        </div>

                                        <div style="display:flex; justify-content:center; align-items:center;">
                                            <div class="info-group pt-3"
                                                style="display:flex; gap:2rem; flex-wrap:wrap; justify-content:center; flex-direction:row; margin-bottom:20px">

                                                <div class="info-item" style="width: 15rem;">
                                                    <span class="info-label">
                                                        Parentesco
                                                    </span>
                                                    <span class="info-value">
                                                        {{ $ins->representanteLegal->parentesco ?? 'N/A' }}
                                                    </span>
                                                </div>

                                                <div class="info-item" style="width: 18rem;">
                                                    <span class="info-label">
                                                        Correo del Representante
                                                    </span>
                                                    <span class="info-value">
                                                        {{ $ins->representanteLegal->correo_representante ?? 'N/A' }}
                                                    </span>
                                                </div>
                                                @if ($ins->representanteLegal->pertenece_a_organizacion_representante)
                                                    <div class="info-item" style="width: 18rem;">
                                                        <span class="info-label">
                                                            Organizacion
                                                        </span>
                                                        <span class="info-value">
                                                            {{ $ins->representanteLegal->cual_organizacion_representante ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                @endif


                                                <div class="info-item" style="width: 12rem;">
                                                    <span class="info-label">
                                                        Carnet de la Patria
                                                    </span>
                                                    <span class="info-value">
                                                        {{ $ins->representanteLegal->carnet_patria_afiliado ? 'Sí' : 'No' }}
                                                    </span>
                                                </div>


                                                <div class="info-item" style="width: 14rem;">
                                                    <span class="info-label">
                                                        Serial Carnet Patria
                                                    </span>
                                                    <span class="info-value">
                                                        {{ $ins->representanteLegal->serial_carnet_patria_representante ?? 'N/A' }}
                                                    </span>
                                                </div>
                                                <div class="info-item" style="width: 14rem;">
                                                    <span class="info-label">
                                                        Código Carnet Patria
                                                    </span>
                                                    <span class="info-value">
                                                        {{ $ins->representanteLegal->codigo_carnet_patria_representante ?? 'N/A' }}
                                                    </span>
                                                </div>

                                                <div class="info-item" style="width: 18rem;">
                                                    <span class="info-label">
                                                        Banco
                                                    </span>
                                                    <span class="info-value">
                                                        {{ $ins->representanteLegal->banco->codigo_banco ?? 'N/A' }}-{{ $ins->representanteLegal->banco->nombre_banco ?? 'N/A' }}
                                                    </span>
                                                </div>

                                                <div class="info-item" style="width: 18rem;">
                                                    <span class="info-label">
                                                        Tipo de Cuenta
                                                    </span>
                                                    <span class="info-value">
                                                        {{ $ins->representanteLegal->tipo_cuenta ?? 'N/A' }}
                                                    </span>
                                                </div>
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
                            <strong>Año cursado:</strong>
                            {{ $grados->firstWhere('id', $gradoAnteriorId)?->numero_grado }} Año
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- PASO 2: MATERIAS PENDIENTES --}}
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
                        <h3>Paso 2: Materias</h3>
                        <p>Marque las materias que están pendientes por aprobar</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern" style="padding: 2rem;">
                @if (count($materias) > 0)
                    {{-- Advertencia de materias pendientes --}}
                    @if ($pendientesActuales >= 4)
                        <div class="alert alert-danger mb-3">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Atención:</strong> Con 4 o más materias pendientes el estudiante debe repetir el
                            mismo año.
                        </div>
                    @endif
                    {{-- SECCIÓN: Materias reprobadas --}}
                    @if ($materiasArrastradas->isNotEmpty())
                        <div class="materias-section mb-4">
                            <div class="section-header-warning mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <h5 class="mb-0">Materias reprobadas</h5>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle"></i>
                                    El estudiante tiene materias reprobadas de años anteriores. Debe aprobarlas todas;
                                    de lo contrario, deberá repetir el año completo.
                                    <b>Marque las materias que el estudiante aprobo</b>
                                </small>
                            </div>

                            <div class="row">
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
                                                            <i class="fas fa-layer-group"></i> Año:
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

                        {{-- Divisor visual --}}
                        <div class="divider-section my-4">
                            <hr class="divider-line">
                        </div>
                    @endif

                    {{-- SECCIÓN: MATERIAS DEL GRADO ACTUAL --}}
                    @if ($materiasActuales->isNotEmpty())
                        <div class="materias-section">
                            <div class="section-header-primary mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-book-open"></i>
                                    <h5 class="mb-0">Materias del Año Actual</h5>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle"></i>
                                    Marque las materias del año cursado que quedaron pendientes por aprobar.
                                </small>
                            </div>

                            <div class="row">
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
                                                            <i class="fas fa-layer-group"></i> Año:
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

        {{-- PASO 3: GRADO Y SECCIÓN --}}
        <div class="card-modern mb-4">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h3>Paso 3: Año y Sección</h3>
                        <p>Seleccione el año al que será promovido el estudiante</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern" style="padding: 2rem;">
                <div class="row">
                    {{-- Año de Promoción --}}
                    <div class="col-md-4">
                        <label for="grado_promocion" class="form-label-modern">
                            <i class="fas fa-layer-group"></i>
                            Año de Promoción
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model.live="gradoPromocionId" id="grado_promocion"
                            class="form-control-modern @error('gradoPromocionId') is-invalid @enderror">

                            <option value="">Seleccione un año</option>

                            @foreach ($grados as $grado)
                                <option value="{{ $grado->id }}">
                                    {{ $grado->numero_grado }}° Año
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
                                El estudiante debe repetir el mismo año
                            </small>
                        @endif
                    </div>

                    {{-- Sección (solo si no es primer grado) --}}
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

                    {{-- Fecha de Inscripción --}}
                    <div class="col-md-4">
                        <label for="fecha" class="form-label-modern">
                            <i class="fas fa-calendar"></i>
                            Fecha de Inscripción
                        </label>
                        <input type="datetime-local" value="{{ now('America/Caracas')->format('Y-m-d\TH:i') }}"
                            class="form-control-modern" disabled>
                    </div>
                </div>

                {{-- Observaciones --}}
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

                {{-- Aceptar Normas --}}
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

        {{-- BOTONES DE ACCIÓN --}}
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
                            Guardar Inscripción
                        </span>
                        <span wire:loading wire:target="finalizar">
                            <i class="fas fa-spinner fa-spin"></i>
                            Procesando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif


    {{-- Modal de Contrato --}}
    @include('admin.transacciones.inscripcion.modales.showContratoModal')

    @push('js')
        <script>
            document.addEventListener('livewire:init', () => {

                const select = $('#alumno_select');

                // 1️⃣ Inicializar UNA SOLA VEZ
                select.selectpicker();

                // 2️⃣ Listener ÚNICO
                select.on('changed.bs.select', function() {
                    const alumnoId = $(this).val();
                    Livewire.dispatch('seleccionarAlumno', {
                        alumnoId
                    });
                });

                // 3️⃣ Refresh SOLO cuando Livewire lo pide
                Livewire.on('refreshSelectAlumno', () => {
                    select.selectpicker('destroy');
                    select.selectpicker();
                });

            });
        </script>
    @endpush


    <style>
        /* Secciones de materias */
        .materias-section {
            position: relative;
        }

        /* Headers de secciones */
        .section-header-warning {
            padding: 1rem;
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border-left: 4px solid #f59e0b;
            border-radius: var(--radius);
        }

        .section-header-warning h5 {
            color: #92400e;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .section-header-primary {
            padding: 1rem;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            border-left: 4px solid #3b82f6;
            border-radius: var(--radius);
        }

        .section-header-primary h5 {
            color: #1e40af;
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Divisor */
        .divider-section {
            position: relative;
            text-align: center;
        }

        .divider-line {
            border: 0;
            height: 2px;
            background: linear-gradient(to right, transparent, #e5e7eb, transparent);
            margin: 2rem 0;
        }

        /* Checkbox items */
        .checkbox-item-modern {
            display: flex;
            align-items: flex-start;
            padding: 1rem 1.25rem;
            background: var(--gray-50);
            border-radius: var(--radius);
            transition: all 0.2s ease;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .checkbox-item-modern:hover {
            background: var(--primary-light);
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Materias reprobadas - estilo especial */
        .checkbox-item-modern.border-warning {
            border-color: #f59e0b;
            background: #fffbeb;
        }

        .checkbox-item-modern.border-warning:hover {
            background: #fef3c7;
            border-color: #d97706;
        }

        .bg-warning-light {
            background: #fffbeb !important;
        }

        .checkbox-modern {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--primary);
            flex-shrink: 0;
            margin-top: 2px;
        }

        .checkbox-modern.checkbox-warning {
            accent-color: #f59e0b;
        }

        .checkbox-label-modern {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            margin: 0 0 0 0.75rem;
            font-size: 0.9rem;
            color: var(--gray-700);
            font-weight: 500;
            user-select: none;
            width: 100%;
        }

        .checkbox-label-modern i {
            color: var(--primary);
        }
    </style>
