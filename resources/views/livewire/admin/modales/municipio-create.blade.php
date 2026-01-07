<div>
    <div wire:ignore.self class="modal fade" id="modalCrearMunicipio" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-modern">

                {{-- Header --}}
                <div class="modal-header-create">
                    <div class="modal-icon-create">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <h5 class="modal-title-create">Nuevo Municipio</h5>

                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- Body --}}
                <div class="modal-body-create">

                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form wire:submit.prevent="store">

                        {{-- País --}}
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-globe"></i> País
                            </label>
                            <select wire:model.live="pais_id"
                                class="form-control-modern @error('pais_id') is-invalid @enderror" required>
                                <option value="">Seleccione un país</option>
                                @foreach ($paises as $pais)
                                    <option value="{{ $pais->id }}">{{ $pais->nameES }}</option>
                                @endforeach
                            </select>
                            @error('pais_id')
                                <div class="invalid-feedback-modern">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Estado --}}
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-tags"></i> Estado
                            </label>
                            <select wire:model.live="estado_id"
                                class="form-control-modern @error('estado_id') is-invalid @enderror"
                                @disabled(!$pais_id) required>
                                <option value="">Seleccione un estado</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                                @endforeach
                            </select>
                            @error('estado_id')
                                <div class="invalid-feedback-modern">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nombre --}}
                        <div class="form-group-modern">
                            <label class="form-label-modern">
                                <i class="fas fa-map-marker-alt"></i> Nombre del Municipio
                            </label>
                            <input type="text"
                                wire:model.defer="nombre_municipio"
                                class="form-control-modern @error('nombre_municipio') is-invalid @enderror"
                                placeholder="Ingrese el nombre del municipio" required>
                            @error('nombre_municipio')
                                <div class="invalid-feedback-modern">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Footer --}}
                        <div class="modal-footer-create">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                Cancelar
                            </button>
                            <button type="submit" class="btn-modal-create">
                                <i class="fas fa-save"></i> Guardar
                            </button>
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
            Livewire.on('cerrarModalCrearMunicipio', () => {
                const modalEl = document.getElementById('modalCrearMunicipio');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }
            });

            Livewire.on('cerrarModalDespuesDe', (data) => {
                setTimeout(() => {
                    const modalEl = document.getElementById('modalCrearMunicipio');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) {
                        modal.hide();
                    }
                }, data[0].delay || 1500);
            });
        });
    </script>
@endpush