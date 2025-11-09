<div class="modal fade" id="viewModalEditar{{ $datos->id }}" tabindex="-1"
    aria-labelledby="viewModalEditarLabel{{ $datos->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="viewModalEditarLabel{{ $datos->id }}">
                    Editar Grado
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                {{-- Ruta de editar grado --}}
                <form action="{{ route('admin.prefijo_telefono.modales.update', $datos->id) }}" method="POST">
                    @csrf
                    {{-- Numero de grado --}}
                    <input type="hidden" name="id" value="{{ $datos->id }}">
                    <div class="mb-3">
                        <label class="form-label"><b>Prefijo:</b></label>
                        <input type="text" class="form-control" inputmode="numeric" pattern="[0-9]+" maxlength="4" oninput="this.value=this.value.replace(/[^0-9]/g,'')" name="prefijo" value="{{ $datos->prefijo }}" required>
                    </div>
                    @error('prefijo')
                        <div class="alert text-danger p-0 m-0">
                            <b>{{ 'Este campo es obligatorio.' }}</b>
                        </div>
                    @enderror

                    {{-- Botones de guardar y cancelar --}}
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


