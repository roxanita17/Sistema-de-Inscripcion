<!-- Modal Contrato de Convivencia -->
<div wire:ignore.self class="modal fade" id="modalContratoConvivencia" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="modalContratoConvivenciaLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content modal-modern">

            {{-- Cabecera del modal --}}
            <div class="modal-header-create">
                <div class="modal-icon-create" style="background: linear-gradient(135deg, var(--primary), #2563eb);">
                    <i class="fas fa-file-contract"></i>
                </div>

                <h5 class="modal-title-create" id="modalContratoConvivenciaLabel">
                    Contrato de Normas de Convivencia
                </h5>

                <button type="button" class="btn-close-modal" data-bs-dismiss="modal" aria-label="Cerrar">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            {{-- Cuerpo del modal --}}
            <div class="modal-body-create" style="max-height: 70vh; overflow-y: auto;">

                {{-- Introducción --}}
                <div class="alert alert-info mb-4"
                    style="border-left: 5px solid var(--primary); background: var(--primary-light);">
                    <i class="fas fa-info-circle me-2"></i>
                    Lea cuidadosamente las normas de convivencia antes de aceptar la inscripción.
                </div>

                {{-- Contenido del contrato --}}
                <div class="contract-content">

                    <h6 class="contract-title">
                        <i class="fas fa-school me-2"></i>
                        Disposiciones Generales
                    </h6>

                    <p class="contract-text">
                        El presente contrato de normas de convivencia tiene como finalidad garantizar
                        un ambiente educativo basado en el respeto, la responsabilidad y la sana
                        convivencia entre estudiantes, representantes, docentes y personal administrativo.
                    </p>

                    <hr class="contract-divider">

                    <h6 class="contract-title">
                        <i class="fas fa-user-check me-2"></i>
                        Compromisos del Representante
                    </h6>

                    <ul class="contract-list">
                        <li>Velar por la asistencia puntual y regular del estudiante.</li>
                        <li>Fomentar el respeto hacia los miembros de la comunidad educativa.</li>
                        <li>Responder oportunamente a los llamados de la institución.</li>
                        <li>Cumplir con las normas académicas y administrativas establecidas.</li>
                    </ul>

                    <hr class="contract-divider">

                    <h6 class="contract-title">
                        <i class="fas fa-child me-2"></i>
                        Compromisos del Estudiante
                    </h6>

                    <ul class="contract-list">
                        <li>Respetar a sus compañeros, docentes y autoridades.</li>
                        <li>Cuidar las instalaciones y bienes de la institución.</li>
                        <li>Cumplir con las normas disciplinarias y académicas.</li>
                        <li>Mantener una conducta acorde a los valores institucionales.</li>
                    </ul>

                    <hr class="contract-divider">

                    <h6 class="contract-title text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Incumplimiento
                    </h6>

                    <p class="contract-text">
                        El incumplimiento de las normas establecidas podrá acarrear sanciones conforme
                        a la gravedad de la falta, de acuerdo con el reglamento interno de la institución.
                    </p>

                    <hr class="contract-divider">

                    <h6 class="contract-title">
                        <i class="fas fa-gavel me-2"></i>
                        Aceptación
                    </h6>

                    <p class="contract-text fw-semibold">
                        Al aceptar este contrato, el representante declara haber leído, entendido
                        y aceptado todas las normas aquí descritas.
                    </p>

                </div>
                
            </div>

            {{-- Footer --}}
            <div class="modal-footer-create">
                <div class="footer-buttons">
                    <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- @push('css')
<style>
    .contract-content {
    font-size: 0.95rem;
    color: var(--gray-700);
    line-height: 1.7;
}

.contract-title {
    font-weight: 600;
    margin-bottom: 0.75rem;
    color: var(--gray-800);
}

.contract-text {
    margin-bottom: 1rem;
}

.contract-list {
    padding-left: 1.2rem;
    margin-bottom: 1rem;
}

.contract-list li {
    margin-bottom: 0.5rem;
}

.contract-divider {
    margin: 1.5rem 0;
    border-top: 1px dashed var(--gray-300);
}

</style>
    
@endpush --}}
