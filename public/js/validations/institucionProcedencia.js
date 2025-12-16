/**
 * Validaciones en tiempo real para el módulo de Institución de Procedencia
 */

document.addEventListener('DOMContentLoaded', function() {
    // Verificar si el modal de crear está presente en la página
    const modalCrear = document.getElementById('modalCrear');
    let validacionesInicializadas = false;

    // Función para limpiar el formulario y errores
    function limpiarFormulario() {
        const form = document.getElementById('formCrearInstitucionProcedencia');
        if (form) {
            form.reset();
            // Limpiar errores
            const errores = form.querySelectorAll('.error-validacion, .is-invalid');
            errores.forEach(error => {
                if (error.classList.contains('error-validacion')) {
                    error.remove();
                } else {
                    error.classList.remove('is-invalid');
                }
            });
            // Limpiar alertas
            const contenedorAlerta = document.getElementById('contenedorAlertaCrear');
            if (contenedorAlerta) {
                contenedorAlerta.innerHTML = '';
            }
        }
    }

    if (modalCrear) {
        // Inicializar validaciones cuando el modal se muestra
        modalCrear.addEventListener('shown.bs.modal', function() {
            limpiarFormulario();
            if (!validacionesInicializadas) {
                inicializarValidacionesCrear();
                validacionesInicializadas = true;
            }
        });

        // Limpiar el formulario cuando se oculte el modal
        modalCrear.addEventListener('hidden.bs.modal', limpiarFormulario);
    }

    // Inicializar validaciones si el modal ya está abierto (en caso de recarga de página)
    if (modalCrear && modalCrear.classList.contains('show')) {
        inicializarValidacionesCrear();
        validacionesInicializadas = true;
    }
});

/**
 * Inicializa las validaciones para el formulario de creación
 */
function inicializarValidacionesCrear() {
    const form = document.getElementById('formCrearInstitucionProcedencia');
    if (!form) return;

    // Elementos del formulario
    const estadoSelect = document.getElementById('estado_id');
    const municipioSelect = document.getElementById('municipio_id');
    const localidadSelect = document.getElementById('localidad_id');
    const nombreInput = document.getElementById('nombre_institucion');
    const contenedorAlerta = document.getElementById('contenedorAlertaCrear');

    // Función para mostrar mensajes de error
    function mostrarError(elemento, mensaje) {
        // Eliminar mensajes de error existentes
        const errorExistente = elemento.parentElement.querySelector('.error-validacion');
        if (errorExistente) {
            errorExistente.remove();
        }

        if (mensaje) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-validacion text-danger mt-1 small';
            errorDiv.textContent = mensaje;
            elemento.parentElement.appendChild(errorDiv);
            elemento.classList.add('is-invalid');
        } else {
            elemento.classList.remove('is-invalid');
        }
    }

    // Función para mostrar alerta general
    function mostrarAlerta(mensaje, tipo = 'danger') {
        contenedorAlerta.innerHTML = `
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        `;
    }

    // Función para validar si un campo está vacío
    function validarCampoRequerido(elemento) {
        const valor = elemento.value.trim();
        if (!valor) {
            mostrarError(elemento, 'Este campo es obligatorio');
            return false;
        }
        mostrarError(elemento, '');
        return true;
    }

    // Función para verificar si la institución ya existe
    async function verificarInstitucionExistente(nombre) {
        try {
            // Usar una ruta absoluta para evitar problemas con la URL base
            const url = new URL('/admin/institucion-procedencia/verificar', window.location.origin);
            url.searchParams.append('nombre', nombre);
            
            const response = await fetch(url.toString());
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            const data = await response.json();
            return data.existe;
        } catch (error) {
            console.error('Error al verificar la institución:', error);
            return false; // En caso de error, asumimos que no existe para no bloquear al usuario
        }
    }

    // Validación en tiempo real para el campo de nombre
    if (nombreInput) {
        let timeoutId;
        let haHechoBlur = false;
        
        // Validar mientras se escribe (solo verificación de duplicados)
        nombreInput.addEventListener('input', function() {
            clearTimeout(timeoutId);
            const valor = this.value.trim();
            
            // Si el campo está vacío, limpiar errores
            if (!valor) {
                mostrarError(this, '');
                return;
            }
            
            // Verificar duplicados después de un tiempo
            timeoutId = setTimeout(async () => {
                const existe = await verificarInstitucionExistente(valor);
                if (existe) {
                    mostrarError(this, 'Ya existe una institución con este nombre');
                } else if (haHechoBlur) {
                    mostrarError(this, '');
                }
            }, 500);
        });
        
        // Validar campo obligatorio solo cuando se hace blur
        nombreInput.addEventListener('blur', function() {
            haHechoBlur = true;
            validarCampoRequerido(this);
            
            // Si el campo tiene valor, verificar duplicados
            const valor = this.value.trim();
            if (valor) {
                verificarInstitucionExistente(valor).then(existe => {
                    if (existe) {
                        mostrarError(this, 'Ya existe una institución con este nombre');
                    }
                });
            }
        });
    }

    // Validación para los selects
    [estadoSelect, municipioSelect, localidadSelect].forEach(select => {
        if (select) {
            select.addEventListener('change', function() {
                validarCampoRequerido(this);
            });
        }
    });

    // Validación al enviar el formulario
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        let esValido = true;
        
        // Validar campos obligatorios
        if (estadoSelect) esValido = validarCampoRequerido(estadoSelect) && esValido;
        if (municipioSelect) esValido = validarCampoRequerido(municipioSelect) && esValido;
        if (localidadSelect) esValido = validarCampoRequerido(localidadSelect) && esValido;
        
        // Validar nombre (obligatorio y sin duplicados)
        if (nombreInput) {
            const nombreValor = nombreInput.value.trim();
            if (!nombreValor) {
                mostrarError(nombreInput, 'El nombre de la institución es obligatorio');
                esValido = false;
            } else {
                // Verificar duplicados
                const existe = await verificarInstitucionExistente(nombreValor);
                if (existe) {
                    mostrarError(nombreInput, 'Ya existe una institución con este nombre');
                    esValido = false;
                }
            }
        }
        
        // Si hay errores, mostrar mensaje y prevenir el envío
        if (!esValido) {
            mostrarAlerta('Por favor, complete todos los campos obligatorios correctamente.');
            return false;
        }
    });
}
