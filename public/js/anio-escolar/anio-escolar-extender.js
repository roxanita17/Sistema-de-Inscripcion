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