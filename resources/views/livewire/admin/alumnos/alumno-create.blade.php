<div>
    {{-- Alertas --}}
    @if (session()->has('success') || session()->has('error'))
        <div class="alerts-container mb-3">
            @if (session()->has('success'))
                <div class="alert-modern alert-success alert alert-dismissible fade show">
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

            @if (session()->has('error'))
                <div class="alert-modern alert-error alert alert-dismissible fade show">
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

    <form wire:submit.prevent="save">
        {{-- Card: Plantel de Procedencia --}}
        <div class="card-modern mb-4">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon">
                        <i class="fas fa-school"></i>
                    </div>
                    <div>
                        <h3>Plantel de Procedencia</h3>
                        <p>Información de la institución de origen</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern" style="padding: 2rem;">
                <div class="alert alert-info mb-4" style="background: var(--info-light); border-left: 4px solid var(--info); padding: 1rem; border-radius: 8px;">
                    <i class="fas fa-info-circle"></i> Los campos con <span class="text-danger" style="font-weight: 700;">(*)</span> son obligatorios
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="numero_zonificacion" class="form-label-modern">
                                <i class="fas fa-hashtag"></i>
                                Número de Zonificado
                            </label>
                            <input type="text" 
                            inputmode="numeric"
                                   wire:model="numero_zonificacion" 
                                   class="form-control-modern @error('numero_zonificacion') is-invalid @enderror"
                                   min="0"
                                   pattern="[0-9]+" 
                                   maxlength="3" 
                                   oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                                   placeholder="Ej: 001">
                            @error('numero_zonificacion')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="institucion_procedencia_id" class="form-label-modern">
                                <i class="fas fa-building"></i>
                                Institución
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model="institucion_procedencia_id" 
                                    class="form-control-modern @error('institucion_procedencia_id') is-invalid @enderror">
                                <option value="">Seleccione una institución</option>
                                @foreach($instituciones as $inst)
                                    <option value="{{ $inst->id }}">{{ $inst->nombre_institucion }}</option>
                                @endforeach
                            </select>
                            @error('institucion_procedencia_id')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="expresion_literaria" class="form-label-modern">
                                <i class="fas fa-font"></i>
                                Literal
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model="expresion_literaria_id"
                                class="form-control-modern @error('expresion_literaria_id') is-invalid @enderror">
                            <option value="">Seleccione</option>
                            @foreach($expresiones_literarias as $item)
                                <option value="{{ $item->id }}">{{ $item->letra_expresion_literaria }}</option>
                            @endforeach
                        </select>

                        @error('expresion_literaria_id')
                            <div class="invalid-feedback-modern">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="anio_egreso" class="form-label-modern">
                                <i class="fas fa-calendar"></i>
                                Egreso
                                <span class="required-badge">*</span>
                            </label>
                            <input type="date" 
                                   wire:model="anio_egreso" 
                                   class="form-control-modern @error('anio_egreso') is-invalid @enderror">
                            @error('anio_egreso')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Datos del Estudiante --}}
        <div class="card-modern mb-4">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon" style="background: linear-gradient(135deg, var(--success), #059669);">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div>
                        <h3>Datos del Estudiante</h3>
                        <p>Información personal del estudiante</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern" style="padding: 2rem;">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="tipo_ci" class="form-label-modern">
                                <i class="fas fa-id-card"></i>
                                Doc.
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model="tipo_documento_id" 
                                    class="form-control-modern @error('tipo_documento_id') is-invalid @enderror">
                                <option value="">Seleccione</option>
                                @foreach($tipos_documentos as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('tipo_documento_id')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="cedula" class="form-label-modern">
                                <i class="fas fa-id-card"></i>
                                Cédula
                                <span class="required-badge">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="cedula" 
                                   class="form-control-modern @error('cedula') is-invalid @enderror"
                                   maxlength="8"
                                   pattern="[0-9]+" 
                                   oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                                   inputmode="numeric"
                                   placeholder="12345678">
                            @error('cedula')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_nacimiento" class="form-label-modern">
                                <i class="fas fa-birthday-cake"></i>
                                Fecha de Nacimiento
                                <span class="required-badge">*</span>
                            </label>
                            <input type="date" 
                                   wire:model="fecha_nacimiento"
                                   class="form-control-modern @error('fecha_nacimiento') is-invalid @enderror">
                            @error('fecha_nacimiento')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label-modern">
                                <i class="fas fa-calendar-alt"></i>
                                Edad
                            </label>
                            <input type="text" 
                                   wire:model="edad" 
                                   class="form-control-modern" 
                                   readonly>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label-modern">
                                <i class="fas fa-calendar"></i>
                                Meses
                            </label>
                            <input type="text" 
                                   wire:model="meses" 
                                   class="form-control-modern" 
                                   readonly>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="primer_nombre" class="form-label-modern">
                                <i class="fas fa-user"></i>
                                Primer Nombre
                                <span class="required-badge">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="primer_nombre" 
                                   class="form-control-modern @error('primer_nombre') is-invalid @enderror"
                                   placeholder="Primer nombre">
                            @error('primer_nombre')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="segundo_nombre" class="form-label-modern">
                                <i class="fas fa-user"></i>
                                Segundo Nombre
                            </label>
                            <input type="text" 
                                   wire:model="segundo_nombre" 
                                   class="form-control-modern"
                                   placeholder="Segundo nombre">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tercer_nombre" class="form-label-modern">
                                <i class="fas fa-user"></i>
                                Tercer Nombre
                            </label>
                            <input type="text" 
                                   wire:model="tercer_nombre" 
                                   class="form-control-modern"
                                   placeholder="Tercer nombre">
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="primer_apellido" class="form-label-modern">
                                <i class="fas fa-user"></i>
                                Primer Apellido
                                <span class="required-badge">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="primer_apellido" 
                                   class="form-control-modern @error('primer_apellido') is-invalid @enderror"
                                   placeholder="Primer apellido">
                            @error('primer_apellido')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="segundo_apellido" class="form-label-modern">
                                <i class="fas fa-user"></i>
                                Segundo Apellido
                            </label>
                            <input type="text" 
                                   wire:model="segundo_apellido" 
                                   class="form-control-modern"
                                   placeholder="Segundo apellido">
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="genero" class="form-label-modern">
                                <i class="fas fa-venus-mars"></i>
                                Genero
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model="genero_id" 
                                    class="form-control-modern @error('genero_id') is-invalid @enderror">
                                <option value="">Seleccione</option>
                                @foreach($generos as $item)
                                    <option value="{{ $item->id }}">{{ $item->genero }}</option>
                                @endforeach
                            </select>
                            @error('genero_id')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="lateralidad" class="form-label-modern">
                                <i class="fas fa-hand-paper"></i>
                                Lateralidad
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model="lateralidad_id" 
                                    class="form-control-modern @error('lateralidad_id') is-invalid @enderror">
                                <option value="">Seleccione</option>
                                @foreach($lateralidades as $item)
                                    <option value="{{ $item->id }}">{{ $item->lateralidad }}</option>
                                @endforeach
                            </select>
                            @error('lateralidad_id')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="orden_nacimiento" class="form-label-modern">
                                <i class="fas fa-sort-numeric-up"></i>
                                Orden de Nacimiento
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model="orden_nacimiento_id" 
                                    class="form-control-modern @error('orden_nacimiento_id') is-invalid @enderror">
                                <option value="">Seleccione</option>
                                @foreach($orden_nacimientos as $item)
                                    <option value="{{ $item->id }}">{{ $item->orden_nacimiento }}</option>
                                @endforeach
                            </select>
                            @error('orden_nacimiento_id')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Lugar de Nacimiento --}}
        <div class="card-modern mb-4">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon" style="background: linear-gradient(135deg, var(--warning), #d97706);">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h3>Lugar de Nacimiento</h3>
                        <p>Ubicación geográfica del estudiante</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern" style="padding: 2rem;">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="estado_id" class="form-label-modern">
                                <i class="fas fa-map"></i>
                                Estado
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model.live="estado_id"
                                    class="form-control-modern @error('estado_id') is-invalid @enderror">
                                <option value="">Seleccione un estado</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                                @endforeach
                            </select>
                            @error('estado_id')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="municipio_id" class="form-label-modern">
                                <i class="fas fa-map-marked-alt"></i>
                                Municipio
                                <span class="required-badge">*</span>
                            </label>
                            <select  wire:model.live="municipio_id"
                                    class="form-control-modern @error('municipio_id') is-invalid @enderror">
                                <option value="">Seleccione un municipio</option>
                                @foreach($municipios as $municipio)
                                    <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
                                @endforeach
                            </select>
                            @error('municipio_id')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="localidad_id" class="form-label-modern">
                                <i class="fas fa-map-pin"></i>
                                Localidad
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model.live="localidad_id" 
                                    class="form-control-modern @error('localidad_id') is-invalid @enderror">
                                <option value="">Seleccione una localidad</option>
                                @foreach($localidades as $localidad)
                                    <option value="{{ $localidad->id }}">{{ $localidad->nombre_localidad }}</option>
                                @endforeach
                            </select>
                            @error('localidad_id')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTINUACIÓN DEL FORMULARIO --}}

        {{-- Card: Descripciones Físicas --}}
        <div class="card-modern mb-4">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon" style="background: linear-gradient(135deg, #8b5cf6, #6d28d9);">
                        <i class="fas fa-ruler-combined"></i>
                    </div>
                    <div>
                        <h3>Descripciones Físicas del Estudiante</h3>
                        <p>Medidas y tallas del estudiante</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern" style="padding: 2rem;">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="talla_estudiante" class="form-label-modern">
                                <i class="fas fa-ruler-vertical"></i>
                                Talla (cm)
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model="talla_estudiante" 
                                    class="form-control-modern @error('talla_estudiante') is-invalid @enderror">
                                <option value="">Seleccione estatura</option>
                                @foreach(range(120, 180, 5) as $talla)
                                    <option value="{{ $talla }}">{{ $talla }} cm</option>
                                @endforeach
                            </select>
                            @error('talla_estudiante')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="peso_estudiante" class="form-label-modern">
                                <i class="fas fa-weight"></i>
                                Peso (kg)
                                <span class="required-badge">*</span>
                            </label>
                            <input type="number" 
                                   wire:model="peso_estudiante" 
                                   class="form-control-modern @error('peso_estudiante') is-invalid @enderror"
                                   step="0.1"
                                   min="20"
                                   max="100"
                                   placeholder="Ej: 45.5">
                            @error('peso_estudiante')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="talla_camisa" class="form-label-modern">
                                <i class="fas fa-tshirt"></i>
                                Talla Camisa
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model="talla_camisa" 
                                    class="form-control-modern @error('talla_camisa') is-invalid @enderror">
                                <option value="">Seleccione</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                            </select>
                            @error('talla_camisa')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="talla_zapato" class="form-label-modern">
                                <i class="fas fa-shoe-prints"></i>
                                Talla Zapato
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model="talla_zapato" 
                                    class="form-control-modern @error('talla_zapato') is-invalid @enderror">
                                <option value="">Seleccione</option>
                                @foreach(range(30, 45) as $talla)
                                    <option value="{{ $talla }}">{{ $talla }}</option>
                                @endforeach
                            </select>
                            @error('talla_zapato')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="talla_pantalon" class="form-label-modern">
                                <i class="fas fa-socks"></i>
                                Talla Pantalón
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model="talla_pantalon" 
                                    class="form-control-modern @error('talla_pantalon') is-invalid @enderror">
                                <option value="">Seleccione</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                            </select>
                            @error('talla_pantalon')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Pertenencia Étnica --}}
        {{-- Card: Pertenencia Étnica --}}
        <div class="card-modern mb-4">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon" style="background: linear-gradient(135deg, #14b8a6, #0f766e);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h3>Pertenencia Étnica</h3>
                        <p>Información sobre origen étnico</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern" style="padding: 2rem;">
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label class="form-label-modern">
                                <i class="fas fa-question-circle"></i>
                                ¿Pertenece a Pueblo Indígena?
                                <span class="required-badge">*</span>
                            </label>

                            <div class="d-flex gap-3 mt-2" id="pueblo-wrapper">

                                <div class="radio-item-modern">
                                    <input type="radio"
                                        name="pueblo_radio"
                                        value="si"
                                        id="pueblo_si_js"
                                        class="radio-modern">
                                    <label for="pueblo_si_js" class="radio-label-modern">
                                        <i class="fas fa-check-circle"></i> Sí
                                    </label>
                                </div>

                                <div class="radio-item-modern">
                                    <input type="radio"
                                        name="pueblo_radio"
                                        value="no"
                                        id="pueblo_no_js"
                                        class="radio-modern"
                                        checked>
                                    <label for="pueblo_no_js" class="radio-label-modern">
                                        <i class="fas fa-times-circle"></i> No
                                    </label>
                                </div>

                                <!-- input oculto que recibe el valor real de Livewire -->
                                <input type="hidden"
                                    id="pertenece_pueblo_indigena"
                                    wire:model="pertenece_pueblo_indigena"
                                    value="no">

                            </div>

                            <div id="etnia-select" style="display:none; margin-top: .75rem;">
                                <label class="form-label-modern">
                                    <i class="fas fa-landmark"></i>
                                    ¿A cuál pertenece?
                                </label>

                                <select id="cual_pueblo_indigena_js"
                                        wire:model="cual_pueblo_indigena"
                                        class="form-control-modern">
                                    <option value="">Seleccione</option>
                                    @foreach($etniasIndigenas as $etnia)
                                        <option value="{{ $etnia->id }}">
                                            {{ $etnia->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>



        {{-- Card: Salud del Estudiante --}}
        <div class="card-modern mb-4">
            <div class="card-header-modern">
                <div class="header-left">
                    <div class="header-icon" style="background: linear-gradient(135deg, #f43f5e, #be123c);">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div>
                        <h3>Salud del Estudiante</h3>
                        <p>Información médica y dirección</p>
                    </div>
                </div>
            </div>

            <div class="card-body-modern" style="padding: 2rem;">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">

                            <label class="form-label-modern">
                                <i class="fas fa-question-circle"></i>
                                ¿Presenta Discapacidad?
                                <span class="required-badge">*</span>
                            </label>

                            <div class="d-flex gap-3 mt-2">

                                <div class="radio-item-modern">
                                    <input type="radio"
                                        id="discapacidad_si"
                                        value="si"
                                        class="radio-modern"
                                        name="discapacidad_radio">
                                    <label for="discapacidad_si" class="radio-label-modern">
                                        <i class="fas fa-check-circle"></i> Sí
                                    </label>
                                </div>

                                <div class="radio-item-modern">
                                    <input type="radio"
                                        id="discapacidad_no"
                                        value="no"
                                        class="radio-modern"
                                        name="discapacidad_radio"
                                        checked>
                                    <label for="discapacidad_no" class="radio-label-modern">
                                        <i class="fas fa-times-circle"></i> No
                                    </label>
                                </div>

                                <!-- hidden sincronizado con Livewire -->
                                <input type="hidden"
                                    id="presenta_discapacidad_js"
                                    wire:model="presenta_discapacidad"
                                    value="no">

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Campos condicionados -->
                <div id="discapacidad-fields" style="display:none; margin-top: .75rem;">
                                <label class="form-label-modern">
                                    <i class="fas fa-landmark"></i>
                                    ¿A cuál pertenece?
                                </label>

                                <select id="cual_discapacidad_js"
                                        wire:model="cual_discapacidad"
                                        class="form-control-modern">
                                    <option value="">Seleccione</option>
                                    @foreach($discapacidades as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nombre_discapacidad }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                    </div>
                </div>


    


        {{-- Botones de Acción --}}
        <div class="card-modern">
            <div class="card-body-modern" style="padding: 2rem;">
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('admin.alumnos.index') }}" class="btn-cancel-modern">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn-primary-modern" wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <i class="fas fa-save"></i>
                            {{ $alumno_id ? 'Actualizar' : 'Guardar' }} Estudiante
                        </span>
                        <span wire:loading>
                            <i class="fas fa-spinner fa-spin"></i>
                            Guardando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- Estilos adicionales para radios --}}
    <style>
        .radio-item-modern {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            background: var(--gray-50);
            border-radius: var(--radius);
            transition: all 0.2s ease;
            border: 2px solid transparent;
            cursor: pointer;
        }

        .radio-item-modern:hover {
            background: var(--primary-light);
            border-color: var(--primary);
        }

        .radio-modern {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .radio-label-modern {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            margin: 0 0 0 0.75rem;
            font-size: 0.9rem;
            color: var(--gray-700);
            font-weight: 500;
            user-select: none;
        }

        .radio-label-modern i {
            color: var(--primary);
        }
    </style>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {

    /***************************
     *  REUTILIZABLE SWITCHER  *
     ***************************/
    function toggleSection(radioSelectorYes, radioSelectorNo, hiddenInput, sectionToToggle) {
        const yes = document.querySelector(radioSelectorYes);
        const no = document.querySelector(radioSelectorNo);
        const hidden = document.querySelector(hiddenInput);
        const section = document.querySelector(sectionToToggle);

        function update() {
            if (yes.checked) {
                hidden.value = "si";
                section.style.display = "block";
                hidden.dispatchEvent(new Event("input"));
            } else {
                hidden.value = "no";
                section.style.display = "none";
                hidden.dispatchEvent(new Event("input"));
            }
        }

        yes.addEventListener("change", update);
        no.addEventListener("change", update);

        update(); // ejecuta al cargar
    }

    /**********************************
     * 1. MÓDULO: PUEBLO INDÍGENA     *
     **********************************/
    toggleSection(
        "#pueblo_si_js",
        "#pueblo_no_js",
        "#pertenece_pueblo_indigena",
        "#etnia-select"
    );

    /**********************************
     * 2. MÓDULO: DISCAPACIDAD        *
     **********************************/
    toggleSection(
        "#discapacidad_si",
        "#discapacidad_no",
        "#presenta_discapacidad_js",
        "#discapacidad-fields"
    );

});
</script>





        {{-- Continúa en el siguiente artefacto... --}}
        {{-- (Para no exceder el límite de caracteres) --}}
    </form>
</div>