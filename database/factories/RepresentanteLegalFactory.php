<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Representante;
use App\Models\Banco;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RepresentanteLegal>
 */
class RepresentanteLegalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'representante_id' => Representante::inRandomOrder()->first()->id,
            'banco_id' => Banco::inRandomOrder()->first()->id,
            'tipo_cuenta' => $this->faker->word(),
            'parentesco' => $this->faker->word(),
            'correo_representante' => $this->faker->email(),
            'pertenece_a_organizacion_representante' => $this->faker->boolean(),
            'cual_organizacion_representante' => $this->faker->word(),
            'carnet_patria_afiliado' => $this->faker->boolean(),
            'serial_carnet_patria_representante' => $this->faker->word(),
            'codigo_carnet_patria_representante' => $this->faker->word(),
            'direccion_representante' => $this->faker->word(),
            'estados_representante' => $this->faker->word(),
        ];
    }
}
