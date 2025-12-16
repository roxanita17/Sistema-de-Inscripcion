<?php

namespace Database\Factories;

use App\Models\Docente;
use App\Models\Persona;
use App\Models\TipoDocumento;
use App\Models\Genero;
use App\Models\PrefijoTelefono;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocenteFactory extends Factory
{
    protected $model = Docente::class;

    public function definition(): array
    {
        return [
            
            'codigo'           => $this->faker->optional()->bothify('DOC-###'),
            'dependencia'      => $this->faker->optional()->randomElement([
                'Matemáticas',
                'Ciencias Sociales',
                'Castellano',
                'Educación Física',
                'Coordinación Académica',
            ]),
            

            
            'persona_id'       => Persona::inRandomOrder()->value('id'),

            'status'           => true,
        ];
    }

    /**
     * Crear persona asociada automáticamente
     */

}
