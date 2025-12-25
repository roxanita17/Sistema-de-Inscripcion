            // ================================
            // VALIDACIÓN EN TIEMPO REAL CÉDULAS
            // ================================

            const verificarnumero_documentoUrl = "{{ route('representante.verificar_numero_documento') }}";
            const buscarnumero_documentoUrl    = "{{ route('representante.buscar_numero_documento') }}";

            function marcarnumero_documentoError(input, mensaje) {
                input.classList.add('is-invalid');
                const errorId = input.id + '-error';
                let errorElement = document.getElementById(errorId);
                if (!errorElement) {
                    errorElement = document.createElement('small');
                    errorElement.className = 'text-danger';
                    errorElement.id = errorId;
                    input.closest('.form-group, .input-group').after(errorElement);
                }
                errorElement.textContent = mensaje;
            }

            function limpiarnumero_documentoError(input) {
                input.classList.remove('is-invalid');
                const errorId = input.id + '-error';
                const errorElement = document.getElementById(errorId);
                if (errorElement) {
                    errorElement.textContent = '';
                }
            }

            function numero_documentoSeRepiteEnFormulario(valor, idActual) {
                if (!valor) return false;
                const ids = ['numero_documento', 'numero_documento-padre', 'numero_documento-representante'];
                let contador = 0;
                ids.forEach(function(id) {
                    const campo = document.getElementById(id);
                    if (campo && campo.value === valor) {
                        contador++;
                    }
                });
                return contador > 1;
            }

            function verificarnumero_documentoCampo(selector, personaIdSelector) {
    const input = document.querySelector(selector);
    if (!input) return;

    input.addEventListener('blur', async function() {
        const valor = this.value.trim();
        limpiarnumero_documentoError(this);
        if (!valor) return;

        // Verificar si es el campo de cédula del representante y está seleccionado "Progenitor como Representante"
        const esProgenitorRepresentante = document.querySelector(
            'input[name="tipo_representante"][value="progenitor_representante"]:checked'
        ) !== null;

        if (this.id === 'numero_documento-representante' && esProgenitorRepresentante) {
            // No validar cédula duplicada si es progenitor representante
            limpiarnumero_documentoError(this);
            return;
        }

        // Verificar repetición dentro del mismo formulario
        if (numero_documentoSeRepiteEnFormulario(valor, this.id)) {
            marcarnumero_documentoError(this,
                'Esta cédula ya se está usando en otro bloque del formulario');
            return;
        }

        // Verificar contra la base de datos
        const personaId = personaIdSelector ? document.querySelector(personaIdSelector)?.value : '';

        try {
            const response = await fetch(
                `${verificarnumero_documentoUrl}?numero_documento=${valor}&persona_id=${personaId}`
            );
            
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Error al verificar la cédula');
            }

            const data = await response.json();
            console.log('Cédula válida:', data);
            limpiarnumero_documentoError(input);
            
            // Si hay datos de persona, rellenar automáticamente
            if (data.persona) {
                rellenarRepresentanteDesdeRespuesta(data);
            }
        } catch (error) {
            console.error('Error al verificar cédula:', error);
            marcarnumero_documentoError(input, error.message || 'Error al verificar la cédula');
        }
    });
}

            // Aplicar validación en tiempo real a las tres cédulas principales
            verificarnumero_documentoCampo('#numero_documento', null); // Madre
            verificarnumero_documentoCampo('#numero_documento-padre', null); // Padre
            verificarnumero_documentoCampo('#numero_documento-representante', '#persona-id-representante'); // Representante legal

            // ================================
            // BLOQUEO / DESBLOQUEO DE SECCIONES
            // ================================

            function toggleSeccionPorEstado(nombreEstado, cardBody, excepcionesNames) {
                const radios = document.querySelectorAll(`input[name="${nombreEstado}"]`);
                if (radios.length === 0 || !cardBody) return;

                function aplicarEstado() {
                    const valor = Array.from(radios).find(r => r.checked)?.value;
                    const esPresente = valor === 'Presente';

                    const inputs = cardBody.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        const name = input.name;
                        if (name && excepcionesNames.includes(name)) {
                            return; // no tocar radios de estado
                        }

                        if (esPresente) {
                            // habilitar
                            input.disabled = false;
                            const wasRequired = input.dataset.wasRequired;
                            if (wasRequired === 'true') {
                                input.required = true;
                            }
                        } else {
                            // deshabilitar
                            if (input.required) {
                                input.dataset.wasRequired = 'true';
                            }
                            input.required = false;
                            input.disabled = true;
                        }
                    });
                }

                // Inicialmente, si no hay selección, bloqueamos todo excepto los radios de estado
                if (!Array.from(radios).find(r => r.checked)) {
                    const inputs = cardBody.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        const name = input.name;
                        if (name && excepcionesNames.includes(name)) {
                            return;
                        }
                        if (input.required) {
                            input.dataset.wasRequired = 'true';
                        }
                        input.required = false;
                        input.disabled = true;
                    });
                } else {
                    aplicarEstado();
                }

                let valorPrevio = Array.from(radios).find(r => r.checked)?.value || null;

                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        const valorNuevo = this.value;
                        if (valorNuevo === 'Ausente') {
                            const confirmado = confirm('Marcar como AUSENTE bloqueará permanentemente la edición de esta sección en este formulario. ¿Desea continuar?');
                            if (!confirmado) {
                                // Volver al valor previo
                                if (valorPrevio) {
                                    radios.forEach(r => r.checked = r.value === valorPrevio);
                                } else {
                                    radios.forEach(r => r.checked = false);
                                }
                                return;
                            }
                        }
                        valorPrevio = valorNuevo;
                        aplicarEstado();
                    });
                });
            }

            // Madre: tomar el card-body de la primera tarjeta (Datos de la Madre)
            const cardMadreBody = document.getElementById('Presente_madre').closest('.card').querySelector('.card-body');
            toggleSeccionPorEstado('estado_madre', cardMadreBody, ['estado_madre']);

            // Refuerzo específico: asegurar bloqueo de ocupación y convive de la madre cuando está Ausente
            function aplicarBloqueoCamposMadre() {
                const estadoMadreVal = document.querySelector('input[name="estado_madre"]:checked')?.value;
                const esPresenteMadre = estadoMadreVal === 'Presente';

                const ocupacionMadre = document.getElementById('ocupacion-madre');
                const otraOcupacionMadre = document.getElementById('otra-ocupacion');
                const conviveSiMadre = document.getElementById('convive-si');
                const conviveNoMadre = document.getElementById('convive-no');

                if (esPresenteMadre) {
                    if (ocupacionMadre) {
                        ocupacionMadre.disabled = false;
                        ocupacionMadre.required = true;
                    }
                    // "Otra ocupación" solo requerida si el contenedor está visible
                    const otraOcupacionContainer = document.getElementById('otra-ocupacion-container');
                    if (otraOcupacionMadre && otraOcupacionContainer) {
                        otraOcupacionMadre.disabled = !otraOcupacionContainer.style.display || otraOcupacionContainer.style.display !== 'none';
                        otraOcupacionMadre.required = !otraOcupacionContainer.style.display || otraOcupacionContainer.style.display !== 'none';
                    }
                    if (conviveSiMadre) conviveSiMadre.disabled = false;
                    if (conviveNoMadre) conviveNoMadre.disabled = false;
                } else {
                    // Ausente u otro estado: bloquear relación familiar de la madre
                    if (ocupacionMadre) {
                        ocupacionMadre.disabled = true;
                        ocupacionMadre.required = false;
                    }
                    if (otraOcupacionMadre) {
                        otraOcupacionMadre.disabled = true;
                        otraOcupacionMadre.required = false;
                    }
                    if (conviveSiMadre) conviveSiMadre.disabled = true;
                    if (conviveNoMadre) conviveNoMadre.disabled = true;
                }
            }

            // Aplicar una vez al cargar y cada vez que cambie el estado de la madre
            aplicarBloqueoCamposMadre();
            document.querySelectorAll('input[name="estado_madre"]').forEach(radio => {
                radio.addEventListener('change', aplicarBloqueoCamposMadre);
            });

            // Padre: card-body de la tarjeta de Datos del Padre
            const cardPadreBody = document.getElementById('Presente_padre').closest('.card').querySelector('.card-body');
            toggleSeccionPorEstado('estado_padre', cardPadreBody, ['estado_padre']);

            // ================================
            // REPRESENTANTE LEGAL COMO PROGENITOR
            // ================================

            function rellenarRepresentanteDesdeRespuesta(resp) {
                if (!resp || !resp.data || !resp.data.persona) return;

                const persona = resp.data.persona;
                const representante = resp.data;
                const legal = resp.data.legal || {};

                document.getElementById('persona-id-representante').value = persona.id || '';
                document.getElementById('representante-id').value = representante.id || '';

                document.getElementById('primer-nombre-representante').value = persona.primer_nombre || '';
                document.getElementById('segundo-nombre-representante').value = persona.segundo_nombre || '';
                document.getElementById('tercer-nombre-representante').value = persona.tercer_nombre || '';
                document.getElementById('primer-apellido-representante').value = persona.primer_apellido || '';
                document.getElementById('segundo-apellido-representante').value = persona.segundo_apellido || '';
                document.getElementById('fechaNacimiento-representante').value = persona.fecha_nacimiento || '';
                
                const sexoRepresentante = document.getElementById('sexo-representante');
                if (sexoRepresentante) {
                    sexoRepresentante.value = persona.genero_id || '';
                }

                // Otros campos opcionales si existen
                const telefonoRepresentante = document.getElementById('telefono-representante');
                const lugarNacimientoRepresentante = document.getElementById('lugar-nacimiento-representante');
                if (telefonoRepresentante) telefonoRepresentante.value = persona.telefono || '';
                if (lugarNacimientoRepresentante) lugarNacimientoRepresentante.value = persona.direccion || '';

                // Correo: preferir el correo del representante legal, si no, el email de la persona
                const correo = legal.correo_representante || persona.email || '';
                document.getElementById('correo-representante').value = correo;
            }

function copiarDesdeMadreOPadreSiCoincide(numero_documento) {
    if (!numero_documento) return false;

    // Función para copiar ubicación
    const copiarUbicacion = (prefijoOrigen, prefijoDestino) => {
        const estado = document.getElementById(`${prefijoOrigen}Estado`).value;
        const municipio = document.getElementById(`${prefijoOrigen}Municipio`).value;
        const parroquia = document.getElementById(`id${prefijoOrigen === '' ? 'parroquia' : 'parroquia-padre'}`).value;
        
        if (estado) {
            document.getElementById('idEstado-representante').value = estado;
            cargarMunicipios(estado, 'idMunicipio-representante', 'idparroquia-representante');
            
            if (municipio) {
                setTimeout(() => {
                    document.getElementById('idMunicipio-representante').value = municipio;
                    cargarLocalidades(municipio, 'idparroquia-representante');
                    
                    if (parroquia) {
                        setTimeout(() => {
                            document.getElementById('idparroquia-representante').value = parroquia;
                        }, 100);
                    }
                }, 100);
            }
        }
    };

    // Función para copiar teléfono y prefijo
    const copiarTelefonoYPrefijo = (prefijoOrigen) => {
        const telefono = document.getElementById(`${prefijoOrigen}telefono`).value;
        const prefijo = document.getElementById(`${prefijoOrigen}prefijo`).value;
        
        if (telefono) document.getElementById('telefono-representante').value = telefono;
        if (prefijo) document.getElementById('prefijo-representante').value = prefijo;
    };

    // Función para copiar lugar de nacimiento
    const copiarLugarNacimiento = (prefijoOrigen) => {
        const lugarNacimiento = document.getElementById(`lugar-nacimiento${prefijoOrigen}`).value;
        if (lugarNacimiento) {
            document.getElementById('lugar-nacimiento-representante').value = lugarNacimiento;
        }
    };

    // Función para copiar ocupación
    const copiarOcupacion = (prefijoOrigen) => {
        const ocupacion = document.getElementById(`ocupacion-${prefijoOrigen}`).value;
        const ocupacionRepresentante = document.getElementById('ocupacion-representante');
        if (ocupacion && ocupacionRepresentante) {
            ocupacionRepresentante.value = ocupacion;
        }
    };

    // Función para copiar convivencia
    const copiarConvivencia = (prefijoOrigen) => {
        const convive = document.querySelector(`input[name="convive${prefijoOrigen}"]:checked`);
        const conviveSiRepresentante = document.querySelector('input[name="convive-representante"][value="si"]');
        const conviveNoRepresentante = document.querySelector('input[name="convive-representante"][value="no"]');
        
        if (convive) {
            if (convive.value === 'si' || convive.value === '1') {
                conviveSiRepresentante.checked = true;
            } else if (convive.value === 'no' || convive.value === '0') {
                conviveNoRepresentante.checked = true;
            }
        }
    };

    // MADRE
    const numero_documentoMadre = document.getElementById('numero_documento');
    if (numero_documentoMadre && numero_documentoMadre.value === numero_documento) {
        // Copiar datos personales
        document.getElementById('primer-nombre-representante').value = document.getElementById('primer-nombre').value || '';
        document.getElementById('segundo-nombre-representante').value = document.getElementById('segundo-nombre').value || '';
        document.getElementById('tercer-nombre-representante').value = document.getElementById('tercer-nombre').value || '';
        document.getElementById('primer-apellido-representante').value = document.getElementById('primer-apellido').value || '';
        document.getElementById('segundo-apellido-representante').value = document.getElementById('segundo-apellido').value || '';
        document.getElementById('fechaNacimiento-representante').value = document.getElementById('fechaNacimiento').value || '';
        
        const sexoRepresentante = document.getElementById('sexo-representante');
        const sexoMadre = document.getElementById('sexo');
        if (sexoRepresentante && sexoMadre) sexoRepresentante.value = sexoMadre.value;
        
        // Copiar datos adicionales
        copiarLugarNacimiento('');
        copiarTelefonoYPrefijo('');
        copiarUbicacion('', '');
        copiarOcupacion('madre');
        copiarConvivencia('');

        return true;
    }

    // PADRE
    const numero_documentoPadre = document.getElementById('numero_documento-padre');
    if (numero_documentoPadre && numero_documentoPadre.value === numero_documento) {
        // Copiar datos personales
        document.getElementById('primer-nombre-representante').value = document.getElementById('primer-nombre-padre').value || '';
        document.getElementById('segundo-nombre-representante').value = document.getElementById('segundo-nombre-padre').value || '';
        document.getElementById('tercer-nombre-representante').value = document.getElementById('tercer-nombre-padre')?.value || '';
        document.getElementById('primer-apellido-representante').value = document.getElementById('primer-apellido-padre').value || '';
        document.getElementById('segundo-apellido-representante').value = document.getElementById('segundo-apellido-padre')?.value || '';
        document.getElementById('fechaNacimiento-representante').value = document.getElementById('fechaNacimiento-padre').value || '';
        
        const sexoRepresentante = document.getElementById('sexo-representante');
        const generoPadre = document.getElementById('genero-padre');
        if (sexoRepresentante && generoPadre) sexoRepresentante.value = generoPadre.value;
        
        // Copiar datos adicionales
        copiarLugarNacimiento('-padre');
        copiarTelefonoYPrefijo('padre-');
        copiarUbicacion('padre-', 'padre-');
        copiarOcupacion('padre');
        copiarConvivencia('-padre');

        return true;
    }

    return false;
}3

            // Función para mostrar/ocultar el campo de organización
            function toggleOrganizacion() {
                const mostrar = document.querySelector('input[name="pertenece-organizacion"]:checked')?.value === 'si';
                const campoOrganizacion = document.getElementById('campo_organizacion');
                const inputOrganizacion = document.getElementById('cual-organizacion');
                
                if (campoOrganizacion) {
                    campoOrganizacion.style.display = mostrar ? 'block' : 'none';
                }
                if (inputOrganizacion) {
                    inputOrganizacion.required = mostrar;
                    if (!mostrar) {
                        inputOrganizacion.value = '';
                    }
                }
            }

            // Manejar cambios en la opción de pertenencia a organización
            document.querySelectorAll('input[name="pertenece-organizacion"]').forEach(radio => {
                radio.addEventListener('change', toggleOrganizacion);
            });
            toggleOrganizacion(); // Estado inicial

            // Estado inicial: bloquear completamente el bloque de representante legal
            const seccionRep = document.getElementById('datos-representante');
            if (seccionRep) {
                seccionRep.style.display = 'none';
                const inputs = seccionRep.querySelectorAll('input, select, textarea');
                inputs.forEach(input => input.disabled = true);
            }

            document.querySelectorAll('input[name="tipo_representante"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const tipo = this.value;
                    const seccionRep = document.getElementById('datos-representante');

                    if (!tipo) {
                        // Sin selección: ocultar y bloquear todo
                        if (seccionRep) {
                            seccionRep.style.display = 'none';
                            const inputs = seccionRep.querySelectorAll('input, select, textarea');
                            inputs.forEach(input => input.disabled = true);
                        }
                        return;
                    }

                    // Mostrar la sección y habilitar campos
                    if (seccionRep) {
                        seccionRep.style.display = 'block';
                        const inputs = seccionRep.querySelectorAll('input, select, textarea');
                        inputs.forEach(input => input.disabled = false);
                    }

                    // Si es progenitor_representante, intentar copiar datos del padre/madre
                    if (tipo === 'progenitor_representante') {
                        // Determinar si el padre o la madre está presente
                        const padrePresente = document.querySelector('input[name="estado_padre"]:checked')?.value === 'Presente';
                        const madrePresente = document.querySelector('input[name="estado_madre"]:checked')?.value === 'Presente';
                        
                        // Obtener los valores de los campos de cédula
                        const numero_documentoPadre = document.getElementById('numero_documento-padre')?.value;
                        const numero_documentoMadre = document.getElementById('numero_documento')?.value;
                        
                        // Obtener los valores de los campos de correo
                        const correoPadre = document.getElementById('email-padre')?.value;
                        const correoMadre = document.getElementById('email')?.value;
                        
                        // Obtener los tipos de documento
                        const tipoDocPadre = document.getElementById('tipo-ci-padre')?.value;
                        const tipoDocMadre = document.getElementById('tipo-ci')?.value;
                        
                        // Si el padre está presente, copiar sus datos
                        if (padrePresente && numero_documentoPadre) {
                            document.getElementById('numero_documento-representante').value = numero_documentoPadre;
                            const tipoCiRepresentante = document.getElementById('tipo-ci-representante');
                            if (tipoCiRepresentante && tipoDocPadre) {
                                tipoCiRepresentante.value = tipoDocPadre;
                            }
                            const correoRepresentante = document.getElementById('correo-representante');
                            if (correoRepresentante && correoPadre) {
                                correoRepresentante.value = correoPadre;
                            }
                            console.log('Datos copiados del padre:', { numero_documento: numero_documentoPadre, correo: correoPadre });
                        } 
                        // Si la madre está presente, copiar sus datos
                        else if (madrePresente && numero_documentoMadre) {
                            document.getElementById('numero_documento-representante').value = numero_documentoMadre;
                            const tipoCiRepresentante = document.getElementById('tipo-ci-representante');
                            if (tipoCiRepresentante && tipoDocMadre) {
                                tipoCiRepresentante.value = tipoDocMadre;
                            }
                            const correoRepresentante = document.getElementById('correo-representante');
                            if (correoRepresentante && correoMadre) {
                                correoRepresentante.value = correoMadre;
                            }
                            console.log('Datos copiados de la madre:', { numero_documento: numero_documentoMadre, correo: correoMadre });
                        }
                        
                        // Forzar el evento blur en la cédula para buscar datos adicionales
                        const numero_documentoRepresentante = document.getElementById('numero_documento-representante');
                        if (numero_documentoRepresentante && numero_documentoRepresentante.value) {
                            numero_documentoRepresentante.dispatchEvent(new Event('blur'));
                        }
                    }
                });
            });

            // Al salir de la cédula del representante, si el tipo es progenitor_representante,
            // primero intentamos copiar desde madre/padre; si no coincide, buscamos en BD
            document.getElementById('numero_documento-representante')?.addEventListener('blur', function() {
                const tipo = document.querySelector('input[name="tipo_representante"]:checked')?.value;
                const numero_documento = this.value;

                if (tipo !== 'progenitor_representante' || !numero_documento) {
                    return;
                }

                // 1) Intentar copiar desde los datos ya cargados en este formulario (madre/padre)
                const copiadoLocal = copiarDesdeMadreOPadreSiCoincide(numero_documento);
                if (copiadoLocal) {
                    return; // no hace falta ir a BD
                }

                // 2) Si no coincide con madre/padre, buscar en BD
                fetch(`${buscarnumero_documentoUrl}?numero_documento=${numero_documento}`)
                    .then(response => response.json())
                    .then(resp => {
                        if (resp && resp.status === 'success') {
                            rellenarRepresentanteDesdeRespuesta(resp);
                        }
                    })
                    .catch(error => {
                        console.error('Error al buscar cédula para representante legal como progenitor', error);
                    });
            });

            // Otras funciones
            document.querySelectorAll('input[name*="telefono"]').forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            });

            document.querySelectorAll('input[name*="numero_documento"]').forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '').substring(0, 8);
                });
            });
        });
    </script>