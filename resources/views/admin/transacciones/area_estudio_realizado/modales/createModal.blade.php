<!-- Modal Crear Asignación -->
<div class="modal fade" id="modalCrearAsignacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearAsignacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">
            <div class="modal-header-create">
                <div class="modal-icon-create">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5 class="modal-title-create" id="modalCrearAsignacionLabel">Nueva Asignación</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body-create">
                <form id="formAsignacion" action="{{ route('admin.transacciones.area_estudio_realizado.modales.store') }}" method="POST">
                    @csrf

                    <!-- Select Área de Formación -->
                    <div class="form-group-modern">
                        <label for="area_formacion_id" class="form-label-modern">
                            <i class="fas fa-bookmark me-2"></i>
                            Área de Formación
                        </label>
                        <select name="area_formacion_id" id="area_formacion_id" 
                                class="form-control-modern selectpicker" 
                                data-live-search="true" 
                                title="Seleccione un área de formación" required>
                            <option value="">Seleccione un área de formación</option>
                            @foreach ($area_formacion as $area)
                                <option value="{{ $area->id }}">{{ $area->nombre_area_formacion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select Título Universitario -->
                    <div class="form-group-modern">
                        <label for="estudios_id" class="form-label-modern">
                            <i class="fas fa-graduation-cap me-2"></i>
                            Título Universitario
                        </label>
                        <select name="estudios_id" id="estudios_id" 
                                class="form-control-modern selectpicker" 
                                data-live-search="true" 
                                title="Seleccione un título universitario" required>
                            <option value="">Seleccione un título universitario</option>
                            @foreach ($estudios as $titulo)
                                <option value="{{ $titulo->id }}">{{ $titulo->estudios }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modal-footer-create">
                        <div class="footer-buttons">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>
                                Cancelar
                            </button>
                            <button type="submit" class="btn-modal-create">
                                <i class="fas fa-save me-1"></i>
                                Guardar
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
document.addEventListener('DOMContentLoaded', function () {
    $('.selectpicker').selectpicker();

    // Refresca los selects cuando se abre el modal
    const modal = document.getElementById('modalCrearAsignacion');
    modal.addEventListener('shown.bs.modal', function () {
        $('.selectpicker').selectpicker('refresh');
    });
});
</script>
@endpush

@push('css')
<style>

</style>
@endpush