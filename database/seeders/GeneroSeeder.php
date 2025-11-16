<?php
// database/seeders/EtniasIndigenasSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genero;

class GeneroSeeder extends Seeder
{
    public function run()
    {
        $generos = [
            'Masculino',
            'Femenino',
            'Otro',
        ];

        foreach ($generos as $genero) {
            Genero::firstOrCreate(['genero' => $genero,
        'status' => true]);
        }

        $this->command->info(string: 'Seeder de generos ejecutado correctamente. Se insertaron generos.');
    }

}


