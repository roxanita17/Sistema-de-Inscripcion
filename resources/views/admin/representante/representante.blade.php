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
                                <button type="button" class="btn-pdf" target="_blank" data-bs-toggle="modal"
                                    data-bs-target="#modalGenerarReporte">
                                    <i class="fas fa-file-pdf"></i> Generar Reporte
                                </button>
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

<!-- Modal Generar Reporte -->
<div class="modal fade" id="modalGenerarReporte" tabindex="-1" aria-labelledby="modalGenerarReporteLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGenerarReporteLabel">
                    <i class="fas fa-file-pdf me-2"></i>Generar Reporte
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formReporte" action="{{ route('representante.reporte_pdf') }}" method="GET"
                target="_blank">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tipo_representante" class="form-label">Tipo de Representante</label>
                        <select class="form-select" id="tipo_representante" name="es_legal">
                            <option value="">Todos los representantes</option>
                            <option value="1">Solo representantes legales</option>
                            <option value="0">Solo representantes no legales</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-pdf">
                        <i class="fas fa-download me-1"></i> Generar PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
    <script>
        // Configuración de fechas por defecto
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
                document.getElementById('modal-lugar-nacimiento').textContent = persona.fecha_nacimiento || persona
                    .lugar_nacimiento || '';

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
                    ocupacionNombre = representante.ocupacion.nombre_ocupacion;
                } else if (representante.ocupacion_representante) {
                    ocupacionNombre = representante.ocupacion_representante;
                }
                document.getElementById('modal-ocupacion').textContent = ocupacionNombre;

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
    </script>
@endsection
