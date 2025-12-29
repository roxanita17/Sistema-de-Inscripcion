<div>
    @if (!$enModoEdicion && !$soloEdicion)
        <div class="header-container" style="display: flex; align-items: center;">
            <div class="header-right" style="margin-left: auto;">
                @if (!$soloEdicion)
                    <button type="button" wire:click="habilitarEdicion" class="btn-primary-modern">
                    <i class="fas fa-edit"></i> Editar Datos
                </button>
                @endif
                
            </div>
        </div>
        {{-- Modo Vista --}}
        <div class="card-body-modern" style="padding: 0;">

            <div class="details-grid">
                {{-- COLUMNA IZQUIERDA --}}
                <div class="details-section">
                    {{-- Sección: Identificación --}}
                    <div class="info-section">
                        <div class="section-header">
                            <i class="fas fa-id-badge"></i>
                            <h4>Datos de Identificación</h4>
                        </div>
                        <div class="info-group">
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-id-card"></i>
                                    Número de Cédula
                                </span>
                                <span class="info-value">
                                    {{ $tipos_documentos->find($tipo_documento_id)->nombre ?? 'N/A' }}-{{ $numero_documento }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Sección: Datos Personales --}}
                    <div class="info-section">
                        <div class="section-header">
                            <i class="fas fa-user"></i>
                            <h4>Información Personal</h4>
                        </div>
                        <div class="info-group">
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-user"></i>
                                    Nombre Completo
                                </span>
                                <span class="info-value">
                                    {{ $primer_nombre }} {{ $segundo_nombre }} {{ $primer_apellido }}
                                    {{ $segundo_apellido }}
                                </span>
                            </div>
                        </div>
                        <div style="align-items: center; display:flex; flex-direction: column;">


                            <div class="info-group pt-3" style="display: flex; flex-direction: row; ">
                                <div class="info-item" style="width: 15rem">
                                    <span class="info-label">
                                        <i class="fas fa-calendar"></i>
                                        Fecha de Nacimiento
                                    </span>
                                    <span class="info-value">
                                        {{ \Carbon\Carbon::parse($fecha_nacimiento)->format('d/m/Y') }}
                                    </span>
                                </div>
                                <div class="info-item" style="width: 15rem">
                                    <span class="info-label">
                                        <i class="fas fa-venus-mars"></i>
                                        Género
                                    </span>
                                    <span class="info-value">
                                        {{ $generos->find($genero_id)->genero ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- COLUMNA DERECHA --}}
                <div class="details-section">
                    {{-- Sección: Lugar de Nacimiento --}}
                    <div class="info-section">
                        <div class="section-header">
                            <i class="fas fa-map-marker-alt"></i>
                            <h4>Lugar de Nacimiento</h4>
                        </div>
                        <div class="info-group">
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-map"></i>
                                    Estado, Municipio, Localidad
                                </span>
                                @if ($localidad_id)
                                    <span class="info-value">
                                        {{ $estados->find($estado_id)->nombre_estado ?? '' }},
                                        {{ $municipios->find($municipio_id)->nombre_municipio ?? '' }},
                                        {{ $localidades->find($localidad_id)->nombre_localidad ?? '' }}
                                    </span>
                                @else
                                    <span class="info-value text-muted">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        No registrado
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Sección: Datos Físicos --}}
                    <div class="info-section">
                        <div class="section-header">
                            <i class="fas fa-ruler-combined"></i>
                            <h4>Información Física</h4>
                        </div>
                        <div style="align-items: center; display:flex; flex-direction: column;">
                            <div class="info-group" style="display: flex; flex-direction: row; ">
                                <div class="info-item" style="width: 10rem;">
                                    <span class="info-label">
                                        <i class="fas fa-ruler-vertical"></i>
                                        Estatura
                                    </span>
                                    <span class="info-value">
                                        {{ $talla_estudiante }} m
                                    </span>

                                </div>
                                <div class="info-item" style="width: 10rem;">
                                    <span class="info-label">
                                        <i class="fas fa-weight"></i>
                                        Peso
                                    </span>
                                    <span class="info-value">
                                        {{ $peso_estudiante }} kg
                                    </span>
                                </div>
                                <div class="info-item" style="width: 10rem;">
                                    <span class="info-label">
                                        <i class="fas fa-tshirt"></i>
                                        Talla Camisa
                                    </span>
                                    <span class="info-value">
                                        {{ $tallas->find($talla_camisa_id)->nombre ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                            <div class="info-group pt-3" style="display: flex; flex-direction: row;">
                                <div class="info-item" style="width: 15rem;">
                                    <span class="info-label">
                                        <i class="fas fa-socks"></i>
                                        Talla Pantalón
                                    </span>
                                    <span class="info-value">
                                        {{ $tallas->find($talla_pantalon_id)->nombre ?? 'N/A' }}
                                    </span>
                                </div>
                                <div class="info-item" style="width: 15rem;">
                                    <span class="info-label">
                                        <i class="fas fa-shoe-prints"></i>
                                        Talla Zapato
                                    </span>
                                    <span class="info-value">
                                        {{ $talla_zapato }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección: Características Adicionales --}}
            <div class="info-section">
                <div class="section-header">
                    <i class="fas fa-info-circle"></i>
                    <h4>Características Adicionales</h4>
                </div>
                <div style="align-items: center; display:flex; flex-direction: column;">
                    <div class="info-group" style="display: flex; flex-direction: row;">
                        <div class="info-item" style="width: 19rem;">
                            <span class="info-label">
                                <i class="fas fa-hand-paper"></i>
                                Lateralidad
                            </span>
                            <span class="info-value">
                                {{ $lateralidades->find($lateralidad_id)->lateralidad ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="info-item" style="width: 19rem;">
                            <span class="info-label">
                                <i class="fas fa-sort-numeric-up"></i>
                                Orden de Nacimiento
                            </span>
                            <span class="info-value">
                                {{ $orden_nacimientos->find($orden_nacimiento_id)->orden_nacimiento ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="info-item" style="width: 19rem;">
                            <span class="info-label">
                                <i class="fas fa-users"></i>
                                Etnia Indígena
                            </span>
                            <span class="info-value">
                                {{ $etnia_indigenas->find($etnia_indigena_id)->nombre ?? 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección de Discapacidades --}}
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon" style="background: linear-gradient(135deg, #8b5cf6, #6366f1);">
                        <i class="fas fa-wheelchair"></i>
                    </div>
                    <div>
                        <h3>Discapacidades Registradas</h3>
                        <p>{{ count($discapacidadesAlumno) }} discapacidades registradas</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern">
                @if (!empty($discapacidadesAlumno))
                    <div class="table-wrapper">
                        <table class="table-modern">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align: middle;">#</th>
                                    <th style="text-align: center; vertical-align: middle;">Discapacidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($discapacidadesAlumno as $index => $discapacidad)
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <span class="number-badge">{{ $index + 1 }}</span>
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <div
                                                style="display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                                                <div
                                                    style="width: 40px; height: 40px; background: var(--primary-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.2rem; flex-shrink: 0;">
                                                    <i class="fas fa-wheelchair"></i>
                                                </div>
                                                <div
                                                    style="font-weight: 600; color: var(--gray-900); font-size: 0.95rem;">
                                                    {{ $discapacidad['nombre'] }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="text-align: center; padding: 3rem; color: var(--gray-500);">
                        <i class="fas fa-info-circle" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p style="font-size: 1.1rem; margin: 0;">No se han registrado discapacidades para este
                            estudiante.</p>
                    </div>
                @endif
            </div>


        </div>
    @else
        {{-- Modo Edición --}}
        <form wire:submit.prevent="guardar">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div>
                        <h3>Puede editar información del estudiante</h3>
                        <p>Actualice los datos del estudiante según sea necesario</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern" style="padding: 2rem;">
                {{-- Datos de Identificación --}}
                <div class="row">
                    <div class="col-12 mb-3">
                        <h5
                            style="color: var(--gray-700); font-weight: 600; border-bottom: 2px solid var(--gray-200); padding-bottom: 0.5rem;">
                            <i class="fas fa-id-badge"></i> Datos de Identificación
                        </h5>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label-modern">
                            <i class="fas fa-id-card"></i> Tipo Doc.
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model.live="tipo_documento_id"
                            class="form-control-modern @error('tipo_documento_id') is-invalid @enderror">
                            <option value="">Seleccione</option>
                            @foreach ($tipos_documentos as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                        @error('tipo_documento_id')
                            <div class="invalid-feedback-modern" style="display:block">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label-modern">
                            <i class="fas fa-id-card"></i> Cédula
                            <span class="required-badge">*</span>
                        </label>
                        <input type="text" wire:model.live="numero_documento"
                            class="form-control-modern @error('numero_documento') is-invalid @enderror
                                text-uppercase"
                            maxlength="{{ $documento_maxlength }}" pattern="{{ $documento_pattern }}"
                            inputmode="{{ $documento_inputmode }}" placeholder="{{ $documento_placeholder }}"
                            oninput="
                                @if ($tipo_documento_id == 1 || $tipo_documento_id == 3) this.value = this.value.replace(/[^0-9]/g,'')
                                @elseif($tipo_documento_id == 2)
                                this.value = this.value.replace(/[^a-zA-Z0-9]/g,'') @endif
                                ">
                        @error('numero_documento')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label-modern">
                            <i class="fas fa-birthday-cake"></i> Fecha Nacimiento
                            <span class="required-badge">*</span>
                        </label>
                        <input type="date" wire:model.live="fecha_nacimiento"
                            class="form-control-modern @error('fecha_nacimiento') is-invalid @enderror">
                        @error('fecha_nacimiento')
                            <div class="invalid-feedback-modern" style="display:block">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label-modern">
                            <i class="fas fa-venus-mars"></i> Género
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model.live="genero_id"
                            class="form-control-modern @error('genero_id') is-invalid @enderror">
                            <option value="">Seleccione</option>
                            @foreach ($generos as $genero)
                                <option value="{{ $genero->id }}">{{ $genero->genero }}</option>
                            @endforeach
                        </select>
                        @error('genero_id')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Datos Personales --}}
                <div class="row mt-4">
                    <div class="col-12 mb-3">
                        <h5
                            style="color: var(--gray-700); font-weight: 600; border-bottom: 2px solid var(--gray-200); padding-bottom: 0.5rem;">
                            <i class="fas fa-user"></i> Datos Personales
                        </h5>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label-modern ">
                            <i class="fas fa-user"></i> Primer Nombre
                            <span class="required-badge">*</span>
                        </label>
                        <input type="text" wire:model.live="primer_nombre"
                            class="form-control-modern text-capitalize @error('primer_nombre') is-invalid @enderror">
                        @error('primer_nombre')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label-modern">Segundo Nombre</label>
                        <input type="text" wire:model="segundo_nombre"
                            class="form-control-modern text-capitalize">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label-modern">Tercer Nombre</label>
                        <input type="text" wire:model="tercer_nombre" class="form-control-modern text-capitalize">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label-modern">
                            <i class="fas fa-user"></i> Primer Apellido
                            <span class="required-badge">*</span>
                        </label>
                        <input type="text" wire:model.live="primer_apellido"
                            class="form-control-modern text-capitalize @error('primer_apellido') is-invalid @enderror">
                        @error('primer_apellido')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-3">
                        <label class="form-label-modern">Segundo Apellido</label>
                        <input type="text" wire:model="segundo_apellido"
                            class="form-control-modern text-capitalize">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label-modern">
                            <i class="fas fa-hand-paper"></i> Lateralidad
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model.live="lateralidad_id"
                            class="form-control-modern @error('lateralidad_id') is-invalid @enderror">
                            <option value="">Seleccione</option>
                            @foreach ($lateralidades as $lat)
                                <option value="{{ $lat->id }}">{{ $lat->lateralidad }}</option>
                            @endforeach
                        </select>
                        @error('lateralidad_id')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label-modern">
                            <i class="fas fa-sort-numeric-up"></i> Orden Nacimiento
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model.live="orden_nacimiento_id"
                            class="form-control-modern @error('orden_nacimiento_id') is-invalid @enderror">
                            <option value="">Seleccione</option>
                            @foreach ($orden_nacimientos as $orden)
                                <option value="{{ $orden->id }}">{{ $orden->orden_nacimiento }}</option>
                            @endforeach
                        </select>
                        @error('orden_nacimiento_id')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label-modern">
                            <i class="fas fa-users"></i> Etnia Indígena
                        </label>
                        <select wire:model="etnia_indigena_id" class="form-control-modern">
                            <option value="">Seleccione</option>
                            @foreach ($etnia_indigenas as $etnia)
                                <option value="{{ $etnia->id }}">{{ $etnia->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Datos Físicos --}}
                <div class="row mt-4">
                    <div class="col-12 mb-3">
                        <h5
                            style="color: var(--gray-700); font-weight: 600; border-bottom: 2px solid var(--gray-200); padding-bottom: 0.5rem;">
                            <i class="fas fa-ruler-combined"></i> Datos Físicos
                        </h5>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label-modern">
                            <i class="fas fa-ruler-vertical"></i> Altura (m)
                            <span class="required-badge">*</span>
                        </label>
                        <input type="text" wire:model.defer="talla_estudiante" wire:blur="validarEstatura"
                            wire:keyup='formatearEstatura'
                            class="form-control-modern @error('talla_estudiante') is-invalid @enderror"
                            placeholder="1.65">
                        @error('talla_estudiante')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label-modern">
                            <i class="fas fa-weight"></i> Peso (kg)
                            <span class="required-badge">*</span>
                        </label>
                        <input type="number" wire:model.live="peso_estudiante"
                            class="form-control-modern @error('peso_estudiante') is-invalid @enderror" step="0.1">
                        @error('peso_estudiante')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label-modern">
                            <i class="fas fa-tshirt"></i> Talla Camisa
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model.live="talla_camisa_id"
                            class="form-control-modern @error('talla_camisa_id') is-invalid @enderror">
                            <option value="">Seleccione</option>
                            @foreach ($tallas as $talla)
                                <option value="{{ $talla->id }}">{{ $talla->nombre }}</option>
                            @endforeach
                        </select>
                        @error('talla_camisa_id')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label-modern">
                            <i class="fas fa-socks"></i> Talla Pantalón
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model.live="talla_pantalon_id"
                            class="form-control-modern @error('talla_pantalon_id') is-invalid @enderror">
                            <option value="">Seleccione</option>
                            @foreach ($tallas as $talla)
                                <option value="{{ $talla->id }}">{{ $talla->nombre }}</option>
                            @endforeach
                        </select>
                        @error('talla_pantalon_id')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label-modern">
                            <i class="fas fa-shoe-prints"></i> Talla Zapato
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model.live="talla_zapato"
                            class="form-control-modern @error('talla_zapato') is-invalid @enderror">
                            <option value="">Seleccione</option>
                            @foreach (range(30, 45) as $talla)
                                <option value="{{ $talla }}">{{ $talla }}</option>
                            @endforeach
                        </select>
                        @error('talla_zapato')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                {{-- Lugar de Nacimiento --}}
                <div class="row mt-4">
                    <div class="col-12 mb-3">
                        <h5
                            style="color: var(--gray-700); font-weight: 600; border-bottom: 2px solid var(--gray-200); padding-bottom: 0.5rem;">
                            <i class="fas fa-map-marker-alt"></i> Lugar de Nacimiento
                        </h5>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-modern">
                            <i class="fas fa-map"></i> Estado
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model.live="estado_id"
                            class="form-control-modern @error('estado_id') is-invalid @enderror">
                            <option value="">Seleccione</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                            @endforeach
                        </select>
                        @error('estado_id')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-modern">
                            <i class="fas fa-map-marked-alt"></i> Municipio
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model.live="municipio_id"
                            class="form-control-modern @error('municipio_id') is-invalid @enderror">
                            <option value="">Seleccione</option>
                            @foreach ($municipios as $municipio)
                                <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
                            @endforeach
                        </select>
                        @error('municipio_id')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-modern">
                            <i class="fas fa-map-pin"></i> Localidad
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model.live="localidad_id"
                            class="form-control-modern @error('localidad_id') is-invalid @enderror">
                            <option value="">Seleccione</option>
                            @foreach ($localidades as $localidad)
                                <option value="{{ $localidad->id }}">{{ $localidad->nombre_localidad }}</option>
                            @endforeach
                        </select>
                        @error('localidad_id')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Sección de Discapacidades en modo edición --}}
            <div class="card-modern mt-4">
                <div class="card-header-modern">
                    <div class="header-left">
                        <div class="header-icon" style="background: linear-gradient(135deg, #8b5cf6, #6366f1);">
                            <i class="fas fa-wheelchair"></i>
                        </div>
                        <div>
                            <h3>Gestionar Discapacidades</h3>
                            <p>{{ count($discapacidadesAlumno) }} discapacidades registradas</p>
                        </div>
                    </div>
                </div>

                <div class="card-body-modern" style="padding: 2rem;">
                    @if (!empty($discapacidadesAlumno))
                        <div class="table-wrapper">
                            <table class="table-modern">
                                <thead>
                                    <tr>
                                        <th style="text-align: center; vertical-align: middle;">#</th>
                                        <th style="text-align: center; vertical-align: middle;">Discapacidad</th>
                                        <th style="text-align: center; vertical-align: middle;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($discapacidadesAlumno as $index => $disc)
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <span class="number-badge">{{ $index + 1 }}</span>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <div
                                                    style="display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                                                    <div
                                                        style="width: 40px; height: 40px; background: var(--primary-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.2rem; flex-shrink: 0;">
                                                        <i class="fas fa-wheelchair"></i>
                                                    </div>
                                                    <div
                                                        style="font-weight: 600; color: var(--gray-900); font-size: 0.95rem;">
                                                        {{ $disc['nombre'] }}
                                                    </div>
                                                </div>
                                            </td>

                                            <td style="text-align: center; vertical-align: middle;">
                                                <div style="display: flex; justify-content: center;">
                                                    <button type="button"
                                                        wire:click="eliminarDiscapacidad({{ $loop->index }})"
                                                        class="action-btn btn-delete" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div style="text-align: center; padding: 2rem; color: var(--gray-500);">
                            <i class="fas fa-info-circle"
                                style="font-size: 2.5rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                            <p style="font-size: 1rem; margin: 0;">No hay discapacidades registradas.</p>
                        </div>
                    @endif

                    {{-- Agregar discapacidad --}}
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <label class="form-label-modern">
                                <i class="fas fa-wheelchair"></i> Discapacidad
                            </label>
                            <select wire:model.defer="discapacidadSeleccionada"
                                class="form-control-modern @error('discapacidadSeleccionada') is-invalid @enderror">
                                <option value="">Seleccione una discapacidad</option>
                                @foreach ($discapacidades as $discapacidad)
                                    <option value="{{ $discapacidad->id }}">{{ $discapacidad->nombre_discapacidad }}
                                    </option>
                                @endforeach
                            </select>
                            @error('discapacidadSeleccionada')
                                <div class="invalid-feedback-modern" style="display: block;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" wire:click="agregarDiscapacidad" class="btn-primary-modern w-100"
                                style="margin-bottom: 0;">
                                <span wire:loading.remove wire:target="agregarDiscapacidad">
                                    <i class="fas fa-plus"></i> Agregar
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Botones --}}
            <div class="card-body-modern" style="padding: 2rem;">
                <div class="d-flex justify-content-end gap-3">
                    <button type="submit" class="btn-primary-modern" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="guardar">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </span>
                        <span wire:loading wire:target="guardar">
                            <i class="fas fa-spinner fa-spin"></i> Guardando...
                        </span>
                    </button>
                </div>
            </div>

        </form>

    @endif
</div>
