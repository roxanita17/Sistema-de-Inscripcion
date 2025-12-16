<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndiceEdadSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('indice_edads')->insert([
            ['indice' => 1,  'min_meses' => 0,   'max_meses' => 72], //6.0 o menos
            ['indice' => 2,  'min_meses' => 73,  'max_meses' => 77], //6.1 a 6.5
            ['indice' => 3,  'min_meses' => 78,  'max_meses' => 82], //6.6 a 6.10
            ['indice' => 4,  'min_meses' => 83,  'max_meses' => 86], //6.11 a 7.2
            ['indice' => 5,  'min_meses' => 87,  'max_meses' => 91], //7.3 a 7.7
            ['indice' => 6,  'min_meses' => 92,  'max_meses' => 96], //7.8 a 8.0
            ['indice' => 7,  'min_meses' => 97,  'max_meses' => 101], //8.1 a 8.5
            ['indice' => 8,  'min_meses' => 102, 'max_meses' => 106], //8.6 a 9.0
            ['indice' => 9,  'min_meses' => 107, 'max_meses' => 111], //9.1 a 9.5
            ['indice' =>10,  'min_meses' => 112, 'max_meses' => 116], //9.6 a 9.10
            ['indice' =>11,  'min_meses' => 117, 'max_meses' => 121], //9.11 a 10.0
            ['indice' =>12,  'min_meses' => 122, 'max_meses' => 126], //10.1 a 10.5
            ['indice' =>13,  'min_meses' => 127, 'max_meses' => 131], //10.6 a 10.10
            ['indice' =>14,  'min_meses' => 132, 'max_meses' => 135], //10.11 a 11.2
            ['indice' =>15,  'min_meses' => 136, 'max_meses' => 140], //11.3 a 11.7
            ['indice' =>16,  'min_meses' => 141, 'max_meses' => 145], //11.8 a 12.0
            ['indice' =>17,  'min_meses' => 146, 'max_meses' => 150], //12.1 a 12.5
            ['indice' =>18,  'min_meses' => 151, 'max_meses' => 155], //12.6 a 12.10
            ['indice' =>19,  'min_meses' => 156, 'max_meses' => 160], //12.11 a 13.2
            ['indice' =>20,  'min_meses' => 161, 'max_meses' => 165], //13.3 a 13.7
            ['indice' =>21,  'min_meses' => 166, 'max_meses' => 170], //13.8 a 14.0
            ['indice' =>22,  'min_meses' => 171, 'max_meses' => 175], //14.1 a 14.5
            ['indice' =>23,  'min_meses' => 176, 'max_meses' => 180], //14.6 a 14.10
            ['indice' =>24,  'min_meses' => 181, 'max_meses' => 185], //14.11 a 15.2
            ['indice' =>25,  'min_meses' => 186, 'max_meses' => 190], //15.3 a 15.7
            ['indice' =>26,  'min_meses' => 191, 'max_meses' => 195], //15.8 a 16.0
            ['indice' =>27,  'min_meses' => 196, 'max_meses' => 200], //16.1 a 16.5
            ['indice' =>28,  'min_meses' => 201, 'max_meses' => 205], //16.6 a 16.10
            ['indice' =>29,  'min_meses' => 206, 'max_meses' => 210], //16.11 a 17.2
            ['indice' =>30,  'min_meses' => 211, 'max_meses' => 215], //17.3 a 17.7
        ]);

        $this->command->info('Índices de edad insertados correctamente.');
    }
}
