<div>
    {{-- TODO EL CONTENIDO DEBE ESTAR DENTRO DE UN SOLO DIV --}}

    {{-- Alertas --}}
    @if (session()->has('success') || session()->has('error'))
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
                    <button type="button" class="alert-close btn-close" data-bs-dismiss="alert" aria-label="Cerrar">
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
                    <button type="button" class="alert-close btn-close" data-bs-dismiss="alert" aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
        </div>
    @endif

    {{-- Card: Búsqueda de Docente --}}
    @if(!$modoEditar)
    <div class="card-modern mb-4">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-search"></i>
                </div>
                <div>
                    <h3>Buscar Docente</h3>
                    <p>Seleccione el docente para asignar materias</p>
                </div>
            </div>
        </div>

 
        <div class="card-body-modern" style="padding: 2rem;">
            <div class="row">
                <div class="col-md-10" wire:ignore>
                    <label for="docente_select" class="form-label-modern">
                        <i class="fas fa-chalkboard-teacher"></i>
                        Docente
                        <span class="required-badge">*</span>
                    </label>
                    
                    <select id="docente_select"
                            class="form-control-modern selectpicker @error('docenteId') is-invalid @enderror"
                            data-live-search="true"
                            data-size="8"
                            data-style="btn-default"
                            data-width="100%"
                            wire:model="docenteId" >
                        <option value="" selected disabled>Seleccione un docente</option>
                        @foreach ($docentes as $docente)
                            @if($docente->detalleEstudios->count() > 0)
                                <option value="{{ $docente->id }}"
                                    data-subtext="{{ $docente->persona->tipo_documento->nombre ?? 'N/A' }}-{{ $docente->persona->numero_documento }}">
                                {{ $docente->nombre_completo }}
                                @if($docente->codigo)
                                    ({{ $docente->codigo }})
                                @endif
                            </option>
                            @endif 
                        @endforeach
                    </select>

                    @error('docenteId')
                        <div class="invalid-feedback-modern" style="display: block;">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="form-text-modern">
                        <i class="fas fa-info-circle"></i>
                        Busque por nombre, apellido o cédula del docente
                    </small>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn-primary-modern w-100"
                            wire:click="seleccionarDocente"
                            wire:loading.attr="disabled"
                            style="margin-bottom: 1.5rem;">
                        <span wire:loading.remove wire:target="seleccionarDocente">
                            <i class="fas fa-check"></i> Seleccionar
                        </span>
                        <span wire:loading wire:target="seleccionarDocente">
                            <i class="fas fa-spinner fa-spin"></i> Cargando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif


    {{-- Card: Información del Docente Seleccionado --}}
    @if($docenteSeleccionado)
    <div class="card-modern" wire:transition>
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon" style="background: linear-gradient(135deg, var(--success), #059669);">
                    <i class="fas fa-user-check"></i>
                </div>
                <div>
                    <h3>Información del Docente</h3>
                    <p>Datos completos del docente seleccionado</p>
                </div>
            </div>
        </div>

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
                                    {{ $docenteSeleccionado->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $docenteSeleccionado->persona->numero_documento }}
                                </span>
                            </div>

                            @if($docenteSeleccionado->codigo)
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-id-card"></i>
                                    Codigo
                                </span>
                                <span class="info-value">
                                    {{ $docenteSeleccionado->codigo }}
                                </span>
                            </div>
                            @endif
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
                                    {{ $docenteSeleccionado->persona->nombreCompleto }}
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-calendar"></i>
                                    Fecha de Nacimiento
                                </span>
                                <span class="info-value">
                                    {{ $docenteSeleccionado->persona->fecha_nacimiento->format('d/m/Y') }}
                                    <span class="text-muted" style="font-size: 0.85rem;">
                                        ({{ $docenteSeleccionado->persona->fecha_nacimiento->age }} años)
                                    </span>
                                </span>
                            </div>
                            @if($docenteSeleccionado->persona->genero)
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-venus-mars"></i>
                                    Genero
                                </span>
                                <span class="info-value">
                                    {{ $docenteSeleccionado->persona->genero->genero }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- COLUMNA DERECHA --}}
                <div class="details-section">

                    {{-- Sección: Contacto --}}
                    <div class="info-section">
                        <div class="section-header">
                            <i class="fas fa-address-book"></i>
                            <h4>Información de Contacto</h4>
                        </div>
                        <div class="info-group">
                            @if($docenteSeleccionado->persona->prefijoTelefono)
                        
                            <div class="info-item">
                            <span class="info-label"> 
                                <i class="fas fa-phone"></i>
                                Teléfono
                            </span>
                            <span class="info-value">
                                @if($docenteSeleccionado->primer_telefono)
                                    {{ $docenteSeleccionado->persona->prefijoTelefono->prefijo }} - {{ $docenteSeleccionado->primer_telefono }}

                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                            @endif
                        </div>


                        <div class="info-group" style="margin-top:1rem">
                            @if($docenteSeleccionado->dependencia)
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-building"></i>
                                    Dependencia
                                </span>
                                <span class="info-value">
                                    {{ $docenteSeleccionado->dependencia ?? 'No asignada' }}
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Sección: Estudios Realizados --}}
                    <div class="info-section">
                        <div class="section-header">
                            <i class="fas fa-graduation-cap"></i>
                            <h4>Estudios Realizados</h4>
                        </div>
                        <div class="info-group">
                            @forelse($docenteSeleccionado->detalleDocenteEstudio as $detalle)
                                @if($detalle->status)
                                <div class="info-item">
                                    <span class="info-label">
                                        <i class="fas fa-certificate"></i>
                                        Título {{ $loop->iteration }}
                                    </span>
                                    <span class="info-value">
                                        <span class="badge-estudio">
                                            {{ $detalle->estudiosRealizado->estudios ?? 'N/A' }}
                                        </span>
                                    </span>
                                </div>
                                @endif
                            @empty
                                <div class="info-item">
                                    <span class="info-value text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        No tiene estudios registrados
                                    </span>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>
                
        </div>
        <br>
    

        <br>

    </div>
    {{-- Formulario para agregar  --}}
    <div class="card-modern mb-4">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <h3>Agregar Estudios Realizados</h3>
                    <p>Seleccione los estudios del docente</p>
                </div>
            </div>
        </div>

        <div class="card-body-modern" style="padding: 2rem;">
            <div class="row">
                <div class="col-md-4" >
                    <label for="estudios_realizados_id" class="form-label-modern">
                        <i class="fas fa-graduation-cap"></i>
                        Materias
                        <span class="required-badge">*</span>
                    </label>

                    {{-- Materias --}}
                    <select id="area_estudio_realizados_id"
                            class="form-control-modern  @error('materiaId') is-invalid @enderror"
                            data-live-search="true"
                            data-size="8"
                            data-style="btn-default"
                            data-width="100%"
                            wire:model="materiaId">
                        <option value="">Seleccione una materia</option>

                        @foreach($materias as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->areaFormacion->nombre_area_formacion ?? 'SIN NOMBRE' }}
                            </option>
                        @endforeach
                        
                    </select>

                    @error('materiaId')
                        <div class="invalid-feedback-modern" style="display: block;">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="form-text-modern">
                        <i class="fas fa-info-circle"></i>
                        Seleccione la materia 
                    </small>
                </div>

                {{-- Grados --}}
                <div class="col-md-4">
                    <label for="grados_id" class="form-label-modern">
                        <i class="fas fa-graduation-cap"></i>
                        Años
                        <span class="required-badge">*</span>
                    </label>

                    <select id="grados_id"
                            class="form-control-modern  @error('gradoId') is-invalid @enderror"
                            data-live-search="true"
                            data-size="8"
                            data-style="btn-default"
                            data-width="100%"
                            wire:model="gradoId">
                        <option value="">Seleccione un año</option>

                        @foreach($grados as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->numero_grado }}
                            </option>
                        @endforeach
                        
                    </select>

                    @error('gradoId')
                        <div class="invalid-feedback-modern" style="display: block;">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="form-text-modern">
                        <i class="fas fa-info-circle"></i>
                        Seleccione el año 
                    </small>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn-primary-modern w-100"
                            wire:click="agregarAsignacion"
                            wire:loading.attr="disabled"
                            style="margin-bottom: 1.5rem;">
                        <span wire:loading.remove wire:target="agregarAsignacion">
                            <i class="fas fa-plus"></i> Agregar Asignación
                        </span>
                        <span wire:loading wire:target="agregarAsignacion">
                            <i class="fas fa-spinner fa-spin"></i> Agregando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de materias y grados asignados --}}
    <div class="card-modern">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h3>Materias y Grados Asignados</h3>
                    <p>{{ $asignaciones->count() }} materias y grados registrados</p>
                </div>
            </div>
            <div class="header-right">
                <div class="date-badge">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ now()->translatedFormat('d M Y') }}</span>
                </div>
            </div>
        </div>

        <div class="card-body-modern">
            <div class="table-wrapper">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th >#</th>
                            <th>Materia</th>
                            <th>Año</th>
                            <th style="text-align: center;">Fecha de Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($asignaciones as $index => $detalle)
                            <tr class="">
                                <td style="text-align: center;">
                                    <span class="number-badge">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div class="cell-content" style="gap: 0.75rem;">
                                        <div style="width: 40px; height: 40px; background: var(--primary-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.2rem; flex-shrink: 0;">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight: 600; color: var(--gray-900); font-size: 0.95rem;">
                                                {{ $detalle->areaEstudios->areaFormacion->nombre_area_formacion ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="cell-content" style="gap: 0.75rem;">
                                        <div style="width: 40px; height: 40px; background: var(--primary-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.2rem; flex-shrink: 0;">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                        <div>
                                            <div style="font-weight: 600; color: var(--gray-900); font-size: 0.95rem;">
                                                {{ $detalle->grado->numero_grado ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td style="text-align: center;">
                                    <span style="color: var(--gray-600); font-size: 0.85rem;">
                                        <i class="fas fa-calendar-alt text-primary me-1"></i>
                                        {{ $detalle->created_at->format('d/m/Y') }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <div class="action-buttons">
                                        <button class="action-btn btn-delete"
                                                wire:click="$set('asignacionAEliminar', {{ $detalle->id }})"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEliminarAsignacion"
                                                title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        
                        @endforeach
                        
                    </tbody>
                </table>
                <!-- MODAL ELIMINAR ASIGNACIÓN -->
                <div wire:ignore.self class="modal fade" id="modalEliminarAsignacion" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content modal-modern">

                            <div class="modal-header-delete">
                                <div class="modal-icon-delete">
                                    <i class="fas fa-trash-alt"></i>
                                </div>
                                <h5 class="modal-title-delete">Confirmar Eliminación</h5>
                                <button type="button" class="btn-close-modal" data-bs-dismiss="modal">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <div class="modal-body-delete">
                                <p>¿Deseas eliminar esta asignación?</p>

                                <p class="delete-warning">
                                    Esta acción es irreversible.
                                </p>
                            </div>

                            <div class="modal-footer-delete">
                                <div class="footer-buttons">
                                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                        Cancelar
                                    </button>

                                    <button class="btn-modal-delete"
                                            wire:click="eliminarAsignacion({{ $asignacionAEliminar }})"
                                            wire:loading.attr="disabled"
                                            data-bs-dismiss="modal">
                                        <span wire:loading.remove wire:target="eliminarAsignacion">
                                            Eliminar
                                        </span>
                                        <span wire:loading wire:target="eliminarAsignacion">
                                            <i class="fas fa-spinner fa-spin"></i>
                                            Eliminando...
                                        </span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                
            </div>
        </div>
        <br>

    </div>
    @endif



    @section('js')
        <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Inicializar selectpicker
            $('.selectpicker').selectpicker();

            // Enviar cambios a Livewire
            $('#docente_select').on('changed.bs.select', function () {
                @this.set('docenteId', $(this).val());
            });

            $('#area_estudio_realizados_id').on('changed.bs.select', function () {
                @this.set('materiaId', $(this).val());
            });

        });

        // Refrescar selectpicker cuando Livewire actualice el DOM
        document.addEventListener('livewire:updated', () => {
            $('.selectpicker').selectpicker('refresh');
        });

        // Reset select desde Livewire
        Livewire.on('resetSelect', () => {
            $('#docente_select').val('').selectpicker('refresh');
        });

        // Auto-cerrar alertas
        setTimeout(function() {
            $('.alert-modern').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
        </script>
@endsection


</div>
