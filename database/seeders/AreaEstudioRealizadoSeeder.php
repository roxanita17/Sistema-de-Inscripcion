<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AreaEstudioRealizado;
use App\Models\AreaFormacion;
use App\Models\EstudiosRealizado;

class AreaEstudioRealizadoSeeder extends Seeder
{
    public function run(): void
    {
        $areas   = AreaFormacion::all();
        $titulos = EstudiosRealizado::all();

        /**
         * Asignaciones Area ↔ Estudio
         * ORDENADAS POR estudios_id
         */
        $asignaciones = [

            // --- LICENCIATURAS / ADMINISTRACIÓN ---
            ['area_id' => 5, 'titulo_id' => 1],  // Lic. Administración
            ['area_id' => 5, 'titulo_id' => 2],  // Lic. Contaduría
            ['area_id' => 5, 'titulo_id' => 3],  // Lic. Economía
            ['area_id' => 1, 'titulo_id' => 4],
            ['area_id' => 1, 'titulo_id' => 5],

            // --- EDUCACIÓN ---
            ['area_id' => 1, 'titulo_id' => 6],  // Prof. Educación Integral
            ['area_id' => 1, 'titulo_id' => 7],  // Prof. Educación Física
            ['area_id' => 6, 'titulo_id' => 8],  // Prof. Matemáticas
            ['area_id' => 1, 'titulo_id' => 9],
            ['area_id' => 3, 'titulo_id' => 10], // Prof. Ciencias Naturales

            // --- INGENIERÍAS ---
            ['area_id' => 10, 'titulo_id' => 11], // Ing. Civil
            ['area_id' => 10, 'titulo_id' => 12], // Ing. Eléctrica
            ['area_id' => 10, 'titulo_id' => 13], // Ing. Electrónica
            ['area_id' => 5, 'titulo_id' => 14],  // Ing. Sistemas
            ['area_id' => 5, 'titulo_id' => 15],  // Ing. Mecánica
            ['area_id' => 11, 'titulo_id' => 16], // Ing. Industrial
            ['area_id' => 3, 'titulo_id' => 17],  // Ing. Química
            ['area_id' => 1, 'titulo_id' => 18],
            ['area_id' => 1, 'titulo_id' => 19],

            // --- SALUD ---
            ['area_id' => 4, 'titulo_id' => 20], // Medicina
            ['area_id' => 4, 'titulo_id' => 21], // Enfermería
            ['area_id' => 3, 'titulo_id' => 22], // Bioanálisis
            ['area_id' => 3, 'titulo_id' => 23], // Nutrición
            ['area_id' => 2, 'titulo_id' => 24], // Fisioterapia

            // --- CIENCIAS SOCIALES ---
            ['area_id' => 8, 'titulo_id' => 25], // Derecho
            ['area_id' => 8, 'titulo_id' => 26], // Sociología
            ['area_id' => 8, 'titulo_id' => 27], // Trabajo Social
            ['area_id' => 12, 'titulo_id' => 28], // Ciencia Política
            ['area_id' => 1, 'titulo_id' => 29],

            // --- ARTE Y HUMANIDADES ---
            ['area_id' => 2, 'titulo_id' => 30], // Arquitectura
            ['area_id' => 2, 'titulo_id' => 31], // Artes Plásticas
            ['area_id' => 2, 'titulo_id' => 32], // Diseño Gráfico
            ['area_id' => 2, 'titulo_id' => 33], // Música
            ['area_id' => 1, 'titulo_id' => 34], // Filosofía
            ['area_id' => 1, 'titulo_id' => 35],
            ['area_id' => 1, 'titulo_id' => 36], // Idiomas Modernos

            // --- AGROPECUARIA / AMBIENTAL ---
            ['area_id' => 9, 'titulo_id' => 37], // Ing. Agronómica
            ['area_id' => 1, 'titulo_id' => 38],
            ['area_id' => 3, 'titulo_id' => 39], // Gestión Ambiental
            ['area_id' => 3, 'titulo_id' => 40], // Ing. Forestal

            // --- TÉCNICOS ---
            ['area_id' => 5, 'titulo_id' => 41], // TSU Informática
            ['area_id' => 5, 'titulo_id' => 42], // TSU Administración
            ['area_id' => 5, 'titulo_id' => 43], // TSU Electrónica
            ['area_id' => 5, 'titulo_id' => 44], // TSU Construcción
            ['area_id' => 6, 'titulo_id' => 45], // TSU Turismo
            ['area_id' => 6, 'titulo_id' => 46], // TSU Mecánica
        ];

        foreach ($asignaciones as $asignacion) {

            $area = $areas->firstWhere('id', $asignacion['area_id']);
            $titulo = $titulos->firstWhere('id', $asignacion['titulo_id']);

            if ($area && $titulo) {
                AreaEstudioRealizado::create([
                    'area_formacion_id' => $area->id,
                    'estudios_id' => $titulo->id,
                    'status' => true,
                ]);
            } else {
                $this->command->warn(
                    "No se pudo asociar Area ID {$asignacion['area_id']} con Título ID {$asignacion['titulo_id']}"
                );
            }
        }

        $this->command->info('Todas las áreas y estudios quedaron correctamente asociados.');
    }
}
