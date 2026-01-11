<div class="modal fade" id="confirmarRestaurar{{ $datos->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-modern">
            <div class="modal-header-delete">
                <div class="modal-icon-delete">
                    <i class="fas fa-undo"></i>
                </div>
                <h5 class="modal-title-delete">Confirmar restauración</h5>
                <button type="button" class="btn-close-modal" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body-delete">
                <p>¿Deseas restaurar esta inscripción?</p>
                <p class="delete-warning">
                    El estudiante también será restaurado.
                </p>
            </div>
            <div class="modal-footer-delete">
                <form action="{{ route('admin.transacciones.inscripcion_prosecucion.restore', $datos->id) }}"
                    method="POST" class="w-100">
                    @csrf
                    @method('GET')
                    <div class="footer-buttons">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn-modal-delete">
                            Restaurar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
