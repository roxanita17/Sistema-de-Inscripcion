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
        $areas = AreaFormacion::all();
        $titulos = EstudiosRealizado::all();
        $asignaciones = [

            // --- PRÁCTICAS DEL LENGUAJE ---
            ['area' => 'Prácticas del Lenguaje', 'titulo' => 'Profesor en Educación Integral'],
            ['area' => 'Prácticas del Lenguaje', 'titulo' => 'Profesor en Lengua y Literatura'],
            ['area' => 'Prácticas del Lenguaje', 'titulo' => 'Idiomas Modernos'],

            // --- ARTE Y PATRIMONIO ---
            ['area' => 'Arte y Patrimonio', 'titulo' => 'Diseño Gráfico'],
            ['area' => 'Arte y Patrimonio', 'titulo' => 'Música'],
            ['area' => 'Arte y Patrimonio', 'titulo' => 'Artes Plásticas'],
            ['area' => 'Arte y Patrimonio', 'titulo' => 'Arquitectura'],

            // --- CIENCIAS NATURALES ---
            ['area' => 'Ciencias Naturales', 'titulo' => 'Profesor en Ciencias Naturales'],
            ['area' => 'Ciencias Naturales', 'titulo' => 'Bioanálisis'],
            ['area' => 'Ciencias Naturales', 'titulo' => 'Nutrición y Dietética'],
            ['area' => 'Ciencias Naturales', 'titulo' => 'Gestión Ambiental'],
            ['area' => 'Ciencias Naturales', 'titulo' => 'Ingeniería Forestal'],

            // --- BIOLOGÍA ---
            ['area' => 'Biología', 'titulo' => 'Medicina'],
            ['area' => 'Biología', 'titulo' => 'Enfermería'],

            // --- MATEMÁTICAS ---
            ['area' => 'Matemáticas', 'titulo' => 'Licenciatura en Administración'],
            ['area' => 'Matemáticas', 'titulo' => 'Licenciatura en Contaduría Pública'],
            ['area' => 'Matemáticas', 'titulo' => 'Licenciatura en Economía'],
            ['area' => 'Matemáticas', 'titulo' => 'Ingeniería en Sistemas'],
            ['area' => 'Matemáticas', 'titulo' => 'Ingeniería Industrial'],
            ['area' => 'Matemáticas', 'titulo' => 'Técnico Superior Universitario en Informática'],

            // --- EDUCACIÓN FÍSICA ---
            ['area' => 'Educación Física', 'titulo' => 'Profesor en Educación Física'],
            ['area' => 'Educación Física', 'titulo' => 'Técnico Superior Universitario en Turismo y Hotelería'],

            // --- INGLÉS ---
            ['area' => 'Inglés', 'titulo' => 'Idiomas Modernos'],

            // --- GEOGRAFÍA, HISTORIA Y CIUDADANÍA ---
            ['area' => 'Geografía, Historia y Ciudadania', 'titulo' => 'Derecho'],
            ['area' => 'Geografía, Historia y Ciudadania', 'titulo' => 'Trabajo Social'],
            ['area' => 'Geografía, Historia y Ciudadania', 'titulo' => 'Comunicación Social'],
            ['area' => 'Geografía, Historia y Ciudadania', 'titulo' => 'Historia'],

            // --- CIENCIAS DE LA TIERRA ---
            ['area' => 'Ciencias de la Tierra', 'titulo' => 'Ingeniería Agronómica'],

            // --- FÍSICA ---
            ['area' => 'Física', 'titulo' => 'Ingeniería Civil'],
            ['area' => 'Física', 'titulo' => 'Ingeniería Eléctrica'],
            ['area' => 'Física', 'titulo' => 'Ingeniería Electrónica'],

            // --- QUÍMICA ---
            ['area' => 'Química', 'titulo' => 'Ingeniería Química'],

            // --- SOBERANÍA NACIONAL ---
            ['area' => 'Soberania Nacional', 'titulo' => 'Ciencia Política'],

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
                $this->command->warn(" No se pudo asociar: {$asignacion['area']} ↔ {$asignacion['titulo']}");
            }
        }

        $this->command->info('Todas las áreas y estudios quedaron correctamente asociados.');
    }
}
