<?php
// database/seeders/EtniasIndigenasSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lateralidad;

class LateralidadSeeder extends Seeder
{
    public function run()
    {
        $lateralidads = [
            'Derecho',
            'Izquierdo',
            'Ambidextro',
        ];

        foreach ($lateralidads as $lateralidad) {
            Lateralidad::firstOrCreate(['lateralidad' => $lateralidad,
            'status' => true]);
        }

        $this->command->info(string: 'Seeder de lateralidades ejecutado correctamente. Se insertaron lateralidades.');
    }

}


