@extends('adminlte::page')

@section('title', 'Estudiante')

@section('content_header')
    <h1>Estudiantes</h1>
@stop

@section('content')
    {{-- @php
    $anoActivo=App\Models\AnoEscolar::whereIn("status",[App\Models\AnoEscolar::STATUS_ACTIVO,App\Models\AnoEscolar::STATUS_EXTENDIDO])->first();
    @endphp --}}

    <div class="container-fluid">
        {{-- @if (!$anoActivo)
            <div class="alert alert-primary" role="alert">
                No puede registrar estudiantes en este momento por que no hay un año escolar activo.
                <a href="{{route("modules.anio_escolar.index")}}" class="alert-link">Registrar año Escolar</a>
            </div>
        @endif --}}

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Estudiantes</h3>
                    <div class="card-tools">
                        {{-- <a href="{{ route('reportes.estudiantes') }}" class="btn btn-primary me-2">
                            <i class="bi bi-file-earmark-pdf-fill"></i> Generar Reporte General
                        </a> --}}

                        {{-- <button class="btn btn-primary me-2" onclick="irHa('{{route('admin.estudiante.formulario')}}')" @disabled(!$anoActivo)>
                            <i class="bi bi-plus-lg"></i> Registrar
                        </button> --}}

                        <a href="{{route('admin.estudiante.formulario')}}" class="btn btn-primary me-2">
                            <i class="bi bi-plus-lg"></i> Registrar
                        </a>

                        {{-- <a href="{{ route('dashboard.admin') }}" class="btn btn-secondary">
                            <i class="bi bi-box-arrow-left"></i> Volver
                        </a> --}}
                    </div>
                </div>
            </div>

            <div class="card-body">
                <!-- BUSCAR -->
                <div class="row mb-3">
                    <div class="col-md-6 offset-md-6">
                        <form role="search">
                            <div class="input-group">
                                <input class="form-control" type="search"
                                       placeholder="Buscar Por Nombre, Apellido o numero_documento al Estudiante..."
                                       aria-label="Search" id="buscador"/>
                            </div>
                        </form>
                    </div>
                </div>

                <hr>

                <!-- Modal Detalles Estudiante -->
                <div class="modal fade" id="modalVerDetalleRegistro" data-bs-backdrop="static" data-bs-keyboard="true"
                    tabindex="-1" aria-labelledby="modalVerDetalleRegistroLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="modalVerDetalleRegistroLabel">
                                    <i class="fas fa-user-graduate me-2"></i>Detalles del Estudiante
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
                                    <i class="fas fa-times me-1"></i> Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Estudiantes -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Cédula</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Estado Del Estudiante</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tabla">
                            <!-- Los datos se cargarán dinámicamente aquí -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Confirmación Eliminar -->
        <div class="modal fade" id="modalConfirmacionEliminar" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalConfirmacionEliminarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConfirmacionEliminarLabel">Eliminar Registro</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="estudiante_id_eliminar" value="">
                        <h4 class="text-center">¿Esta seguro que desea eliminar el registro?</h4>
                        <h5 class="text-center text-danger">Esta acción es irreversible</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="eliminar()">Si</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Estilos personalizados si los necesitas --}}
@stop

@section('js')
    {{-- <script>
        const tablaBody = document.getElementById('tabla');
        const buscador = document.getElementById('buscador');
        let debounceTimer = null;

        function renderFilas(items) {
            if (!Array.isArray(items)) { tablaBody.innerHTML = ''; return; }
            tablaBody.innerHTML = items.map(item => {
                const p = item.persona || {};
                const numero_documento = p.numero_documento || '';
                const nombre = [p.primer_nombre, p.segundo_nombre].filter(Boolean).join(' ');
                const apellido = [p.primer_apellido, p.segundo_apellido].filter(Boolean).join(' ');
                const estado = item.status || '';
                const editUrl = `{{ route('admin.estudiante.formulario.editar', ['id' => '__ID__']) }}`.replace('__ID__', item.id);
                return `
                    <tr>
                        <td>${numero_documento}</td>
                        <td>${nombre}</td>
                        <td>${apellido}</td>
                        <td>${estado}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="${editUrl}">Editar</a>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        async function cargarLista(page = 1) {
            try {
                const res = await fetch(`{{ url('/admin/estudiante/listar') }}?page=${page}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                const json = await res.json();
                const datos = json && json.data && json.data.data ? json.data.data : [];
                renderFilas(datos);
            } catch (e) {
                renderFilas([]);
            }
        }

        async function buscar(q, page = 1) {
            if (!q) { return cargarLista(page); }
            try {
                const res = await fetch(`{{ route('admin.estudiante.buscar') }}?q=${encodeURIComponent(q)}&page=${page}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                const json = await res.json();
                const datos = json && json.data && json.data.data ? json.data.data : [];
                renderFilas(datos);
            } catch (e) {
                renderFilas([]);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            cargarLista();
            if (buscador) {
                buscador.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    const q = this.value.trim();
                    debounceTimer = setTimeout(() => buscar(q), 300);
                });
            }
        });

        function cerrarModalCorrectamente() {
            const modalElement = document.getElementById('modalVerDetalleRegistro');
            if (modalElement) {
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }

                setTimeout(() => {
                    // Remover todos los backdrops
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    backdrops.forEach(backdrop => {
                        backdrop.remove();
                    });

                    // Restaurar el estado del body
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';

                    // Remover atributos de accesibilidad
                    modalElement.setAttribute('aria-hidden', 'true');
                    modalElement.style.display = 'none';
                }, 150);
            }
        }

        // También limpiar cuando se cierre con el botón X ya que sigue siendo una misma modal para todo
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('modalVerDetalleRegistro');
            if (modalElement) {
                const closeButton = modalElement.querySelector('.btn-close');
                if (closeButton) {
                    closeButton.addEventListener('click', cerrarModalCorrectamente);
                }

                // Limpiar también cuando se cierre con el evento de Bootstrap
                modalElement.addEventListener('hidden.bs.modal', function() {
                    setTimeout(() => {
                        const backdrops = document.querySelectorAll('.modal-backdrop');
                        backdrops.forEach(backdrop => backdrop.remove());
                        document.body.classList.remove('modal-open');
                    }, 150);
                });
            }
        });

        // Función eliminar (debes implementarla según tu lógica)
        function eliminar() {
            // Implementar lógica de eliminación aquí
            console.log('Eliminar estudiante');
        }

        // Función irHa (debes implementarla según tu lógica)
        function irHa(url) {
            window.location.href = url;
        }
    </script> --}}
@stop
