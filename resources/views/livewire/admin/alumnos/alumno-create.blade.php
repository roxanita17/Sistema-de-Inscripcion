    {{-- Alertas --}}
    {{--     @if (session()->has('success') || session()->has('error'))
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
    @endif --}}

    <form wire:submit.prevent="save">


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
                            <select wire:model.livee="tipo_documento_id"
                                class="form-control-modern @error('tipo_documento_id') is-invalid @enderror">
                                <option value="">Seleccione</option>
                                @foreach ($tipos_documentos as $item)
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
                            <label for="numero_documento" class="form-label-modern">
                                <i class="fas fa-id-card"></i>
                                Cédula
                                <span class="required-badge">*</span>
                            </label>
                            <input type="text" wire:model.live="numero_documento"
                                class="form-control-modern @error('numero_documento') is-invalid @enderror
                                text-uppercase"
                                maxlength="{{ $documento_maxlength }}" pattern="{{ $documento_pattern }}"
                                inputmode="{{ $documento_inputmode }}" placeholder="{{ $documento_placeholder }}"
                                oninput="
                                @if ($tipo_documento_id == 1 || $tipo_documento_id == 3) this.value = this.value.replace(/[^0-9]/g,'')
                                @elseif($tipo_documento_id == 2)
                                this.value = this.value.replace(/[^a-zA-Z0-9]/g,'') @endif
                                ">
                            @error('numero_documento')
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
                            <input type="date" wire:model.live="fecha_nacimiento"
                                class="form-control-modern @error('fecha_nacimiento') is-invalid @enderror">
                            @error('fecha_nacimiento')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
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
                            <input type="text" wire:model.live="primer_nombre"
                                class="form-control-modern @error('primer_nombre') is-invalid @enderror text-capitalize"
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
                            <input type="text" wire:model="segundo_nombre"
                                class="form-control-modern text-capitalize" placeholder="Segundo nombre">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tercer_nombre" class="form-label-modern ">
                                <i class="fas fa-user"></i>
                                Tercer Nombre
                            </label>
                            <input type="text" wire:model.live="tercer_nombre"
                                class="form-control-modern text-capitalize" placeholder="Tercer nombre">
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="primer_apellido" class="form-label-modern ">
                                <i class="fas fa-user"></i>
                                Primer Apellido
                                <span class="required-badge">*</span>
                            </label>
                            <input type="text" wire:model.live="primer_apellido"
                                class="form-control-modern @error('primer_apellido') is-invalid @enderror text-capitalize"
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
                            <label for="segundo_apellido" class="form-label-modern ">
                                <i class="fas fa-user"></i>
                                Segundo Apellido
                            </label>
                            <input type="text" wire:model.live="segundo_apellido"
                                class="form-control-modern text-capitalize" placeholder="Segundo apellido">
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
                            <select wire:model.live="genero_id"
                                class="form-control-modern @error('genero_id') is-invalid @enderror">
                                <option value="">Seleccione</option>
                                @foreach ($generos as $item)
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
                            <select wire:model.live="lateralidad_id"
                                class="form-control-modern @error('lateralidad_id') is-invalid @enderror">
                                <option value="">Seleccione</option>
                                @foreach ($lateralidades as $item)
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
                            <select wire:model.live="orden_nacimiento_id"
                                class="form-control-modern @error('orden_nacimiento_id') is-invalid @enderror">
                                <option value="">Seleccione</option>
                                @foreach ($orden_nacimientos as $item)
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
                            <select wire:model.live.live="estado_id"
                                class="form-control-modern @error('estado_id') is-invalid @enderror">
                                <option value="">Seleccione un estado</option>
                                @foreach ($estados as $estado)
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
                            <select wire:model.live.live="municipio_id"
                                class="form-control-modern @error('municipio_id') is-invalid @enderror">
                                <option value="">Seleccione un municipio</option>
                                @foreach ($municipios as $municipio)
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
                            <select wire:model.live.live="localidad_id"
                                class="form-control-modern @error('localidad_id') is-invalid @enderror">
                                <option value="">Seleccione una localidad</option>
                                @foreach ($localidades as $localidad)
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
                                Altura (m)
                                <span class="required-badge">*</span>
                            </label>
                            <input type="text" wire:model.defer="talla_estudiante" wire:blur="validarEstatura"
                                wire:keyup='formatearEstatura' placeholder="Ej: 1.66"
                                class="form-control-modern @error('talla_estudiante') is-invalid @enderror">
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
                            <input type="number" wire:model.live="peso_estudiante"
                                class="form-control-modern @error('peso_estudiante') is-invalid @enderror"
                                step="0.1" min="20" max="100" placeholder="Ej: 45.5">
                            @error('peso_estudiante')
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
                            <select wire:model.live="talla_zapato"
                                class="form-control-modern @error('talla_zapato') is-invalid @enderror">
                                <option value="">Seleccione</option>
                                @foreach (range(30, 45) as $talla)
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
                            <label for="talla_camisa_id" class="form-label-modern">
                                <i class="fas fa-tshirt"></i>
                                Talla Camisa
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model.live="talla_camisa_id"
                                class="form-control-modern @error('talla_camisa_id') is-invalid @enderror">
                                <option value="">Seleccione</option>
                                @foreach ($tallas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('talla_camisa_id')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="talla_pantalon_id" class="form-label-modern">
                                <i class="fas fa-socks"></i>
                                Talla Pantalón
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model.live="talla_pantalon_id"
                                class="form-control-modern @error('talla_pantalon_id') is-invalid @enderror">
                                <option value="">Seleccione</option>
                                @foreach ($tallas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('talla_pantalon_id')
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
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="etnia_indigena_id" class="form-label-modern">
                                <i class="fas fa-id-card"></i>
                                Etnia Indigena
                                <span class="required-badge">*</span>
                            </label>
                            <select wire:model.live="etnia_indigena_id"
                                class="form-control-modern @error('etnia_indigena_id') is-invalid @enderror">
                                <option value="">Seleccione</option>
                                @foreach ($etnia_indigenas as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('etnia_indigena_id')
                                <div class="invalid-feedback-modern">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

      