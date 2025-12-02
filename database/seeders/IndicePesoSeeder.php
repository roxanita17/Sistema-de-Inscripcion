<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndicePesoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('indice_pesos')->insert([
            ['indice' => 1,  'min_kg' => 0,    'max_kg' => 10.0],
            ['indice' => 2,  'min_kg' => 10.1, 'max_kg' => 12.6],
            ['indice' => 3,  'min_kg' => 12.7, 'max_kg' => 15.2],
            ['indice' => 4,  'min_kg' => 15.3, 'max_kg' => 17.8],
            ['indice' => 5,  'min_kg' => 17.9, 'max_kg' => 20.4],
            ['indice' => 6,  'min_kg' => 20.5, 'max_kg' => 23.0],
            ['indice' => 7,  'min_kg' => 23.1, 'max_kg' => 25.6],
            ['indice' => 8,  'min_kg' => 25.7, 'max_kg' => 28.2],
            ['indice' => 9,  'min_kg' => 28.3, 'max_kg' => 30.8],
            ['indice' =>10,  'min_kg' => 30.9, 'max_kg' => 33.4],
            ['indice' =>11,  'min_kg' => 33.5, 'max_kg' => 36.0],
            ['indice' =>12,  'min_kg' => 36.1, 'max_kg' => 38.6],
            ['indice' =>13,  'min_kg' => 38.7, 'max_kg' => 41.2],
            ['indice' =>14,  'min_kg' => 41.3, 'max_kg' => 43.8],
            ['indice' =>15,  'min_kg' => 43.9, 'max_kg' => 46.4],
            ['indice' =>16,  'min_kg' => 46.5, 'max_kg' => 49.0],
            ['indice' =>17,  'min_kg' => 49.1, 'max_kg' => 51.6],
            ['indice' =>18,  'min_kg' => 51.7, 'max_kg' => 54.2],
            ['indice' =>19,  'min_kg' => 54.3, 'max_kg' => 56.8],
            ['indice' =>20,  'min_kg' => 56.9, 'max_kg' => 59.4],
            ['indice' =>21,  'min_kg' => 59.5, 'max_kg' => 62.0],
            ['indice' =>22,  'min_kg' => 62.1, 'max_kg' => 64.6],
            ['indice' =>23,  'min_kg' => 64.7, 'max_kg' => 67.2],
            ['indice' =>24,  'min_kg' => 67.3, 'max_kg' => 69.8],
            ['indice' =>25,  'min_kg' => 69.9, 'max_kg' => 72.4],
            ['indice' =>26,  'min_kg' => 72.5, 'max_kg' => 75.0],
            ['indice' =>27,  'min_kg' => 75.1, 'max_kg' => 77.6],
            ['indice' =>28,  'min_kg' => 77.7, 'max_kg' => 80.2],
            ['indice' =>29,  'min_kg' => 80.3, 'max_kg' => 82.8],
            ['indice' =>30,  'min_kg' => 82.9, 'max_kg' => 100.0],
        ]);

        $this->command->info('Índices de peso insertados correctamente.');
    }
}
