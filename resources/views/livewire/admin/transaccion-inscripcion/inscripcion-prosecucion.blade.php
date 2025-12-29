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
            @if ($alumnoSeleccionado)
                <div class="header-right">
                    <span class="badge bg-success">
                        <i class="fas fa-check-circle"></i> Seleccionado
                    </span>
                </div>
            @endif
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
                            <option value="{{ $alumno->id }}"
                                data-subtext="{{ $alumno->persona->tipoDocumento->nombre ?? '' }}-{{ $alumno->persona->numero_documento }}">
                                {{ $alumno->persona->primer_nombre }}
                                {{ $alumno->persona->primer_apellido }}
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
                <div class="alert alert-info mt-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-info-circle fa-2x"></i>
                        <div>
                            <strong>Grado cursado:</strong>
                            {{ $grados->firstWhere('id', $gradoAnteriorId)?->numero_grado }}° Grado
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
                <div class="header-right">


                    <span class="badge bg-primary">
                        {{ $pendientesActuales }} pendiente(s)
                    </span>
                </div>
            </div>

            <div class="card-body-modern" style="padding: 2rem;">
                @if (count($materias) > 0)
                    {{-- Advertencia de materias pendientes --}}
                    @if ($pendientesActuales >= 4)
                        <div class="alert alert-danger mb-3">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Atención:</strong> Con 4 o más materias pendientes el estudiante debe repetir el
                            mismo grado.
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
                                    El estudiante tiene materias reprobadas de grados anteriores. Debe aprobarlas todas;
                                    de lo contrario, deberá repetir el grado completo.
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
                                                            <i class="fas fa-tag"></i> Código: {{ $materia['codigo'] }}
                                                            |
                                                            <i class="fas fa-layer-group"></i> Grado:
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
                                    <h5 class="mb-0">Materias del Grado Actual</h5>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle"></i>
                                    Marque las materias del grado cursado que quedaron pendientes por aprobar.
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
                                                            <i class="fas fa-layer-group"></i> Grado:
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
                        <h3>Paso 3: Grado y Sección</h3>
                        <p>Seleccione el grado al que será promovido el estudiante</p>
                    </div>
                </div>
                @if ($repite_grado)
                    <div class="header-right">
                        <span class="badge bg-danger">
                            <i class="fas fa-redo"></i> Repite Grado
                        </span>
                    </div>
                @endif
            </div>

            <div class="card-body-modern" style="padding: 2rem;">
                <div class="row">
                    {{-- Grado de Promoción --}}
                    <div class="col-md-4">
                        <label for="grado_promocion" class="form-label-modern">
                            <i class="fas fa-layer-group"></i>
                            Grado de Promoción
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model.live="gradoPromocionId" id="grado_promocion"
                            class="form-control-modern @error('gradoPromocionId') is-invalid @enderror">

                            <option value="">Seleccione un grado</option>

                            @foreach ($grados as $grado)
                                <option value="{{ $grado->id }}">
                                    {{ $grado->numero_grado }}° Grado
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
                                El estudiante debe repetir el mismo grado
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
                        <textarea wire:model.defer="observaciones" id="observaciones"
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
