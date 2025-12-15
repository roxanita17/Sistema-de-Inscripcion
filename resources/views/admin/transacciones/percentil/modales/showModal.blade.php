{{-- Modal Ver Detalles del Grado --}}
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content modal-modern">

            {{-- Cabecera del modal --}}
            <div class="modal-header-view">
                <div class="modal-icon-view">
                    <i class="fas fa-eye"></i>
                </div>
                <h5 class="modal-title-view" id="viewModalLabel">
                    Resumen de secciones
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cuerpo del modal --}}
            <div class="modal-body">
                <div class="row g-3 justify-content-center">
                    @foreach ($seccionesResumen as $seccion)
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="card shadow-sm border-0 w-100">
                                <div class="card-body text-center">
                                    <h6 class="fw-bold mb-2">
                                        <i class="fas fa-hashtag me-1"></i>
                                        {{ $seccion->seccion->nombre }}
                                    </h6>
                                    <span class="badge py-2 px-3 fs-6"
                                        style="background-color: var(--info-light); color:rgba(0, 0, 0, 0.715)">
                                        {{ $seccion->total_estudiantes }} estudiantes
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Pie del modal --}}
            <div class="modal-footer-view">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>

        </div>
    </div>
</div>
