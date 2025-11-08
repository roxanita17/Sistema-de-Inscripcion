<!-- Modal Crear Expresión Literaria -->
<div class="modal fade" id="modalCrearExpresionLiteraria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalCrearExpresionLiterariaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCrearExpresionLiterariaLabel">Registrar Expresión Literaria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.expresion_literaria.modales.store') }}" method="POST" id="formCrearExpresionLiteraria">
                    @csrf
                    <div class="mb-3">
                        <label for="letra_expresion_literaria" class="form-label">Letra de la expresión literaria</label>
                        <input
                            type="text"
                            class="form-control text-uppercase"
                            id="letra_expresion_literaria"
                            name="letra_expresion_literaria"
                            maxlength="1"
                            pattern="[A-Za-z]"
                            required
                            oninput="this.value = this.value.toUpperCase().replace(/[^A-Z]/g, '');"
                            title="Debe ingresar solo una letra (A-Z)"
                        >
                    </div>

                    @error('letra_expresion_literaria')
                        <div class="alert text-danger p-0 m-0">
                            <b>{{ $message }}</b>
                        </div>
                    @enderror

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="formCrearExpresionLiteraria">
                            Guardar
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
