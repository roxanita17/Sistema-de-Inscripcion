<!-- Modal Extender Año Escolar -->
<div class="modal fade" id="viewModalExtender{{ $datos->id }}" tabindex="-1"
    aria-labelledby="viewModalExtenderLabel{{ $datos->id }}" aria-hidden="true" data-cierre-actual="{{ $datos->cierre_anio_escolar }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">
            <div class="modal-header-edit">
                <div class="modal-icon-edit">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <h5 class="modal-title-edit" id="viewModalExtenderLabel{{ $datos->id }}">
                    Extender Año Escolar
                </h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body-edit">
                <form action="{{ route('admin.anio_escolar.modales.extender', $datos->id) }}" method="POST" id="formExtender{{ $datos->id }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $datos->id }}">

                    {{-- Alerta informativa --}}
                    <div class="alert alert-warning d-flex align-items-center mb-3" style="font-size: 0.85rem; padding: 0.75rem;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span>Solo puede extender hasta <strong>1 mes</strong> después de la fecha de cierre actual.</span>
                    </div>

                    <!-- Inicio (solo lectura) -->
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-calendar-alt me-2"></i>
                            Inicio del Año Escolar
                        </label>
                        <input type="date" 
                            class="form-control-modern" 
                            value="{{ \Carbon\Carbon::parse($datos->inicio_anio_escolar)->format('Y-m-d') }}" 
                            readonly 
                            style="background-color: #f8f9fa; cursor: not-allowed;">
                    </div>

                    <!-- Cierre actual (solo lectura) -->
                    <div class="form-group-modern">
                        <label class="form-label-modern">
                            <i class="fas fa-clock me-2"></i>
                            Fecha de Cierre Actual
                        </label>
                        <input type="date" 
                            class="form-control-modern" 
                            value="{{ \Carbon\Carbon::parse($datos->cierre_anio_escolar)->format('Y-m-d') }}"
                            readonly
                            style="background-color: #f8f9fa; cursor: not-allowed;">
                    </div>

                    <!-- Nueva fecha de cierre -->
                    <div class="form-group-modern">
                        <label class="form-label-modern text-primary">
                            <i class="fas fa-calendar-plus me-2"></i>
                            Nueva Fecha de Cierre <span class="text-danger">*</span>
                        </label>
                        <input type="date" 
                            class="form-control-modern" 
                            id="extenderHasta{{ $datos->id }}" 
                            name="cierre_anio_escolar"
                            min="{{ $datos->cierre_anio_escolar }}"
                            max="{{ \Carbon\Carbon::parse($datos->cierre_anio_escolar)->addMonth()->format('Y-m-d') }}"
                            required>
                        
                        {{-- Mensaje de error dinámico --}}
                        <div id="extender_error_{{ $datos->id }}" class="error-message d-none mt-2">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <span id="texto_error_{{ $datos->id }}"></span>
                        </div>

                        {{-- Información de ayuda --}}
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>
                            Fecha máxima permitida: <strong>{{ \Carbon\Carbon::parse($datos->cierre_anio_escolar)->addMonth()->format('d/m/Y') }}</strong>
                        </small>
                    </div>

                    {{-- Extensión actual (si existe) --}}
                    @if($datos->extencion_anio_escolar)
                    <div class="alert alert-info d-flex align-items-center" style="font-size: 0.85rem; padding: 0.75rem;">
                        <i class="fas fa-info-circle me-2"></i>
                        <span>Este año escolar ya fue extendido anteriormente hasta el <strong>{{ \Carbon\Carbon::parse($datos->extencion_anio_escolar)->format('d/m/Y') }}</strong></span>
                    </div>
                    @endif

                    <div class="modal-footer-edit">
                        <div class="footer-buttons">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </button>
                            <button type="submit" class="btn-modal-edit" id="btnGuardarExtension{{ $datos->id }}">
                                <i class="fas fa-save me-1"></i> Guardar Extensión
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript para validación de extensión --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalId = 'viewModalExtender{{ $datos->id }}';
    const modal = document.getElementById(modalId);
    const inputNuevoCierre = document.getElementById('extenderHasta{{ $datos->id }}');
    const errorDiv = document.getElementById('extender_error_{{ $datos->id }}');
    const textoError = document.getElementById('texto_error_{{ $datos->id }}');
    const btnGuardar = document.getElementById('btnGuardarExtension{{ $datos->id }}');

    const cierreActual = new Date('{{ $datos->cierre_anio_escolar }}');
    const limiteExtension = new Date(cierreActual);
    limiteExtension.setMonth(limiteExtension.getMonth() + 1);

    // Validar al cambiar la fecha
    inputNuevoCierre.addEventListener('change', function() {
        const nuevoCierre = new Date(this.value);
        
        // Limpiar errores previos
        errorDiv.classList.add('d-none');
        inputNuevoCierre.classList.remove('is-invalid');
        btnGuardar.disabled = false;

        if (!this.value) {
            return;
        }

        // Validar que sea mayor o igual al cierre actual
        if (nuevoCierre < cierreActual) {
            mostrarError('La nueva fecha no puede ser anterior a la fecha de cierre actual.');
            inputNuevoCierre.classList.add('is-invalid');
            btnGuardar.disabled = true;
            return;
        }

        // Validar que no exceda 1 mes
        if (nuevoCierre > limiteExtension) {
            mostrarError('No puede extender más de 1 mes desde la fecha de cierre actual.');
            inputNuevoCierre.classList.add('is-invalid');
            btnGuardar.disabled = true;
            return;
        }
    });

    function mostrarError(mensaje) {
        textoError.textContent = mensaje;
        errorDiv.classList.remove('d-none');
    }

    // Limpiar al cerrar el modal
    modal.addEventListener('hidden.bs.modal', function() {
        inputNuevoCierre.value = '';
        errorDiv.classList.add('d-none');
        inputNuevoCierre.classList.remove('is-invalid');
        btnGuardar.disabled = false;
    });
});
</script>