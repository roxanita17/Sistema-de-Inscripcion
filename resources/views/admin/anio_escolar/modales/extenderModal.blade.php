{{-- Modal Extender Año Escolar --}}
                <div class="modal fade" id="viewModalExtender{{ $datos->id }}" tabindex="-1"
                    aria-labelledby="viewModalExtenderLabel{{ $datos->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-warning text-dark">
                                <h5 class="modal-title" id="viewModalExtenderLabel{{ $datos->id }}">
                                    Extender Año Escolar
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.anio_escolar.modales.extender', $datos->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $datos->id }}">
                                    <div class="mb-3">
                                        <label class="form-label"><b>Inicio del año escolar:</b></label>
                                        <input type="date" class="form-control" value="{{ $datos->inicio_anio_escolar }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><b>Fecha de cierre actual:</b></label>
                                        <input type="date" class="form-control" value="{{ $datos->cierre_anio_escolar }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-danger"><b>Extender hasta (nuevo cierre):</b></label>
                                        <input type="date" class="form-control" id="extenderHasta{{ $datos->id }}" name="cierre_anio_escolar">
                                        <div id="extender_error_{{ $datos->id }}" class="text-danger small mt-1"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-warning">
                                            Guardar Extensión
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