@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-styles.css') }}">
@stop

@section('title')
    Registrar Nuevo Ingreso
@stop

@section('content_header')
    <div class="content-header-modern">
        <div class="header-content">
            <div class="header-title">
                <div class="icon-wrapper">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <h1 class="title-main">Registrar Nuevo Ingreso</h1>
                    <p class="title-subtitle">Formulario de inscripción de estudiantes</p>
                </div>
            </div>
            <a href="{{ route('admin.estudiante.inicio') }}" class="btn-create" style="background: var(--gray-500);">
                <i class="fas fa-arrow-left"></i>
                <span>Volver</span>
            </a>
        </div>
    </div>
@stop

@section('content')
    @php
        $anoActivo = App\Models\AnioEscolar::whereIn('status', ['Activo', 'Extendido'])->first();
    @endphp

    <div class="main-container">
        {{-- Alerta si NO hay año escolar activo --}}
        @if (!$anoActivo)
            <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-1">¡Atención! No hay año escolar activo</h5>
                        <p class="mb-0">
                            No puede proceder con el registro porque no se encuentra un año escolar activo.
                            <a href="{{ route('admin.anio_escolar.index') }}" class="alert-link">Ir a Año Escolar</a>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Alertas de éxito o error --}}
        @if (session('success') || session('error'))
            <div class="alerts-container">
                @if (session('success'))
                    <div class="alert-modern alert-success alert alert-dismissible fade show" role="alert">
                        <div class="alert-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="alert-content">
                            <h4>Éxito</h4>
                            <p>{{ session('success') }}</p>
                        </div>
                        <button type="button" class="alert-close btn-close" data-bs-dismiss="alert">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-modern alert-error alert alert-dismissible fade show" role="alert">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="alert-content">
                            <h4>Error</h4>
                            <p>{{ session('error') }}</p>
                        </div>
                        <button type="button" class="alert-close btn-close" data-bs-dismiss="alert">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
            </div>
        @endif

        {{-- Formulario Principal --}}
        <form method="POST" {{-- action="{{ route('admin.estudiante.store') }}" --}} id="inscripcion-form">
            @csrf
            <input type="hidden" id="id" name="id">

            {{-- Card: Selección de Registros Existentes --}}
            <div class="card-modern mb-4">
                <div class="card-header-modern">
                    <div class="header-left">
                        <div class="header-icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <div>
                            <h3>Selección de Estudiante y Representantes</h3>
                            <p>Seleccione el estudiante y sus representantes</p>
                        </div>
                    </div>
                </div>

                <div class="card-body-modern" style="padding: 2rem;">
                    <div class="alert alert-info mb-4" style="background: var(--info-light); border-left: 4px solid var(--info); padding: 1rem; border-radius: 8px;">
                        <i class="fas fa-info-circle"></i> Los campos con <span class="text-danger" style="font-weight: 700;">(*)</span> son obligatorios
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="estudiante_id" class="form-label-modern">
                                    <i class="fas fa-user-graduate"></i>
                                    Estudiante
                                    <span class="required-badge">*</span>
                                </label>
                                <select class="form-control-modern select2" id="estudiante_id" name="estudiante_id" required>
                                    <option value="">Seleccione un estudiante</option>
                                    @if(isset($estudiantesLista) && count($estudiantesLista) > 0)
                                        @foreach($estudiantesLista as $e)
                                            <option value="{{ $e->id }}">
                                                {{ $e->tipo_documento }}-{{ $e->numero_documento }} | 
                                                {{ strtoupper($e->primer_apellido) }}, {{ $e->primer_nombre }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No hay estudiantes registrados</option>
                                    @endif
                                </select>
                                @error('estudiante_id')
                                    <div class="invalid-feedback-modern">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="representante_padre_id" class="form-label-modern">
                                    <i class="fas fa-male"></i>
                                    Representante (Padre)
                                </label>
                                <select class="form-control-modern select2" id="representante_padre_id" name="representante_padre_id">
                                    <option value="">Seleccione (opcional)</option>
                                    @if(isset($representantesLista) && count($representantesLista) > 0)
                                        @foreach($representantesLista as $r)
                                            <option value="{{ $r->id }}">
                                                {{ $r->tipo_documento }}-{{ $r->numero_documento }} | 
                                                {{ strtoupper($r->primer_apellido) }}, {{ $r->primer_nombre }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No hay representantes registrados</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="representante_madre_id" class="form-label-modern">
                                    <i class="fas fa-female"></i>
                                    Representante (Madre)
                                </label>
                                <select class="form-control-modern select2" id="representante_madre_id" name="representante_madre_id">
                                    <option value="">Seleccione (opcional)</option>
                                    @if(isset($representantesLista) && count($representantesLista) > 0)
                                        @foreach($representantesLista as $r)
                                            <option value="{{ $r->id }}">
                                                {{ $r->tipo_documento }}-{{ $r->numero_documento }} | 
                                                {{ strtoupper($r->primer_apellido) }}, {{ $r->primer_nombre }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No hay representantes registrados</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="representante_legal_id" class="form-label-modern">
                                    <i class="fas fa-gavel"></i>
                                    Representante Legal
                                </label>
                                <select class="form-control-modern select2" id="representante_legal_id" name="representante_legal_id">
                                    <option value="">Seleccione (opcional)</option>
                                    @if(isset($representantesLegalesLista) && count($representantesLegalesLista) > 0)
                                        @foreach($representantesLegalesLista as $rl)
                                            <option value="{{ $rl->id }}">
                                                {{ $rl->tipo_documento }}-{{ $rl->numero_documento }} | 
                                                {{ strtoupper($rl->primer_apellido) }}, {{ $rl->primer_nombre }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No hay representantes legales registrados</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Información Académica --}}
            <div class="card-modern mb-4">
                <div class="card-header-modern">
                    <div class="header-left">
                        <div class="header-icon" style="background: linear-gradient(135deg, var(--success), #059669);">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div>
                            <h3>Información Académica</h3>
                            <p>Datos del año escolar y grado académico</p>
                        </div>
                    </div>
                </div>

                <div class="card-body-modern" style="padding: 2rem;">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fecha_inscripcion" class="form-label-modern">
                                    <i class="fas fa-calendar-check"></i>
                                    Fecha de Inscripción
                                    <span class="required-badge">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control-modern @error('fecha_inscripcion') is-invalid @enderror" 
                                       id="fecha_inscripcion" 
                                       name="fecha_inscripcion" 
                                       value="{{ old('fecha_inscripcion', date('Y-m-d')) }}" 
                                       required>
                                @error('fecha_inscripcion')
                                    <div class="invalid-feedback-modern">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ano_escolar" class="form-label-modern">
                                    <i class="fas fa-calendar-alt"></i>
                                    Año Escolar
                                    <span class="required-badge">*</span>
                                </label>
                                <select class="form-control-modern @error('ano_escolar') is-invalid @enderror" 
                                        id="ano_escolar" 
                                        name="ano_escolar" 
                                        required>
                                    @if($anoActivo)
                                        @php
                                            $fechaInicio = new DateTime($anoActivo->inicio_anio_escolar);
                                            $fechaCierre = new DateTime($anoActivo->cierre_anio_escolar);
                                        @endphp
                                        <option value="{{ $anoActivo->id }}" selected>
                                            {{ $fechaInicio->format('Y') }} - {{ $fechaCierre->format('Y') }} ({{ $anoActivo->status }})
                                        </option>
                                    @else
                                        <option value="">No hay año escolar activo</option>
                                    @endif
                                </select>
                                @error('ano_escolar')
                                    <div class="invalid-feedback-modern">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="grado_academico" class="form-label-modern">
                                    <i class="fas fa-layer-group"></i>
                                    Año Académico
                                    <span class="required-badge">*</span>
                                </label>
                                <select class="form-control-modern @error('grado_academico') is-invalid @enderror" 
                                        id="grado_academico" 
                                        name="grado_academico" 
                                        required>
                                    <option value="">Seleccione un año</option>
                                    @for($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" {{ old('grado_academico') == $i ? 'selected' : '' }}>
                                            {{ $i }}° Año
                                        </option>
                                    @endfor
                                </select>
                                @error('grado_academico')
                                    <div class="invalid-feedback-modern">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Documentos Entregados --}}
            <div class="card-modern mb-4">
                <div class="card-header-modern">
                    <div class="header-left">
                        <div class="header-icon" style="background: linear-gradient(135deg, var(--warning), #d97706);">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div>
                            <h3>Documentos Entregados</h3>
                            <p>Marque los documentos que el estudiante ha entregado</p>
                        </div>
                    </div>
                </div>

                <div class="card-body-modern" style="padding: 2rem;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="checkbox-group">
                                <div class="checkbox-item-modern">
                                    <input type="checkbox" 
                                           class="checkbox-modern" 
                                           name="documentos[]" 
                                           value="partida_nacimiento" 
                                           id="partida_nacimiento">
                                    <label for="partida_nacimiento" class="checkbox-label-modern">
                                        <i class="fas fa-file-alt"></i>
                                        Partida de Nacimiento
                                    </label>
                                </div>

                                <div class="checkbox-item-modern">
                                    <input type="checkbox" 
                                           class="checkbox-modern" 
                                           name="documentos[]" 
                                           value="copia_cedula_representante" 
                                           id="copia_cedula_representante">
                                    <label for="copia_cedula_representante" class="checkbox-label-modern">
                                        <i class="fas fa-id-card"></i>
                                        Copia de Cédula del Representante
                                    </label>
                                </div>

                                <div class="checkbox-item-modern">
                                    <input type="checkbox" 
                                           class="checkbox-modern" 
                                           name="documentos[]" 
                                           value="copia_cedula_estudiante" 
                                           id="copia_cedula_estudiante">
                                    <label for="copia_cedula_estudiante" class="checkbox-label-modern">
                                        <i class="fas fa-id-card"></i>
                                        Copia de Cédula del Estudiante
                                    </label>
                                </div>

                                <div class="checkbox-item-modern">
                                    <input type="checkbox" 
                                           class="checkbox-modern" 
                                           name="documentos[]" 
                                           value="boletin_6to_grado" 
                                           id="boletin_6to_grado">
                                    <label for="boletin_6to_grado" class="checkbox-label-modern">
                                        <i class="fas fa-file-alt"></i>
                                        Boletín de 6to Grado
                                    </label>
                                </div>

                                <div class="checkbox-item-modern">
                                    <input type="checkbox" 
                                           class="checkbox-modern" 
                                           name="documentos[]" 
                                           value="certificado_calificaciones" 
                                           id="certificado_calificaciones">
                                    <label for="certificado_calificaciones" class="checkbox-label-modern">
                                        <i class="fas fa-certificate"></i>
                                        Certificado de Calificaciones
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="checkbox-group">
                                <div class="checkbox-item-modern">
                                    <input type="checkbox" 
                                           class="checkbox-modern" 
                                           name="documentos[]" 
                                           value="constancia_aprobacion_primaria" 
                                           id="constancia_aprobacion_primaria">
                                    <label for="constancia_aprobacion_primaria" class="checkbox-label-modern">
                                        <i class="fas fa-stamp"></i>
                                        Constancia de Aprobación Primaria
                                    </label>
                                </div>

                                <div class="checkbox-item-modern">
                                    <input type="checkbox" 
                                           class="checkbox-modern" 
                                           name="documentos[]" 
                                           value="foto_estudiante" 
                                           id="foto_estudiante">
                                    <label for="foto_estudiante" class="checkbox-label-modern">
                                        <i class="fas fa-camera"></i>
                                        Fotografía Tipo Carnet Del Estudiante
                                    </label>
                                </div>

                                <div class="checkbox-item-modern">
                                    <input type="checkbox" 
                                           class="checkbox-modern" 
                                           name="documentos[]" 
                                           value="foto_representante" 
                                           id="foto_representante">
                                    <label for="foto_representante" class="checkbox-label-modern">
                                        <i class="fas fa-camera"></i>
                                        Fotografía Tipo Carnet Del Representante
                                    </label>
                                </div>

                                <div class="checkbox-item-modern">
                                    <input type="checkbox" 
                                           class="checkbox-modern" 
                                           name="documentos[]" 
                                           value="carnet_vacunacion" 
                                           id="carnet_vacunacion">
                                    <label for="carnet_vacunacion" class="checkbox-label-modern">
                                        <i class="fas fa-syringe"></i>
                                        Carnet de Vacunación Vigente
                                    </label>
                                </div>

                                <div class="checkbox-item-modern">
                                    <input type="checkbox" 
                                           class="checkbox-modern" 
                                           name="documentos[]" 
                                           value="autorizacion_tercero" 
                                           id="autorizacion_tercero">
                                    <label for="autorizacion_tercero" class="checkbox-label-modern">
                                        <i class="fas fa-file-signature"></i>
                                        Autorización Firmada (si inscribe un tercero)
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Observaciones --}}
            <div class="card-modern mb-4">
                <div class="card-header-modern">
                    <div class="header-left">
                        <div class="header-icon" style="background: linear-gradient(135deg, var(--info), #2563eb);">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                        <div>
                            <h3>Observaciones</h3>
                            <p>Notas adicionales sobre la inscripción</p>
                        </div>
                    </div>
                </div>

                <div class="card-body-modern" style="padding: 2rem;">
                    <div class="form-group">
                        <label for="observaciones" class="form-label-modern">
                            <i class="fas fa-edit"></i>
                            Observaciones Adicionales
                        </label>
                        <textarea class="form-control-modern @error('observaciones') is-invalid @enderror" 
                                  id="observaciones" 
                                  name="observaciones" 
                                  rows="4" 
                                  placeholder="Ingrese cualquier observación adicional sobre la inscripción...">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="card-modern">
                <div class="card-body-modern" style="padding: 2rem;">
                    <div class="d-flex justify-content-end gap-3">
                        <a href="{{ route('admin.estudiante.inicio') }}" class="btn-cancel-modern">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="btn-primary-modern" 
                                id="guardar" 
                                @if(!$anoActivo) disabled @endif>
                            <i class="fas fa-save"></i>
                            Inscribir Estudiante
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        // Inicializar Select2
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Seleccione una opción',
                allowClear: true,
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    },
                    searching: function() {
                        return "Buscando...";
                    }
                }
            });

            // Auto-cerrar alertas después de 5 segundos
            setTimeout(function() {
                $('.alert-modern').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        });
    </script>
@stop