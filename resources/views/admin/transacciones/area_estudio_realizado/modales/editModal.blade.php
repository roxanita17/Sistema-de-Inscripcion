<!-- Modal Editar Asignación -->
<div class="modal fade" id="viewModalEditar{{ $datos->id }}" tabindex="-1" aria-labelledby="viewModalEditarLabel{{ $datos->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">
            <div class="modal-header-edit">
                <div class="modal-icon-edit">
                    <i class="fas fa-pen"></i>
                </div>
                <h5 class="modal-title-edit" id="viewModalEditarLabel{{ $datos->id }}">Editar Asignación</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body-edit">
                <form action="{{ route('admin.transacciones.area_estudio_realizado.modales.update', $datos->id) }}" method="POST">
                    @csrf

                    <!-- Select Área de Formación -->
                    <div class="form-group-modern">
                        <label for="area_formacion_id_{{ $datos->id }}" class="form-label-modern">
                            <i class="fas fa-bookmark me-2"></i>
                            Área de Formación
                        </label>
                        <select name="area_formacion_id" id="area_formacion_id_{{ $datos->id }}" 
                                class="form-control-modern selectpicker-edit-{{ $datos->id }}" 
                                data-live-search="true" required>
                            @foreach ($area_formacion as $area)
                                <option value="{{ $area->id }}" {{ old('area_formacion_id', $datos->area_formacion_id) == $area->id ? 'selected' : '' }}>
                                    {{ $area->nombre_area_formacion }}
                                </option>
                            @endforeach
                        </select>
                        @error('area_formacion_id')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                Este campo es obligatorio.
                            </div>
                        @enderror
                    </div>

                    <!-- Select Título Universitario -->
                    <div class="form-group-modern">
                        <label for="estudios_id_{{ $datos->id }}" class="form-label-modern">
                            <i class="fas fa-graduation-cap me-2"></i>
                            Título Universitario
                        </label>
                        <select name="estudios_id" id="estudios_id_{{ $datos->id }}" 
                                class="form-control-modern selectpicker-edit-{{ $datos->id }}" 
                                data-live-search="true" required>
                            @foreach ($estudios as $titulo)
                                <option value="{{ $titulo->id }}" {{ old('estudios_id', $datos->estudios_id) == $titulo->id ? 'selected' : '' }}>
                                    {{ $titulo->estudios }}
                                </option>
                            @endforeach
                        </select>
                        @error('estudios_id')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                Este campo es obligatorio.
                            </div>
                        @enderror
                    </div>

                    <div class="modal-footer-edit">
                        <div class="footer-buttons">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>
                                Cancelar
                            </button>
                            <button type="submit" class="btn-modal-edit">
                                <i class="fas fa-save me-1"></i>
                                Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
$(document).ready(function () {
    var modalId = '{{ $datos->id }}';
    
    // Destruir cualquier instancia previa al abrir el modal
    $('#viewModalEditar' + modalId).on('show.bs.modal', function () {
        $('.selectpicker-edit-' + modalId).selectpicker('destroy');
    });
    
    // Inicializar selectpicker cuando se muestra el modal
    $('#viewModalEditar' + modalId).on('shown.bs.modal', function () {
        $('.selectpicker-edit-' + modalId).selectpicker({
            liveSearch: true,
            noneSelectedText: 'Seleccione una opción'
        });
    });
    
    // Destruir al cerrar para evitar duplicados
    $('#viewModalEditar' + modalId).on('hidden.bs.modal', function () {
        $('.selectpicker-edit-' + modalId).selectpicker('destroy');
    });
});
</script>
@endpush