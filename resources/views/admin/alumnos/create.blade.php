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
            <div class="alert alert-info mb-4" style="background: var(--info-light); border-left: 4px solid var(--info); padding: 1rem; border-radius: 8px;">
                        <i class="fas fa-info-circle"></i> Los campos con <span class="text-danger" style="font-weight: 700;">(*)</span> son obligatorios
                    </div>

            {{-- Card: Selección de Registros Existentes --}}
            <div class="card-modern mb-4">
                <div class="card-header-modern">
                    <div class="header-left">
                        <div class="header-icon">
                            <i class="fas fa-school"></i>
                        </div>
                        <div>
                            <h3>Plantel de procedencia</h3>
                            <p></p>
                        </div>
                    </div>
                </div>

                <div class="card-body-modern" style="padding: 2rem;">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="numero_zonificacion" class="form-label-modern">
                                    <i class="fas fa-hashtag"></i>
                                    Número de Zonificacion
                                </label>
                                <input 
                                    type="number" 
                                    class="form-control-modern" 
                                    id="numero_zonificacion" 
                                    placeholder="001"
                                    inputmode="numeric"
                                    class="form-control-modern"
                                    min="0"
                                    max="120"
                                    pattern="[0-9]+" 
                                    maxlength="4" 
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')" 
                                    >
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label-modern">
                                    <i class="fas fa-id-card-alt"></i>
                                    Expresion Literaria <span class="required-badge">*</span>
                                </label>
                                <select name="letra_expresion_literaria_id" 
                                        id="letra_expresion_literaria_id"
                                        class="form-control-modern @error('letra_expresion_literaria_id') is-invalid @enderror  selectpicker"
                                        required >
                                    <option selected disabled>Seleccione</option>
                                    @foreach ($expresion_literaria as $item)
                                        <option value="{{ $item->id }}" {{ old('letra_expresion_literaria_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->letra_expresion_literaria }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('letra_expresion_literaria_id')
                                    <div class="invalid-feedback-modern">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date" class="form-label-modern">
                                    <i class="fas fa-calendar"></i>
                                    Fecha de Egreso
                                </label>
                                <input 
                                    type="date" 
                                    class="form-control-modern" 
                                    id="anio_egreso">
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
                            <h3>Datos del estudiante</h3>
                            <p>Informacion personal del estudiante</p>
                        </div>
                    </div>
                </div>

                <div class="card-body-modern" style="padding: 2rem;">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label-modern">
                                    <i class="fas fa-id-card-alt"></i>
                                    Tipo de Documento <span class="required-badge">*</span>
                                </label>
                                <select name="tipo_documento_id" 
                                        id="tipo_documento_id"
                                        class="form-control-modern @error('tipo_documento_id') is-invalid @enderror  selectpicker"
                                        required >
                                    <option selected disabled>Seleccione</option>
                                    @foreach ($tipo_documento as $item)
                                        <option value="{{ $item->id }}" {{ old('tipo_documento_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo_documento_id')
                                    <div class="invalid-feedback-modern">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label-modern">
                                <i class="fas fa-id-card"></i>
                                Cédula <span class="required-badge">*</span>
                            </label>
                            <input type="text" 
                                name="cedula" 
                                inputmode="numeric"
                                id="cedula" 
                                pattern="[0-9]+" 
                                maxlength="8" 
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                                required
                                class="form-control-modern @error('cedula') is-invalid @enderror"
                                value="{{ old('cedula') }}"
                                placeholder="12345678">
                            @error('cedula')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <small class="form-text-modern">
                                <i class="fas fa-info-circle"></i>
                                Solo números, máximo 8 dígitos
                            </small>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date" class="form-label-modern">
                                    <i class="fas fa-calendar"></i>
                                    Fecha de Nacimiento
                                </label>
                                <input 
                                    type="date" 
                                    class="form-control-modern  @error('fecha_nacimiento') is-invalid @enderror" 
                                    id="fecha_nacimiento">
                                @error('fecha_nacimiento')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label-modern">
                                <i class="fas fa-id-card"></i>
                                Edad <span class="required-badge">*</span>
                            </label>
                            <input  
                                pattern="[0-9]+" 
                                class="form-control-modern"
                                readonly>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label-modern">
                                <i class="fas fa-id-card"></i>
                                Meses <span class="required-badge">*</span>
                            </label>
                            <input  
                                pattern="[0-9]+" 
                                class="form-control-modern"
                                readonly>
                        </div>
                    </div>
                    <div class="row">

                    {{-- Primer nombre --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label-modern">
                                <i class="fas fa-user"></i>
                                Primer nombre <span class="required-badge">*</span>
                            </label>
                            <input type="text" name="primer_nombre"
                                class="form-control-modern @error('primer_nombre') is-invalid @enderror"
                                value="{{ old('primer_nombre') }}"
                                placeholder="Ej: Juan"
                                required>
                            @error('primer_nombre')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Segundo nombre --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label-modern">
                                <i class="fas fa-user"></i>
                                Segundo nombre
                            </label>
                            <input type="text" name="segundo_nombre"
                                class="form-control-modern @error('segundo_nombre') is-invalid @enderror"
                                value="{{ old('segundo_nombre') }}"
                                placeholder="Ej: Carlos">
                            @error('segundo_nombre')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Tercer nombre --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label-modern">
                                <i class="fas fa-user"></i>
                                Tercer nombre
                            </label>
                            <input type="text" name="tercer_nombre"
                                class="form-control-modern @error('tercer_nombre') is-invalid @enderror"
                                value="{{ old('tercer_nombre') }}"
                                placeholder="Opcional">
                            @error('tercer_nombre')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Primer apellido --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label-modern">
                                <i class="fas fa-user-tag"></i>
                                Primer apellido <span class="required-badge">*</span>
                            </label>
                            <input type="text" name="primer_apellido"
                                class="form-control-modern @error('primer_apellido') is-invalid @enderror"
                                value="{{ old('primer_apellido') }}"
                                placeholder="Ej: Pérez"
                                required>
                            @error('primer_apellido')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Segundo apellido --}}
                        <div class="col-md-4 mb-3">
                            <label class="form-label-modern">
                                <i class="fas fa-user-tag"></i>
                                Segundo apellido
                            </label>
                            <input type="text" name="segundo_apellido"
                                class="form-control-modern @error('segundo_apellido') is-invalid @enderror"
                                value="{{ old('segundo_apellido') }}"
                                placeholder="Ej: Gómez">
                            @error('segundo_apellido')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Género --}}
                        {{-- --}}
                </div> {{-- row --}}
                <div class="row">
                    <div class="col-md-2">
                        <label class="form-label-modern">
                            <i class="fas fa-venus-mars"></i>
                            Género
                            <span class="required-badge">*</span>
                        </label>
                        <select name="genero" id="genero"
                                class="form-control-modern @error('genero') is-invalid @enderror"
                                required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach ($genero as $item)
                                <option value="{{ $item->id }}" {{ old('genero') == $item->id ? 'selected' : '' }}>
                                    {{ $item->genero }}
                                </option>
                            @endforeach
                        </select>
                        @error('genero')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label-modern">
                            <i class="fas fa-venus-mars"></i>
                            Lateralidad
                            <span class="required-badge">*</span>
                        </label>
                        <select name="lateralidad" id="lateralidad"
                                class="form-control-modern @error('lateralidad') is-invalid @enderror"
                                required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach ($lateralidad as $item)
                                <option value="{{ $item->id }}" {{ old('lateralidad') == $item->id ? 'selected' : '' }}>
                                    {{ $item->lateralidad }}
                                </option>
                            @endforeach
                        </select>
                        @error('lateralidad')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="col-md-3">
                        <label class="form-label-modern">
                            <i class="fas fa-venus-mars"></i>
                           Orden de Nac
                            <span class="required-badge">*</span>
                        </label>
                        <select name="orden_nacimiento" id="orden_nacimiento"
                                class="form-control-modern @error('orden_nacimiento') is-invalid @enderror"
                                required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach ($orden_nacimiento as $item)
                                <option value="{{ $item->id }}" {{ old('orden_nacimiento') == $item->id ? 'selected' : '' }}>
                                    {{ $item->orden_nacimiento }}
                                </option>
                            @endforeach
                        </select>
                        @error('orden_nacimiento')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror

                    </div>
                    <br>
                    <br>


                    <div class="card-header-modern" style="margin-top: 2rem">
                        <div class="header-left">
                            <div class="header-icon" >
                                <i class="fas fa-student"></i>
                            </div>
                            <div>
                                <h3>Direccion del estudiante</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label-modern">
                                    <i class="fas fa-id-card-alt"></i>
                                    Estado <span class="required-badge">*</span>
                                </label>
                                <select name="estado" 
                                        id="estado"
                                        class="form-control-modern @error('estado') is-invalid @enderror  selectpicker"
                                        required >
                                    <option selected disabled>Seleccione</option>
                                    @foreach ($estado as $item)
                                        <option value="{{ $item->id }}" {{ old('estado') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nombre_estado }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback-modern">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label-modern">
                                    <i class="fas fa-id-card-alt"></i>
                                    Municipio <span class="required-badge">*</span>
                                </label>
                                <select name="municipio" 
                                        id="municipio"
                                        class="form-control-modern @error('municipio') is-invalid @enderror  selectpicker"
                                        required >
                                    <option selected disabled>Seleccione</option>
                                    @foreach ($municipio as $item)
                                        <option value="{{ $item->id }}" {{ old('municipio') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nombre_municipio }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('municipio')
                                    <div class="invalid-feedback-modern">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
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