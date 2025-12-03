<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\OrdenNacimiento;
use App\Models\Discapacidad;
use App\Models\EtniaIndigena;
use App\Models\ExpresionLiteraria;
use App\Models\InstitucionProcedencia;
use App\Models\Lateralidad;
use App\Models\Persona;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alumno>
 */
class AlumnoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero_zonificacion'  => $this->faker->numerify('###'),
            'anio_egreso' => $this->faker->date('Y-m-d'),
            'talla_camisa' => $this->faker->numberBetween(36, 46),
            'talla_pantalon' => $this->faker->numberBetween(36, 46),
            'tallas_zapato' => $this->faker->numberBetween(36, 46),
            'peso' => $this->faker->numberBetween(36, 46),
            'estatura' => $this->faker->numberBetween(36, 46),
            

            'orden_nacimiento_id'       => OrdenNacimiento::inRandomOrder()->value('id'),
            'institucion_procedencia_id'       => InstitucionProcedencia::inRandomOrder()->value('id'),
            'expresion_literaria_id'       => ExpresionLiteraria::inRandomOrder()->value('id'),
            'lateralidad_id'       => Lateralidad::inRandomOrder()->value('id'),
            'persona_id'       => Persona::inRandomOrder()->value('id'),

            'status'           => 'Activo',
        ];
    }
}
