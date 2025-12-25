<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradoAreaFormacionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('grado_area_formacions')->insert([

            /* ===================== 1er GRADO ===================== */
            ['codigo' => '001-CAS', 'grado_id' => 1, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //1
            ['codigo' => '001-AYP', 'grado_id' => 1, 'area_formacion_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //2
            ['codigo' => '001-CNE', 'grado_id' => 1, 'area_formacion_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //3
            ['codigo' => '001-MAT', 'grado_id' => 1, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //4
            ['codigo' => '001-EFU', 'grado_id' => 1, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //5
            ['codigo' => '001-ING', 'grado_id' => 1, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //6
            ['codigo' => '001-GHY', 'grado_id' => 1, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //7
            ['codigo' => '001-SNB', 'grado_id' => 1, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //8 
            ['codigo' => '001-OYC', 'grado_id' => 1, 'area_formacion_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //9

            /* ===================== 2do GRADO ===================== */
            ['codigo' => '002-MAT', 'grado_id' => 2, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //10
            ['codigo' => '002-CAS', 'grado_id' => 2, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //11
            ['codigo' => '002-ING', 'grado_id' => 2, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //12
            ['codigo' => '002-EFU', 'grado_id' => 2, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //13
            ['codigo' => '002-AYP', 'grado_id' => 2, 'area_formacion_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //14
            ['codigo' => '002-CNE', 'grado_id' => 2, 'area_formacion_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //15
            ['codigo' => '002-GHY', 'grado_id' => 2, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //16
            ['codigo' => '002-SNB', 'grado_id' => 2, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //17
            ['codigo' => '002-OYC', 'grado_id' => 2, 'area_formacion_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //18

            /* ===================== 3do GRADO ===================== */
            ['codigo' => '003-MAT', 'grado_id' => 3, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //19
            ['codigo' => '003-CAS', 'grado_id' => 3, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //20
            ['codigo' => '003-ING', 'grado_id' => 3, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //21 
            ['codigo' => '003-EFU', 'grado_id' => 3, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //22
            ['codigo' => '003-FIS', 'grado_id' => 3, 'area_formacion_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //23
            ['codigo' => '003-QUI', 'grado_id' => 3, 'area_formacion_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //24
            ['codigo' => '003-BIO', 'grado_id' => 3, 'area_formacion_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //25
            ['codigo' => '003-GHY', 'grado_id' => 3, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //26
            ['codigo' => '003-SNB', 'grado_id' => 3, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //27
            ['codigo' => '003-OYC', 'grado_id' => 3, 'area_formacion_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //28

            /* ===================== 4do GRADO ===================== */
            ['codigo' => '004-MAT', 'grado_id' => 4, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //29
            ['codigo' => '004-CAS', 'grado_id' => 4, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //30
            ['codigo' => '004-ING', 'grado_id' => 4, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //31
            ['codigo' => '004-EFU', 'grado_id' => 4, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //32
            ['codigo' => '004-FIS', 'grado_id' => 4, 'area_formacion_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //33
            ['codigo' => '004-QUI', 'grado_id' => 4, 'area_formacion_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //34
            ['codigo' => '004-BIO', 'grado_id' => 4, 'area_formacion_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //35
            ['codigo' => '004-GHY', 'grado_id' => 4, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //36
            ['codigo' => '004-SNB', 'grado_id' => 4, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //37
            ['codigo' => '004-OYC', 'grado_id' => 4, 'area_formacion_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //38

            /* ===================== 5do GRADO ===================== */
            ['codigo' => '005-MAT', 'grado_id' => 5, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //39
            ['codigo' => '005-CAS', 'grado_id' => 5, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //40
            ['codigo' => '005-ING', 'grado_id' => 5, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //41
            ['codigo' => '005-EFU', 'grado_id' => 5, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //42
            ['codigo' => '005-FIS', 'grado_id' => 5, 'area_formacion_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //43
            ['codigo' => '005-QUI', 'grado_id' => 5, 'area_formacion_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //44
            ['codigo' => '005-BIO', 'grado_id' => 5, 'area_formacion_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //45
            ['codigo' => '005-GHY', 'grado_id' => 5, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //46
            ['codigo' => '005-SNB', 'grado_id' => 5, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //47
            ['codigo' => '005-OYC', 'grado_id' => 5, 'area_formacion_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //48
        ]);

        $this->command->info('Grado–Área de Formación insertados correctamente.');
    }
}
