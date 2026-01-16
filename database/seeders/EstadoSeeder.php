<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EstadoSeeder extends Seeder
{
    /** 
     * Run the database seeds.
     */
   public function run(): void
    {
        $estados = [
            ['id' => 1, 'pais_id' => 242, 'nombre_estado' => 'Amazonas'],
            ['id' => 2, 'pais_id' => 242, 'nombre_estado' => 'Anzoátegui'],
            ['id' => 3, 'pais_id' => 242, 'nombre_estado' => 'Apure'],
            ['id' => 4, 'pais_id' => 242, 'nombre_estado' => 'Aragua'],
            ['id' => 5, 'pais_id' => 242, 'nombre_estado' => 'Barinas'],
            ['id' => 6, 'pais_id' => 242, 'nombre_estado' => 'Bolívar'],
            ['id' => 7, 'pais_id' => 242, 'nombre_estado' => 'Carabobo'],
            ['id' => 8, 'pais_id' => 242, 'nombre_estado' => 'Cojedes'],
            ['id' => 9, 'pais_id' => 242, 'nombre_estado' => 'Delta Amacuro'],
            ['id' => 10, 'pais_id' => 242, 'nombre_estado' => 'Distrito Capital'],
            ['id' => 11, 'pais_id' => 242, 'nombre_estado' => 'Falcón'],
            ['id' => 12, 'pais_id' => 242, 'nombre_estado' => 'Guárico'],
            ['id' => 13, 'pais_id' => 242, 'nombre_estado' => 'Lara'],
            ['id' => 14, 'pais_id' => 242, 'nombre_estado' => 'Mérida'],
            ['id' => 15, 'pais_id' => 242, 'nombre_estado' => 'Miranda'],
            ['id' => 16, 'pais_id' => 242, 'nombre_estado' => 'Monagas'],
            ['id' => 17, 'pais_id' => 242, 'nombre_estado' => 'Nueva Esparta'],
            ['id' => 18, 'pais_id' => 242, 'nombre_estado' => 'Portuguesa'],
            ['id' => 19, 'pais_id' => 242, 'nombre_estado' => 'Sucre'],
            ['id' => 20, 'pais_id' => 242, 'nombre_estado' => 'Táchira'],
            ['id' => 21, 'pais_id' => 242, 'nombre_estado' => 'Trujillo'],
            ['id' => 22, 'pais_id' => 242, 'nombre_estado' => 'Vargas'],
            ['id' => 23, 'pais_id' => 242, 'nombre_estado' => 'Yaracuy'],
            ['id' => 24, 'pais_id' => 242, 'nombre_estado' => 'Zulia'],
        ];
        $this->command->info('Estados insertados correctamente.');

        DB::table('estados')->insert($estados);
    }
}
