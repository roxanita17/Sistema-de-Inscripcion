<div>
    {{-- Alertas --}}
    @if (session()->has('success') || session()->has('error'))
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
        </div>
    @endif


    {{-- Resumen de Estado de Inscripción --}}
    <div class="card-modern mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="card-body-modern" style="padding: 1.5rem;">
            <div class="row text-white">
                <div class="col-md-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-file-alt fa-3x"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-white">Estado Documentos</h6>
                            <h4 class="mb-0 fw-bold">{{ $estadoDocumentos ?: 'Pendiente' }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-user-graduate fa-3x"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-white">Estado Inscripción</h6>
                            <h4 class="mb-0 fw-bold">{{ $statusInscripcion ?: 'Pendiente' }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-clipboard-check fa-3x"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-white">Documentos Entregados</h6>
                            <h4 class="mb-0 fw-bold">{{ count($documentos) }} / {{ count($documentosDisponibles) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Datos del Alumno --}}
    <div class="card-modern mb-4">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon" style="background: linear-gradient(135deg, var(--info), #0284c7);">
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

    {{-- Seleccionar Representantes --}}
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
            {{-- Padre --}}
            <div class="row mb-3">
                <div class="col-md-12" wire:ignore>
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
            </div>

            @if ($padreSeleccionado)
                <div class="card mt-3 mb-4">
                    <div class="card-body">

                        <h5>Datos del Padre</h5>

                        <p><strong>Nombre completo:</strong>
                            {{ $padreSeleccionado->persona->primer_nombre }}
                            {{ $padreSeleccionado->persona->segundo_nombre }}
                            {{ $padreSeleccionado->persona->tercer_nombre }}
                            {{ $padreSeleccionado->persona->primer_apellido }}
                            {{ $padreSeleccionado->persona->segundo_apellido }}
                        </p>

                        <p><strong>Documento:</strong>
                            {{ $padreSeleccionado->persona->tipoDocumento->nombre ?? 'N/A' }} -
                            {{ $padreSeleccionado->persona->numero_documento }}
                        </p>

                        <p><strong>Género:</strong>
                            {{ $padreSeleccionado->persona->genero->genero ?? 'N/A' }}
                        </p>

                        <p><strong>Teléfono:</strong>
                            {{ $padreSeleccionado->persona->telefono ?? 'N/A' }}
                        </p>

                        <p><strong>Email:</strong>
                            {{ $padreSeleccionado->persona->email ?? 'N/A' }}
                        </p>

                        <p><strong>Ocupación:</strong>
                            {{ $padreSeleccionado->ocupacion->nombre_ocupacion ?? 'N/A' }}
                        </p>

                        <p><strong>Estado:</strong>
                            {{ $padreSeleccionado->estado->nombre_estado ?? 'N/A' }}
                        </p>

                        <p><strong>Municipio:</strong>
                            {{ $padreSeleccionado->municipios->nombre_municipio ?? 'N/A' }}
                        </p>

                        <p><strong>Localidad / Parroquia:</strong>
                            {{ $padreSeleccionado->localidads->nombre_localidad ?? 'N/A' }}
                        </p>

                        <p><strong>Convive con el estudiante:</strong>
                            {{ $padreSeleccionado->convivenciaestudiante_representante ? 'Sí' : 'No' }}
                        </p>

                    </div>
                </div>
            @endif


            {{-- Madre --}}
            <div class="row mb-3">
                <div class="col-md-12" wire:ignore>
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
            </div>

            @if ($madreSeleccionado)
                <div class="card mt-3 mb-4">
                    <div class="card-body">

                        <h5>Datos de la Madre</h5>

                        <p><strong>Nombre completo:</strong>
                            {{ $madreSeleccionado->persona->primer_nombre }}
                            {{ $madreSeleccionado->persona->segundo_nombre }}
                            {{ $madreSeleccionado->persona->tercer_nombre }}
                            {{ $madreSeleccionado->persona->primer_apellido }}
                            {{ $madreSeleccionado->persona->segundo_apellido }}
                        </p>

                        <p><strong>Documento:</strong>
                            {{ $madreSeleccionado->persona->tipoDocumento->nombre ?? 'N/A' }} -
                            {{ $madreSeleccionado->persona->numero_documento }}
                        </p>

                        <p><strong>Género:</strong>
                            {{ $madreSeleccionado->persona->genero->genero ?? 'N/A' }}
                        </p>

                        <p><strong>Teléfono:</strong>
                            {{ $madreSeleccionado->persona->telefono ?? 'N/A' }}
                        </p>

                        <p><strong>Email:</strong>
                            {{ $madreSeleccionado->persona->email ?? 'N/A' }}
                        </p>

                        <p><strong>Ocupación:</strong>
                            {{ $madreSeleccionado->ocupacion->nombre_ocupacion ?? 'N/A' }}
                        </p>

                        <p><strong>Estado:</strong>
                            {{ $madreSeleccionado->estado->nombre_estado ?? 'N/A' }}
                        </p>

                        <p><strong>Municipio:</strong>
                            {{ $madreSeleccionado->municipios->nombre_municipio ?? 'N/A' }}
                        </p>

                        <p><strong>Localidad / Parroquia:</strong>
                            {{ $madreSeleccionado->localidads->nombre_localidad ?? 'N/A' }}
                        </p>

                        <p><strong>Convive con el estudiante:</strong>
                            {{ $madreSeleccionado->convivenciaestudiante_representante ? 'Sí' : 'No' }}
                        </p>
                    </div>
                </div>
            @endif


            {{-- Representante Legal --}}
            <div class="row">
                <div class="col-md-12" wire:ignore>
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
            </div>
            @error('representanteLegalId')
                <div class="invalid-feedback-modern">
                    {{ $message }}
                </div>
            @enderror

            @if ($representanteLegalSeleccionado)
                <div class="card mt-3 mb-4">
                    <div class="card-body">

                        <h5>Datos del Representante Legal</h5>

                        {{-- Datos personales --}}
                        <p><strong>Nombre completo:</strong>
                            {{ $representanteLegalSeleccionado->representante->persona->primer_nombre }}
                            {{ $representanteLegalSeleccionado->representante->persona->segundo_nombre }}
                            {{ $representanteLegalSeleccionado->representante->persona->tercer_nombre }}
                            {{ $representanteLegalSeleccionado->representante->persona->primer_apellido }}
                            {{ $representanteLegalSeleccionado->representante->persona->segundo_apellido }}
                        </p>

                        <p><strong>Documento:</strong>
                            {{ $representanteLegalSeleccionado->representante->persona->tipoDocumento->nombre ?? 'N/A' }}
                            -
                            {{ $representanteLegalSeleccionado->representante->persona->numero_documento }}
                        </p>

                        <p><strong>Género:</strong>
                            {{ $representanteLegalSeleccionado->representante->persona->genero->genero ?? 'N/A' }}
                        </p>

                        <p><strong>Teléfono:</strong>
                            {{ $representanteLegalSeleccionado->representante->persona->telefono ?? 'N/A' }}
                        </p>

                        <p><strong>Email:</strong>
                            {{ $representanteLegalSeleccionado->representante->persona->email ?? 'N/A' }}
                        </p>

                        {{-- Datos del representante --}}
                        <p><strong>Ocupación:</strong>
                            {{ $representanteLegalSeleccionado->representante->ocupacion->nombre_ocupacion ?? 'N/A' }}
                        </p>

                        <p><strong>Estado:</strong>
                            {{ $representanteLegalSeleccionado->representante->estado->nombre_estado ?? 'N/A' }}
                        </p>

                        <p><strong>Municipio:</strong>
                            {{ $representanteLegalSeleccionado->representante->municipios->nombre_municipio ?? 'N/A' }}
                        </p>

                        <p><strong>Localidad / Parroquia:</strong>
                            {{ $representanteLegalSeleccionado->representante->localidads->nombre_localidad ?? 'N/A' }}
                        </p>

                        <p><strong>Convive con el estudiante:</strong>
                            {{ $representanteLegalSeleccionado->representante->convivenciaestudiante_representante ? 'Sí' : 'No' }}
                        </p>

                        <p><strong>Status:</strong>
                            {{ $representanteLegalSeleccionado->representante->status ? 'Activo' : 'Inactivo' }}
                        </p>

                        {{-- Datos legales --}}
                        <hr>

                        <p><strong>Parentesco:</strong>
                            {{ $representanteLegalSeleccionado->parentesco ?? 'N/A' }}
                        </p>

                        <p><strong>Correo representante:</strong>
                            {{ $representanteLegalSeleccionado->correo_representante ?? 'N/A' }}
                        </p>

                        <p><strong>Pertenece a organización:</strong>
                            {{ $representanteLegalSeleccionado->pertenece_a_organizacion_representante ? 'Sí' : 'No' }}
                        </p>

                        <p><strong>Organización:</strong>
                            {{ $representanteLegalSeleccionado->cual_organizacion_representante ?? 'N/A' }}
                        </p>

                        <p><strong>Carnet de la Patria:</strong>
                            {{ $representanteLegalSeleccionado->carnet_patria_afiliado ? 'Sí' : 'No' }}
                        </p>

                        <p><strong>Serial Carnet Patria:</strong>
                            {{ $representanteLegalSeleccionado->serial_carnet_patria_representante ?? 'N/A' }}
                        </p>

                        <p><strong>Banco:</strong>
                            {{ $representanteLegalSeleccionado->banco->nombre_banco ?? 'N/A' }}
                        </p>

                        <p><strong>Tipo de Cuenta:</strong>
                            {{ $representanteLegalSeleccionado->tipo_cuenta ?? 'N/A' }}
                        </p>

                        <p><strong>Código Carnet Patria:</strong>
                            {{ $representanteLegalSeleccionado->codigo_carnet_patria_representante ?? 'N/A' }}
                        </p>

                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- Datos de Grado y Procedencia --}}
    <div class="card-modern mb-4">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon" style="background: linear-gradient(135deg, var(--warning), #d97706);">
                    <i class="fas fa-school"></i>
                </div>
                <div>
                    <h3>Grado y Procedencia</h3>
                    <p>Información del grado e institución de procedencia</p>
                </div>
            </div>
        </div>
        <div class="card-body-modern" style="padding: 2rem;">
            <div class="row">
                <div class="col-md-4">
                    <label for="grado_id" class="form-label-modern">
                        <i class="fas fa-layer-group"></i> Grado
                    </label>
                    <select wire:model.live="gradoId"
                        class="form-control-modern @error('gradoId') is-invalid @enderror">
                        <option value="">Seleccione un grado</option>
                        @foreach ($grados as $grado)
                            <option value="{{ $grado->id }}">{{ $grado->numero_grado }}° Grado</option>
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
                    </div>
                    @error('seccionId')
                        <div class="invalid-feedback-modern">
                            {{ $message }}
                        </div>
                    @enderror
                @endif

                @if ($esPrimerGrado)
                    <div class="col-md-4">
                        <label class="form-label-modern">
                            <i class="fas fa-hashtag"></i> Número de Zonificación
                        </label>
                        <input type="text" wire:model.live="numero_zonificacion"
                            class="form-control-modern @error('numero_zonificacion') is-invalid @enderror"
                            maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g,'')"
                            inputmode="numeric">
                    </div>
                @endif
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label class="form-label-modern">
                        <i class="fas fa-building"></i> Institución de Procedencia
                    </label>
                    <select wire:model.live="institucion_procedencia_id"
                        class="form-control-modern @error('institucion_procedencia_id') is-invalid @enderror">
                        <option value="">Seleccione</option>
                        @foreach ($instituciones as $inst)
                            <option value="{{ $inst->id }}">{{ $inst->nombre_institucion }}</option>
                        @endforeach
                    </select>
                    @error('institucion_procedencia_id')
                        <div class="invalid-feedback-modern">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <label class="form-label-modern">
                        <i class="fas fa-font"></i> Literal
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

                <div class="col-md-3">
                    <label class="form-label-modern">
                        <i class="fas fa-calendar"></i> Año de Egreso
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

    {{-- Documentos y Observaciones --}}
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
            {{-- Seleccionar todos --}}
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

            {{-- Lista de documentos --}}
            <div class="row">
                @php
                    $colCounter = 0;
                @endphp

                @foreach ($documentosEtiquetas as $documento => $etiqueta)
                    @php
                        // Saltar documentos que no aplican para primer grado
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

            {{-- Información sobre documentos faltantes --}}
            @if (!empty($documentosFaltantes))
                <div class="alert alert-warning mt-3">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-2"><strong>Documentos Pendientes:</strong></h6>
                            <ul class="mb-0">
                                @foreach ($documentosFaltantes as $faltante)
                                    <li>{{ $documentosEtiquetas[$faltante] ?? $faltante }}</li>
                                @endforeach
                            </ul>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-info-circle"></i>
                                La inscripción se actualizará a estado "{{ $statusInscripcion }}" con documentos
                                "{{ $estadoDocumentos }}"
                            </small>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-success mt-3">
                    <i class="fas fa-check-circle"></i>
                    <strong>¡Todos los documentos están completos!</strong>
                    La inscripción se actualizará a estado "Activo".
                </div>
            @endif

            {{-- Observaciones --}}
            <div class="row mt-4">
                <div class="col-12">
                    <label class="form-label-modern">
                        <i class="fas fa-comment"></i> Observaciones
                    </label>
                    <textarea wire:model="observaciones" class="form-control-modern" rows="3"
                        placeholder="Observaciones adicionales sobre la inscripción..."></textarea>
                </div>
            </div>
        </div>
    </div>
    @include('admin.transacciones.inscripcion.modales.showContratoModal')


    {{-- Botones de Acción --}}
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

    <style>
        .checkbox-item-modern {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            background: var(--gray-50);
            border-radius: var(--radius);
            transition: all 0.2s ease;
            border: 2px solid transparent;
        }

        .checkbox-item-modern:hover {
            background: var(--primary-light);
            border-color: var(--primary);
        }

        .checkbox-item-modern.checkbox-warning {
            background: #fef3c7;
            border-color: #fbbf24;
        }

        .checkbox-item-modern.checkbox-warning:hover {
            background: #fde68a;
        }

        .checkbox-modern {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--primary);
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
            flex: 1;
        }

        .checkbox-label-modern.text-warning {
            color: #d97706;
        }
    </style>
@endpush
