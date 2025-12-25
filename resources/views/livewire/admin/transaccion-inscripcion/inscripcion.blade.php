<div>
    {{-- Alertas --}}
    @if (session()->has('success') || session()->has('error') || session()->has('warning'))
        <div class="alerts-container mb-3">
            @if (session()->has('success'))
                <div class="alert-modern alert-success alert alert-dismissible fade show">
                    <div class="alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
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
                    <div class="alert-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
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
                <div class="alert alert-warning alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    @endif

    {{-- Seleccionar Representantes --}}
    <div class="card-modern mb-4">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon" style="background: linear-gradient(135deg, var(--success), #059669);">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h3>Seleccionar Representantes</h3>
                    <p>Debe seleccionar al menos un representante</p>
                </div>
            </div>
        </div>
        <div class="card-body-modern" style="padding: 2rem;">

            {{-- Padre --}}
            <div class="row mb-3">
                <div class="col-md-12" wire:ignore>
                    <label for="padre_select" class="form-label-modern">
                        <i class="fas fa-male"></i>
                        Padre
                    </label>
                    <select id="padre_select" class="form-control-modern selectpicker" data-live-search="true"
                        data-size="8" data-width="100%">
                        <option value="">Seleccione al padre (opcional)</option>
                        @foreach ($padres as $padre)
                            <option value="{{ $padre['id'] }}"
                                data-subtext="{{ $padre['tipo_documento'] }}-{{ $padre['numero_documento'] }}">
                                {{ $padre['nombre_completo'] }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>
            @if ($padreSeleccionado)
                <div class="card shadow-sm mt-3">
                    <div class="card-body">

                        <h5 class="mb-3">
                            <i class="fas fa-user text-primary"></i> Datos del Padre
                        </h5>

                        <p><strong>Nombre:</strong> {{ $padreSeleccionado->persona->primer_nombre }}
                            {{ $padreSeleccionado->persona->segundo_nombre }}
                            {{ $padreSeleccionado->persona->primer_apellido }}
                            {{ $padreSeleccionado->persona->segundo_apellido }}
                        </p>

                        <p><strong>Documento:</strong>
                            {{ $padreSeleccionado->persona->tipoDocumento->nombre }}
                            - {{ $padreSeleccionado->persona->numero_documento }}
                        </p>

                        @if ($padreSeleccionado->ocupacion)
                            <p><strong>Ocupación:</strong> {{ $padreSeleccionado->ocupacion->nombre_ocupacion }}</p>
                        @endif

                        <p><strong>Género:</strong> {{ $padreSeleccionado->persona->genero->genero }}</p>

                    </div>
                </div>
            @endif

            {{-- Madre --}}
            <div class="row mb-3">
                <div class="col-md-12" wire:ignore>
                    <label for="madre_select" class="form-label-modern">
                        <i class="fas fa-female"></i>
                        Madre
                    </label>

                    <select id="madre_select" class="form-control-modern selectpicker" data-live-search="true"
                        data-size="8" data-width="100%">
                        <option value="">Seleccione a la madre (opcional)</option>
                        @foreach ($madres as $madre)
                            <option value="{{ $madre['id'] }}"
                                data-subtext="{{ $madre['tipo_documento'] }}-{{ $madre['numero_documento'] }}">
                                {{ $madre['nombre_completo'] }}
                            </option>
                        @endforeach
                    </select>

                </div>
            </div>
            @if ($madreSeleccionado)
                <div class="card shadow-sm mt-3">
                    <div class="card-body">

                        <h5 class="mb-3">
                            <i class="fas fa-user text-primary"></i> Datos de la Madre
                        </h5>

                        <p><strong>Nombre:</strong> {{ $madreSeleccionado->persona->primer_nombre }}
                            {{ $madreSeleccionado->persona->segundo_nombre }}
                            {{ $madreSeleccionado->persona->primer_apellido }}
                            {{ $madreSeleccionado->persona->segundo_apellido }}
                        </p>

                        <p><strong>Documento:</strong>
                            {{ $madreSeleccionado->persona->tipoDocumento->nombre }}
                            - {{ $madreSeleccionado->persona->numero_documento }}
                        </p>

                        @if ($madreSeleccionado->ocupacion)
                            <p><strong>Ocupación:</strong> {{ $madreSeleccionado->ocupacion->nombre_ocupacion }}</p>
                        @endif

                        <p><strong>Género:</strong> {{ $madreSeleccionado->persona->genero->genero }}</p>

                    </div>
                </div>
            @endif

            {{-- Representante Legal --}}
            <div class="row">
                <div class="col-md-12" wire:ignore>
                    <label for="representante_legal_select" class="form-label-modern">
                        <i class="fas fa-gavel"></i>
                        Representante Legal
                    </label>

                    <select id="representante_legal_select" class="form-control-modern selectpicker"
                        data-live-search="true" data-size="8" data-width="100%">
                        <option value="">Seleccione un representante legal</option>
                        @foreach ($representantes as $rep)
                            <option value="{{ $rep['id'] }}"
                                data-subtext="{{ $rep['tipo_documento'] }}-{{ $rep['numero_documento'] }}">
                                {{ $rep['nombre_completo'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @if ($representanteLegalSeleccionado)
                <div class="card shadow-sm mt-3">
                    <div class="card-body">

                        <h5 class="mb-3">
                            <i class="fas fa-user text-primary"></i> Datos del representanteLegal
                        </h5>

                        <p><strong>Nombre:</strong>
                            {{ $representanteLegalSeleccionado->representante->persona->primer_nombre }}
                            {{ $representanteLegalSeleccionado->representante->persona->segundo_nombre }}
                            {{ $representanteLegalSeleccionado->representante->persona->primer_apellido }}
                            {{ $representanteLegalSeleccionado->representante->persona->segundo_apellido }}
                        </p>

                        <p><strong>Documento:</strong>
                            {{ $representanteLegalSeleccionado->representante->persona->tipoDocumento->nombre }}
                            - {{ $representanteLegalSeleccionado->representante->persona->numero_documento }}
                        </p>

                        @if ($representanteLegalSeleccionado->representante->ocupacion)
                            <p><strong>Ocupación:</strong>
                                {{ $representanteLegalSeleccionado->representante->ocupacion->nombre_ocupacion }}</p>
                        @endif

                        <p><strong>Género:</strong>
                            {{ $representanteLegalSeleccionado->representante->persona->genero->genero }}</p>

                    </div>
                </div>
            @endif

            {{-- Boton de crear representante --}}
            <div class="row align-items-center mb-4 mt-4">
                <div class="col-md-9">
                    <div class="alert alert-info d-flex align-items-start p-3 mb-0 shadow-sm" role="alert"
                        style="border-left: 5px solid var(--primary); background: var(--primary-light);">
                        <i class="fas fa-info-circle fa-lg me-3 mt-1"></i>
                        <div class="grow">
                            <span class="d-block"><b>Atención: </b> Si el representante no existe, puede crearlo
                                ahora.</span>
                        </div>
                    </div>
                </div>

                {{-- Alerta de sweetalert --}}
                <div class="col-md-3 text-md-end mt-3 mt-md-0">
                    <button type="button" onclick="confirmarEnvio()" class="btn-create">
                        <i class="fas fa-plus"></i> Crear Representante
                    </button>
                </div>
                <script>
                    function confirmarEnvio() {
                        Swal.fire({
                            title: '¿Desea crear un nuevo representante?',
                            text: 'Esta acción no guardará la información actual.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, crear representante',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('representante.formulario', ['from' => 'inscripcion']) }}";
                            }
                        });
                    }
                </script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            </div>
        </div>
    </div>



    <div class="card-modern mb-4">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon" style="background: linear-gradient(135deg, var(--warning), #d97706);">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <h3>Seleccionar Grado</h3>
                    <p>Seleccione el grado al que desea inscribir al estudiante</p>
                </div>
            </div>
        </div>
        <div class="card-body-modern" style="padding: 2rem;">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="grado_id" class="form-label-modern">
                            <i class="fas fa-layer-group"></i>
                            Grado
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model.live="gradoId" id="grado_id"
                            class="form-control-modern @error('gradoId') is-invalid @enderror">
                            <option value="">Seleccione un grado</option>
                            @foreach ($grados as $grado)
                                <option value="{{ $grado->id }}">{{ $grado->numero_grado }}° Grado</option>
                            @endforeach
                        </select>
                        @error('gradoId')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                @if (!$esPrimerGrado)
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="seccion_id" class="form-label-modern"><i class="fas fa-th-large"></i>
                                Sección
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model.live="seccion_id" id="seccion_id"
                                class="form-control-modern @error('seccion_id') is-invalid @enderror">
                                <option value="">Seleccione una sección</option>
                                @foreach ($secciones as $seccion)
                                    <option value="{{ $seccion->id }}">
                                        {{ $seccion->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('seccion_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                @endif


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fecha" class="form-label-modern">
                            <i class="fas fa-layer-group"></i>
                            Fecha de inscripcion
                            <span class="required-badge">*</span>
                        </label>
                        <input type="datetime-local" value="{{ now('America/Caracas')->format('Y-m-d\TH:i') }}"
                            id="fecha" class="form-control-modern @error('fecha') is-invalid @enderror" disabled>
                        @error('fecha')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>


            </div>
        </div>
    </div>

    {{-- Formulario de datos de procedencia --}}
    <div class="card-modern mb-4">
        <div class="card-body-modern">
            <div class="card-modern mb-4">
                <div class="card-header-modern">
                    <div class="header-left">
                        <div class="header-icon">
                            <i class="fas fa-school"></i>
                        </div>
                        <div>
                            <h3>Plantel de Procedencia</h3>
                            <p>Información de la institución de origen</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-modern" style="padding: 2rem;">
                    <div class="alert alert-danger mb-4"
                        style="background: var(--danger-light); border-left: 4px solid var(--danger); padding: 1rem; border-radius: 8px;">
                        <i class="fas fa-info-circle"></i> Los campos con <span class="text-danger"
                            style="font-weight: 700;">(*)</span> son obligatorios
                    </div>

                    <div class="row">
                        {{-- Numero de zonificacion --}}
                        @if ($esPrimerGrado)
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-label-modern">
                                        <i class="fas fa-hashtag"></i>
                                        Número de Zonificación
                                    </label>
                                    <input type="text" wire:model.live="numero_zonificacion"
                                        class="form-control-modern" maxlength="3" inputmode="numeric"
                                        oninput="this.value = this.value.replace(/[^0-9]/g,'')"
                                        placeholder="Ingrese número de zonificación">
                                </div>
                            </div>
                        @endif


                        {{-- Institucion de procedencia --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="institucion_procedencia_id" class="form-label-modern">
                                    <i class="fas fa-building"></i>
                                    Institución de procedencia
                                    <span class="required-badge">*</span>
                                </label>
                                <select wire:model.live="institucion_procedencia_id"
                                    class="form-control-modern @error('institucion_procedencia_id') is-invalid @enderror">
                                    <option value="">Seleccione una institución</option>
                                    @foreach ($instituciones as $inst)
                                        <option value="{{ $inst->id }}">{{ $inst->nombre_institucion }}</option>
                                    @endforeach
                                </select>
                                @error('institucion_procedencia_id')
                                    <div class="invalid-feedback-modern">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- Expresion literaria --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="expresion_literaria" class="form-label-modern">
                                    <i class="fas fa-font"></i>
                                    Literal
                                    <span class="required-badge">*</span>
                                </label>
                                <select wire:model.live="expresion_literaria_id"
                                    class="form-control-modern @error('expresion_literaria_id') is-invalid @enderror">
                                    <option value="">Seleccione</option>
                                    @foreach ($expresiones_literarias as $item)
                                        <option value="{{ $item->id }}">{{ $item->letra_expresion_literaria }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('expresion_literaria_id')
                                    <div class="invalid-feedback-modern">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        {{-- fecha de egreso --}}
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="anio_egreso" class="form-label-modern">
                                    <i class="fas fa-calendar"></i>
                                    Egreso
                                    <span class="required-badge">*</span>
                                </label>
                                <input type="date" wire:model.live="anio_egreso"
                                    class="form-control-modern @error('anio_egreso') is-invalid @enderror">
                                @error('anio_egreso')
                                    <div class="invalid-feedback-modern">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <livewire:admin.alumnos.alumno-create>
        </div>
    </div>
    {{-- SECCIÓN: DISCAPACIDADES --}}
    <div class="card-modern mb-4">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed);">
                    <i class="fas fa-wheelchair"></i>
                </div>
                <div>
                    <h3>Discapacidades</h3>
                    <p>Agregue las discapacidades que presente el estudiante (opcional)</p>
                </div>
            </div>
            @if (!empty($discapacidadesAgregadas))
                <div class="header-right">
                    <span class="badge bg-info">
                        {{ count($discapacidadesAgregadas) }} agregada(s)
                    </span>
                </div>
            @endif
        </div>

        <div class="card-body-modern" style="padding: 2rem;">

            {{-- Alerta temporal de éxito --}}
            @if (session()->has('success_temp'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success_temp') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Formulario para agregar discapacidad --}}
            <div class="row align-items-end mb-4">
                <div class="col-md-10">
                    <label for="discapacidad_select" class="form-label-modern">
                        <i class="fas fa-list"></i>
                        Seleccionar Discapacidad
                    </label>
                    <select wire:model.defer="discapacidadSeleccionada" id="discapacidad_select"
                        class="form-control-modern @error('discapacidadSeleccionada') is-invalid @enderror">
                        <option value="">Seleccione una discapacidad</option>
                        @foreach ($discapacidades as $discapacidad)
                            <option value="{{ $discapacidad->id }}">
                                {{ $discapacidad->nombre_discapacidad }}
                            </option>
                        @endforeach
                    </select>
                    @error('discapacidadSeleccionada')
                        <div class="invalid-feedback-modern" style="display: block;">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-2">
                    <button type="button" wire:click="agregarDiscapacidad" class="btn-primary-modern w-100"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="agregarDiscapacidad">
                            <i class="fas fa-plus"></i> Agregar
                        </span>
                        <span wire:loading wire:target="agregarDiscapacidad">
                            <i class="fas fa-spinner fa-spin"></i>
                        </span>
                    </button>
                </div>
            </div>

            {{-- Tabla de discapacidades agregadas --}}
            @if (!empty($discapacidadesAgregadas))
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th style="width: 80px; text-align: center;">#</th>
                                <th>Discapacidad</th>
                                <th style="width: 120px; text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($discapacidadesAgregadas as $index => $discapacidad)
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <span class="badge bg-primary">{{ $index + 1 }}</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-wheelchair text-primary"></i>
                                            <strong>{{ $discapacidad['nombre'] }}</strong>
                                        </div>
                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <button type="button" wire:click="eliminarDiscapacidad({{ $index }})"
                                            class="btn btn-sm btn-danger" wire:loading.attr="disabled"
                                            title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    No se han agregado discapacidades. Si el estudiante no presenta ninguna discapacidad, puede
                    continuar sin agregar.
                </div>
            @endif
        </div>
    </div>




    {{-- Documentos Entregados --}}
    <div class="card-modern mb-4" id="bloque-documentos">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon" style="background: linear-gradient(135deg, var(--warning), #d97706);">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div>
                    <h3>Documentos Entregados</h3>
                    <p>Marque los documentos que el estudiante ha entregado</p>
                </div>
            </div>
        </div>



        <div class="card-body-modern" style="padding: 2rem;">
            @if ($errors->has('documentos'))
                <div class="alert-modern alert-error alert alert-dismissible fade show">
                    <div class="alert-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="alert-content">
                        <h4>Error</h4>
                        <p>{{ $errors->first('documentos') }}</p>
                    </div>
                    <button type="button" class="alert-close btn-close" data-bs-dismiss="alert">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
            <div class="row">
                @php
                    $colCounter = 0;
                @endphp
                <div class="col-12 mb-4">
                    <div class="checkbox-item-modern">
                        <input type="checkbox" id="seleccionar_todos" wire:model.live="seleccionarTodos"
                            class="checkbox-modern">
                        <label for="seleccionar_todos" class="checkbox-label-modern">
                            Seleccionar todos los documentos
                        </label>
                    </div>
                </div>

                @foreach ([
        'partida_nacimiento' => 'Partida de Nacimiento',
        'boletin_6to_grado' => 'Boletín de 6to Grado',
        'notas_certificadas' => 'Notas Certificadas',
        'liberacion_cupo' => 'Liberación de Cupo',
        'certificado_calificaciones' => 'Certificado de Calificaciones',
        'constancia_aprobacion_primaria' => 'Constancia de Aprobación Primaria',
        'copia_cedula_representante' => 'Copia de Cédula del Representante',
        'copia_cedula_estudiante' => 'Copia de Cédula del Estudiante',
        'foto_estudiante' => 'Fotografía Tipo Carnet Del Estudiante',
        'foto_representante' => 'Fotografía Tipo Carnet Del Representante',
        'carnet_vacunacion' => 'Carnet de Vacunación Vigente',
        'autorizacion_tercero' => 'Autorización Firmada (si inscribe un tercero)',
    ] as $documento => $etiqueta)
                    @php
                        if ($esPrimerGrado && in_array($documento, ['notas_certificadas', 'liberacion_cupo'])) {
                            continue;
                        }
                    @endphp

                    @if ($colCounter % 12 === 0 && $colCounter !== 0)
            </div>
            <div class="row mt-3">
                @endif

                @php
                    $esFaltante = in_array($documento, $documentosFaltantes);
                @endphp

                <div class="col-md-6 mb-3">
                    <div class="checkbox-item-modern {{ $esFaltante ? 'checkbox-error' : '' }}">
                        <input type="checkbox" id="{{ $documento }}" wire:model.live="documentos"
                            value="{{ $documento }}" class="checkbox-modern">

                        <label for="{{ $documento }}"
                            class="checkbox-label-modern {{ $esFaltante ? 'text-danger fw-bold' : '' }}">
                            {{ $etiqueta }}

                            @if ($esFaltante)
                                <span class="text-danger "></span>
                            @endif
                        </label>
                    </div>
                </div>

                @php $colCounter++; @endphp
                @endforeach
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="form-group">
                        <label for="observaciones" class="form-label-modern">
                            <i class="fas fa-comment"></i>
                            Observaciones
                        </label>
                        <textarea wire:model.live="observaciones" id="observaciones" class="form-control-modern" rows="3"
                            placeholder="Observaciones adicionales sobre la inscripción..."></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 ms-auto d-flex flex-column align-items-end gap-2">

                    <div class="checkbox-item-modern">
                        <input type="checkbox" id="acepta_normas_contrato" wire:model.live="acepta_normas_contrato"
                            class="checkbox-modern">

                        <label for="acepta_normas_contrato" class="checkbox-label-modern"
                            style="margin-left: 2px; gap: 0">
                            He leído y acepto
                            <a class="text-primary " style="margin-left: 5px; padding: 0; text-decoration: none;"
                                data-bs-toggle="modal" data-bs-target="#modalContratoConvivencia"
                                title="Ver Detalles">
                                las normas de convivencia
                            </a>
                        </label>
                    </div>
                    @error('acepta_normas_contrato')
                        <div class="invalid-feedback-modern">
                            {{ $message }}

                        </div>
                    @enderror
                </div>
            </div>
        </div>
        @include('admin.transacciones.inscripcion.modales.showContratoModal')

        {{-- Botones de Acción --}}
        <div class="card-modern">
            <div class="card-body-modern" style="padding: 2rem;">
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('admin.transacciones.inscripcion.index') }}" type="button"
                        class="btn-cancel-modern">
                        <i class="fas fa-arrow-left"></i>
                        Cancelar
                    </a>
                    <button type="button" wire:click="finalizar" class="btn-primary-modern"
                        wire:loading.attr="disabled" @if (!$acepta_normas_contrato) disabled @endif>
                        <span wire:loading.remove wire:target="finalizar" @disabled(!empty($documentosFaltantes))>
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
    </div>
</div>







</div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar selectpickers
            $('.selectpicker').selectpicker();

            // Sincronizar alumno con Livewire
            $('#alumno_select').on('changed.bs.select', function() {
                @this.set('alumnoId', $(this).val());
            });

            // Sincronizar padre con Livewire
            $('#padre_select').on('changed.bs.select', function() {
                @this.set('padreId', $(this).val());
            });

            // Sincronizar madre con Livewire
            $('#madre_select').on('changed.bs.select', function() {
                @this.set('madreId', $(this).val());
            });

            // Sincronizar representante legal con Livewire
            $('#representante_legal_select').on('changed.bs.select', function() {
                @this.set('representanteLegalId', $(this).val());
            });
        });

        // Refrescar selectpickers cuando Livewire actualiza
        document.addEventListener('livewire:updated', function() {
            $('.selectpicker').selectpicker('refresh');
        });

        // Resetear selects cuando se limpia el formulario
        Livewire.on('resetSelects', () => {
            $('.selectpicker').val('').selectpicker('refresh');
        });

        //Para mostrar los datos seleccionados de padre
        document.addEventListener('livewire:init', () => {
            $('#padre_select').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
                let value = $(this).val();
                Livewire.dispatch('padreSeleccionadoEvento', {
                    value: value
                });
            });
        });

        //Para mostrar los datos seleccionados de madre
        document.addEventListener('livewire:init', () => {
            $('#madre_select').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
                let value = $(this).val();
                Livewire.dispatch('madreSeleccionadoEvento', {
                    value: value
                });
            });
        });

        //Para mostrar los datos seleccionados de representante legal
        document.addEventListener('livewire:init', () => {
            $('#representante_legal_select').on('changed.bs.select', function(e, clickedIndex, isSelected,
                previousValue) {
                let value = $(this).val();
                Livewire.dispatch('representanteLegalSeleccionadoEvento', {
                    value: value
                });
            });
        });

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('scrollTo', (id) => {
                const el = document.getElementById(id);
                if (el) {
                    el.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    <style>
        .radio-item-modern {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            background: var(--gray-50);
            border-radius: var(--radius);
            transition: all 0.2s ease;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .radio-item-modern:hover {
            background: var(--primary-light);
            border-color: var(--primary);
        }

        .radio-modern {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .radio-label-modern {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            margin: 0 0 0 0.75rem;
            font-size: 0.9rem;
            color: var(--gray-700);
            font-weight: 500;
            user-select: none;
        }

        .radio-label-modern i {
            color: var(--primary);
        }
    </style>
@endpush
