<!-- Modal Ver Detalles de datos -->
<div class="modal fade" id="viewModal{{ $datos->id }}" tabindex="-1"
    aria-labelledby="viewModalLabel{{ $datos->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-modern">

            <!-- Header -->
            <div class="modal-header-view">
                <div class="modal-icon-view">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h5 class="modal-title-view" id="viewModalLabel{{ $datos->id }}">
                    Información del Docente
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body-view">
                    
                <div class="details-card">

                    <!-- =======================
                        Sección: Identificación
                    ============================ -->
                    <h6 class="section-title">
                        <i class="fas fa-id-badge"></i> Identificación
                    </h6>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-id-card"></i> Cédula
                        </span>
                        <span class="detail-value">
                            {{ $datos->persona->tipoDocumento->nombre }}-{{ $datos->persona->numero_documento }}
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-hashtag"></i> Código Interno
                        </span>
                        <span class="detail-value">{{ $datos->codigo ?? 'No asignado' }}</span>
                    </div>

                    <!-- =======================
                        Sección: Datos Personales
                    ============================ -->
                    <h6 class="section-title">
                        <i class="fas fa-user"></i> Datos Personales
                    </h6>

                    <div class="detail-item">
                        <span class="detail-label"><i class="fas fa-user"></i> Nombres</span>
                        <span class="detail-value">
                            {{ $datos->persona->primer_nombre }}
                            {{ $datos->persona->segundo_nombre }}
                            {{ $datos->persona->tercer_nombre }}
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label"><i class="fas fa-user"></i> Apellidos</span>
                        <span class="detail-value">
                            {{ $datos->persona->primer_apellido }}
                            {{ $datos->persona->segundo_apellido }}
                        </span>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-venus-mars"></i> Género
                                </span>
                                <span class="detail-value">{{ $datos->persona->genero->genero }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-calendar"></i> Fecha de Nacimiento
                                </span>
                                <span class="detail-value">
                                    {{ \Carbon\Carbon::parse($datos->fecha_nacimiento)->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- =======================
                        Sección: Contacto
                    ============================ -->
                    <h6 class="section-title">
                        <i class="fas fa-phone-alt"></i> Información de Contacto
                    </h6>

                    <div class="detail-item">
                        <span class="detail-label"><i class="fas fa-envelope"></i> Correo</span>
                        <span class="detail-value">{{ $datos->persona->email ?? 'Sin registrar' }}</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label"><i class="fas fa-phone"></i> Teléfono</span>
                        <span class="detail-value">
                            @if ($datos->persona->prefijoTelefono)
                                {{ $datos->persona->prefijoTelefono->prefijo }}-{{ $datos->primer_telefono }}
                            @else
                                Sin registrar
                            @endif
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label"><i class="fas fa-phone"></i> Segundo Teléfono</span>
                        <span class="detail-value">
                            @if ($datos->persona->prefijoDos)
                                {{ $datos->persona->prefijoDos->prefijo}}-{{ $datos->persona->telefono_dos }}
                            @else
                                Sin registrar
                            @endif
                        </span>
                    </div>

                    <!-- =======================
                        Sección: Dependencia
                    ============================ -->
                    <h6 class="section-title">
                        <i class="fas fa-building"></i> Dependencia
                    </h6>

                    <div class="detail-item">
                        <span class="detail-label"><i class="fas fa-building"></i> Dependencia</span>
                        <span class="detail-value">{{ $datos->dependencia ?? 'Sin especificar' }}</span>
                    </div>

                    <!-- =======================
                        Sección: Estudios
                    ============================ -->
                    <h6 class="section-title">
                        <i class="fas fa-graduation-cap"></i> Estudios Realizados
                    </h6>

                    <div class="detail-item">
                        <span class="detail-label"><i class="fas fa-graduation-cap"></i> Estudios</span>
                        <span class="detail-value">
                            @forelse ($datos->detalleEstudios as $est)
                                • {{ $est->estudiosRealizado->estudios }} <br>
                            @empty
                                Sin estudios registrados
                            @endforelse
                        </span>
                    </div>

                    <!-- =======================
                        Auditoría
                    ============================ -->
                    <h6 class="section-title">
                        <i class="fas fa-clock"></i> Auditoría
                    </h6>

                    <div class="detail-item">
                        <span class="detail-label"><i class="fas fa-calendar-plus"></i> Registrado el</span>
                        <span class="detail-value">
                            {{ $datos->created_at->format('d/m/Y H:i:s') }}
                        </span>
                    </div>

                    @if ($datos->updated_at != $datos->created_at)
                    <div class="detail-item">
                        <span class="detail-label"><i class="fas fa-edit"></i> Última actualización</span>
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
                    <i class="fas fa-times-circle"></i> Cerrar
                </button>
            </div>

        </div>
    </div>
</div>
