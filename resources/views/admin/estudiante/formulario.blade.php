@extends('adminlte::page')

@section('title', 'Estudiante')

@section('content_header')
    @if(isset($estudiante))
        <h1>Editar Estudiante - {{ $estudiante->persona->primer_nombre ?? '' }} {{ $estudiante->persona->primer_apellido ?? '' }}</h1>
    @else
        <h1>Registrar Estudiante</h1>
    @endif
@stop

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        @if(isset($estudiante))
                            Editar Estudiante - {{ $estudiante->persona->primer_nombre ?? '' }} {{ $estudiante->persona->primer_apellido ?? '' }}
                        @else
                            Registrar Estudiante
                        @endif
                    </h3>
                    <a href="{{ route('admin.estudiante.inicio') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div id="formularioEstudiante">
                    <form id="estudiante-form" enctype="multipart/form-data" class="needs-validation" novalidate>
                        @csrf
                        <div id="contendorAlertaFormulario"></div>

                        <input type="hidden" id="id" name="id">
                        <div class="alert alert-info">
                            <strong><i class="fas fa-info-circle"></i> Información:</strong> Los campos con <span class="text-danger">(*)</span> son campos obligatorios a llenar
                        </div>

                        <!-- Sección Plantel de Procedencia -->
                        <div class="card border-primary mb-4">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0"><i class="fas fa-school"></i> Plantel de Procedencia</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="numero-zonificacion-plantel">Número de Zonificado</label>
                                            <input type="text" id="numero-zonificacion-plantel" pattern="[0-9]+"
                                                   title="Coloque el Número de Zonificación de la Institución Del Estudiante"
                                                   name="numero-zonificacion-plantel" class="form-control" maxlength="3">
                                            <small id="numero-zonificacion-plantel-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="intitucion-procedencia"><span class="text-danger">(*)</span> Institución</label>
                                            <div class="input-group">
                                                <select class="form-control select2" id="intitucion-procedencia" name="intitucion-procedencia"
                                                        aria-label="Seleccione la institución de procedencia" required>
                                                    <option value="">Seleccione una institución</option>
                                                    @foreach ($instituciones as $institucion)
                                                        <option value="{{ $institucion->id }}"
                                                            {{ old('intitucion-procedencia', $estudiante->institucion_id ?? '') == $institucion->id ? 'selected' : '' }}>
                                                            {{ $institucion->nombre_institucion }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-primary" onclick="abrirModalInstitucion()">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small id="intitucion-procedencia-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="expresion-literaria"><span class="text-danger">(*)</span> Literal</label>
                                            <select class="form-control select2" id="expresion-literaria"
                                                    title="Seleccione la Expresion Literaria Con la Que Salio El Estudiante De La Institución"
                                                    name="expresion-literaria" required>
                                                <option value=""></option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                            </select>
                                            <small id="expresion-literaria-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="año-egreso"><span class="text-danger">(*)</span> Fecha De Egreso</label>
                                            <input type="date" id="año-egreso" name="año-egreso" class="form-control"
                                                   title="Coloque la Fecha en la Que Egreso el Estudiante de la Primaria" required>
                                            <small id="año-egreso-error" class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Datos del Estudiante -->
                        <div class="card border-primary mb-4">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0"><i class="fas fa-user-graduate"></i> Datos del Estudiante</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="tipo-ci"><span class="text-danger">(*)</span> Documento</label>
                                            <select class="form-control select2" id="tipo-ci" name="tipo-ci" required>
                                                <option value=""></option>
                                                <option value="V">V</option>
                                                <option value="E">E</option>
                                            </select>
                                            <small id="tipo-ci-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="cedula"><span class="text-danger">(*)</span> Cédula</label>
                                            <input type="text" class="form-control" id="cedula" pattern="[0-9]+" name="cedula"
                                                   maxlength="8" title="Ingresa solamente numeros,no se permiten letras"
                                                   value="{{ isset($estudiante) ? $estudiante->persona->numero_cedula_persona : '' }}" required>
                                            <small id="cedula-error" class="text-danger" style="display: none;"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="fechaNacimiento"><span class="text-danger">(*)</span> Fecha de Nacimiento</label>
                                            <input type="date" id="fechaNacimiento" name="fechaNacimiento" class="form-control" required>
                                            <small id="fechaNacimiento-error" class="text-danger"></small>
                                            <small id="error-edad" class="text-danger d-none">La edad debe estar entre 10 y 17 años</small>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="edadNac">Edad</label>
                                            <input type="text" id="edadNac" name="edadNac" class="form-control" readonly>
                                            <small id="edadNac-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="mesesNac">Meses</label>
                                            <input type="text" id="mesesNac" name="mesesNac" class="form-control" readonly>
                                            <small id="mesesNac-error" class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="primer-nombre"><span class="text-danger">(*)</span> Primer Nombre</label>
                                            <input type="text" id="primer-nombre" name="primer-nombre" class="form-control"
                                                   pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios,no se aceptan números" required>
                                            <small id="primer-nombre-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="segundo-nombre">Segundo Nombre</label>
                                            <input type="text" id="segundo-nombre" name="segundo-nombre" class="form-control"
                                                   pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios,no se aceptan números">
                                            <small id="segundo-nombre-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tercer-nombre">Tercer Nombre</label>
                                            <input type="text" id="tercer-nombre" name="tercer-nombre" class="form-control"
                                                   pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios,no se aceptan números">
                                            <small id="tercer-nombre-error" class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="primer-apellido"><span class="text-danger">(*)</span> Primer Apellido</label>
                                            <input type="text" id="primer-apellido" name="primer-apellido" class="form-control"
                                                   pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios,no se aceptan números" required>
                                            <small id="primer-apellido-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="segundo-apellido">Segundo Apellido</label>
                                            <input type="text" id="segundo-apellido" name="segundo-apellido" class="form-control"
                                                   pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios,no se aceptan números">
                                            <small id="segundo-apellido-error" class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sexo"><span class="text-danger">(*)</span> Sexo</label>
                                            <select class="form-control select2" id="sexo" name="sexo" required>
                                                <option value="">Seleccione</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                            </select>
                                            <small id="sexo-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="lateralidad-estudiante"><span class="text-danger">(*)</span> Lateralidad</label>
                                            <select class="form-control select2" id="lateralidad-estudiante" name="lateralidad-estudiante" required>
                                                <option value="">Selección</option>
                                                <option value="izquierda">Izquierda</option>
                                                <option value="derecha">Derecha</option>
                                                <option value="ambidiestro">Ambidiestro</option>
                                            </select>
                                            <small id="lateralidad-estudiante-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="orden-nacimiento-estudiante"><span class="text-danger">(*)</span> Orden de Nacimiento</label>
                                            <select class="form-control select2" id="orden-nacimiento-estudiante" name="orden-nacimiento-estudiante" required>
                                                <option value=""></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                            </select>
                                            <small id="orden-nacimiento-estudiante-error" class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Lugar de Nacimiento -->
                        <div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="idEstado"><span class="text-danger">(*)</span> Estado</label>
            <select class="form-control select2" id="idEstado" name="idEstado"
                    onchange="cargarMunicipiosInputFormulario(this.value)" required>
                <option value="" selected>Seleccione un Estado</option>
                @foreach ($estados as $estado)
                    <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                @endforeach
            </select>
            <small id="idEstado-error" class="text-danger"></small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="idMunicipio"><span class="text-danger">(*)</span> Municipio</label>
            <select class="form-control select2" id="idMunicipio" onchange="cargarParroquiasInputFormulario(this.value)"
                    name="idMunicipio" required>
                <option value="">Seleccione un municipio</option>
            </select>
            <small id="idMunicipio-error" class="text-danger"></small>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="idparroquia"><span class="text-danger">(*)</span> Localidad</label>
            <div class="input-group">
                <select class="form-control select2" id="idparroquia" name="idparroquia" required>
                    <option value="">Seleccione una localidad</option>
                </select>
                <div class="input-group-append">
                    <button type="button" class="btn btn-primary" onclick="abrirModalLocalidad()">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <small id="idparroquia-error" class="text-danger"></small>
        </div>
    </div>
</div>

                        <!-- Sección Descripciones Físicas -->
                        <div class="card border-primary mb-4">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0"><i class="fas fa-ruler-combined"></i> Descripciones Físicas Del Estudiante</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="talla_estudiante">Talla del Estudiante (cm) <span class="text-danger">(*)</span></label>
                                            <select class="form-control select2" id="talla_estudiante" name="talla_estudiante" required>
                                                <option value="">Seleccione Estatura</option>
                                                @foreach(range(120, 180, 5) as $talla)
                                                    <option value="{{ $talla }}" {{ old('talla_estudiante') == $talla ? 'selected' : '' }}>
                                                        {{ $talla }} cm
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small id="talla_estudiante-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="peso_estudiante">Peso del Estudiante (kg) <span class="text-danger">(*)</span></label>
                                            <input type="number" class="form-control" id="peso_estudiante" name="peso_estudiante"
                                                   step="0.1" min="20" max="100" value="{{ old('peso_estudiante') }}"
                                                   placeholder="Ej: 45.5" required>
                                            <small id="peso_estudiante-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="talla_camisa">Talla Camisa <span class="text-danger">(*)</span></label>
                                            <select class="form-control select2" id="talla_camisa" name="talla_camisa" required>
                                                <option value="">Seleccione</option>
                                                <option value="XS">XS</option>
                                                <option value="S">S</option>
                                                <option value="M">M</option>
                                                <option value="L">L</option>
                                                <option value="XL">XL</option>
                                            </select>
                                            <small id="talla_camisa-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="talla_zapato">Talla Zapato <span class="text-danger">(*)</span></label>
                                            <select class="form-control select2" id="talla_zapato" name="talla_zapato" required>
                                                <option value="">Seleccione</option>
                                                @foreach(range(30, 45) as $talla)
                                                    <option value="{{ $talla }}" {{ old('talla_zapato') == $talla ? 'selected' : '' }}>
                                                        {{ $talla }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small id="talla_zapato-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="talla_pantalon">Talla Pantalón <span class="text-danger">(*)</span></label>
                                            <select class="form-control select2" id="talla_pantalon" name="talla_pantalon" required>
                                                <option value="">Seleccione</option>
                                                <option value="XS">XS</option>
                                                <option value="S">S</option>
                                                <option value="M">M</option>
                                                <option value="L">L</option>
                                                <option value="XL">XL</option>
                                            </select>
                                            <small id="talla_pantalon-error" class="text-danger"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Pertenencia Étnica -->
                        <div class="card border-primary mb-4">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0"><i class="fas fa-users"></i> Pertenencia Étnica</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Pertenece a Pueblo indígena? <span class="text-danger">(*)</span></label>
                                            <div class="d-flex">
                                                <div class="form-check mr-3">
                                                    <input class="form-check-input" type="radio" name="pueblo_indigena"
                                                           id="opcion_si" value="si">
                                                    <label class="form-check-label" for="opcion_si">
                                                        Si
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="pueblo_indigena"
                                                           id="opcion_no" value="no">
                                                    <label class="form-check-label" for="opcion_no">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                            <small id="pueblo_indigena-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div id="campo_pueblo_indigena" class="col-md-6" style="display: none">
                                        <div class="form-group">
                                            <label for="pueblo">A cual Pertenece:</label>
                                            <select class="form-control select2" id="pueblo" name="pueblo" aria-label="Pueblo indígena">
                                                <option value="">Seleccione una etnia</option>
                                                @foreach($etniasIndigenas as $etnia)
                                                    <option value="{{ $etnia->nombre }}"
                                                        {{ old('pueblo', isset($estudiante) ? $estudiante->cual_pueblo_indigna : '') == $etnia->nombre ? 'selected' : '' }}>
                                                        {{ $etnia->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small id="pueblo-error" class="text-danger d-none"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Salud y Dirección -->
                        <div class="card border-primary mb-4">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0"><i class="fas fa-heartbeat"></i> Salud Del Estudiante</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Presenta Discapacidad? <span class="text-danger">(*)</span></label>
                                            <div class="d-flex">
                                                <div class="form-check mr-3">
                                                    <input class="form-check-input" type="radio" name="salud_estudiante"
                                                           id="opcion_si_salud_estudiante" value="si">
                                                    <label class="form-check-label" for="opcion_si_salud_estudiante">
                                                        Si
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="salud_estudiante"
                                                           id="opcion_no_salud_estudiante" value="no">
                                                    <label class="form-check-label" for="opcion_no_salud_estudiante">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                            <small id="salud_estudiante-error" class="text-danger"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div id="discapacidad_estudiante" class="form-group" style="display: none">
                                            <label for="cual_discapacidad">Cual Discapacidad</label>
                                            <input type="text" id="cual_discapacidad" name="cual_discapacidad" class="form-control">
                                            <small id="cual_discapacidad-error" class="text-danger d-none"></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div id="documentos_estudiante" class="form-group" style="display: none">
                                            <label for="formFile" class="text-danger">
                                                En caso de ser afirmativo adjunte copia simple del informe medico (ACTUALIZADO):
                                            </label>
                                            <input class="form-control" type="file" id="formFile"
                                                   value="documentos_estudiante" name="documentos_estudiante" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="direccion_persona">Dirección Del Estudiante:</label>
                                            <textarea class="form-control" id="direccion_persona" name="direccion_persona" rows="3"
                                                      placeholder="Calle, Avenida, Número de Casa, etc...."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="card-footer text-right">
                            <button type="button" class="btn btn-primary" id="guardar" onclick="enviar()">
                                @if(isset($estudiante))
                                    <i class="fas fa-check"></i> Actualizar Estudiante
                                @else
                                    <i class="fas fa-save"></i> Guardar Estudiante
                                @endif
                            </button>
                            <a href="{{ route('admin.estudiante.inicio') }}" class="btn btn-danger">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modales institucion y localidad (se mantienen igual) -->


    <!-- Modal para agregar institución -->
<div class="modal fade" id="modalInstitucion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalInstitucionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tituloModalInstitucion">Agregar Nueva Institución</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <legend class="fs-5">Los campos con <span class="text-danger">(*)</span> son campos obligatorios</legend>
                <div id="contendorAlertaModalInstitucion"></div>
                <form id="institucion-form-modal">
                    @csrf
                    <input type="hidden" id="institucion_id_modal" name="id">

                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <span class="text-danger">(*)</span>Nombre de La Institución
                                </span>
                                <input type="text" id="nombre_institucion_modal" name="nombre_institucion"
                                    class="form-control" maxlength="255"
                                    placeholder="Ingrese el nombre de la institución" required>
                            </div>
                            <small id="nombre_institucion_modal-error" class="text-danger d-none"></small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <span class="text-danger">(*)</span>Estado
                                </span>
                                <select class="form-select" id="estado_id_modal" name="estado_id" required
                                    onchange="cargarMunicipiosModal(this.value)">
                                    <option value="">Seleccione un Estado</option>
                                    @foreach ($estados as $estado)
                                        <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small id="estado_id_modal-error" class="text-danger d-none"></small>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <span class="text-danger">(*)</span>Municipio
                                </span>
                                <select class="form-select" id="municipio_id_modal" name="municipio_id" required
                                    onchange="cargarParroquiasModal(this.value)">
                                    <option value="">Seleccione municipio</option>
                                </select>
                            </div>
                            <small id="municipio_id_modal-error" class="text-danger d-none"></small>
                        </div>

                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <span class="text-danger">(*)</span>Localidad
                                </span>
                                <select class="form-select" id="parroquia_id_modal" name="parroquia_id" required>
                                    <option value="">Seleccione parroquia</option>
                                </select>
                            </div>
                            <small id="parroquia_id_modal-error" class="text-danger d-none"></small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="guardarInstitucionModal()">
                    <i class="bi bi-save"></i> Guardar Institución
                </button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> Cancelar
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Modal para agregar localidad -->
<div class="modal fade" id="modalLocalidad" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalLocalidadLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="tituloModalLocalidad">Agregar Nueva Localidad</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <legend class="fs-5">Los campos con <span class="text-danger">(*)</span> son campos obligatorios</legend>
                <div id="contendorAlertaModalLocalidad"></div>
                <form id="localidad-form-modal">
                    @csrf
                    <input type="hidden" id="parroquia_id_modal" name="parroquia_id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <span class="text-danger">(*)</span>Estado
                                </span>
                                <select class="form-select" id="estado_id_modal_localidad" name="estado_id" required
                                    onchange="cargarMunicipiosModalLocalidad(this.value)">
                                    <option value="">Seleccione un Estado</option>
                                    @foreach ($estados as $estado)
                                        <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <small id="estado_id_modal_localidad-error" class="text-danger d-none"></small>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <span class="text-danger">(*)</span>Municipio
                                </span>
                                <select class="form-select" id="municipio_id_modal_localidad" name="municipio_id" required>
                                    <option value="">Seleccione municipio</option>
                                </select>
                            </div>
                            <small id="municipio_id_modal_localidad-error" class="text-danger d-none"></small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text">
                                    <span class="text-danger">(*)</span>Localidad
                                </span>
                                <input type="text" class="form-control" id="nombre_modal_localidad"
                                    name="nombre" maxlength="50" required placeholder="Ingrese el nombre de la localidad">
                            </div>
                            <small id="nombre_modal_localidad-error" class="text-danger d-none"></small>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="guardarLocalidadModal()">
                    <i class="bi bi-save"></i> Guardar Localidad
                </button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i> Cancelar
                </button>
            </div>
        </div>
    </div>
</div>


@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@stop

@section('js')


<!-- Select2 JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    // import axios from "axios";
    // ========== CONFIGURACIÓN INICIAL ==========
    window.verificarCedulaUrl = "{{ route('admin.estudiante.verificar-cedula') }}";
    const url_pantalla_principal_modulo_estudiante = "{{ route('admin.estudiante.inicio') }}";

    window.instituciones = @json($instituciones);
    window.estados = @json($estados);
    window.municipios = @json($municipios);
    window.localidades = @json($parroquias_cargadas);
    window.estudianteData = @json($estudiante ?? null);

    console.log('Configuración cargada:', {
        verificarCedulaUrl: window.verificarCedulaUrl,
        estudianteData: window.estudianteData ? 'Presente' : 'Ausente'
    });

    // ========== FUNCIONES DE UBICACIÓN ==========
    function cargarMunicipiosInputFormulario(estadoId) {
        console.log('=== INICIO cargarMunicipiosInputFormulario ===');
        console.log('Estado ID recibido:', estadoId);

        const $municipioSelect = $('#idMunicipio');
        const $localidadSelect = $('#idparroquia');

        $municipioSelect.html('<option value="">Cargando municipios...</option>');
        $localidadSelect.html('<option value="">Seleccione un municipio primero</option>');

        if (!estadoId || estadoId === '') {
            $municipioSelect.html('<option value="">Seleccione un estado primero</option>');
            return;
        }

        try {
            const municipiosFiltrados = window.municipios.filter(municipio =>
                parseInt(municipio.estado_id) === parseInt(estadoId)
            );

            console.log('Municipios encontrados:', municipiosFiltrados.length);

            if (municipiosFiltrados.length > 0) {
                let options = '<option value="">Seleccione un municipio</option>';
                municipiosFiltrados.forEach((municipio) => {
                    const id = municipio.id || '';
                    const nombre = municipio.nombre_municipio || 'Sin nombre';
                    options += `<option value="${id}">${nombre}</option>`;
                });

                $municipioSelect.html(options);
                $municipioSelect.trigger('change.select2');
            } else {
                $municipioSelect.html('<option value="">No hay municipios disponibles</option>');
            }
        } catch (error) {
            console.error('Error al cargar municipios:', error);
            $municipioSelect.html('<option value="">Error al cargar municipios</option>');
        }
    }

    function cargarParroquiasInputFormulario(municipioId) {
        console.log('=== INICIO cargarParroquiasInputFormulario ===');
        console.log('Municipio ID:', municipioId);

        const $localidadSelect = $('#idparroquia');
        $localidadSelect.html('<option value="">Cargando localidades...</option>');

        if (!municipioId) {
            $localidadSelect.html('<option value="">Seleccione un municipio primero</option>');
            return;
        }

        try {
            const localidadesFiltradas = window.localidades.filter(localidad =>
                parseInt(localidad.municipio_id) === parseInt(municipioId)
            );

            console.log('Localidades encontradas:', localidadesFiltradas.length);

            if (localidadesFiltradas.length > 0) {
                let options = '<option value="">Seleccione una localidad</option>';
                localidadesFiltradas.forEach(localidad => {
                    const id = localidad.id || '';
                    const nombre = localidad.nombre_localidad || 'Sin nombre';
                    options += `<option value="${id}">${nombre}</option>`;
                });

                $localidadSelect.html(options);
                $localidadSelect.trigger('change.select2');
            } else {
                $localidadSelect.html('<option value="">No hay localidades disponibles</option>');
            }
        } catch (error) {
            console.error('Error al cargar localidades:', error);
            $localidadSelect.html('<option value="">Error al cargar localidades</option>');
        }
    }

    // ========== FUNCIONES DE RADIOS (CAMPOS CONDICIONALES) ==========
    function manejarPuebloIndigena() {
        $('input[name="pueblo_indigena"]').change(function() {
            const valor = $(this).val();
            const mostrar = valor === 'si';
            console.log('Pueblo indígena cambio:', valor, 'Mostrar:', mostrar);

            if (mostrar) {
                $('#campo_pueblo_indigena').show();
                $('#pueblo').prop('required', true);
                if ($('#pueblo').hasClass('select2-hidden-accessible')) {
                    $('#pueblo').trigger('change.select2');
                }
            } else {
                $('#campo_pueblo_indigena').hide();
                $('#pueblo').prop('required', false).val('');
                if ($('#pueblo').hasClass('select2-hidden-accessible')) {
                    $('#pueblo').trigger('change.select2');
                }
            }
        });
    }

    function manejarDiscapacidad() {
        $('input[name="salud_estudiante"]').change(function() {
            const valor = $(this).val();
            const mostrar = valor === 'si';
            console.log('Salud estudiante cambio:', valor, 'Mostrar:', mostrar);

            if (mostrar) {
                $('#discapacidad_estudiante').show();
                $('#documentos_estudiante').show();
                $('#cual_discapacidad').prop('required', true);
                $('#formFile').prop('required', true);
            } else {
                $('#discapacidad_estudiante').hide();
                $('#documentos_estudiante').hide();
                $('#cual_discapacidad').prop('required', false).val('');
                $('#formFile').prop('required', false).val('');
            }
        });
    }

    function aplicarEstadoInicialRadios() {
        // Pueblo indígena
        const valorPueblo = $('input[name="pueblo_indigena"]:checked').val();
        if (valorPueblo === 'si') {
            $('#campo_pueblo_indigena').show();
            $('#pueblo').prop('required', true);
        } else {
            $('#campo_pueblo_indigena').hide();
            $('#pueblo').prop('required', false);
        }

        // Discapacidad
        const valorSalud = $('input[name="salud_estudiante"]:checked').val();
        if (valorSalud === 'si') {
            $('#discapacidad_estudiante').show();
            $('#documentos_estudiante').show();
            $('#cual_discapacidad').prop('required', true);
            $('#formFile').prop('required', true);
        } else {
            $('#discapacidad_estudiante').hide();
            $('#documentos_estudiante').hide();
            $('#cual_discapacidad').prop('required', false);
            $('#formFile').prop('required', false);
        }
    }

    // ========== AUTOLLENADO PARA EDICIÓN ==========
    function autoLlenarFormularioEdicion() {
        console.log("=== INICIANDO AUTOLLENADO ===");

        if (!window.estudianteData) {
            console.error("No hay datos del estudiante");
            return;
        }

        const estudiante = window.estudianteData;
        const persona = estudiante.persona;

        if (!persona) {
            console.error("No hay datos de persona");
            return;
        }

        console.log("Datos válidos encontrados");

        // Llenar ID
        const idField = document.getElementById('id');
        if (idField) {
            idField.value = persona.id || '';
        }

        // Llenar campos básicos
        const camposAdicionales = [
            // Campos del estudiante
            { id: 'numero-zonificacion-plantel', valor: estudiante.numero_zonificacion_plantel },
            { id: 'intitucion-procedencia', valor: estudiante.institucion_id },
            { id: 'expresion-literaria', valor: estudiante.expresion_literaria },
            { id: 'año-egreso', valor: estudiante.ano_ergreso_estudiante },
            { id: 'orden-nacimiento-estudiante', valor: estudiante.orden_nacimiento_estudiante },
            { id: 'talla_estudiante', valor: estudiante.talla_estudiante },
            { id: 'peso_estudiante', valor: estudiante.peso_estudiante },
            { id: 'talla_camisa', valor: estudiante.talla_camisa },
            { id: 'talla_zapato', valor: estudiante.talla_zapato },
            { id: 'talla_pantalon', valor: estudiante.talla_pantalon },

            // Campos de la persona
            { id: 'tipo-ci', valor: persona.tipo_cedula_persona },
            { id: 'cedula', valor: persona.numero_cedula_persona },
            { id: 'fechaNacimiento', valor: persona.fecha_nacimiento_personas },
            { id: 'primer-nombre', valor: persona.primer_nombre },
            { id: 'segundo-nombre', valor: persona.segundo_nombre },
            { id: 'tercer-nombre', valor: persona.tercer_nombre },
            { id: 'primer-apellido', valor: persona.primer_apellido },
            { id: 'segundo-apellido', valor: persona.segundo_apellido },
            { id: 'sexo', valor: persona.sexo },
            { id: 'lateralidad-estudiante', valor: estudiante.lateralidad_estudiante },
            { id: 'direccion_persona', valor: persona.direccion_persona }
        ];

        camposAdicionales.forEach(campo => {
            const elemento = document.getElementById(campo.id);
            if (elemento) {
                elemento.value = campo.valor || '';
            }
        });

        // Pueblo indígena
        if (estudiante.cual_pueblo_indigna) {
            $('#opcion_si').prop('checked', true);
            setTimeout(() => {
                $('#opcion_si').trigger('change');
                $('#pueblo').val(estudiante.cual_pueblo_indigna).trigger('change');
            }, 100);
        } else {
            $('#opcion_no').prop('checked', true);
            setTimeout(() => {
                $('#opcion_no').trigger('change');
            }, 100);
        }

        // Discapacidad
        if (estudiante.discapacidad_estudiante) {
            $('#opcion_si_salud_estudiante').prop('checked', true);
            setTimeout(() => {
                $('#opcion_si_salud_estudiante').trigger('change');
                $('#cual_discapacidad').val(estudiante.discapacidad_estudiante);
            }, 150);
        } else {
            $('#opcion_no_salud_estudiante').prop('checked', true);
            setTimeout(() => {
                $('#opcion_no_salud_estudiante').trigger('change');
            }, 150);
        }

        // Lugar de nacimiento
        if (estudiante.estado_id && document.getElementById('idEstado')) {
            document.getElementById('idEstado').value = estudiante.estado_id;

            setTimeout(() => {
                if (typeof cargarMunicipiosInputFormulario === 'function') {
                    cargarMunicipiosInputFormulario(estudiante.estado_id);

                    setTimeout(() => {
                        if (estudiante.municipio_id && document.getElementById('idMunicipio')) {
                            document.getElementById('idMunicipio').value = estudiante.municipio_id;

                            setTimeout(() => {
                                if (typeof cargarParroquiasInputFormulario === 'function') {
                                    cargarParroquiasInputFormulario(estudiante.municipio_id);

                                    setTimeout(() => {
                                        if (estudiante.localidad_id && document.getElementById('idparroquia')) {
                                            document.getElementById('idparroquia').value = estudiante.localidad_id;
                                        }
                                    }, 1000);
                                }
                            }, 800);
                        }
                    }, 600);
                }
            }, 400);
        }

        console.log("Autollenado completado");
    }

    // ========== INICIALIZACIÓN PRINCIPAL ==========
    $(document).ready(function() {
        console.log('=== INICIALIZACIÓN ===');

        // Inicializar select2
        $('.select2').each(function() {
            $(this).select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: 'Seleccione una opción',
                allowClear: true,
                dropdownParent: $(this).closest('.modal').length ? $(this).closest('.modal') : $(document.body)
            });
        });

        // Eventos para selects de ubicación
        $('#idEstado').change(function() {
            const estadoId = $(this).val();
            cargarMunicipiosInputFormulario(estadoId);
        });

        $('#idMunicipio').change(function() {
            const municipioId = $(this).val();
            cargarParroquiasInputFormulario(municipioId);
        });

        // Configurar eventos de radios
        manejarPuebloIndigena();
        manejarDiscapacidad();

        // Aplicar estado inicial de radios
        aplicarEstadoInicialRadios();

        // Validación de cédula
        $('input[name="cedula"]').on('input', function() {
            $(this).val($(this).val().replace(/[^0-9]/g, '').substring(0, 8));
        });

        // Auto-llenado si estamos en modo edición
        if (window.estudianteData) {
            console.log('MODO EDICIÓN - Cargando datos del estudiante');
            setTimeout(() => {
                autoLlenarFormularioEdicion();
            }, 500);
        } else {
            console.log('NUEVO REGISTRO - Formulario limpio');
        }

        console.log('✅ Inicialización completada');
    });

    // ========== FUNCIONES GLOBALES ==========
    window.cargarMunicipiosInputFormulario = cargarMunicipiosInputFormulario;
    window.cargarParroquiasInputFormulario = cargarParroquiasInputFormulario;

    function enviar() {
        console.log('Enviando formulario...');
    }

    // function abrirModalInstitucion() {
    //     console.log('Abriendo modal de institución');
    // }
    function abrirModalInstitucion() {
        console.log("Abriendo modal de institución");

        // Limpiar el formulario del modal
        document.getElementById('institucion-form-modal').reset();
        document.getElementById('contendorAlertaModalInstitucion').innerHTML = '';

        // Limpiar mensajes de error
        limpiarErroresModal();

        // Limpiar selects de municipio y parroquia
        document.getElementById('municipio_id_modal').innerHTML = '<option value="">Seleccione municipio</option>';
        document.getElementById('parroquia_id_modal').innerHTML = '<option value="">Seleccione parroquia</option>';

        // Mostrar el modal
        const modal = new bootstrap.Modal(document.getElementById('modalInstitucion'));
        modal.show();
    }

    // Función para limpiar errores del modal
    function limpiarErroresModal() {
        const errorElements = document.querySelectorAll('[id$="-modal-error"]');
        errorElements.forEach(element => {
            element.textContent = '';
            element.classList.add('d-none');
        });
    }

    // function abrirModalLocalidad() {
    //     console.log('Abriendo modal de localidad');
    // }

    function abrirModalLocalidad() {
    console.log("Abriendo modal de localidad");

    // Limpiar el formulario del modal
    document.getElementById('localidad-form-modal').reset();
    document.getElementById('contendorAlertaModalLocalidad').innerHTML = '';

    // Limpiar mensajes de error
    limpiarErroresModalLocalidad();

    // Limpiar selects de municipio
    document.getElementById('municipio_id_modal_localidad').innerHTML = '<option value="">Seleccione municipio</option>';

    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalLocalidad'));
    modal.show();
}

// Función para limpiar errores del modal de localidad
function limpiarErroresModalLocalidad() {
    const errorElements = document.querySelectorAll('[id$="-modal_localidad-error"]');
    errorElements.forEach(element => {
        element.textContent = '';
        element.classList.add('d-none');
    });
}

    // ========== FUNCIÓN DE PRUEBA ==========
    function probarRadios() {
        console.log("=== PROBANDO RADIOS ===");
        
        console.log("Probando Pueblo Indígena - SI");
        $('#opcion_si').prop('checked', true).trigger('change');
        
        setTimeout(() => {
            console.log("Probando Pueblo Indígena - NO");
            $('#opcion_no').prop('checked', true).trigger('change');
        }, 2000);
        
        setTimeout(() => {
            console.log("Probando Discapacidad - SI");
            $('#opcion_si_salud_estudiante').prop('checked', true).trigger('change');
        }, 4000);
        
        setTimeout(() => {
            console.log("Probando Discapacidad - NO");
            $('#opcion_no_salud_estudiante').prop('checked', true).trigger('change');
        }, 6000);
    }

    window.probarRadios = probarRadios;
</script>

<!-- EL RESTO DE TU CÓDIGO DE MODALES SE MANTIENE IGUAL -->
<script>
    // Tu código de modales aquí (sin cambios)

    function abrirModalLocalidad() {
    console.log("Abriendo modal de localidad");

    // Limpiar el formulario del modal
    document.getElementById('localidad-form-modal').reset();
    document.getElementById('contendorAlertaModalLocalidad').innerHTML = '';

    // Limpiar mensajes de error
    limpiarErroresModalLocalidad();

    // Limpiar selects de municipio
    document.getElementById('municipio_id_modal_localidad').innerHTML = '<option value="">Seleccione municipio</option>';

    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalLocalidad'));
    modal.show();
}

// Función para limpiar errores del modal de localidad
function limpiarErroresModalLocalidad() {
    const errorElements = document.querySelectorAll('[id$="-modal_localidad-error"]');
    errorElements.forEach(element => {
        element.textContent = '';
        element.classList.add('d-none');
    });
}

    // ========== FUNCIONES DE UBICACIÓN PARA MODALES ==========
    function cargarMunicipiosModal(estadoId) {
        console.log('=== INICIO cargarMunicipiosModal ===');
        console.log('Estado ID recibido:', estadoId);

        const $municipioSelect = $('#municipio_id_modal');
        const $parroquiaSelect = $('#parroquia_id_modal');

        // Limpiar selects dependientes
        $municipioSelect.html('<option value="">Seleccione municipio</option>');
        $parroquiaSelect.html('<option value="">Seleccione parroquia</option>');

        if (!estadoId) return;

        try {
            const municipiosFiltrados = window.municipios.filter(municipio =>
                parseInt(municipio.estado_id) === parseInt(estadoId)
            );

            console.log('Municipios encontrados para modal:', municipiosFiltrados.length);

            if (municipiosFiltrados.length > 0) {
                municipiosFiltrados.forEach(municipio => {
                    const option = document.createElement('option');
                    option.value = municipio.id;
                    option.textContent = municipio.nombre_municipio || 'Sin nombre';
                    $municipioSelect[0].appendChild(option);
                });
                $municipioSelect.trigger('change.select2');
            }
        } catch (error) {
            console.error('Error al cargar municipios en modal:', error);
        }
    }

    function cargarParroquiasModal(municipioId) {
        console.log('=== INICIO cargarParroquiasModal ===');
        console.log('Municipio ID:', municipioId);

        const $parroquiaSelect = $('#parroquia_id_modal');
        $parroquiaSelect.html('<option value="">Seleccione localidad</option>');

        if (!municipioId) return;

        try {
            const localidadesFiltradas = window.localidades.filter(localidad =>
                parseInt(localidad.municipio_id) === parseInt(municipioId)
            );

            console.log('Localidades encontradas para modal:', localidadesFiltradas.length);

            if (localidadesFiltradas.length > 0) {
                localidadesFiltradas.forEach(localidad => {
                    const option = document.createElement('option');
                    option.value = localidad.id;
                    option.textContent = localidad.nombre_localidad || 'Sin nombre';
                    $parroquiaSelect[0].appendChild(option);
                });
                $parroquiaSelect.trigger('change.select2');
            }
        } catch (error) {
            console.error('Error al cargar parroquias en modal:', error);
        }
    }

    function cargarMunicipiosModalLocalidad(estadoId) {
        console.log('=== INICIO cargarMunicipiosModalLocalidad ===');
        console.log('Estado ID recibido:', estadoId);

        const $municipioSelect = $('#municipio_id_modal_localidad');

        // Limpiar select de municipio
        $municipioSelect.html('<option value="">Seleccione municipio</option>');

        if (!estadoId) return;

        try {
            const municipiosFiltrados = window.municipios.filter(municipio =>
                parseInt(municipio.estado_id) === parseInt(estadoId)
            );

            console.log('Municipios encontrados para modal localidad:', municipiosFiltrados.length);

            if (municipiosFiltrados.length > 0) {
                municipiosFiltrados.forEach(municipio => {
                    const option = document.createElement('option');
                    option.value = municipio.id;
                    option.textContent = municipio.nombre_municipio || 'Sin nombre';
                    $municipioSelect[0].appendChild(option);
                });
                $municipioSelect.trigger('change.select2');
            }
        } catch (error) {
            console.error('Error al cargar municipios en modal localidad:', error);
        }
    }
// ----------------------------------------------

//   let cedulaValida = true;
// window.enviar = () => {
//     if (!cedulaValida) {
//         console.error('No se puede enviar el formulario - cédula duplicada');
//         mostrarAlertaError("No se puede guardar el estudiante. La cédula ya está registrada en el sistema.", "danger", "contendorAlertaFormulario");
        
//         const cedulaInput = document.getElementById('cedula');
//         if (cedulaInput) {
//             cedulaInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
//             cedulaInput.focus();
//         }
//         return;
//     }

//     const loader = document.getElementById("contenedorLoader");
//     if (loader) {
//         loader.classList.add("mostrar-loader");
//     }

//     let formulario = document.getElementById("estudiante-form");
//     const data = new FormData(formulario);

//     // Agregar token CSRF
//     const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
//     if (csrfToken) {
//         data.append('_token', csrfToken);
//     }

//     axios.post("/app/estudiante/save", data, {
//         headers: {
//             'Content-Type': 'multipart/form-data',
//             'X-Requested-With': 'XMLHttpRequest'
//         }
//     })
//     .then(res => {
//         if (loader) loader.classList.remove("mostrar-loader");
//         console.log("Éxito:", res.data);
//         mostrarAlertaError("Estudiante guardado exitosamente", "success", "contendorAlertaFormulario");
        
//         // Redirigir al formulario de representante con el ID del estudiante
//         // irHa(url_pantalla_formulario_representante + `?estudiante_id=${res.data.data.estudiante.id}`);
//         alert("Estudiante guardado exitosamente");
//         console.log("Datos del estudiante:", res.data.data.estudiante);
//         console.log("ID del estudiante:", res.data.data.estudiante.id);
//         console.log("Todo el response:", res.data);
//         console.log("Estado del response:", res.status);
//         console.log("Headers del response:", res.headers);
//     })
//     .catch(error => {
//         if (loader) loader.classList.remove("mostrar-loader");
//         console.error("Error:", error.response?.data);

//         let mensajeError = "Error al guardar el estudiante";
//         if (error.response?.data?.message) {
//             mensajeError = error.response.data.message;
//         }

//         mostrarAlertaError(mensajeError, "danger", "contendorAlertaFormulario");
//     });
// };

let cedulaValida = true;
window.enviar = () => {
    if (!cedulaValida) {
        console.error('No se puede enviar el formulario - cédula duplicada');
        mostrarAlertaError("No se puede guardar el estudiante. La cédula ya está registrada en el sistema.", "danger", "contendorAlertaFormulario");
        
        const cedulaInput = document.getElementById('cedula');
        if (cedulaInput) {
            cedulaInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            cedulaInput.focus();
        }
        return;
    }

    const loader = document.getElementById("contenedorLoader");
    if (loader) {
        loader.classList.add("mostrar-loader");
    }

    let formulario = document.getElementById("estudiante-form");
    const data = new FormData(formulario);

    // Agregar token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (csrfToken) {
        data.append('_token', csrfToken);
    }

    // Usando fetch en lugar de axios
    fetch("/admin/estudiante/save", {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        },
        body: data
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        return response.json();
    })
    .then(res => {
        if (loader) loader.classList.remove("mostrar-loader");
        console.log("Éxito:", res);
        mostrarAlertaError("Estudiante guardado exitosamente", "success", "contendorAlertaFormulario");
        
        // Redirigir al formulario de representante con el ID del estudiante
        // irHa(url_pantalla_formulario_representante + `?estudiante_id=${res.data.estudiante.id}`);
        alert("Estudiante guardado exitosamente");
        console.log("Datos del estudiante:", res.data?.estudiante);
        console.log("ID del estudiante:", res.data?.estudiante?.id);
        console.log("Todo el response:", res);
        console.log("Estado del response:", res.status);
    })
    .catch(error => {
        if (loader) loader.classList.remove("mostrar-loader");
        console.error("Error:", error);

        // Intentar parsear el error si viene como JSON
        if (error.message.includes('Error HTTP:')) {
            error.response?.json().then(errorData => {
                let mensajeError = errorData?.message || "Error al guardar el estudiante";
                mostrarAlertaError(mensajeError, "danger", "contendorAlertaFormulario");
            }).catch(() => {
                mostrarAlertaError("Error al guardar el estudiante", "danger", "contendorAlertaFormulario");
            });
        } else {
            mostrarAlertaError("Error de conexión: " + error.message, "danger", "contendorAlertaFormulario");
        }
    });
};

</script>
@stop