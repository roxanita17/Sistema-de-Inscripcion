<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaFormacionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('area_formacions')->insert([
            ['nombre_area_formacion' =>  'Castellano', 'codigo_area' => '1', 'siglas' => 'CAST', 'status' => true], /* 1 */
            ['nombre_area_formacion' => 'Arte y Patrimonio', 'codigo_area' => '2', 'siglas' => 'ART', 'status' => true], /* 2 */
            ['nombre_area_formacion' => 'Ciencias Naturales', 'codigo_area' => '3', 'siglas' => 'CIN', 'status' => true], /* 3 */
            ['nombre_area_formacion' => 'Biología', 'codigo_area' => '4', 'siglas' => 'BIO', 'status' => true], /* 4 */
            ['nombre_area_formacion' => 'Matemáticas', 'codigo_area' => '5', 'siglas' => 'MAT', 'status' => true], /* 5 */
            ['nombre_area_formacion' => 'Educación Física', 'codigo_area' => '6', 'siglas' => 'EDF', 'status' => true], /* 6 */
            ['nombre_area_formacion' => 'Inglés y otras lenguas extranjeras', 'codigo_area' => '7', 'siglas' => 'IEL', 'status' => true],/* 7 */
            ['nombre_area_formacion' => 'Geografía, Historia y Ciudadania', 'codigo_area' => '8', 'siglas' => 'GHC', 'status' => true],/* 8 */
            ['nombre_area_formacion' => 'Ciencias de la Tierra', 'codigo_area' => '9', 'siglas' => 'CTI', 'status' => true],/* 9 */
            ['nombre_area_formacion' => 'Física', 'codigo_area' => '10', 'siglas' => 'FIS', 'status' => true],/* 10 */
            ['nombre_area_formacion' => 'Química', 'codigo_area' => '11', 'siglas' => 'QUI', 'status' => true],/* 11 */
            ['nombre_area_formacion' => 'Formación para la Soberania Nacional', 'codigo_area' => '12', 'siglas' => 'FSN', 'status' => true],/* 12 */
            ['nombre_area_formacion' => 'Orientación y Convivencia', 'codigo_area' => '13', 'siglas' => 'OC', 'status' => true],/* 13 */
        ]);
        $this->command->info('Areas de Formación insertados correctamente.');
    }
}
