<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaFormacionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('area_formacions')->insert([
            ['nombre_area_formacion' => 'Castellano', 'status' => true], /* 1 */
            ['nombre_area_formacion' => 'Arte y Patrimonio', 'status' => true], /* 2 */
            ['nombre_area_formacion' => 'Ciencias Naturales', 'status' => true], /* 3 */
            ['nombre_area_formacion' => 'Biología', 'status' => true], /* 4 */
            ['nombre_area_formacion' => 'Matemáticas', 'status' => true], /* 5 */
            ['nombre_area_formacion' => 'Educación Física', 'status' => true], /* 6 */
            ['nombre_area_formacion' => 'Inglés y otras lenguas extranjeras', 'status' => true],/* 7 */
            ['nombre_area_formacion' => 'Geografía, Historia y Ciudadania', 'status' => true],/* 8 */
            ['nombre_area_formacion' => 'Ciencias de la Tierra', 'status' => true],/* 9 */
            ['nombre_area_formacion' => 'Física', 'status' => true],/* 10 */
            ['nombre_area_formacion' => 'Química', 'status' => true],/* 11 */
            ['nombre_area_formacion' => 'Formación para la Soberania Nacional', 'status' => true],/* 12 */
            ['nombre_area_formacion' => 'Orientación y Convivencia', 'status' => true],/* 13 */
        ]);
        $this->command->info('Areas de Formación insertados correctamente.');
    }
}
