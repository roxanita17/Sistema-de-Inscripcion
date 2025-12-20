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
            <button type="button" class="btn-create"
                onclick="window.location.href='{{ route('representante.formulario') }}'"
                @if (!$anioEscolarActivo) disabled @endif
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
                        <div class="d-flex gap-2">

                            <form class="d-flex" role="search">
                                <input class="form-control" type="search"
                                    placeholder="Buscar por cédula, nombre o apellido" aria-label="Search" id="buscador">
                            </form>
                            <div class="header-right" style="display: flex; gap: 5px;">
                                <div>
                                    <button class="btn-modal-create" data-bs-toggle="modal" data-bs-target="#modalFiltros">
                                        <i class="fas fa-filter"></i>
                                        Filtros
                                    </button>
                                </div>
                                <a href="{{ route('representante.reporte_pdf') }}" class="btn-pdf" id="generarPdfBtn" target="_blank">
                                    <i class="fas fa-file-pdf me-2"></i>Generar PDF
                                </a>

                                <div class="date-badge">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>{{ now()->translatedFormat('d M Y') }}</span>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="card-body-modern">
                        <div class="table-wrapper">
                            <table class="table-modern overflow-hidden hidden">
                                <thead>
                                    <tr style="text-align: center">
                                        <th style="text-align: center">Cédula</th>
                                        <th style="text-align: center">Nombre</th>
                                        <th style="text-align: center">Apellido</th>
                                        <th style="text-align: center">Tipo</th>
                                        <th style="text-align: center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-representantes" style="text-align: center">
                                    @forelse($representantes as $rep)
                                        <tr>
                                            <td>{{ $rep->persona->numero_documento ?? 'N/A' }}</td>
                                            <td>{{ $rep->persona->primer_nombre ?? 'N/A' }}</td>
                                            <td>{{ $rep->persona->primer_apellido ?? 'N/A' }}</td>
                                            <td>
                                                @php
                                                    $tipoRepresentante = $rep->legal
                                                        ? 'Representante Legal'
                                                        : 'Progenitor';
                                                @endphp
                                                @if ($tipoRepresentante === 'Representante Legal')
                                                    <span class="badge bg-primary">Representante Legal</span>
                                                @else
                                                    <span class="badge bg-secondary">Progenitor</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <div class="dropdown dropstart text-center">
                                                        <button
                                                            class="btn btn-light btn-sm rounded-circle shadow-sm action-btn"
                                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="fas fa-ellipsis-v"></i>
                                                        </button>

                                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                            {{-- Ver mas --}}
                                                            <li>
                                                                <button
                                                                    class="dropdown-item d-flex align-items-center text-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modalVerDetalleRegistro"
                                                                    onclick='llenarModalRepresentante(@json($rep->persona), @json($rep), @json($rep->legal), @json($rep->legal ? $rep->legal->banco : null))'
                                                                    title="Ver detalle  ">
                                                                    <i class="fas fa-eye me-2"></i>
                                                                    Ver más
                                                                </button>
                                                            </li>

                                                            {{-- Editar --}}
                                                            <li>
                                                                <a type="button"
                                                                    class="dropdown-item d-flex align-items-center text-warning"
                                                                    href="{{ route('representante.editar', $rep->id) }}"
                                                                    title="Editar"
                                                                    @if (!$anioEscolarActivo) disabled @endif
                                                                    title="{{ !$anioEscolarActivo ? 'Debe registrar un año escolar activo' : 'Editar' }}">
                                                                    <i class="fas fa-pen me-2"></i>
                                                                    Editar
                                                                </a>
                                                            </li>

                                                            {{-- Inactivar --}}
                                                            <li>
                                                                <button
                                                                    class="dropdown-item d-flex align-items-center text-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#confirmarEliminarRepresentante{{ $rep->id }}"
                                                                    @disabled(!$anioEscolarActivo) title="Eliminar">
                                                                    <i class="fas fa-trash me-2"></i>
                                                                    Eliminar
                                                                </button>
                                                            </li>

                                                            
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- Modal de confirmación para eliminar representante --}}
                                        <div class="modal fade" id="confirmarEliminarRepresentante{{ $rep->id }}"
                                            tabindex="-1" aria-labelledby="modalLabelEliminarRep{{ $rep->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content modal-modern">
                                                    <div class="modal-header-delete">
                                                        <div class="modal-icon-delete">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </div>
                                                        <h5 class="modal-title-delete"
                                                            id="modalLabelEliminarRep{{ $rep->id }}">Confirmar
                                                            Eliminación</h5>
                                                        <button type="button" class="btn-close-modal"
                                                            data-bs-dismiss="modal" aria-label="Cerrar">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body-delete">
                                                        <p>¿Deseas eliminar este representante?</p>
                                                        <p class="delete-warning">
                                                            Esta acción es un borrado suave: el registro no se eliminará
                                                            físicamente,
                                                            pero dejará de aparecer en los listados.
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer-delete">
                                                        <form action="{{ route('representante.destroy', $rep->id) }}"
                                                            method="POST" class="w-100">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="footer-buttons">
                                                                <button type="button" class="btn-modal-cancel"
                                                                    data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    class="btn-modal-delete">Eliminar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-3">No hay representantes registrados.
                                            </td>
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

            </div>
        </div>
    </div>
@endsection

@include('admin.representante.modales.filtroModal')

@section('js')
    <script>
        // Obtener la lista de ocupaciones desde el controlador
        const ocupaciones = @json(\App\Models\Ocupacion::all());
        
        // Configuración de fechas por defecto
        
        // Manejar la búsqueda de representantes
        document.addEventListener('DOMContentLoaded', function() {
            const buscador = document.getElementById('buscador');
            const tbody = document.getElementById('tbody-representantes');
            const pagination = document.querySelector('.pagination');
            const tabla = document.querySelector('.table-modern');

            if (buscador && tbody) {
                let timeoutId;
                
                // Función para realizar la búsqueda
                const buscarRepresentantes = async (termino) => {
                    try {
                        const response = await fetch(`/representante/filtrar?buscador=${encodeURIComponent(termino)}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        
                        if (!response.ok) {
                            const errorText = await response.text();
                            console.error('Error en la respuesta del servidor:', response.status, errorText);
                            throw new Error(`Error en la búsqueda: ${response.status} ${response.statusText}`);
                        }
                        
                        let data;
                        try {
                            data = await response.json();
                        } catch (e) {
                            console.error('Error al analizar la respuesta JSON:', e);
                            const errorText = await response.text();
                            console.error('Respuesta del servidor:', errorText);
                            throw new Error('La respuesta del servidor no es un JSON válido');
                        }
                        
                        if (data.status === 'success') {
                            // Actualizar la tabla con los resultados
                            tbody.innerHTML = '';
                            
                            if (data.data.data && data.data.data.length > 0) {
                                data.data.data.forEach(rep => {
                                    const fila = document.createElement('tr');
                                    
                                    // Crear celdas con los datos del representante
                                    const celdas = [
                                        rep.persona?.numero_documento || 'N/A',
                                        rep.persona?.primer_nombre || 'N/A',
                                        rep.persona?.primer_apellido || 'N/A',
                                        // Agregar más celdas según sea necesario
                                        `
                                        <div class="action-buttons">
                                            <div class="dropdown dropstart text-center">
                                                <button class="btn btn-light btn-sm rounded-circle shadow-sm action-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="#" onclick="verDetalles(${rep.id})">
                                                            <i class="fas fa-eye me-2"></i> Ver Detalles
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="/representante/" + rep.id + "/editar">
                                                            <i class="fas fa-edit me-2"></i> Editar
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#confirmarEliminarRepresentante${rep.id}">
                                                            <i class="fas fa-trash-alt me-2"></i> Eliminar
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        `
                                    ];
                                    
                                    celdas.forEach(texto => {
                                        const celda = document.createElement('td');
                                        celda.innerHTML = texto;
                                        fila.appendChild(celda);
                                    });
                                    
                                    tbody.appendChild(fila);
                                });
                            } else {
                                const fila = document.createElement('tr');
                                const celda = document.createElement('td');
                                celda.colSpan = 5;
                                celda.className = 'text-center py-3';
                                celda.textContent = 'No se encontraron resultados';
                                fila.appendChild(celda);
                                tbody.appendChild(fila);
                            }
                            
                            // Actualizar la paginación si existe
                            if (pagination && data.data.links) {
                                pagination.innerHTML = '';
                                data.data.links.forEach(link => {
                                    const li = document.createElement('li');
                                    li.className = `page-item ${link.active ? 'active' : ''} ${!link.url ? 'disabled' : ''}`;
                                    
                                    const a = document.createElement('a');
                                    a.className = 'page-link';
                                    a.href = link.url || '#';
                                    a.innerHTML = link.label.replace('&laquo;', '«').replace('&raquo;', '»');
                                    
                                    li.appendChild(a);
                                    pagination.appendChild(li);
                                });
                            }
                            
                            // Mostrar la tabla si estaba oculta
                            if (tabla) {
                                tabla.classList.remove('hidden');
                            }
                        }
                    } catch (error) {
                        console.error('Error al buscar representantes:', error);
                    }
                };
                
                // Evento para el campo de búsqueda
                buscador.addEventListener('input', function(e) {
                    clearTimeout(timeoutId);
                    const termino = e.target.value.trim();
                    
                    // Esperar 500ms después de que el usuario deje de escribir
                    timeoutId = setTimeout(() => {
                        if (termino.length >= 2 || termino.length === 0) {
                            buscarRepresentantes(termino);
                        }
                    }, 500);
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Establecer rango de fechas por defecto (mes actual)
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);

            // Formatear fechas para el input date (YYYY-MM-DD)
            const formatDate = (date) => {
                const d = new Date(date);
                let month = '' + (d.getMonth() + 1);
                let day = '' + d.getDate();
                const year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [year, month, day].join('-');
            };

            // Establecer valores por defecto
            document.getElementById('fecha_inicio').value = formatDate(firstDay);
            document.getElementById('fecha_fin').value = formatDate(today);

            // Validación de fechas
            document.getElementById('formReporte').addEventListener('submit', function(e) {
                const fechaInicio = document.getElementById('fecha_inicio').value;
                const fechaFin = document.getElementById('fecha_fin').value;

                if (fechaInicio && fechaFin && new Date(fechaInicio) > new Date(fechaFin)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'La fecha de inicio no puede ser mayor a la fecha de fin',
                        confirmButtonColor: '#3085d6',
                    });
                }
            });
        });

        function llenarModalRepresentante(persona, representante, legal, banco) {
            try {
                console.log('=== llenarModalRepresentante llamado ===');
                console.log('persona:', persona);
                console.log('representante:', representante);
                console.log('legal:', legal);
                console.log('banco:', banco);

                // Actualizar el título con el tipo de representante
                const tipoBadge = document.getElementById('tipo-representante-badge');
                if (legal && legal.id) {
                    // Es representante legal
                    tipoBadge.textContent = 'Representante Legal';
                    tipoBadge.className = 'text-white fw-medium';
                } else {
                    // Es progenitor
                    tipoBadge.textContent = 'Progenitor';
                    tipoBadge.className = 'text-white fw-medium';
                }

                // Datos personales
                document.getElementById('modal-primer-nombre').textContent = persona.primer_nombre || '';
                document.getElementById('modal-segundo-nombre').textContent = persona.segundo_nombre || '';
                document.getElementById('modal-primer-apellido').textContent = persona.primer_apellido || '';
                document.getElementById('modal-segundo-apellido').textContent = persona.segundo_apellido || '';
                document.getElementById('modal-numero_documento').textContent = persona.numero_documento || '';
                
                // Formatear fecha de nacimiento
                let fechaNacimiento = persona.fecha_nacimiento ? new Date(persona.fecha_nacimiento) : null;
                if (fechaNacimiento && !isNaN(fechaNacimiento)) {
                    const dia = String(fechaNacimiento.getDate()).padStart(2, '0');
                    const mes = String(fechaNacimiento.getMonth() + 1).padStart(2, '0');
                    const anio = fechaNacimiento.getFullYear();
                    document.getElementById('modal-lugar-nacimiento').textContent = `${dia}/${mes}/${anio}`;
                } else {
                    // Si no hay fecha de nacimiento, mostrar lugar de nacimiento o mensaje por defecto
                    document.getElementById('modal-lugar-nacimiento').textContent = persona.lugar_nacimiento || 'No especificado';
                }

                // Contacto básico
                if (document.getElementById('modal-telefono')) {
                    // Teléfono se guarda en Persona.telefono según el controlador
                    document.getElementById('modal-telefono').textContent = persona.telefono || '';
                }
                if (document.getElementById('modal-correo')) {
                    const correoItem = document.getElementById('correo-detail-item');
                    if (legal && legal.correo_representante) {
                        // Solo mostrar correo cuando hay representante legal
                        document.getElementById('modal-correo').textContent = legal.correo_representante;
                        if (correoItem) correoItem.style.display = '';
                    } else {
                        // Para progenitor, ocultar completamente el bloque de correo
                        document.getElementById('modal-correo').textContent = '';
                        if (correoItem) correoItem.style.display = 'none';
                    }
                }

                // Ocupación (usando relación ocupacion si viene cargada)
                let ocupacionNombre = '';
                if (representante.ocupacion && representante.ocupacion.nombre_ocupacion) {
                    // Si la relación ocupación está cargada con el modelo
                    ocupacionNombre = representante.ocupacion.nombre_ocupacion;
                } else if (typeof ocupaciones !== 'undefined' && ocupaciones.length > 0 && representante.ocupacion_representante) {
                    // Buscar la ocupación por ID en el array global de ocupaciones
                    const ocupacion = ocupaciones.find(oc => oc.id == representante.ocupacion_representante);
                    ocupacionNombre = ocupacion ? ocupacion.nombre_ocupacion : `ID: ${representante.ocupacion_representante}`;
                } else if (representante.ocupacion_representante) {
                    // Si no hay array de ocupaciones, mostrar el ID como último recurso
                    ocupacionNombre = `ID: ${representante.ocupacion_representante}`;
                }
                document.getElementById('modal-ocupacion').textContent = ocupacionNombre || 'No especificada';

                // Convive con el estudiante
                let convive = representante.convivenciaestudiante_representante;
                if (typeof convive !== 'undefined' && convive !== null) {
                    document.getElementById('modal-convive').textContent = (convive === true || convive === 1 || convive ===
                        'si' || convive === 'Sí') ? 'Sí' : 'No';
                } else {
                    document.getElementById('modal-convive').textContent = '';
                }

                // Sección de representante legal
                const legalSection = document.getElementById('legal-info-section');
                if (legal && legalSection) {
                    legalSection.style.display = 'block';

                    document.getElementById('modal-parentesco').textContent = legal.parentesco || '';

                    // Carnet de la patria (afiliado o no)
                    const carnetEl = document.getElementById('modal-carnet-afiliado');
                    if (carnetEl) {
                        const tieneCarnet = legal.carnet_patria_afiliado; // 1 / 0
                        carnetEl.textContent = tieneCarnet ? 'Afiliado' : 'No afiliado';
                    }

                    // Código y serial de carnet (según controlador)
                    if (document.getElementById('modal-codigo')) {
                        document.getElementById('modal-codigo').textContent = legal.codigo_carnet_patria_representante ||
                        '';
                    }
                    if (document.getElementById('modal-serial')) {
                        document.getElementById('modal-serial').textContent = legal.serial_carnet_patria_representante ||
                        '';
                    }

                    // Pertenece a organización
                    const perteneceOrgEl = document.getElementById('modal-pertenece-org');
                    const campoOrg = document.getElementById('campo-organizacion');
                    if (perteneceOrgEl) {
                        const pertenece = legal.pertenece_a_organizacion_representante;
                        if (pertenece) {
                            perteneceOrgEl.textContent = 'Sí';
                            if (campoOrg) campoOrg.style.display = '';
                            document.getElementById('modal-org-pertenece').textContent = legal
                                .cual_organizacion_representante || '';
                        } else {
                            perteneceOrgEl.textContent = 'No';
                            if (campoOrg) campoOrg.style.display = 'none';
                            document.getElementById('modal-org-pertenece').textContent = '';
                        }
                    }

                } else if (legalSection) {
                    // Si no es representante legal, ocultar sección
                    legalSection.style.display = 'none';

                    // Y asegurarse de que el bloque de correo no se muestre para progenitor
                    const correoItem = document.getElementById('correo-detail-item');
                    if (correoItem) correoItem.style.display = 'none';
                }

            } catch (e) {
                console.error('Error al llenar el modal de representante:', e);
            }
        }

        // Actualizar el enlace de generación de PDF con los filtros actuales
        function actualizarEnlacePDF() {
            const generarPdfBtn = document.getElementById('generarPdfBtn');
            if (generarPdfBtn) {
                // Obtener todos los parámetros de la URL actual
                const urlParams = new URLSearchParams(window.location.search);
                
                // Construir la URL base del reporte
                let reportUrl = generarPdfBtn.getAttribute('href').split('?')[0];
                const params = new URLSearchParams();
                
                // Agregar todos los parámetros de filtro actuales
                for (const [key, value] of urlParams.entries()) {
                    if (key === 'page') continue; // No incluir la paginación en el reporte
                    params.append(key, value);
                }
                
                // Si hay parámetros, agregarlos a la URL
                if (params.toString()) {
                    reportUrl += '?' + params.toString();
                }
                
                // Actualizar el atributo href del botón
                generarPdfBtn.setAttribute('href', reportUrl);
                
                console.log('Enlace de PDF actualizado:', reportUrl);
            }
        }
        
        // Manejar el envío del formulario de filtros
        const filtroForm = document.getElementById('filtroForm');
        if (filtroForm) {
            filtroForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Obtener el valor seleccionado
                const tipoRepresentante = document.getElementById('tipo_representante').value;
                
                // Construir la URL con los parámetros de filtro
                const url = new URL(window.location.href.split('?')[0]);
                
                // Solo agregar el parámetro si hay un valor seleccionado
                if (tipoRepresentante !== '') {
                    url.searchParams.set('es_legal', tipoRepresentante);
                } else {
                    url.searchParams.delete('es_legal');
                }
                
                // Cerrar el modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalFiltros'));
                if (modal) {
                    modal.hide();
                }
                
                // Actualizar el enlace del PDF antes de redirigir
                actualizarEnlacePDF();
                
                // Redirigir a la URL con los filtros aplicados
                window.location.href = url.toString();
            });
        }
        
        // Inicializar el enlace de PDF cuando el documento esté listo
        document.addEventListener('DOMContentLoaded', function() {
            // Actualizar el enlace de PDF al cargar la página
            actualizarEnlacePDF();
            
            // Actualizar el enlace de PDF cuando cambie la URL (navegación con filtros)
            window.addEventListener('popstate', actualizarEnlacePDF);
            
            // Actualizar el enlace cuando se muestre el modal de filtros
            const filtroModal = document.getElementById('modalFiltros');
            if (filtroModal) {
                filtroModal.addEventListener('shown.bs.modal', function() {
                    // Asegurarse de que el select muestre el valor actual del filtro
                    const urlParams = new URLSearchParams(window.location.search);
                    const tipoRepresentante = urlParams.get('es_legal');
                    const selectTipo = document.getElementById('tipo_representante');
                    if (selectTipo) {
                        selectTipo.value = tipoRepresentante !== null ? tipoRepresentante : '';
                    }
                });
            }
            window.addEventListener('popstate', function() {
                actualizarEnlacePDF();
            });
        });
    </script>
@endsection
