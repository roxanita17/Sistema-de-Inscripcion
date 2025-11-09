{{-- Modal Ver Detalles --}}
                <div class="modal fade" id="viewModal{{ $datos->id }}" tabindex="-1" 
                    aria-labelledby="viewModalLabel{{ $datos->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="viewModalLabel{{ $datos->id }}">
                                    Detalles del Grado
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <p><b>Grado:</b> {{ $datos->numero_grado }}</p>
                                <p><b>Capacidad maxima de cupos:</b> {{ $datos->capacidad_max }}</p>
                                <p><b>Minimo de seccion:</b> {{ $datos->min_seccion }}</p>
                                <p><b>Maximo de seccion:</b> {{ $datos->max_seccion }}</p>
                                <p><b>Estado:</b> 
                                    @if ($datos->status == true)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                