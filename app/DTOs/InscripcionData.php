<?php

namespace App\DTOs;

class InscripcionData
{
    public ?int $alumno_id;
    public ?string $numero_zonificacion;
    public ?int $institucion_procedencia_id;
    public ?string $anio_egreso;
    public ?int $expresion_literaria_id;
    public ?int $grado_id;
    public ?int $padre_id;
    public ?int $madre_id;
    public ?int $representante_legal_id;
    public array $documentos;
    public ?string $fecha_inscripcion;
    public ?string $observaciones;
    public bool $acepta_normas_contrato;

    public function __construct(array $data)
    {
        $this->alumno_id = $data['alumno_id'] ?? null;
        $this->numero_zonificacion = $data['numero_zonificacion'] ?? null;
        $this->institucion_procedencia_id = $data['institucion_procedencia_id'] ?? null;
        $this->anio_egreso = $data['anio_egreso'] ?? null;
        $this->expresion_literaria_id = $data['expresion_literaria_id'] ?? null;
        $this->grado_id = $data['grado_id'] ?? null;
        $this->padre_id = $data['padre_id'] ?? null;
        $this->madre_id = $data['madre_id'] ?? null;
        $this->representante_legal_id = $data['representante_legal_id'] ?? null;
        $this->documentos = $data['documentos'] ?? [];
        $this->fecha_inscripcion = $data['fecha_inscripcion'] ?? null;
        $this->observaciones = $data['observaciones'] ?? null;
        $this->acepta_normas_contrato = $data['acepta_normas_contrato'] ?? false;
    }
}