@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Año Escolar</h1>
@stop

@section('style')

@endsection



@section('content')

        <div class="row bg-light-subtle rounded ">
            <div class="col-12">
                <div class="container ">
                    {{-- <h1 class="text-center p-3">Año escolar</h1> --}}


                    {{-- <a href="{{route("modules.anio_escolar.formulario")}}" class="btn btn-primary m-2 ">Crear</a> --}}


                    {{-- <button class="btn btn-primary">crear</button> --}}




                    <div class="d-flex justify-content-between p-3">

                        <div class="">
                            <h3>Año Escolar</h3>
                        </div>

                        <div class=" d-flex justify-content-end ">
                            {{-- <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#formulario" onclick="modalModoRegistro()" @if ($anoActivo) disabled @endif > --}}
                            <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal"
                                data-bs-target="#formulario" onclick="modalModoRegistro()" >
                                {{-- agregar --}}
                                <i class="bi bi-plus-lg">Registrar</i>
                            </button>

                            <div class="">
                                <a href="#" class="btn btn-secondary">
                                    <i class="bi bi-box-arrow-left ">Volver</i></a>

                            </div>
                        </div>

                    </div>



                    {{-- <hr> --}}

                    {{-- BUSCAR  --}}
                    
                    {{-- 
                    <div class="form-group mb-3">
                        <input type="text" id="buscador" class="form-control" placeholder="Buscar materia..." style="width: 250px; text-aling: center;">
                    </div>
                    <nav class="navbar bg-body-transparent ">
                    <div class="container-fluid flex-row-reverse">

                        <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Search"/>
                        <button class="btn btn-success" type="submit">Buscar</button>
                        </form>

                    </div>

                </nav> --}}

                    <hr>





                </div>



                {{-- <a href="{{route("modules.anio_escolar.formulario",["id_registro" => 1])}}" class="btn btn-warning">Editar</a> --}}





                <div class="container ">
                    <table class="table table-bordered border-light table-secondary">
                        <thead>
                            <tr>
                                <th scope="col">Fecha Inicio</th>
                                <th scope="col">Fecha Cierre</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="registroTabla">
                            <tr>
                                @foreach ($escolar as $datos)
                                    <td scope="col">
                                        {{ $datos->inicio_anio_escolar }}
                                    </td>
                                    <td scope="col">
                                        {{ $datos->cierre_anio_escolar }}
                                    </td>
                                    <td style="text-align: center;">
                                        @if ($datos->status == 'Activo')
                                            <span class="badge badge-success">Disponible</span>
                                        @elseif ($datos->status == 'En Espera')
                                            <span class="badge badge-danger">En Espera</span>
                                        @elseif ($datos->status == 'Extendido')
                                            <span class="badge badge-danger">Extendido</span>
                                        @else
                                            <span class="badge badge-danger">No disponible</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#viewModal{{ $datos->id }}" data-toggle="modal" class="btn btn-info"
                                            title="Ver detalles"><i class="fas fa-eye"></i></a>

                                        <!-- Modal -->
                                        {{-- <div class="modal fade" id="viewModal{{ $libro->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="viewModalLabel{{ $libro->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info">
                                                        <h5 class="modal-title" id="viewModalLabel{{ $libro->id }}">
                                                            Detalles del libro</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><b>Título:</b> {{ $libro->titulo }}</p>
                                                        <p><b>Autor:</b> {{ $libro->autor }}</p>
                                                        <p><b>Año de publicación:</b> {{ $libro->año_publicacion }}</p>
                                                        <p><b>Género:</b> {{ $libro->genero }}</p>
                                                        <p><b>Idioma:</b> {{ $libro->idioma }}</p>
                                                        <p><b>Cantidad en Stock:</b> {{ $libro->cantidad_stock }}</p>
                                                        <p><b>Estado:</b>
                                                            @if ($libro->estatus == 1)
                                                                Disponible
                                                            @else
                                                                No disponible
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <a href="javascript:void(0)" class="btn btn-warning" title="Editar">
                                            <i class="fas fa-edit text-white"></i>
                                        </a>

                                        <!-- Botón que abre el modal -->
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#confirmarEliminar{{ $datos->id }}" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <div class="modal fade" id="confirmarEliminar{{ $datos->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="modalLabel{{ $datos->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalLabel{{ $datos->id }}">
                                                            Confirmar eliminación</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Cerrar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿Estás seguro de que deseas eliminar este libro?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ url('admin/anio_escolar/' . $datos->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <button type="submit"
                                                                class="btn btn-danger">Eliminar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @endforeach
                                
                            </tr>
                            {{-- <tr>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>

                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                     data-bs-target="#formulario" onclick="modalModoExtender(0)">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#formulario">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>

                                </td>
                            </tr> --}}
                        </tbody>



                    </table>

                    <hr>

                    <div class="d-flex justify-content-end">

                        {{--
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
                        </nav> --}}
                    </div>







                </div>

            </div>
        </div>
        <div class="modal fade" id="modalConfirmacionEliminar" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalConfirmacionEliminarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalConfirmacionEliminarLabel">Eliminar Registro
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_ano_escolar_suspender">
                        <h4 class=" text-center">¿Esta seguro que desea eliminar el reigistro?</h4>
                        <h4 class="text-center text-lg">Esta acción es irreversible</h4>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="suspender()">Si</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalConfirmacionCreacion" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalConfirmacionCreacionLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalConfirmacionCreacionLabel">Crear un nuevo año escolar
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4 class=" text-center">¿Esta seguro que desea crear un año escolar?</h4>
                        <h4 class="text-center text-lg">Si hay un año escolar en espera sera supendido</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="crearAnoEscolar()">Si</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalConfirmacionExtencion" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalConfirmacionExtencionLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalConfirmacionExtencionLabel">Extender Año Escolar
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h4 class=" text-center">¿Esta seguro que desea extender el año escolar?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="extenderAnoEscolar()">Si</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalConfirmacionActivarAnoEscolar" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalConfirmacionActivarAnoEscolarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalConfirmacionActivarAnoEscolarLabel">Activar Año Escolar
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_ano_escolar_activar">
                        <h4 class="text-center">¿Esta seguro que desea activar el año escolar?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="activar()">Si</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalConfirmacionInactivarAnoEscolar" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="modalConfirmacionInactivarAnoEscolarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalConfirmacionInactivarAnoEscolarLabel">Inactivar Año Escolar
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_ano_escolar_inactivar">
                        <h4 class="text-center">¿Esta seguro que desea inactivar el año escolar?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="inactivar()">Si</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Modal de Registrar-->
    @include("admin.anio_escolar.modol_formulario")

@endsection

{{-- @section('pie_modulo')
    <h3>uwu</h3>
@endsection --}}
