@extends('adminlte::page')

@section('title', 'Estudiantes Nuevo Ingreso')

@section('content_header')
    <h1>Estudiantes Nuevo Ingreso Inscritos</h1>
@stop

@section('content')
    @php
    $anoActivo = App\Models\AnioEscolar::whereIn('status', ['Activo', 'Extendido'])->first();
    @endphp

    <div class="container-fluid">
        @if (!$anoActivo)
            <div class="alert alert-warning">
                <h5><i class="icon fas fa-exclamation-triangle"></i> Año Escolar Inactivo</h5>
                No puede registrar estudiantes en este momento porque no hay un año escolar activo.
                <a href="{{ route('admin.anio_escolar.index') }}" class="alert-link">Registrar Año Escolar</a>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Lista de Estudiantes Inscritos</h3>
                    <div class="card-tools">
                        <a href="{{route('admin.inscripcion.estudiante')}}" class="btn btn-primary btn-sm mr-2" @disabled(!$anoActivo)>
                            <i class="fas fa-plus"></i> Inscribir
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- Barra de búsqueda -->
                <div class="row mb-3">
                    <div class="col-md-6 offset-md-6">
                        <div class="input-group">
                            <input type="search" class="form-control" 
                                   placeholder="Buscar por nombre, apellido o cédula..."
                                   id="buscador">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Estudiante</th>
                                <th>Cédula</th>
                                <th>Fecha de Inscripción</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla">
                            <!-- Los datos se cargarán dinámicamente aquí -->
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">Cargando...</span>
                                    </div>
                                    <p class="mt-2 text-muted">Cargando estudiantes...</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detalles Estudiante -->
    <div class="modal fade" id="modalVerDetalleRegistro" tabindex="-1" role="dialog" 
         aria-labelledby="modalVerDetalleRegistroLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="modalVerDetalleRegistroLabel">
                        <i class="fas fa-user-graduate mr-2"></i>Detalles del Estudiante
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detalleEstudianteContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Cargando...</span>
                        </div>
                        <p class="mt-2 text-muted">Cargando información del estudiante...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Confirmación Eliminar -->
    <div class="modal fade" id="modalConfirmacionEliminar" tabindex="-1" role="dialog" 
         aria-labelledby="modalConfirmacionEliminarLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="modalConfirmacionEliminarLabel">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Eliminar Inscripción
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="estudiante_id_eliminar" value="">
                    <h4 class="text-center">¿Está seguro que desea eliminar esta inscripción?</h4>
                    <h5 class="text-center text-danger">Esta acción eliminará:</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">• La inscripción de nuevo ingreso</li>
                        <li class="list-group-item">• Los datos del estudiante</li>
                        <li class="list-group-item">• Los datos del representante</li>
                    </ul>
                    <p class="text-center text-danger mt-3"><strong>¡Esta acción es irreversible!</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-ban mr-1"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" onclick="eliminar()">
                        <i class="fas fa-trash mr-1"></i> Eliminar
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
@stop

@section('js')
<script>
// Configuración global de las constantes de URL
const URL_ESTUDIANTE_LISTAR = '{{ route("admin.inscripciones.listar") }}';
const URL_ESTUDIANTE_DETALLE = '{{ route("admin.inscripciones.detalle", ":id") }}';
const URL_ESTUDIANTE_EDITAR = '{{ route("admin.nuevo_ingreso.editar", ":id") }}';
const URL_ESTUDIANTE_ELIMINAR = '{{ route("admin.nuevo_ingreso.eliminar", ":id") }}';
const URL_ESTUDIANTE_BUSCAR = '{{ route("admin.nuevo_ingreso.buscar") }}';

// Función para cargar los datos en la tabla
function cargarEstudiantesInscritos(buscar = '') {
    fetch(`${URL_ESTUDIANTE_LISTAR}?search=${encodeURIComponent(buscar)}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('Datos recibidos:', data);

        const tabla = document.getElementById('tabla');

        if (data.success && data.data.length > 0) {
            tabla.innerHTML = '';

            data.data.forEach(estudiante => {
                const fila = document.createElement('tr');

                // Determinar clase de estado
                let claseEstado = '';
                let textoEstado = '';
                let iconoEstado = '';

                switch(estudiante.estado) {
                    case 'pendiente':
                        claseEstado = 'warning';
                        textoEstado = 'Pendiente';
                        break;
                    case 'completada':
                        claseEstado = 'success';
                        textoEstado = 'Completada';
                        break;
                    case 'rechazada':
                        claseEstado = 'danger';
                        textoEstado = 'Rechazada';
                        break;
                    default:
                        claseEstado = 'secondary';
                        textoEstado = estudiante.estado;
                }

                fila.innerHTML = `
                    <td>
                        <div class="ms-3">
                            <h6 class="mb-0">${estudiante.id}</h6>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="ms-3">
                                <h6 class="mb-0">${estudiante.nombre_completo}</h6>
                                <small class="text-muted">${estudiante.grado}° Año</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-primary">${estudiante.cedula}</span>
                    </td>
                    <td>
                        ${new Date(estudiante.fecha_inscripcion).toLocaleDateString('es-ES')}
                    </td>
                    <td>
                        <span class="badge bg-${claseEstado}">
                            ${textoEstado}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-info btn-sm" onclick="verDetalle(${estudiante.id})" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="editarInscripcion(${estudiante.id})" title="Editar inscripción">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmarEliminacion(${estudiante.id})" title="Eliminar inscripción">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                `;

                tabla.appendChild(fila);
            });
        } else {
            tabla.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-inbox display-4 d-block mb-2"></i>
                            <h5>No hay estudiantes inscritos</h5>
                            <p class="mb-0">Comienza inscribiendo un nuevo estudiante</p>
                        </div>
                    </td>
                </tr>
            `;
        }
    })
    .catch(error => {
        console.error('Error al cargar estudiantes:', error);
        const tabla = document.getElementById('tabla');
        tabla.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-danger py-4">
                    <i class="fas fa-exclamation-triangle display-4 d-block mb-2"></i>
                    <h5>Error al cargar los datos</h5>
                    <p class="mb-0">Por favor, recarga la página</p>
                </td>
            </tr>
        `;
    });
}

function verDetalle(id) {
    fetch(URL_ESTUDIANTE_DETALLE.replace(':id', id), {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const estudiante = data.data;
            const contenido = document.getElementById('detalleEstudianteContent');

            // Procesar documentos entregados
            let documentosHTML = '';
            if (estudiante.documentos_entregados) {
                const documentosEntregados = Array.isArray(estudiante.documentos_entregados)
                    ? estudiante.documentos_entregados
                    : JSON.parse(estudiante.documentos_entregados || '[]');

                const documentosLista = {
                    'partida_nacimiento': 'Partida de Nacimiento',
                    'copia_cedula_representante': 'Copia de Cédula del Representante',
                    'copia_cedula_estudiante': 'Copia de Cédula del Estudiante',
                    'boletin_6to_grado': 'Boletín de 6to Grado',
                    'certificado_calificaciones': 'Certificado de Calificaciones',
                    'constancia_aprobacion_primaria': 'Constancia de Aprobación Primaria',
                    'foto_estudiante': 'Fotografía Tipo Carnet Del Estudiante',
                    'foto_representante': 'Fotografía Tipo Carnet Del Representante',
                    'carnet_vacunacion': 'Carnet de Vacunación Vigente',
                    'autorizacion_tercero': 'Autorización Firmada (si el estudiante está siendo inscrito por un tercero)'
                };

                documentosHTML = `
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="border-bottom pb-2 mb-3">Documentos Entregados</h6>
                        <div class="row">
                            ${Object.entries(documentosLista).map(([key, label], index) => {
                                const entregado = documentosEntregados.includes(key);
                                return `
                                <div class="col-md-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-${entregado ? 'success' : 'danger'} me-2">
                                            <i class="fas ${entregado ? 'fa-check' : 'fa-times'}"></i>
                                        </span>
                                        <span class="${entregado ? 'text-success' : 'text-danger'}">
                                            ${label}
                                        </span>
                                    </div>
                                </div>
                                `;
                            }).join('')}
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <strong>Resumen:</strong>
                                ${documentosEntregados.length} de ${Object.keys(documentosLista).length} documentos entregados
                                (${Math.round((documentosEntregados.length / Object.keys(documentosLista).length) * 100)}%)
                            </small>
                        </div>
                    </div>
                </div>
                `;
            } else {
                documentosHTML = `
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="border-bottom pb-2 mb-3">Documentos Entregados</h6>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            No hay información de documentos registrada.
                        </div>
                    </div>
                </div>
                `;
            }

            contenido.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2 mb-3">Información del Estudiante</h6>
                        <p><strong>Nombre completo:</strong> ${estudiante.estudiante?.persona?.nombre_uno || ''} ${estudiante.estudiante?.persona?.apellido_uno || ''}</p>
                        <p><strong>Cédula:</strong> ${estudiante.estudiante?.persona?.tipo_cedula_persona || ''}-${estudiante.estudiante?.persona?.numero_cedula_persona || ''}</p>
                        <p><strong>Fecha nacimiento:</strong> ${estudiante.estudiante?.persona?.fecha_nacimiento_personas ? new Date(estudiante.estudiante.persona.fecha_nacimiento_personas).toLocaleDateString('es-ES') : ''}</p>
                        <p><strong>Sexo:</strong> ${estudiante.estudiante?.persona?.sexo || ''}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2 mb-3">Información de Inscripción</h6>
                        <p><strong>Fecha inscripción:</strong> ${new Date(estudiante.fecha_inscripcion).toLocaleDateString('es-ES')}</p>
                        <p><strong>Año:</strong> ${estudiante.grado_academico}°</p>
                        <p><strong>Sección:</strong> ${estudiante.seccion_academico}</p>
                        <p><strong>Estado:</strong> <span class="badge bg-${estudiante.status === 'completada' ? 'success' : estudiante.status === 'pendiente' ? 'warning' : 'danger'}">${estudiante.status}</span></p>
                        <p><strong>Año escolar:</strong> ${estudiante.anoEscolar?.inicio_anio_escolar || ''} - ${estudiante.anoEscolar?.cierre_anio_escolar || ''}</p>
                    </div>
                </div>

                ${estudiante.representante ? `
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="border-bottom pb-2 mb-3">Información del Representante</h6>
                        <p><strong>Nombre:</strong> ${estudiante.representante.persona?.nombre_uno || ''} ${estudiante.representante.persona?.apellido_uno || ''}</p>
                        <p><strong>Cédula:</strong> ${estudiante.representante.persona?.tipo_cedula_persona || ''}-${estudiante.representante.persona?.numero_cedula_persona || ''}</p>
                        <p><strong>Teléfono:</strong> ${estudiante.representante.persona?.prefijo_telefono_personas || ''} ${estudiante.representante.persona?.telefono_personas || ''}</p>
                        <p><strong>Ocupación:</strong> ${estudiante.representante.ocupacion_representante || ''}</p>
                    </div>
                </div>
                ` : ''}

                ${documentosHTML}

                ${estudiante.observaciones ? `
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="border-bottom pb-2 mb-3">Observaciones</h6>
                        <p>${estudiante.observaciones}</p>
                    </div>
                </div>
                ` : ''}
            `;

            // Mostrar el modal
            $('#modalVerDetalleRegistro').modal('show');
        } else {
            alert('Error al cargar los detalles: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al cargar los detalles del estudiante');
    });
}

//  editar inscripción
function editarInscripcion(id) {
    console.log('Editando inscripción ID:', id);

    const url = URL_ESTUDIANTE_EDITAR.replace(':id', id);
    console.log('URL final:', url);

    fetch(url)
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response URL:', response.url);

            if (response.ok) {
                window.location.href = url;
            } else {
                alert('Error: No se pudo cargar la página de edición. Status: ' + response.status);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al acceder a la página de edición: ' + error.message);
        });
}

// confirmar eliminación
function confirmarEliminacion(id) {
    // Guardar ID en el modal
    document.getElementById('estudiante_id_eliminar').value = id;

    // Mostrar el modal de confirmación
    $('#modalConfirmacionEliminar').modal('show');
}

// eliminar inscripción
function eliminar() {
    const id = document.getElementById('estudiante_id_eliminar').value;

    if (!id) {
        alert('Error: No se encontró el ID del estudiante');
        return;
    }

    fetch(URL_ESTUDIANTE_ELIMINAR.replace(':id', id), {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar el modal
            $('#modalConfirmacionEliminar').modal('hide');

            // Mostrar mensaje de éxito
            alert(data.message);

            // Recargar la tabla
            cargarEstudiantesInscritos();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar la inscripción');
    });
}

// Función para buscar
function configurarBusqueda() {
    const buscador = document.getElementById('buscador');
    let timeoutId;

    buscador.addEventListener('input', function() {
        const query = this.value.trim();
        clearTimeout(timeoutId);

        timeoutId = setTimeout(() => {
            if (query.length === 0) {
                // Si está vacío, cargar todos los estudiantes
                cargarEstudiantesInscritos();
            } else if (query.length >= 2) {
                // Solo buscar si tiene al menos 2 caracteres
                buscarInscripciones(query);
            }
        }, 500);
    });
}

//  para buscar inscripciones
function buscarInscripciones(query) {
    fetch(`${URL_ESTUDIANTE_BUSCAR}?query=${encodeURIComponent(query)}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        const tabla = document.getElementById('tabla');
        if (data.html) {
            tabla.innerHTML = data.html;
        } else {
            tabla.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center py-4">
                        <div class="text-muted">
                            <h5>Error en la búsqueda</h5>
                            <p class="mb-0">No se pudo realizar la búsqueda</p>
                        </div>
                    </td>
                </tr>
            `;
        }
    })
    .catch(error => {
        console.error('Error en búsqueda:', error);
        const tabla = document.getElementById('tabla');
        tabla.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-danger py-4">
                    <i class="fas fa-exclamation-triangle display-4 d-block mb-2"></i>
                    <h5>Error en la búsqueda</h5>
                    <p class="mb-0">Por favor, recarga la página</p>
                </td>
            </tr>
        `;
    });
}

//  para ir a otra página
function irHa(url) {
    window.location.href = url;
}

//  cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('Cargando estudiantes inscritos...');
    cargarEstudiantesInscritos();
    configurarBusqueda();

    // Configurar el modal para que se recargue cuando se cierre
    $('#modalVerDetalleRegistro').on('hidden.bs.modal', function() {
        document.getElementById('detalleEstudianteContent').innerHTML = `
            <div class="text-center py-4">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Cargando...</span>
                </div>
                <p class="mt-2 text-muted">Cargando información del estudiante...</p>
            </div>
        `;
    });
});
</script>
@stop