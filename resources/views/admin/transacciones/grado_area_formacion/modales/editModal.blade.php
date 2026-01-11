<div class="modal fade" id="viewModalEditar{{ $datos->id }}" tabindex="-1"
    aria-labelledby="viewModalEditarLabel{{ $datos->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">
            <div class="modal-header-edit">
                <div class="modal-icon-edit">
                    <i class="fas fa-pen"></i>
                </div>
                <h5 class="modal-title-edit" id="viewModalEditarLabel{{ $datos->id }}">
                    Editar Asignación
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body-edit">
                <form action="{{ route('admin.transacciones.grado_area_formacion.modales.update', $datos->id) }}"
                    method="POST">
                    @csrf
                    <div class="form-group-modern">
                        <label for="grado_id_{{ $datos->id }}" class="form-label-modern">
                            <i class="fas fa-graduation-cap me-2"></i>
                            Año
                        </label>
                        <select name="grado_id" id="grado_id_{{ $datos->id }}"
                            class="form-control-modern selectpicker" data-live-search="true" title="Seleccione un Año"
                            required>
                            @foreach ($grados as $grado)
                                <option value="{{ $grado->id }}"
                                    {{ old('grado_id', $datos->grado_id) == $grado->id ? 'selected' : '' }}>
                                    {{ $grado->numero_grado }}
                                </option>
                            @endforeach
                        </select>
                        @error('grado_id')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                Este campo es obligatorio.
                            </div>
                        @enderror
                    </div>
                    <div class="form-group-modern">
                        <label for="area_formacion_id_{{ $datos->id }}" class="form-label-modern">
                            <i class="fas fa-bookmark me-2"></i>
                            Área de Formación
                        </label>
                        <select name="area_formacion_id" id="area_formacion_id_{{ $datos->id }}"
                            class="form-control-modern selectpicker" data-live-search="true"
                            title="Seleccione un área de formación" required>
                            @foreach ($areaFormacion as $area)
                                <option value="{{ $area->id }}"
                                    {{ old('area_formacion_id', $datos->area_formacion_id) == $area->id ? 'selected' : '' }}>
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
        $(document).ready(function() {
            $('#viewModalEditar{{ $datos->id }}').on('shown.bs.modal', function() {
                $('#grado_id_{{ $datos->id }}, #area_formacion_id_{{ $datos->id }}').each(
            function() {
                    if (!$(this).data('selectpicker-initialized')) {
                        $(this).selectpicker();
                        $(this).data('selectpicker-initialized', true);
                    } else {
                        $(this).selectpicker('render');
                    }
                });
            });
        });
    </script>
@endpush
