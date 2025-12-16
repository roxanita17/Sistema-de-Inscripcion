/**
 * Validaciones en tiempo real para el módulo de Expresión Literaria
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Cargando validaciones para expresión literaria...');
    
    // Inicializar validaciones cuando el DOM esté completamente cargado
    const modalExpresion = document.getElementById('modalCrear');
    if (modalExpresion) {
        console.log('Modal de expresión literaria encontrado, inicializando validaciones...');
        inicializarValidacionesExpresionLiteraria();
    } else {
        console.log('Modal de expresión literaria no encontrado');
    }
});

/**
 * Inicializa las validaciones para el formulario de expresión literaria
 */
function inicializarValidacionesExpresionLiteraria() {
    console.log('Inicializando validaciones para expresión literaria...');
    const form = document.getElementById('formCrearExpresionLiteraria');
    
    if (!form) {
        console.error('No se encontró el formulario con ID formCrearExpresionLiteraria');
        return;
    }

    // Elementos del formulario
    const letraInput = document.getElementById('letra_expresion_literaria');
    const contenedorAlerta = document.getElementById('contenedorAlertaCrear');

    console.log('Elementos del formulario:', {
        letraInput,
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

    // Función para validar el formato de la letra
    function validarLetra(valor) {
        return /^[A-Za-z]$/.test(valor);
    }

    // Función para verificar si la letra ya existe
    async function verificarLetraExistente(letra) {
        try {
            const url = new URL('/admin/expresion_literaria/verificar', window.location.origin);
            url.searchParams.append('letra_expresion_literaria', letra);
            
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
            console.error('Error al verificar la letra:', error);
            return false; // En caso de error, asumimos que no existe para no bloquear al usuario
        }
    }

    // Validación en tiempo real para el campo de letra
    if (letraInput) {
        let timeoutId;
        let haHechoBlur = false;

        // Validar formato mientras se escribe
        letraInput.addEventListener('input', function() {
            console.log('Evento input en letra:', this.value);
            clearTimeout(timeoutId);
            
            // Convertir a mayúscula automáticamente
            this.value = this.value.toUpperCase();
            
            const valor = this.value.trim();
            
            // Solo validar formato mientras se escribe, no si está vacío
            if (valor) {
                if (!validarLetra(valor)) {
                    mostrarError(this, 'Debe ingresar una sola letra (A-Z)');
                } else {
                    mostrarError(this, '');
                    
                    // Verificar duplicados después de un tiempo
                    timeoutId = setTimeout(async () => {
                        console.log('Verificando duplicados para:', valor);
                        const existe = await verificarLetraExistente(valor);
                        console.log('Resultado de verificación:', existe);
                        if (existe) {
                            mostrarError(this, 'Ya existe una expresión literaria con esta letra');
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
        letraInput.addEventListener('blur', function() {
            console.log('Evento blur en letra:', this.value);
            haHechoBlur = true;
            const valor = this.value.trim();
            
            if (!valor) {
                mostrarError(this, 'La letra es obligatoria');
            } else if (!validarLetra(valor)) {
                mostrarError(this, 'Debe ingresar una sola letra (A-Z)');
            } else {
                // Verificar duplicados al salir del campo
                verificarLetraExistente(valor).then(existe => {
                    console.log('Verificación después de blur:', existe);
                    if (existe) {
                        mostrarError(this, 'Ya existe una expresión literaria con esta letra');
                    } else {
                        mostrarError(this, '');
                    }
                });
            }
        });
    }

    // Validación al enviar el formulario
    form.addEventListener('submit', async function(event) {
        console.log('Enviando formulario de expresión literaria...');
        event.preventDefault();
        let esValido = true;
        
        // Validar letra
        if (letraInput) {
            const valor = letraInput.value.trim();
            if (!valor) {
                mostrarError(letraInput, 'La letra es obligatoria');
                esValido = false;
            } else if (!validarLetra(valor)) {
                mostrarError(letraInput, 'Debe ingresar una sola letra (A-Z)');
                esValido = false;
            } else {
                // Verificar si la letra ya existe
                console.log('Verificando duplicados antes de enviar...');
                const existe = await verificarLetraExistente(valor);
                console.log('Resultado de verificación antes de enviar:', existe);
                if (existe) {
                    mostrarError(letraInput, 'Ya existe una expresión literaria con esta letra');
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
    const modal = document.getElementById('modalCrear');
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            console.log('Modal de expresión literaria cerrado, limpiando formulario...');
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

    console.log('Validaciones de expresión literaria inicializadas correctamente');
}
