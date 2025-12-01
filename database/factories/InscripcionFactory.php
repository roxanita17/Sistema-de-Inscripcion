<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Alumno;
use App\Models\Representante;
use App\Models\Grado;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inscripcion>
 */
class InscripcionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'alumno_id' => Alumno::inRandomOrder()->first()->id,
            'representante_id' => Representante::inRandomOrder()->first()->id,
            'grado_id' => Grado::inRandomOrder()->first()->id,
            'status' => 'Activo',
        ];
    }
}
