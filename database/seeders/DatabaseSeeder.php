<?php

namespace Database\Seeders;

use App\Models\AnioEscolar;
use App\Models\EtniaIndigena;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Localidad;
use App\Models\EstudiosRealizado;
use App\Models\AreaEstudioRealizado;
use App\Models\GradoAreaFormacion;
use App\Models\Discapacidad;
use App\Models\Ocupacion;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // User::factory(10)->create();
        $this->command->info('Iniciando seeders...');


        AnioEscolar::factory(1)->create([
            'inicio_anio_escolar' => '2025-01-01',
            'cierre_anio_escolar' => '2025-12-31',
            'extencion_anio_escolar' => '2026-01-01',
            'status' => 'Activo',
        ]);


        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('12345678'),
        ]);

        $this->call([
            GradoSeeder::class,
            AreaFormacionSeeder::class,
            EstadoSeeder::class,
            MunicipioSeeder::class,
            LocalidadSeeder::class,
            EstudiosRealizadoSeeder::class,
            AreaEstudioRealizadoSeeder::class,
            GradoAreaFormacionSeeder::class,
            EtniaIndigenaSeeder::class,
            DiscapacidadSeeder::class,
            OcupacionSeeder::class,
        ]);
        $this->command->info('¡Base de datos poblada con éxito!');

    }
}
