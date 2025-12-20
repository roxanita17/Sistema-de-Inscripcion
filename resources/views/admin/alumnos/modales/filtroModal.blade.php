<div class="modal fade" id="modalFiltros" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content modal-modern">
            <!-- Header -->
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title d-flex align-items-center gap-2" style="color: var(--primary);">
                    <i class="fas fa-filter"></i>
                    Filtros
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <hr>

            <!-- Body -->
            <div class="modal-body pt-0">
                <form id="formFiltros">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label-modern">
                            <i class="fas fa-venus-mars" style="color: var(--primary);"></i>
                            Género
                        </label>
                        <select class="form-select" id="genero" name="genero">
                            <option value="">Todos los géneros</option>
                            <option value="Femenino" {{ request('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="Masculino" {{ request('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Otro" {{ request('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern">
                            <i class="fas fa-id-card" style="color: var(--primary);"></i>
                            Tipo de Documento
                        </label>
                        <select class="form-select" id="tipo_documento" name="tipo_documento">
                            <option value="">Todos los tipos de documento</option>
                            <option value="V" {{ request('tipo_documento') == 'V' ? 'selected' : '' }}>V - Venezolano</option>
                            <option value="E" {{ request('tipo_documento') == 'E' ? 'selected' : '' }}>E - Extranjero</option>
                        </select>
                    </div>
                    
                    <div class="modal-footer p-0 pt-3">
                        <button type="submit" class="btn-modal-create w-100 mt-4">
                            <i class="fas fa-check"></i>
                            Aplicar Filtros
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    #modalFiltros .modal-content {
        border: 1px solid var(--primary);
        box-shadow: var(--shadow-sm);
    }

    #modalFiltros .modal-footer {
        justify-content: space-between;
        border-top: none;
    }

    #modalFiltros .form-select {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }

    #modalFiltros .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>