{{-- Modal Editar Año Escolar --}}
                <div class="modal fade" id="viewModalEditarGrupoEstable{{ $grupo->id }}" tabindex="-1"
                    aria-labelledby="viewModalEditarLabelGrupoEstable{{ $grupo->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title" id="viewModalEditarLabelGrupoEstable{{ $grupo->id }}">
                                    Editar Grupo Estable
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.area_formacion.modalesGrupoEstable.updateGrupoEstable', $grupo->id) }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="nombre_grupo_estable" class="form-label">Nombre del grupo estable</label>
                                        <input type="text" class="form-control" id="nombre_grupo_estable" name="nombre_grupo_estable" value="{{ $grupo->nombre_grupo_estable }}" required>
                                    </div>
                                    @error('nombre_grupo_estable')
                                        <div class="alert text-danger p-0 m-0">
                                            <b>{{ 'Este campo es obligatorio.' }}</b>
                                        </div>
                                    @enderror

                                    <input type="hidden" name="id" value="{{ $grupo->id }}">
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
                        $('#viewModalEditarGrupoEstable{{ $grupo->id }}').on('shown.bs.modal', function () {
                            $('#nombre_grupo_estable').refresh();
                        });
                    });
                </script>
