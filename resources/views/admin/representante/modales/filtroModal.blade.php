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

                {{-- FILTRO --}}
<form id="formReporte" action="{{ route('representante.reporte_pdf') }}" method="GET"
                target="_blank">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tipo_representante" class="form-label">Tipo de Representante</label>
                        <select class="form-select" id="tipo_representante" name="es_legal">
                            <option value="">Todos los representantes</option>
                            <option value="1">Solo representantes legales</option>
                            <option value="0">Solo representantes no legales</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-pdf">
                        <i class="fas fa-download me-1"></i> Generar PDF
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
