<!-- Modal Crear Municipio -->
<div class="modal fade" id="modalCrearAreaFormacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalCrearAreaFormacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCrearAreaFormacionLabel">Registrar Área de formación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.area_formacion.modales.store') }}" method="POST" id="formCrearAreaFormacion">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre_area_formacion" class="form-label">Nombre del área de formación</label>
                        <input type="text" class="form-control" id="nombre_area_formacion" name="nombre_area_formacion" required>
                    </div>

                    @error('nombre_area_formacion')
                        <div class="alert text-danger p-0 m-0">
                            <b>{{ 'Este campo es obligatorio.' }}</b>
                        </div>
                    @enderror

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="formCrearAreaFormacion">
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






