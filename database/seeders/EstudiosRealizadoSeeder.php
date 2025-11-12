<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EstudiosRealizado; // Ajusta el modelo si tiene otro nombre

class EstudiosRealizadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $titulos = [
            // --- ÁREA ADMINISTRATIVA ---
            ['estudios' => 'Licenciatura en Administración','status'=> true,],
            ['estudios' => 'Licenciatura en Contaduría Pública','status'=> true,],
            ['estudios' => 'Licenciatura en Economía','status'=> true,],
            ['estudios' => 'Licenciatura en Comercio Internacional','status'=> true,],
            ['estudios' => 'Licenciatura en Gerencia de Recursos Humanos','status'=> true,],

            // --- ÁREA DE EDUCACIÓN ---
            ['estudios' => 'Profesor en Educación Integral','status'=> true,],
            ['estudios' => 'Profesor en Educación Física','status'=> true,],
            ['estudios' => 'Profesor en Matemáticas','status'=> true,],
            ['estudios' => 'Profesor en Lengua y Literatura','status'=> true,],
            ['estudios' => 'Profesor en Ciencias Naturales','status'=> true,],

            // --- ÁREA DE INGENIERÍA ---
            ['estudios' => 'Ingeniería Civil','status'=> true,],
            ['estudios' => 'Ingeniería Eléctrica','status'=> true,],
            ['estudios' => 'Ingeniería Electrónica','status'=> true,],
            ['estudios' => 'Ingeniería en Sistemas','status'=> true,],
            ['estudios' => 'Ingeniería Mecánica','status'=> true,],
            ['estudios' => 'Ingeniería Industrial','status'=> true,],
            ['estudios' => 'Ingeniería Química','status'=> true,],
            ['estudios' => 'Ingeniería de Telecomunicaciones','status'=> true,],
            ['estudios' => 'Ingeniería en Informática','status'=> true,],

            // --- ÁREA DE SALUD ---
            ['estudios' => 'Medicina','status'=> true,],
            ['estudios' => 'Odontología','status'=> true,],
            ['estudios' => 'Enfermería','status'=> true,],
            ['estudios' => 'Bioanálisis','status'=> true,],
            ['estudios' => 'Nutrición y Dietética','status'=> true,],
            ['estudios' => 'Fisioterapia','status'=> true,],

            // --- ÁREA DE DERECHO Y CIENCIAS SOCIALES ---
            ['estudios' => 'Derecho','status'=> true,],
            ['estudios' => 'Sociología','status'=> true,],
            ['estudios' => 'Trabajo Social','status'=> true,],
            ['estudios' => 'Ciencia Política','status'=> true,],
            ['estudios' => 'Comunicación Social','status'=> true,],

            // --- ÁREA DE ARTE Y HUMANIDADES ---
            ['estudios' => 'Arquitectura','status'=> true,],
            ['estudios' => 'Artes Plásticas','status'=> true,],
            ['estudios' => 'Diseño Gráfico','status'=> true,],
            ['estudios' => 'Música','status'=> true,],
            ['estudios' => 'Filosofía','status'=> true,],
            ['estudios' => 'Historia','status'=> true,],
            ['estudios' => 'Idiomas Modernos','status'=> true,],

            // --- ÁREA AGROPECUARIA Y AMBIENTAL ---
            ['estudios' => 'Ingeniería Agronómica','status'=> true,],
            ['estudios' => 'Medicina Veterinaria','status'=> true,],
            ['estudios' => 'Gestión Ambiental','status'=> true,],
            ['estudios' => 'Ingeniería Forestal','status'=> true,],

            // --- ÁREA TECNOLÓGICA Y TÉCNICA ---
            ['estudios' => 'Técnico Superior Universitario en Informática','status'=> true,],
            ['estudios' => 'Técnico Superior Universitario en Administración','status'=> true,],
            ['estudios' => 'Técnico Superior Universitario en Electrónica','status'=> true,],
            ['estudios' => 'Técnico Superior Universitario en Construcción Civil','status'=> true,],
            ['estudios' => 'Técnico Superior Universitario en Turismo y Hotelería','status'=> true,],
            ['estudios' => 'Técnico Superior Universitario en Mecánica Industrial','status'=> true,],
        ];

        foreach ($titulos as $titulo) {
            EstudiosRealizado::create($titulo);
        }
        $this->command->info('Titulos universitarios insertados correctamente.');
    }
}
