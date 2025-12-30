<div class="modal fade" id="modalFiltros" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content modal-modern">
            <!-- Header -->
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title d-flex align-items-center gap-2" style="color: var(--primary);">
                    <i class="fas fa-filter"></i>
                    Filtros
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <hr>
 
            <!-- Body -->
            <div class="modal-body pt-0">
                <form id="filtroForm" action="{{ route('admin.alumnos.index') }}" method="GET">
                    <!-- Filtro de Género -->
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

                    <!-- Filtro de Tipo de Documento -->
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
        padding: 0.5rem 0.75rem;
        width: 100%;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    #modalFiltros .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    #modalFiltros .btn-modal-create {
        background-color: var(--primary);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    #modalFiltros .btn-modal-create:hover {
        background-color: #0b5ed7;
        transform: translateY(-1px);
    }

    #modalFiltros .btn-modal-cancel {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    #modalFiltros .btn-modal-cancel:hover {
        background-color: #5c636a;
        color: white;
        transform: translateY(-1px);
    }
</style>