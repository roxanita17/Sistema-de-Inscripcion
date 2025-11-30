<?php

namespace Database\Factories;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonaFactory extends Factory
{
public function definition(): array
{
    return [
        'primer_nombre' => $this->faker->firstName(),
        'segundo_nombre' => $this->faker->optional()->firstName(),
        'tercer_nombre' => $this->faker->optional()->firstName(),
        'primer_apellido' => $this->faker->lastName(),
        'segundo_apellido' => $this->faker->lastName(),
        'cedula' => $this->faker->unique()->randomNumber(8 ) ,
        'fecha_nacimiento' => $this->faker->date(),
        'direccion' => $this->faker->address(),
        'email' => $this->faker->email(),
        'status' => 1,

        'tipo_documento_id' => \App\Models\TipoDocumento::inRandomOrder()->first()->id,
        'genero_id' => \App\Models\Genero::inRandomOrder()->first()->id,
        'localidad_id' => \App\Models\Localidad::inRandomOrder()->first()->id,
    ];
}
}
