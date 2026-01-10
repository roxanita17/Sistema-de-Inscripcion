<div>
    <!-- Modal Crear Institución de Procedencia -->
    <div wire:ignore.self class="modal fade" id="modalCrearInstitucionInscripcion" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearInstitucionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-modern">

                {{-- Cabecera del modal --}}
                <div class="modal-header-create">
                    <div class="modal-icon-create">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <h5 class="modal-title-create" id="modalCrearInstitucionLabel">Nueva Institución de Procedencia</h5>

                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- Cuerpo del modal --}}
                <div class="modal-body-create">
                    <form wire:submit.prevent="store" id="formCrearInstitucionProcedencia">
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

                        {{-- Select País --}}
                        <div class="form-group-modern">
                            <label for="pais_id_modal" class="form-label-modern">
                                <i class="fas fa-globe"></i>
                                País
                            </label>
                            <select wire:model.live="pais_id" id="pais_id_modal" class="form-control-modern" required>
                                <option value="">Seleccione un país</option>
                                @foreach ($paises as $pais)
                                    <option value="{{ $pais->id }}">{{ $pais->nameES }}</option>
                                @endforeach
                            </select>

                            @error('pais_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Select Estado --}}
                        <div class="form-group-modern">
                            <label for="estado_id_modal" class="form-label-modern">
                                <i class="fas fa-tags"></i>
                                Estado
                            </label>
                            <select name="estado_id" wire:model.live="estado_id" id="estado_id_modal"
                                class="form-control-modern" required>
                                <option value="">Seleccione un estado</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                                @endforeach
                            </select>

                            @error('estado_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Select Municipio --}}
                        <div class="form-group-modern">
                            <label for="municipio_id_modal" class="form-label-modern">
                                <i class="fas fa-tags"></i>
                                Municipio
                            </label>
                            <select name="municipio_id" wire:model.live="municipio_id" id="municipio_id_modal"
                                class="form-control-modern" required>
                                <option value="">Seleccione un municipio</option>
                                @foreach ($municipios as $municipio)
                                    <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
                                @endforeach
                            </select>

                            @error('municipio_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Select Localidad --}}
                        <div class="form-group-modern">
                            <label for="localidad_id_modal" class="form-label-modern">
                                <i class="fas fa-tags"></i>
                                Localidad
                            </label>
                            <select name="localidad_id" wire:model.live="localidad_id" id="localidad_id_modal"
                                class="form-control-modern" required>
                                <option value="">Seleccione una localidad</option>
                                @foreach ($localidades as $localidad)
                                    <option value="{{ $localidad->id }}">{{ $localidad->nombre_localidad }}</option>
                                @endforeach
                            </select>

                            @error('localidad_id')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nombre de la Institución --}}
                        <div class="form-group-modern">
                            <label for="nombre_institucion_modal" class="form-label-modern">
                                <i class="fas fa-school"></i>
                                Nombre de la Institución
                            </label>

                            <input type="text" id="nombre_institucion_modal" class="form-control-modern"
                                wire:model.defer="nombre_institucion" maxlength="150"
                                placeholder="Ingrese el nombre de la institución" required>

                            @error('nombre_institucion')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Botones --}}
                        <div class="modal-footer-create">
                            <div class="footer-buttons">
                                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                    Cancelar
                                </button>
                                <button type="submit" class="btn-modal-create" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="store">Guardar</span>
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
            Livewire.on('cerrarModalCrearInstitucion', () => {
                const modalEl = document.getElementById('modalCrearInstitucionInscripcion');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) {
                    modal.hide();
                }
            });

            Livewire.on('cerrarModalDespuesDe', (data) => {
                setTimeout(() => {
                    const modalEl = document.getElementById('modalCrearInstitucionInscripcion');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) {
                        modal.hide();
                    }
                }, data[0].delay || 1500);
            });
        });
    </script>
@endpush
