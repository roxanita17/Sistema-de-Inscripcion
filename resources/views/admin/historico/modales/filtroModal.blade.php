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
                        <i class="fas fa-calendar-alt" style="color: var(--primary);"></i>
                        Año Escolar
                    </label>
                    <select name="anio_escolar_id" class="form-select form-control-modern">
                        <option value="">Todos los años</option>
                        @foreach ($anios as $anio)
                            <option value="{{ $anio->id }}"
                                {{ $anio->id == request('anio_escolar_id') ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($anio->inicio_anio_escolar)->format('Y') }}
                                -
                                {{ \Carbon\Carbon::parse($anio->cierre_anio_escolar)->format('Y') }}
                            </option>
                        @endforeach
                    </select>
                    <br>

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

                    <div id="filtroGradoSeccion">
                        <label class="form-label-modern mt-3">
                            <i class="fas fa-layer-group" style="color: var(--primary);"></i>
                            Nivel Academico
                        </label>

                        <select name="grado_id" id="gradoSelect" class="form-select form-control-modern mt-2">
                            <option value="">Todos los niveles academicos</option>
                            @foreach ($grados as $grado)
                                <option value="{{ $grado->id }}"
                                    {{ request('grado_id') == $grado->id ? 'selected' : '' }}>
                                    {{ $grado->numero_grado }}
                                </option>
                            @endforeach
                        </select>

                        <label class="form-label-modern mt-3">
                            <i class="fas fa-layer-group" style="color: var(--primary);"></i>
                            Sección
                        </label>
                        <select name="seccion_id" id="seccionSelect" class="form-select form-control-modern mt-2"
                            disabled>
                            <option value="">
                                {{ request('grado_id') ? 'Cargando secciones...' : 'Primero seleccione un nivel academico' }}
                            </option>

                            @foreach ($secciones as $seccion)
                                <option value="{{ $seccion->id }}"
                                    {{ request('seccion_id') == $seccion->id ? 'selected' : '' }}>
                                    {{ $seccion->nombre }}
                                </option>
                            @endforeach
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
    document.addEventListener('DOMContentLoaded', function() {
        const tipoSelect = document.querySelector('select[name="tipo"]');
        const modalidadDiv = document.getElementById('filtroModalidad');

        tipoSelect.addEventListener('change', function() {
            if (this.value === 'inscripciones') {
                modalidadDiv.style.display = 'block';
            } else {
                modalidadDiv.style.display = 'none';
            }
        });
    });

    document.addEventListener('DOMContentLoaded', () => {

        const gradoSelect = document.getElementById('gradoSelect');
        const seccionSelect = document.getElementById('seccionSelect');

        const baseUrl = "{{ url('admin/historico/secciones-por-grado') }}";

        gradoSelect.addEventListener('change', async function() {

            const gradoId = this.value;

            seccionSelect.innerHTML = '';
            seccionSelect.disabled = true;

            if (!gradoId) {
                seccionSelect.innerHTML =
                    '<option value="">Primero seleccione un nivel academico</option>';
                return;
            }

            seccionSelect.innerHTML =
                '<option value="">Cargando secciones...</option>';

            try {
                const response = await fetch(`${baseUrl}/${gradoId}`);

                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
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
                    option.textContent = seccion.nombre;
                    seccionSelect.appendChild(option);
                });

                seccionSelect.disabled = false;

            } catch (error) {
                console.error(error);
                seccionSelect.innerHTML =
                    '<option value="">Error al cargar secciones</option>';
            }
        });
    });
</script>
