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
            <div class="col-md-6">
                <p><strong>Documento:</strong> {{ $tipos_documentos->find($tipo_documento_id)->nombre ?? 'N/A' }} - {{ $numero_documento }}</p>
                <p><strong>Nombre Completo:</strong> {{ $primer_nombre }} {{ $segundo_nombre }} {{ $primer_apellido }} {{ $segundo_apellido }}</p>
                <p><strong>Fecha de Nacimiento:</strong> {{ \Carbon\Carbon::parse($fecha_nacimiento)->format('d/m/Y') }} ({{ $edad }} años, {{ $meses }} meses)</p>
                <p><strong>Género:</strong> {{ $generos->find($genero_id)->genero ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Estatura:</strong> {{ $talla_estudiante }} m</p>
                <p><strong>Peso:</strong> {{ $peso_estudiante }} kg</p>
                <p><strong>Talla Camisa:</strong> {{ $tallas->find($talla_camisa_id)->nombre ?? 'N/A' }}</p>
                <p><strong>Talla Pantalón:</strong> {{ $tallas->find($talla_pantalon_id)->nombre ?? 'N/A' }}</p>
                <p><strong>Talla Zapato:</strong> {{ $talla_zapato }}</p>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                @if ($localidad_id)
                    <p><strong>Lugar de Nacimiento:</strong> 
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
            </div>
        </div>
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
                    <input type="text" value="{{ $edad }} años, {{ $meses }} meses" class="form-control-modern" disabled>
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
                    <input type="text" wire:model="talla_estudiante" class="form-control-modern" placeholder="1.65">
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