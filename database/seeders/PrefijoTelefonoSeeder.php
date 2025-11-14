<?php
// database/seeders/EtniasIndigenasSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PrefijoTelefono;
use Illuminate\Support\Facades\DB;


class PrefijoTelefonoSeeder extends Seeder
{
    public function run()
    {
        $prefijos = [
            '0412',
            '0416',
            '0424',
            '0426',
            '0414',
            '0422',
        ];

        foreach ($prefijos as $prefijo) {
            DB::table('prefijo_telefonos')->insert([
                'prefijo' => $prefijo,
                'status' => true,
            ]);
        }

        $this->command->info(string: 'Seeder de prefijos ejecutado correctamente.');
    }
}
