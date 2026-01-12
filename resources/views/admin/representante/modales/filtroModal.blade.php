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
                    <!-- Preservar parámetros existentes -->
                    @if(request()->has('buscar'))
                        <input type="hidden" name="buscar" value="{{ request('buscar') }}">
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label-modern">
                            <i class="fas fa-user-tag" style="color: var(--primary);"></i>
                            Tipo de Representante
                        </label>
                        <select class="form-select" id="tipo_representante" name="es_legal">
                            <option value="" {{ !request()->has('es_legal') ? 'selected' : '' }}>Todos los representantes</option>
                            <option value="1" {{ request('es_legal') === '1' ? 'selected' : '' }}>Solo representantes legales</option>
                            <option value="0" {{ request('es_legal') === '0' ? 'selected' : '' }}>Solo progenitores</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern">
                            <i class="fas fa-graduation-cap" style="color: var(--primary);"></i>
                            Nivel Académico
                        </label>
                        <select class="form-select" id="grado" name="grado_id">
                            <option value="" {{ !request()->has('grado_id') ? 'selected' : '' }}>Todos los niveles</option>
                            @foreach($grados as $grado)
                                <option value="{{ $grado->id }}" {{ request('grado_id') == $grado->id ? 'selected' : '' }}>
                                    {{ $grado->numero_grado }}° Niveles academicos
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
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
                    </div>
                    
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn-modal-create mt-4 flex-fill" onclick="aplicarFiltros(event)">
                            <i class="fas fa-check"></i>
                            Aplicar
                        </button>
                        <button type="button" class="btn-modal-cancel mt-4 flex-fill" onclick="limpiarFiltros()">
                            <i class="fas fa-times"></i>
                            Limpiar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function aplicarFiltros(event) {
    event.preventDefault(); // Prevenir el envío automático del formulario
    
    // Cerrar el modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('modalFiltros'));
    if (modal) {
        modal.hide();
    }
    
    // Enviar el formulario
    document.getElementById('filtroForm').submit();
}

function limpiarFiltros() {
    // Limpiar todos los campos del formulario
    document.getElementById('tipo_representante').value = '';
    document.getElementById('grado').value = '';
    document.getElementById('seccion').value = '';
    
    // Mantener el parámetro de búsqueda si existe
    const form = document.getElementById('filtroForm');
    const currentUrl = new URL(form.action);
    const searchParams = currentUrl.searchParams;
    
    // Limpiar parámetros de filtro
    searchParams.delete('es_legal');
    searchParams.delete('grado_id');
    searchParams.delete('seccion_id');
    
    // Construir nueva URL con parámetros limpios
    const newUrl = currentUrl.pathname + '?' + searchParams.toString();
    
    // Redirigir a la URL limpia
    window.location.href = newUrl;
}
</script>

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
