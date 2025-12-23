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
                <form method="GET" class="filter-inline">
                    {{-- MODALIDAD (solo Inscripciones) --}}

                    <label class="form-label-modern">
                        <i class="fas fa-fw fa-layer-group" style="color: var(--primary);"></i>
                        Modulos
                    </label>
                    <select name="tipo" class="form-select form-control-modern mt-2">
                        <option value="inscripciones"
                            {{ request('tipo', 'inscripciones') == 'inscripciones' ? 'selected' : '' }}>
                            Inscripciones
                        </option>
                        <option value="docentes" {{ request('tipo') == 'docentes' ? 'selected' : '' }}>
                            Docentes
                        </option>
                    </select>

                    <br>

                    <div id="filtroModalidad"
                        style="{{ request('tipo', 'inscripciones') === 'inscripciones' ? '' : 'display:none' }}">

                        <label class="form-label-modern mt-3">
                            <i class="fas fa-user-graduate" style="color: var(--primary);"></i>
                            Modalidad de Inscripción
                        </label>

                        <select name="modalidad" class="form-select form-control-modern mt-2">
                            <option value="">Todas</option>
                            <option value="nuevo_ingreso"
                                {{ request('modalidad') === 'nuevo_ingreso' ? 'selected' : '' }}>
                                Nuevo Ingreso
                            </option>
                            <option value="prosecucion" {{ request('modalidad') === 'prosecucion' ? 'selected' : '' }}>
                                Prosecución
                            </option>
                        </select>
                    </div>

                    <button class="btn-modal-create mt-4 w-100">
                        <i class="fas fa-check"></i>
                        Aplicar
                    </button>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoSelect = document.querySelector('select[name="tipo"]');
        const modalidadDiv = document.getElementById('filtroModalidad');

        tipoSelect.addEventListener('change', function () {
            if (this.value === 'inscripciones') {
                modalidadDiv.style.display = 'block';
            } else {
                modalidadDiv.style.display = 'none';
            }
        });
    });
</script>
