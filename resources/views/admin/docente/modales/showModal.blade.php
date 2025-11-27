<!-- Modal Ver Detalles de datos -->
<div class="modal fade" id="viewModal{{ $datos->id }}" tabindex="-1"
    aria-labelledby="viewModalLabel{{ $datos->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-modern">
            
            <!-- Header -->
            <div class="modal-header-view">
                <div class="modal-icon-view">
                    <i class="fas fa-user"></i>
                </div>
                <h5 class="modal-title-view" id="viewModalLabel{{ $datos->id }}">
                    Detalles del datos
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body-view">
                <div class="details-card">

                    {{-- Identificación --}}
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-id-card"></i>
                            Cedula
                        </span>
                        <span class="detail-value">{{ $datos->persona->tipoDocumento->nombre }}-{{ $datos->persona->cedula }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-hashtag"></i>
                            Código Interno
                        </span>
                        <span class="detail-value">{{ $datos->codigo ?? 'No asignado' }}</span>
                    </div>

                    {{-- Datos personales --}}
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-user"></i>
                            Nombres
                        </span>
                        <span class="detail-value">
                            {{ $datos->persona->primer_nombre }}
                            {{ $datos->persona->segundo_nombre }}
                            {{ $datos->persona->tercer_nombre }}
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-user"></i>
                            Apellidos
                        </span>
                        <span class="detail-value"> 
                            {{ $datos->persona->primer_apellido }}
                            {{ $datos->persona->segundo_apellido }}
                        </span>
                    </div>

                    {{-- Genero y fecha de nacimiento --}}
                    <div class="col">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-venus-mars"></i>
                                        Género
                                    </span>
                                    <span class="detail-value">{{ $datos->persona->genero->genero}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-item">
                                    <span class="detail-label">
                                        <i class="fas fa-calendar"></i>
                                        Fecha de Nacimiento
                                    </span>
                                    <span class="detail-value">
                                        {{ \Carbon\Carbon::parse($datos->fecha_nacimiento)->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Contacto --}}
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-envelope"></i>
                            Correo
                        </span>
                        <span class="detail-value">{{ $datos->persona->email ?? 'Sin registrar' }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-phone"></i>
                            Teléfono
                        </span>
                        <span class="detail-value">
                            @if ($datos->prefijoTelefono)
                                ({{ $datos->prefijoTelefono->prefijo }}) {{ $datos->primer_telefono }}
                            @else
                                Sin registrar
                            @endif
                        </span>
                    </div>

                    {{-- Otros --}}
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-building"></i>
                            Dependencia
                        </span>
                        <span class="detail-value">
                            {{ $datos->dependencia ?? 'Sin especificar' }}
                        </span>
                    </div>

                    {{-- <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Dirección
                        </span>
                        <span class="detail-value">
                            {{ $datos->direccion ?? 'No registrada' }}
                        </span>
                    </div> --}}

                    {{-- Separador --}}
                    <div style="border-top: 2px dashed var(--gray-200); margin: 1rem 0;"></div>                    

                    {{-- Estudios --}}
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-graduation-cap"></i>
                            Estudios Realizados
                        </span>

                        <span class="detail-value">
                            @forelse ($datos->detalleEstudios as $est)
                                • {{ $est->estudiosRealizado->estudios }} <br>
                            @empty
                                Sin estudios registrados
                            @endforelse
                        </span>
                    </div>

                    {{-- Auditoria --}}
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-calendar-plus"></i>
                            Registrado el
                        </span>
                        <span class="detail-value">
                            {{ $datos->created_at->format('d/m/Y H:i:s') }}
                        </span>
                    </div>

                    @if ($datos->updated_at != $datos->created_at)
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-calendar-edit"></i>
                            Última actualización
                        </span>
                        <span class="detail-value">
                            {{ $datos->updated_at->format('d/m/Y H:i:s') }}
                            <small style="display:block;color:var(--gray-700);font-size:.8rem;">
                                ({{ $datos->updated_at->diffForHumans() }})
                            </small>
                        </span>
                    </div>
                    @endif

                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer-view">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times-circle"></i>
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>
