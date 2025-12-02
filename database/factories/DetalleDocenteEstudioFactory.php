<?php

namespace Database\Factories;

use App\Models\DetalleDocenteEstudio;
use App\Models\Docente;
use App\Models\EstudiosRealizado;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetalleDocenteEstudioFactory extends Factory
{
    protected $model = DetalleDocenteEstudio::class;

    public function definition(): array
    {
        return [
            'docente_id'  => Docente::inRandomOrder()->value('id'),
            'estudios_id' => EstudiosRealizado::inRandomOrder()->value('id'),

            'status'      => true,
        ];
    }
}
