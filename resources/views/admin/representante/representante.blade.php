
@extends('adminlte::page')

@section('title', 'Gestión de Representantes')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@stop

@section('content_header')
    <div class="content-header-modern">
        <div class="header-content">

            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div>
                    <h1 class="title-main">Gestión de Representantes</h1>
                    <p class="title-subtitle">Administración de los representantes del sistema</p>
                </div>
            </div>

            {{-- Botón crear --}}
            <button type="button"
                    class="btn-create"
                    onclick="window.location.href='{{ route('representante.formulario') }}'"
                    @if(!$anioEscolarActivo) disabled @endif
                    title="{{ !$anioEscolarActivo ? 'Requiere año escolar activo' : 'Nuevo Representante' }}">
                <i class="fas fa-plus"></i>
                <span>Nuevo Representante</span>
            </button>

        </div>
    </div>
@stop

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Listado de Representantes</h3>
                        <form class="d-flex" role="search">
                            <input class="form-control" type="search"
                                   placeholder="Buscar por cédula, nombre o apellido" aria-label="Search"
                                   id="buscador">
                        </form>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Cédula</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Apellido</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col" class="text-end">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-representantes">
                                    @forelse($representantes as $rep)
                                        <tr>
                                            <td>{{ $rep->persona->numero_documento ?? 'N/A' }}</td>
                                            <td>{{ $rep->persona->primer_nombre ?? 'N/A' }}</td>
                                            <td>{{ $rep->persona->primer_apellido ?? 'N/A' }}</td>
                                            <td>
                                                @php
                                                    $tipoRepresentante = $rep->legal ? 'Representante Legal' : 'Progenitor';
                                                @endphp
                                                @if($tipoRepresentante === 'Representante Legal')
                                                    <span class="badge bg-primary">Representante Legal</span>
                                                @else
                                                    <span class="badge bg-secondary">Progenitor</span>
                                                @endif
                                            </td>
                                           <td>
                                        <div class="action-buttons">
                                            {{-- Ver detalles del representante --}}
                                            <button class="action-btn btn-view"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalVerDetalleRegistro"
                                                    
                                                    onclick='llenarModalRepresentante(@json($rep->persona), @json($rep), @json($rep->legal), @json($rep->legal ? $rep->legal->banco : null))'>
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            {{-- Editar representante --}}
                                            <button class="action-btn btn-edit"
                                                    @if(!$anioEscolarActivo) disabled @endif
                                                    title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Editar' }}"
                                                    onclick='abrirModalEditar(@json($rep->persona), @json($rep), @json($rep->legal))'>
                                                <i class="fas fa-pen"></i>
                                            </button>

                                            {{-- Eliminar representante --}}
                                            <button class="action-btn btn-delete"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#confirmarEliminarRepresentante{{ $rep->id }}"
                                                    @if(!$anioEscolarActivo) disabled @endif
                                                    title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Eliminar' }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                            
                                    </td>
                                        </tr>
                                    {{-- Modal de confirmación para eliminar representante --}}
                                    <div class="modal fade" id="confirmarEliminarRepresentante{{ $rep->id }}" tabindex="-1" aria-labelledby="modalLabelEliminarRep{{ $rep->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content modal-modern">
                                                <div class="modal-header-delete">
                                                    <div class="modal-icon-delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </div>
                                                    <h5 class="modal-title-delete" id="modalLabelEliminarRep{{ $rep->id }}">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body-delete">
                                                    <p>¿Deseas eliminar este representante?</p>
                                                    <p class="delete-warning">
                                                        Esta acción es un borrado suave: el registro no se eliminará físicamente,
                                                        pero dejará de aparecer en los listados.
                                                    </p>
                                                </div>
                                                <div class="modal-footer-delete">
                                                    <form action="{{ route('representante.destroy', $rep->id) }}" method="POST" class="w-100">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="footer-buttons">
                                                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn-modal-delete">Eliminar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-3">No hay representantes registrados.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer clearfix">
                        <div class="d-flex justify-content-end">
                            {{ $representantes->links() }}
                        </div>
                    </div>
                </div>

                {{-- Modal de detalles del representante --}}
                @include('admin.representante.modales.showModal')

                {{-- Modal de edición del representante --}}
                @include('admin.representante.modales.editarModal')

            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const ubicacionesData = @json($estados);

        function cargarMunicipios(estadoId, municipioSelectId, localidadSelectId) {
            const municipioSelect = document.getElementById(municipioSelectId);
            const localidadSelect = localidadSelectId ? document.getElementById(localidadSelectId) : null;

            if (!municipioSelect) return;

            municipioSelect.innerHTML = '<option value="">Seleccione un municipio</option>';
            if (localidadSelect) {
                localidadSelect.innerHTML = '<option value="">Seleccione una localidad</option>';
            }

            if (!estadoId) return;

            const estado = Array.isArray(ubicacionesData) ? ubicacionesData.find(e => e.id == estadoId) : null;
            if (!estado || !Array.isArray(estado.municipio)) return;

            estado.municipio.forEach(municipio => {
                const option = document.createElement('option');
                option.value = municipio.id;
                option.textContent = municipio.nombre_municipio || municipio.nombre || 'Sin nombre';
                municipioSelect.appendChild(option);
            });
        }

        function cargarLocalidades(municipioId, localidadSelectId) {
            const localidadSelect = document.getElementById(localidadSelectId);
            if (!localidadSelect) return;

            localidadSelect.innerHTML = '<option value="">Seleccione una localidad</option>';
            if (!municipioId) return;

            let localidades = [];
            if (Array.isArray(ubicacionesData)) {
                for (const estado of ubicacionesData) {
                    if (!Array.isArray(estado.municipio)) continue;
                    const municipio = estado.municipio.find(m => m.id == municipioId);
                    if (municipio && Array.isArray(municipio.localidades)) {
                        localidades = municipio.localidades;
                        break;
                    }
                }
            }

            localidades.forEach(localidad => {
                const option = document.createElement('option');
                option.value = localidad.id;
                option.textContent = localidad.nombre_localidad || localidad.nombre || 'Sin nombre';
                localidadSelect.appendChild(option);
            });
        }

        window.cargarMunicipiosRepresentante = function (estadoId) {
            cargarMunicipios(estadoId, 'idMunicipio-representante', 'idparroquia-representante');
        };

        window.cargarParroquiasRepresentante = function (municipioId) {
            cargarLocalidades(municipioId, 'idparroquia-representante');
        };

      function llenarModalRepresentante(persona, representante, legal, banco) {
    try {
        console.log('=== llenarModalRepresentante llamado ===');
        console.log('persona:', persona);
        console.log('representante:', representante);
        console.log('legal:', legal);
        console.log('banco:', banco);

        // Datos personales
        document.getElementById('modal-primer-nombre').textContent = persona.primer_nombre || '';
        document.getElementById('modal-segundo-nombre').textContent = persona.segundo_nombre || '';
        document.getElementById('modal-primer-apellido').textContent = persona.primer_apellido || '';
        document.getElementById('modal-segundo-apellido').textContent = persona.segundo_apellido || '';
        document.getElementById('modal-cedula').textContent = persona.numero_documento || '';
        document.getElementById('modal-lugar-nacimiento').textContent = persona.fecha_nacimiento || persona.lugar_nacimiento || '';

        // **DIRECCIÓN DE HABITACIÓN - AGREGAR ESTOS CAMPOS**
        if (document.getElementById('modal-direccion')) {
            document.getElementById('modal-direccion').textContent = persona.direccion || '';
        }
        
        // Cargar estado, municipio y parroquia
        if (representante.estado && document.getElementById('modal-estado')) {
            document.getElementById('modal-estado').textContent = representante.estado.nombre_estado || '';
        }
        if (representante.municipio && document.getElementById('modal-municipio')) {
            document.getElementById('modal-municipio').textContent = representante.municipio.nombre_municipio || '';
        }
        if (representante.parroquia && document.getElementById('modal-parroquia')) {
            document.getElementById('modal-parroquia').textContent = representante.parroquia.nombre_localidad || '';
        }

        // Contacto básico
        if (document.getElementById('modal-telefono')) {
            document.getElementById('modal-telefono').textContent = persona.telefono || '';
        }
        
        if (document.getElementById('modal-correo')) {
            const correoItem = document.getElementById('correo-detail-item');
            if (legal && legal.correo_representante) {
                document.getElementById('modal-correo').textContent = legal.correo_representante;
                if (correoItem) correoItem.style.display = '';
            } else {
                document.getElementById('modal-correo').textContent = '';
                if (correoItem) correoItem.style.display = 'none';
            }
        }

        // Ocupación
        let ocupacionNombre = '';
        if (representante.ocupacion && representante.ocupacion.nombre_ocupacion) {
            ocupacionNombre = representante.ocupacion.nombre_ocupacion;
        } else if (representante.ocupacion_representante) {
            ocupacionNombre = representante.ocupacion_representante;
        }
        document.getElementById('modal-ocupacion').textContent = ocupacionNombre;

        // Convive con el estudiante
        let convive = representante.convivenciaestudiante_representante;
        if (typeof convive !== 'undefined' && convive !== null) {
            document.getElementById('modal-convive').textContent = (convive === true || convive === 1 || convive === 'si' || convive === 'Sí') ? 'Sí' : 'No';
        } else {
            document.getElementById('modal-convive').textContent = '';
        }

        // Sección de representante legal
        const legalSection = document.getElementById('legal-info-section');
        if (legal && legalSection) {
            legalSection.style.display = 'block';

            document.getElementById('modal-parentesco').textContent = legal.parentesco || '';

            // **CARNET DE LA PATRIA AFILIADO - CORREGIR**
            const carnetEl = document.getElementById('modal-carnet-afiliado');
            if (carnetEl) {
                const tieneCarnet = legal.carnet_patria_afiliado; // 1 / 0
                carnetEl.textContent = tieneCarnet ? 'Afiliado' : 'No afiliado';
            }

            // **CÓDIGO Y SERIAL - CORREGIR**
            if (document.getElementById('modal-codigo')) {
                document.getElementById('modal-codigo').textContent = legal.codigo_carnet_patria_representante || '';
            }
            if (document.getElementById('modal-serial')) {
                document.getElementById('modal-serial').textContent = legal.serial_carnet_patria_representante || '';
            }

            // **TIPO DE CUENTA - AGREGAR**
            if (document.getElementById('modal-tipo-cuenta')) {
                document.getElementById('modal-tipo-cuenta').textContent = legal.tipo_cuenta || '';
            }

            // **BANCO - AGREGAR**
            if (document.getElementById('modal-banco')) {
                document.getElementById('modal-banco').textContent = banco ? (banco.nombre_banco || banco.nombre || '') : '';
            }

            // Pertenece a organización
            const perteneceOrgEl = document.getElementById('modal-pertenece-org');
            const campoOrg = document.getElementById('campo-organizacion');
            if (perteneceOrgEl) {
                const pertenece = legal.pertenece_a_organizacion_representante;
                if (pertenece) {
                    perteneceOrgEl.textContent = 'Sí';
                    if (campoOrg) campoOrg.style.display = '';
                    document.getElementById('modal-org-pertenece').textContent = legal.cual_organizacion_representante || '';
                } else {
                    perteneceOrgEl.textContent = 'No';
                    if (campoOrg) campoOrg.style.display = 'none';
                    document.getElementById('modal-org-pertenece').textContent = '';
                }
            }

        } else if (legalSection) {
            legalSection.style.display = 'none';
            const correoItem = document.getElementById('correo-detail-item');
            if (correoItem) correoItem.style.display = 'none';
        }

    } catch (e) {
        console.error('Error al llenar el modal de representante:', e);
    }
}

        function abrirModalEditar(persona, representante, legal) {
    // IDs para indicar que es edición
    document.getElementById('persona-id-representante').value = persona.id || '';
    document.getElementById('representante-id').value = representante.id || '';

    // Datos personales
    document.getElementById('tipo-ci-representante').value = persona.tipo_documento_id || '';
    document.getElementById('cedula-representante').value = persona.numero_documento || '';

    document.getElementById('primer-nombre-representante').value  = persona.primer_nombre || '';
    document.getElementById('segundo-nombre-representante').value = persona.segundo_nombre || '';
    document.getElementById('tercer-nombre-representante').value  = persona.tercer_nombre || '';
    document.getElementById('primer-apellido-representante').value  = persona.primer_apellido || '';
    document.getElementById('segundo-apellido-representante').value = persona.segundo_apellido || '';
    
    // Set gender if available
    if (persona.genero_id) {
        document.getElementById('sexo-representante').value = persona.genero_id;
    }
    
    // Set birthdate if available
    if (persona.fecha_nacimiento) {
        const fechaNacimiento = new Date(persona.fecha_nacimiento).toISOString().split('T')[0];
        document.getElementById('fecha-nacimiento-representante').value = fechaNacimiento;
    }

    // Dirección y contacto
    document.getElementById('lugar-nacimiento-representante').value = persona.direccion || '';
    document.getElementById('telefono-representante').value = persona.telefono || '';

    const estadoId = representante.estado_id || '';
    const municipioId = representante.municipio_id || '';
    const parroquiaId = representante.parroquia_id || '';

    document.getElementById('idEstado-representante').value = estadoId;

    if (estadoId) {
        cargarMunicipios(estadoId, 'idMunicipio-representante', 'idparroquia-representante');

        if (municipioId) {
            document.getElementById('idMunicipio-representante').value = municipioId;
            cargarLocalidades(municipioId, 'idparroquia-representante');

            if (parroquiaId) {
                document.getElementById('idparroquia-representante').value  = parroquiaId;
            }
        }
    }

    // Ocupación y convive
    document.getElementById('ocupacion-representante').value = representante.ocupacion_representante || '';
    if (representante.convivenciaestudiante_representante === 'si') {
        document.getElementById('convive-si').checked = true;
    } else {
        document.getElementById('convive-no-representante').checked = true;
    }

    // ---- Parte de REPRESENTANTE LEGAL ----
    const seccionLegal = document.getElementById('section-legal-representante');
    const inputLegalId = document.getElementById('representante_legal_id');
    const rowConect = document.getElementById('row-conectividad');

    if (legal) {
        
        if (seccionLegal) seccionLegal.style.display = '';
        if (rowConect) rowConect.style.display = '';
        if (inputLegalId) inputLegalId.value = legal.id || '';

        // Correo y organización
        document.getElementById('correo-representante').value = legal.correo_representante || '';

        if (legal.pertenece_a_organizacion_representante) {
            document.getElementById('opcion_si').checked = true;
            document.getElementById('campo_organizacion').style.display = '';
            document.getElementById('cual-organizacion').value = legal.cual_organizacion_representante || '';
        } else {
            document.getElementById('opcion_no').checked = true;
            document.getElementById('campo_organizacion').style.display = 'none';
            document.getElementById('cual-organizacion').value = '';
        }

        // Parentesco y carnet
        document.getElementById('parentesco').value = legal.parentesco || '';
        document.getElementById('codigo').value    = legal.codigo_carnet_patria_representante || '';
        document.getElementById('serial').value    = legal.serial_carnet_patria_representante || '';
        
        // Lugar de nacimiento y dirección
        document.getElementById('lugar-nacimiento-representante').value = persona.lugar_nacimiento || '';
        document.getElementById('direccion-habitacion').value = legal.direccion_representante || '';
        
        // Carnet de la patria (1: Padre, 2: Madre)
        if (legal.carnet_patria_afiliado) {
            document.getElementById('carnet-patria').value = legal.carnet_patria_afiliado;
        } else {
            document.getElementById('carnet-patria').value = '';
        }

        // Prefijo telefónico
        if (persona.prefijo_telefono_id) {
            document.getElementById('prefijo-representante').value = persona.prefijo_telefono_id;
        }

        // Tipo de cuenta y banco
        if (legal.tipo_cuenta) {
            // Asegurarse de que el valor sea '1' o '2' para coincidir con el select
            document.getElementById('tipo-cuenta').value = legal.tipo_cuenta.toString() === '1' ? '1' : '2';
        }
        if (legal.banco_id) {
            document.getElementById('banco-representante').value = legal.banco_id;
        }

    } else {
        // PROGENITOR: ocultar sección legal y limpiar campos
        if (seccionLegal) seccionLegal.style.display = 'none';
        if (inputLegalId) inputLegalId.value = '';
        if (rowConect) rowConect.style.display = 'none';

        document.getElementById('correo-representante').value = '';
        document.getElementById('parentesco').value = '';
        document.getElementById('codigo').value = '';
        document.getElementById('serial').value = '';
        document.getElementById('tipo-cuenta').value = '';
        document.getElementById('banco-representante').value = '';
        document.getElementById('opcion_si').checked = false;
        document.getElementById('opcion_no').checked = false;
        document.getElementById('campo_organizacion').style.display = 'none';
        document.getElementById('cual-organizacion').value = '';
    }

    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalEditarRepresentante'));
    modal.show();
}
    </script>

    <script>
        // Handle form submission for editing representative
        document.addEventListener('DOMContentLoaded', function() {
            const editForm = document.getElementById('form-editar-representante');
            
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const url = this.getAttribute('action');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    
                    // Find the submit button safely
                    const submitBtn = this.querySelector('button[type="submit"], input[type="submit"]');
                    let originalBtnContent = null;
                    
                    // If we found the button, store its current content
                    if (submitBtn) {
                        originalBtnContent = submitBtn.innerHTML;
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';
                    }
                    
                    // Send AJAX request
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken || '',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: data.message || 'Los datos se han actualizado correctamente.',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                // Close the modal and refresh the page
                                const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarRepresentante'));
                                if (modal) modal.hide();
                                window.location.reload();
                            });
                        } else {
                            // Show validation errors
                            let errorMessage = data.message || 'Error al actualizar los datos.';
                            if (data.errors) {
                                errorMessage = Object.values(data.errors).join('<br>');
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                html: errorMessage,
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al procesar la solicitud. Por favor, inténtalo de nuevo.',
                            confirmButtonText: 'Aceptar'
                        });
                    })
                    .finally(() => {
                        // Reset button state if we found the button
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            if (originalBtnContent !== null) {
                                submitBtn.innerHTML = originalBtnContent;
                            } else {
                                submitBtn.textContent = 'Guardar Cambios';
                            }
                        }
                    });
                });
            }
            
            // Handle organization radio buttons
            const opcionSi = document.getElementById('opcion_si');
            const opcionNo = document.getElementById('opcion_no');
            const campoOrganizacion = document.getElementById('campo_organizacion');
            
            if (opcionSi && opcionNo && campoOrganizacion) {
                opcionSi.addEventListener('change', function() {
                    campoOrganizacion.style.display = this.checked ? '' : 'none';
                    if (!this.checked) {
                        document.getElementById('cual-organizacion').value = '';
                    }
                });
                
                opcionNo.addEventListener('change', function() {
                    if (this.checked) {
                        campoOrganizacion.style.display = 'none';
                        document.getElementById('cual-organizacion').value = '';
                    }
                });
            }
        });
    </script>
@endsection
