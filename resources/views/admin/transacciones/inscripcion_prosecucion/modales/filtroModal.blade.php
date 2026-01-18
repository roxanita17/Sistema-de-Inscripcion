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
                <form method="GET" action="{{ route('admin.transacciones.inscripcion_prosecucion.index') }}"
                    id="formFiltros">

                    {{-- STATUS --}}
                    <label for="status">
                        <i class="fas fa-toggle-on" style="color: var(--primary);"></i>
                        Estado de la inscripción
                    </label>
                    <select name="status" id="status" class="form-select form-control-modern">
                        <option value="">Todos</option>
                        <option value="Activo" {{ request('status', 'Activo') == 'Activo' ? 'selected' : '' }}>
                            Activo
                        </option>
                        <option value="Pendiente" {{ request('status') == 'Pendiente' ? 'selected' : '' }}>
                            Pendiente
                        </option>
                        <option value="Inactivo" {{ request('status') == 'Inactivo' ? 'selected' : '' }}>
                            Inactivo
                        </option>
                    </select>
                    <br>

                    {{-- GRADO --}}
                    <label class="form-label-modern">
                        <i class="fas fa-layer-group" style="color: var(--primary);"></i>
                        Niveles academicos
                    </label>
                    <select name="grado_id" id="grado_select_prosecucion" class="form-select form-control-modern">
                        <option value="">Todos los niveles</option>
                        @foreach ($grados as $grado)
                            <option value="{{ $grado->id }}"
                                {{ request('grado_id') == $grado->id ? 'selected' : '' }}>
                                {{ $grado->numero_grado }}
                            </option>
                        @endforeach
                    </select>
                    <br>

                    {{-- SECCIÓN --}}
                    <label class="form-label-modern">
                        <i class="fas fa-th-large" style="color: var(--primary);"></i>
                        Sección
                    </label>
                    <select name="seccion_id" id="seccion_select_prosecucion" class="form-select form-control-modern"
                        {{ !request('grado_id') ? 'disabled' : '' }}>
                        <option value="">
                            @if (!request('grado_id'))
                                Primero seleccione un nivel academico
                            @elseif($secciones->isEmpty())
                                No hay secciones para este nivel academico
                            @else
                                Todas las secciones
                            @endif
                        </option>
                        @foreach ($secciones as $seccion)
                            <option value="{{ $seccion->id }}"
                                {{ request('seccion_id') == $seccion->id ? 'selected' : '' }}>
                                {{ $seccion->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <br>

                    {{-- MATERIAS PENDIENTES --}}
                    <label class="form-label-modern">
                        <i class="fas fa-book" style="color: var(--primary);"></i>
                        Materias Pendientes
                    </label>
                    <select name="materias_pendientes" class="form-select form-control-modern">
                        <option value="">Todos los estudiantes</option>
                        <option value="con_pendientes"
                            {{ request('materias_pendientes') == 'Con materias pendientes' ? 'selected' : '' }}>
                            Con materias pendientes
                        </option>
                        <option value="sin_pendientes"
                            {{ request('materias_pendientes') == 'Sin materias pendientes' ? 'selected' : '' }}>
                            Sin materias pendientes
                        </option>
                    </select>
                    <br>

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

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const gradoSelect = document.getElementById('grado_select_prosecucion');
        const seccionSelect = document.getElementById('seccion_select_prosecucion');

        // URL correcta (con /admin)
        const baseUrl = "{{ url('admin/transacciones/secciones-por-grado') }}";

        gradoSelect.addEventListener('change', async function() {

            const gradoId = this.value;

            // Reset
            seccionSelect.innerHTML = '';
            seccionSelect.disabled = true;

            if (!gradoId) {
                seccionSelect.innerHTML =
                    '<option value="">Primero seleccione un nivel academico</option>';
                return;
            }

            // Loading
            seccionSelect.innerHTML =
                '<option value="">Cargando secciones...</option>';

            try {
                const response = await fetch(`${baseUrl}/${gradoId}`);

                if (!response.ok) {
                    throw new Error('Error HTTP ' + response.status);
                }

                const secciones = await response.json();

                seccionSelect.innerHTML =
                    '<option value="">Todas las secciones</option>';

                if (!secciones.length) {
                    seccionSelect.innerHTML =
                        '<option value="">No hay secciones para este nivel academico</option>';
                    return;
                }

                secciones.forEach(seccion => {
                    const option = document.createElement('option');
                    option.value = seccion.id;
                    option.textContent = `${seccion.nombre}`;
                    seccionSelect.appendChild(option);
                });

                seccionSelect.disabled = false;

            } catch (error) {
                console.error('Error al cargar secciones:', error);
                seccionSelect.innerHTML =
                    '<option value="">Error al cargar secciones</option>';
            }
        });
    });
</script>
