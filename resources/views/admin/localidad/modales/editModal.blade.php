{{-- Modal para Editar una Localidad --}}
<div class="modal fade" id="viewModalEditar{{ $datos->id }}" tabindex="-1"
    aria-labelledby="viewModalEditarLabel{{ $datos->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">

            {{-- Encabezado del modal --}}
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="viewModalEditarLabel{{ $datos->id }}">
                    Editar Localidad
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                {{-- Formulario de edición de localidad --}}
                <form action="{{ route('admin.localidad.modales.update', $datos->id) }}" method="POST">
                    @csrf

                    {{-- Campo de selección de estado --}}
                    <div class="mb-3">
                        <label for="estado_id_{{ $datos->id }}" class="form-label">Estado</label>
                        <select name="estado_id" id="estado_id_{{ $datos->id }}" class="form-select" required>
                            <option value="">Seleccione un estado</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}"
                                    {{ $estado->id == $datos->municipio->estado_id ? 'selected' : '' }}>
                                    {{ $estado->nombre_estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('estado_id')
                        <div class="alert text-danger p-0 m-0">
                            <b>Este campo es obligatorio.</b>
                        </div>
                    @enderror

                    {{-- Campo de selección de municipio --}}
                    <div class="mb-3">
                        <label for="municipio_id_{{ $datos->id }}" class="form-label">Municipio</label>
                        <select name="municipio_id" id="municipio_id_{{ $datos->id }}" class="form-select" required>
                            <option value="">Seleccione un municipio</option>
                            @foreach ($municipios->where('estado_id', $datos->municipio->estado_id) as $municipio)
                                <option value="{{ $municipio->id }}"
                                    {{ $municipio->id == $datos->municipio_id ? 'selected' : '' }}>
                                    {{ $municipio->nombre_municipio }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('municipio_id')
                        <div class="alert text-danger p-0 m-0">
                            <b>Este campo es obligatorio.</b>
                        </div>
                    @enderror

                    {{-- Campo para nombre de la localidad --}}
                    <input type="hidden" name="id" value="{{ $datos->id }}">
                    <div class="mb-3">
                        <label class="form-label"><b>Nombre:</b></label>
                        <input type="text" class="form-control" name="nombre_localidad"
                            value="{{ $datos->nombre_localidad }}" required>
                    </div>
                    @error('nombre_localidad')
                        <div class="alert text-danger p-0 m-0">
                            <b>Este campo es obligatorio.</b>
                        </div>
                    @enderror

                    {{-- Botones del modal --}}
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

<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para cargar municipios dinámicamente al cambiar el estado -->
<script>
document.addEventListener("DOMContentLoaded", function () {
  console.log("Script JS de edición cargado");

  // Selecciona todos los selects de estado (uno por cada modal abierto)
  document.querySelectorAll("[id^='estado_id_']").forEach(estadoSelect => {
    const id = estadoSelect.id.split("_")[2]; // Obtiene el ID de la localidad (por ejemplo, 5)
    const municipioSelect = document.getElementById(`municipio_id_${id}`);

    // Cuando se cambia el estado
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
        // Petición al backend para traer municipios del estado seleccionado
        const response = await fetch(`{{ url('admin/localidad/municipios') }}/${estadoId}`);
        if (!response.ok) throw new Error("Error en la respuesta del servidor");

        const municipios = await response.json();
        console.log(`Municipios del estado ${estadoId}:`, municipios);

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
  });
});
</script>
