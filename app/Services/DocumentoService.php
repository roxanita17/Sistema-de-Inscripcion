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
    ];

    private array $documentosObligatorios = [
        'partida_nacimiento',
        'boletin_6to_grado',
        'certificado_calificaciones',
        'constancia_aprobacion_primaria',
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
    ];

    public function obtenerDocumentosDisponibles(): array
    {
        return $this->documentosDisponibles;
    }

    public function obtenerEtiquetas(): array
    {
        return $this->documentosEtiquetas;
    }

    public function evaluarEstadoDocumentos(array $seleccionados, bool $requiereAutorizacion): array
    {
        // 1. Validar obligatorios
        $faltanObligatorios = array_diff($this->documentosObligatorios, $seleccionados);

        if (!empty($faltanObligatorios)) {
            return [
                'puede_guardar' => false,
                'estado_documentos' => 'Incompletos',
                'status_inscripcion' => 'Pendiente',
                'faltantes' => $faltanObligatorios,
            ];
        }

        // 2. Validar autorización si aplica
        if ($requiereAutorizacion && !in_array($this->documentoAutorizacion, $seleccionados)) {
            return [
                'puede_guardar' => false,
                'estado_documentos' => 'Incompletos',
                'status_inscripcion' => 'Pendiente',
                'faltantes' => [$this->documentoAutorizacion],
            ];
        }

        // 3. Validar opcionales
        $faltanOpcionales = array_diff($this->documentosOpcionales, $seleccionados);

        if (!empty($faltanOpcionales)) {
            return [
                'puede_guardar' => true,
                'estado_documentos' => 'Incompletos',
                'status_inscripcion' => 'Pendiente',
                'faltantes' => $faltanOpcionales,
            ];
        }

        // 4. Todo completo
        return [
            'puede_guardar' => true,
            'estado_documentos' => 'Completos',
            'status_inscripcion' => 'Activo',
            'faltantes' => [],
        ];
    }

    public function generarObservaciones(array $documentos, bool $requiereAutorizacion): ?string
    {
        $evaluacion = $this->evaluarEstadoDocumentos($documentos, $requiereAutorizacion);

        if (empty($evaluacion['faltantes'])) {
            return null;
        }

        $nombres = array_map(
            fn($doc) => $this->documentosEtiquetas[$doc] ?? ucfirst(str_replace('_', ' ', $doc)),
            $evaluacion['faltantes']
        );

        return 'Documentos pendientes por:' . PHP_EOL . implode(PHP_EOL, $nombres);
    }
}