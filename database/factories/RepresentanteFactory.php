<?php

namespace Database\Factories;

use App\Models\Persona;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Localidad;
use App\Models\Ocupacion;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepresentanteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'persona_id' => Persona::inRandomOrder()->first()->id,
            'estado_id' => Estado::inRandomOrder()->first()->id,
            
            'municipio_id' => Municipio::inRandomOrder()->first()->id,
            'parroquia_id' => Localidad::inRandomOrder()->first()->id,
            'ocupacion_representante' => Ocupacion::inRandomOrder()->first()->id,
            'convivenciaestudiante_representante' => $this->faker->word(),
        ];
    }
}
