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
                    <div class="rules-container">
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-user-check"></i> <span class="rule-number">1</span> Responsabilidad personal
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    El estudiante y representante deben asumir la responsabilidad de su comportamiento, actuación y aprendizaje en el cumplimiento de las actividades que le sean asignadas.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-clock"></i> <span class="rule-number">2</span> Puntualidad
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    Asistir puntualmente a las actividades académicas y de evaluación de acuerdo al horario de clase (7:00 am a 12:45 pm).
                                </span>
                            </div>
                            <div class="alert alert-warning py-2 px-3 mt-2">
                                <small><i class="fas fa-exclamation-triangle me-1"></i> Los días lunes, el Acto Cívico es obligatorio a las 7:00 am. La inasistencia se considerará falta en el primer bloque.</small>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-file-medical"></i> <span class="rule-number">3</span> Justificación de inasistencias
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    Las ausencias deben ser justificadas por el representante legal. En caso de reposos médicos, deben presentarse en original y dos copias dentro de las 75 horas (3 días) hábiles siguientes.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-tshirt"></i> <span class="rule-number">4</span> Uniforme y presentación personal
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    <ul class="mb-0 ps-3">
                                        <li>1° a 3° año: Camisa/chemise azul claro</li>
                                        <li>4° y 5° año: Camisa/chemise beige (no franela)</li>
                                        <li>Pantalón azul marino de gabardina clásico (no ajustado, no a la cadera)</li>
                                        <li>Zapatos negros, azul oscuro, marrón oscuro o blanco (colegiales o deportivos, no tipo botín)</li>
                                        <li>Cinturón azul oscuro, negro o marrón</li>
                                        <li>Uniforme de deporte: Mono azul marino con camisa blanca (solo los días de educación física)</li>
                                        <li>Cabello natural, sin accesorios inadecuados (aretes, piercings, etc.)</li>
                                        <li>Sin maquillaje excesivo ni tintes de colores no naturales</li>
                                    </ul>
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-hands-helping"></i> <span class="rule-number">5</span> Respeto institucional
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    Mantener una actitud de respeto hacia todos los miembros de la comunidad educativa (directivos, docentes, administrativos, obreros, personal PAE y estudiantes), acatando las decisiones y orientaciones del personal directivo y docente.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-home"></i> <span class="rule-number">6</span> Cuidado de instalaciones
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    Los estudiantes deben mantener en buen estado las instalaciones, mobiliario y materiales. Los daños causados serán responsabilidad económica del estudiante y su representante.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-user-slash"></i> <span class="rule-number">7</span> Prohibido recibir visitas
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    No se permiten visitas ajenas a la institución en horario de clases.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-door-open"></i> <span class="rule-number">8</span> Permanencia en aulas
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    No se permite la permanencia de estudiantes en las aulas durante horas libres o sin supervisión docente.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-mobile-alt"></i> <span class="rule-number">9</span> Uso de celulares
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    Prohibido el uso de teléfonos celulares dentro y fuera de las aulas, solo bajo autorización del personal docente o directivo.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-gavel"></i> <span class="rule-number">10</span> Orden y disciplina
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    No interrumpir ni obstaculizar el desarrollo normal de las actividades escolares. Prohibido participar en actos contrarios a la disciplina y al orden público.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-ban"></i> <span class="rule-number">11</span> Objetos prohibidos
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    No se permite traer a la institución: radio reproductores, juegos de azar, metras o trompos.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-comment-dots"></i> <span class="rule-number">12</span> Procedimiento de quejas
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    Cualquier queja o reclamo debe presentarse por escrito ante la Coordinación correspondiente.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-smoking-ban"></i> <span class="rule-number">13</span> Prohibición de sustancias
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    Se prohíbe fumar, ingerir bebidas alcohólicas, sustancias estupefacientes o cualquier derivado del tabaco dentro o fuera de la institución.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-shield-alt"></i> <span class="rule-number">14</span> Armas y objetos peligrosos
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    Está estrictamente prohibido portar armas blancas, de fuego, municiones, detonantes, explosivos o fuegos artificiales.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-door-closed"></i> <span class="rule-number">15</span> Permanencia en puertas de aulas
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    No se permite la permanencia de representantes o estudiantes en las puertas de las aulas durante horas de clase.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-redo"></i> <span class="rule-number">16</span> Estudiantes repitentes
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    Al estudiante que repita año escolar se le brindará una segunda oportunidad con el compromiso y seguimiento del plantel y su representante legal.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-user-friends"></i> <span class="rule-number">17</span> Representación legal
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    El estudiante que no conviva con su representante biológico deberá informarlo al momento de la inscripción y presentar la autorización correspondiente.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-chart-line"></i> <span class="rule-number">18</span> Seguimiento académico
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    El representante legal debe vigilar el rendimiento académico y la conducta de su representado, acudiendo al plantel al menos cada dos semanas.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-users"></i> <span class="rule-number">19</span> Asistencia a asambleas
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    Es obligación de los padres y representantes asistir a las Asambleas Generales, reuniones, citaciones y entrega de boletines.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-baby"></i> <span class="rule-number">20</span> Madres adolescentes
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    Se prohíbe a las madres adolescentes (estudiantes) traer a sus hijos durante las actividades escolares.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-paw"></i> <span class="rule-number">21</span> Mascotas
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    Prohibido traer todo tipo de mascotas a la institución (perros, gatos, loros, entre otros).
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-dollar-sign"></i> <span class="rule-number">22</span> Aportes económicos
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    No está permitido que los docentes soliciten dinero a los estudiantes sin autorización escrita del Director y conocimiento de los Padres y Representantes.
                                </span>
                            </div>
                        </div>
                        
                        <div class="details-card mb-2 ms-3 me-3">
                            <h6 class="section-title text-start">
                                <i class="fas fa-user-tie"></i> <span class="rule-number">23</span> Vestimenta de representantes
                            </h6>
                            <div class="detail-item">
                                <span class="detail-value text-start">
                                    LOS PADRES Y REPRESENTANTES DEBEN ASISTIR A LA INSTITUCIÓN CON EL ATUENDO ADECUADO (prohibido escotes, franelillas, short, bermudas, chancletas, pijamas, batas, vestidos cortos y claros, entre otros).
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning mt-3 ms-3 me-3">
                        <h6 class="fw-semibold mb-2 text-start">Nota Importante</h6>
                        <p class="mb-0 text-start">El incumplimiento de estos acuerdos podrá acarrear sanciones disciplinarias según lo establecido en el Reglamento Interno de la Institución.</p>
                    </div>

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

@push('css')
<style>
    .title-gradient {
        background: linear-gradient(135deg, #6f42c1 0%, #9c27b0 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        position: relative;
        padding-bottom: 8px;
    }
    
    .title-gradient::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, #6f42c1, #9c27b0);
        border-radius: 3px;
    }
    
    .rule-number {
        display: inline-block;
        width: 24px;
        height: 24px;
        line-height: 24px;
        border-radius: 50%;
        background: var(--primary);
        color: white;
        text-align: center;
        margin-right: 8px;
        font-weight: bold;
        font-size: 0.9em;
    }
    
    .section-title {
        color: #6f42c1 !important;
        font-weight: 600;
    }
    
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
