<div>
    {{-- Alertas al inicio (estilo año escolar) --}}
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

    {{-- Formulario para agregar estudios --}}
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
                <div class="col-md-8" wire:ignore>
                    <label for="estudios_realizados_id" class="form-label-modern">
                        <i class="fas fa-graduation-cap"></i>
                        Estudios Realizados
                        <span class="required-badge">*</span>
                    </label>

                    <select id="estudios_realizados_id"
                            class="form-control-modern selectpicker @error('estudiosId') is-invalid @enderror"
                            data-live-search="true"
                            data-size="8"
                            data-style="btn-default"
                            data-width="100%"
                            wire:model="estudiosId">
                        <option value="">Seleccione un estudio</option>
                        @foreach ($estudios as $titulo)
                            <option value="{{ $titulo->id }}">{{ $titulo->estudios }}</option>
                        @endforeach
                    </select>

                    @error('estudiosId')
                        <div class="invalid-feedback-modern" style="display: block;">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="form-text-modern">
                        <i class="fas fa-info-circle"></i>
                        Seleccione el título académico del docente
                    </small>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn-primary-modern w-100"
                            wire:click="agregarEstudio"
                            wire:loading.attr="disabled"
                            style="margin-bottom: 1.5rem;">
                        <span wire:loading.remove wire:target="agregarEstudio">
                            <i class="fas fa-plus"></i> Agregar Estudio
                        </span>
                        <span wire:loading wire:target="agregarEstudio">
                            <i class="fas fa-spinner fa-spin"></i> Agregando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    

    {{-- Tabla de estudios asignados --}}
    <div class="card-modern">
        <div class="card-header-modern">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <h3>Estudios Asignados</h3>
                    <p>{{ $estudiosAsignados->count() }} estudios registrados</p>
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
                            <th>Estudio Realizado</th>
                            <th style="text-align: center;">Fecha de Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($estudiosAsignados as $index => $detalle)
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
                                                {{ $detalle->estudiosRealizado->estudios ?? 'N/A' }}
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
                                                wire:click="eliminarEstudio({{ $detalle->id }})"
                                                wire:confirm="¿Está seguro de eliminar este estudio?"
                                                wire:loading.attr="disabled"
                                                title="Eliminar">
                                            <span wire:loading.remove wire:target="eliminarEstudio({{ $detalle->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </span>
                                            <span wire:loading wire:target="eliminarEstudio({{ $detalle->id }})">
                                                <i class="fas fa-spinner fa-spin"></i>
                                            </span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">
                                    <div class="empty-state">
                                        
                                        <h4>No hay estudios asignados</h4>
                                        <p>Agregue estudios realizados usando el formulario superior</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        
                    </tbody>
                </table>
                
            </div>
        </div>
        <br>
        <hr>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
                <a type="button" 
                class="btn-create px-4 py-2"
                href="{{ route('admin.docente.index') }}">
                    <i class="fas fa-save"></i> Guardar
                </a>
            </div>
        </div>
        <br>

    </div>
    
    
</div>


@push('scripts')
<script>
    // Inicializar selectpicker
    document.addEventListener('DOMContentLoaded', function() {
        $('.selectpicker').selectpicker();
        
        // Actualizar selectpicker cuando cambie el wire:model
        $('#estudios_realizados_id').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            @this.set('estudiosId', $(this).val());
        });
    });

    // Escuchar evento para resetear el select
    document.addEventListener('livewire:load', function () {
        Livewire.on('resetSelect', () => {
            $('#estudios_realizados_id').val('').selectpicker('refresh');
        });
    });

    // Auto-cerrar alertas después de 5 segundos
    setTimeout(function() {
        $('.alert-modern').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 5000);
</script>
@endpush