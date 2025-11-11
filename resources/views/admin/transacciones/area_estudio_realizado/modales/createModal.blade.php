<!-- Modal Crear Asignación -->
<div class="modal fade" id="modalCrearAsignacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Registrar Asignación</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form id="formAsignacion" action="{{ route('admin.transacciones.area_estudio_realizado.modales.store') }}" method="POST">
          @csrf

          <!-- Select Área de Formación -->
          <div class="mb-3">
              <label for="area_formacion_id" class="form-label">Área de Formación</label>
              <select name="area_formacion_id" id="area_formacion_id" 
                      class="form-control selectpicker" 
                      data-live-search="true" 
                      title="Seleccione un área de formación" required>
                  <option value="">Seleccione un área de formación</option>
                  @foreach ($area_formacion as $area)
                      <option value="{{ $area->id }}">{{ $area->nombre_area_formacion }}</option>
                  @endforeach
              </select>
          </div>

          <!-- Select Título Universitario -->
          <div class="mb-3">
              <label for="titulo_universitario_id" class="form-label">Título Universitario</label>
              <select name="titulo_universitario_id" id="titulo_universitario_id" 
                      class="form-control selectpicker" 
                      data-live-search="true" 
                      title="Seleccione un título universitario" required>
                  <option value="">Seleccione un título universitario</option>
                  @foreach ($titulo_universitario as $titulo)
                      <option value="{{ $titulo->id }}">{{ $titulo->titulo_universitario }}</option>
                  @endforeach
              </select>
          </div>

          <div class="modal-footer">
              <button type="submit" class="btn btn-primary">
                  <i class="fas fa-save"></i> Guardar
              </button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  <i class="fas fa-times"></i> Cancelar
              </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap 5 y Selectpicker -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
