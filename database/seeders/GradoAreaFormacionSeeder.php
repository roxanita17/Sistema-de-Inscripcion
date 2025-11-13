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
            ['codigo' => 'PDL-001', 'grado_id' => 1, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'AYP-001', 'grado_id' => 1, 'area_formacion_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'CNE-001', 'grado_id' => 1, 'area_formacion_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'BIO-001', 'grado_id' => 1, 'area_formacion_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'MAT-001', 'grado_id' => 1, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'EFU-001', 'grado_id' => 1, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'ING-001', 'grado_id' => 1, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'GHY-001', 'grado_id' => 1, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'CDL-001', 'grado_id' => 1, 'area_formacion_id' => 9, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'FIS-001', 'grado_id' => 1, 'area_formacion_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'QUI-001', 'grado_id' => 1, 'area_formacion_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'SNB-001', 'grado_id' => 1, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

            /* ===================== 2do GRADO ===================== */
            ['codigo' => 'PDL-002', 'grado_id' => 2, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'AYP-002', 'grado_id' => 2, 'area_formacion_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'CNE-002', 'grado_id' => 2, 'area_formacion_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'BIO-002', 'grado_id' => 2, 'area_formacion_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'MAT-002', 'grado_id' => 2, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'EFU-002', 'grado_id' => 2, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'ING-002', 'grado_id' => 2, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'GHY-002', 'grado_id' => 2, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'CDL-002', 'grado_id' => 2, 'area_formacion_id' => 9, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'FIS-002', 'grado_id' => 2, 'area_formacion_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'QUI-002', 'grado_id' => 2, 'area_formacion_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'SNB-002', 'grado_id' => 2, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

            /* ===================== 3er GRADO ===================== */
            ['codigo' => 'PDL-003', 'grado_id' => 3, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'AYP-003', 'grado_id' => 3, 'area_formacion_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'CNE-003', 'grado_id' => 3, 'area_formacion_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'BIO-003', 'grado_id' => 3, 'area_formacion_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'MAT-003', 'grado_id' => 3, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'EFU-003', 'grado_id' => 3, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'ING-003', 'grado_id' => 3, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'GHY-003', 'grado_id' => 3, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'CDL-003', 'grado_id' => 3, 'area_formacion_id' => 9, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'FIS-003', 'grado_id' => 3, 'area_formacion_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'QUI-003', 'grado_id' => 3, 'area_formacion_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'SNB-003', 'grado_id' => 3, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

            /* ===================== 4to GRADO ===================== */
            ['codigo' => 'PDL-004', 'grado_id' => 4, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'AYP-004', 'grado_id' => 4, 'area_formacion_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'CNE-004', 'grado_id' => 4, 'area_formacion_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'BIO-004', 'grado_id' => 4, 'area_formacion_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'MAT-004', 'grado_id' => 4, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'EFU-004', 'grado_id' => 4, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'ING-004', 'grado_id' => 4, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'GHY-004', 'grado_id' => 4, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'CDL-004', 'grado_id' => 4, 'area_formacion_id' => 9, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'FIS-004', 'grado_id' => 4, 'area_formacion_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'QUI-004', 'grado_id' => 4, 'area_formacion_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'SNB-004', 'grado_id' => 4, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],

            /* ===================== 5to GRADO ===================== */
            ['codigo' => 'PDL-005', 'grado_id' => 5, 'area_formacion_id' => 1, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'AYP-005', 'grado_id' => 5, 'area_formacion_id' => 2, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'CNE-005', 'grado_id' => 5, 'area_formacion_id' => 3, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'BIO-005', 'grado_id' => 5, 'area_formacion_id' => 4, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'MAT-005', 'grado_id' => 5, 'area_formacion_id' => 5, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'EFU-005', 'grado_id' => 5, 'area_formacion_id' => 6, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'ING-005', 'grado_id' => 5, 'area_formacion_id' => 7, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'GHY-005', 'grado_id' => 5, 'area_formacion_id' => 8, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'CDL-005', 'grado_id' => 5, 'area_formacion_id' => 9, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'FIS-005', 'grado_id' => 5, 'area_formacion_id' => 10, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'QUI-005', 'grado_id' => 5, 'area_formacion_id' => 11, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['codigo' => 'SNB-005', 'grado_id' => 5, 'area_formacion_id' => 12, 'status' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $this->command->info('Grado–Área de Formación insertados correctamente.');
    }
}
