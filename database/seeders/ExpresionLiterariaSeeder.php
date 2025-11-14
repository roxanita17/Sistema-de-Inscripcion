<?php
// database/seeders/EtniasIndigenasSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpresionLiteraria;

class ExpresionLiterariaSeeder extends Seeder
{
    public function run()
    {
        $letra = [
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
        ];

        foreach ($letra as $letra_expresion_literaria) {
            ExpresionLiteraria::firstOrCreate(['letra_expresion_literaria' => $letra_expresion_literaria,
        'status' => true]);
        }

        $this->command->info(string: 'Seeder de expresiones literarias ejecutado correctamente. Se insertaron expresiones literarias.');
    }
}
