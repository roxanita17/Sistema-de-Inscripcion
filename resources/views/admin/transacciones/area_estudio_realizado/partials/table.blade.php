<div class="card-modern">
    <div class="card-header-modern">
        <div class="header-left">
            <div class="header-icon"><i class="fas fa-list-ul"></i></div>
            <div>
                <h3>Listado de Asignaciones</h3>
                <p>{{ $areaEstudioRealizado->total() }} registros encontrados</p>
            </div>
        </div>
        <div class="header-right">
            <div class="date-badge"><i class="fas fa-calendar-alt"></i> <span>{{ now()->translatedFormat('d M Y') }}</span></div>
        </div>
    </div>
    <div class="card-body-modern">
        <div class="table-wrapper">
            <table class="table-modern overflow-hidden">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Área de Formación</th>
                        <th>Título Universitario</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($areaEstudioRealizado as $index => $datos)
                        <tr class=" ">
                            <td>{{ $index + $areaEstudioRealizado->firstItem() }}</td>
                            <td>{{ $datos->area_formacion->nombre_area_formacion ?? '—' }}</td>
                            <td>{{ $datos->estudio_realizado->estudios ?? '—' }}</td>
                            <td>
                                @if ($datos->status)
                                    <span class="status-badge status-active">Activo</span>
                                @else
                                    <span class="status-badge status-inactive">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn btn-edit" data-bs-toggle="modal" data-bs-target="#viewModalEditar{{ $datos->id }}"><i class="fas fa-pen"></i></button>
                                    <button class="action-btn btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $datos->id }}"><i class="fas fa-trash-alt"></i></button>
                                </div>
                            </td>
                        </tr>

                        {{-- Edit Modal --}}
                        @include('admin.transacciones.area_estudio_realizado.modales.editModal', [
                            'datos' => $datos,
                            'area_formacion' => $area_formacion,
                            'estudios' => $estudios
                        ])

                        {{-- Delete Modal --}}
                        <div class="modal fade" id="deleteModal{{ $datos->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content modal-modern">
                                    <div class="modal-header-delete">
                                        <div class="modal-icon-delete"><i class="fas fa-trash-alt"></i></div>
                                        <h5 class="modal-title-delete">Confirmar Eliminación</h5>
                                        <button type="button" class="btn-close-modal" data-bs-dismiss="modal"><i class="fas fa-times"></i></button>
                                    </div>
                                    <div class="modal-body-delete">
                                        <p class="delete-message">¿Deseas eliminar esta asignación?</p>
                                        <p class="delete-warning"><i class="fas fa-exclamation-triangle me-1"></i>No se puede deshacer</p>
                                    </div>
                                    <div class="modal-footer-delete">
                                        <form action="{{ url('admin/transacciones/area_estudio_realizado/' . $datos->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn-modal-delete"><i class="fas fa-trash me-1"></i>Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay asignaciones registradas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación normal --}}
        <x-pagination :paginator="$areaEstudioRealizado" />
    </div>
</div>
