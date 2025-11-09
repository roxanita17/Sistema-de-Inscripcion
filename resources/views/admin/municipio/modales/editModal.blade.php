{{-- Modal Editar Año Escolar --}}
                <div class="modal fade" id="viewModalEditar{{ $datos->id }}" tabindex="-1"
                    aria-labelledby="viewModalEditarLabel{{ $datos->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title" id="viewModalEditarLabel{{ $datos->id }}">
                                    Editar Municipio
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.municipio.modales.update', $datos->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="estado_id" class="form-label">Estado</label>
                                        <select name="estado_id" id="estado_id" class="form-control selectpicker" data-live-search="true" title="Seleccione un estado" required>
                                            @foreach ($estados as $estado)
                                                <option value="{{ $estado->id }}" {{ old('estado_id', $datos->estado_id) == $estado->id ? 'selected' : '' }}>{{ $estado->nombre_estado }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('estado_id')
                                        <div class="alert text-danger p-0 m-0">
                                            <b>{{ 'Este campo es obligatorio.' }}</b>
                                        </div>
                                    @enderror

                                    <input type="hidden" name="id" value="{{ $datos->id }}">
                                    <div class="mb-3">
                                        <label class="form-label"><b>Nombre:</b></label>
                                        <input type="text" class="form-control" name="nombre_municipio" value="{{ $datos->nombre_municipio }}" required>
                                    </div>
                                    @error('nombre_municipio')
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
                        // Inicia todos los selectpicker
                        $('.selectpicker').selectpicker();

                        // Asegura que se refresque al abrir el modal
                        $('#viewModalEditar{{ $datos->id }}').on('shown.bs.modal', function () {
                            $('#estado_id').selectpicker('refresh');
                        });
                    });
                    </script>