<?php

namespace Database\Seeders;

use App\Models\AnioEscolar;
use App\Models\EtniaIndigena;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        AnioEscolar::factory(1)->create([
            'inicio_anio_escolar' => '2025-01-01',
            'cierre_anio_escolar' => '2025-12-31',
            'extencion_anio_escolar' => '2026-01-01',
            'status' => 'Activo',
        ]);

        EtniaIndigena::factory(20)->create();
            

        User::factory()->create([
            'name' => 'Nohely Sosa',
            'email' => 'nohelysq2006@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
    }
}
