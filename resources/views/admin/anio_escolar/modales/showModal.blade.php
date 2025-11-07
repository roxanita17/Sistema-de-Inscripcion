{{-- Modal Ver Detalles --}}
                <div class="modal fade" id="viewModal{{ $datos->id }}" tabindex="-1" 
                    aria-labelledby="viewModalLabel{{ $datos->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="viewModalLabel{{ $datos->id }}">
                                    Detalles del Año Escolar
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <p><b>ID:</b> {{ $datos->id }}</p>
                                <p><b>Fecha de inicio:</b> {{ $datos->inicio_anio_escolar }}</p>
                                <p><b>Fecha de cierre:</b> {{ $datos->cierre_anio_escolar }}</p>
                                <p><b>Estado:</b> 
                                    @if ($datos->status == 'Activo')
                                        <span class="badge bg-success">Activo</span>
                                    @elseif ($datos->status == 'Extendido')
                                        <span class="badge bg-warning text-dark">Extendido</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </p>
                                <p><b>Creado por:</b> {{ $datos->user->name ?? 'No registrado' }}</p>
                                <p><b>Fecha de creación:</b> {{ $datos->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                