<?php

namespace App\Actions\Alumno;

use App\Models\Persona;
use App\Models\Alumno;

class CrearAlumnoAction
{
    public function ejecutar(array $datos): Alumno
    {
        $persona = Persona::create([
            'primer_nombre' => $datos['primer_nombre'],
            'segundo_nombre' => $datos['segundo_nombre'] ?? null,
            'tercer_nombre' => $datos['tercer_nombre'] ?? null,
            'primer_apellido' => $datos['primer_apellido'],
            'segundo_apellido' => $datos['segundo_apellido'] ?? null,
            'tipo_documento_id' => $datos['tipo_documento_id'],
            'numero_documento' => $datos['numero_documento'],
            'genero_id' => $datos['genero_id'],
            'fecha_nacimiento' => $datos['fecha_nacimiento'],
            'localidad_id' => $datos['localidad_id'],
            'status' => true,
        ]);

        return Alumno::create([
            'persona_id' => $persona->id,
            'talla_camisa' => $datos['talla_camisa'],
            'talla_pantalon' => $datos['talla_pantalon'],
            'talla_zapato' => $datos['talla_zapato'],
            'peso' => $datos['peso_estudiante'],
            'estatura' => $datos['talla_estudiante'],
            'lateralidad_id' => $datos['lateralidad_id'],
            'orden_nacimiento_id' => $datos['orden_nacimiento_id'],
            'status' => 'Activo',
        ]);
    }
}
