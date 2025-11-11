<div class="modal fade" id="viewModalEditar{{ $datos->id }}" tabindex="-1"
    aria-labelledby="viewModalEditarLabel{{ $datos->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="viewModalEditarLabel{{ $datos->id }}">
                    Editar Asignación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.transacciones.area_estudio_realizado.modales.update', $datos->id) }}" method="POST">
                    @csrf

                    <!-- Select Área de Formación -->
                    <div class="mb-3">
                        <label for="area_formacion_id_{{ $datos->id }}" class="form-label">Área de Formación</label>
                        <select name="area_formacion_id" id="area_formacion_id_{{ $datos->id }}" 
                                class="form-control selectpicker" data-live-search="true" required>
                            @foreach ($area_formacion as $area)
                                <option value="{{ $area->id }}" {{ old('area_formacion_id', $datos->area_formacion_id) == $area->id ? 'selected' : '' }}>
                                    {{ $area->nombre_area_formacion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('area_formacion_id')
                        <div class="alert text-danger p-0 m-0">
                            <b>Este campo es obligatorio.</b>
                        </div>
                    @enderror

                    <!-- Select Título Universitario -->
                    <div class="mb-3">
                        <label for="titulo_universitario_id_{{ $datos->id }}" class="form-label">Título Universitario</label>
                        <select name="titulo_universitario_id" id="titulo_universitario_id_{{ $datos->id }}" 
                                class="form-control selectpicker" data-live-search="true" required>
                            @foreach ($titulo_universitario as $titulo)
                                <option value="{{ $titulo->id }}" {{ old('titulo_universitario_id', $datos->titulo_universitario_id) == $titulo->id ? 'selected' : '' }}>
                                    {{ $titulo->titulo_universitario }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('titulo_universitario_id')
                        <div class="alert text-danger p-0 m-0">
                            <b>Este campo es obligatorio.</b>
                        </div>
                    @enderror

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">
                            Guardar Cambios
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // Refrescar los selectpicker cuando se abre el modal
    $('#viewModalEditar{{ $datos->id }}').on('shown.bs.modal', function () {
        $('#area_formacion_id_{{ $datos->id }}').selectpicker('refresh');
        $('#titulo_universitario_id_{{ $datos->id }}').selectpicker('refresh');
    });
});
</script>
