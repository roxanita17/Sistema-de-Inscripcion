<div class="modal fade" id="modalFiltros" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content modal-modern">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title d-flex align-items-center gap-2" style="color: var(--primary);">
                    <i class="fas fa-filter"></i>
                    Filtros
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <hr>
 
            <div class="modal-body pt-0">
                <form id="filtroForm" action="{{ route('admin.alumnos.index') }}" method="GET">
                    <div class="mb-3">
                        <label class="form-label-modern">
                            <i class="fas fa-venus-mars" style="color: var(--primary);"></i>
                            Género
                        </label>
                        <select class="form-select" id="genero" name="genero">
                            <option value="">Todos los géneros</option>
                            @foreach($generos as $genero)
                                <option value="{{ $genero->id }}" {{ request('genero') == $genero->id ? 'selected' : '' }}>
                                    {{ $genero->genero }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label-modern">
                            <i class="fas fa-id-card" style="color: var(--primary);"></i>
                            Tipo de Documento
                        </label>
                        <select class="form-select" id="tipo_documento" name="tipo_documento">
                            <option value="">Todos los tipos de documento</option>
                            @foreach($tiposDocumento as $tipo)
                                <option value="{{ $tipo->id }}" {{ request('tipo_documento') == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nombre }} ({{ $tipo->abreviatura }})
                                </option>
                            @endforeach
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