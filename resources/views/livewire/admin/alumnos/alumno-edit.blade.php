<div>
    @if (!$enModoEdicion)
        {{-- Modo Vista --}}
        <div class="row">
            <div class="col-md-12 text-end mb-3">
                <button type="button" wire:click="habilitarEdicion" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Editar Datos
                </button>
            </div>
        </div>

        <div class="row">
            {{-- Columna Izquierda --}}
            <div class="col-md-6">
                <h6 class="text-primary mb-3"><i class="fas fa-id-card"></i> Datos Personales</h6>

                <p><strong>Tipo de Documento:</strong>
                    {{ $tipos_documentos->find($tipo_documento_id)->nombre ?? 'N/A' }}</p>
                <p><strong>Número de Documento:</strong> {{ $numero_documento }}</p>

                <p><strong>Primer Nombre:</strong> {{ $primer_nombre }}</p>
                @if ($segundo_nombre)
                    <p><strong>Segundo Nombre:</strong> {{ $segundo_nombre }}</p>
                @endif
                @if ($tercer_nombre)
                    <p><strong>Tercer Nombre:</strong> {{ $tercer_nombre }}</p>
                @endif

                <p><strong>Primer Apellido:</strong> {{ $primer_apellido }}</p>
                @if ($segundo_apellido)
                    <p><strong>Segundo Apellido:</strong> {{ $segundo_apellido }}</p>
                @endif

                <p><strong>Nombre Completo:</strong>
                    {{ $primer_nombre }} {{ $segundo_nombre }} {{ $tercer_nombre }}
                    {{ $primer_apellido }} {{ $segundo_apellido }}
                </p>

                <p><strong>Fecha de Nacimiento:</strong>
                    {{ \Carbon\Carbon::parse($fecha_nacimiento)->format('d/m/Y') }}
                </p>

                <p><strong>Edad:</strong> {{ $edad }} años, {{ $meses }} meses</p>

                <p><strong>Género:</strong> {{ $generos->find($genero_id)->genero ?? 'N/A' }}</p>

                <hr class="my-3">

                <h6 class="text-primary mb-3"><i class="fas fa-ruler-combined"></i> Datos Físicos</h6>

                <p><strong>Estatura:</strong> {{ $talla_estudiante }} m</p>
                <p><strong>Peso:</strong> {{ $peso_estudiante }} kg</p>
                <p><strong>Talla Camisa:</strong> {{ $tallas->find($talla_camisa_id)->nombre ?? 'N/A' }}</p>
                <p><strong>Talla Pantalón:</strong> {{ $tallas->find($talla_pantalon_id)->nombre ?? 'N/A' }}</p>
                <p><strong>Talla Zapato:</strong> {{ $talla_zapato }}</p>
            </div>

            {{-- Columna Derecha --}}
            <div class="col-md-6">
                <h6 class="text-primary mb-3"><i class="fas fa-map-marker-alt"></i> Lugar de Nacimiento</h6>

                @if ($localidad_id)
                    <p><strong>Estado:</strong> {{ $estados->find($estado_id)->nombre_estado ?? 'N/A' }}</p>
                    <p><strong>Municipio:</strong> {{ $municipios->find($municipio_id)->nombre_municipio ?? 'N/A' }}
                    </p>
                    <p><strong>Localidad:</strong> {{ $localidades->find($localidad_id)->nombre_localidad ?? 'N/A' }}
                    </p>

                    <p><strong>Dirección Completa:</strong>
                        {{ $estados->find($estado_id)->nombre_estado ?? '' }},
                        {{ $municipios->find($municipio_id)->nombre_municipio ?? '' }},
                        {{ $localidades->find($localidad_id)->nombre_localidad ?? '' }}
                    </p>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        No se ha registrado el lugar de nacimiento. Por favor, edite los datos para agregarlo.
                    </div>
                @endif

                <hr class="my-3">

                <h6 class="text-primary mb-3"><i class="fas fa-info-circle"></i> Información Adicional</h6>

                <p><strong>Lateralidad:</strong>
                    {{ $lateralidades->find($lateralidad_id)->lateralidad ?? 'N/A' }}
                </p>

                <p><strong>Orden de Nacimiento:</strong>
                    {{ $orden_nacimientos->find($orden_nacimiento_id)->orden_nacimiento ?? 'N/A' }}
                </p>

                <p><strong>Etnia Indígena:</strong>
                    {{ $etnia_indigenas->find($etnia_indigena_id)->nombre ?? 'N/A' }}
                </p>
            </div>
        </div>

        {{-- Sección de Discapacidades si existen --}}
        @if (!empty($discapacidadesAlumno))
            <div class="row mt-4">
                <div class="col-12">
                    <hr>
                    <h6 class="text-primary mb-3">
                        <i class="fas fa-wheelchair"></i> Discapacidades Registradas
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Discapacidad</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($discapacidadesAlumno as $index => $discapacidad)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $discapacidad['nombre'] }}</td>
                                        <td>
                                            <span class="badge bg-success">Activo</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="row mt-4">
                <div class="col-12">
                    <hr>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        No se han registrado discapacidades para este estudiante.
                    </div>
                </div>
            </div>
        @endif
    @else
        {{-- Modo Edición --}}
        <form wire:submit.prevent="guardar">
            {{-- Datos Personales --}}
            <div class="row">
                <div class="col-md-2">
                    <label class="form-label-modern">
                        <i class="fas fa-id-card"></i> Tipo Doc.
                    </label>
                    <select wire:model="tipo_documento_id" class="form-control-modern">
                        <option value="">Seleccione</option>
                        @foreach ($tipos_documentos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label-modern">
                        <i class="fas fa-id-card"></i> Cédula
                    </label>
                    <input type="text" wire:model="numero_documento" class="form-control-modern" maxlength="8">
                </div>

                <div class="col-md-3">
                    <label class="form-label-modern">
                        <i class="fas fa-birthday-cake"></i> Fecha Nacimiento
                    </label>
                    <input type="date" wire:model.live="fecha_nacimiento" class="form-control-modern">
                </div>

                <div class="col-md-2">
                    <label class="form-label-modern">Edad</label>
                    <input type="text" value="{{ $edad }} años, {{ $meses }} meses"
                        class="form-control-modern" disabled>
                </div>

                <div class="col-md-3">
                    <label class="form-label-modern">
                        <i class="fas fa-venus-mars"></i> Género
                    </label>
                    <select wire:model="genero_id" class="form-control-modern">
                        <option value="">Seleccione</option>
                        @foreach ($generos as $genero)
                            <option value="{{ $genero->id }}">{{ $genero->genero }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <label class="form-label-modern">
                        <i class="fas fa-user"></i> Primer Nombre
                    </label>
                    <input type="text" wire:model="primer_nombre" class="form-control-modern text-capitalize">
                </div>

                <div class="col-md-3">
                    <label class="form-label-modern">Segundo Nombre</label>
                    <input type="text" wire:model="segundo_nombre" class="form-control-modern text-capitalize">
                </div>

                <div class="col-md-3">
                    <label class="form-label-modern">Tercer Nombre</label>
                    <input type="text" wire:model="tercer_nombre" class="form-control-modern text-capitalize">
                </div>

                <div class="col-md-3">
                    <label class="form-label-modern">
                        <i class="fas fa-user"></i> Primer Apellido
                    </label>
                    <input type="text" wire:model="primer_apellido" class="form-control-modern text-capitalize">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <label class="form-label-modern">Segundo Apellido</label>
                    <input type="text" wire:model="segundo_apellido" class="form-control-modern text-capitalize">
                </div>

                <div class="col-md-3">
                    <label class="form-label-modern">
                        <i class="fas fa-hand-paper"></i> Lateralidad
                    </label>
                    <select wire:model="lateralidad_id" class="form-control-modern">
                        <option value="">Seleccione</option>
                        @foreach ($lateralidades as $lat)
                            <option value="{{ $lat->id }}">{{ $lat->lateralidad }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label-modern">
                        <i class="fas fa-sort-numeric-up"></i> Orden Nacimiento
                    </label>
                    <select wire:model="orden_nacimiento_id" class="form-control-modern">
                        <option value="">Seleccione</option>
                        @foreach ($orden_nacimientos as $orden)
                            <option value="{{ $orden->id }}">{{ $orden->orden_nacimiento }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label-modern">
                        <i class="fas fa-users"></i> Etnia Indígena
                    </label>
                    <select wire:model="etnia_indigena_id" class="form-control-modern">
                        <option value="">Seleccione</option>
                        @foreach ($etnia_indigenas as $etnia)
                            <option value="{{ $etnia->id }}">{{ $etnia->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Datos Físicos --}}
            <div class="row mt-3">
                <div class="col-md-3">
                    <label class="form-label-modern">
                        <i class="fas fa-ruler-vertical"></i> Altura (m)
                    </label>
                    <input type="text" wire:model="talla_estudiante" class="form-control-modern"
                        placeholder="1.65">
                </div>

                <div class="col-md-2">
                    <label class="form-label-modern">
                        <i class="fas fa-weight"></i> Peso (kg)
                    </label>
                    <input type="number" wire:model="peso_estudiante" class="form-control-modern" step="0.1">
                </div>

                <div class="col-md-2">
                    <label class="form-label-modern">
                        <i class="fas fa-tshirt"></i> Talla Camisa
                    </label>
                    <select wire:model="talla_camisa_id" class="form-control-modern">
                        <option value="">Seleccione</option>
                        @foreach ($tallas as $talla)
                            <option value="{{ $talla->id }}">{{ $talla->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label-modern">
                        <i class="fas fa-socks"></i> Talla Pantalón
                    </label>
                    <select wire:model="talla_pantalon_id" class="form-control-modern">
                        <option value="">Seleccione</option>
                        @foreach ($tallas as $talla)
                            <option value="{{ $talla->id }}">{{ $talla->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label-modern">
                        <i class="fas fa-shoe-prints"></i> Talla Zapato
                    </label>
                    <select wire:model="talla_zapato" class="form-control-modern">
                        <option value="">Seleccione</option>
                        @foreach (range(30, 45) as $talla)
                            <option value="{{ $talla }}">{{ $talla }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Lugar de Nacimiento --}}
            <div class="row mt-3">
                <div class="col-md-4">
                    <label class="form-label-modern">
                        <i class="fas fa-map"></i> Estado
                    </label>
                    <select wire:model.live="estado_id" class="form-control-modern">
                        <option value="">Seleccione</option>
                        @foreach ($estados as $estado)
                            <option value="{{ $estado->id }}">{{ $estado->nombre_estado }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label-modern">
                        <i class="fas fa-map-marked-alt"></i> Municipio
                    </label>
                    <select wire:model.live="municipio_id" class="form-control-modern">
                        <option value="">Seleccione</option>
                        @foreach ($municipios as $municipio)
                            <option value="{{ $municipio->id }}">{{ $municipio->nombre_municipio }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label-modern">
                        <i class="fas fa-map-pin"></i> Localidad
                    </label>
                    <select wire:model="localidad_id" class="form-control-modern">
                        <option value="">Seleccione</option>
                        @foreach ($localidades as $localidad)
                            <option value="{{ $localidad->id }}">{{ $localidad->nombre_localidad }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <h5>Discapacidades</h5>

                    @if (!empty($discapacidadesAlumno))
                        <ul class="list-group">
                            @foreach ($discapacidadesAlumno as $disc)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $disc['nombre'] }}
                                    @if ($enModoEdicion)
                                        <button type="button" wire:click="eliminarDiscapacidad({{ $loop->index }})"
                                            class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="alert alert-info">
                            Este alumno no tiene discapacidades registradas.
                        </div>
                    @endif

                    @if ($enModoEdicion)
                        <div class="mt-3 row align-items-end">
                            <div class="col-md-8">
                                <select wire:model.defer="discapacidadSeleccionada" class="form-control">
                                    <option value="">Seleccione una discapacidad</option>
                                    @foreach ($discapacidades as $discapacidad)
                                        <option value="{{ $discapacidad->id }}">
                                            {{ $discapacidad->nombre_discapacidad }}</option>
                                    @endforeach
                                </select>
                                @error('discapacidadSeleccionada')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <button type="button" wire:click="agregarDiscapacidad"
                                    class="btn btn-primary w-100">
                                    <i class="fas fa-plus"></i> Agregar
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Botones --}}
            <div class="row mt-4">
                <div class="col-12 text-end">
                    <button type="button" wire:click="cancelarEdicion" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success ms-2" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="guardar">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </span>
                        <span wire:loading wire:target="guardar">
                            <i class="fas fa-spinner fa-spin"></i> Guardando...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>
