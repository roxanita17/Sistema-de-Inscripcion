/**
 * Validaciones en tiempo real para el módulo de Estudios Realizados
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Cargando validaciones para estudios realizados...');
    
    // Inicializar validaciones cuando el DOM esté completamente cargado
    const modalEstudios = document.getElementById('modalCrearEstudio');
    if (modalEstudios) {
        console.log('Modal de estudios realizados encontrado, inicializando validaciones...');
        inicializarValidacionesEstudiosRealizados();
    } else {
        console.log('Modal de estudios realizados no encontrado');
    }
});

/**
 * Inicializa las validaciones para el formulario de estudios realizados
 */
function inicializarValidacionesEstudiosRealizados() {
    console.log('Inicializando validaciones para estudios realizados...');
    const form = document.getElementById('formCrearEstudiosRealizados');
    
    if (!form) {
        console.error('No se encontró el formulario con ID formCrearEstudiosRealizados');
        return;
    }

    // Elementos del formulario
    const estudiosInput = document.getElementById('estudios');
    const contenedorAlerta = document.getElementById('contenedorAlertaCrear');

    console.log('Elementos del formulario:', {
        estudiosInput,
        contenedorAlerta
    });

    // Función para mostrar mensajes de error
    function mostrarError(elemento, mensaje) {
        console.log(`Mostrando error para ${elemento.id}:`, mensaje);
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
        console.log(`Mostrando alerta (${tipo}):`, mensaje);
        if (contenedorAlerta) {
            contenedorAlerta.innerHTML = `
                <div class="alert alert-${tipo} alert-dismissible fade show mb-3" role="alert">
                    ${mensaje}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            `;
        }
    }

    // Función para validar el formato del nombre del estudio
    function validarEstudio(valor) {
        return valor.trim().length > 0 && valor.trim().length <= 100;
    }

    // Función para verificar si el estudio ya existe
    async function verificarEstudioExistente(estudio) {
        try {
            const url = new URL('/admin/estudios_realizados/verificar', window.location.origin);
            url.searchParams.append('estudios', estudio);
            
            console.log('Solicitando URL:', url.toString());
            
            const response = await fetch(url.toString());
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('Respuesta del servidor:', data);
            
            // Verificar si la respuesta es exitosa
            if (data.success === false) {
                console.error('Error del servidor:', data.message);
                return false; // En caso de error, asumimos que no existe para no bloquear al usuario
            }
            
            return data.existe;
        } catch (error) {
            console.error('Error al verificar el estudio:', error);
            return false; // En caso de error, asumimos que no existe para no bloquear al usuario
        }
    }

    // Validación en tiempo real para el campo de estudios
    if (estudiosInput) {
        let timeoutId;
        let haHechoBlur = false;

        // Validar formato mientras se escribe
        estudiosInput.addEventListener('input', function() {
            console.log('Evento input en estudios:', this.value);
            clearTimeout(timeoutId);
            const valor = this.value.trim();
            
            // Solo validar formato mientras se escribe, no si está vacío
            if (valor) {
                if (!validarEstudio(valor)) {
                    mostrarError(this, 'El nombre del estudio no debe exceder los 100 caracteres');
                } else {
                    mostrarError(this, '');
                    
                    // Verificar duplicados después de un tiempo
                    timeoutId = setTimeout(async () => {
                        console.log('Verificando duplicados para:', valor);
                        const existe = await verificarEstudioExistente(valor);
                        console.log('Resultado de verificación:', existe);
                        if (existe) {
                            mostrarError(this, 'Ya existe un estudio con este nombre');
                        } else if (haHechoBlur) {
                            mostrarError(this, '');
                        }
                    }, 500);
                }
            } else {
                mostrarError(this, '');
            }
        });

        // Validar campo obligatorio solo cuando se hace blur
        estudiosInput.addEventListener('blur', function() {
            console.log('Evento blur en estudios:', this.value);
            haHechoBlur = true;
            const valor = this.value.trim();
            
            if (!valor) {
                mostrarError(this, 'El nombre del estudio es obligatorio');
            } else if (!validarEstudio(valor)) {
                mostrarError(this, 'El nombre del estudio no debe exceder los 100 caracteres');
            } else {
                // Verificar duplicados al salir del campo
                verificarEstudioExistente(valor).then(existe => {
                    console.log('Verificación después de blur:', existe);
                    if (existe) {
                        mostrarError(this, 'Ya existe un estudio con este nombre');
                    } else {
                        mostrarError(this, '');
                    }
                });
            }
        });
    }

    // Validación al enviar el formulario
    form.addEventListener('submit', async function(event) {
        console.log('Enviando formulario de estudios realizados...');
        event.preventDefault();
        let esValido = true;
        
        // Validar estudios
        if (estudiosInput) {
            const valor = estudiosInput.value.trim();
            if (!valor) {
                mostrarError(estudiosInput, 'El nombre del estudio es obligatorio');
                esValido = false;
            } else if (!validarEstudio(valor)) {
                mostrarError(estudiosInput, 'El nombre del estudio no debe exceder los 100 caracteres');
                esValido = false;
            } else {
                // Verificar si el estudio ya existe
                console.log('Verificando duplicados antes de enviar...');
                const existe = await verificarEstudioExistente(valor);
                console.log('Resultado de verificación antes de enviar:', existe);
                if (existe) {
                    mostrarError(estudiosInput, 'Ya existe un estudio con este nombre');
                    esValido = false;
                }
            }
        }
        
        // Si hay errores, mostrar mensaje y prevenir el envío
        if (!esValido) {
            console.log('Formulario no válido, mostrando alerta...');
            mostrarAlerta('Por favor, complete el formulario correctamente.');
            return false;
        }
        
        console.log('Formulario válido, enviando...');
        // Si todo está bien, enviar el formulario
        this.submit();
        return true;
    });

    // Limpiar el formulario cuando se cierre el modal
    const modal = document.getElementById('modalCrearEstudio');
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            console.log('Modal de estudios realizados cerrado, limpiando formulario...');
            form.reset();
            const errores = form.querySelectorAll('.error-validacion, .is-invalid');
            errores.forEach(error => {
                if (error.classList.contains('error-validacion')) {
                    error.remove();
                } else {
                    error.classList.remove('is-invalid');
                }
            });
            if (contenedorAlerta) {
                contenedorAlerta.innerHTML = '';
            }
        });
    }

    console.log('Validaciones de estudios realizados inicializadas correctamente');
}
