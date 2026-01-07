<!-- Modal Crear Institución de Procedencia -->
<div wire:ignore.self class="modal fade" id="modalCrear" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">

            {{-- Cabecera del modal --}}
            <div class="modal-header-create">
                <div class="modal-icon-create">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5 class="modal-title-create" id="modalCrearLabel">Nueva Institución de Procedencia</h5>

                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cuerpo del modal --}}
            <div class="modal-body-create">
                <form wire:submit.prevent="store" id="formCrearInstitucionProcedencia">

                    {{-- Contenedor para alertas --}}
                    <div id="contenedorAlertaCrear"></div>

                    {{-- Select Estado --}}
                    <div class="form-group-modern">
                        <label for="estado_id" class="form-label-modern">
                            <i class="fas fa-tags"></i>
                            Estado
                        </label>
                        <select name="estado_id"
                            wire:model.live="estado_id"
                            id="estado_id"
                            class="form-control-modern"
                            required>
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
                        <label for="municipio_id" class="form-label-modern">
                            <i class="fas fa-tags"></i>
                            Municipio
                        </label>
                        <select name="municipio_id"
                            wire:model.live="municipio_id"
                            id="municipio_id"
                            class="form-control-modern"
                            required>
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
                        <label for="localidad_id" class="form-label-modern">
                            <i class="fas fa-tags"></i>
                            Localidad
                        </label>
                        <select name="localidad_id"
                            wire:model.live="localidad_id"
                            id="localidad_id"
                            class="form-control-modern"
                            required>
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
                        <label for="nombre_institucion" class="form-label-modern">
                            <i class="fas fa-school"></i>
                            Nombre de la Institución
                        </label>

                        <input type="text"
                            id="nombre_institucion"
                            class="form-control-modern"
                            wire:model.defer="nombre_institucion"
                            maxlength="150"
                            placeholder="Ingrese el nombre de la institución"
                            required>

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
                            <button type="submit" class="btn-modal-create">
                                Guardar
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('cerrarModal', () => {
            const modalEl = document.getElementById('modalCrear');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        });
    });
</script>
