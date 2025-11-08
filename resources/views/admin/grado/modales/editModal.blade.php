{{-- Modal Editar Año Escolar --}}
                <div class="modal fade" id="viewModalEditar{{ $datos->id }}" tabindex="-1"
                    aria-labelledby="viewModalEditarLabel{{ $datos->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title" id="viewModalEditarLabel{{ $datos->id }}">
                                    Editar Banco
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.banco.modales.update', $datos->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $datos->id }}">
                                    <div class="mb-3">
                                        <label class="form-label"><b>Codigo:</b></label>
                                        <input type="text" class="form-control" inputmode="numeric" pattern="[0-9]+" maxlength="4" oninput="this.value=this.value.replace(/[^0-9]/g,'')" name="codigo_banco" value="{{ $datos->codigo_banco }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><b>Nombre:</b></label>
                                        <input type="text" class="form-control" name="nombre_banco" value="{{ $datos->nombre_banco }}" required>
                                    </div>
                                    @error('codigo_banco')
                                        <div class="alert text-danger p-0 m-0">
                                            <b>{{ 'Este campo es obligatorio.' }}</b>
                                        </div>
                                    @enderror
                                    @error('nombre_banco')
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