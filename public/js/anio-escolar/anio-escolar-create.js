 document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalCrearAnioEscolar');
    const inputInicio = document.getElementById('inicio_anio_escolar');
    const inputCierre = document.getElementById('cierre_anio_escolar');
    const errorDiv = document.getElementById('error_validacion_fechas');
    const textoError = document.getElementById('texto_error_validacion');
    const infoDuracion = document.getElementById('info_duracion');
    const duracionTexto = document.getElementById('duracion_texto');
    const btnGuardar = document.getElementById('btn_guardar_anio');

    // ========================================
    // PRELLENAR FECHAS AL ABRIR EL MODAL
    // ========================================
    modal.addEventListener('show.bs.modal', function() {
        const hoy = new Date();
        const anioActual = hoy.getFullYear();
        const mesActual = hoy.getMonth(); // 0 = Enero, 8 = Septiembre
        
        // Si estamos en septiembre o después, usar el año actual, sino el anterior
        const anioInicio = mesActual >= 8 ? anioActual : anioActual - 1;
        
        // Fecha de inicio: 10 de septiembre
        const fechaInicio = `${anioInicio}-09-10`;
        
        // Fecha de cierre: 10 de junio del siguiente año
        const fechaCierre = `${anioInicio + 1}-06-10`;
        
        // Prellenar los campos
        inputInicio.value = fechaInicio;
        inputCierre.value = fechaCierre;
        
        // Calcular duración inicial
        calcularDuracion();
    });

    // ========================================
    // VALIDACIÓN EN TIEMPO REAL
    // ========================================
    function validarFechas() {
        const inicio = new Date(inputInicio.value);
        const cierre = new Date(inputCierre.value);
        
        // Limpiar errores previos
        errorDiv.classList.add('d-none');
        inputInicio.classList.remove('is-invalid');
        inputCierre.classList.remove('is-invalid');
        btnGuardar.disabled = false;

        // Validar que ambas fechas estén llenas
        if (!inputInicio.value || !inputCierre.value) {
            return;
        }

        // Validar que cierre sea posterior a inicio
        if (cierre <= inicio) {
            mostrarError('La fecha de cierre debe ser posterior a la fecha de inicio.');
            inputCierre.classList.add('is-invalid');
            btnGuardar.disabled = true;
            return;
        }

        // Validar duración mínima (6 meses)
        const mesesDiferencia = (cierre.getFullYear() - inicio.getFullYear()) * 12 + 
                                (cierre.getMonth() - inicio.getMonth());
        
        if (mesesDiferencia < 6) {
            mostrarError('El año escolar debe tener una duración mínima de 6 meses.');
            inputCierre.classList.add('is-invalid');
            btnGuardar.disabled = true;
            return;
        }

        // Calcular duración
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

        // Calcular diferencia en días
        const diferenciaTiempo = cierre - inicio;
        const dias = Math.floor(diferenciaTiempo / (1000 * 60 * 60 * 24));
        const meses = Math.floor(dias / 30);

        duracionTexto.textContent = `${meses} meses (${dias} días)`;
        infoDuracion.classList.remove('d-none');
    }

    // Escuchar cambios en los inputs
    inputInicio.addEventListener('change', validarFechas);
    inputCierre.addEventListener('change', validarFechas);

    // ========================================
    // LIMPIAR MODAL AL CERRAR
    // ========================================
    modal.addEventListener('hidden.bs.modal', function() {
        document.getElementById('formAnioEscolar').reset();
        errorDiv.classList.add('d-none');
        infoDuracion.classList.add('d-none');
        inputInicio.classList.remove('is-invalid');
        inputCierre.classList.remove('is-invalid');
        btnGuardar.disabled = false;
    });
});