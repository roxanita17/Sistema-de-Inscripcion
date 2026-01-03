<!-- Modal Ver Detalles de datos -->
<div class="modal fade" id="viewModal{{ $datos->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $datos->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-modern">

            @php
                $alumno = $datos;
                $persona = $alumno->persona;
            @endphp

            <!-- Header -->
            <div class="modal-header-view">
                <div class="modal-icon-view">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h5 class="modal-title-view" id="viewModalLabel{{ $datos->id }}">
                    Información del Estudiante
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
                            {{ $persona?->tipoDocumento->nombre ?? 'N/A' }}-{{ $persona?->numero_documento ?? 'N/A' }}
                        </span>
                    </div>

                    <!-- =======================
                        Sección: Datos Personales
                    ============================ -->
                    <h6 class="section-title">
                        <i class="fas fa-user"></i> Datos Personales
                    </h6>

                    <div class="detail-item">
                        <span class="detail-label">Nombres</span>
                        <span class="detail-value">
                            {{ $persona?->primer_nombre ?? 'N/A' }}
                            {{ $persona?->segundo_nombre ?? 'N/A' }}
                            {{ $persona?->tercer_nombre ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Apellidos</span>
                        <span class="detail-value">
                            {{ $persona?->primer_apellido ?? 'N/A' }}
                            {{ $persona?->segundo_apellido ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Género</span>
                        <span class="detail-value">
                            {{ $persona?->genero?->genero ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Fecha de nacimiento</span>
                        <span class="detail-value">
                            {{ $persona?->fecha_nacimiento?->format('d/m/Y') ?? 'N/A' }}
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
                    <h6 class="section-title">
                        <i class="fas fa-ruler-combined"></i> Datos Físicos
                    </h6>

                    <div class="detail-item">
                        <span class="detail-label">Estatura</span>
                        <span class="detail-value">{{ $alumno?->estatura ?? 'N/A' }} m</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Peso</span>
                        <span class="detail-value">{{ $alumno?->peso ?? 'N/A' }} kg</span>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Lateralidad</span>
                        <span class="detail-value">
                            {{ $alumno?->lateralidad?->lateralidad ?? 'N/A' }}
                        </span>
                    </div>

                    <h6 class="section-title">
                        <i class="fas fa-users"></i> Información Cultural
                    </h6>

                    <div class="detail-item">
                        <span class="detail-label">Etnia indígena</span>
                        <span class="detail-value">
                            {{ $alumno?->etniaIndigena?->nombre ?? 'No aplica' }}
                        </span>
                    </div>

                    <h6 class="section-title">
                        <i class="fas fa-wheelchair"></i> Discapacidades
                    </h6>

                    @if ($alumno->discapacidades->count())
                        <ul>
                            @foreach ($alumno->discapacidades as $discapacidad)
                                <li>{{ $discapacidad->nombre_discapacidad ?? 'N/A' }}</li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-muted">No presenta discapacidades</span>
                    @endif





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
