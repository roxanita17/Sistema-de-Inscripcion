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
                <form method="GET" action="{{ route('admin.transacciones.inscripcion.index') }}">

                    <label class="form-label-modern">
                        <i class="fas fa-layer-group" style="color: var(--primary);"></i>
                        Grado
                    </label>

                    <select name="grado_id" class="form-select form-control-modern">
                        <option value="">Todos los grados</option>
                        @foreach ($grados as $grado)
                            <option value="{{ $grado->id }}"
                                {{ request('grado_id') == $grado->id ? 'selected' : '' }}>
                                {{ $grado->numero_grado }}
                            </option>
                        @endforeach
                    </select>
                    <br>

                    {{-- SECCIÓN --}}
                    {{-- <label class="form-label-modern">
                        <i class="fas fa-th-large" style="color: var(--primary);"></i>
                        Sección
                    </label>

                    <select name="seccion_id" class="form-select form-control-modern">
                        <option value="">Todas las secciones</option>

                        @foreach ($secciones as $seccion)
                            <option value="{{ $seccion->id }}"
                                {{ request('seccion_id') == $seccion->id ? 'selected' : '' }}>
                                {{ $seccion->nombre }}
                            </option>
                        @endforeach
                    </select> --}}



                    <button type="submit" class="btn-modal-create mt-4 w-100">
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
