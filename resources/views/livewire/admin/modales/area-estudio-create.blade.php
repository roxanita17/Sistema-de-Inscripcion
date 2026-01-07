<div>
    <!-- Modal Crear Asignación -->
    <div wire:ignore.self class="modal fade" id="modalCrearAsignacion" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="modalCrearAsignacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-modern">
                <div class="modal-header-create">
                    <div class="modal-icon-create">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <h5 class="modal-title-create" id="modalCrearAsignacionLabel">Nueva Asignación Área-Estudio</h5>
                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="modal-body-create">

                    <form wire:submit.prevent="store" id="formAsignacion">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Select Área de Formación -->
                        <div class="form-group-modern">
                            <label for="area_formacion_id_modal" class="form-label-modern">
                                <i class="fas fa-bookmark"></i>
                                Área de Formación
                            </label>
                            <select wire:model.live="area_formacion_id" id="area_formacion_id_modal"
                                class="form-control-modern @error('area_formacion_id') is-invalid @enderror" required>
                                <option value="">Seleccione un área de formación</option>
                                @foreach ($areas_formacion as $area)
                                    <option value="{{ $area->id }}">{{ $area->nombre_area_formacion }}</option>
                                @endforeach
                            </select>
                            @error('area_formacion_id')
                                <div class="invalid-feedback-modern" style="display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Select Título Universitario -->
                        <div class="form-group-modern">
                            <label for="estudios_id_modal" class="form-label-modern">
                                <i class="fas fa-graduation-cap"></i>
                                Título Universitario
                            </label>
                            <select wire:model.live="estudios_id" id="estudios_id_modal"
                                class="form-control-modern @error('estudios_id') is-invalid @enderror" required>
                                <option value="">Seleccione un título universitario</option>
                                @foreach ($estudios as $titulo)
                                    <option value="{{ $titulo->id }}">{{ $titulo->estudios }}</option>
                                @endforeach
                            </select>
                            @error('estudios_id')
                                <div class="invalid-feedback-modern" style="display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="modal-footer-create">
                            <div class="footer-buttons">
                                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                    <i class="fas fa-times"></i>
                                    Cancelar
                                </button>
                                <button type="submit" class="btn-modal-create" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="store">
                                        <i class="fas fa-save"></i> Guardar
                                    </span>
                                    <span wire:loading wire:target="store">
                                        <i class="fas fa-spinner fa-spin"></i> Guardando...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
document.addEventListener('livewire:init', () => {

    Livewire.on('cerrarModalDespuesDe', (data) => {
        setTimeout(() => {
            const modalEl = document.getElementById('modalCrearAsignacion');
            let modal = bootstrap.Modal.getInstance(modalEl);
            if (!modal) {
                modal = new bootstrap.Modal(modalEl);
            }
            modal.hide();
        }, data.delay || 1500);
    });

});
</script>
@endpush

