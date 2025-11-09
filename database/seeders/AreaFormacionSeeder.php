<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaFormacionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('area_formacions')->insert([
            ['nombre_area_formacion' => 'Prácticas del Lenguaje', 'status' => true],
            ['nombre_area_formacion' => 'Arte y Patrimonio', 'status' => true],
            ['nombre_area_formacion' => 'Ciencias Naturales', 'status' => true],
            ['nombre_area_formacion' => 'Biología', 'status' => true], 
            ['nombre_area_formacion' => 'Matemáticas', 'status' => true],
            ['nombre_area_formacion' => 'Educación Física', 'status' => true],
            ['nombre_area_formacion' => 'Inglés', 'status' => true],
            ['nombre_area_formacion' => 'Geografía, Historia y Ciudadania', 'status' => true],
            ['nombre_area_formacion' => 'Ciencias de la Tierra', 'status' => true],
            ['nombre_area_formacion' => 'Física', 'status' => true],
            ['nombre_area_formacion' => 'Química', 'status' => true],
            ['nombre_area_formacion' => 'Soberania Nacional', 'status' => true],
        ]);
        $this->command->info('Areas de Formación insertados correctamente.');
    }
}
