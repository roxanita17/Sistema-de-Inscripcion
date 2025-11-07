<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AnioEscolar>
 */
class AnioEscolarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'inicio_anio_escolar' => $this->faker->date(),
            'cierre_anio_escolar' => $this->faker->date(),
            'extencion_anio_escolar' => $this->faker->date(),
            'status' => $this->faker->randomElement(['Inactivo', 'En Espera', 'Activo', 'Extendido']),
        ];
    }
}
