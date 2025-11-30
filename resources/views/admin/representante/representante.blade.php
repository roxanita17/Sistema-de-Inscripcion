
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
                                            <td class="text-end">
                                                <button type="button" class="btn btn-info btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#modalVerDetalleRegistro"
                                                        onclick="llenarModalRepresentante('{{ addslashes($rep->persona->toJson()) }}', '{{ addslashes($rep->toJson()) }}', '{{ $rep->legal ? addslashes($rep->legal->toJson()) : 'null' }}', '{{ $rep->legal && $rep->legal->banco ? addslashes($rep->legal->banco->toJson()) : 'null' }}')">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                                <a href="{{ route('representante.editar', $rep->id) }}" class="btn btn-secondary btn-sm">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#modalConfirmacionEliminarLabel"
                                                        data-id="{{ $rep->id }}" onclick="setIdEliminar(this)">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
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

                {{-- Modal de detalles (estructura base, reutiliza los IDs que ya usabas) --}}
                <div class="modal fade" id="modalVerDetalleRegistro" data-bs-backdrop="static" data-bs-keyboard="false"
                     tabindex="-1" aria-labelledby="modalVerDetalleRegistroLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalVerDetalleRegistroLabel">Detalles del representante</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6 class="text-primary">Datos Personales</h6>
                                        <p class="mb-1"><strong>Primer Nombre:</strong> <span id="modal-primer-nombre"></span></p>
                                        <p class="mb-1"><strong>Segundo Nombre:</strong> <span id="modal-segundo-nombre"></span></p>
                                        <p class="mb-1"><strong>Primer Apellido:</strong> <span id="modal-primer-apellido"></span></p>
                                        <p class="mb-1"><strong>Segundo Apellido:</strong> <span id="modal-segundo-apellido"></span></p>
                                        <p class="mb-1"><strong>C.I:</strong> <span id="modal-cedula"></span></p>
                                        <p class="mb-1"><strong>Fecha de Nacimiento:</strong> <span id="modal-lugar-nacimiento"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-success">Contacto</h6>
                                        <p class="mb-1"><strong>Teléfono:</strong> <span id="modal-telefono"></span></p>
                                        <p class="mb-1"><strong>Correo:</strong> <span id="modal-correo"></span></p>
                                        <h6 class="text-info mt-3">Relación Familiar</h6>
                                        <p class="mb-1"><strong>Ocupación:</strong> <span id="modal-ocupacion"></span></p>
                                        <p class="mb-1"><strong>Convive con el estudiante:</strong> <span id="modal-convive"></span></p>
                                    </div>
                                </div>

                                <div id="legal-info-section" style="display: none;">
                                    <hr>
                                    <h6 class="text-warning">Datos de Representante Legal</h6>
                                    <p class="mb-1"><strong>Parentesco:</strong> <span id="modal-parentesco"></span></p>
                                    <p class="mb-1"><strong>Carnet de la Patria:</strong> <span id="modal-carnet-afiliado" class="badge"></span></p>
                                    <p class="mb-1" id="campo-codigo"><strong>Código:</strong> <span id="modal-codigo"></span></p>
                                    <p class="mb-1" id="campo-serial"><strong>Serial:</strong> <span id="modal-serial"></span></p>
                                    <p class="mb-1"><strong>Pertenece a organización:</strong> <span id="modal-pertenece-org" class="badge"></span></p>
                                    <p class="mb-1" id="campo-organizacion"><strong>Organización:</strong> <span id="modal-org-pertenece"></span></p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

