<!-- Modal Crear Localidad -->
<div class="modal fade" id="modalCrearLocalidad" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Registrar Localidad</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="formLocalidad" action="{{ route('admin.localidad.modales.store') }}" method="POST">
          @csrf

          <!-- Select Estado -->
          <div class="mb-3">
              <label for="estado_id" class="form-label">Estado</label>
                <select name="estado_id" id="estado_id" class="form-control selectpicker" data-live-search="true" title="Seleccione un estado" required>
                    @foreach ($estados as $estado)
                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                    @endforeach
                </select>
          </div>

          <!-- Select Municipio -->
          <div class="mb-3">
            <label for="municipio_id" class="form-label">
              <span class="text-danger">*</span> Municipio
            </label>
              <select name="municipio_id" id="municipio_id" class="form-select" required disabled>
                <option value="">Seleccione un estado primero</option>
              </select>
          </div>

          <!-- Input Nombre Localidad -->
          <div class="mb-3">
            <label for="nombre_localidad" class="form-label">
              <span class="text-danger">*</span> Nombre de la Localidad
            </label>
            <input type="text" class="form-control" id="nombre_localidad" name="nombre_localidad"
              placeholder="Ej: Centro, La Trinidad, etc." required>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
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
document.addEventListener("DOMContentLoaded", function () {
  console.log("Script JS cargado");

  const estadoSelect = document.getElementById("estado_id");
  const municipioSelect = document.getElementById("municipio_id");

  estadoSelect.addEventListener("change", async function () {
    const estadoId = this.value;
    municipioSelect.innerHTML = "";
    municipioSelect.disabled = true;

    if (!estadoId) {
      municipioSelect.innerHTML = '<option value="">Seleccione un estado primero</option>';
      return;
    }

    municipioSelect.innerHTML = '<option value="">Cargando municipios...</option>';

    try {
      // Usa la URL absoluta de Laravel
      const response = await fetch(`{{ url('admin/localidad/municipios') }}/${estadoId}`);
      if (!response.ok) throw new Error("Error en la respuesta del servidor");

      const municipios = await response.json();
      console.log("Municipios recibidos:", municipios);

      municipioSelect.innerHTML = "";

      if (municipios.length > 0) {
        municipioSelect.innerHTML += '<option value="">Seleccione un municipio</option>';
        municipios.forEach(m => {
          municipioSelect.innerHTML += `<option value="${m.id}">${m.nombre_municipio}</option>`;
        });
        municipioSelect.disabled = false;
      } else {
        municipioSelect.innerHTML = '<option value="">No hay municipios disponibles</option>';
      }

    } catch (error) {
      console.error("Error al cargar municipios:", error);
      municipioSelect.innerHTML = '<option value="">Error al cargar municipios</option>';
    }
  });

  // Limpiar formulario al cerrar modal
  const modal = document.getElementById("modalCrearLocalidad");
  modal.addEventListener("hidden.bs.modal", () => {
    document.getElementById("formLocalidad").reset();
    municipioSelect.innerHTML = '<option value="">Seleccione un estado primero</option>';
    municipioSelect.disabled = true;
  });
});
</script>
