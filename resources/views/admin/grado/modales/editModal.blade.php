<!-- Modal Editar Grado -->
<div class="modal fade" id="viewModalEditar{{ $datos->id }}" tabindex="-1" aria-labelledby="viewModalEditarLabel{{ $datos->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">

            {{-- Cabecera del modal --}}
            <div class="modal-header-edit">
                <div class="modal-icon-edit">
                    <i class="fas fa-pen"></i>
                </div>
                <h5 class="modal-title-edit" id="viewModalEditarLabel{{ $datos->id }}">
                    Editar Año
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cuerpo del modal con formulario --}}
            <div class="modal-body-edit">
                <form action="{{ route('admin.grado.modales.update', $datos->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $datos->id }}">

                    {{-- Numero de grado --}}
                    <div class="form-group-modern">
                        <label for="numero_grado_{{ $datos->id }}" class="form-label-modern">
                            Número de año
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="numero_grado_{{ $datos->id }}" 
                               name="numero_grado" 
                               inputmode="numeric" 
                               pattern="[0-9]+" 
                               maxlength="4" 
                               value="{{ $datos->numero_grado }}" 
                               oninput="this.value=this.value.replace(/[^0-9]/g,'')" 
                               required>
                        @error('numero_grado')
                            <div class="error-message">
                                Este campo es obligatorio.
                            </div>
                        @enderror
                    </div>

                    {{-- Capacidad máxima --}}
                    <div class="form-group-modern">
                        <label for="capacidad_max_{{ $datos->id }}" class="form-label-modern">
                            Capacidad Máxima de Cupos
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="capacidad_max_{{ $datos->id }}" 
                               name="capacidad_max" 
                               inputmode="numeric" 
                               pattern="[0-9]+" 
                               maxlength="3" 
                               value="{{ $datos->capacidad_max }}" 
                               oninput="this.value=this.value.replace(/[^0-9]/g,'')" 
                               required>
                        @error('capacidad_max')
                            <div class="error-message">
                                Este campo es obligatorio.
                            </div>
                        @enderror
                    </div>

                    {{-- Mínimo de sección --}}
                    <div class="form-group-modern">
                        <label for="min_seccion_{{ $datos->id }}" class="form-label-modern">
                            Mínimo de Sección
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="min_seccion_{{ $datos->id }}" 
                               name="min_seccion" 
                               inputmode="numeric" 
                               pattern="[0-9]+" 
                               maxlength="2" 
                               value="{{ $datos->min_seccion }}" 
                               oninput="this.value=this.value.replace(/[^0-9]/g,'')" 
                               required>
                        @error('min_seccion')
                            <div class="error-message">
                                Este campo es obligatorio.
                            </div>
                        @enderror
                    </div>

                    {{-- Máximo de sección --}}
                    <div class="form-group-modern">
                        <label for="max_seccion_{{ $datos->id }}" class="form-label-modern">
                            Máximo de Sección
                        </label>
                        <input type="text" 
                               class="form-control-modern" 
                               id="max_seccion_{{ $datos->id }}" 
                               name="max_seccion" 
                               inputmode="numeric" 
                               pattern="[0-9]+" 
                               maxlength="2" 
                               value="{{ $datos->max_seccion }}" 
                               oninput="this.value=this.value.replace(/[^0-9]/g,'')" 
                               required>
                        @error('max_seccion')
                            <div class="error-message">
                                Este campo es obligatorio.
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
