<?php
// database/seeders/EtniasIndigenasSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EtniaIndigena;

class EtniaIndigenaSeeder extends Seeder
{
    public function run()
    {
        $nombre = [
            'Wayuu',
            'Warao',
            'Pemón',
            'Yanomami',
            'Kariña',
            'Yekuana',
            'Piaroa',
            'Guajibo',
            'Barí',
            'Yukpa',
            'Añú',
            'Japreria',
            'Baniva',
            'Puinave',
            'Curripaco',
            'Warekena',
            'Panare',
            'Pumé',
            'Jodi',
            'Sanemá',
            'Mapoyo',
            'Yavarana',
            'Hoti',
            'Eñepá',
            'Akawaio',
            'Wotjuja',
            'Chaima',
            'Cumanagoto',
            'Guanono',
            'Maco',
            'Piapoco',
            'Saliva',
            'Sape',
            'Uruak',
            'Waikerí',
            'Amorua',
            'Yeral',
            'Karua',
            'Mako',
            'Yabarana',
            'Panare',
            'Wüinaji',
            'Dearu',
            'Jirajara',
            'Timoto-cuicas',
            'Gayon',
            'Ayaman',
            'Ajagua',
            'Taparita',
            'Otomaco',
            'Taparita',
            'Yaruro'
        ];

        foreach ($nombre as $etnia) {
            EtniaIndigena::firstOrCreate(['nombre' => $etnia,
        'status' => true]);
        }

        $this->command->info('Seeder de etnias indígenas ejecutado correctamente. Se insertaron etnias.');
    }
}
