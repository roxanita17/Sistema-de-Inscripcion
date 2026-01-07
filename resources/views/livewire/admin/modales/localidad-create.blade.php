<div>

    <!-- Modal Crear Localidad -->
    <div wire:ignore.self class="modal fade" id="modalCrearLocalidad" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="modalCrearLocalidadLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-modern">

                {{-- Cabecera del modal --}}
                <div class="modal-header-create">
                    <div class="modal-icon-create">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <h5 class="modal-title-create" id="modalCrearLocalidadLabel">Nueva Localidad</h5>

                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- Cuerpo del modal --}}
                <div class="modal-body-create">
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

                    <form wire:submit.prevent="store" id="formCrearLocalidad">

                        {{-- Select del estado --}}
                        <div class="form-group-modern">
                            <label for="estado_id_localidad" class="form-label-modern">
                                <i class="fas fa-tags"></i>
                                Estado
                            </label>
                            <select wire:model.live="estado_id" id="estado_id_localidad"
                                class="form-control-modern @error('estado_id') is-invalid @enderror" required>
                                <option value="">Seleccione un estado</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                                @endforeach
                            </select>
                            @error('estado_id')
                                <div class="invalid-feedback-modern" style="display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Select del municipio --}}
                        <div class="form-group-modern">
                            <label for="municipio_id_localidad" class="form-label-modern">
                                <i class="fas fa-tags"></i>
                                Municipio
                            </label>
                            <select wire:model.live="municipio_id" id="municipio_id_localidad"
                                class="form-control-modern @error('municipio_id') is-invalid @enderror"
                                @disabled(!$estado_id) required>
                                <option value="">Seleccione un municipio</option>
                                @foreach ($municipios as $municipio)
                                    <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
                                @endforeach
                            </select>
                            @error('municipio_id')
                                <div class="invalid-feedback-modern" style="display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Nombre de la Localidad --}}
                        <div class="form-group-modern">
                            <label for="nombre_localidad_crear" class="form-label-modern">
                                <i class="fas fa-map-marker-alt"></i>
                                Nombre de la Localidad
                            </label>
                            <input type="text"
                                class="form-control-modern @error('nombre_localidad') is-invalid @enderror"
                                id="nombre_localidad_crear" wire:model.defer="nombre_localidad" maxlength="100"
                                placeholder="Ingrese el nombre de la localidad" required>
                            @error('nombre_localidad')
                                <div class="invalid-feedback-modern" style="display: block;">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Botones --}}
                        <div class="modal-footer-create">
                            <div class="footer-buttons">
                                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
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
        Livewire.on('cerrarModalCrearLocalidad', () => {
            const modalEl = document.getElementById('modalCrearLocalidad');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        });

        // ✅ AGREGAR ESTO
        Livewire.on('cerrarModalDespuesDe', (data) => {
            setTimeout(() => {
                const modalEl = document.getElementById('modalCrearLocalidad');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }
            }, data[0].delay || 1500);
        });
    });
</script>
@endpush
