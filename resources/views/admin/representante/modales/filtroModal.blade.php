<div class="modal fade" id="modalFiltros" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content modal-modern">
            <!-- Header -->
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title d-flex align-items-center gap-2" style="color: var(--primary);">
                    <i class="fas fa-filter"></i>
                    Filtros de Búsqueda
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <hr>

            <!-- Body -->
            <div class="modal-body pt-0">
                <form id="filtroForm" action="{{ route('representante.index') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label-modern">
                            <i class="fas fa-user-tag" style="color: var(--primary);"></i>
                            Tipo de Representante
                        </label>
                        <select class="form-select" id="tipo_representante" name="es_legal">
                            <option value="" {{ !request()->has('es_legal') ? 'selected' : '' }}>Todos los representantes</option>
                            <option value="1" {{ request('es_legal') === '1' ? 'selected' : '' }}>Solo representantes legales</option>
                            <option value="0" {{ request('es_legal') === '0' ? 'selected' : '' }}>Solo representantes no legales</option>
                        </select>
                    </div>
                    
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn-modal-create mt-4 w-100">
                        <i class="fas fa-check"></i>
                        Aplicar
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
    }

    #modalFiltros .form-control-modern {
        border-width: 1px;
    }

    #modalFiltros .form-control-modern:focus {
        border-color: var(--primary);
    }
</style>
