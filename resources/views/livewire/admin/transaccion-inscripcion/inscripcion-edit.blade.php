<div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal', (payload) => {
                const data = payload[0];

                Swal.fire({
                    icon: data.icon,
                    title: data.title,
                    text: data.message,
                    confirmButtonText: 'Aceptar'
                });
            });
        });
    </script>

    <div class="card-modern mb-4">
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

    <div class="card-modern mb-4">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon" style="background: linear-gradient(135deg, var(--success), #059669);">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h3>Representantes</h3>
                    <p>Seleccione al menos un representante</p>
                </div>
            </div>
        </div>
        <div class="card-body-modern" style="padding: 2rem;">
            <div class="row align-items-center mb-4 mt-4">
                <div class="col-md-10" wire:ignore>
                    <label for="padre_select" class="form-label-modern">
                        <i class="fas fa-male"></i> Padre
                    </label>
                    <select id="padre_select" class="form-control-modern selectpicker" data-live-search="true"
                        data-size="8" data-width="100%">
                        <option value="">Seleccione al padre (opcional)</option>
                        @foreach ($padres as $padre)
                            <option value="{{ $padre['id'] }}"
                                data-subtext="{{ $padre['tipo_documento'] }}-{{ $padre['numero_documento'] }}"
                                {{ $padreId == $padre['id'] ? 'selected' : '' }}>
                                {{ $padre['nombre_completo'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 text-md-end mt-3 mt-md-0">
                    @if ($padreId)
                        <a href="{{ route('representante.editar', [
                            'id' => $padreId,
                            'from' => 'inscripcion_edit',
                            'inscripcion_id' => $inscripcionId,
                        ]) }}"
                            class="btn-create btn-sm">
                            <i class="fas fa-edit me-1"></i> Editar
                        </a>
                    @endif
                </div>
            </div>

            @if ($padreSeleccionado)
                <div class="card-body-modern" style="padding: 0;">
                    <div class="details-grid">
                        <div class="details-section">
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
                                            {{ $padreSeleccionado->persona->tipoDocumento->nombre ?? 'N/A' }} -
                                            {{ $padreSeleccionado->persona->numero_documento }}
                                        </span>
                                    </div>
                                </div>
                            </div>

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
                                            {{ $padreSeleccionado->persona->primer_nombre }}
                                            {{ $padreSeleccionado->persona->segundo_nombre }}
                                            {{ $padreSeleccionado->persona->tercer_nombre }}
                                            {{ $padreSeleccionado->persona->primer_apellido }}
                                            {{ $padreSeleccionado->persona->segundo_apellido }}
                                        </span>
                                    </div>
                                </div>
                                <div
                                    style="display:flex; justify-content:center; align-items:center; flex-direction:column;">
                                    <div class="info-group pt-3" style="display:flex; gap:2rem; flex-direction:row">
                                        <div class="info-item" style="width: 15rem;">
                                            <span class="info-label">
                                                Género
                                            </span>
                                            <span class="info-value">
                                                {{ $padreSeleccionado->persona->genero->genero ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="info-item" style="width: 15rem;">
                                            <span class="info-label">
                                                Teléfono
                                            </span>
                                            <span class="info-value">
                                                {{ $padreSeleccionado->persona->telefono_completo ?? 'N/A' }}
                                            </span>
                                        </div>
                                        @if ($padreSeleccionado->persona->telefono_dos_completo)
                                            <div class="info-item" style="width: 15rem;">
                                                <span class="info-label">
                                                    Segundo Teléfono
                                                </span>
                                                <span class="info-value">
                                                    {{ $padreSeleccionado->persona->telefono_dos_completo ?? 'N/A' }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="details-section">
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
                                            {{ $padreSeleccionado->estado->nombre_estado ?? 'N/A' }},
                                            {{ $padreSeleccionado->municipios->nombre_municipio ?? 'N/A' }},
                                            {{ $padreSeleccionado->localidads->nombre_localidad ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
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
                                            {{ $padreSeleccionado->ocupacion->nombre_ocupacion ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="info-group pt-3">
                                    <div class="info-item">
                                        <span class="info-label">
                                            Convive con el Estudiante
                                        </span>
                                        <span class="info-value">
                                            {{ $padreSeleccionado->convivenciaestudiante_representante ? 'Sí' : 'No' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row align-items-center mb-4 mt-4">
                <div class="col-md-10" wire:ignore>
                    <label for="madre_select" class="form-label-modern">
                        <i class="fas fa-female"></i> Madre
                    </label>
                    <select id="madre_select" class="form-control-modern selectpicker" data-live-search="true"
                        data-size="8" data-width="100%">
                        <option value="">Seleccione a la madre (opcional)</option>
                        @foreach ($madres as $madre)
                            <option value="{{ $madre['id'] }}"
                                data-subtext="{{ $madre['tipo_documento'] }}-{{ $madre['numero_documento'] }}"
                                {{ $madreId == $madre['id'] ? 'selected' : '' }}>
                                {{ $madre['nombre_completo'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 text-md-end mt-3 mt-md-0">
                    @if ($madreId)
                        <a href="{{ route('representante.editar', [
                            'id' => $madreId,
                            'from' => 'inscripcion_edit',
                            'inscripcion_id' => $inscripcionId,
                        ]) }}"
                            class="btn-create btn-sm">
                            <i class="fas fa-edit me-1"></i> Editar
                        </a>
                    @endif
                </div>
            </div>
            @if ($madreSeleccionado)
                <div class="card-body-modern" style="padding: 0;">
                    <div class="details-grid">
                        <div class="details-section">
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
                                            {{ $madreSeleccionado->persona->tipoDocumento->nombre ?? 'N/A' }} -
                                            {{ $madreSeleccionado->persona->numero_documento }}
                                        </span>
                                    </div>
                                </div>
                            </div>
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
                                            {{ $madreSeleccionado->persona->primer_nombre }}
                                            {{ $madreSeleccionado->persona->segundo_nombre }}
                                            {{ $madreSeleccionado->persona->tercer_nombre }}
                                            {{ $madreSeleccionado->persona->primer_apellido }}
                                            {{ $madreSeleccionado->persona->segundo_apellido }}
                                        </span>
                                    </div>
                                </div>
                                <div
                                    style="display:flex; justify-content:center; align-items:center; flex-direction:column;">
                                    <div class="info-group pt-3" style="display:flex; gap:2rem; flex-direction:row">
                                        <div class="info-item" style="width: 15rem;">
                                            <span class="info-label">
                                                Género
                                            </span>
                                            <span class="info-value">
                                                {{ $madreSeleccionado->persona->genero->genero ?? 'N/A' }}
                                            </span>
                                        </div>
                                        <div class="info-item" style="width: 15rem;">
                                            <span class="info-label">
                                                Teléfono
                                            </span>
                                            <span class="info-value">
                                                {{ $madreSeleccionado->persona->telefono ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="details-section">
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
                                            {{ $madreSeleccionado->estado->nombre_estado ?? 'N/A' }},
                                            {{ $madreSeleccionado->municipios->nombre_municipio ?? 'N/A' }},
                                            {{ $madreSeleccionado->localidads->nombre_localidad ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
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
                                            {{ $madreSeleccionado->ocupacion->nombre_ocupacion ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="info-group pt-3">
                                    <div class="info-item">
                                        <span class="info-label">
                                            Convive con el Estudiante
                                        </span>
                                        <span class="info-value">
                                            {{ $madreSeleccionado->convivenciaestudiante_representante ? 'Sí' : 'No' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row align-items-center mb-4 mt-4">
                <div class="col-md-10" wire:ignore>
                    <label for="representante_legal_select" class="form-label-modern">
                        <i class="fas fa-gavel"></i> Representante Legal
                    </label>
                    <select id="representante_legal_select" class="form-control-modern selectpicker"
                        data-live-search="true" data-size="8" data-width="100%">
                        <option value="">Seleccione un representante legal</option>
                        @foreach ($representantes as $rep)
                            <option value="{{ $rep['id'] }}"
                                data-subtext="{{ $rep['tipo_documento'] }}-{{ $rep['numero_documento'] }}"
                                {{ $representanteLegalId == $rep['id'] ? 'selected' : '' }}>
                                {{ $rep['nombre_completo'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 text-md-end mt-3 mt-md-0">
                    @if ($representanteLegalId)
                        <a href="{{ route('representante.editar', [
                            'id' => $representanteLegalId,
                            'from' => 'inscripcion_edit',
                            'inscripcion_id' => $inscripcionId,
                        ]) }}"
                            class="btn-create btn-sm">
                            <i class="fas fa-edit me-1"></i> Editar
                        </a>
                    @endif
                </div>
            </div>
            @error('representanteLegalId')
                <div class="invalid-feedback-modern">
                    {{ $message }}
                </div>
            @enderror
            @if ($representanteLegalSeleccionado)
                <div class="card-body-modern" style="padding: 0;">
                    <div class="details-grid">
                        <div class="details-section">
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
                                            {{ $representanteLegalSeleccionado->representante->persona->tipoDocumento->nombre ?? 'N/A' }}
                                            -
                                            {{ $representanteLegalSeleccionado->representante->persona->numero_documento }}
                                        </span>
                                    </div>
                                </div>
                            </div>

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
                                            {{ $representanteLegalSeleccionado->representante->persona->primer_nombre }}
                                            {{ $representanteLegalSeleccionado->representante->persona->segundo_nombre }}
                                            {{ $representanteLegalSeleccionado->representante->persona->tercer_nombre }}
                                            {{ $representanteLegalSeleccionado->representante->persona->primer_apellido }}
                                            {{ $representanteLegalSeleccionado->representante->persona->segundo_apellido }}
                                        </span>
                                    </div>
                                </div>
                                <div
                                    style="display:flex; justify-content:center; align-items:center; flex-direction:column;">
                                    <div class="info-group pt-3" style="display:flex; gap:2rem; flex-direction:row">
                                        <div class="info-item" style="width: 15rem;">
                                            <span class="info-label">
                                                Género
                                            </span>
                                            <span class="info-value">
                                                {{ $representanteLegalSeleccionado->representante->persona->genero->genero ?? 'N/A' }}
                                            </span>
                                        </div>

                                        <div class="info-item" style="width: 15rem;">
                                            <span class="info-label">
                                                Teléfono
                                            </span>
                                            <span class="info-value">
                                                {{ $representanteLegalSeleccionado->representante->persona->telefono ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="details-section">
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
                                            {{ $representanteLegalSeleccionado->representante->estado->nombre_estado ?? 'N/A' }},
                                            {{ $representanteLegalSeleccionado->representante->municipios->nombre_municipio ?? 'N/A' }},
                                            {{ $representanteLegalSeleccionado->representante->localidads->nombre_localidad ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
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
                                            {{ $representanteLegalSeleccionado->representante->ocupacion->nombre_ocupacion ?? 'N/A' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="info-group pt-3">
                                    <div class="info-item">
                                        <span class="info-label">
                                            Convive con el Estudiante
                                        </span>
                                        <span class="info-value">
                                            {{ $representanteLegalSeleccionado->representante->convivenciaestudiante_representante ? 'Sí' : 'No' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-section mt-4">
                    <div class="section-header">
                        <i class="fas fa-gavel"></i>
                        <h4>Información Legal</h4>
                    </div>
                    <div style="display:flex; justify-content:center; align-items:center;">
                        <div class="info-group pt-3"
                            style="display:flex; gap:2rem; flex-wrap:wrap; justify-content:center; flex-direction:row;">
                            <div class="info-item" style="width: 15rem;">
                                <span class="info-label">
                                    Parentesco
                                </span>
                                <span class="info-value">
                                    {{ $representanteLegalSeleccionado->parentesco ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="info-item" style="width: 18rem;">
                                <span class="info-label">
                                    Correo del Representante
                                </span>
                                <span class="info-value">
                                    {{ $representanteLegalSeleccionado->correo_representante ?? 'N/A' }}
                                </span>
                            </div>
                            @if ($representanteLegalSeleccionado->pertenece_a_organizacion_representante)
                                <div class="info-item" style="width: 18rem;">
                                    <span class="info-label">
                                        Organizacion
                                    </span>
                                    <span class="info-value">
                                        {{ $representanteLegalSeleccionado->cual_organizacion_representante ?? 'N/A' }}
                                    </span>
                                </div>
                            @endif
                            <div class="info-item" style="width: 12rem;">
                                <span class="info-label">
                                    Carnet de la Patria
                                </span>
                                <span class="info-value">
                                    {{ $representanteLegalSeleccionado->carnet_patria_afiliado ? 'Sí' : 'No' }}
                                </span>
                            </div>
                            <div class="info-item" style="width: 14rem;">
                                <span class="info-label">
                                    Serial Carnet Patria
                                </span>
                                <span class="info-value">
                                    {{ $representanteLegalSeleccionado->serial_carnet_patria_representante ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="info-item" style="width: 14rem;">
                                <span class="info-label">
                                    Código Carnet Patria
                                </span>
                                <span class="info-value">
                                    {{ $representanteLegalSeleccionado->codigo_carnet_patria_representante ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="info-item" style="width: 18rem;">
                                <span class="info-label">
                                    Banco
                                </span>
                                <span class="info-value">
                                    {{ $representanteLegalSeleccionado->banco->codigo_banco ?? 'N/A' }}-{{ $representanteLegalSeleccionado->banco->nombre_banco ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="info-item" style="width: 18rem;">
                                <span class="info-label">
                                    Tipo de Cuenta
                                </span>
                                <span class="info-value">
                                    {{ $representanteLegalSeleccionado->tipo_cuenta ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="card-modern mb-4">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon" style="background: linear-gradient(135deg, var(--warning), #d97706);">
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <h3>Nivel Academico y Procedencia</h3>
                    <p>Información del nivel academico e institución de procedencia</p>
                </div>
            </div>
        </div>
        <div class="card-body-modern" style="padding: 2rem;">
            <div class="row">
                <div class="col-md-4">
                    <label for="grado_id" class="form-label-modern">
                        Nivel Academico
                    </label>
                    <select wire:model.live="gradoId"
                        class="form-control-modern @error('gradoId') is-invalid @enderror">
                        <option value="">Seleccione un nivel academico</option>
                        @foreach ($grados as $grado)
                            <option value="{{ $grado->id }}">{{ $grado->numero_grado }} °
                            </option>
                        @endforeach
                    </select>
                    @error('gradoId')
                        <div class="invalid-feedback-modern">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                @if (!$esPrimerGrado)
                    <div class="col-md-4">
                        <label for="seccion_id" class="form-label-modern">
                            <i class="fas fa-th-large"></i> Sección
                        </label>
                        <select wire:model.live="seccionId"
                            class="form-control-modern @error('seccionId') is-invalid @enderror">
                            <option value="">Seleccione una sección</option>
                            @foreach ($secciones as $seccion)
                                <option value="{{ $seccion->id }}">{{ $seccion->nombre }}</option>
                            @endforeach
                        </select>
                        @error('seccionId')
                            <div class="invalid-feedback-modern">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                @endif
                @if ($esPrimerGrado)
                    <div class="col-md-4">
                        <label class="form-label-modern">
                            Número de Zonificación
                        </label>
                        <input type="text" wire:model.live="numero_zonificacion"
                            class="form-control-modern @error('numero_zonificacion') is-invalid @enderror"
                            maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g,'')"
                            inputmode="numeric">
                    </div>
                @endif
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="paisId" class="form-label-modern">Pais<span class="required-badge">*</span></label>
                        <select wire:model.live="paisId" class="form-control-modern @error('paisId') is-invalid @enderror">
                            <option value="">Seleccione un país</option>
                            @foreach($paises as $pais)
                                <option value="{{ $pais->id }}">{{ $pais->nameES }}</option>
                            @endforeach
                        </select>
                        @error('paisId') <div class="invalid-feedback-modern">{{ $message }}</div> @enderror
                    </div>
                </div>


                @if($esVenezolano)
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="estado_id" class="form-label-modern">Estado <span class="required-badge">*</span></label>
                            <select wire:model.live="estado_id" id="estado_id" @disabled(!$paisId) class="form-control-modern @error('estado_id') is-invalid @enderror">
                                <option value="">Seleccione un estado</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                                @endforeach
                            </select>
                            @error('estado_id') <div class="invalid-feedback-modern">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="municipio_id" class="form-label-modern">Municipio <span class="required-badge">*</span></label>
                            <select wire:model.live="municipio_id" id="municipio_id" @disabled(!$estado_id) class="form-control-modern @error('municipio_id') is-invalid @enderror">
                                <option value="">Seleccione un municipio</option>
                                @foreach ($municipios as $municipio)
                                    <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
                                @endforeach
                            </select>
                            @error('municipio_id') <div class="invalid-feedback-modern">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="localidad_id" class="form-label-modern">Localidad <span class="required-badge">*</span></label>
                            <select wire:model.live="localidad_id" id="localidad_id" @disabled(!$municipio_id) class="form-control-modern @error('localidad_id') is-invalid @enderror">
                                <option value="">Seleccione una localidad</option>
                                @foreach ($localidades as $localidad)
                                    <option value="{{ $localidad->id }}">{{ $localidad->nombre_localidad }}</option>
                                @endforeach
                            </select>
                            @error('localidad_id') <div class="invalid-feedback-modern">{{ $message }}</div> @enderror
                        </div>
                    </div>
                @endif
            </div>
            <div class="row mt-3">
                <div class="col-md-4">
                    <label class="form-label-modern">
                        Institución de Procedencia
                    </label>

                    @if($esVenezolano)
                        <select wire:model.live="institucion_procedencia_id"
                            class="form-control-modern @error('institucion_procedencia_id') is-invalid @enderror"
                            @disabled(!$localidad_id)>
                            <option value="">Seleccione</option>
                            @foreach ($instituciones as $inst)
                                <option value="{{ $inst->id }}">{{ $inst->nombre_institucion }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="text"
                            wire:model.live="otroPaisNombre"
                            class="form-control-modern"
                            placeholder="Nombre de la institución extranjera">
                    @endif

                    @error('institucion_procedencia_id')
                        <div class="invalid-feedback-modern">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label class="form-label-modern">
                        Literal
                    </label>
                    <select wire:model.live="expresion_literaria_id"
                        class="form-control-modern @error('expresion_literaria_id') is-invalid @enderror">
                        <option value="">Seleccione</option>
                        @foreach ($expresiones_literarias as $item)
                            <option value="{{ $item->id }}">{{ $item->letra_expresion_literaria }}</option>
                        @endforeach
                    </select>
                    @error('expresion_literaria_id')
                        <div class="invalid-feedback-modern">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label-modern">
                        Año de Egreso
                    </label>
                    <input type="date" wire:model.live="anio_egreso"
                        class="form-control-modern @error('anio_egreso') is-invalid @enderror">
                    @error('anio_egreso')
                        <div class="invalid-feedback-modern">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card-modern mb-4">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div>
                    <h3>Documentos Entregados</h3>
                    <p>Marque los documentos que el estudiante ha entregado</p>
                </div>
            </div>
            <div class="header-right">
                @if ($estadoDocumentos === 'Completos')
                    <span class="badge bg-success">
                        <i class="fas fa-check-circle"></i> Completos
                    </span>
                @elseif($estadoDocumentos === 'Incompletos')
                    <span class="badge bg-warning">
                        <i class="fas fa-exclamation-circle"></i> Incompletos
                    </span>
                @endif
            </div>
        </div>
        <div class="card-body-modern" style="padding: 2rem;">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="checkbox-item-modern">
                        <input type="checkbox" id="seleccionar_todos" wire:model.live="seleccionarTodos"
                            class="checkbox-modern">
                        <label for="seleccionar_todos" class="checkbox-label-modern">
                            Seleccionar todos los documentos
                        </label>
                    </div>
                </div>
            </div>

            <div class="row">
                @php
                    $colCounter = 0;
                @endphp

                @foreach ($documentosEtiquetas as $documento => $etiqueta)
                    @php
                        if ($esPrimerGrado && in_array($documento, ['notas_certificadas', 'liberacion_cupo'])) {
                            continue;
                        }

                        $esFaltante = in_array($documento, $documentosFaltantes);
                    @endphp

                    @if ($colCounter % 12 === 0 && $colCounter !== 0)
            </div>
            <div class="row mt-3">
                @endif

                <div class="col-md-6 mb-3">
                    <div class="checkbox-item-modern {{ $esFaltante ? 'checkbox-warning' : '' }}">
                        <input type="checkbox" id="doc_{{ $documento }}" wire:model.live="documentos"
                            value="{{ $documento }}" class="checkbox-modern">

                        <label for="doc_{{ $documento }}"
                            class="checkbox-label-modern {{ $esFaltante ? 'text-warning fw-bold' : '' }}">
                            {{ $etiqueta }}
                            @if ($esFaltante)
                                <span class="badge bg-warning ms-2">Pendiente</span>
                            @endif
                        </label>
                    </div>
                </div>

                @php $colCounter++; @endphp
                @endforeach
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <label class="form-label-modern">
                        <i class="fas fa-comment"></i> Observaciones
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
        </div>
    </div>
    @include('admin.transacciones.inscripcion.modales.showContratoModal')

    <div class="card-modern">
        <div class="card-body-modern" style="padding: 2rem;">
            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.transacciones.inscripcion.index') }}" class="btn-cancel-modern">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>

                <button type="button" wire:click="actualizar" class="btn-primary-modern"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="actualizar">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </span>
                    <span wire:loading wire:target="actualizar">
                        <i class="fas fa-spinner fa-spin"></i> Guardando...
                    </span>
                </button>
            </div>
        </div>
    </div>
    @livewire('admin.modales.institucion-procedencia-create')
    @livewire('admin.modales.localidad-create')
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.selectpicker').selectpicker();

            $('#padre_select').on('changed.bs.select', function() {
                let value = $(this).val();
                @this.set('padreId', value, true);
            });

            $('#madre_select').on('changed.bs.select', function() {
                let value = $(this).val();
                @this.set('madreId', value, true);
            });

            $('#representante_legal_select').on('changed.bs.select', function() {
                let value = $(this).val();
                @this.set('representanteLegalId', value, true);
            });
        });

        document.addEventListener('livewire:updated', function() {
            $('.selectpicker').selectpicker('refresh');
        });
    </script>
@endpush
