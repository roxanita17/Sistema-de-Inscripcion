
@extends('adminlte::page')

@section('title', 'Gestión de Representantes')

@section('content_header')
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-toggle-on"></i>
                </div>
                <div>
                    <h1 class="title-main">Gestión de Representantes</h1>
                    <p class="title-subtitle">Administración de los representantes del sistema</p>
                </div>
            </div>

            {{-- Botón crear --}} 
            <button type="button" 
                    class="btn-create" 
                    data-bs-toggle="modal" 
                    data-bs-target="#modalCrear"
                    @if(!$anioEscolarActivo) disabled @endif
                    title="{{ !$anioEscolarActivo ? 'Requiere año escolar activo' : 'Nuevo Representante' }}">
                <i class="fas fa-plus"></i>
                <span>Nuevo Representante</span>
            </button>
        </div> 
    </div>
@stop

{{-- Estilos --}}
@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}">
@stop

@section('content')
    
@endsection


<meta name="csrf-token" content="{{ csrf_token() }}">

    <main class=" container-fluid p-5">

        <div class="row bg-light-subtle rounded ">
            <div class="col-12">
                <div class="container ">

                    {{-- <h1 class="text-center p-3">Año escolar</h1> --}}


                    {{-- <a href="{{route("modules.anio_escolar.formulario")}}" class="btn btn-primary m-2 ">Crear</a> --}}


                    {{-- <button class="btn btn-primary">crear</button> --}}


                    {{-- <a href="{{route("modules.usuarios.formulario_usuario")}}" class="btn btn-primary m-2 ">formulario</a> --}}

                    </div>
                    <div class="d-flex justify-content-between p-3">

                        <div class="">
                            <h3>Representantes</h3>
                        </div>

                        {{-- data-bs-toggle="modal" data-bs-target="#formularioUsuario" --}}
                        <div class=" d-flex justify-content-end ">

                            <a href="{{ route('representante.formulario') }}" class="btn btn-primary me-2">
                                <i class="bi bi-plus-lg">Registrar</i>
                            </a>
                                    <i class="bi bi-plus-lg">Registrar</i>

                                </a>

                            </div> --}}

                            <div class="">
                                <a href="" class="btn btn-secondary">
                                    <i class="bi bi-box-arrow-left ">Volver</i></a>

                            </div>
                        </div>

                    </div>



                    {{-- <hr> --}}

                    {{-- BUSCAR  --}}
                    <nav class="navbar bg-body-transparent ">
                        <div class="container-fluid flex-row-reverse">

                            <form class="d-flex col-5 " role="search">
                                <input class="form-control me-2" type="search" placeholder="Buscar Por Nombre,Apellido o Cedula al Estudiante..."
                                    aria-label="Search"  id="buscador"/>

                            </form>

                        </div>

                    </nav>

                    <hr>


                    <div class="modal fade" id="modalVerDetalleRegistro" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="modalVerDetalleRegistroLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="modalVerDetalleRegistroLabel">Detalles del registro
                                    </h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <!-- Datos Personales -->
                                    <h6 class="text-primary mb-3"><i class="bi bi-person-fill me-2"></i>Datos Personales</h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-6"><span style="font-weight: 600; color: #495057;">Primer Nombre:</span> <span id="modal-primer-nombre" class="text-dark fw-semibold"></span></div>
                                        <div class="col-6"><span style="font-weight: 600; color: #495057;">Segundo Nombre:</span> <span id="modal-segundo-nombre" class="text-dark fw-semibold"></span></div>
                                        <div class="col-6"><span style="font-weight: 600; color: #495057;">Primer Apellido:</span> <span id="modal-primer-apellido" class="text-dark fw-semibold"></span></div>
                                        <div class="col-6"><span style="font-weight: 600; color: #495057;">Segundo Apellido:</span> <span id="modal-segundo-apellido" class="text-dark fw-semibold"></span></div>
                                        <div class="col-6"><span style="font-weight: 600; color: #495057;">C.I:</span> <span id="modal-cedula" class="text-dark fw-semibold"></span></div>
                                        <div class="col-6"><span style="font-weight: 600; color: #495057;">Fecha de Nacimiento:</span> <span id="modal-lugar-nacimiento" class="text-dark fw-semibold"></span></div>
                                    </div>

                                    <!-- Contacto -->
                                    <h6 class="text-success mb-3"><i class="bi bi-telephone-fill me-2"></i>Información de Contacto</h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-12"><span style="font-weight: 600; color: #495057;">Número de Teléfono:</span> <span id="modal-telefono" class="text-dark fw-semibold"></span></div>
                                        <div class="col-12"><span style="font-weight: 600; color: #495057;">Correo Electrónico:</span> <span id="modal-correo" class="text-dark fw-semibold"></span></div>
                                    </div>

                                    <!-- Relación Familiar -->
                                    <h6 class="text-info mb-3"><i class="bi bi-house-fill me-2"></i>Relación Familiar</h6>
                                    <div class="row g-3 mb-4">
                                        <div class="col-6"><span style="font-weight: 600; color: #495057;">Ocupación:</span> <span id="modal-ocupacion" class="text-dark fw-semibold"></span></div>
                                        <div class="col-6"><span style="font-weight: 600; color: #495057;">Convive con estudiante:</span> <span id="modal-convive" class="text-dark fw-semibold"></span></div>
                                    </div>

                                    <!-- Información Legal (solo si aplica) -->
                                    <div id="legal-info-section" style="display: none;">
                                        <h6 class="text-warning mb-3"><i class="bi bi-file-earmark-text-fill me-2"></i>Datos Representante Legal</h6>
                                        <div class="row g-3 mb-4">
                                            <!-- Información Básica -->
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="fw-bold" style="min-width: 150px;">Parentesco:</span>
                                                    <span id="modal-parentesco" class="text-dark fw-semibold"></span>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="fw-bold" style="min-width: 150px;">Carnet de la Patria:</span>
                                                    <span id="modal-carnet-afiliado" class="badge"></span>
                                                </div>
                                                <div id="campo-codigo" class="d-flex align-items-center mb-2">
                                                    <span class="fw-bold" style="min-width: 150px;">Código:</span>
                                                    <span id="modal-codigo" class="text-dark fw-semibold"></span>
                                                </div>
                                                <div id="campo-serial" class="d-flex align-items-center mb-2">
                                                    <span class="fw-bold" style="min-width: 150px;">Serial:</span>
                                                    <span id="modal-serial" class="text-dark fw-semibold"></span>
                                                </div>
                                            </div>
                                            
                                            <!-- Información de Organización -->
                                            <div class="col-md-6">
                                                <div class="d-flex align-items-center mb-2">
                                                    <span class="fw-bold" style="min-width: 200px;">Pertenece a Organización:</span>
                                                    <span id="modal-pertenece-org" class="badge"></span>
                                                </div>
                                                <div id="campo-organizacion" class="d-flex align-items-center mb-2">
                                                    <span class="fw-bold" style="min-width: 200px;">Organización:</span>
                                                    <span id="modal-org-pertenece" class="text-dark fw-semibold"></span>
                                                </div>
                                            </div>
                                            
                                            <!-- Información Bancaria -->
                                            <!-- Información Bancaria -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {{ $representantes->links() }}
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Acción</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-representantes">
                                @foreach($representantes as $rep)
                                <tr>
                                    <td>{{ $rep->persona->numero_cedula_persona }}</td>
                                    <td>{{ $rep->persona->nombre_uno }}</td>
                                    <td>{{ $rep->persona->apellido_uno }}</td>
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
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalVerDetalleRegistro" onclick="llenarModalRepresentante('{{ addslashes($rep->persona->toJson()) }}', '{{ addslashes($rep->toJson()) }}', '{{ $rep->legal ? addslashes($rep->legal->toJson()) : 'null' }}', '{{ $rep->legal && $rep->legal->banco ? addslashes($rep->legal->banco->toJson()) : 'null' }}')">
                                            <i class="bi bi-eye-fill">Ver</i>
                                        </button>
                                        <a href="{{ route('representante.editar', $rep->id) }}" class="btn btn-secondary">
                                            <i class="bi bi-pencil-square">Editar</i>
                                        </a>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalConfirmacionEliminarLabel" data-id="{{ $rep->id }}" onclick="setIdEliminar(this)">
                                            <i class="bi bi-trash3-fill">Eliminar</i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                                    

                        </table>

                        <hr>

                        <div class="d-flex justify-content-end">


                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item disabled">
                                        <a class="page-link">Anterior</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Siguiente</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>







                    </div>

                </div>
            </div>
    </main>
