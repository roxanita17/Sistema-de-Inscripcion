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

            <!-- Body -->
            <div class="modal-body pt-2">

                <!-- Estado -->
                <div class="form-group-modern">
                    <label class="form-label-modern">
                        <i class="fas fa-toggle-on" style="color: var(--primary);"></i>
                        Estado
                    </label>
                    <select class="form-control-modern">
                        <option value="">Todos</option>
                        <option value="activo">Activo</option>
                        <option value="inactivo">Inactivo</option>
                    </select>
                </div>

                <!-- Fecha -->
                <div class="form-group-modern">
                    <label class="form-label-modern">
                        <i class="fas fa-calendar-alt" style="color: var(--primary);"></i>
                        Fecha
                    </label>
                    <input type="date" class="form-control-modern">
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 pt-0">
                <button class="btn-modal-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Limpiar
                </button>

                <button class="btn-modal-create">
                    <i class="fas fa-check"></i>
                    Aplicar
                </button>
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