<!-- Modal Editar Localidad -->
<div wire:ignore.self class="modal fade" id="modalEditar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">

            {{-- Cabecera del modal --}}
            <div class="modal-header-edit">
                <div class="modal-icon-edit">
                    <i class="fas fa-pen"></i>
                </div>
                <h5 class="modal-title-edit" id="modalEditarLabel">Editar Localidad</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cuerpo del modal con formulario --}}
            <div class="modal-body-edit">
                <form wire:submit.prevent="update" id="formEditarLocalidad">

                    {{-- Contenedor para alertas de validación --}}
                    <div id="contenedorAlertaEditar"></div>

                    <div class="form-group-modern">
                        <label for="pais_id" class="form-label-modern">
                            <i class="fas fa-tags"></i>
                            Pais
                        </label>
                        <select name="pais_id" 
                            wire:model.live="pais_id"
                            id="pais_id" 
                            class="form-control-modern " 
                            data-live-search="true"
                            title="Seleccione un pais"
                            required>
                            <option value="">Seleccione un pais</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->id }}">{{ $pais->nameES }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Select del estado --}}
                    <div class="form-group-modern">
                        <label for="estado_id_editar" class="form-label-modern">
                            <i class="fas fa-map-marker-alt"></i>
                            Estado
                        </label>
                        <select name="estado_id" 
                            wire:model.live="estado_id"
                            id="estado_id_editar" 
                            class="form-control-modern" 
                            required>
                            <option value="">Seleccione un estado</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}" {{ $estado_id == $estado->id ? 'selected' : '' }}>
                                    {{ $estado->nombre_estado }}
                                </option>
                            @endforeach
                        </select>
                        @error('estado_id')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Select del municipio (dependiente del estado) --}}
                    <div class="form-group-modern">
                        <label for="municipio_id_editar" class="form-label-modern">
                            <i class="fas fa-city"></i>
                            Municipio
                        </label>
                        <select name="municipio_id" 
                            wire:model.live="municipio_id"
                            id="municipio_id_editar" 
                            class="form-control-modern" 
                            {{ empty($municipios) ? 'disabled' : '' }}
                            required>
                            <option value="">Seleccione un municipio</option>
                            @foreach ($municipios as $municipio)
                                <option value="{{ $municipio->id }}" {{ $municipio_id == $municipio->id ? 'selected' : '' }}>
                                    {{ $municipio->nombre_municipio }}
                                </option>
                            @endforeach
                        </select>
                        @error('municipio_id')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Nombre de la Localidad --}}
                    <div class="form-group-modern">
                        <label for="nombre_localidad_editar" class="form-label-modern">
                            <i class="fas fa-hashtag me-2"></i> Nombre de la Localidad
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="nombre_localidad_editar" 
                               wire:model.defer="nombre_localidad"
                               inputmode="text"
                               maxlength="100"
                               placeholder="Edite el nombre de la localidad"
                               required>
                        @error('nombre_localidad')
                            <div class="error-message">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Botones --}}
                    <div class="modal-footer-edit">
                        <div class="footer-buttons">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                Cancelar
                            </button>
                            <button type="submit" class="btn-modal-edit">
                                Guardar Cambios
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>