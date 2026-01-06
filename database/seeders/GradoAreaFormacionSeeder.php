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
            ['codigo' => '1-001-CAS', 'grado_id' => 1, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //1
            ['codigo' => '2-001-AYP', 'grado_id' => 1, 'area_formacion_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //2
            ['codigo' => '3-001-CNE', 'grado_id' => 1, 'area_formacion_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //3
            ['codigo' => '5-001-MAT', 'grado_id' => 1, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //4
            ['codigo' => '6-001-EFU', 'grado_id' => 1, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //5
            ['codigo' => '7-001-ING', 'grado_id' => 1, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //6
            ['codigo' => '8-001-GHY', 'grado_id' => 1, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //7
            ['codigo' => '12-001-SNB', 'grado_id' => 1, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //8 
            ['codigo' => '13-001-OYC', 'grado_id' => 1, 'area_formacion_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //9

            /* ===================== 2do GRADO ===================== */
            ['codigo' => '5-002-MAT', 'grado_id' => 2, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //10
            ['codigo' => '1-002-CAS', 'grado_id' => 2, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //11
            ['codigo' => '7-002-ING', 'grado_id' => 2, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //12
            ['codigo' => '6-002-EFU', 'grado_id' => 2, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //13
            ['codigo' => '2-002-AYP', 'grado_id' => 2, 'area_formacion_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //14
            ['codigo' => '3-002-CNE', 'grado_id' => 2, 'area_formacion_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //15
            ['codigo' => '8-002-GHY', 'grado_id' => 2, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //16
            ['codigo' => '12-002-SNB', 'grado_id' => 2, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //17
            ['codigo' => '13-002-OYC', 'grado_id' => 2, 'area_formacion_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //18

            /* ===================== 3do GRADO ===================== */
            ['codigo' => '5-003-MAT', 'grado_id' => 3, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //19
            ['codigo' => '1-003-CAS', 'grado_id' => 3, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //20
            ['codigo' => '7-003-ING', 'grado_id' => 3, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //21 
            ['codigo' => '6-003-EFU', 'grado_id' => 3, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //22
            ['codigo' => '10-003-FIS', 'grado_id' => 3, 'area_formacion_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //23
            ['codigo' => '11-003-QUI', 'grado_id' => 3, 'area_formacion_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //24
            ['codigo' => '4-003-BIO', 'grado_id' => 3, 'area_formacion_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //25
            ['codigo' => '8-003-GHY', 'grado_id' => 3, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //26
            ['codigo' => '12-003-SNB', 'grado_id' => 3, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //27
            ['codigo' => '13-003-OYC', 'grado_id' => 3, 'area_formacion_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //28

            /* ===================== 4do GRADO ===================== */
            ['codigo' => '5-004-MAT', 'grado_id' => 4, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //29
            ['codigo' => '1-004-CAS', 'grado_id' => 4, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //30
            ['codigo' => '7-004-ING', 'grado_id' => 4, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //31
            ['codigo' => '6-004-EFU', 'grado_id' => 4, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //32
            ['codigo' => '10-004-FIS', 'grado_id' => 4, 'area_formacion_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //33
            ['codigo' => '11-004-QUI', 'grado_id' => 4, 'area_formacion_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //34
            ['codigo' => '4-004-BIO', 'grado_id' => 4, 'area_formacion_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //35
            ['codigo' => '8-004-GHY', 'grado_id' => 4, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //36
            ['codigo' => '12-004-SNB', 'grado_id' => 4, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //37
            ['codigo' => '13-004-OYC', 'grado_id' => 4, 'area_formacion_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //38

            /* ===================== 5do GRADO ===================== */
            ['codigo' => '5-005-MAT', 'grado_id' => 5, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //39
            ['codigo' => '1-005-CAS', 'grado_id' => 5, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //40
            ['codigo' => '7-005-ING', 'grado_id' => 5, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //41
            ['codigo' => '6-005-EFU', 'grado_id' => 5, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //42
            ['codigo' => '10-005-FIS', 'grado_id' => 5, 'area_formacion_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //43
            ['codigo' => '11-005-QUI', 'grado_id' => 5, 'area_formacion_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //44
            ['codigo' => '4-005-BIO', 'grado_id' => 5, 'area_formacion_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //45
            ['codigo' => '8-005-GHY', 'grado_id' => 5, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //46
            ['codigo' => '12-005-SNB', 'grado_id' => 5, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //47
            ['codigo' => '13-005-OYC', 'grado_id' => 5, 'area_formacion_id' => 13, 'status' => true, 'created_at' => now(), 'updated_at' => now()], //48
        ]);

        $this->command->info('Grado–Área de Formación insertados correctamente.');
    }
}
