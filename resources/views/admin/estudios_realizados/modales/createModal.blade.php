<!-- Modal Crear Municipio -->
<div class="modal fade" id="modalCrearEstudiosRealizados" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalCrearEstudiosRealizadosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCrearEstudiosRealizados">Registrar Estudios Realizados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.estudios_realizados.modales.store') }}" method="POST" id="formCrearEstudiosRealizados">
                    @csrf
                    <div class="mb-3">
                        <label for="titulo_universitario" class="form-label">Nombre del estudio realizado</label>
                        <input type="text" class="form-control" id="titulo_universitario" name="titulo_universitario" required>
                    </div>

                    @error('titulo_universitario')
                        <div class="alert text-danger p-0 m-0">
                            <b>{{ 'Este campo es obligatorio.' }}</b>
                        </div>
                    @enderror

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="formCrearEstudiosRealizados">
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






