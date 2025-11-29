       {{-- Modal Editar Representante --}}
<div class="modal fade" id="modalEditarRepresentante" tabindex="-1" aria-labelledby="modalEditarRepresentanteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content modal-modern">

            <div class="modal-header-edit">
                <div class="modal-icon-edit">
                    <i class="fas fa-pen"></i>
                </div>
                <h5 class="modal-title-edit" id="modalEditarRepresentanteLabel">Editar Representante</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="modal-body-edit">
                <form id="form-editar-representante" action="{{ route('representante.save') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" id="representante_legal_id" name="representante_legal_id">

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
                            <input type="text" class="form-control" id="otra-ocupacion-representante" name="otra-ocupacion-representante"
                                aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" pattern="[A-Za-záéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios,no se aceptan números" required>
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
                </div>                                                   <div class="row" id="row-conectividad">
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

                                                {{-- Sección de datos legales del representante --}}
                                                <div id="section-legal-representante">

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
                                                                <select class="form-select" id="carnet-patria" name="carnet-patria" required>
                                                                    <option value="">Seleccione</option>
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
                                                                    aria-describedby="inputGroup-sizing-default" maxlength="10" pattern="[0-9]+" title="Ingresa solamente numeros,no se permiten letras" required>
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
                                                                            aria-describedby="inputGroup-sizing-default" maxlength="9" pattern="[0-9]+" title="Ingresa solamente números, máximo 9 dígitos" required>
                                                                    </div>
                                                                    <small id="serial-error" class="text-danger" ></small>
                                                                </div>

                                                                <div class="col-md-4 mb-3">
                                                                    <div class="input-group mb-3">
                                                                        <label class="input-group-text" for="inputGroupSelect01"><span
                                                                                class="text-danger">(*)</span>Tipo de Cuenta:</label>
                                                                        <select class="form-select" id="tipo-cuenta" name="tipo-cuenta" required>
                                                                            <option value="">Seleccione</option>
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
                                                                        <select class="form-select" id="banco-representante" name="banco-representante" required>
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
                                                                        <textarea class="form-control" id="direccion-habitacion" name="direccion-habitacion" rows="3" maxlength="100" title="Coloque su Dirección Calle, Avenida..." placeholder="E.j : Barrio Araguaney Avenida 5 calle 9" required></textarea>
                                                                        <small id="direccion-habitacion-error" class="text-danger"></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div> {{-- fin section-legal-representante --}}
                    </div>

                </form>
            </div>

            <div class="modal-footer-edit">
                <div class="footer-buttons">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="form-editar-representante" class="btn-modal-edit">Guardar cambios</button>
                </div>
            </div>

        </div>
    </div>
</div>