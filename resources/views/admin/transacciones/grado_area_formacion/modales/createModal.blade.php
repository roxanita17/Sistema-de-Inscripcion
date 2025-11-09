<!-- Modal Crear Localidad -->
<div class="modal fade" id="modalCrearAsignacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Registrar Asignacion</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="formAsignacion" action="{{ route('admin.transacciones.grado_area_formacion.modales.store') }}" method="POST">
          @csrf

          <!-- Select Grado -->
          <div class="mb-3">
              <label for="grado_id" class="form-label">Grado</label>
                <select name="grado_id" id="grado_id" class="form-control" data-live-search="true" title="Seleccione un grado" required>
                  <option value="">Seleccione un grado</option>
                    @foreach ($grados as $grado)
                        <option value="{{ $grado->id }}">{{ $grado->numero_grado }}</option>
                    @endforeach
                </select>
          </div>

          <!-- Select Area Formacion -->
        <div class="mb-3">
              <label for="area_formacion_id" class="form-label">Area Formacion</label>
                <select name="area_formacion_id" id="area_formacion_id" class="form-control selectpicker" data-live-search="true" title="Seleccione un area formacion" required>
                  <option value="">Seleccione un area formacion</option>
                    @foreach ($areaFormacion as $area_formacion)
                        <option value="{{ $area_formacion->id }}">{{ $area_formacion->nombre_area_formacion }}</option>
                    @endforeach
                </select>
          </div> 
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary">
                  Guardar 
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

<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script puro JS -->
<script>
$(document).ready(function () {
    // Inicia todos los selectpicker
    $('.selectpicker').selectpicker();

    // Asegura que se refresque al abrir el modal
    $('#modalCrearAsignacion').on('shown.bs.modal', function () {
        $('#grado_id').selectpicker('refresh');
    });
});
</script>
