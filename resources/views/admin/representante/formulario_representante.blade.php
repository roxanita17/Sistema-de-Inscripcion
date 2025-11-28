
@extends('adminlte::page')

@section('title', 'Gestión de Representantes')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Gestión de Representantes</h1>
        <a href="{{ route('representante.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
@stop

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registro de Representante</h3>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Los campos marcados con <span class="text-danger">(*)</span> son obligatorios
            </div>

            <form id="representante-form" action="{{ route('representante.save') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <!-- Sección de la Madre -->
                <div class="card card-outline card-primary mb-4">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-female me-2"></i>Datos de la Madre
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <label class="form-label fw-bold d-block mb-3">
                                <span class="text-danger">(*)</span> Estado de la madre:
                            </label>
                            <div class="d-flex flex-wrap gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="Presente" name="estado_madre" id="Presente_madre" required>
                                    <label class="form-check-label d-flex align-items-center" for="Presente_madre">
                                        <i class="fas fa-user-check me-2"></i>
                                        <span>Presente</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="Ausente" name="estado_madre" id="Ausente_madre" required>
                                    <label class="form-check-label d-flex align-items-center" for="Ausente_madre">
                                        <i class="fas fa-user-times me-2"></i>
                                        <span>Ausente</span>
                                    </label>
                                </div>
                                {{-- OPCIÓN DIFUNTO COMENTADA --}}
                                {{-- <div class="form-check">
                                    <input class="form-check-input" type="radio" value="difunto" name="estado_madre" id="difunto_madre">
                                    <label class="form-check-label d-flex align-items-center" for="difunto_madre">
                                        <i class="fas fa-cross me-2"></i>
                                        <span>Difunto</span>
                                    </label>
                                </div> --}}
                            </div>
                            <div class="invalid-feedback">
                                Por favor seleccione el estado de la madre.
                            </div>
                            <small id="estado_madre-error" class="text-danger mt-1"></small>
                    
            {{-- Datos personales --}}
                        <!-- Sección de Datos Personales -->
                        <div class="border rounded p-4 mb-4 bg-light">
                            <h5 class="mb-4 pb-2 border-bottom">
                                <i class="fas fa-id-card me-2"></i>Datos Personales
                            </h5>
                
                <div class="row">


                    {{-- DATOS PERSONALES MADRE --}}


                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="tipo-ci" class="form-label required">Tipo de Documento</label>
                            <select class="form-select" id="tipo-ci" name="tipo-ci" required>
                                <option value="" disabled selected>Seleccione</option>
                                @foreach($tipoDocumentos as $tipoDoc)
                                    <option value="{{ $tipoDoc->id }}">{{ $tipoDoc->tipo_documento }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Por favor seleccione el tipo de documento.
                            </div>
                            <small id="tipo-ci-error" class="text-danger"></small>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="cedula" class="form-label required">Número de Cédula</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" 
                                maxlength="8" pattern="[0-9]+" 
                                title="Ingrese solo números (máximo 8 dígitos)" required>
                            <div class="invalid-feedback">
                                Por favor ingrese un número de cédula válido (solo números).
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="fechaNacimiento" class="form-label required">Fecha de Nacimiento</label>
                            <input type="date" id="fechaNacimiento" name="fechaNacimiento" 
                                class="form-control" required>
                            <div class="invalid-feedback">
                                Por favor ingrese una fecha de nacimiento válida.
                            </div>
                            <small id="error-edad" class="text-danger d-none">La edad debe estar entre 10 y 17 años</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="primer-nombre" class="form-label required">Primer Nombre</label>
                            <input type="text" class="form-control" id="primer-nombre" name="primer-nombre"
                                pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" 
                                title="Solo se permiten letras y espacios, no se aceptan números" required>
                            <div class="invalid-feedback">
                                Por favor ingrese un nombre válido (solo letras y espacios).
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="segundo-nombre" class="form-label">Segundo Nombre</label>
                            <input type="text" class="form-control" id="segundo-nombre" name="segundo-nombre"
                                pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]*"
                                title="Solo se permiten letras y espacios, no se aceptan números">
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="tercer-nombre" class="form-label">Tercer Nombre</label>
                            <input type="text" class="form-control" id="tercer-nombre" name="tercer-nombre"
                                pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]*"
                                title="Solo se permiten letras y espacios, no se aceptan números">
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="primer-apellido" class="form-label required">Primer Apellido</label>
                            <input type="text" class="form-control" id="primer-apellido" name="primer-apellido"
                                pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" 
                                title="Solo se permiten letras y espacios, no se aceptan números" required>
                            <div class="invalid-feedback">
                                Por favor ingrese un apellido válido (solo letras y espacios).
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="segundo-apellido" class="form-label">Segundo Apellido</label>
                            <input type="text" class="form-control" id="segundo-apellido" name="segundo-apellido"
                                pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]*"
                                title="Solo se permiten letras y espacios, no se aceptan números">
                        </div>
                    </div>
                </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="sexo" class="form-label required">Género</label>
                            <select class="form-select" id="sexo" name="sexo" required>
                                <option value="" disabled selected>Seleccione</option>
                                @foreach ($generos as $genero)
                                    <option value="{{ $genero->id }}">{{ $genero->genero }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Por favor seleccione un género.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                        <!-- Sección de Dirección y Contactos -->
                        <div class="border rounded p-4 mb-4 bg-light">
                            <h5 class="mb-4 pb-2 border-bottom">
                                <i class="fas fa-address-book me-2"></i>Dirección y Contactos
                            </h5>
                
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="lugar-nacimiento" class="form-label required">Lugar de Nacimiento</label>
                            <input type="text" class="form-control" id="lugar-nacimiento" name="lugar-nacimiento"
                                pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" 
                                title="Solo se permiten letras y espacios, no se aceptan números"
                                maxlength="100" required>
                            <div class="invalid-feedback">
                                Por favor ingrese un lugar de nacimiento válido.
                            </div>
                        </div>
                    </div>


                    
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text" id="inputGroup-sizing-default">
                            <span class="text-danger">(*)</span>Estado
                        </span>
                        <select class="form-select" id="idEstado" name="idEstado"
                                style="display: block !important; visibility: visible !important; opacity: 1 !important;"
                                aria-label="Seleccione un estado">
                            <option value="">Seleccione un estado</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->id }}" 
                                        @if(old('idEstado') == $estado->id) selected @endif>
                                    {{ $estado->nombre_estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <small id="idEstado-error" class="text-danger"></small>
                </div>
                <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text" id="inputGroup-sizing-default"><span class="text-danger">(*)</span>Municipio</span>
                            <select class="form-select" id="idMunicipio" name="idMunicipio" aria-label="Seleccione un municipio">
                                <option value="">Seleccione un municipio</option>
                            </select>
                        </div>
                        <small id="idMunicipio-error" class="text-danger"></small>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroup-sizing-default"><span class="text-danger">(*)</span>Localidad</span>
                            <select class="form-select" id="idparroquia" name="idparroquia" aria-label="Seleccione una parroquia">
                                <option value="">Seleccione una parroquia</option>
                            </select>
                        </div>
                        <small id="idparroquia-error" class="text-danger"></small>
                    </div>
                </div>
                                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="input-group">
                            <label class="input-group-text" for="prefijo"><span class="text-danger">(*)</span>Prefijo</label>
                            <select class="form-select" id="prefijo" name="prefijo" title="Seleccione el tipo de linea Teléfonica" required>
                                <option value="">Seleccione</option>
                                     @foreach($prefijos_telefono as $prefijo)
                                    <option value="{{ $prefijo->id }}">{{ $prefijo->prefijo }}</option> 
                                    @endforeach
                            </select>
                        </div>
                        <small id="prefijo-error" class="text-danger"></small>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroup-sizing-default"><span class="text-danger">(*)</span>Número de Teléfono:</span>
                            <input type="text" class="form-control" aria-label="Sizing example input" id="telefono" name="telefono"
                                aria-describedby="inputGroup-sizing-default" pattern="[0-9]+" maxlength="11" title="Ingresa solamente numeros,no se permiten letras" required>
                        </div>
                        <small id="telefono-error" class="text-danger"></small>
                    </div>
                </div>
            </div>

            </div>  
            


                        <!-- Sección de Relación Familiar -->
                        <div class="border rounded p-4 bg-light">
                            <h5 class="mb-4 pb-2 border-bottom">
                                <i class="fas fa-users me-2"></i>Relación Familiar con el Estudiante
                            </h5>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroup-sizing-default"><span class="text-danger">(*)</span>Ocupación</span>
                            <select name="ocupacion-madre" id="ocupacion-madre" class="form-select" required>
                                <option value="" disabled selected>Seleccione</option>
                                @foreach ($ocupaciones as $ocupacion)
                                    <option value="{{ $ocupacion->id }}">{{ $ocupacion->nombre_ocupacion }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Por favor seleccione una ocupación.
                            </div>
                        </div>
                        <small id="ocupacion-error" class="text-danger"></small>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="input-group" id="otra-ocupacion-container" style="display:none">
                            <span class="input-group-text" id="inputGroup-sizing-default"><span class="text-danger">(*)</span>Otra Ocupación</span>
                            <input type="text" class="form-control" aria-label="Sizing example input" id="otra-ocupacion" name="otra-ocupacion"
                                aria-describedby="inputGroup-sizing-default" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios,no se aceptan números" required>
                        </div>
                        <small id="otra-ocupacion-error" class="text-danger"></small>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <span><span class="text-danger">(*)</span>Convive con el Estudiante?</span>
                        <div class="d-flex mt-1">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" id="convive-si" name="convive" value="si">
                                <label class="form-check-label" for="convive-si">Si</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="convive-no" name="convive" value="no">
                                <label class="form-check-label" for="convive-no">No</label>
                            </div>
                        </div>
                        <small id="convive-error" class="error-message text-danger"></small>
                    </div>
                        <small id="representante_legal-error" class="error-message text-danger"></small>
                    </div>

                            </div>
                        </div>
                    
                </div>
             </div>
        </div>      
            {{-- Formulario del Padre --}}

<!-- Sección del Padre -->
<div class="card card-outline card-primary mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-male me-2"></i>Datos del Padre
        </h3>
    </div>
    <div class="card-body">
        <div class="form-group mb-4">
            <label class="form-label fw-bold d-block mb-3">
                <span class="text-danger">(*)</span> Estado del padre:
            </label>
            <div class="d-flex flex-wrap gap-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Presente" name="estado_padre" id="Presente_padre" required>
                    <label class="form-check-label d-flex align-items-center" for="Presente_padre">
                        <i class="fas fa-user-check me-2"></i>
                        <span>Presente</span>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" value="Ausente" name="estado_padre" id="Ausente_padre">
                    <label class="form-check-label d-flex align-items-center" for="Ausente_padre">
                        <i class="fas fa-user-times me-2"></i>
                        <span>Ausente</span>
                    </label>
                </div>
            </div>
            <div class="invalid-feedback">
                Por favor seleccione el estado del padre.
            </div>
        </div>

        <!-- Sección de Datos Personales -->
        <div class="border rounded p-4 mb-4 bg-light">
            <h5 class="mb-4 pb-2 border-bottom">
                <i class="fas fa-id-card me-2"></i>Datos Personales
            </h5>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="tipo-ci-padre" class="form-label required">Tipo de Documento</label>
                        <select class="form-select" id="tipo-ci-padre" name="tipo-ci-padre" required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach($tipoDocumentos as $tipoDoc)
                                <option value="{{ $tipoDoc->id }}">{{ $tipoDoc->tipo_documento }}</option>
                            @endforeach
                        </select>
                    </div>
                    <small id="tipo-ci-padre-error" class="text-danger"></small>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="cedula-padre" class="form-label required">Número de Cédula</label>
                        <input type="text" class="form-control" id="cedula-padre" name="cedula-padre"
                            maxlength="8" pattern="[0-9]+" 
                            title="Ingrese solo números (máximo 8 dígitos)" required>
                        <div class="invalid-feedback">
                            Por favor ingrese un número de cédula válido (solo números).
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="fechaNacimiento-padre" class="form-label required">Fecha de Nacimiento</label>
                        <input type="date" id="fechaNacimiento-padre" name="fechaNacimiento-padre" 
                            class="form-control" required>
                        <div class="invalid-feedback">
                            Por favor ingrese una fecha de nacimiento válida.
                        </div>
                        <small id="error-edad-padre" class="text-danger d-none">La edad debe ser mayor de 18 años</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="primer-nombre-padre" class="form-label required">Primer Nombre</label>
                        <input type="text" class="form-control" id="primer-nombre-padre" name="primer-nombre-padre"
                            pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" 
                            title="Solo se permiten letras y espacios, no se aceptan números" required>
                        <div class="invalid-feedback">
                            Por favor ingrese un nombre válido (solo letras y espacios).
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="segundo-nombre-padre" class="form-label">Segundo Nombre</label>
                        <input type="text" class="form-control" id="segundo-nombre-padre" name="segundo-nombre-padre"
                            pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]*"
                            title="Solo se permiten letras y espacios, no se aceptan números">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="tercer-nombre" class="form-label">Tercer Nombre</label>
                            <input type="text" class="form-control" id="tercer-nombre" name="tercer-nombre"
                                pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]*"
                                title="Solo se permiten letras y espacios, no se aceptan números">
                        </div>
                    </div>

                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="primer-apellido-padre" class="form-label required">Primer Apellido</label>
                        <input type="text" class="form-control" id="primer-apellido-padre" name="primer-apellido-padre"
                            pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" 
                            title="Solo se permiten letras y espacios, no se aceptan números" required>
                        <div class="invalid-feedback">
                            Por favor ingrese un apellido válido (solo letras y espacios).
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="segundo-apellido-padre" class="form-label">Segundo Apellido</label>
                        <input type="text" class="form-control" id="segundo-apellido-padre" name="segundo-apellido-padre"
                            pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]*"
                            title="Solo se permiten letras y espacios, no se aceptan números">
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="genero-padre" class="form-label required">Género</label>
                        <select class="form-select" id="genero-padre" name="genero-padre" required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach ($generos as $genero)
                                <option value="{{ $genero->id }}">{{ $genero->genero }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un género.
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="lugar-nacimiento-padre" class="form-label required">Lugar de Nacimiento</label>
                        <input type="text" class="form-control" id="lugar-nacimiento-padre" name="lugar-nacimiento-padre"
                            pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" 
                            title="Solo se permiten letras y espacios, no se aceptan números"
                            maxlength="100" required>
                        <div class="invalid-feedback">
                            Por favor ingrese un lugar de nacimiento válido.
                        </div>
                    </div>
                </div>    
            </div>

        <!-- Sección de Dirección y Contactos -->
        <div class="border rounded p-4 mb-4 bg-light">
            <h5 class="mb-4 pb-2 border-bottom">
                <i class="fas fa-address-book me-2"></i>Dirección y Contactos
            </h5>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="idEstado-padre" class="form-label required">Estado</label>
                        <select class="form-select" id="idEstado-padre" name="idEstado-padre" required>
                            <option value="" disabled selected>Seleccione un estado</option>
                            @foreach ($estados as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un estado.
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="idMunicipio-padre" class="form-label required">Municipio</label>
                        <select class="form-select" id="idMunicipio-padre" name="idMunicipio-padre" required>
                            <option value="" disabled selected>Seleccione un municipio</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un municipio.
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="idparroquia-padre" class="form-label required">Parroquia</label>
                        <select class="form-select" id="idparroquia-padre" name="idparroquia-padre" required>
                            <option value="" disabled selected>Seleccione una parroquia</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione una parroquia.
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label for="direccion-padre" class="form-label required">Dirección</label>
                        <input type="text" class="form-control" id="direccion-padre" name="direccion-padre" required>
                        <div class="invalid-feedback">
                            Por favor ingrese una dirección.
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <label for="prefijo-padre" class="form-label required">Prefijo Tel.</label>
                        <select class="form-select" id="prefijo-padre" name="prefijo-padre" required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach($prefijos_telefono as $prefijo)
                                <option value="{{ $prefijo->id }}">{{ $prefijo->prefijo }} ({{ $prefijo->tipo_linea }})</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un prefijo telefónico.
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="telefono-padre" class="form-label required">Número de Teléfono</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="telefono-padre" name="telefono-padre"
                                pattern="[0-9]+" maxlength="11" 
                                title="Ingrese solo números (máximo 11 dígitos)" required>
                        </div>
                        <div class="invalid-feedback">
                            Por favor ingrese un número de teléfono válido (solo números).
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Sección Relación Familiar -->
        <div class="border rounded p-4 mb-4 bg-light">
            <h5 class="mb-4 pb-2 border-bottom">
                <i class="fas fa-users me-2"></i>Relación Familiar con el Estudiante
            </h5>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="ocupacion-padre" class="form-label required">Ocupación</label>
                        <select class="form-select" id="ocupacion-padre" name="ocupacion-padre" required>
                            <option value="" disabled selected>Seleccione</option>
                            @foreach($ocupaciones as $ocupacion)
                                <option value="{{ $ocupacion->id }}">{{ $ocupacion->nombre_ocupacion }}</option>
                            @endforeach
                            <option value="otro">Otra ocupación</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione una ocupación.
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-3" id="otra-ocupacion-padre-container" style="display: none;">
                    <div class="form-group">
                        <label for="otra-ocupacion-padre" class="form-label">Especifique Ocupación</label>
                        @foreach ($ocupaciones as $ocupacion)
                            <option value="{{ $ocupacion->id }}">{{ $ocupacion->nombre }}</option>
                        @endforeach  
                        <input type="text" class="form-control" id="otra-ocupacion-padre" name="otra-ocupacion-padre"
                            pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" 
                            title="Solo se permiten letras y espacios">
                        <div class="invalid-feedback">
                            Por favor ingrese una ocupación válida (solo letras y espacios).
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label class="form-label d-block mb-2 required">¿Convive con el Estudiante?</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check me-4">
                                <input class="form-check-input" type="radio" name="convive-padre" id="convive-si-padre" value="1" required>
                                <label class="form-check-label" for="convive-si-padre">
                                    <i class="fas fa-check-circle me-1"></i> Sí
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="convive-padre" id="convive-no-padre" value="0">
                                <label class="form-check-label" for="convive-no-padre">
                                    <i class="fas fa-times-circle me-1"></i> No
                                </label>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            Por favor indique si convive con el estudiante.
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label for="observaciones-padre" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones-padre" name="observaciones-padre" rows="2"></textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Sección del Representante Legal --}}
<div class="card card-outline card-primary mb-4">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user-tie me-2"></i>Datos del Representante Legal
        </h3>
    </div>
    <div class="card-body">
        <div class="form-group mb-4">
            <label class="form-label fw-bold d-block mb-3">
                <span class="text-danger">(*)</span> Tipo de Representante:
            </label>
            <div class="d-flex flex-wrap gap-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_representante" id="solo_representante" value="solo_representante" required>
                    <label class="form-check-label d-flex align-items-center" for="solo_representante">
                        <i class="fas fa-user-tag me-2"></i>
                        <span>Solo Representante Legal</span>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_representante" id="progenitor_representante" value="progenitor_representante">
                    <label class="form-check-label d-flex align-items-center" for="progenitor_representante">
                        <i class="fas fa-users me-2"></i>
                        <span>Progenitor como Representante</span>
                    </label>
                </div>
            </div>
            <div class="invalid-feedback">
                Por favor seleccione el tipo de representante.
            </div>
        </div>

        {{-- Datos personales --}}
        <!-- Sección de Datos Personales -->
        <div class="border rounded p-4 mb-4 bg-light">
            <h5 class="mb-4 pb-2 border-bottom">
                <i class="fas fa-id-card me-2"></i>Datos Personales
            </h5>
                
            <div class="row identification-row">
                {{-- DATOS DE IDENTIFICACIÓN --}}
                <div class="col-md-2 mb-3">
                    <div class="input-group">
                        <label class="input-group-text" for="tipo-ci-representante"><span class="text-danger">(*)</span>Doc.</label>
                        <select class="form-select" id="tipo-ci-representante" name="tipo-ci-representante" required>
                            <option value="">Seleccione</option>
                            @foreach($tipoDocumentos as $tipoDoc)
                                <option value="{{ $tipoDoc->id }}">{{ $tipoDoc->tipo_documento }}</option>
                            @endforeach
                        </select>
                    </div>
                    <small id="tipo-ci-representante-error" class="text-danger"></small>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text" id="inputGroup-sizing-default"><span class="text-danger">(*)</span>Cédula</span>
                        <input type="text" class="form-control" id="cedula-representante" name="cedula-representante" aria-label="Sizing example input"
                            aria-describedby="inputGroup-sizing-default" maxlength="8" pattern="[0-9]+" title="Ingresa solamente numeros,no se permiten letras" required>
                    </div>
                    <input type="hidden" id="persona-id-representante" name="persona-id-representante">
                    <input type="hidden" id="representante-id" name="representante-id">
                    <small id="cedula-representante-error" class="text-danger"></small>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="primer-nombre-representante" name="primer-nombre-representante" placeholder="Primer nombre *"
                                    pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios,no se aceptan números" required>
                                <small class="text-danger" id="primer-nombre-representante-error"></small>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="segundo-nombre-representante" name="segundo-nombre-representante" placeholder="Segundo nombre"
                                    pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios,no se aceptan números">
                                <small class="text-danger" id="segundo-nombre-representante-error"></small>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="primer-apellido-representante" name="primer-apellido-representante" placeholder="Primer apellido *"
                                    pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios,no se aceptan números" required>
                                <small class="text-danger" id="primer-apellido-representante-error"></small>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="segundo-apellido-representante" name="segundo-apellido-representante" placeholder="Segundo apellido"
                                    pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios,no se aceptan números" required>
                                <small class="text-danger" id="segundo-apellido-representante-error"></small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tercer Nombre</span>
                            <input type="text" class="form-control" id="tercer-nombre-representante" name="tercer-nombre-representante"
                                aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios,no se aceptan números">
                        </div>
                        <small id="tercer-nombre-representante-error" class="text-danger"></small>
                    </div>
                </div>
            </div>

                        <!-- Sección de Dirección y Contactos -->
                        <div class="border rounded p-4 mb-4 bg-light">
                            <h5 class="mb-4 pb-2 border-bottom">
                                <i class="fas fa-address-book me-2"></i>Dirección y Contactos
                            </h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroup-sizing-default"><span class="text-danger">(*)</span>Lugar de Nacimiento</span>
                            <input type="textarea" class="form-control" aria-label="Sizing example input" id="lugar-nacimiento-representante" name="lugar-nacimiento-representante" title="Solo se permiten letras y espacios,no se aceptan números" required
                                aria-describedby="inputGroup-sizing-default" maxlength="30">
                        </div>
                        <small id="lugar-nacimiento-representante-error" class="text-danger"></small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroup-sizing-default"><span class="text-danger">(*)</span>Estado</span>
                                <select class="form-select" id="idEstado-representante" name="idEstado-representante" 
                                        aria-label="Default select example" onchange="window.cargarMunicipiosRepresentante(this.value)">
                                <option value="">Seleccione</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                                @endforeach
                            </select>
                        </div>
                        <small id="idEstado-representante-error" class="text-danger"></small>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroup-sizing-default"><span class="text-danger">(*)</span>Municipio</span>
                            <select class="form-select" id="idMunicipio-representante" name="idMunicipio-representante" 
                                aria-label="Default select example" onchange="window.cargarParroquiasRepresentante(this.value)">
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                        <small id="idMunicipio-representante-error" class="text-danger"></small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroup-sizing-default"><span class="text-danger">(*)</span>Localidad</span>
                            <select class="form-select" id="idparroquia-representante" name="idparroquia-representante" aria-label="Default select example">
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                        <small id="idparroquia-representante-error" class="text-danger"></small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="input-group">
                            <label class="input-group-text" for="prefijo-representante"><span class="text-danger">(*)</span>Prefijo</label>
                            <select class="form-select" id="prefijo-representante" name="prefijo-representante" title="Seleccione el tipo de linea Teléfonica" required>
                                <option value="">Seleccione</option>
                                     @foreach($prefijos_telefono as $prefijo)
                                    <option value="{{ $prefijo->id }}">{{ $prefijo->prefijo }}</option> 
                                    @endforeach
                            </select>
                        </div>
                        <small id="prefijo-representante-error" class="text-danger"></small>
                    </div>
                    
                    <div class="col-md-5 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroup-sizing-default"><span class="text-danger">(*)</span>Número de Teléfono:</span>
                            <input type="text" class="form-control" aria-label="Sizing example input" id="telefono-representante" name="telefono-representante"
                                aria-describedby="inputGroup-sizing-default" pattern="[0-9]+" maxlength="11" title="Ingresa solamente numeros,no se permiten letras" required>
                        </div>
                        <small id="telefono-representante-error" class="text-danger"></small>
                    </div>
                </div>
            </div>

            <div class="border border-primary rounded px-3 py-3 mt-3">

                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group">
                                            <h4 class="mb-3">Relación Familiar Con El Estudiante</h4>
                            <span class="input-group-text" id="inputGroup-sizing-default"><span class="text-danger">(*)</span>Ocupación</span>
                            <select name="ocupacion-representante" id="ocupacion-representante" class="form-select" required>
                                <option value="" disabled selected>Seleccione</option>
                                <!-- Opciones de ocupación -->
                                @foreach($ocupaciones as $ocupacion)
                                    <option value="{{ $ocupacion->id }}">{{ $ocupacion->nombre_ocupacion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <small id="ocupacion-representante-error" class="text-danger"></small>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="input-group" id="otra-ocupacion-container" style="display:none">
                            <span class="input-group-text" id="inputGroup-sizing-default"><span class="text-danger">(*)</span>Otra Ocupación</span>
                            <input type="text" class="form-control" aria-label="Sizing example input" id="otra-ocupacion-representante" name="otra-ocupacion-representante"
                                aria-describedby="inputGroup-sizing-default" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios,no se aceptan números" required>
                        </div>
                        <small id="otra-ocupacion-error-representante" class="text-danger"></small>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <span><span class="text-danger">(*)</span>Convive con el Estudiante?</span>
                        <div class="d-flex mt-1">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" id="convive-si" name="convive-representante" value="si">
                                <label class="form-check-label" for="convive-si-representante">Si</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="convive-no-representante" name="convive-representante" value="no">
                                <label class="form-check-label" for="convive-no-representante">No</label>
                            </div>
                        </div>
                        <small id="convive-representante-error" class="error-message text-danger"></small>
                    </div>
                </div>                                                   <div class="row">
                                                                <h4 class=" p-3">Conectividad Y Participación Ciudadana</h4>
                                                        <div class="col-sm-6 mb-3">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text"
                                                                    id="inputGroup-sizing-default">Correo</span>
                                                                <input type="email" class="form-control" id="correo-representante" name="correo-representante"
                                                                    aria-label="Sizing example input"
                                                                    aria-describedby="inputGroup-sizing-default" maxlength="254" title="No olvide caracteres especiales como el @">
                                                            </div>
                                                            <small id="correo-representante-error" class="text-danger"></small>
                                                            
                                                        </div>
                                                        <div class="col-sm-6 mb-3">
                                                            <span><span class="text-danger">(*)</span>Pertenece a Organización Política o
                                                                Comunitaria?</span>
                                                            <div class="d-flex mt-1">
                                                                <div class="form-check me-3" >
                                                                    <input class="form-check-input" type="radio"
                                                                        id="opcion_si" name="pertenece-organizacion" value="si">
                                                                    <label class="form-check-label" for="opcion_si">
                                                                        Si
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        id="opcion_no" name="pertenece-organizacion" value="no">
                                                                    <label class="form-check-label" for="opcion_no">
                                                                        No
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <small id="pertenece-organizacion-error" class="text-danger"></small>
                                                        </div>
                                                        <div class="col-sm-12 mb-3">
                                                            <div id="campo_organizacion" class="input-group mb-3" style="display: none">
                                                                <span class="input-group-text" >A
                                                                    cual:</span>
                                                                <input type="text" class="form-control" id="cual-organizacion" name="cual-organizacion"
                                                                    aria-label="Sizing example input" title="Ingrese la Organizacion Política O Comunitaria Al Que Pertenece, no se aceptan numeros"
                                                                    aria-describedby="inputGroup-sizing-default"  maxlength="30">
                                                            </div>
                                                            <small id="cual-organizacion-error" class="text-danger d-none " ></small>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="border border-primary rounded px-1 py-1 mt-2">
                                                        <div class="row">
                                                            <h4 class=" p-3">Identificación Familiar Y Datos De Cuenta</h4>
                                                        <div class="col-md-4 mb-3">
                                                            <div class="input-group mb-3">
                                                                <label class="input-group-text"
                                                                    for="inputGroupSelect01"><span class="text-danger">(*)</span>Parentesco</label>
                                                                <select class="form-select" id="parentesco" name="parentesco" required>
                                                                    <option value="">Seleccione parentesco</option>
                                                                    <option value="Papá">Papá</option>
                                                                    <option value="Mamá">Mamá</option>
                                                                    <option value="Hermano">Hermano</option>
                                                                    <option value="Hermana">Hermana</option>
                                                                    <option value="Abuelo">Abuelo</option>
                                                                    <option value="Abuela">Abuela</option>
                                                                    <option value="Tío">Tío</option>
                                                                    <option value="Tía">Tía</option>
                                                                    <option value="Otro">Otro</option>
                                                                </select>
                                                                <small id="parentesco-error" class="text-danger"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <div class="input-group mb-3">
                                                                <label class="input-group-text" for="inputGroupSelect01"><span
                                                                        class="text-danger">(*)</span>Carnet de la
                                                                    Patria Afiliada a:</label>
                                                                <select class="form-select" id="carnet-patria" name="carnet-patria">
                                                                    <option value=""></option>
                                                                    <option value="1">Padre</option>
                                                                    <option value="2">Madre</option>
                                                                </select>
                                                            </div>
                                                            <small id="carnet-patria-error" class="text-danger " ></small>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="inputGroup-sizing-default"><span
                                                                        class="text-danger">(*)</span>Código</span>
                                                                <input type="text" class="form-control" id="codigo" name="codigo"
                                                                    aria-label="Sizing example input"
                                                                    aria-describedby="inputGroup-sizing-default" maxlength="10" pattern="[0-9]+" title="Ingresa solamente numeros,no se permiten letras">
                                                            </div>
                                                            <small id="codigo-error" class="text-danger " ></small>
                                                        </div>

                                                    </div>


                                                            <div class="row">
                                                                <div class="col-md-4 mb-3">
                                                                    <div class="input-group mb-3">
                                                                        <span class="input-group-text" ><span
                                                                                class="text-danger">(*)</span>Serial:</span>
                                                                        <input type="text" class="form-control" id="serial" name="serial"
                                                                            aria-label="Sizing example input"
                                                                            aria-describedby="inputGroup-sizing-default" maxlength="9" pattern="[0-9]+" title="Ingresa solamente números, máximo 9 dígitos">
                                                                    </div>
                                                                    <small id="serial-error" class="text-danger" ></small>
                                                                </div>

                                                                <div class="col-md-4 mb-3">
                                                                    <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01"><span
                                                                                class="text-danger">(*)</span>Tipo de Cuenta:</label>
                                                                        <select class="form-select" id="tipo-cuenta" name="tipo-cuenta">
                                                                            <option value=""></option>
                                                                            <option value="1">Corriente</option>
                                                                            <option value="2">Ahorro</option>
                                                                        </select>
                                                                    </div>
                                                                    <small id="tipo-cuenta-error" class="text-danger"></small>
                                                                </div>

                                                                <div class="col-md-4 mb-3">
                                                                    <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01"><span
                                                                                class="text-danger">(*)</span>Banco</label>
                                                                        <select class="form-select" id="banco-representante" name="banco-representante">
                                                                            <option value="">Seleccione</option>
                                                                            @foreach ($bancos as $banco)
                                                                                <option value="{{ $banco->id }}">{{ $banco->nombre_banco }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <small id="banco-representante-error" class="text-danger"></small>
                                                                </div>
                                                            </div>

                                                </div>

                                                    <div class="border border-primary rounded px-1 py-1 mt-2">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <h4 class=" p-3">Dirección de Habitación</h4>
                                                                        <textarea class="form-control" id="direccion-habitacion" name="direccion-habitacion" rows="3" maxlength="50" title="Coloque su Dirección Calle, Avenida..." placeholder="E.j : Barrio Araguaney Avenida 5 calle 9" required></textarea>
                                                                        <small id="direccion-habitacion-error" class="text-danger"></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                    </div>

            </div>
        </div>

                        </div><!-- Fin Sección Relación Familiar -->
                    </div><!-- Fin card-body -->
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Guardar Datos
                        </button>
                        <a href="{{ route('representante.index') }}" class="btn btn-outline-secondary ms-2">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </a>
                    </div>
                </div><!-- Fin Sección Madre -->
            </form>
    </div>
</div>
@stop

@section('css')
    <!-- Select2 CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <style>
        .form-label.required::after {
            content: ' *';
            color: #dc3545;
        }
        .form-control:disabled, .form-control[readonly] {
            background-color: #f8f9fa;
            opacity: 1;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
        .form-section {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #0d6efd;
        }
        .form-section h5 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #dee2e6;
        }
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .form-check-label {
            cursor: pointer;
        }
        .input-group-text {
            min-width: 120px;
            justify-content: center;
        }
        .was-validated .form-control:invalid, .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        .was-validated .form-select:invalid, .form-select.is-invalid {
            border-color: #dc3545;
            padding-right: 4.125rem;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e"), url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-position: right 0.75rem center, center right 2.25rem;
            background-size: 16px 12px, calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
    </style>
    <style>
        .form-label {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }
        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 0.5rem;
            border-left: 4px solid #007bff;
        }
        .form-section h5 {
            color: #2c3e50;
            font-weight: 600;
        }
        .required-field::after {
            content: ' *';
            color: #dc3545;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }
    </style>
@stop

@section('js')
    <script>
        // Datos de estados, municipios y localidades cargados desde Blade
        const ubicacionesData = @json($estados);
        
        console.log('=== ESTRUCTURA COMPLETA DE DATOS ===');
        console.log('Estados cargados:', ubicacionesData);
        
        if (ubicacionesData.length > 0) {
            const primerEstado = ubicacionesData[0];
            console.log('Primer estado:', primerEstado.nombre_estado);
            console.log('ID del primer estado:', primerEstado.id); // Usar 'id' no 'id_estado'
            
            if (primerEstado.municipio && primerEstado.municipio.length > 0) {
                const primerMunicipio = primerEstado.municipio[0];
                console.log('Primer municipio:', primerMunicipio.nombre_municipio);
                console.log('ID del primer municipio:', primerMunicipio.id); // Usar 'id' no 'id_municipio'
                console.log('¿Tiene localidades?', 'localidades' in primerMunicipio);
                
                if (primerMunicipio.localidades && primerMunicipio.localidades.length > 0) {
                    console.log('Primera localidad:', primerMunicipio.localidades[0]);
                }
            }
        }

        // Funciones para cargar ubicaciones
        function cargarMunicipios(estadoId, municipioSelectId, localidadSelectId) {
            console.log('=== INICIO cargarMunicipios ===');
            console.log('Estado ID recibido:', estadoId);
            console.log('Municipio Select ID:', municipioSelectId);
            
            const municipioSelect = document.getElementById(municipioSelectId);
            const localidadSelect = localidadSelectId ? document.getElementById(localidadSelectId) : null;
            
            // Limpiar los selects
            municipioSelect.innerHTML = '<option value="">Cargando municipios...</option>';
            
            if (localidadSelect) {
                localidadSelect.innerHTML = '<option value="">Seleccione un municipio primero</option>';
            }

            if (!estadoId || estadoId === '') {
                console.log('Estado ID vacío, limpiando selects');
                municipioSelect.innerHTML = '<option value="">Seleccione un estado primero</option>';
                return;
            }

            try {
                console.log('Buscando estado con ID:', estadoId);
                
                // Buscar el estado por ID - usar 'id' (no 'id_estado')
                const estado = ubicacionesData.find(e => e.id == estadoId);
                
                if (!estado) {
                    console.error('No se encontró el estado con ID:', estadoId);
                    municipioSelect.innerHTML = '<option value="">Error: Estado no encontrado</option>';
                    return;
                }
                
                console.log('Estado encontrado:', estado.nombre_estado);
                
                // Usar la propiedad 'municipio' (singular)
                const municipios = estado.municipio || [];
                console.log('Número de municipios encontrados:', municipios.length);
                console.log('Municipios:', municipios);
                
                if (municipios.length > 0) {
                    let options = '<option value="">Seleccione un municipio</option>';
                    
                    municipios.forEach((municipio) => {
                        // Usar 'id' (no 'id_municipio')
                        const id = municipio.id || '';
                        const nombre = municipio.nombre_municipio || municipio.nombre || 'Sin nombre';
                        console.log(`Agregando municipio: ${nombre} (ID: ${id})`);
                        options += `<option value="${id}">${nombre}</option>`;
                    });
                    
                    municipioSelect.innerHTML = options;
                    console.log('Municipios cargados correctamente en', municipioSelectId);
                } else {
                    console.warn('No se encontraron municipios para el estado:', estado.nombre_estado);
                    municipioSelect.innerHTML = '<option value="">No hay municipios disponibles</option>';
                }
            } catch (error) {
                console.error('Error al cargar municipios:', error);
                municipioSelect.innerHTML = '<option value="">Error al cargar municipios</option>';
            }
        }

        function cargarLocalidades(municipioId, localidadSelectId) {
            console.log('=== INICIO cargarLocalidades ===');
            console.log('Municipio ID:', municipioId);
            console.log('Localidad Select ID:', localidadSelectId);
            
            const localidadSelect = document.getElementById(localidadSelectId);
            localidadSelect.innerHTML = '<option value="">Cargando localidades...</option>';

            if (!municipioId) {
                localidadSelect.innerHTML = '<option value="">Seleccione un municipio primero</option>';
                return;
            }

            try {
                let localidadesEncontradas = [];
                
                console.log('Buscando municipio con ID:', municipioId);
                
                // Buscar en todos los estados
                for (const estado of ubicacionesData) {
                    if (!estado.municipio || !Array.isArray(estado.municipio)) {
                        continue;
                    }
                    
                    // Buscar el municipio por ID - usar 'id' (no 'id_municipio')
                    const municipio = estado.municipio.find(m => m.id == municipioId);
                    
                    if (municipio) {
                        console.log('Municipio encontrado:', municipio.nombre_municipio);
                        
                        // Usar 'localidades' (no 'parroquia')
                        if (municipio.localidades && Array.isArray(municipio.localidades)) {
                            localidadesEncontradas = municipio.localidades;
                            console.log('Localidades encontradas:', localidadesEncontradas.length);
                            console.log('Localidades:', localidadesEncontradas);
                        } else {
                            console.log('El municipio no tiene localidades');
                            console.log('Propiedades del municipio:', Object.keys(municipio));
                        }
                        break;
                    }
                }

                if (localidadesEncontradas.length > 0) {
                    let options = '<option value="">Seleccione una localidad</option>';
                    
                    localidadesEncontradas.forEach(localidad => {
                        // Usar 'id' (no 'id_parroquia')
                        const id = localidad.id || '';
                        const nombre = localidad.nombre_localidad || localidad.nombre || 'Sin nombre';
                        console.log(`Agregando localidad: ${nombre} (ID: ${id})`);
                        options += `<option value="${id}">${nombre}</option>`;
                    });
                    
                    localidadSelect.innerHTML = options;
                    console.log('Localidades cargadas correctamente en', localidadSelectId);
                } else {
                    console.warn('No se encontraron localidades para el municipio ID:', municipioId);
                    localidadSelect.innerHTML = '<option value="">No hay localidades disponibles</option>';
                }
            } catch (error) {
                console.error('Error al cargar localidades:', error);
                localidadSelect.innerHTML = '<option value="">Error al cargar localidades</option>';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Eventos para MADRE - con más debug
            document.getElementById('idEstado').addEventListener('change', function() {
                const estadoId = this.value;
                console.log('=== CAMBIO DE ESTADO (madre) ===');
                console.log('Estado seleccionado VALUE:', estadoId);
                console.log('Texto seleccionado:', this.options[this.selectedIndex].text);
                
                if (!estadoId) {
                    console.log('❌ Estado ID está vacío');
                    document.getElementById('idMunicipio').innerHTML = '<option value="">Seleccione un estado primero</option>';
                    document.getElementById('idparroquia').innerHTML = '<option value="">Seleccione un municipio primero</option>';
                    return;
                }
                
                console.log('Estado ID válido:', estadoId);
                cargarMunicipios(estadoId, 'idMunicipio', 'idparroquia');
            });

            document.getElementById('idMunicipio').addEventListener('change', function() {
                const municipioId = this.value;
                console.log('=== CAMBIO DE MUNICIPIO (madre) ===');
                console.log('Municipio seleccionado:', municipioId);
                console.log('Texto seleccionado:', this.options[this.selectedIndex].text);
                
                cargarLocalidades(municipioId, 'idparroquia');
            });

            // Eventos para PADRE
            document.getElementById('idEstado-padre').addEventListener('change', function() {
                const estadoId = this.value;
                console.log('=== CAMBIO DE ESTADO (padre) ===');
                console.log('Estado seleccionado:', estadoId);
                
                cargarMunicipios(estadoId, 'idMunicipio-padre', 'idparroquia-padre');
            });

            document.getElementById('idMunicipio-padre').addEventListener('change', function() {
                const municipioId = this.value;
                console.log('=== CAMBIO DE MUNICIPIO (padre) ===');
                console.log('Municipio seleccionado:', municipioId);
                
                cargarLocalidades(municipioId, 'idparroquia-padre');
            });

            // Eventos para REPRESENTANTE
            document.getElementById('idEstado-representante').addEventListener('change', function() {
                const estadoId = this.value;
                console.log('=== CAMBIO DE ESTADO (representante) ===');
                console.log('Estado seleccionado:', estadoId);
                
                cargarMunicipios(estadoId, 'idMunicipio-representante', 'idparroquia-representante');
            });

            document.getElementById('idMunicipio-representante').addEventListener('change', function() {
                const municipioId = this.value;
                console.log('=== CAMBIO DE MUNICIPIO (representante) ===');
                console.log('Municipio seleccionado:', municipioId);
                
                cargarLocalidades(municipioId, 'idparroquia-representante');
            });

            // Funciones globales para compatibilidad
            window.cargarMunicipiosInputFormulario = cargarMunicipios;
            window.cargarParroquiasInputFormulario = cargarLocalidades;

            // Validación de formulario (solo marca visualmente, no bloquea el envío)
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    const forms = document.getElementsByClassName('needs-validation');
                    Array.prototype.forEach.call(forms, function(form) {
                        form.addEventListener('submit', function() {
                            // Antes de validar, si madre/padre no están presentes, quitar required de sus campos
                            const estadoMadre = document.querySelector('input[name="estado_madre"]:checked');
                            if (estadoMadre && estadoMadre.value !== 'Presente') {
                                const cardMadreBody = document.getElementById('Presente_madre').closest('.card').querySelector('.card-body');
                                const inputs = cardMadreBody.querySelectorAll('input, select, textarea');
                                inputs.forEach(input => input.required = false);
                            }

                            const estadoPadre = document.querySelector('input[name="estado_padre"]:checked');
                            if (estadoPadre && estadoPadre.value !== 'Presente') {
                                const cardPadreBody = document.getElementById('Presente_padre').closest('.card').querySelector('.card-body');
                                const inputs = cardPadreBody.querySelectorAll('input, select, textarea');
                                inputs.forEach(input => input.required = false);
                            }

                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();

            // ================================
            // VALIDACIÓN EN TIEMPO REAL CÉDULAS
            // ================================

            const verificarCedulaUrl = "{{ route('representante.verificar_cedula') }}";
            const buscarCedulaUrl    = "{{ route('representante.buscar_cedula') }}";

            function marcarCedulaError(input, mensaje) {
                input.classList.add('is-invalid');
                const errorId = input.id + '-error';
                let errorElement = document.getElementById(errorId);
                if (!errorElement) {
                    errorElement = document.createElement('small');
                    errorElement.className = 'text-danger';
                    errorElement.id = errorId;
                    input.closest('.form-group, .input-group').after(errorElement);
                }
                errorElement.textContent = mensaje;
            }

            function limpiarCedulaError(input) {
                input.classList.remove('is-invalid');
                const errorId = input.id + '-error';
                const errorElement = document.getElementById(errorId);
                if (errorElement) {
                    errorElement.textContent = '';
                }
            }

            function cedulaSeRepiteEnFormulario(valor, idActual) {
                if (!valor) return false;
                const ids = ['cedula', 'cedula-padre', 'cedula-representante'];
                let contador = 0;
                ids.forEach(function(id) {
                    const campo = document.getElementById(id);
                    if (campo && campo.value === valor) {
                        contador++;
                    }
                });
                return contador > 1;
            }

            function verificarCedulaCampo(selector, personaIdSelector) {
                const input = document.querySelector(selector);
                if (!input) return;

                input.addEventListener('blur', function() {
                    const valor = this.value;
                    limpiarCedulaError(this);
                    if (!valor) return;

                    // Verificar repetición dentro del mismo formulario
                    if (cedulaSeRepiteEnFormulario(valor, this.id)) {
                        marcarCedulaError(this, 'Esta cédula ya se está usando en otro bloque del formulario');
                        return;
                    }

                    // Verificar contra la base de datos
                    const personaId = personaIdSelector ? document.querySelector(personaIdSelector)?.value : '';

                    fetch(`${verificarCedulaUrl}?cedula=${valor}&persona_id=${personaId}`)
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => { throw err; });
                            }
                            return response.json();
                        })
                        .then(resp => {
                            console.log('Cedula OK', selector, resp);
                            limpiarCedulaError(input);
                        })
                        .catch(error => {
                            if (error.message) {
                                marcarCedulaError(input, error.message);
                            } else {
                                console.error('Error al verificar cédula', error);
                            }
                        });
                });
            }

            // Aplicar validación en tiempo real a las tres cédulas principales
            verificarCedulaCampo('#cedula', null); // Madre
            verificarCedulaCampo('#cedula-padre', null); // Padre
            verificarCedulaCampo('#cedula-representante', '#persona-id-representante'); // Representante legal

            // ================================
            // BLOQUEO / DESBLOQUEO DE SECCIONES
            // ================================

            function toggleSeccionPorEstado(nombreEstado, cardBody, excepcionesNames) {
                const radios = document.querySelectorAll(`input[name="${nombreEstado}"]`);
                if (radios.length === 0 || !cardBody) return;

                function aplicarEstado() {
                    const valor = Array.from(radios).find(r => r.checked)?.value;
                    const esPresente = valor === 'Presente';

                    const inputs = cardBody.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        const name = input.name;
                        if (name && excepcionesNames.includes(name)) {
                            return; // no tocar radios de estado
                        }

                        if (esPresente) {
                            // habilitar
                            input.disabled = false;
                            const wasRequired = input.dataset.wasRequired;
                            if (wasRequired === 'true') {
                                input.required = true;
                            }
                        } else {
                            // deshabilitar
                            if (input.required) {
                                input.dataset.wasRequired = 'true';
                            }
                            input.required = false;
                            input.disabled = true;
                        }
                    });
                }

                // Inicialmente, si no hay selección, bloqueamos todo excepto los radios de estado
                if (!Array.from(radios).find(r => r.checked)) {
                    const inputs = cardBody.querySelectorAll('input, select, textarea');
                    inputs.forEach(input => {
                        const name = input.name;
                        if (name && excepcionesNames.includes(name)) {
                            return;
                        }
                        if (input.required) {
                            input.dataset.wasRequired = 'true';
                        }
                        input.required = false;
                        input.disabled = true;
                    });
                } else {
                    aplicarEstado();
                }

                let valorPrevio = Array.from(radios).find(r => r.checked)?.value || null;

                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        const valorNuevo = this.value;
                        if (valorNuevo === 'Ausente') {
                            const confirmado = confirm('Marcar como AUSENTE bloqueará permanentemente la edición de esta sección en este formulario. ¿Desea continuar?');
                            if (!confirmado) {
                                // Volver al valor previo
                                if (valorPrevio) {
                                    radios.forEach(r => r.checked = r.value === valorPrevio);
                                } else {
                                    radios.forEach(r => r.checked = false);
                                }
                                return;
                            }
                        }
                        valorPrevio = valorNuevo;
                        aplicarEstado();
                    });
                });
            }

            // Madre: tomar el card-body de la primera tarjeta (Datos de la Madre)
            const cardMadreBody = document.getElementById('Presente_madre').closest('.card').querySelector('.card-body');
            toggleSeccionPorEstado('estado_madre', cardMadreBody, ['estado_madre']);

            // Refuerzo específico: asegurar bloqueo de ocupación y convive de la madre cuando está Ausente
            function aplicarBloqueoCamposMadre() {
                const estadoMadreVal = document.querySelector('input[name="estado_madre"]:checked')?.value;
                const esPresenteMadre = estadoMadreVal === 'Presente';

                const ocupacionMadre = document.getElementById('ocupacion-madre');
                const otraOcupacionMadre = document.getElementById('otra-ocupacion');
                const conviveSiMadre = document.getElementById('convive-si');
                const conviveNoMadre = document.getElementById('convive-no');

                if (esPresenteMadre) {
                    if (ocupacionMadre) {
                        ocupacionMadre.disabled = false;
                        ocupacionMadre.required = true;
                    }
                    // "Otra ocupación" solo requerida si el contenedor está visible
                    const otraOcupacionContainer = document.getElementById('otra-ocupacion-container');
                    if (otraOcupacionMadre && otraOcupacionContainer) {
                        otraOcupacionMadre.disabled = !otraOcupacionContainer.style.display || otraOcupacionContainer.style.display !== 'none';
                        otraOcupacionMadre.required = !otraOcupacionContainer.style.display || otraOcupacionContainer.style.display !== 'none';
                    }
                    if (conviveSiMadre) conviveSiMadre.disabled = false;
                    if (conviveNoMadre) conviveNoMadre.disabled = false;
                } else {
                    // Ausente u otro estado: bloquear relación familiar de la madre
                    if (ocupacionMadre) {
                        ocupacionMadre.disabled = true;
                        ocupacionMadre.required = false;
                    }
                    if (otraOcupacionMadre) {
                        otraOcupacionMadre.disabled = true;
                        otraOcupacionMadre.required = false;
                    }
                    if (conviveSiMadre) conviveSiMadre.disabled = true;
                    if (conviveNoMadre) conviveNoMadre.disabled = true;
                }
            }

            // Aplicar una vez al cargar y cada vez que cambie el estado de la madre
            aplicarBloqueoCamposMadre();
            document.querySelectorAll('input[name="estado_madre"]').forEach(radio => {
                radio.addEventListener('change', aplicarBloqueoCamposMadre);
            });

            // Padre: card-body de la tarjeta de Datos del Padre
            const cardPadreBody = document.getElementById('Presente_padre').closest('.card').querySelector('.card-body');
            toggleSeccionPorEstado('estado_padre', cardPadreBody, ['estado_padre']);

            // ================================
            // REPRESENTANTE LEGAL COMO PROGENITOR
            // ================================

            function rellenarRepresentanteDesdeRespuesta(resp) {
                if (!resp || !resp.data || !resp.data.persona) return;

                const persona = resp.data.persona;
                const representante = resp.data;
                const legal = resp.data.legal || {};

                document.getElementById('persona-id-representante').value = persona.id || '';
                document.getElementById('representante-id').value = representante.id || '';

                document.getElementById('primer-nombre-representante').value = persona.primer_nombre || '';
                document.getElementById('segundo-nombre-representante').value = persona.segundo_nombre || '';
                document.getElementById('tercer-nombre-representante').value = persona.tercer_nombre || '';
                document.getElementById('primer-apellido-representante').value = persona.primer_apellido || '';
                document.getElementById('segundo-apellido-representante').value = persona.segundo_apellido || '';
                document.getElementById('fechaNacimiento-representante').value = persona.fecha_nacimiento || '';
                
                const sexoRepresentante = document.getElementById('sexo-representante');
                if (sexoRepresentante) {
                    sexoRepresentante.value = persona.genero_id || '';
                }

                // Otros campos opcionales si existen
                const telefonoRepresentante = document.getElementById('telefono-representante');
                const lugarNacimientoRepresentante = document.getElementById('lugar-nacimiento-representante');
                if (telefonoRepresentante) telefonoRepresentante.value = persona.telefono || '';
                if (lugarNacimientoRepresentante) lugarNacimientoRepresentante.value = persona.direccion || '';

                // Correo: preferir el correo del representante legal, si no, el email de la persona
                const correo = legal.correo_representante || persona.email || '';
                document.getElementById('correo-representante').value = correo;
            }

function copiarDesdeMadreOPadreSiCoincide(cedula) {
    if (!cedula) return false;

    // Función para copiar ubicación
    const copiarUbicacion = (prefijoOrigen, prefijoDestino) => {
        const estado = document.getElementById(`${prefijoOrigen}Estado`).value;
        const municipio = document.getElementById(`${prefijoOrigen}Municipio`).value;
        const parroquia = document.getElementById(`id${prefijoOrigen === '' ? 'parroquia' : 'parroquia-padre'}`).value;
        
        if (estado) {
            document.getElementById('idEstado-representante').value = estado;
            cargarMunicipios(estado, 'idMunicipio-representante', 'idparroquia-representante');
            
            if (municipio) {
                setTimeout(() => {
                    document.getElementById('idMunicipio-representante').value = municipio;
                    cargarLocalidades(municipio, 'idparroquia-representante');
                    
                    if (parroquia) {
                        setTimeout(() => {
                            document.getElementById('idparroquia-representante').value = parroquia;
                        }, 100);
                    }
                }, 100);
            }
        }
    };

    // Función para copiar teléfono y prefijo
    const copiarTelefonoYPrefijo = (prefijoOrigen) => {
        const telefono = document.getElementById(`${prefijoOrigen}telefono`).value;
        const prefijo = document.getElementById(`${prefijoOrigen}prefijo`).value;
        
        if (telefono) document.getElementById('telefono-representante').value = telefono;
        if (prefijo) document.getElementById('prefijo-representante').value = prefijo;
    };

    // Función para copiar lugar de nacimiento
    const copiarLugarNacimiento = (prefijoOrigen) => {
        const lugarNacimiento = document.getElementById(`lugar-nacimiento${prefijoOrigen}`).value;
        if (lugarNacimiento) {
            document.getElementById('lugar-nacimiento-representante').value = lugarNacimiento;
        }
    };

    // Función para copiar ocupación
    const copiarOcupacion = (prefijoOrigen) => {
        const ocupacion = document.getElementById(`ocupacion-${prefijoOrigen}`).value;
        const ocupacionRepresentante = document.getElementById('ocupacion-representante');
        if (ocupacion && ocupacionRepresentante) {
            ocupacionRepresentante.value = ocupacion;
        }
    };

    // Función para copiar convivencia
    const copiarConvivencia = (prefijoOrigen) => {
        const convive = document.querySelector(`input[name="convive${prefijoOrigen}"]:checked`);
        const conviveSiRepresentante = document.querySelector('input[name="convive-representante"][value="si"]');
        const conviveNoRepresentante = document.querySelector('input[name="convive-representante"][value="no"]');
        
        if (convive) {
            if (convive.value === 'si' || convive.value === '1') {
                conviveSiRepresentante.checked = true;
            } else if (convive.value === 'no' || convive.value === '0') {
                conviveNoRepresentante.checked = true;
            }
        }
    };

    // MADRE
    const cedulaMadre = document.getElementById('cedula');
    if (cedulaMadre && cedulaMadre.value === cedula) {
        // Copiar datos personales
        document.getElementById('primer-nombre-representante').value = document.getElementById('primer-nombre').value || '';
        document.getElementById('segundo-nombre-representante').value = document.getElementById('segundo-nombre').value || '';
        document.getElementById('tercer-nombre-representante').value = document.getElementById('tercer-nombre').value || '';
        document.getElementById('primer-apellido-representante').value = document.getElementById('primer-apellido').value || '';
        document.getElementById('segundo-apellido-representante').value = document.getElementById('segundo-apellido').value || '';
        document.getElementById('fechaNacimiento-representante').value = document.getElementById('fechaNacimiento').value || '';
        
        const sexoRepresentante = document.getElementById('sexo-representante');
        const sexoMadre = document.getElementById('sexo');
        if (sexoRepresentante && sexoMadre) sexoRepresentante.value = sexoMadre.value;
        
        // Copiar datos adicionales
        copiarLugarNacimiento('');
        copiarTelefonoYPrefijo('');
        copiarUbicacion('', '');
        copiarOcupacion('madre');
        copiarConvivencia('');

        return true;
    }

    // PADRE
    const cedulaPadre = document.getElementById('cedula-padre');
    if (cedulaPadre && cedulaPadre.value === cedula) {
        // Copiar datos personales
        document.getElementById('primer-nombre-representante').value = document.getElementById('primer-nombre-padre').value || '';
        document.getElementById('segundo-nombre-representante').value = document.getElementById('segundo-nombre-padre').value || '';
        document.getElementById('tercer-nombre-representante').value = document.getElementById('tercer-nombre-padre')?.value || '';
        document.getElementById('primer-apellido-representante').value = document.getElementById('primer-apellido-padre').value || '';
        document.getElementById('segundo-apellido-representante').value = document.getElementById('segundo-apellido-padre')?.value || '';
        document.getElementById('fechaNacimiento-representante').value = document.getElementById('fechaNacimiento-padre').value || '';
        
        const sexoRepresentante = document.getElementById('sexo-representante');
        const generoPadre = document.getElementById('genero-padre');
        if (sexoRepresentante && generoPadre) sexoRepresentante.value = generoPadre.value;
        
        // Copiar datos adicionales
        copiarLugarNacimiento('-padre');
        copiarTelefonoYPrefijo('padre-');
        copiarUbicacion('padre-', 'padre-');
        copiarOcupacion('padre');
        copiarConvivencia('-padre');

        return true;
    }

    return false;
}3

            // Función para mostrar/ocultar el campo de organización
            function toggleOrganizacion() {
                const mostrar = document.querySelector('input[name="pertenece-organizacion"]:checked')?.value === 'si';
                const campoOrganizacion = document.getElementById('campo_organizacion');
                const inputOrganizacion = document.getElementById('cual-organizacion');
                
                if (campoOrganizacion) {
                    campoOrganizacion.style.display = mostrar ? 'block' : 'none';
                }
                if (inputOrganizacion) {
                    inputOrganizacion.required = mostrar;
                    if (!mostrar) {
                        inputOrganizacion.value = '';
                    }
                }
            }

            // Manejar cambios en la opción de pertenencia a organización
            document.querySelectorAll('input[name="pertenece-organizacion"]').forEach(radio => {
                radio.addEventListener('change', toggleOrganizacion);
            });
            toggleOrganizacion(); // Estado inicial

            // Estado inicial: bloquear completamente el bloque de representante legal
            const seccionRep = document.getElementById('datos-representante');
            if (seccionRep) {
                seccionRep.style.display = 'none';
                const inputs = seccionRep.querySelectorAll('input, select, textarea');
                inputs.forEach(input => input.disabled = true);
            }

            document.querySelectorAll('input[name="tipo_representante"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const tipo = this.value;
                    const seccionRep = document.getElementById('datos-representante');

                    if (!tipo) {
                        // Sin selección: ocultar y bloquear todo
                        if (seccionRep) {
                            seccionRep.style.display = 'none';
                            const inputs = seccionRep.querySelectorAll('input, select, textarea');
                            inputs.forEach(input => input.disabled = true);
                        }
                        return;
                    }

                    // Mostrar la sección y habilitar campos
                    if (seccionRep) {
                        seccionRep.style.display = 'block';
                        const inputs = seccionRep.querySelectorAll('input, select, textarea');
                        inputs.forEach(input => input.disabled = false);
                    }

                    // Si es progenitor_representante, intentar copiar datos del padre/madre
                    if (tipo === 'progenitor_representante') {
                        // Determinar si el padre o la madre está presente
                        const padrePresente = document.querySelector('input[name="estado_padre"]:checked')?.value === 'Presente';
                        const madrePresente = document.querySelector('input[name="estado_madre"]:checked')?.value === 'Presente';
                        
                        // Obtener los valores de los campos de cédula
                        const cedulaPadre = document.getElementById('cedula-padre')?.value;
                        const cedulaMadre = document.getElementById('cedula')?.value;
                        
                        // Obtener los valores de los campos de correo
                        const correoPadre = document.getElementById('email-padre')?.value;
                        const correoMadre = document.getElementById('email')?.value;
                        
                        // Obtener los tipos de documento
                        const tipoDocPadre = document.getElementById('tipo-ci-padre')?.value;
                        const tipoDocMadre = document.getElementById('tipo-ci')?.value;
                        
                        // Si el padre está presente, copiar sus datos
                        if (padrePresente && cedulaPadre) {
                            document.getElementById('cedula-representante').value = cedulaPadre;
                            const tipoCiRepresentante = document.getElementById('tipo-ci-representante');
                            if (tipoCiRepresentante && tipoDocPadre) {
                                tipoCiRepresentante.value = tipoDocPadre;
                            }
                            const correoRepresentante = document.getElementById('correo-representante');
                            if (correoRepresentante && correoPadre) {
                                correoRepresentante.value = correoPadre;
                            }
                            console.log('Datos copiados del padre:', { cedula: cedulaPadre, correo: correoPadre });
                        } 
                        // Si la madre está presente, copiar sus datos
                        else if (madrePresente && cedulaMadre) {
                            document.getElementById('cedula-representante').value = cedulaMadre;
                            const tipoCiRepresentante = document.getElementById('tipo-ci-representante');
                            if (tipoCiRepresentante && tipoDocMadre) {
                                tipoCiRepresentante.value = tipoDocMadre;
                            }
                            const correoRepresentante = document.getElementById('correo-representante');
                            if (correoRepresentante && correoMadre) {
                                correoRepresentante.value = correoMadre;
                            }
                            console.log('Datos copiados de la madre:', { cedula: cedulaMadre, correo: correoMadre });
                        }
                        
                        // Forzar el evento blur en la cédula para buscar datos adicionales
                        const cedulaRepresentante = document.getElementById('cedula-representante');
                        if (cedulaRepresentante && cedulaRepresentante.value) {
                            cedulaRepresentante.dispatchEvent(new Event('blur'));
                        }
                    }
                });
            });

            // Al salir de la cédula del representante, si el tipo es progenitor_representante,
            // primero intentamos copiar desde madre/padre; si no coincide, buscamos en BD
            document.getElementById('cedula-representante')?.addEventListener('blur', function() {
                const tipo = document.querySelector('input[name="tipo_representante"]:checked')?.value;
                const cedula = this.value;

                if (tipo !== 'progenitor_representante' || !cedula) {
                    return;
                }

                // 1) Intentar copiar desde los datos ya cargados en este formulario (madre/padre)
                const copiadoLocal = copiarDesdeMadreOPadreSiCoincide(cedula);
                if (copiadoLocal) {
                    return; // no hace falta ir a BD
                }

                // 2) Si no coincide con madre/padre, buscar en BD
                fetch(`${buscarCedulaUrl}?cedula=${cedula}`)
                    .then(response => response.json())
                    .then(resp => {
                        if (resp && resp.status === 'success') {
                            rellenarRepresentanteDesdeRespuesta(resp);
                        }
                    })
                    .catch(error => {
                        console.error('Error al buscar cédula para representante legal como progenitor', error);
                    });
            });

            // Otras funciones
            document.querySelectorAll('input[name*="telefono"]').forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            });

            document.querySelectorAll('input[name*="cedula"]').forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '').substring(0, 8);
                });
            });
        });
    </script>
@stop