<!-- Modal Crear Municipio -->
<div class="modal fade" id="modalCrearMunicipio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalCrearMunicipioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCrearMunicipioLabel">Registrar Municipio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.municipio.modales.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="estado_id" class="form-label">Estado</label>
                        <select name="estado_id" id="estado_id" class="form-control selectpicker" data-live-search="true" title="Seleccione un estado" required>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    @error('estado_id')
                        <div class="alert text-danger p-0 m-0">
                            <b>{{ 'Este campo es obligatorio.' }}</b>
                        </div>
                    @enderror

                    <div class="input-group mb-3">
                        <span class="input-group-text"><span class="text-danger">*</span> Nombre</span>
                        <input type="text" class="form-control" id="nombre_municipio" name="nombre_municipio" required>
                    </div>

                    @error('nombre_municipio')
                        <div class="alert text-danger p-0 m-0">
                            <b>{{ 'Este campo es obligatorio.' }}</b>
                        </div>
                    @enderror

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>


<!-- Inicialización: refrescar/activar selectpicker cuando se abra el modal -->
<script>
$(document).ready(function () {
    // Inicia todos los selectpicker
    $('.selectpicker').selectpicker();

    // Asegura que se refresque al abrir el modal
    $('#modalCrearMunicipio').on('shown.bs.modal', function () {
        $('#estado_id').selectpicker('refresh');
    });
});
</script>
