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

    {{-- Card: Seleccionar Representantes --}}
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

                        <p><strong>Nombre:</strong> {{ $representanteLegalSeleccionado->representante->persona->primer_nombre }}
                            {{ $representanteLegalSeleccionado->representante->persona->segundo_nombre }}
                            {{ $representanteLegalSeleccionado->representante->persona->primer_apellido }}
                            {{ $representanteLegalSeleccionado->representante->persona->segundo_apellido }}
                        </p>

                        <p><strong>Documento:</strong>
                            {{ $representanteLegalSeleccionado->representante->persona->tipoDocumento->nombre }}
                            - {{ $representanteLegalSeleccionado->representante->persona->numero_documento }}
                        </p>

                        @if ($representanteLegalSeleccionado->representante->ocupacion)
                            <p><strong>Ocupación:</strong> {{ $representanteLegalSeleccionado->representante->ocupacion->nombre_ocupacion }}</p>
                        @endif

                        <p><strong>Género:</strong> {{ $representanteLegalSeleccionado->representante->persona->genero->genero }}</p>

                    </div>
                </div>
            @endif

            <div class="row align-items-center mb-4 mt-4">

                <div class="col-md-9">
                    <div class="alert alert-success d-flex align-items-start p-3 mb-0 shadow-sm" role="alert"
                        style="border-left: 5px solid #0d9006;">
                        <i class="fas fa-exclamation-triangle fa-lg me-3 mt-1"></i>

                        <div class="grow">
                            <strong class="d-block mb-1">Atención</strong>
                            <span class="d-block">Si el representante no existe, puede crearlo ahora.</span>
                        </div>
                    </div>
                </div>

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

    {{-- Card: Formulario de alumno --}}
    <div class="card-body-modern">
        <livewire:admin.alumnos.alumno-create>
    </div>




    {{-- Card: Documentos Entregados --}}
    <div class="card-modern mb-4">
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
            <div class="row">
                @php
                    $colCounter = 0;
                @endphp

                @foreach ([
        'partida_nacimiento' => 'Partida de Nacimiento',
        'copia_cedula_representante' => 'Copia de Cédula del Representante',
        'copia_cedula_estudiante' => 'Copia de Cédula del Estudiante',
        'boletin_6to_grado' => 'Boletín de 6to Grado',
        'certificado_calificaciones' => 'Certificado de Calificaciones',
        'constancia_aprobacion_primaria' => 'Constancia de Aprobación Primaria',
        'foto_estudiante' => 'Fotografía Tipo Carnet Del Estudiante',
        'foto_representante' => 'Fotografía Tipo Carnet Del Representante',
        'carnet_vacunacion' => 'Carnet de Vacunación Vigente',
        'autorizacion_tercero' => 'Autorización Firmada (si inscribe un tercero)',
    ] as $documento => $etiqueta)
                    @if ($colCounter % 10 === 0 && $colCounter !== 0)
            </div>
            <div class="row mt-3">
                @endif

                <div class="col-md-6 mb-3">
                    <div class="checkbox-item-modern">
                        <input type="checkbox" id="{{ $documento }}" wire:model.live="documentos"
                            value="{{ $documento }}" class="checkbox-modern">
                        <label for="{{ $documento }}" class="checkbox-label-modern">
                            <i
                                class="fas fa-{{ $documento === 'carnet_vacunacion' ? 'syringe' : ($documento === 'foto_estudiante' || $documento === 'foto_representante' ? 'camera' : ($documento === 'autorizacion_tercero' ? 'file-signature' : 'file-alt')) }}"></i>
                            {{ $etiqueta }}
                        </label>
                    </div>
                </div>

                @php $colCounter++; @endphp
                @endforeach
            </div>
        </div>
    </div>

    {{-- Card: Datos de la Inscripción --}}
    <div class="card-modern mb-4">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon" style="background: linear-gradient(135deg, var(--warning), #d97706);">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <h3>Datos de la Inscripción</h3>
                    <p>Complete la información requerida</p>
                </div>
            </div>
        </div>
        <div class="card-body-modern" style="padding: 2rem;">
            <div class="row">
                {{-- <div class="col-md-4">
                    <div class="form-group">
                        <label for="grado_id" class="form-label-modern">
                            <i class="fas fa-layer-group"></i>
                            Grado
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model="gradoId" 
                                id="grado_id"
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
                </div> --}}

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fecha_inscripcion" class="form-label-modern">
                            <i class="fas fa-calendar"></i>
                            Fecha de Inscripción
                            <span class="required-badge">*</span>
                        </label>
                        <input type="date" wire:model="fecha_inscripcion" id="fecha_inscripcion"
                            class="form-control-modern @error('fecha_inscripcion') is-invalid @enderror">
                        @error('fecha_inscripcion')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="observaciones" class="form-label-modern">
                                <i class="fas fa-comment"></i>
                                Observaciones
                            </label>
                            <textarea wire:model="observaciones" id="observaciones" class="form-control-modern" rows="3"
                                placeholder="Observaciones adicionales sobre la inscripción..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Botones de Acción --}}
        <div class="card-modern">
            <div class="card-body-modern" style="padding: 2rem;">
                <div class="d-flex justify-content-end gap-3">
                    <button type="button" wire:click="limpiar" class="btn-cancel-modern">
                        <i class="fas fa-broom"></i>
                        Limpiar
                    </button>
                    <button type="button" wire:click="finalizar" class="btn-primary-modern"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="finalizar">
                            <i class="fas fa-save"></i>
                            Guardar Inscripción
                        </span>
                        <span wire:loading wire:target="finalizar">
                            <i class="fas fa-spinner fa-spin"></i>
                            Guardando...
                        </span>
                    </button>
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
            $('#representante_legal_select').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
                let value = $(this).val();
                Livewire.dispatch('representanteLegalSeleccionadoEvento', {
                    value: value
                });
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
