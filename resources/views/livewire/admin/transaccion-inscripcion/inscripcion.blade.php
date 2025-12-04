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

    {{-- Card: Búsqueda de Alumno --}}
    <div class="card-modern mb-4">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div>
                    <h3>Seleccionar Alumno</h3>
                    <p>Busque y seleccione el alumno a inscribir</p>
                </div>
            </div>
        </div>

        <div class="card-body-modern" style="padding: 2rem;">
            <div class="row">
                <div class="col-md-12" wire:ignore>
                    <label for="alumno_select" class="form-label-modern">
                        <i class="fas fa-user-graduate"></i>
                        Alumno
                        <span class="required-badge">*</span>
                    </label>
                    
                    <select id="alumno_select"
                            class="form-control-modern selectpicker"
                            data-live-search="true"
                            data-size="8"
                            data-width="100%">
                        <option value="">Seleccione un alumno</option>
                        @foreach ($alumnos as $alumno)
                            <option value="{{ $alumno['id'] }}"
                                    data-subtext="{{ $alumno['tipo_documento'] }}-{{ $alumno['numero_documento'] }}">
                                {{ $alumno['nombre_completo'] }}
                            </option>
                        @endforeach
                        
                    </select>
                    

                    @error('alumnoId')
                        <div class="invalid-feedback-modern" style="display: block;">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="form-text-modern">
                        <i class="fas fa-info-circle"></i>
                        Busque por nombre, apellido o cédula del alumno
                    </small>
                </div>
                {{-- <div class="col-md-2">
                    <div class="btn-create" style="margin-top: 3rem">
                        <a href="{{ route('admin.transacciones.inscripcion.create') }}"
                            style="display: block; text-align: center;">
                            <i class="fas fa-plus"></i>
                            <span>Nuevo Alumno</span>
                        </a>
                        
                    </div>
                    
                </div> --}}
                
            </div>


            {{-- Información del alumno seleccionado --}}
            @if($alumnoSeleccionado)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="info-card-modern p-4 shadow-sm rounded-3 bg-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="info-icon bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:30px; height:30px;">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <h5 class="mb-0">Datos del Alumno Seleccionado</h5>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-5">
                                    <div class="detail-item p-2">
                                        <div class="detail-label"><i class="fas fa-user"></i> Nombre Completo</div>
                                        <div class="detail-value">
                                            {{ $alumnoSeleccionado->persona->primer_nombre }} 
                                            {{ $alumnoSeleccionado->persona->segundo_nombre ?? '' }} 
                                            {{ $alumnoSeleccionado->persona->primer_apellido }} 
                                            {{ $alumnoSeleccionado->persona->segundo_apellido ?? '' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="detail-item p-2">
                                        <div class="detail-label"><i class="fas fa-id-card"></i> Cedula</div>
                                        <div class="detail-value">
                                            {{ $alumnoSeleccionado->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $alumnoSeleccionado->persona->numero_documento }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="detail-item p-2">
                                        <div class="detail-label"><i class="fas fa-birthday-cake"></i> Edad</div>
                                        <div class="detail-value">
                                            {{ $alumnoSeleccionado->persona->fecha_nacimiento->age ?? 'N/A' }} años
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="detail-item p-2">
                                        <div class="detail-label"><i class="fas fa-venus-mars"></i> Género</div>
                                        <div class="detail-value">
                                            {{ $alumnoSeleccionado->persona->genero->genero ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="detail-item p-2">
                                        <div class="detail-label"><i class="fas fa-calendar-alt"></i> Fecha de Nacimiento</div>
                                        <div class="detail-value">
                                            {{ $alumnoSeleccionado->persona->fecha_nacimiento->format('d/m/Y') ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

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
                    
                    <select id="padre_select"
                            class="form-control-modern selectpicker"
                            data-live-search="true"
                            data-size="8"
                            data-width="100%">
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

            {{-- Madre --}}
            <div class="row mb-3">
                <div class="col-md-12" wire:ignore>
                    <label for="madre_select" class="form-label-modern">
                        <i class="fas fa-female"></i>
                        Madre
                    </label>
                    
                    <select id="madre_select"
                            class="form-control-modern selectpicker"
                            data-live-search="true"
                            data-size="8"
                            data-width="100%">
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

            {{-- Representante Legal --}}
            <div class="row">
                <div class="col-md-12" wire:ignore>
                    <label for="representante_legal_select" class="form-label-modern">
            <i class="fas fa-gavel"></i>
            Representante Legal
        </label>
        
        <select id="representante_legal_select"
                class="form-control-modern selectpicker"
                data-live-search="true"
                data-size="8"
                data-width="100%">
            <option value="">Seleccione un representante legal (opcional)</option>
            @foreach ($representantes as $rep)
                <option value="{{ $rep['id'] }}"
                        data-subtext="{{ $rep['tipo_documento'] }}-{{ $rep['numero_documento'] }}">
                    {{ $rep['nombre_completo'] }}
                </option>
            @endforeach
        </select>
                </div>
            </div>
        </div>
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
                    'autorizacion_tercero' => 'Autorización Firmada (si inscribe un tercero)'
                ] as $documento => $etiqueta)
                    @if($colCounter % 10 === 0 && $colCounter !== 0)
                        </div><div class="row mt-3">
                    @endif

                    <div class="col-md-6 mb-3">
                        <div class="checkbox-item-modern">
                            <input type="checkbox" 
                                id="{{ $documento }}" 
                                wire:model.live="documentos"
                                value="{{ $documento }}"
                                class="checkbox-modern">
                            <label for="{{ $documento }}" class="checkbox-label-modern">
                                <i class="fas fa-{{ $documento === 'carnet_vacunacion' ? 'syringe' : ($documento === 'foto_estudiante' || $documento === 'foto_representante' ? 'camera' : ($documento === 'autorizacion_tercero' ? 'file-signature' : 'file-alt')) }}"></i>
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
                            @foreach($grados as $grado)
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
                        <input type="date" 
                               wire:model="fecha_inscripcion" 
                               id="fecha_inscripcion"
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
                        <textarea wire:model="observaciones" 
                                  id="observaciones"
                                  class="form-control-modern" 
                                  rows="3"
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
                <button type="button" 
                        wire:click="limpiar"
                        class="btn-cancel-modern">
                    <i class="fas fa-broom"></i>
                    Limpiar
                </button>
                <button type="button" 
                        wire:click="registrar" 
                        class="btn-primary-modern"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="registrar">
                        <i class="fas fa-save"></i>
                        Guardar Inscripción
                    </span>
                    <span wire:loading wire:target="registrar">
                        <i class="fas fa-spinner fa-spin"></i>
                        Guardando...
                    </span>
                </button>
            </div>
        </div>
    </div>

</div>


@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Inicializar selectpickers
    $('.selectpicker').selectpicker();

    // Sincronizar alumno con Livewire
    $('#alumno_select').on('changed.bs.select', function () {
        @this.set('alumnoId', $(this).val());
    });

    // Sincronizar padre con Livewire
    $('#padre_select').on('changed.bs.select', function () {
        @this.set('padreId', $(this).val());
    });

    // Sincronizar madre con Livewire
    $('#madre_select').on('changed.bs.select', function () {
        @this.set('madreId', $(this).val());
    });

    // Sincronizar representante legal con Livewire
    $('#representante_legal_select').on('changed.bs.select', function () {
        @this.set('representanteLegalId', $(this).val());
    });
});

// Refrescar selectpickers cuando Livewire actualiza
document.addEventListener('livewire:updated', function () {
    $('.selectpicker').selectpicker('refresh');
});

// Resetear selects cuando se limpia el formulario
Livewire.on('resetSelects', () => {
    $('.selectpicker').val('').selectpicker('refresh');
});
</script>
@endpush

