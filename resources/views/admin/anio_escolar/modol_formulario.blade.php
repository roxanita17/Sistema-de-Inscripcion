<div class="modal fade" id="formulario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="formularioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="formularioLabel">Año Escolar Activación
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <legend class="fs-5">Los campos con <span class="text-danger">(*)</span> son campos
                    obligatorios a llenar</legend>
                    <div id="contendorAlertaFormulario"></div>
                <form id="form">
                    @csrf
                    <input type="hidden" id="id_ano_escolar" name="id" value="null">

                    <div class="input-group">
                        <span class="input-group-text" id="inputGroup-sizing-default"><span
                                class="text-danger">(*)</span> Desde</span>
                        <input type="date" class="form-control" id="inicio_ano_escolar" name="inicio_ano_escolar"
                            aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                    </div>
                    <div id="inicio_ano_escolar_error" class="mb-3" style="color: red"></div>

                    <div class="input-group" id="contenedorInputCerrarAnoEscolar">
                        <span class="input-group-text" id="inputGroup-sizing-default"><span
                                class="text-danger">(*)</span> Hasta</span>
                        <input type="date" class="form-control" id="cierre_ano_escolar" name="cierre_ano_escolar"
                            aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">

                    </div>
                    <div id="cierre_ano_escolar_error" class="mb-3" style="color: red"></div>

                    <div class="input-group d-none" id="contenedorInputExtenderAnoEscolar">
                        <span class="input-group-text" id="inputGroup-sizing-default"><span
                                class="text-danger">(*)</span> Extender Hasta</span>
                        <input type="date" class="form-control" id="extencion_ano_escolar"
                            name="extencion_ano_escolar" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default">

                    </div>
                    <div id="extencion_ano_escolar_error" class="mb-3" style="color: red"></div>
                    {{-- <div id="canvas">
                                            <h3>hola uwu</h3>
                                        </div> --}}
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="botonContinuiar"
                    onclick="validarFormularioCrear()">Crear</button>
                <button type="button" class="btn btn-warning d-none" id="botonExtender"
                    onclick="validarFormularioExtender()">Extender</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                    aria-label="Close">Cancelar</button>
            </div>



        </div>
    </div>
</div>
