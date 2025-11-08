<!-- Modal Crear Municipio -->
<div class="modal fade" id="modalCrearMateria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalCrearMateriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCrearMateriaLabel">Registrar Materia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.materia.modales.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="grado_id" class="form-label">Grado</label>
                        <select name="grado_id" id="grado_id" class="form-control" title="Seleccione un grado" required>
                            <option value="">Seleccione un grado</option>
                            @foreach ($grados as $grado)    
                                <option value="{{ $grado->id }}">{{ $grado->numero_grado }}</option>
                            @endforeach
                        </select>
                    </div>

                    @error('grado_id')
                        <div class="alert text-danger p-0 m-0">
                            <b>{{ 'Este campo es obligatorio.' }}</b>
                        </div>
                    @enderror

                    <div class="input-group mb-3">
                        <span class="input-group-text"><span class="text-danger">*</span> Nombre</span>
                        <input type="text" class="form-control" id="nombre_materia" name="nombre_materia" required>
                    </div>

                    @error('nombre_materia')
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



