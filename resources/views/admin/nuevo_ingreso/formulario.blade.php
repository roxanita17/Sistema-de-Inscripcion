@extends('adminlte::page')

@section('title')
    @if(isset($estudiante))
        Editar Estudiante - {{ $estudiante->persona->primer_nombre ?? '' }} {{ $estudiante->persona->primer_apellido ?? '' }}
    @else
        Registrar Estudiante
    @endif
@stop

@section('content_header')
    <h1>
        @if(isset($estudiante))
            <i class="fas fa-user-edit"></i> Editar Estudiante - {{ $estudiante->persona->primer_nombre ?? '' }} {{ $estudiante->persona->primer_apellido ?? '' }}
        @else
            <i class="fas fa-user-plus"></i> Registrar Estudiante
        @endif
    </h1>
@stop

@section('content')
    @php
    $anoActivo = App\Models\AnioEscolar::whereIn('status', ['Activo', 'Extendido'])->first();
    @endphp

    <div class="container-fluid">
        @if (!$anoActivo)
            <div class="modal fade" id="avisoModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title">
                                <i class="fas fa-exclamation-triangle"></i> ¡Atención!
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>No puede proceder con el registro de estudiantes porque no se encuentra un año escolar activo.</p>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('admin.estudiante.inicio') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Regresar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Formulario de Inscripción</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.estudiante.inicio') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Los campos con <span class="text-danger">(*)</span> son campos obligatorios a llenar
                </div>

                <form method="POST" action="" id="inscripcion-final-form">
                    @csrf
                    <div id="contendorAlertaFormulario"></div>
                    
                    <input type="hidden" id="id" name="id">

                    <!-- Selección de registros existentes -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estudiante_id" class="form-label">Estudiante:</label>
                                <select class="form-control select2" id="estudiante_id" name="estudiante_id" required>
                                    <option value="">Seleccione un estudiante</option>
                                    @if(isset($estudiantesLista) && count($estudiantesLista) > 0)
                                        @foreach($estudiantesLista as $e)
                                            <option value="{{ $e->id }}">{{ $e->tipo_documento }}-{{ $e->numero_documento }} | {{ strtoupper($e->primer_apellido) }}, {{ $e->primer_nombre }}</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No hay estudiantes registrados</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="representante_padre_id" class="form-label">Representante (Padre):</label>
                                <select class="form-control select2" id="representante_padre_id" name="representante_padre_id">
                                    <option value="">Seleccione (opcional)</option>
                                    @if(isset($representantesLista) && count($representantesLista) > 0)
                                        @foreach($representantesLista as $r)
                                            <option value="{{ $r->id }}">{{ $r->tipo_documento }}-{{ $r->numero_documento }} | {{ strtoupper($r->primer_apellido) }}, {{ $r->primer_nombre }}</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No hay representantes registrados</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="representante_madre_id" class="form-label">Representante (Madre):</label>
                                <select class="form-control select2" id="representante_madre_id" name="representante_madre_id">
                                    <option value="">Seleccione (opcional)</option>
                                    @if(isset($representantesLista) && count($representantesLista) > 0)
                                        @foreach($representantesLista as $r)
                                            <option value="{{ $r->id }}">{{ $r->tipo_documento }}-{{ $r->numero_documento }} | {{ strtoupper($r->primer_apellido) }}, {{ $r->primer_nombre }}</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No hay representantes registrados</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="representante_legal_id" class="form-label">Representante Legal:</label>
                                <select class="form-control select2" id="representante_legal_id" name="representante_legal_id">
                                    <option value="">Seleccione (opcional)</option>
                                    @if(isset($representantesLegalesLista) && count($representantesLegalesLista) > 0)
                                        @foreach($representantesLegalesLista as $rl)
                                            <option value="{{ $rl->id }}">{{ $rl->tipo_documento }}-{{ $rl->numero_documento }} | {{ strtoupper($rl->primer_apellido) }}, {{ $rl->primer_nombre }}</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No hay representantes legales registrados</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Sección de Información Académica -->
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="fecha_inscripcion" class="form-label">Fecha de Inscripción:</label>
                                <input type="date" class="form-control" id="fecha_inscripcion" name="fecha_inscripcion" value="{{ old('fecha_inscripcion', date('Y-m-d')) }}">
                                @error('fecha_inscripcion')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ano_escolar" class="form-label">Año Escolar:</label>
                                <select class="form-control" id="ano_escolar" name="ano_escolar">
                                    @if($anoActivo)
                                        @php
                                            $fechaInicio = new DateTime($anoActivo->inicio_anio_escolar);
                                            $fechaCierre = new DateTime($anoActivo->cierre_anio_escolar);
                                        @endphp
                                        <option @if (session('ano_escolar')==$anoActivo->id) selected @endif value="{{ $anoActivo->id }}">
                                            {{ $fechaInicio->format('Y') }} - {{ $fechaCierre->format('Y') }} {{ $anoActivo->status }}
                                        </option>
                                    @else
                                        <option value="">No hay año escolar activo</option>
                                    @endif
                                </select>
                                @error('ano_escolar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="grado_academico" class="form-label">Año Académico:</label>
                                <select class="form-control" id="grado_academico" name="grado_academico">
                                    <option value="">Seleccione un Año</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('grado_academico') == $i ? 'selected' : '' }}>
                                            {{ $i }}° Año
                                        </option>
                                    @endfor
                                </select>
                                @error('grado_academico')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                       
                    </div>

                    <!-- Sección de Documentos -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Documentos Entregados:</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="documentos[]" value="partida_nacimiento" id="partida_nacimiento">
                                            <label class="form-check-label" for="partida_nacimiento">
                                                Partida de Nacimiento
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="documentos[]" value="copia_cedula_representante" id="copia_cedula_representante">
                                            <label class="form-check-label" for="copia_cedula_representante">
                                                Copia de Cédula del Representante
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="documentos[]" value="copia_cedula_estudiante" id="copia_cedula_estudiante">
                                            <label class="form-check-label" for="copia_cedula_estudiante">
                                                Copia de Cédula del Estudiante
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="documentos[]" value="boletin_6to_grado" id="boletin_6to_grado">
                                            <label class="form-check-label" for="boletin_6to_grado">
                                                Boletín de 6to Grado
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="documentos[]" value="certificado_calificaciones" id="certificado_calificaciones">
                                            <label class="form-check-label" for="certificado_calificaciones">
                                                Certificado de Calificaciones
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="documentos[]" value="constancia_aprobacion_primaria" id="constancia_aprobacion_primaria">
                                            <label class="form-check-label" for="constancia_aprobacion_primaria">
                                                Constancia de Aprobación Primaria
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="documentos[]" value="foto_estudiante" id="foto_estudiante">
                                            <label class="form-check-label" for="foto_estudiante">
                                                Fotografía Tipo Carnet Del Estudiante
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="documentos[]" value="foto_representante" id="foto_representante">
                                            <label class="form-check-label" for="foto_representante">
                                                Fotografía Tipo Carnet Del Representante
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="documentos[]" value="carnet_vacunacion" id="carnet_vacunacion">
                                            <label class="form-check-label" for="carnet_vacunacion">
                                                Carnet de Vacunación Vigente
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="documentos[]" value="autorizacion_tercero" id="autorizacion_tercero">
                                            <label class="form-check-label" for="autorizacion_tercero">
                                                Autorización Firmada (si el estudiante está siendo inscrito por un tercero)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @error('documentos')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Campo Observaciones -->
                    <div class="form-group mt-4">
                        <label for="observaciones" class="form-label">Observaciones:</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Ingrese cualquier observación adicional...">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Botones de acción -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary mr-2" id="guardar" @disabled(!$anoActivo)>
                                        <i class="fas fa-save"></i> Inscribir Estudiante
                                    </button>
                                    <a href="{{ route('admin.estudiante.inicio') }}" class="btn btn-danger">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .form-check {
            margin-bottom: 0.5rem;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
function enviarInscripcionFinal() {
    console.log('📝 Enviando formulario final de nuevo ingreso...');

    const loader = document.getElementById("contenedorLoader");
    if (loader) {
        loader.classList.add("mostrar-loader");
    }

    const formulario = document.getElementById('inscripcion-final-form');
    const formData = new FormData(formulario);

    // Agregar token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        formData.append('_token', csrfToken.getAttribute('content'));
    }

    // Validar que se haya seleccionado al menos un documento
    const checkboxes = document.querySelectorAll('input[name="documentos[]"]:checked');
    const documentos = Array.from(checkboxes).map(cb => cb.value);

    if (documentos.length === 0) {
        mostrarAlerta('Debe seleccionar al menos un documento entregado', 'warning', 'contendorAlertaFormulario');
        if (loader) loader.classList.remove("mostrar-loader");
        return;
    }

    // Limpiar documentos previos y agregar los nuevos
    formData.delete('documentos[]');
    documentos.forEach(doc => {
        formData.append('documentos[]', doc);
    });

    console.log('Documentos seleccionados:', documentos);

    const btnGuardar = document.getElementById('guardar');
    if (btnGuardar) {
        btnGuardar.disabled = true;
        btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
    }

    // Enviar por AJAX
    fetch('{{ route("admin.inscripcion.completar") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('✅ Respuesta del servidor:', data);

        if (data.success) {
            mostrarAlerta(data.message, "success", "contendorAlertaFormulario");

            // Redirigir a página de éxito
            if (data.redirect) {
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 2000);
            }
        } else {
            mostrarAlerta(data.message || "Error al completar la inscripción", "danger", "contendorAlertaFormulario");
        }
    })
    .catch(error => {
        console.error('❌ Error en la petición:', error);
        mostrarAlerta('Error de conexión. Por favor, inténtelo de nuevo.', 'danger', 'contendorAlertaFormulario');
    })
    .finally(() => {
        if (loader) {
            loader.classList.remove("mostrar-loader");
        }
        if (btnGuardar) {
            btnGuardar.disabled = false;
            btnGuardar.innerHTML = '<i class="fas fa-save"></i> Inscribir Estudiante';
        }
    });
}

function mostrarAlerta(mensaje, tipo, contenedorId) {
    const container = document.getElementById(contenedorId);
    if (container) {
        container.innerHTML = `
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                <strong>${tipo === 'success' ? '✅' : '❌'} ${tipo === 'success' ? 'Éxito' : 'Error'}:</strong> ${mensaje}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;
    }
}

// Inicializar evento cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    const btnGuardar = document.getElementById('guardar');

    if (btnGuardar) {
        btnGuardar.addEventListener('click', function(e) {
            e.preventDefault();
            enviarInscripcionFinal();
        });
    }

    // Validación de fecha de inscripción (no puede ser mayor a hoy)
    const fechaInscripcion = document.getElementById('fecha_inscripcion');
    if (fechaInscripcion) {
        const hoy = new Date().toISOString().split('T')[0];
        fechaInscripcion.max = hoy;
    }

    // Mostrar modal de advertencia si no hay año activo
    @if(!$anoActivo)
        $('#avisoModal').modal('show');
    @endif

    // Inicializar Select2 en los selects de búsqueda
    if (window.jQuery && $.fn.select2) {
        $('.select2').select2({
            width: '100%',
            placeholder: 'Seleccione una opción',
            allowClear: true
        });
    }
});
</script>
@stop
