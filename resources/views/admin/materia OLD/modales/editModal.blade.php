{{-- Modal Editar Año Escolar --}}
                <div class="modal fade" id="viewModalEditar{{ $datos->id }}" tabindex="-1"
                    aria-labelledby="viewModalEditarLabel{{ $datos->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title" id="viewModalEditarLabel{{ $datos->id }}">
                                    Editar Materia
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.materia.modales.update', $datos->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="grado_id" class="form-label">Grado</label>
                                        <select name="grado_id" id="grado_id" class="form-control" title="Seleccione un grado" required>
                                            @foreach ($grados as $grado)
                                                <option value="{{ $grado->id }}" {{ old('grado_id', $datos->grado_id) == $grado->id ? 'selected' : '' }}>{{ $grado->numero_grado }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('grado_id')
                                        <div class="alert text-danger p-0 m-0">
                                            <b>{{ 'Este campo es obligatorio.' }}</b>
                                        </div>
                                    @enderror

                                    <input type="hidden" name="id" value="{{ $datos->id }}">
                                    <div class="mb-3">
                                        <label class="form-label"><b>Nombre:</b></label>
                                        <input type="text" class="form-control" name="nombre_materia" value="{{ $datos->nombre_materia }}" required>
                                    </div>
                                    @error('nombre_materia')
                                        <div class="alert text-danger p-0 m-0">
                                            <b>{{ 'Este campo es obligatorio.' }}</b>
                                        </div>
                                    @enderror
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

                <script>
                    $(document).ready(function () {
                        // Asegura que se refresque al abrir el modal
                        $('#viewModalEditar{{ $datos->id }}').on('shown.bs.modal', function () {
                            $('#grado_id').refresh();
                        });
                    });
                    </script>