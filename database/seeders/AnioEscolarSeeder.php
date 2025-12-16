<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnioEscolarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('anio_escolars')->insert([
            ['inicio_anio_escolar' => '2023-01-01', 'status' => 'Inactivo', 'cierre_anio_escolar' => '2024-12-31'],
            ['inicio_anio_escolar' => '2024-01-01', 'status' => 'Inactivo', 'cierre_anio_escolar' => '2025-12-31'],
            ['inicio_anio_escolar' => '2025-01-01', 'status' => 'Activo', 'cierre_anio_escolar' => '2026-12-31'],
            
        ]);
        $this->command->info(string: 'Anio escolar insertados correctamente.');
    }
}
