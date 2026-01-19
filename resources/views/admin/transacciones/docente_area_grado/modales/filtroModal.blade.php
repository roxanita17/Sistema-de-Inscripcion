<div class="modal fade" id="modalFiltros" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content modal-modern">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title d-flex align-items-center gap-2" style="color: var(--primary);">
                    <i class="fas fa-filter"></i>
                    Filtros
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <hr>

            <div class="modal-body pt-0">
                <form method="GET" class="filter-inline">
                    <input type="hidden" name="tipo" value="{{ request('tipo', 'inscripciones') }}">
                    <label class="form-label-modern">
                        <i class="fas fa-calendar-alt"></i>
                        Niveles Academicos
                    </label>
                    <select name="grado_id" class="form-select form-control-modern">
                        <option value="">Todos</option>
                        @foreach ($gradosEscolares as $grado)
                            <option value="{{ $grado->id }}" {{ request('grado_id') == $grado->id ? 'selected' : '' }}>
                                {{ $grado->numero_grado }}
                            </option>
                        @endforeach
                    </select>
                    <label class="form-label-modern mt-3">
                        <i class="fas fa-layer-group"></i>
                        Sección
                    </label>
                    <select name="seccion_id" class="form-select form-control-modern">
                        <option value="">Todas</option>
                        @foreach ($secciones as $seccion)
                            <option value="{{ $seccion->nombre }}"
                                {{ request('seccion_id') == $seccion->nombre ? 'selected' : '' }}>
                                {{ $seccion->nombre }}
                            </option>

                        @endforeach
                    </select>
                    <div id="filtroModalidad">
                        <label class="form-label-modern mt-3">
                            <i class="fas fa-user-graduate"></i>
                            Área de formación
                        </label>
                        <select name="area_formacion_id" class="form-select form-control-modern">
                            <option value="">Todas</option>
                            @foreach ($areasFormacion as $area)
                                <option value="{{ $area->id }}" {{ request('area_formacion_id') == $area->id ? 'selected' : '' }}>
                                    {{ $area->nombre_area_formacion }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn-modal-create mt-4 w-100">
                        <i class="fas fa-check"></i> Aplicar
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
    document.addEventListener('DOMContentLoaded', function() {
        const tipoInput = document.querySelector('input[name="tipo"]');
        if (!tipoInput) return;

        const modalidadDiv = document.getElementById('filtroModalidad');

        tipoSelect.addEventListener('change', function() {
            if (this.value === 'inscripciones') {
                modalidadDiv.style.display = 'block';
            } else {
                modalidadDiv.style.display = 'none';
            }
        });
    });
</script>
