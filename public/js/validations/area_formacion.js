/**
 * Validaciones en tiempo real para el módulo de Áreas de Formación y Grupos Estables
 */

console.log('Cargando validaciones para area_formacion.js');

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente cargado, inicializando validaciones...');
    
    // Inicializar validaciones para el modal de área de formación
    const modalAreaFormacion = document.getElementById('modalCrearAreaFormacion');
    if (modalAreaFormacion) {
        console.log('Modal de área de formación encontrado');
        inicializarValidacionesAreaFormacion();
    } else {
        console.log('Modal de área de formación no encontrado');
    }

    // Inicializar validaciones para el modal de grupo estable
    const modalGrupoEstable = document.getElementById('modalCrearGrupoEstable');
    if (modalGrupoEstable) {
        console.log('Modal de grupo estable encontrado');
        inicializarValidacionesGrupoEstable();
    } else {
        console.log('Modal de grupo estable no encontrado');
    }
});

/**
 * Inicializa las validaciones para el formulario de área de formación
 */
function inicializarValidacionesAreaFormacion() {
    console.log('Inicializando validaciones para área de formación...');
    const form = document.getElementById('formAreaFormacion');
    console.log('Formulario de área de formación encontrado:', form);
    
    if (!form) {
        console.error('No se encontró el formulario con ID formAreaFormacion');
        return;
    }

    // Elementos del formulario
    const nombreInput = document.getElementById('nombre_area_formacion');
    const contenedorAlerta = document.createElement('div');
    contenedorAlerta.id = 'contenedorAlertaAreaFormacion';
    form.insertBefore(contenedorAlerta, form.firstChild);

    console.log('Elementos del formulario de área de formación:', {
        nombreInput,
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
        contenedorAlerta.innerHTML = `
            <div class="alert alert-${tipo} alert-dismissible fade show mb-3" role="alert">
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        `;
    }

    // Función para validar el formato del nombre del área de formación
    function validarFormatoNombre(valor) {
        return valor.trim().length > 0 && valor.trim().length <= 255;
    }

    // Función para verificar si el área de formación ya existe
    async function verificarAreaFormacionExistente(nombre) {
        try {
            const url = new URL('/admin/area_formacion/verificar', window.location.origin);
            url.searchParams.append('nombre', nombre);
            
            console.log('Solicitando URL:', url.toString());
            
            const response = await fetch(url.toString());
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                console.error('Error en la respuesta:', response.status, errorData);
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
            console.error('Error al verificar el área de formación:', error);
            return false; // En caso de error, asumimos que no existe para no bloquear al usuario
        }
    }

    // Validación en tiempo real para el campo de nombre
    if (nombreInput) {
        let timeoutId;
        let haHechoBlur = false;

        // Validar formato mientras se escribe
        nombreInput.addEventListener('input', function() {
            console.log('Evento input en nombre:', this.value);
            clearTimeout(timeoutId);
            const valor = this.value.trim();
            
            // Solo validar formato mientras se escribe, no si está vacío
            if (valor) {
                if (!validarFormatoNombre(valor)) {
                    mostrarError(this, 'El nombre no puede tener más de 255 caracteres');
                } else {
                    mostrarError(this, '');
                    
                    // Verificar duplicados después de un tiempo
                    timeoutId = setTimeout(async () => {
                        console.log('Verificando duplicados para:', valor);
                        const existe = await verificarAreaFormacionExistente(valor);
                        console.log('Resultado de verificación:', existe);
                        if (existe) {
                            mostrarError(this, 'Ya existe un área de formación con este nombre');
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
        nombreInput.addEventListener('blur', function() {
            console.log('Evento blur en nombre:', this.value);
            haHechoBlur = true;
            const valor = this.value.trim();
            
            if (!valor) {
                mostrarError(this, 'El nombre del área de formación es obligatorio');
            } else if (!validarFormatoNombre(valor)) {
                mostrarError(this, 'El nombre no puede tener más de 255 caracteres');
            } else {
                // Verificar duplicados al salir del campo
                verificarAreaFormacionExistente(valor).then(existe => {
                    console.log('Verificación después de blur:', existe);
                    if (existe) {
                        mostrarError(this, 'Ya existe un área de formación con este nombre');
                    } else {
                        mostrarError(this, '');
                    }
                });
            }
        });
    }

    // Validación al enviar el formulario
    form.addEventListener('submit', async function(event) {
        console.log('Enviando formulario de área de formación...');
        event.preventDefault();
        let esValido = true;
        
        // Validar nombre
        if (nombreInput) {
            const valor = nombreInput.value.trim();
            if (!valor) {
                mostrarError(nombreInput, 'El nombre del área de formación es obligatorio');
                esValido = false;
            } else if (!validarFormatoNombre(valor)) {
                mostrarError(nombreInput, 'El nombre no puede tener más de 255 caracteres');
                esValido = false;
            } else {
                // Verificar si el área de formación ya existe
                console.log('Verificando duplicados antes de enviar...');
                const existe = await verificarAreaFormacionExistente(valor);
                console.log('Resultado de verificación antes de enviar:', existe);
                if (existe) {
                    mostrarError(nombreInput, 'Ya existe un área de formación con este nombre');
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
    const modal = document.getElementById('modalCrearAreaFormacion');
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            console.log('Modal de área de formación cerrado, limpiando formulario...');
            form.reset();
            const errores = form.querySelectorAll('.error-validacion, .is-invalid');
            errores.forEach(error => {
                if (error.classList.contains('error-validacion')) {
                    error.remove();
                } else {
                    error.classList.remove('is-invalid');
                }
            });
            contenedorAlerta.innerHTML = '';
        });
    }

    console.log('Validaciones de área de formación inicializadas correctamente');
}

/**
 * Inicializa las validaciones para el formulario de grupo estable
 */
function inicializarValidacionesGrupoEstable() {
    console.log('Inicializando validaciones para grupo estable...');
    const form = document.getElementById('formGrupoEstable');
    console.log('Formulario de grupo estable encontrado:', form);
    
    if (!form) {
        console.error('No se encontró el formulario con ID formGrupoEstable');
        return;
    }

    // Elementos del formulario
    const nombreInput = document.getElementById('nombre_grupo_estable');
    const contenedorAlerta = document.createElement('div');
    contenedorAlerta.id = 'contenedorAlertaGrupoEstable';
    form.insertBefore(contenedorAlerta, form.firstChild);

    console.log('Elementos del formulario de grupo estable:', {
        nombreInput,
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
        contenedorAlerta.innerHTML = `
            <div class="alert alert-${tipo} alert-dismissible fade show mb-3" role="alert">
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        `;
    }

    // Función para validar el formato del nombre del grupo estable
    function validarFormatoNombre(valor) {
        return valor.trim().length > 0 && valor.trim().length <= 255;
    }

    // Función para verificar si el grupo estable ya existe
    async function verificarGrupoEstableExistente(nombre) {
        try {
            const url = new URL('/admin/area_formacion/verificar-grupo-estable', window.location.origin);
            url.searchParams.append('nombre', nombre);
            
            console.log('Solicitando URL:', url.toString());
            
            const response = await fetch(url.toString());
            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                console.error('Error en la respuesta:', response.status, errorData);
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
            console.error('Error al verificar el grupo estable:', error);
            return false; // En caso de error, asumimos que no existe para no bloquear al usuario
        }
    }

    // Validación en tiempo real para el campo de nombre
    if (nombreInput) {
        let timeoutId;
        let haHechoBlur = false;

        // Validar formato mientras se escribe
        nombreInput.addEventListener('input', function() {
            console.log('Evento input en nombre:', this.value);
            clearTimeout(timeoutId);
            const valor = this.value.trim();
            
            // Solo validar formato mientras se escribe, no si está vacío
            if (valor) {
                if (!validarFormatoNombre(valor)) {
                    mostrarError(this, 'El nombre no puede tener más de 255 caracteres');
                } else {
                    mostrarError(this, '');
                    
                    // Verificar duplicados después de un tiempo
                    timeoutId = setTimeout(async () => {
                        console.log('Verificando duplicados para:', valor);
                        const existe = await verificarGrupoEstableExistente(valor);
                        console.log('Resultado de verificación:', existe);
                        if (existe) {
                            mostrarError(this, 'Ya existe un grupo estable con este nombre');
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
        nombreInput.addEventListener('blur', function() {
            console.log('Evento blur en nombre:', this.value);
            haHechoBlur = true;
            const valor = this.value.trim();
            
            if (!valor) {
                mostrarError(this, 'El nombre del grupo estable es obligatorio');
            } else if (!validarFormatoNombre(valor)) {
                mostrarError(this, 'El nombre no puede tener más de 255 caracteres');
            } else {
                // Verificar duplicados al salir del campo
                verificarGrupoEstableExistente(valor).then(existe => {
                    console.log('Verificación después de blur:', existe);
                    if (existe) {
                        mostrarError(this, 'Ya existe un grupo estable con este nombre');
                    } else {
                        mostrarError(this, '');
                    }
                });
            }
        });
    }

    // Validación al enviar el formulario
    form.addEventListener('submit', async function(event) {
        console.log('Enviando formulario de grupo estable...');
        event.preventDefault();
        let esValido = true;
        
        // Validar nombre
        if (nombreInput) {
            const valor = nombreInput.value.trim();
            if (!valor) {
                mostrarError(nombreInput, 'El nombre del grupo estable es obligatorio');
                esValido = false;
            } else if (!validarFormatoNombre(valor)) {
                mostrarError(nombreInput, 'El nombre no puede tener más de 255 caracteres');
                esValido = false;
            } else {
                // Verificar si el grupo estable ya existe
                console.log('Verificando duplicados antes de enviar...');
                const existe = await verificarGrupoEstableExistente(valor);
                console.log('Resultado de verificación antes de enviar:', existe);
                if (existe) {
                    mostrarError(nombreInput, 'Ya existe un grupo estable con este nombre');
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
    const modal = document.getElementById('modalCrearGrupoEstable');
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            console.log('Modal de grupo estable cerrado, limpiando formulario...');
            form.reset();
            const errores = form.querySelectorAll('.error-validacion, .is-invalid');
            errores.forEach(error => {
                if (error.classList.contains('error-validacion')) {
                    error.remove();
                } else {
                    error.classList.remove('is-invalid');
                }
            });
            contenedorAlerta.innerHTML = '';
        });
    }

    console.log('Validaciones de grupo estable inicializadas correctamente');
}
