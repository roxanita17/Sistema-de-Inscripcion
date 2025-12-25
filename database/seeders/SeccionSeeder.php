<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('seccions')->insert([
            /* Grado 2 */
            ['nombre' => 'Seccion A', 'cantidad_actual' => '0', 'grado_id' => '2', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion B', 'cantidad_actual' => '0', 'grado_id' => '2', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion C', 'cantidad_actual' => '0', 'grado_id' => '2', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion D', 'cantidad_actual' => '0', 'grado_id' => '2', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion E', 'cantidad_actual' => '0', 'grado_id' => '2', 'ejecucion_percentil_id' => null, 'status' => true, ],
            /* Grado 3 */
            ['nombre' => 'Seccion A', 'cantidad_actual' => '0', 'grado_id' => '3', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion B', 'cantidad_actual' => '0', 'grado_id' => '3', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion C', 'cantidad_actual' => '0', 'grado_id' => '3', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion D', 'cantidad_actual' => '0', 'grado_id' => '3', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion E', 'cantidad_actual' => '0', 'grado_id' => '3', 'ejecucion_percentil_id' => null, 'status' => true, ],
            /* Grado 4 */
            ['nombre' => 'Seccion A', 'cantidad_actual' => '0', 'grado_id' => '4', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion B', 'cantidad_actual' => '0', 'grado_id' => '4', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion C', 'cantidad_actual' => '0', 'grado_id' => '4', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion D', 'cantidad_actual' => '0', 'grado_id' => '4', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion E', 'cantidad_actual' => '0', 'grado_id' => '4', 'ejecucion_percentil_id' => null, 'status' => true, ],
            /* Grado 5 */
            ['nombre' => 'Seccion A', 'cantidad_actual' => '0', 'grado_id' => '5', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion B', 'cantidad_actual' => '0', 'grado_id' => '5', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion C', 'cantidad_actual' => '0', 'grado_id' => '5', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion D', 'cantidad_actual' => '0', 'grado_id' => '5', 'ejecucion_percentil_id' => null, 'status' => true, ],
            ['nombre' => 'Seccion E', 'cantidad_actual' => '0', 'grado_id' => '5', 'ejecucion_percentil_id' => null, 'status' => true, ],
        ]);
        $this->command->info(string: 'Secciones insertadas correctamente.');
    }
}
