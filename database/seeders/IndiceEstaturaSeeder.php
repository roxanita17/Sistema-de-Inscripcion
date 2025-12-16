<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndiceEstaturaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('indice_estaturas')->insert([
            ['indice' => 1,  'min_cm' => 0,     'max_cm' => 80.0],
            ['indice' => 2,  'min_cm' => 80.1,  'max_cm' => 83.6],
            ['indice' => 3,  'min_cm' => 83.7,  'max_cm' => 87.2],
            ['indice' => 4,  'min_cm' => 87.3,  'max_cm' => 90.8],
            ['indice' => 5,  'min_cm' => 90.9,  'max_cm' => 94.4],
            ['indice' => 6,  'min_cm' => 94.5,  'max_cm' => 98.0],
            ['indice' => 7,  'min_cm' => 98.1,  'max_cm' => 101.6],
            ['indice' => 8,  'min_cm' => 101.7, 'max_cm' => 105.2],
            ['indice' => 9,  'min_cm' => 105.3, 'max_cm' => 108.8],
            ['indice' =>10,  'min_cm' => 108.9, 'max_cm' => 112.4],
            ['indice' =>11,  'min_cm' => 112.5, 'max_cm' => 116.0],
            ['indice' =>12,  'min_cm' => 116.1, 'max_cm' => 119.6],
            ['indice' =>13,  'min_cm' => 119.7, 'max_cm' => 123.2],
            ['indice' =>14,  'min_cm' => 123.3, 'max_cm' => 126.8],
            ['indice' =>15,  'min_cm' => 126.9, 'max_cm' => 130.4],
            ['indice' =>16,  'min_cm' => 130.5, 'max_cm' => 134.0],
            ['indice' =>17,  'min_cm' => 134.1, 'max_cm' => 137.6],
            ['indice' =>18,  'min_cm' => 137.7, 'max_cm' => 141.2],
            ['indice' =>19,  'min_cm' => 141.3, 'max_cm' => 144.8],
            ['indice' =>20,  'min_cm' => 144.9, 'max_cm' => 148.4],
            ['indice' =>21,  'min_cm' => 148.5, 'max_cm' => 152.0],
            ['indice' =>22,  'min_cm' => 152.1, 'max_cm' => 155.6],
            ['indice' =>23,  'min_cm' => 155.7, 'max_cm' => 159.2],
            ['indice' =>24,  'min_cm' => 159.3, 'max_cm' => 162.8],
            ['indice' =>25,  'min_cm' => 162.9, 'max_cm' => 166.4],
            ['indice' =>26,  'min_cm' => 166.5, 'max_cm' => 170.0],
            ['indice' =>27,  'min_cm' => 170.1, 'max_cm' => 173.6],
            ['indice' =>28,  'min_cm' => 173.7, 'max_cm' => 177.2],
            ['indice' =>29,  'min_cm' => 177.3, 'max_cm' => 180.8],
            ['indice' =>30,  'min_cm' => 180.9, 'max_cm' => 184.4],
        ]);

        $this->command->info('Índices de estatura insertados correctamente.');
    }
}
