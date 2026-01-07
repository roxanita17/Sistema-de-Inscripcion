<div>
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
    @if (!$modoEditar)
        <div class="card-modern mb-4">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div>
                        <h3>Buscar Docente</h3>
                        <p>Seleccione el docente para asignarle areas de formacion</p>
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
                            data-live-search="true" data-size="8" data-style="btn-default" data-width="100%"
                            wire:model.live="docenteId">
                            <option value="" selected disabled>Seleccione un docente</option>
                            @foreach ($docentes as $docente)
                                @if ($docente->detalleEstudios->count() > 0)
                                    <option value="{{ $docente->id }}"
                                        data-subtext="{{ $docente->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $docente->persona->numero_documento }}">
                                        {{ $docente->nombre_completo }}
                                        @if ($docente->codigo)
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

                </div>
            </div>
        </div>
    @endif

    @if ($docenteSeleccionado)
        <div class="card-modern mb-4">
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
                    <div class="details-section">
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
                                @if ($docenteSeleccionado->codigo)
                                    <div class="info-item">
                                        <span class="info-label">
                                            <i class="fas fa-barcode"></i>
                                            Código
                                        </span>
                                        <span class="info-value">
                                            {{ $docenteSeleccionado->codigo }}
                                        </span>
                                    </div>
                                @endif
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
                                @if ($docenteSeleccionado->persona->genero)
                                    <div class="info-item">
                                        <span class="info-label">
                                            <i class="fas fa-venus-mars"></i>
                                            Género
                                        </span>
                                        <span class="info-value">
                                            {{ $docenteSeleccionado->persona->genero->genero }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="details-section">
                        <div class="info-section">
                            <div class="section-header">
                                <i class="fas fa-address-book"></i>
                                <h4>Información de Contacto</h4>
                            </div>
                            <div class="info-group">
                                @if (!empty($docenteSeleccionado->persona->telefono_completo))
                                    <div class="info-item">
                                        <span class="info-label">
                                            <i class="fas fa-phone"></i>
                                            Teléfono
                                        </span>
                                        <span class="info-value">
                                            {{ $docenteSeleccionado->persona->telefono_completo }}
                                        </span>
                                    </div>
                                @endif
                                @if ($docenteSeleccionado->persona->telefono_dos_completo)
                                    <div class="info-item">
                                        <span class="info-label">
                                            <i class="fas fa-phone"></i>
                                            Teléfono 2
                                        </span>
                                        <span class="info-value">
                                            {{ $docenteSeleccionado->persona->telefono_dos_completo }}
                                        </span>
                                    </div>
                                @endif
                                @if ($docenteSeleccionado->dependencia)
                                    <div class="info-item">
                                        <span class="info-label">
                                            <i class="fas fa-building"></i>
                                            Dependencia
                                        </span>
                                        <span class="info-value">
                                            {{ $docenteSeleccionado->dependencia }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="info-section">
                            <div class="section-header">
                                <i class="fas fa-graduation-cap"></i>
                                <h4>Estudios Realizados</h4>
                            </div>
                            <div class="info-group">
                                @forelse($docenteSeleccionado->detalleDocenteEstudio as $detalle)
                                    @if ($detalle->status)
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
        </div>
        <div class="card-modern mb-4">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div>
                        <h3>Agregar Nueva Asignación</h3>
                        <p>Asigne areas de formacion, niveles academicos y secciones al docente</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern" style="padding: 2rem;">
                <div class="row">
                    <div class="col-md-4">
                        <label for="materia_select" class="form-label-modern">
                            <i class="fas fa-book"></i>
                            Area de Formacion
                            <span class="required-badge">*</span>
                        </label>

                        <select wire:model.live="materiaId" id="materia_select"
                            class="form-control-modern @error('materiaId') is-invalid @enderror">
                            <option value="">Seleccione un area de formacion</option>
                            @foreach ($materias as $materia)
                                <option value="{{ $materia->id }}">
                                    {{ $materia->areaFormacion->nombre_area_formacion }}
                                </option>
                            @endforeach
                        </select>

                        @error('materiaId')
                            <div class="invalid-feedback-modern" style="display: block;">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="grado_select" class="form-label-modern">
                            <i class="fas fa-layer-group"></i>
                            Nivel Academico
                            <span class="required-badge">*</span>
                        </label>
                        <select wire:model.live="gradoId" id="grado_select"
                            class="form-control-modern @error('gradoId') is-invalid @enderror"
                            {{ !$materiaId ? 'disabled' : '' }}>
                            <option value="">
                                @if (!$materiaId)
                                    Primero seleccione un area de formacion
                                @elseif($grados->isEmpty())
                                    No hay niveles academicos disponibles
                                @else
                                    Seleccione un nivel academico
                                @endif
                            </option>
                            @foreach ($grados as $grado)
                                <option value="{{ $grado->id }}">
                                    {{ $grado->numero_grado }}
                                </option>
                            @endforeach
                        </select>

                        @error('gradoId')
                            <div class="invalid-feedback-modern" style="display: block;">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Secciones --}}
                    <div class="col-md-3">
                        <label for="seccion_select" class="form-label-modern">
                            <i class="fas fa-users"></i>
                            Sección
                            <span class="required-badge">*</span>
                        </label>

                        <select wire:model.live="seccionId" id="seccion_select"
                            class="form-control-modern @error('seccionId') is-invalid @enderror"
                            {{ !$gradoId ? 'disabled' : '' }}>
                            <option value="">
                                @if (!$gradoId)
                                    Primero seleccione un nivel academico
                                @elseif($secciones->isEmpty())
                                    No hay secciones disponibles
                                @else
                                    Seleccione una sección
                                @endif
                            </option>
                            @foreach ($secciones as $seccion)
                                <option value="{{ $seccion->id }}">
                                    Sección {{ $seccion->nombre }}
                                </option>
                            @endforeach
                        </select>

                        @error('seccionId')
                            <div class="invalid-feedback-modern" style="display: block;">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Botón Agregar --}}
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn-primary-modern w-100" wire:click="agregarAsignacion"
                            wire:loading.attr="disabled" style="margin-bottom: 0rem;" @disabled(!$this->puedeAgregarAsignacion)
                            title="{{ !$this->puedeAgregarAsignacion ? 'Seleccione materia, año y sección' : '' }}">
                            <span wire:loading.remove wire:target="agregarAsignacion">
                                <i class="fas fa-plus"></i> Agregar
                            </span>
                            <span wire:loading wire:target="agregarAsignacion">
                                <i class="fas fa-spinner fa-spin"></i> Agregando...
                            </span>
                        </button>
                    </div>
                    
                </div>
                <small class="form-text-modern" style="margin-top: 0.5rem; color: var(--gray-500);  ">
                    <i class="fas fa-info-circle"></i>
                    Si no hay asignaciones de areas de formacion y estudios para el docente puede agregar una
                    <a class="text-primary" data-bs-toggle="modal"
                        data-bs-target="#modalCrearAsignacion">"aquí"</a>
                </small>
            </div>
        </div>

        <div class="card-modern">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-list-check"></i>
                    </div>
                    <div>
                        <h3>Areas de Formacion y Niveles Academicos Asignados</h3>
                        <p>{{ $asignaciones->count() }} asignaciones registradas</p>
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
                                <th style="text-align: center; vertical-align: middle;">#</th>
                                <th style="text-align: center; vertical-align: middle;">Area de formacion</th>
                                <th style="text-align: center; vertical-align: middle;">Nivel academico</th>
                                <th style="text-align: center; vertical-align: middle;">Sección</th>
                                <th style="text-align: center; vertical-align: middle;">Fecha de Registro</th>
                                <th style="text-align: center; vertical-align: middle;">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($asignaciones as $index => $detalle)
                                <tr>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <span class="number-badge">{{ $index + 1 }}</span>
                                    </td>

                                    <td style="text-align: center; vertical-align: middle;">
                                        <div
                                            style="display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                                            <div
                                                style="width: 40px; height: 40px; background: var(--primary-light); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.2rem;">
                                                <i class="fas fa-book"></i>
                                            </div>
                                            <div style="font-weight: 600; color: var(--gray-900); font-size: 0.95rem;">
                                                {{ $detalle->areaEstudios->areaFormacion->nombre_area_formacion ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </td>

                                    <td style="text-align: center; vertical-align: middle;">
                                        <div style="font-weight: 600; color: var(--gray-900); font-size: 0.95rem;">
                                            {{ $detalle->grado->numero_grado ?? 'N/A' }}
                                        </div>
                                    </td>

                                    <td style="text-align: center; vertical-align: middle;">
                                        <div style="font-weight: 600; color: var(--gray-900); font-size: 0.95rem;">
                                            {{ $detalle->seccion->nombre ?? 'N/A' }}
                                        </div>
                                    </td>

                                    <td style="text-align: center; vertical-align: middle;">
                                        <span style="color: var(--gray-600); font-size: 0.85rem;">
                                            <i class="fas fa-calendar-alt text-primary me-1"></i>
                                            {{ $detalle->created_at->format('d/m/Y') }}
                                        </span>
                                    </td>

                                    <td style="text-align: center; vertical-align: middle;">
                                        <div style="display: flex; justify-content: center;">
                                            <button class="action-btn btn-delete"
                                                wire:click="$set('asignacionAEliminar', {{ $detalle->id }})"
                                                data-bs-toggle="modal" data-bs-target="#modalEliminarAsignacion"
                                                title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 3rem;">
                                        <i class="fas fa-inbox"
                                            style="font-size: 3rem; color: var(--gray-400); margin-bottom: 1rem;"></i>
                                        <p style="color: var(--gray-600); font-size: 1.1rem; margin: 0;">
                                            No hay asignaciones registradas
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                        <p class="delete-warning">Esta acción es irreversible.</p>
                    </div>
                    <div class="modal-footer-delete">
                        <div class="footer-buttons">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                Cancelar
                            </button>
                            <button class="btn-modal-delete"
                                wire:click="eliminarAsignacion({{ $asignacionAEliminar }})"
                                wire:loading.attr="disabled" data-bs-dismiss="modal">
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
        @livewire('admin.modales.area-estudio-create')

    @endif

    @section('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                $('.selectpicker').selectpicker();

                $('#docente_select').on('changed.bs.select', function() {
                    @this.set('docenteId', $(this).val());
                });

                $('#area_estudio_realizados_id').on('changed.bs.select', function() {
                    @this.set('materiaId', $(this).val());
                });

            });

            document.addEventListener('livewire:updated', () => {
                $('.selectpicker').selectpicker('refresh');
            });

            Livewire.on('resetSelects', () => {
                $('.selectpicker').val('').selectpicker('refresh');
            });

            setTimeout(function() {
                $('.alert-modern').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        </script>
    @endsection
</div>
