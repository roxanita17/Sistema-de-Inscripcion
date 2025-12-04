
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

            <form id="representante-form" action="{{ route('representante.save') }}" method="POST" class="needs-validation">
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
                                    <option value="{{ $tipoDoc->id }}">{{ $tipoDoc->nombre}}</option>
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
                            <label for="numero_documento" class="form-label required">Número de Cédula</label>
                            <input type="text" class="form-control" id="numero_documento" name="numero_documento" 
                                maxlength="8" pattern="\d{6,8}" 
                                title="Ingrese solo números (entre 6 y 8 dígitos)" required
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
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
                                <option value="{{ $tipoDoc->id }}">{{ $tipoDoc->nombre }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione el tipo de documento.
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="numero_documento-padre" class="form-label required">Número de Cédula</label>
                        <input type="text" class="form-control" id="numero_documento-padre" name="numero_documento-padre" 
                            maxlength="8" required>
                        <div class="invalid-feedback">
                            Por favor ingrese un número de cédula válido (solo números).
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="fecha-nacimiento-padre" class="form-label required">Fecha de Nacimiento</label>
                        <input type="date" id="fecha-nacimiento-padre" name="fecha-nacimiento-padre" 
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
                            <label for="tercer-nombre-padre" class="form-label">Tercer Nombre</label>
                            <input type="text" class="form-control" id="tercer-nombre-padre" name="tercer-nombre-padre"
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
                        <label for="sexo-padre" class="form-label required">Género</label>
                        <select class="form-select" id="sexo-padre" name="sexo-padre" required>
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
        <div class="border rounded p-4 mb-4 bg-light">
            <h5 class="mb-4 pb-2 border-bottom">
                <i class="fas fa-address-book me-2"></i>Dirección y Contactos
            </h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label for="lugar-nacimiento-padre" class="form-label">Lugar de Nacimiento *</label>
                        <input type="text" class="form-control" id="lugar-nacimiento-padre" name="lugar-nacimiento-padre">
                    </div>
                </div>  
            </div>
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
        </div>  
        <!-- Sección de Dirección y Contactos -->
        <div class="border rounded p-4 mb-4 bg-light">
            <h5 class="mb-4 pb-2 border-bottom">
                <i class="fas fa-address-book me-2"></i>Dirección y Contactos
            </h5>
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
                                <option value="{{ $tipoDoc->id }}">{{ $tipoDoc->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <small id="tipo-ci-representante-error" class="text-danger"></small>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text" id="inputGroup-sizing-default"><span class="text-danger">(*)</span>Cédula</span>
                        <input type="text" class="form-control" id="numero_documento-representante" name="numero_documento-representante" 
                            aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" 
                            maxlength="8" required>
                    </div>
                    <input type="hidden" id="persona-id-representante" name="persona-id-representante">
                    <input type="hidden" id="representante-id" name="representante-id">
                    <small id="numero_documento-representante-error" class="text-danger"></small>
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
                    <div class="col-md-4 mb-3">
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroup-sizing-default">Tercer Nombre</span>
                            <input type="text" class="form-control" id="tercer-nombre-representante" name="tercer-nombre-representante"
                                aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios,no se aceptan números">
                        </div>
                        <small id="tercer-nombre-representante-error" class="text-danger"></small>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="input-group">
                            <label class="input-group-text" for="sexo-representante"><span class="text-danger">(*)</span>Género</label>
                            <select class="form-select" id="sexo-representante" name="sexo-representante" required>
                                <option value="">Seleccione</option>
                                @foreach($generos as $genero)
                                    <option value="{{ $genero->id }}">{{ $genero->genero }}</option>
                                @endforeach
                            </select>
                        </div>
                        <small id="sexo-representante-error" class="text-danger"></small>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="input-group">
                            <span class="input-group-text"><span class="text-danger">(*)</span>Fecha Nac.</span>
                            <input type="date" class="form-control" id="fecha-nacimiento-representante" name="fecha-nacimiento-representante" 
                                aria-label="Fecha de Nacimiento" required>
                        </div>
                        <small id="fecha-nacimiento-representante-error" class="text-danger"></small>
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

            <!-- Sección de Relación Familiar con el Estudiante -->
            <div class="border rounded p-4 mb-4 bg-light">
                <h5 class="mb-4 pb-2 border-bottom">
                    <i class="fas fa-users me-2"></i>Relación Familiar con el Estudiante
                </h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="ocupacion-representante" class="form-label required">Ocupación</label>
                            <select name="ocupacion-representante" id="ocupacion-representante" class="form-select" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                @foreach($ocupaciones as $ocupacion)
                                    <option value="{{ $ocupacion->id }}">{{ $ocupacion->nombre_ocupacion }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Por favor seleccione una ocupación.
                            </div>
                            <small id="ocupacion-representante-error" class="text-danger"></small>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <div class="form-group" id="otra-ocupacion-container" style="display:none">
                            <label for="otra-ocupacion-representante" class="form-label required">Especifique la ocupación</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                <input type="text" class="form-control" id="otra-ocupacion-representante" 
                                    name="otra-ocupacion-representante" maxlength="50"
                                    title="Solo se permiten letras y espacios, no se aceptan números"
                                    pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                            </div>
                            <div class="invalid-feedback">
                                Por favor ingrese una ocupación válida (solo letras y espacios).
                            </div>
                            <small id="otra-ocupacion-error-representante" class="text-danger"></small>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="form-label d-block required">¿Convive con el Estudiante?</label>
                            <div class="d-flex mt-1">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" id="convive-si-representante" 
                                        name="convive-representante" value="si" required>
                                    <label class="form-check-label" for="convive-si-representante">Sí</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="convive-no-representante" 
                                        name="convive-representante" value="no" required>
                                    <label class="form-check-label" for="convive-no-representante">No</label>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                Por favor indique si convive con el estudiante.
                            </div>
                            <small id="convive-representante-error" class="text-danger"></small>
                        </div>
                    </div>
                </div>

                <!-- Sección de Conectividad y Participación Ciudadana -->
                <div class="border rounded p-4 mb-4 bg-light">
                    <h5 class="mb-4 pb-2 border-bottom">
                        <i class="fas fa-wifi me-2"></i>Conectividad y Participación Ciudadana
                    </h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="correo-representante" class="form-label">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="correo-representante" 
                                        name="correo-representante" maxlength="254" 
                                        title="No olvide incluir el símbolo @ en la dirección de correo"
                                        placeholder="ejemplo@correo.com">
                                </div>
                                <small id="correo-representante-error" class="text-danger"></small>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label class="form-label d-block">
                                    <span class="text-danger">(*)</span> ¿Pertenece a alguna Organización Política o Comunitaria?
                                </label>
                                <div class="d-flex mt-1">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio"
                                            id="opcion_si" name="pertenece-organizacion" value="si">
                                        <label class="form-check-label" for="opcion_si">
                                            Sí
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            id="opcion_no" name="pertenece-organizacion" value="no" checked>
                                        <label class="form-check-label" for="opcion_no">
                                            No
                                        </label>
                                    </div>
                                </div>
                                <small id="pertenece-organizacion-error" class="text-danger"></small>
                            </div>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <div id="campo_organizacion" class="form-group" style="display: none">
                                <label for="cual-organizacion" class="form-label">
                                    <span class="text-danger">(*)</span> Especifique la organización
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-sitemap"></i></span>
                                    <input type="text" class="form-control" id="cual-organizacion" 
                                        name="cual-organizacion" maxlength="50"
                                        title="Ingrese el nombre de la organización (solo letras y espacios)"
                                        pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+">
                                </div>
                                <small id="cual-organizacion-error" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección de Identificación Familiar y Datos de Cuenta -->
                <div class="border rounded p-4 mb-4 bg-light">
                    <h5 class="mb-4 pb-2 border-bottom">
                        <i class="fas fa-id-card me-2"></i>Identificación Familiar y Datos de Cuenta
                    </h5>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="parentesco" class="form-label required">Parentesco</label>
                                <select class="form-select" id="parentesco" name="parentesco" required>
                                    <option value="" disabled selected>Seleccione</option>
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
                                <div class="invalid-feedback">
                                    Por favor seleccione un parentesco.
                                </div>
                                <small id="parentesco-error" class="text-danger"></small>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="carnet-patria" class="form-label">Carnet de la Patria Afiliado a</label>
                                <select class="form-select" id="carnet-patria" name="carnet-patria">
                                    <option value="" selected>Seleccione</option>
                                    <option value="1">Padre</option>
                                    <option value="2">Madre</option>
                                </select>
                                <small id="carnet-patria-error" class="text-danger"></small>
                            </div>
                        </div> 
                        
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="codigo" class="form-label required">Código</label>
                                <input type="text" class="form-control" id="codigo" name="codigo"
                                    maxlength="10" pattern="[0-9]+" 
                                    title="Ingrese solo números (máximo 10 dígitos)" required
                                    inputmode="numeric" 
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                <div class="invalid-feedback">
                                    Por favor ingrese un código válido (solo números).
                                </div>
                                <small id="codigo-error" class="text-danger"></small>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="serial" class="form-label required">Serial</label>
                                <input type="text" class="form-control" id="serial" name="serial"
                                    maxlength="9" pattern="[0-9]+" 
                                    title="Ingrese solo números (máximo 9 dígitos)" required
                                     inputmode="numeric" 
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                <div class="invalid-feedback">
                                    Por favor ingrese un serial válido (solo números).
                                </div>
                                <small id="serial-error" class="text-danger"></small>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="tipo-cuenta" class="form-label required">Tipo de Cuenta</label>
                                <select class="form-select" id="tipo-cuenta" name="tipo-cuenta" required>
                                    <option value="" disabled selected>Seleccione</option>
                                    <option value="1">Corriente</option>
                                    <option value="2">Ahorro</option>
                                </select>
                                <div class="invalid-feedback">
                                    Por favor seleccione un tipo de cuenta.
                                </div>
                                <small id="tipo-cuenta-error" class="text-danger"></small>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="banco-representante" class="form-label required">Banco</label>
                                <select class="form-select" id="banco-representante" name="banco-representante" required>
                                    <option value="" disabled selected>Seleccione</option>
                                    @foreach ($bancos as $banco)
                                        <option value="{{ $banco->id }}">{{ $banco->nombre_banco }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Por favor seleccione un banco.
                                </div>
                                <small id="banco-representante-error" class="text-danger"></small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Sección de Dirección de Habitación -->
                <div class="border rounded p-4 mb-4 bg-light">
                    <h5 class="mb-4 pb-2 border-bottom">
                        <i class="fas fa-home me-2"></i>Dirección de Habitación
                    </h5>
                    <div class="form-group">
                        <label for="direccion-habitacion" class="form-label required">Dirección Completa</label>
                        <textarea class="form-control" id="direccion-habitacion" name="direccion-habitacion" 
                            rows="3" maxlength="200" 
                            placeholder="Ej: Barrio Araguaney, Avenida 5 entre calles 8 y 9, Casa #12-34" 
                            title="Ingrese su dirección completa incluyendo puntos de referencia"
                            required></textarea>
                        <div class="invalid-feedback">
                            Por favor ingrese una dirección válida.
                        </div>
                        <small id="direccion-habitacion-error" class="text-danger"></small>
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
                </div>
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

        // Función para cargar municipios del representante
        window.cargarMunicipiosRepresentante = function(estadoId) {
            console.log('=== INICIO cargarMunicipiosRepresentante ===');
            console.log('Estado ID recibido:', estadoId);
            
            const municipioSelect = document.getElementById('idMunicipio-representante');
            const parroquiaSelect = document.getElementById('idparroquia-representante');
            
            if (!municipioSelect) {
                console.error('No se encontró el select de municipio del representante');
                return;
            }

            // Limpiar selects
            municipioSelect.innerHTML = '<option value="">Cargando municipios...</option>';
            if (parroquiaSelect) {
                parroquiaSelect.innerHTML = '<option value="">Seleccione un municipio primero</option>';
            }

            if (!estadoId) {
                municipioSelect.innerHTML = '<option value="">Seleccione un estado</option>';
                return;
            }

            try {
                // Buscar el estado en los datos cargados
                const estado = ubicacionesData.find(e => e.id == estadoId);
                
                if (!estado) {
                    console.error('No se encontró el estado con ID:', estadoId);
                    municipioSelect.innerHTML = '<option value="">Error: Estado no encontrado</option>';
                    return;
                }

                // Usar la propiedad 'municipio' (singular) según la estructura de datos
                const municipios = estado.municipio || [];
                console.log(`Encontrados ${municipios.length} municipios para el estado ${estadoId}`);
                
                if (municipios.length > 0) {
                    let options = '<option value="">Seleccione un municipio</option>';
                    
                    municipios.forEach(municipio => {
                        const nombre = municipio.nombre_municipio || municipio.nombre || 'Municipio sin nombre';
                        options += `<option value="${municipio.id}">${nombre}</option>`;
                    });
                    
                    municipioSelect.innerHTML = options;
                } else {
                    municipioSelect.innerHTML = '<option value="">No hay municipios disponibles</option>';
                }
            } catch (error) {
                console.error('Error al cargar municipios:', error);
                municipioSelect.innerHTML = '<option value="">Error al cargar municipios</option>';
            }
            
            console.log('=== FIN cargarMunicipiosRepresentante ===');
        };

        // Función para cargar parroquias del representante
        window.cargarParroquiasRepresentante = function(municipioId) {
            console.log('=== INICIO cargarParroquiasRepresentante ===');
            console.log('Municipio ID:', municipioId);
            
            const selectParroquia = document.getElementById('idparroquia-representante');
            if (!selectParroquia) {
                console.error('No se encontró el select de parroquia del representante');
                return;
            }

            // Limpiar opciones existentes
            selectParroquia.innerHTML = '<option value="">Seleccione</option>';
            
            if (!municipioId) {
                console.log('No se proporcionó ID de municipio');
                return;
            }

            // Buscar el municipio seleccionado en los datos cargados
            let municipioEncontrado = null;
            
            // Buscar en todos los estados
            for (const estado of ubicacionesData) {
                // Verificar si el estado tiene la propiedad 'municipio' (singular)
                if (estado.municipio) {
                    municipioEncontrado = estado.municipio.find(m => m.id == municipioId);
                    if (municipioEncontrado) break;
                }
            }

            if (municipioEncontrado && municipioEncontrado.localidades) {
                console.log(`Encontradas ${municipioEncontrado.localidades.length} parroquias para el municipio ${municipioId}`);
                
                // Agregar opciones de parroquias
                municipioEncontrado.localidades.forEach(parroquia => {
                    const option = document.createElement('option');
                    option.value = parroquia.id;
                    option.textContent = parroquia.nombre_parroquia || parroquia.nombre;
                    selectParroquia.appendChild(option);
                });
            } else {
                console.log('No se encontraron parroquias para el municipio', municipioId);
            }
            
            console.log('=== FIN cargarParroquiasRepresentante ===');
        };

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

            const verificarnumero_documentoUrl = "{{ route('representante.verificar_numero_documento') }}";
            const buscarnumero_documentoUrl    = "{{ route('representante.buscar_numero_documento') }}";

            function marcarnumero_documentoError(input, mensaje) {
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

            function limpiarnumero_documentoError(input) {
                input.classList.remove('is-invalid');
                const errorId = input.id + '-error';
                const errorElement = document.getElementById(errorId);
                if (errorElement) {
                    errorElement.textContent = '';
                }
            }

            function numero_documentoSeRepiteEnFormulario(valor, idActual) {
                if (!valor) return false;
                
                // Si es el campo de cédula del representante y está seleccionado "Progenitor como Representante", no marcar como duplicado
                if (idActual === 'numero_documento-representante') {
                    const progenitorRep = document.querySelector('input[name="tipo_representante"][value="progenitor_representante"]:checked');
                    if (progenitorRep) {
                        return false; // No marcar como duplicado si es progenitor representante
                    }
                }

                const ids = ['numero_documento', 'numero_documento-padre', 'numero_documento-representante'];
                let contador = 0;

                ids.forEach(id => {
                    // No comparar consigo mismo
                    if (id === idActual) return;
                    
                    const campo = document.getElementById(id);
                    if (campo && campo.value && campo.value === valor) {
                        // Si es el campo de cédula del representante y está seleccionado "Progenitor como Representante", no contar como duplicado
                        if (id === 'numero_documento-representante') {
                            const progenitorRep = document.querySelector('input[name="tipo_representante"][value="progenitor_representante"]:checked');
                            if (progenitorRep) {
                                return; // No contar este campo si es progenitor representante
                            }
                        }
                        contador++;
                    }
                });

                return contador > 0; // Cambiado a > 0 para marcar como duplicado si se encuentra en cualquier otro campo
            }

            function verificarnumero_documentoCampo(selector, personaIdSelector) {
                const input = document.querySelector(selector);
                if (!input) return;

                input.addEventListener('blur', function() {
                    const valor = this.value.trim();
                    limpiarnumero_documentoError(this);
                    if (!valor) return;

                    // Verificar si es el campo de cédula del representante y está seleccionado "Progenitor como Representante"
                    const esProgenitorRepresentante = document.querySelector('input[name="tipo_representante"][value="progenitor_representante"]:checked') !== null;
                    
                    if (this.id === 'numero_documento-representante' && esProgenitorRepresentante) {
                        // No validar cédula duplicada si es progenitor representante
                        limpiarnumero_documentoError(this);
                        return;
                    }

                    // Verificar repetición dentro del mismo formulario
                    if (numero_documentoSeRepiteEnFormulario(valor, this.id)) {
                        marcarnumero_documentoError(this, 'Esta cédula ya se está usando en otro bloque del formulario');
                        return;
                    }

                    // Verificar contra la base de datos
                    const personaId = personaIdSelector ? document.querySelector(personaIdSelector)?.value : '';

                    fetch(`${verificarnumero_documentoUrl}?numero_documento=${valor}&persona_id=${personaId}`)
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => { throw err; });
                            }
                            return response.json();
                        })
                        .then(resp => {
                            console.log('numero_documento OK', selector, resp);
                            limpiarnumero_documentoError(input);
                        })
                        .catch(error => {
                            if (error.message) {
                                marcarnumero_documentoError(input, error.message);
                            } else {
                                console.error('Error al verificar cédula', error);
                            }
                        });
                });
            }

            // Aplicar validación en tiempo real a las tres cédulas principales
            verificarnumero_documentoCampo('#numero_documento', null); // Madre
            verificarnumero_documentoCampo('#numero_documento-padre', null); // Padre
            verificarnumero_documentoCampo('#numero_documento-representante', '#persona-id-representante'); // Representante legal

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

// Función segura para obtener un elemento por ID
const getElement = (id) => document.getElementById(id);

// Función segura para establecer un valor en un elemento
const setValue = (id, value) => {
    const element = getElement(id);
    if (element) element.value = value || '';
};

// Función para establecer valores en selects dependientes
function setSelectValue(selectId, value, callback) {
    const select = document.getElementById(selectId);
    if (!select) return;
    
    select.value = value;
    if (select.value === value) {
        // Disparar evento change para actualizar selects dependientes
        select.dispatchEvent(new Event('change'));
        if (callback) callback();
    } else {
        // Si el valor no se establece de inmediato, esperar un momento y volver a intentar
        setTimeout(() => {
            setSelectValue(selectId, value, callback);
        }, 100);
    }
}

function copiarDesdeMadreOPadreSiCoincide(numero_documento) {
    if (!numero_documento || !numero_documento.trim()) return false;
    
    // Limpiar errores previos
    const errorElement = getElement('error-copia-datos');
    if (errorElement) errorElement.remove();

    // Función para copiar ubicación
    const copiarUbicacion = (prefijoOrigen, prefijoDestino) => {
        try {
            const estadoEl = getElement(`${prefijoOrigen}Estado`);
            const municipioEl = getElement(`${prefijoOrigen}Municipio`);
            const parroquiaEl = getElement(`id${prefijoOrigen === '' ? 'parroquia' : 'parroquia-padre'}`);
            
            if (estadoEl && estadoEl.value) {
                const estado = estadoEl.value;
                setValue('idEstado-representante', estado);
                
                // Cargar municipios y manejar la carga asíncrona
                if (typeof cargarMunicipios === 'function') {
                    cargarMunicipios(estado, 'idMunicipio-representante', 'idparroquia-representante');
                    
                    if (municipioEl && municipioEl.value) {
                        const municipio = municipioEl.value;
                        setTimeout(() => {
                            setValue('idMunicipio-representante', municipio);
                            
                            if (typeof cargarLocalidades === 'function') {
                                cargarLocalidades(municipio, 'idparroquia-representante');
                                
                                if (parroquiaEl && parroquiaEl.value) {
                                    setTimeout(() => {
                                        setValue('idparroquia-representante', parroquiaEl.value);
                                    }, 100);
                                }
                            }
                        }, 100);
                    }
                }
            }
        } catch (error) {
            console.error('Error al copiar ubicación:', error);
        }
    };

    // Función para copiar teléfono y prefijo
    const copiarTelefonoYPrefijo = (prefijoOrigen) => {
        try {
            const telefonoEl = getElement(`${prefijoOrigen}telefono`);
            const prefijoEl = getElement(`${prefijoOrigen}prefijo`);
            
            if (telefonoEl && telefonoEl.value) setValue('telefono-representante', telefonoEl.value);
            if (prefijoEl && prefijoEl.value) setValue('prefijo-representante', prefijoEl.value);
        } catch (error) {
            console.error('Error al copiar teléfono y prefijo:', error);
        }
    };

    // Función para copiar lugar de nacimiento
    const copiarLugarNacimiento = (prefijoOrigen) => {
        try {
            const lugarNacimientoEl = getElement(`lugar-nacimiento${prefijoOrigen}`);
            if (lugarNacimientoEl && lugarNacimientoEl.value) {
                setValue('lugar-nacimiento-representante', lugarNacimientoEl.value);
            }
        } catch (error) {
            console.error('Error al copiar lugar de nacimiento:', error);
        }
    };

    // Función para copiar ocupación
    const copiarOcupacion = (prefijoOrigen) => {
        try {
            const ocupacionEl = getElement(`ocupacion-${prefijoOrigen}`);
            const ocupacionRepresentanteEl = getElement('ocupacion-representante');
            
            if (ocupacionEl && ocupacionEl.value && ocupacionRepresentanteEl) {
                ocupacionRepresentanteEl.value = ocupacionEl.value;
            }
        } catch (error) {
            console.error('Error al copiar ocupación:', error);
        }
    };

    // Función para copiar convivencia
    const copiarConvivencia = (prefijoOrigen) => {
        try {
            const convive = document.querySelector(`input[name="convive${prefijoOrigen}"]:checked`);
            const conviveSiRepresentante = document.querySelector('input[name="convive-representante"][value="si"]');
            const conviveNoRepresentante = document.querySelector('input[name="convive-representante"][value="no"]');
            
            if (convive && conviveSiRepresentante && conviveNoRepresentante) {
                if (convive.value === 'si' || convive.value === '1') {
                    conviveSiRepresentante.checked = true;
                } else if (convive.value === 'no' || convive.value === '0') {
                    conviveNoRepresentante.checked = true;
                }
            }
        } catch (error) {
            console.error('Error al copiar convivencia:', error);
        }
    };

    // Función para copiar datos personales
    const copiarDatosPersonales = (prefijoOrigen, esMadre = true) => {
        try {
            // Mapeo de campos para padre/madre
            const campos = [
                { origen: 'primer-nombre', destino: 'primer-nombre-representante' },
                { origen: 'segundo-nombre', destino: 'segundo-nombre-representante' },
                { origen: 'tercer-nombre', destino: 'tercer-nombre-representante' },
                { origen: 'primer-apellido', destino: 'primer-apellido-representante' },
                { origen: 'segundo-apellido', destino: 'segundo-apellido-representante' }
            ];

            // Copiar cada campo si existe
            campos.forEach(campo => {
                const valor = getElement(`${campo.origen}${prefijoOrigen}`)?.value;
                if (valor !== undefined) {
                    setValue(campo.destino, valor);
                }
            });

            // Copiar fecha de nacimiento (manejar tanto con prefijo como sin él)
            const fechaNacimiento = getElement(`fechaNacimiento${prefijoOrigen}`)?.value || 
                                  getElement('fecha-nacimiento' + (esMadre ? '' : '-padre'))?.value ||
                                  getElement('fecha-nacimiento' + prefijoOrigen.toLowerCase())?.value;
            
            if (fechaNacimiento) {
                setValue('fecha-nacimiento-representante', fechaNacimiento);
            }

            // Copiar teléfono y prefijo
            const telefono = getElement(`telefono${prefijoOrigen}`)?.value;
            const prefijo = getElement(`prefijo${prefijoOrigen}`)?.value;
            if (telefono) setValue('telefono-representante', telefono);
            if (prefijo) setValue('prefijo-representante', prefijo);

            // Copiar género (usando el campo correcto para padre)
            const generoId = esMadre ? 
                getElement('sexo')?.value : 
                getElement('sexo-padre')?.value;
            
            if (generoId) {
                setValue('sexo-representante', generoId);
                // Disparar evento change para actualizar selects dependientes si es necesario
                const selectGenero = getElement('sexo-representante');
                if (selectGenero) {
                    selectGenero.dispatchEvent(new Event('change'));
                }
            }
            
            // Copiar ubicación
            const prefijoUbicacion = esMadre ? '' : '-padre';
            const estado = getElement(`idEstado${prefijoUbicacion}`)?.value;
            const municipio = getElement(`idMunicipio${prefijoUbicacion}`)?.value;
            const parroquia = getElement(`idparroquia${prefijoUbicacion}`)?.value;
            const lugarNacimiento = getElement(`lugar-nacimiento${prefijoUbicacion}`)?.value;
            
            // Establecer lugar de nacimiento
            if (lugarNacimiento) {
                setValue('lugar-nacimiento-representante', lugarNacimiento);
            }
            
            // Establecer ubicación (estado, municipio, parroquia)
            if (estado) {
                // Usar setTimeout para asegurar que los selects se hayan cargado
                setTimeout(() => {
                    setSelectValue('idEstado-representante', estado, () => {
                        if (municipio) {
                            setTimeout(() => {
                                setSelectValue('idMunicipio-representante', municipio, () => {
                                    if (parroquia) {
                                        setTimeout(() => {
                                            setSelectValue('idparroquia-representante', parroquia);
                                        }, 500);
                                    }
                                });
                            }, 500);
                        }
                    });
                }, 100);
            }

            return true;
        } catch (error) {
            console.error('Error al copiar datos personales:', error);
            return false;
        }
    };

    // MADRE
    try {
        const numero_documentoMadre = getElement('numero_documento');
        if (numero_documentoMadre?.value === numero_documento) {
            // Copiar datos personales
            copiarDatosPersonales('', true);
            
            // Copiar datos adicionales
            copiarLugarNacimiento('');
            copiarTelefonoYPrefijo('');
            copiarUbicacion('', '');
            copiarOcupacion('madre');
            copiarConvivencia('');

            return true;
        }
    } catch (error) {
        console.error('Error al copiar datos de la madre:', error);
    }

    // PADRE
    try {
        const numero_documentoPadre = getElement('numero_documento-padre');
        if (numero_documentoPadre?.value === numero_documento) {
            // Copiar datos personales
            copiarDatosPersonales('-padre', false);
            
            // Copiar datos adicionales
            copiarLugarNacimiento('-padre');
            copiarTelefonoYPrefijo('padre-');
            copiarUbicacion('padre-', 'padre-');
            copiarOcupacion('padre');
            copiarConvivencia('-padre');

            return true;
        }
    } catch (error) {
        console.error('Error al copiar datos del padre:', error);
    }

    // Si no coincide con ninguno, mostrar mensaje
    try {
        const seccionRep = getElement('datos-representante');
        if (seccionRep) {
            // Remover mensaje anterior si existe
            const mensajeAnterior = getElement('error-copia-datos');
            if (mensajeAnterior) mensajeAnterior.remove();
            
            // Crear y mostrar nuevo mensaje
            const errorDiv = document.createElement('div');
            errorDiv.id = 'error-copia-datos';
            errorDiv.className = 'alert alert-warning mt-3';
            errorDiv.textContent = 'No se encontró un progenitor con esta cédula. Complete los datos manualmente.';
            
            // Insertar después del campo de cédula
            const numero_documentoField = getElement('numero_documento-representante');
            if (numero_documentoField?.parentNode) {
                numero_documentoField.parentNode.insertBefore(errorDiv, numero_documentoField.nextSibling);
            } else {
                seccionRep.insertBefore(errorDiv, seccionRep.firstChild);
            }
        }
        
        // Limpiar campos de representante excepto la cédula
        const campos = document.querySelectorAll('#datos-representante input[type="text"], #datos-representante input[type="email"], #datos-representante input[type="tel"], #datos-representante select');
        campos.forEach(campo => {
            if (campo.id !== 'numero_documento-representante') {
                campo.value = '';
            }
        });
    } catch (error) {
        console.error('Error al mostrar mensaje de error:', error);
    }

    return false;
}

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

            // Variable global para la sección de representante
            let seccionRep = null;

            // Función para habilitar/deshabilitar la sección de representante legal
            function toggleSeccionRepresentante(habilitar) {
                // Inicializar seccionRep si aún no está definida
                if (!seccionRep) {
                    seccionRep = document.getElementById('datos-representante');
                    if (!seccionRep) return;
                }
                
                // Mostrar/ocultar la sección
                seccionRep.style.display = habilitar ? 'block' : 'none';
                
                // Obtener todos los campos del formulario dentro de la sección
                const formControls = seccionRep.querySelectorAll('input, select, textarea, button');
                
                // Habilitar/deshabilitar todos los campos
                formControls.forEach(control => {
                    if (control.type === 'button' || control.type === 'submit') {
                        // Para botones, solo deshabilitar si es necesario
                        control.disabled = !habilitar;
                    } else if (control.type !== 'hidden') {
                        // Para otros controles de formulario
                        control.disabled = !habilitar;
                        control.classList.toggle('bg-light', !habilitar);
                        control.readOnly = !habilitar;
                        
                        // Si es un select, forzar la actualización del estilo
                        if (control.tagName === 'SELECT' && typeof $.fn.select2 === 'function') {
                            $(control).select2({
                                disabled: !habilitar
                            });
                        }
                    }
                });
                
                // Si se deshabilita, limpiar validaciones
                if (!habilitar) {
                    const errores = seccionRep.querySelectorAll('.is-invalid, .invalid-feedback');
                    errores.forEach(el => el.remove());
                }
                
                // Forzar actualización de Select2
                if (typeof $.fn.select2 === 'function') {
                    $('select').select2();
                }
            }

            // Inicialización cuando el DOM esté listo
            document.addEventListener('DOMContentLoaded', function() {
                // Obtener referencia a la sección
                seccionRep = document.getElementById('datos-representante');
                
                // Ocultar la sección por defecto
                if (seccionRep) {
                    seccionRep.style.display = 'none';
                }
                
                // Verificar si hay un radio button seleccionado por defecto
                const radioSeleccionado = document.querySelector('input[name="tipo_representante"]:checked');
                if (radioSeleccionado) {
                    toggleSeccionRepresentante(true);
                }
            });

            // Manejar cambios en los radio buttons de tipo de representante
            document.querySelectorAll('input[name="tipo_representante"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    const tipo = this.value;
                    
                    // Limpiar errores de validación de cédula cuando se selecciona 'Progenitor como Representante'
                    if (tipo === 'progenitor_representante') {
                        const numero_documentoRepresentante = document.getElementById('numero_documento-representante');
                        if (numero_documentoRepresentante) {
                            limpiarnumero_documentoError(numero_documentoRepresentante);
                            
                            // Si hay un valor en la cédula del representante, forzar la validación
                            if (numero_documentoRepresentante.value) {
                                numero_documentoRepresentante.dispatchEvent(new Event('blur'));
                            }
                        }
                    }
                    
                    if (tipo) {
                        // Si se selecciona alguna opción, habilitar la sección
                        toggleSeccionRepresentante(true);
                        
                        // Si es 'progenitor_representante', limpiar el campo de cédula para que el usuario lo llene
                        if (tipo === 'progenitor_representante') {
                            const numero_documentoRepresentante = document.getElementById('numero_documento-representante');
                            if (numero_documentoRepresentante) {
                                // Limpiar el campo de cédula y enfocarlo para que el usuario lo llene
                                numero_documentoRepresentante.value = '';
                                numero_documentoRepresentante.focus();
                                
                                // Agregar evento para copiar datos cuando se ingrese la cédula
                                const handlenumero_documentoBlur = function() {
                                    if (numero_documentoRepresentante.value.trim() !== '') {
                                        copiarDesdeMadreOPadreSiCoincide(numero_documentoRepresentante.value);
                                    }
                                };
                                
                                // Remover cualquier evento anterior para evitar duplicados
                                numero_documentoRepresentante.removeEventListener('blur', handlenumero_documentoBlur);
                                numero_documentoRepresentante.addEventListener('blur', handlenumero_documentoBlur);
                            }
                        }
                    } else {
                        // Sin selección: ocultar y bloquear todo
                        toggleSeccionRepresentante(false);
                    }

                    // Si es progenitor_representante, intentar copiar datos del padre/madre
                    if (tipo === 'progenitor_representante') {
                        // Determinar si el padre o la madre está presente
                        const padrePresente = document.querySelector('input[name="estado_padre"]:checked')?.value === 'Presente';
                        const madrePresente = document.querySelector('input[name="estado_madre"]:checked')?.value === 'Presente';
                        
                        // Obtener los valores de los campos de cédula
                        const numero_documentoPadre = document.getElementById('numero_documento-padre')?.value;
                        const numero_documentoMadre = document.getElementById('numero_documento')?.value;
                        
                        // Obtener los valores de los campos de correo
                        const correoPadre = document.getElementById('email-padre')?.value;
                        const correoMadre = document.getElementById('email')?.value;
                        
                        // Obtener los tipos de documento
                        const tipoDocPadre = document.getElementById('tipo-ci-padre')?.value;
                        const tipoDocMadre = document.getElementById('tipo-ci')?.value;
                        
                        // Si el padre está presente, copiar sus datos
                        if (padrePresente && numero_documentoPadre) {
                            document.getElementById('numero_documento-representante').value = numero_documentoPadre;
                            const tipoCiRepresentante = document.getElementById('tipo-ci-representante');
                            if (tipoCiRepresentante && tipoDocPadre) {
                                tipoCiRepresentante.value = tipoDocPadre;
                            }
                            const correoRepresentante = document.getElementById('correo-representante');
                            if (correoRepresentante && correoPadre) {
                                correoRepresentante.value = correoPadre;
                            }
                            console.log('Datos copiados del padre:', { numero_documento: numero_documentoPadre, correo: correoPadre });
                        } 
                        // Si la madre está presente, copiar sus datos
                        else if (madrePresente && numero_documentoMadre) {
                            document.getElementById('numero_documento-representante').value = numero_documentoMadre;
                            const tipoCiRepresentante = document.getElementById('tipo-ci-representante');
                            if (tipoCiRepresentante && tipoDocMadre) {
                                tipoCiRepresentante.value = tipoDocMadre;
                            }
                            const correoRepresentante = document.getElementById('correo-representante');
                            if (correoRepresentante && correoMadre) {
                                correoRepresentante.value = correoMadre;
                            }
                            console.log('Datos copiados de la madre:', { numero_documento: numero_documentoMadre, correo: correoMadre });
                        }
                        
                        // Forzar el evento blur en la cédula para buscar datos adicionales
                        const numero_documentoRepresentante = document.getElementById('numero_documento-representante');
                        if (numero_documentoRepresentante && numero_documentoRepresentante.value) {
                            numero_documentoRepresentante.dispatchEvent(new Event('blur'));
                        }
                    }
                });
            });

            // Al salir de la cédula del representante, si el tipo es progenitor_representante,
            // primero intentamos copiar desde madre/padre; si no coincide, buscamos en BD
            document.getElementById('numero_documento-representante')?.addEventListener('blur', function() {
                const tipo = document.querySelector('input[name="tipo_representante"]:checked')?.value;
                const numero_documento = this.value;

                if (tipo !== 'progenitor_representante' || !numero_documento) {
                    return;
                }

                // 1) Intentar copiar desde los datos ya cargados en este formulario (madre/padre)
                const copiadoLocal = copiarDesdeMadreOPadreSiCoincide(numero_documento);
                if (copiadoLocal) {
                    return; // no hace falta ir a BD
                }

                // 2) Si no coincide con madre/padre, buscar en BD
                fetch(`${buscarnumero_documentoUrl}?numero_documento=${numero_documento}`)
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

            document.querySelectorAll('input[name*="numero_documento"]').forEach(input => {
                input.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '').substring(0, 8);
                });
            });
        });
        
        // Función para mostrar errores
function mostrarError(elemento, mensaje) {
    if (!elemento) return;
    
    const grupo = elemento.closest('.form-group') || elemento.closest('.input-group') || elemento.closest('.mb-3');
    if (!grupo) return;

    let errorElement = grupo.querySelector('.invalid-feedback');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.className = 'invalid-feedback d-block';
        grupo.appendChild(errorElement);
    }
    errorElement.textContent = mensaje;
    
    // Añadir clases de error
    elemento.classList.add('is-invalid');
    if (elemento.tagName === 'SELECT') {
        elemento.classList.add('border-danger');
    }
}

// Función para limpiar errores
function limpiarError(elemento) {
    if (!elemento) return;
    
    const grupo = elemento.closest('.form-group') || elemento.closest('.input-group') || elemento.closest('.mb-3');
    if (!grupo) return;

    const errorElement = grupo.querySelector('.invalid-feedback');
    if (errorElement) {
        errorElement.remove();
    }
    
    elemento.classList.remove('is-invalid');
    if (elemento.tagName === 'SELECT') {
        elemento.classList.remove('border-danger');
    }
}

// Validar campo requerido
function validarRequerido(input) {
    if (!input) return false;
    if (!input.value.trim()) {
        mostrarError(input, 'Este campo es obligatorio');
        return false;
    }
    limpiarError(input);
    return true;
}

// Validar selección de opción
function validarSeleccion(select) {
    if (!select) return false;
    if (!select.value) {
        mostrarError(select, 'Debe seleccionar una opción');
        return false;
    }
    limpiarError(select);
    return true;
}

// Función para verificar si se ha seleccionado "Progenitor como Representante"
function esProgenitorRepresentante() {
    return document.querySelector('input[name="tipo_representante"][value="progenitor_representante"]:checked') !== null;
}

// Validar cédula (solo verifica que no esté vacío si es requerido)
function validarnumero_documento(input) {
    if (!input) return true;  // No hay input, no validar
    
    const numero_documento = input.value.trim();
    if (input.required && !numero_documento) {
        mostrarError(input, 'La cédula es obligatoria');
        return false;
    }
    
    limpiarError(input);
    return true;
}

// Validar teléfono
function validarTelefono(input) {
    if (!input) return false;
    const telefono = input.value.trim();
    if (!telefono) {
        mostrarError(input, 'El teléfono es obligatorio');
        return false;
    }
    if (!/^\d{7,11}$/.test(telefono)) {
        mostrarError(input, 'El teléfono debe tener entre 7 y 11 dígitos');
        return false;
    }
    limpiarError(input);
    return true;
}

// Validar fecha de nacimiento
function validarFechaNacimiento(input) {
    if (!input) return false;
    if (!input.value) {
        mostrarError(input, 'La fecha de nacimiento es obligatoria');
        return false;
    }
    
    const fechaNacimiento = new Date(input.value);
    const hoy = new Date();
    const edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
    
    if (fechaNacimiento > hoy) {
        mostrarError(input, 'La fecha no puede ser futura');
        return false;
    }
    if (edad < 18) {
        mostrarError(input, 'El representante debe ser mayor de edad');
        return false;
    }
    
    limpiarError(input);
    return true;
}

// Configurar validación en tiempo real para un campo
function configurarValidacion(input, validacion) {
    if (!input) return;
    
    // Validar al perder el foco
    input.addEventListener('blur', function() {
        // No validar cédula de representante si es "Progenitor como Representante"
        if (this.id === 'numero_documento-representante' && esProgenitorRepresentante()) {
            limpiarError(this);
            return;
        }
        validacion(this);
    });

    // Limpiar errores al escribir
    input.addEventListener('input', function() {
        if (this.value.trim() !== '') {
            limpiarError(this);
        }
    });
    
    // Si es el campo de cédula del representante, agregar evento para el cambio de tipo de representante
    if (input.id === 'numero_documento-representante') {
        document.querySelectorAll('input[name="tipo_representante"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'progenitor_representante') {
                    limpiarError(input);
                } else {
                    // Si cambia a otro tipo, validar la cédula
                    validarnumero_documento(input);
                }
            });
        });
    }
}

// Configurar validación para selects
function configurarValidacionSelect(select) {
    if (!select) return;
    
    select.addEventListener('change', function() {
        if (this.value) {
            limpiarError(this);
        } else {
            validarSeleccion(this);
        }
    });
}

// Configurar validaciones para la madre
function configurarValidacionesMadre() {
    const camposMadre = {
        // Datos personales
        'primer-nombre': validarRequerido,
        'primer-apellido': validarRequerido,
        'numero_documento': validarnumero_documento,
        'fechaNacimiento': validarFechaNacimiento,
        'sexo': validarSeleccion,
        'lugar-nacimiento': validarRequerido,
        // Ubicación
        'idEstado': validarSeleccion,
        'idMunicipio': validarSeleccion,
        'idparroquia': validarSeleccion,
        // Contacto
        'prefijo': validarSeleccion,
        'telefono': validarTelefono,
        // Relación familiar
        'ocupacion-madre': validarRequerido,
        'convive': validarSeleccion
    };

    Object.entries(camposMadre).forEach(([id, validacion]) => {
        const elemento = document.getElementById(id);
        if (elemento) {
            if (elemento.tagName === 'SELECT') {
                configurarValidacionSelect(elemento);
            } else if (elemento.type === 'radio' || elemento.type === 'checkbox') {
                // Para radios, configurar en todos los del mismo nombre
                const radioName = elemento.name;
                const radioGroup = document.querySelectorAll(`input[name="${radioName}"]`);
                if (radioGroup.length > 0) {
                    radioGroup.forEach(radio => {
                        radio.addEventListener('change', () => {
                            const selected = document.querySelector(`input[name="${radioName}"]:checked`);
                            if (!selected) {
                                mostrarError(radio, 'Debe seleccionar una opción');
                            } else {
                                limpiarError(radio);
                                // Limpiar errores de otros radios del mismo grupo
                                radioGroup.forEach(r => limpiarError(r));
                            }
                        });
                    });
                }
            } else {
                configurarValidacion(elemento, validacion);
            }
        }
    });
}

// Configurar validaciones para el padre
function configurarValidacionesPadre() {
    const camposPadre = {
        // Datos personales
        'primer-nombre-padre': validarRequerido,
        'primer-apellido-padre': validarRequerido,
        'numero_documento-padre': validarnumero_documento,
        'fechaNacimiento-padre': validarFechaNacimiento,
        'genero-padre': validarSeleccion,
        'lugar-nacimiento-padre': validarRequerido,
        // Ubicación
        'idEstado-padre': validarSeleccion,
        'idMunicipio-padre': validarSeleccion,
        'idparroquia-padre': validarSeleccion,
        // Contacto
        'prefijo-padre': validarSeleccion,
        'telefono-padre': validarTelefono,
        // Relación familiar
        'ocupacion-padre': validarRequerido,
        'convive-padre': validarSeleccion
    };

    Object.entries(camposPadre).forEach(([id, validacion]) => {
        const elemento = document.getElementById(id);
        if (elemento) {
            if (elemento.tagName === 'SELECT') {
                configurarValidacionSelect(elemento);
            } else if (elemento.type === 'radio' || elemento.type === 'checkbox') {
                const radioName = elemento.name;
                const radioGroup = document.querySelectorAll(`input[name="${radioName}"]`);
                if (radioGroup.length > 0) {
                    radioGroup.forEach(radio => {
                        radio.addEventListener('change', () => {
                            const selected = document.querySelector(`input[name="${radioName}"]:checked`);
                            if (!selected) {
                                mostrarError(radio, 'Debe seleccionar una opción');
                            } else {
                                limpiarError(radio);
                                // Limpiar errores de otros radios del mismo grupo
                                radioGroup.forEach(r => limpiarError(r));
                            }
                        });
                    });
                }
            } else {
                configurarValidacion(elemento, validacion);
            }
        }
    });
}

// Configurar validaciones para el representante legal
function configurarValidacionesRepresentante() {
    const camposRepresentante = {
        // Datos personales
        'primer-nombre-representante': validarRequerido,
        'primer-apellido-representante': validarRequerido,
        'numero_documento-representante': validarnumero_documento,
        'fechaNacimiento-representante': validarFechaNacimiento,
        'sexo-representante': validarSeleccion,
        'lugar-nacimiento-representante': validarRequerido,
        // Ubicación
        'idEstado-representante': validarSeleccion,
        'idMunicipio-representante': validarSeleccion,
        'idparroquia-representante': validarSeleccion,
        // Contacto
        'prefijo-representante': validarSeleccion,
        'telefono-representante': validarTelefono,
        // Relación familiar
        'ocupacion-representante': validarRequerido,
        'convive-representante': validarSeleccion,
        // Datos legales
        'parentesco': validarSeleccion,
        'tipo-cuenta': validarSeleccion,
        'banco-representante': validarSeleccion
    };

    Object.entries(camposRepresentante).forEach(([id, validacion]) => {
        const elemento = document.getElementById(id);
        if (elemento) {
            if (elemento.tagName === 'SELECT') {
                configurarValidacionSelect(elemento);
            } else if (elemento.type === 'radio' || elemento.type === 'checkbox') {
                const radioName = elemento.name;
                const radioGroup = document.querySelectorAll(`input[name="${radioName}"]`);
                if (radioGroup.length > 0) {
                    radioGroup.forEach(radio => {
                        radio.addEventListener('change', () => {
                            const selected = document.querySelector(`input[name="${radioName}"]:checked`);
                            if (!selected) {
                                mostrarError(radio, 'Debe seleccionar una opción');
                            } else {
                                limpiarError(radio);
                                // Limpiar errores de otros radios del mismo grupo
                                radioGroup.forEach(r => limpiarError(r));
                            }
                        });
                    });
                }
            } else {
                configurarValidacion(elemento, validacion);
            }
        }
    });
}

// Función para inicializar las validaciones
function inicializarValidaciones() {
    // Configurar validaciones
    configurarValidacionesMadre();
    configurarValidacionesPadre();
    configurarValidacionesRepresentante();

    // Validar formulario antes de enviar
    const formulario = document.querySelector('form');
    if (formulario) {
        // Guardar el manejador original si existe
        const originalSubmit = formulario.onsubmit;

        // Agregar nuestro manejador
        formulario.addEventListener('submit', function(e) {
            let valido = true;
            
            // Limpiar errores previos
            const erroresPrevios = formulario.querySelectorAll('.is-invalid');
            erroresPrevios.forEach(el => el.classList.remove('is-invalid'));
            
            const mensajesError = formulario.querySelectorAll('.invalid-feedback');
            mensajesError.forEach(el => el.remove());
            
            // Validar todos los campos requeridos
            const requiredInputs = formulario.querySelectorAll('[required]');
            requiredInputs.forEach(input => {
                if (input.offsetParent !== null) { // Solo validar campos visibles
                    if (input.type === 'radio' || input.type === 'checkbox') {
                        const name = input.name;
                        const radioGroup = Array.from(document.querySelectorAll(`input[name="${name}"]`));
                        const isRequired = radioGroup.some(radio => radio.required);
                        
                        if (isRequired) {
                            const checked = formulario.querySelector(`input[name="${name}"]:checked`);
                            if (!checked) {
                                const firstRadio = radioGroup[0];
                                mostrarError(firstRadio, 'Debe seleccionar una opción');
                                valido = false;
                            }
                        }
                    } else if (input.required && !input.value.trim()) {
                        mostrarError(input, 'Este campo es obligatorio');
                        valido = false;
                    }
                }
            });

            if (!valido) {
                e.preventDefault();
                e.stopImmediatePropagation();
                
                // Desplazarse al primer error
                const primerError = formulario.querySelector('.is-invalid');
                if (primerError) {
                    primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    primerError.focus();
                }
                return false;
            }
            
            // Si hay un manejador original, ejecutarlo
            if (originalSubmit) {
                const result = originalSubmit.call(formulario, e);
                if (result === false) {
                    e.preventDefault();
                    return false;
                }
            }
            
            return true;
        }, true); // Usar captura para asegurarnos de ejecutarnos primero
    }
}

// Función para validar un campo individual con validaciones específicas
function validarCampo(campo, mensajeError) {
    if (!campo) return false;
    
    const valor = campo.value.trim();
    let esValido = true;
    let mensaje = '';
    
    // Validar campo requerido
    const esRequerido = campo.required || campo.getAttribute('required') !== null;
    
    // Campos que siempre son obligatorios independientemente del atributo required
    const camposObligatorios = [
        'lugar-nacimiento-representante',
        'carnet-patria',
        'codigo-carnet',
        'serial-carnet'
    ];
    
    // Verificar si el campo es obligatorio
    const esCampoObligatorio = camposObligatorios.includes(campo.id) || 
                              (campo.id.includes('lugar-nacimiento') && !campo.id.includes('lugar-nacimiento-madre') && !campo.id.includes('lugar-nacimiento-padre'));
    
    // Forzar el atributo required si es un campo obligatorio
    if (esCampoObligatorio) {
        campo.required = true;
    }
    
    if ((esRequerido || esCampoObligatorio) && valor === '') {
        esValido = false;
        mensaje = 'Este campo es obligatorio';
    }
    
    // Validaciones específicas por tipo de campo
    if (esValido && valor !== '') {
        // Validar nombres (solo letras, espacios y caracteres especiales comunes en nombres)
        if (campo.id.includes('nombre') || campo.id.includes('apellido') || 
            campo.name.includes('nombre') || campo.name.includes('apellido')) {
            const nombreRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s'-]+$/;
            if (!nombreRegex.test(valor)) {
                esValido = false;
                mensaje = 'Solo se permiten letras y espacios en este campo';
            }
        }
        // Validar ubicaciones (estado, municipio, parroquia, lugar de nacimiento)
        else if (campo.id.includes('lugar-nacimiento') || 
                campo.id.includes('idEstado') || 
                campo.id.includes('idMunicipio') || 
                campo.id.includes('idparroquia')) {
            if (valor === '' || valor === 'Seleccione') {
                esValido = false;
                mensaje = 'Este campo es obligatorio';
                
                // Asegurarse de que el campo se marque como inválido visualmente
                if (campo.id === 'lugar-nacimiento-representante') {
                    campo.classList.add('is-invalid');
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = mensaje;
                    
                    // Insertar el mensaje de error después del campo
                    const parent = campo.parentNode;
                    if (parent && !parent.querySelector('.invalid-feedback')) {
                        parent.appendChild(errorDiv);
                    }
                }
            }
        }
        // Validar Carnet de la Patria
        else if (campo.id === 'carnet-patria') {
            if (valor === '' || valor === 'Seleccione') {
                esValido = false;
                mensaje = 'Debe seleccionar una opción';
            } else if (valor !== '0') { // Si no es 'No aplica'
                // Validar campos de código y serial si está afiliado
                const codigoCarnet = document.getElementById('codigo-carnet');
                const serialCarnet = document.getElementById('serial-carnet');
                
                if (codigoCarnet && codigoCarnet.value.trim() === '') {
                    esValido = false;
                    mostrarError(codigoCarnet, 'El código del carnet es obligatorio');
                }
                
                if (serialCarnet && serialCarnet.value.trim() === '') {
                    esValido = false;
                    mostrarError(serialCarnet, 'El serial del carnet es obligatorio');
                }
            }
        }
        // Validar formato de código y serial de carnet
        else if (campo.id === 'codigo-carnet' || campo.id === 'serial-carnet') {
            if (valor !== '') {
                // Validar que solo contenga números y letras
                const codigoRegex = /^[A-Za-z0-9]+$/;
                if (!codigoRegex.test(valor)) {
                    esValido = false;
                    mensaje = 'Solo se permiten letras y números';
                } else if (valor.length < 5) {
                    esValido = false;
                    mensaje = 'Debe tener al menos 5 caracteres';
                }
            } else {
                // Si el campo está vacío, verificar si es obligatorio
                const carnetAfiliado = document.getElementById('carnet-patria');
                if (carnetAfiliado && carnetAfiliado.value !== '0' && carnetAfiliado.value !== '') {
                    esValido = false;
                    mensaje = 'Este campo es obligatorio';
                }
            }
        }
        // Validar email
        if (campo.type === 'email' || campo.getAttribute('data-type') === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(valor)) {
                esValido = false;
                mensaje = 'Ingrese un correo electrónico válido';
            }
        }
        // Validar números
        else if (campo.type === 'number' || campo.getAttribute('data-type') === 'number') {
            if (isNaN(valor)) {
                esValido = false;
                mensaje = 'Ingrese un número válido';
            } else {
                const min = campo.getAttribute('min');
                const max = campo.getAttribute('max');
                const numVal = parseFloat(valor);
                
                if (min !== null && numVal < parseFloat(min)) {
                    esValido = false;
                    mensaje = `El valor mínimo permitido es ${min}`;
                } else if (max !== null && numVal > parseFloat(max)) {
                    esValido = false;
                    mensaje = `El valor máximo permitido es ${max}`;
                }
            }
        }
        // Validar teléfono
        else if (campo.id.includes('telefono') || campo.getAttribute('data-type') === 'phone') {
            const phoneRegex = /^[0-9\s\-\(\)]+$/;
            if (!phoneRegex.test(valor)) {
                esValido = false;
                mensaje = 'Ingrese un número de teléfono válido';
            }
        }
        // Validación de cédula/RIF eliminada para permitir cualquier valor
        // Se mantiene el comentario para referencia
    }
    
    if (!esValido) {
        mostrarError(campo, mensaje || mensajeError);
        return false;
    }
    
    limpiarError(campo);
    return true;
}

// Función para validar un grupo de radio buttons o checkboxes
function validarRadioGroup(nombreGrupo, mensajeError) {
    const inputs = document.querySelectorAll(`input[name="${nombreGrupo}"]`);
    if (inputs.length === 0) return true;
    
    const esRadio = inputs[0].type === 'radio';
    const seleccionado = Array.from(inputs).some(input => input.checked);
    const esRequerido = inputs[0].required || inputs[0].getAttribute('required') !== null;
    
    // Solo validar si es requerido
    if (esRequerido && !seleccionado) {
        const primerInput = inputs[0];
        const errorElement = primerInput.closest('.form-group') || primerInput.closest('.form-check');
        mostrarError(errorElement, mensajeError || `Debe seleccionar ${esRadio ? 'una opción' : 'al menos una opción'}`);
        return false;
    }
    
    // Limpiar errores si es válido
    if (seleccionado) {
        inputs.forEach(input => {
            const errorElement = input.closest('.form-group') || input.closest('.form-check');
            limpiarError(errorElement);
        });
    }
    
    return true;
}

// Función para validar la sección de la madre
function validarSeccionMadre() {
    let valido = true;
    
    // Validar estado de la madre
    if (!validarRadioGroup('estado_madre', 'Debe seleccionar el estado de la madre')) {
        valido = false;
    }
    
    // Si la madre está presente, validar sus datos
    if (document.querySelector('input[name="estado_madre"]:checked')?.value === 'Presente') {
        const camposMadre = [
            { id: 'tipo-ci', mensaje: 'Seleccione el tipo de documento' },
            { id: 'numero_documento', mensaje: 'Ingrese el número de cédula' },
            { id: 'primer-nombre', mensaje: 'Ingrese el primer nombre' },
            { id: 'primer-apellido', mensaje: 'Ingrese el primer apellido' },
            { id: 'sexo', mensaje: 'Seleccione el género' },
            { id: 'lugar-nacimiento', mensaje: 'Ingrese el lugar de nacimiento' },
            { id: 'idEstado', mensaje: 'Seleccione el estado' },
            { id: 'idMunicipio', mensaje: 'Seleccione el municipio' },
            { id: 'idparroquia', mensaje: 'Seleccione la parroquia' },
            { id: 'prefijo', mensaje: 'Seleccione el prefijo telefónico' },
            { id: 'telefono', mensaje: 'Ingrese el número de teléfono' },
            { id: 'ocupacion-madre', mensaje: 'Seleccione una ocupación' }
        ];
        
        // Asegurarse de que los campos de ubicación sean requeridos
        const ubicaciones = ['lugar-nacimiento', 'idEstado', 'idMunicipio', 'idparroquia'];
        ubicaciones.forEach(id => {
            const elemento = document.getElementById(id);
            if (elemento) elemento.required = true;
        });
        
        camposMadre.forEach(campo => {
            const elemento = document.getElementById(campo.id);
            if (elemento && !validarCampo(elemento, campo.mensaje)) {
                valido = false;
            }
        });
    }
    
    return valido;
}

// Función para validar la sección del padre
function validarSeccionPadre() {
    let valido = true;
    
    // Validar estado del padre
    if (!validarRadioGroup('estado_padre', 'Debe seleccionar el estado del padre')) {
        valido = false;
    }
    
    // Si el padre está presente, validar sus datos
    if (document.querySelector('input[name="estado_padre"]:checked')?.value === 'Presente') {
        const camposPadre = [
            { id: 'tipo-ci-padre', mensaje: 'Seleccione el tipo de documento' },
            { id: 'numero_documento-padre', mensaje: 'Ingrese el número de cédula' },
            { id: 'primer-nombre-padre', mensaje: 'Ingrese el primer nombre' },
            { id: 'primer-apellido-padre', mensaje: 'Ingrese el primer apellido' },
            { id: 'sexo-padre', mensaje: 'Seleccione el género' },
            { id: 'lugar-nacimiento-padre', mensaje: 'Ingrese el lugar de nacimiento' },
            { id: 'idEstado-padre', mensaje: 'Seleccione el estado' },
            { id: 'idMunicipio-padre', mensaje: 'Seleccione el municipio' },
            { id: 'idparroquia-padre', mensaje: 'Seleccione la parroquia' },
            { id: 'prefijo-padre', mensaje: 'Seleccione el prefijo telefónico' },
            { id: 'telefono-padre', mensaje: 'Ingrese el número de teléfono' },
            { id: 'ocupacion-padre', mensaje: 'Seleccione una ocupación' }
        ];
        
        // Asegurarse de que los campos de ubicación sean requeridos
        const ubicaciones = ['lugar-nacimiento-padre', 'idEstado-padre', 'idMunicipio-padre', 'idparroquia-padre'];
        ubicaciones.forEach(id => {
            const elemento = document.getElementById(id);
            if (elemento) elemento.required = true;
        });
        
        camposPadre.forEach(campo => {
            const elemento = document.getElementById(campo.id);
            if (elemento && !validarCampo(elemento, campo.mensaje)) {
                valido = false;
            }
        });
    }
    
    return valido;
}

// Función para validar la sección del representante legal
function validarSeccionRepresentante() {
    let valido = true;
    
    // Validar tipo de representante
    if (!validarRadioGroup('tipo_representante', 'Seleccione el tipo de representante')) {
        valido = false;
    }
    
    const camposRepresentante = [
        { id: 'tipo-ci-representante', mensaje: 'Seleccione el tipo de documento' },
        { id: 'numero_documento-representante', mensaje: 'Ingrese el número de cédula' },
        { id: 'primer-nombre-representante', mensaje: 'Ingrese el primer nombre' },
        { id: 'primer-apellido-representante', mensaje: 'Ingrese el primer apellido' },
        { id: 'sexo-representante', mensaje: 'Seleccione el género' },
        { id: 'lugar-nacimiento-representante', mensaje: 'Ingrese el lugar de nacimiento' },
        { id: 'idEstado-representante', mensaje: 'Seleccione el estado' },
        { id: 'idMunicipio-representante', mensaje: 'Seleccione el municipio' },
        { id: 'idparroquia-representante', mensaje: 'Seleccione la parroquia' },
        { id: 'prefijo-representante', mensaje: 'Seleccione el prefijo telefónico' },
        { id: 'telefono-representante', mensaje: 'Ingrese el número de teléfono' },
        { id: 'parentesco', mensaje: 'Seleccione el parentesco' },
        { id: 'banco-representante', mensaje: 'Seleccione el banco' },
        { id: 'tipo-cuenta-representante', mensaje: 'Seleccione el tipo de cuenta' },
        { id: 'numero-cuenta-representante', mensaje: 'Ingrese el número de cuenta' },
        { id: 'carnet-patria', mensaje: 'Seleccione la opción de Carnet de la Patria' },
        { id: 'codigo-carnet', mensaje: 'Ingrese el código del carnet' },
        { id: 'serial-carnet', mensaje: 'Ingrese el serial del carnet' }
    ];
    
    // Asegurarse de que los campos de ubicación sean requeridos
    const ubicaciones = [
        'lugar-nacimiento-representante', 
        'idEstado-representante', 
        'idMunicipio-representante', 
        'idparroquia-representante'
    ];
    
    ubicaciones.forEach(id => {
        const elemento = document.getElementById(id);
        if (elemento) elemento.required = true;
    });
    
    camposRepresentante.forEach(campo => {
        const elemento = document.getElementById(campo.id);
        if (elemento && !validarCampo(elemento, campo.mensaje)) {
            valido = false;
        }
    });
    
    return valido;
}

// Función para validar todo el formulario
function validarFormularioCompleto() {
    // Limpiar errores previos
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
    
    // Validar cada sección
    const validoMadre = validarSeccionMadre();
    const validoPadre = validarSeccionPadre();
    const validoRepresentante = validarSeccionRepresentante();
    
    // Si hay errores, desplazarse al primero
    if (!validoMadre || !validoPadre || !validoRepresentante) {
        const primerError = document.querySelector('.is-invalid');
        if (primerError) {
            primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            primerError.focus();
        }
        return false;
    }
    
    return true;
}

// Función para agregar validación en tiempo real
function agregarValidacionEnTiempoReal() {
    // Validar campos de texto, email, número, teléfono y selects
    document.querySelectorAll('input[type="text"], input[type="email"], input[type="number"], input[type="tel"], textarea, select').forEach(input => {
        if (input.type === 'file') return;
        
        // Marcar como requerido si es un campo de ubicación o del Carnet de la Patria
        if (input.id.includes('lugar-nacimiento') || 
            input.id.includes('idEstado') || 
            input.id.includes('idMunicipio') || 
            input.id.includes('idparroquia') ||
            input.id === 'carnet-patria' ||
            input.id === 'codigo-carnet' ||
            input.id === 'serial-carnet') {
            input.required = true;
            
            // Agregar clase de Bootstrap para estilos de campo requerido
            if (!input.classList.contains('is-required')) {
                input.classList.add('is-required');
            }
        }
        
        // Validar campos del Carnet de la Patria cuando cambian
        if (input.id === 'carnet-patria') {
            input.addEventListener('change', function() {
                const codigoCarnet = document.getElementById('codigo-carnet');
                const serialCarnet = document.getElementById('serial-carnet');
                
                // Mostrar/ocultar campos según la selección
                if (this.value === '0') { // No aplica
                    if (codigoCarnet) codigoCarnet.required = false;
                    if (serialCarnet) serialCarnet.required = false;
                } else {
                    if (codigoCarnet) codigoCarnet.required = true;
                    if (serialCarnet) serialCarnet.required = true;
                }
                
                validarCampo(this, 'Seleccione una opción');
            });
        }
        
        // Validar al salir del campo
        input.addEventListener('blur', function() {
            // Validar siempre los campos obligatorios, independientemente de si tienen valor o no
            if (this.required || this.id.includes('lugar-nacimiento') || this.value.trim() !== '') {
                validarCampo(this, 'Este campo es obligatorio');
            }
        });
        
        // Validar mientras se escribe (solo si ya tiene un valor)
        input.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                validarCampo(this, 'Este campo es obligatorio');
            } else {
                limpiarError(this);
                this.classList.remove('is-invalid');
            }
        });
        
        // Validar cambios en selects de ubicación
        if (input.tagName === 'SELECT' && 
            (input.id.includes('idEstado') || 
             input.id.includes('idMunicipio') || 
             input.id.includes('idparroquia'))) {
            input.addEventListener('change', function() {
                validarCampo(this, 'Este campo es obligatorio');
            });
        }
    });
    
    // Validar radio buttons y checkboxes
    document.querySelectorAll('input[type="radio"], input[type="checkbox"]').forEach(input => {
        input.addEventListener('change', function() {
            const name = this.name;
            const formGroup = this.closest('.form-group') || this.closest('.form-check');
            
            if (this.type === 'radio') {
                validarRadioGroup(name);
            } 
            else if (this.required) {
                const checked = document.querySelectorAll(`input[name="${name}"]:checked`).length > 0;
                if (!checked) {
                    mostrarError(formGroup, 'Debe seleccionar al menos una opción');
                } else {
                    limpiarError(formGroup);
                }
            }
        });
    });
}

// Inicializar validaciones cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Configurar validación en tiempo real
    agregarValidacionEnTiempoReal();
    
    // Configurar el evento de envío del formulario
    const formulario = document.getElementById('representante-form');
    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            if (!validarFormularioCompleto()) {
                e.preventDefault();
                e.stopPropagation();
                
                // Desplazarse al primer error
                const primerError = document.querySelector('.is-invalid');
                if (primerError) {
                    primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    primerError.focus();
                }
                
                return false;
            }
            return true;
        });
    }
});

// ================= VALIDACIÓN DE FECHAS DE NACIMIENTO =================
// Función para validar que la fecha corresponde a una persona mayor de 18 años
function validarEdad(fechaInput) {
    // Si no hay input o no tiene valor, limpiar estilos y salir
    if (!fechaInput || !fechaInput.value) {
        limpiarEstiloEdad(fechaInput);
        return true;
    }
    
    // Calcular la edad exacta
    const fechaNacimiento = new Date(fechaInput.value);
    const hoy = new Date();
    let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
    const mes = hoy.getMonth() - fechaNacimiento.getMonth();
    
    // Ajustar la edad si aún no ha cumplido años este año
    if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
        edad--;
    }
    
    // Obtener el contenedor del campo y verificar si ya existe una advertencia
    const grupo = fechaInput.closest('.form-group') || fechaInput.closest('.input-group');
    let advertencia = grupo ? grupo.querySelector('.advertencia-edad') : null;
    
    // Verificar si es menor de 18 años
    if (edad < 18) {
        // Crear mensaje de advertencia
        const mensaje = 'Advertencia: La persona es menor de 18 años';
        
        // Crear elemento de advertencia si no existe
        if (!advertencia && grupo) {
            advertencia = document.createElement('small');
            advertencia.className = 'form-text text-danger advertencia-edad';
            grupo.appendChild(advertencia);
        }
        
        // Actualizar el texto de la advertencia
        if (advertencia) {
            advertencia.textContent = mensaje;
        }
        
        // Resaltar el campo en rojo
        fechaInput.classList.add('is-invalid');
        fechaInput.classList.remove('is-valid');
    } else {
        // Si es mayor de edad, limpiar cualquier advertencia previa
        limpiarEstiloEdad(fechaInput);
    }
    
    return true; // Siempre permitir cualquier fecha
}

/**
 * Limpia los estilos y mensajes de advertencia de un campo de fecha
 * @param {HTMLInputElement} input - Elemento input a limpiar
 */
function limpiarEstiloEdad(input) {
    if (!input) return;
    
    // Buscar y eliminar el mensaje de advertencia si existe
    const grupo = input.closest('.form-group') || input.closest('.input-group');
    if (grupo) {
        const advertencia = grupo.querySelector('.advertencia-edad');
        if (advertencia) {
            advertencia.remove();
        }
    }
    // Restaurar estilos por defecto
    input.classList.remove('is-invalid', 'is-valid');
}

/**
 * Configura los eventos de validación para todos los campos de fecha
 */
function configurarValidacionFechas() {
    // IDs de todos los campos de fecha que necesitan validación
    const fechas = [
        'fecha-nacimiento-representante', // Fecha de nacimiento del representante
        'fecha-nacimiento-padre',        // Fecha de nacimiento del padre
        'fechaNacimiento'                // Fecha de nacimiento de la madre
    ];

    // Configurar eventos para cada campo de fecha
    fechas.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            // Validar cuando cambia la fecha
            input.addEventListener('change', function() {
                validarEdad(this);
            });
            
            // También validar cuando el campo pierde el foco
            input.addEventListener('blur', function() {
                validarEdad(this);
            });
        }
    });
}

// Inicializar la validación cuando el DOM esté completamente cargado
if (document.readyState === 'loading') {
    // Si el DOM aún no está listo, esperar a que cargue
    document.addEventListener('DOMContentLoaded', configurarValidacionFechas);
} else {
    // Si el DOM ya está listo, ejecutar directamente
    configurarValidacionFechas();
}
    </script>
@stop