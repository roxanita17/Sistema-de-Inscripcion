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
            ['codigo' => '001-PDL', 'grado_id' => 1, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => '001-AYP', 'grado_id' => 1, 'area_formacion_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => '001-CNE', 'grado_id' => 1, 'area_formacion_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => '001-MAT', 'grado_id' => 1, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => '001-EFU', 'grado_id' => 1, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => '001-ING', 'grado_id' => 1, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => '001-GHY', 'grado_id' => 1, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => '001-SNB', 'grado_id' => 1, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

        ]);

        $this->command->info('Grado–Área de Formación insertados correctamente.');
    }
}
