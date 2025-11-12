<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AreaEstudioRealizado; // Ajusta al nombre real de tu modelo pivot/intermedio
use App\Models\AreaFormacion;
use App\Models\EstudiosRealizado;

class AreaEstudioRealizadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = AreaFormacion::all();
        $titulos = EstudiosRealizado::all();

        if ($areas->isEmpty() || $titulos->isEmpty()) {
            $this->command->warn('⚠️ No se encontraron registros en áreas o estudios realizados. Ejecuta primero los seeders correspondientes.');
            return;
        }

        $asignaciones = [
            // --- ADMINISTRATIVAS ---
            ['area' => 'Matemáticas', 'titulo' => 'Licenciatura en Administración'],
            ['area' => 'Matemáticas', 'titulo' => 'Licenciatura en Contaduría Pública'],
            ['area' => 'Matemáticas', 'titulo' => 'Licenciatura en Economía'],

            // --- EDUCACIÓN ---
            ['area' => 'Prácticas del Lenguaje', 'titulo' => 'Profesor en Educación Integral'],
            ['area' => 'Educación Física', 'titulo' => 'Profesor en Educación Física'],
            ['area' => 'Prácticas del Lenguaje', 'titulo' => 'Profesor en Lengua y Literatura'],

            // --- INGENIERÍA ---
            ['area' => 'Física', 'titulo' => 'Ingeniería Civil'],
            ['area' => 'Física', 'titulo' => 'Ingeniería Eléctrica'],
            ['area' => 'Matemáticas', 'titulo' => 'Ingeniería en Sistemas'],
            ['area' => 'Matemáticas', 'titulo' => 'Ingeniería Industrial'],
            ['area' => 'Química', 'titulo' => 'Ingeniería Química'],

            // --- SALUD ---
            ['area' => 'Biología', 'titulo' => 'Medicina'],
            ['area' => 'Biología', 'titulo' => 'Enfermería'],
            ['area' => 'Ciencias Naturales', 'titulo' => 'Bioanálisis'],
            ['area' => 'Ciencias Naturales', 'titulo' => 'Nutrición y Dietética'],

            // --- DERECHO Y SOCIALES ---
            ['area' => 'Geografía, Historia y Ciudadania', 'titulo' => 'Derecho'],
            ['area' => 'Geografía, Historia y Ciudadania', 'titulo' => 'Trabajo Social'],
            ['area' => 'Geografía, Historia y Ciudadania', 'titulo' => 'Comunicación Social'],

            // --- HUMANIDADES Y ARTE ---
            ['area' => 'Arte y Patrimonio', 'titulo' => 'Diseño Gráfico'],
            ['area' => 'Arte y Patrimonio', 'titulo' => 'Música'],
            ['area' => 'Prácticas del Lenguaje', 'titulo' => 'Idiomas Modernos'],
            ['area' => 'Arte y Patrimonio', 'titulo' => 'Artes Plásticas'],

            // --- AGRO Y AMBIENTAL ---
            ['area' => 'Ciencias de la Tierra', 'titulo' => 'Ingeniería Agronómica'],
            ['area' => 'Ciencias Naturales', 'titulo' => 'Gestión Ambiental'],
            ['area' => 'Ciencias Naturales', 'titulo' => 'Ingeniería Forestal'],

            // --- TECNOLÓGICA ---
            ['area' => 'Matemáticas', 'titulo' => 'Técnico Superior Universitario en Informática'],
            ['area' => 'Educación Física', 'titulo' => 'Técnico Superior Universitario en Turismo y Hotelería'],
        ];

        foreach ($asignaciones as $asignacion) {
            $area = $areas->where('nombre_area_formacion', $asignacion['area'])->first();
            $titulo = $titulos->where('estudios', $asignacion['titulo'])->first();

            if ($area && $titulo) {
                AreaEstudioRealizado::create([
                    'area_formacion_id' => $area->id,
                    'estudios_id' => $titulo->id,
                    'status' => true,
                ]);
            } else {
                $this->command->warn("⚠️ No se pudo asociar: {$asignacion['area']} ↔ {$asignacion['titulo']}");
            }
        }

        $this->command->info('✅ Áreas de Formación y Estudios Realizados asociados correctamente.');
    }
}
