<!-- Modal Crear Año Escolar -->
<div class="modal fade" id="modalCrearGrado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalCrearGradoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCrearGradoLabel">Registrar Grado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                {{-- Ruta para guardar el grado --}}
                <form action="{{ route('admin.grado.modales.store') }}" method="POST" id="formCrearGrado">
                    @csrf
                    <div id="contenedorAlertaCrear"></div>
                    {{-- Numero de grado --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text"><span class="text-danger">*</span> Numero</span>
                        <input type="text" class="form-control" id="numero_grado" name="numero_grado" inputmode="numeric" pattern="[0-9]+" maxlength="2" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                    </div>
                    @error('numero_grado')
                        <div class="alert text-danger p-0 m-0">
                            <b>{{ 'Este campo es obligatorio.' }}</b>
                        </div>
                    @enderror

                    {{-- Capacidad maxima de cupos --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text"><span class="text-danger">*</span> Capacidad maxima de cupos</span>
                        <input type="text" class="form-control" id="capacidad_max" name="capacidad_max" inputmode="numeric" pattern="[0-9]+" maxlength="3" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                    </div>
                    @error('capacidad_max')
                        <div class="alert text-danger p-0 m-0">
                            <b>{{ 'Este campo es obligatorio.' }}</b>
                        </div>
                    @enderror

                    {{-- Minimo de seccion --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text"><span class="text-danger">*</span> Minimo de seccion</span>
                        <input type="text" class="form-control" id="min_seccion" name="min_seccion" inputmode="numeric" pattern="[0-9]+" maxlength="2" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                    </div>
                    @error('min_seccion')
                        <div class="alert text-danger p-0 m-0">
                            <b>{{ 'Este campo es obligatorio.' }}</b>
                        </div>
                    @enderror

                    {{-- Maximo de seccion --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text"><span class="text-danger">*</span> Maximo de seccion</span>
                        <input type="text" class="form-control" id="max_seccion" name="max_seccion" inputmode="numeric" pattern="[0-9]+" maxlength="2" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                    </div>
                    @error('max_seccion')
                        <div class="alert text-danger p-0 m-0">
                            <b>{{ 'Este campo es obligatorio.' }}</b>
                        </div>
                    @enderror
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" form="formCrearGrado">
                    Guardar
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


