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
                                <form action="{{ route('admin.grado.modales.update', $datos->id) }}" method="POST">
                                    @csrf
                                    {{-- Numero de grado --}}
                                    <input type="hidden" name="id" value="{{ $datos->id }}">
                                    <div class="mb-3">
                                        <label class="form-label"><b>Numero:</b></label>
                                        <input type="text" class="form-control" inputmode="numeric" pattern="[0-9]+" maxlength="4" oninput="this.value=this.value.replace(/[^0-9]/g,'')" name="numero_grado" value="{{ $datos->numero_grado }}" required>
                                    </div>
                                    @error('numero_grado')
                                        <div class="alert text-danger p-0 m-0">
                                            <b>{{ 'Este campo es obligatorio.' }}</b>
                                        </div>
                                    @enderror

                                    {{-- Capacidad maxima de cupos --}}
                                    <div class="mb-3">
                                        <label class="form-label"><b>Capacidad maxima de cupos:</b></label>
                                        <input type="text" class="form-control" inputmode="numeric" pattern="[0-9]+" maxlength="3" oninput="this.value=this.value.replace(/[^0-9]/g,'')" name="capacidad_max" value="{{ $datos->capacidad_max }}" required>
                                    </div>
                                    @error('capacidad_max')
                                        <div class="alert text-danger p-0 m-0">
                                            <b>{{ 'Este campo es obligatorio.' }}</b>
                                        </div>
                                    @enderror

                                    {{-- Minimo de seccion --}}
                                    <div class="mb-3">
                                        <label class="form-label"><b>Minimo de seccion:</b></label>
                                        <input type="text" class="form-control" inputmode="numeric" pattern="[0-9]+" maxlength="2" oninput="this.value=this.value.replace(/[^0-9]/g,'')" name="min_seccion" value="{{ $datos->min_seccion }}" required>
                                    </div>
                                    @error('min_seccion')
                                        <div class="alert text-danger p-0 m-0">
                                            <b>{{ 'Este campo es obligatorio.' }}</b>
                                        </div>
                                    @enderror

                                    {{-- Maximo de seccion --}}
                                    <div class="mb-3">
                                        <label class="form-label"><b>Maximo de seccion:</b></label>
                                        <input type="text" class="form-control" inputmode="numeric" pattern="[0-9]+" maxlength="2" oninput="this.value=this.value.replace(/[^0-9]/g,'')" name="max_seccion" value="{{ $datos->max_seccion }}" required>
                                    </div>
                                    @error('max_seccion')
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