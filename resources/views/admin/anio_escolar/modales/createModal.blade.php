<div class="modal fade" id="modalCrearAnioEscolar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCrearAnioEscolarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">
            <div class="modal-header-create">
                <div class="modal-icon-create">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h5 class="modal-title-create" id="modalCrearAnioEscolarLabel">Nuevo Año Escolar</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body-create">
                <form id="formAnioEscolar" action="{{ route('admin.anio_escolar.modales.store') }}" method="POST">
                    @csrf

                    <div class="alert alert-info d-flex align-items-center mb-3" style="font-size: 0.9rem; padding: 0.75rem;">
                        <i class="fas fa-info-circle me-2"></i>
                        <span>Las fechas sugeridas son del <strong>10 de septiembre</strong> al <strong>10 de junio</strong>. Puede modificarlas según cronograma.</span>
                    </div>

                    <div class="form-group-modern">
                        <label for="inicio_anio_escolar" class="form-label-modern">
                            <i class="fas fa-calendar-day me-2"></i> Fecha de Inicio
                        </label>
                        <input type="date" 
                            class="form-control-modern" 
                            id="inicio_anio_escolar" 
                            name="inicio_anio_escolar" 
                            required>
                        @error('inicio_anio_escolar')
                            <div class="error-message mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group-modern">
                        <label for="cierre_anio_escolar" class="form-label-modern">
                            <i class="fas fa-calendar-check me-2"></i> Fecha de Cierre
                        </label>
                        <input type="date" 
                            class="form-control-modern" 
                            id="cierre_anio_escolar" 
                            name="cierre_anio_escolar" 
                            required>
                        @error('cierre_anio_escolar')
                            <div class="error-message mt-1">
                                <i class="fas fa-exclamation-circle me-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div id="error_validacion_fechas" class="error-message d-none">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        <span id="texto_error_validacion"></span>
                    </div>

                    <div id="info_duracion" class="alert alert-success d-none" style="font-size: 0.85rem; padding: 0.5rem; margin-top: 1rem;">
                        <i class="fas fa-clock me-2"></i>
                        <strong>Duración:</strong> <span id="duracion_texto"></span>
                    </div>

                    <div class="modal-footer-create">
                        <div class="footer-buttons">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>
                                Cancelar
                            </button>
                            <button type="submit" class="btn-modal-create" id="btn_guardar_anio">
                                <i class="fas fa-save me-1"></i>
                                Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalCrearAnioEscolar');
    const inputInicio = document.getElementById('inicio_anio_escolar');
    const inputCierre = document.getElementById('cierre_anio_escolar');
    const errorDiv = document.getElementById('error_validacion_fechas');
    const textoError = document.getElementById('texto_error_validacion');
    const infoDuracion = document.getElementById('info_duracion');
    const duracionTexto = document.getElementById('duracion_texto');
    const btnGuardar = document.getElementById('btn_guardar_anio');

    modal.addEventListener('show.bs.modal', function() {
        const hoy = new Date();
        const anioActual = hoy.getFullYear();
        const mesActual = hoy.getMonth();
        const anioInicio = mesActual >= 8 ? anioActual : anioActual - 1;
        const fechaInicio = `${anioInicio}-09-10`;
        const fechaCierre = `${anioInicio + 1}-06-10`;
        inputInicio.value = fechaInicio;
        inputCierre.value = fechaCierre;
        calcularDuracion();
    });

    function validarFechas() {
        const inicio = new Date(inputInicio.value);
        const cierre = new Date(inputCierre.value);
        errorDiv.classList.add('d-none');
        inputInicio.classList.remove('is-invalid');
        inputCierre.classList.remove('is-invalid');
        btnGuardar.disabled = false;

        if (!inputInicio.value || !inputCierre.value) {
            return;
        }

        if (cierre <= inicio) {
            mostrarError('La fecha de cierre debe ser posterior a la fecha de inicio.');
            inputCierre.classList.add('is-invalid');
            btnGuardar.disabled = true;
            return;
        }

        const mesesDiferencia = (cierre.getFullYear() - inicio.getFullYear()) * 12 + 
                                (cierre.getMonth() - inicio.getMonth());
        
        if (mesesDiferencia < 6) {
            mostrarError('El año escolar debe tener una duración mínima de 6 meses.');
            inputCierre.classList.add('is-invalid');
            btnGuardar.disabled = true;
            return;
        }

        calcularDuracion();
    }

    function mostrarError(mensaje) {
        textoError.textContent = mensaje;
        errorDiv.classList.remove('d-none');
        infoDuracion.classList.add('d-none');
    }

    function calcularDuracion() {
        if (!inputInicio.value || !inputCierre.value) {
            infoDuracion.classList.add('d-none');
            return;
        }

        const inicio = new Date(inputInicio.value);
        const cierre = new Date(inputCierre.value);
        
        if (cierre <= inicio) {
            infoDuracion.classList.add('d-none');
            return;
        }

        const diferenciaTiempo = cierre - inicio;
        const dias = Math.floor(diferenciaTiempo / (1000 * 60 * 60 * 24));
        const meses = Math.floor(dias / 30);
        duracionTexto.textContent = `${meses} meses (${dias} días)`;
        infoDuracion.classList.remove('d-none');
    }

    inputInicio.addEventListener('change', validarFechas);
    inputCierre.addEventListener('change', validarFechas);
    modal.addEventListener('hidden.bs.modal', function() {
        document.getElementById('formAnioEscolar').reset();
        errorDiv.classList.add('d-none');
        infoDuracion.classList.add('d-none');
        inputInicio.classList.remove('is-invalid');
        inputCierre.classList.remove('is-invalid');
        btnGuardar.disabled = false;
    });
});
</script>