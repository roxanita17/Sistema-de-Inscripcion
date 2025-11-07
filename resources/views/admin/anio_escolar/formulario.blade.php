@section('title', 'Dashboard')

@section('content_header')
    <h1>Blog</h1>
@stop


@section('style')

@endsection

@section('script')

@endsection

@section('contenido_modulo')

    <main class=" container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="">formulario</h1>


                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Crear
                </button>
                @if ($id = null)



                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Formulario Activar Año Escolar</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Fecha De Inicio</span>
                                    <input type="date" class="form-control" aria-label="Sizing example input"
                                        aria-describedby="inputGroup-sizing-default">
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="inputGroup-sizing-default">Fecha De Cierre</span>
                                    <input type="date" class="form-control" aria-label="Sizing example input"
                                        aria-describedby="inputGroup-sizing-default">
                                </div>

                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupSelect01">Opciones</label>
                                    <select class="form-select" id="inputGroupSelect01">
                                        <option selected>Elija un Estado</option>
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                        <option value="3">En espera</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary">Crear</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>

                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if ($id != null)
                    <button class="btn btn-warning">editar</button>

                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                        Editar
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Formulario (editar) Activar Año
                                        Escolar</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Fecha De Inicio</span>
                                        <input type="date" class="form-control" aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>

                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-default">Fecha De Cierre</span>
                                        <input type="date" class="form-control" aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-default">
                                    </div>

                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="inputGroupSelect01">Opciones</label>
                                        <select class="form-select" id="inputGroupSelect01">
                                            <option selected>Elija un Estado</option>
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                            <option value="3">En espera</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary">Crear</button>
                                    <button type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Cancelar</button>

                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <a href="{{ route('modules.anio_escolar.index') }}" class="btn btn-danger">cancelar</a>




            </div>
        </div>
    </main>

@endsection

 {{-- @section('pie_modulo')
    <h3>uwu</h3>
@endsection --}}
