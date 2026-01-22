<?php

namespace App\Services;

class DocumentoService
{
    private array $documentosDisponibles = [
        'partida_nacimiento',
        'copia_cedula_representante',
        'copia_cedula_estudiante',
        'boletin_6to_grado',
        'certificado_calificaciones',
        'constancia_aprobacion_primaria',
        'foto_estudiante',
        'foto_representante',
        'carnet_vacunacion',
        'autorizacion_tercero',
        'notas_certificadas',
        'liberacion_cupo',
    ];

    private array $documentosObligatorios = [
        'partida_nacimiento',
        'boletin_6to_grado',
        'certificado_calificaciones',
        'constancia_aprobacion_primaria',
    ];

    private array $documentosSegundoGrado = [
        'notas_certificadas',
        'liberacion_cupo',
    ];
    
    private array $documentosOpcionales = [
        'copia_cedula_representante',
        'copia_cedula_estudiante',
        'foto_estudiante',
        'foto_representante',
        'carnet_vacunacion',
    ];

    private string $documentoAutorizacion = 'autorizacion_tercero';

    private array $documentosEtiquetas = [
        'partida_nacimiento' => 'Partida de Nacimiento',
        'copia_cedula_representante' => 'Copia de Cédula del Representante',
        'copia_cedula_estudiante' => 'Copia de Cédula del Estudiante',
        'boletin_6to_grado' => 'Boletín de 6to Grado',
        'certificado_calificaciones' => 'Certificado de Calificaciones',
        'constancia_aprobacion_primaria' => 'Constancia de Aprobación Primaria',
        'foto_estudiante' => 'Fotografía Tipo Carnet del Estudiante',
        'foto_representante' => 'Fotografía Tipo Carnet del Representante',
        'carnet_vacunacion' => 'Carnet de Vacunación Vigente',
        'autorizacion_tercero' => 'Autorización Firmada',
        'notas_certificadas' => 'Notas Certificadas',
        'liberacion_cupo' => 'Liberación de Cupo',
    ];

    public function obtenerDocumentosDisponibles(): array
    {
        return $this->documentosDisponibles;
    }

    public function obtenerEtiquetas(): array
    {
        return $this->documentosEtiquetas;
    }

    public function evaluarEstadoDocumentos(
        array $seleccionados,
        bool $requiereAutorizacion,
        bool $esPrimerGrado
    ): array {
        // 1. Definir documentos OBLIGATORIOS según grado
        $obligatorios = $this->documentosObligatorios;

        // Para 2do grado en adelante, agregar documentos adicionales como obligatorios
        if (!$esPrimerGrado) {
            $obligatorios = array_merge($obligatorios, $this->documentosSegundoGrado);
        }

        // 2. Verificar documentos OBLIGATORIOS faltantes (BLOQUEANTES)
        $faltantesObligatorios = array_diff($obligatorios, $seleccionados);

        // 3. Verificar autorización si aplica (TAMBIÉN ES BLOQUEANTE)
        if ($requiereAutorizacion && !in_array($this->documentoAutorizacion, $seleccionados)) {
            $faltantesObligatorios[] = $this->documentoAutorizacion;
        }

        // Si faltan documentos OBLIGATORIOS, NO puede guardar
        if (!empty($faltantesObligatorios)) {
            return [
                'puede_guardar' => false,
                'estado_documentos' => 'Incompletos',
                'status_inscripcion' => 'Pendiente',
                'faltantes' => $faltantesObligatorios,
                'faltantes_obligatorios' => $faltantesObligatorios,
            ];
        }

        // 4. Verificar documentos OPCIONALES faltantes (NO BLOQUEANTES)
        $faltantesOpcionales = array_diff($this->documentosOpcionales, $seleccionados);

        // Si faltan opcionales, puede guardar pero queda en Pendiente
        if (!empty($faltantesOpcionales)) {
            return [
                'puede_guardar' => true,
                'estado_documentos' => 'Incompletos',
                'status_inscripcion' => 'Pendiente',
                'faltantes' => $faltantesOpcionales,
                'faltantes_obligatorios' => [],
            ];
        }

        // 5. Todo completo - puede guardar y queda Activo
        return [
            'puede_guardar' => true,
            'estado_documentos' => 'Completos',
            'status_inscripcion' => 'Activo',
            'faltantes' => [],
            'faltantes_obligatorios' => [],
        ];
    }

    public function generarObservaciones(
        array $documentos,
        bool $requiereAutorizacion,
        bool $esPrimerGrado,
        ?int $alumnoId = null
    ): ?string {
        $evaluacion = $this->evaluarEstadoDocumentos(
            $documentos,
            $requiereAutorizacion,
            $esPrimerGrado
        );

        $observaciones = [];

        // Solo listar los documentos que faltan (obligatorios u opcionales)
        if (!empty($evaluacion['faltantes'])) {
            $observaciones[] = 'Documentos faltantes:';
            
            foreach ($evaluacion['faltantes'] as $doc) {
                $etiqueta = $this->documentosEtiquetas[$doc] ?? ucfirst(str_replace('_', ' ', $doc));
                
                // Marcar si es obligatorio
                $esObligatorio = in_array($doc, $evaluacion['faltantes_obligatorios']);
                $marcador = $esObligatorio ? ' (OBLIGATORIO)' : ' (Opcional)';
                
                $observaciones[] = '- ' . $etiqueta . $marcador;
            }
        }

        // Agregar discapacidades si existen
        if ($alumnoId) {
            $discapacidades = \App\Models\DiscapacidadEstudiante::with('discapacidad')
                ->where('alumno_id', $alumnoId)
                ->where('status', true)
                ->get()
                ->pluck('discapacidad.nombre_discapacidad')
                ->filter()
                ->values();

            if ($discapacidades->isNotEmpty()) {
                $observaciones[] = '';
                $observaciones[] = 'Discapacidades del estudiante:';
                foreach ($discapacidades as $nombre) {
                    $observaciones[] = '- ' . $nombre;
                }
            }
        }

        return empty($observaciones) ? null : implode(PHP_EOL, $observaciones);
    }
}
