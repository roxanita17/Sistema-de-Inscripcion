<?php

namespace App\DTOs;

class InscripcionData
{
    public ?int $alumno_id;
    public ?string $numero_zonificacion;
    public ?int $institucion_procedencia_id;
    public ?int $inscripcion_id;
    public ?string $anio_egreso;
    public ?bool $promovido;
    public ?bool $repite_grado;
    public ?int $expresion_literaria_id;
    public ?string $tipo_inscripcion;
    public ?int $grado_id;
    public ?int $seccion_id;
    public ?int $padre_id;
    public ?int $madre_id;
    public ?int $representante_legal_id;
    public array $documentos;
    public ?string $fecha_inscripcion;
    public ?string $observaciones;
    public bool $acepta_normas_contrato;
    public ?int $anio_escolar_id;

    public function __construct(array $data)
    {
        $this->alumno_id = $data['alumno_id'] ?? null;
        $this->numero_zonificacion = $data['numero_zonificacion'] ?? null;
        $this->institucion_procedencia_id = $data['institucion_procedencia_id'] ?? null;
        $this->inscripcion_id = $data['inscripcion_id'] ?? null;
        $this->anio_egreso = $data['anio_egreso'] ?? null;
        $this->promovido = $data['promovido'] ?? null;
        $this->repite_grado = $data['repite_grado'] ?? null;
        $this->expresion_literaria_id = $data['expresion_literaria_id'] ?? null;
        $this->tipo_inscripcion = $data['tipo_inscripcion'] ?? null;
        $this->grado_id = $data['grado_id'] ?? null;
        $this->seccion_id = $data['seccion_id'] ?? null;
        $this->padre_id = $data['padre_id'] ?? null;
        $this->madre_id = $data['madre_id'] ?? null;
        $this->representante_legal_id = $data['representante_legal_id'] ?? null;
        $this->documentos = $data['documentos'] ?? [];
        $this->fecha_inscripcion = $data['fecha_inscripcion'] ?? null;
        $this->observaciones = $data['observaciones'] ?? null;
        $this->acepta_normas_contrato = $data['acepta_normas_contrato'] ?? false;
        $this->anio_escolar_id = $data['anio_escolar_id'] ?? null;
    }
}