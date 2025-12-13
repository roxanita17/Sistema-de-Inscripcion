<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('grados')->insert([
            ['numero_grado' => '1', 'status' => true, 'capacidad_max'=> '100', 'max_seccion'=> '30', 'min_seccion'=> '25'],
            ['numero_grado' => '2', 'status' => true, 'capacidad_max'=> '100', 'max_seccion'=> '30', 'min_seccion'=> '25'],
            ['numero_grado' => '3', 'status' => true, 'capacidad_max'=> '100', 'max_seccion'=> '30', 'min_seccion'=> '25'],
            ['numero_grado' => '4', 'status' => true, 'capacidad_max'=> '100', 'max_seccion'=> '30', 'min_seccion'=> '25'], 
            ['numero_grado' => '5', 'status' => true, 'capacidad_max'=> '100', 'max_seccion'=> '30', 'min_seccion'=> '25'],
        ]);
        $this->command->info(string: 'Grados insertados correctamente.');
    }
}
