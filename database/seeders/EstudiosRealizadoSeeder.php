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
            ['estudios' => 'Licenciatura en Administración', 'status' => true,],/* 1 */
            ['estudios' => 'Licenciatura en Contaduría Pública', 'status' => true,],/* 2 */
            ['estudios' => 'Licenciatura en Economía', 'status' => true,],/* 3 */
            ['estudios' => 'Licenciatura en Comercio Internacional', 'status' => true,],/* 4 */
            ['estudios' => 'Licenciatura en Gerencia de Recursos Humanos', 'status' => true,],/* 5 */

            // --- ÁREA DE EDUCACIÓN ---
            ['estudios' => 'Profesor en Educación Integral', 'status' => true,],/* 6 */
            ['estudios' => 'Profesor en Educación Física', 'status' => true,],/* 7 */
            ['estudios' => 'Profesor en Matemáticas', 'status' => true,],/* 8 */
            ['estudios' => 'Profesor en Lengua y Literatura', 'status' => true,],/* 9 */
            ['estudios' => 'Profesor en Ciencias Naturales', 'status' => true,],/* 10 */

            // --- ÁREA DE INGENIERÍA ---
            ['estudios' => 'Ingeniería Civil', 'status' => true,],/* 11 */
            ['estudios' => 'Ingeniería Eléctrica', 'status' => true,],/* 12 */
            ['estudios' => 'Ingeniería Electrónica', 'status' => true,],/* 13 */
            ['estudios' => 'Ingeniería en Sistemas', 'status' => true,],/* 14 */
            ['estudios' => 'Ingeniería Mecánica', 'status' => true,],/* 15 */
            ['estudios' => 'Ingeniería Industrial', 'status' => true,],/* 16 */
            ['estudios' => 'Ingeniería Química', 'status' => true,],/* 17 */
            ['estudios' => 'Ingeniería de Telecomunicaciones', 'status' => true,],/* 18 */
            ['estudios' => 'Ingeniería en Informática', 'status' => true,],/* 19 */

            // --- ÁREA DE SALUD ---
            ['estudios' => 'Medicina', 'status' => true,],/* 20 */
            ['estudios' => 'Enfermería', 'status' => true,],/* 21 */
            ['estudios' => 'Bioanálisis', 'status' => true,],/* 22 */
            ['estudios' => 'Nutrición y Dietética', 'status' => true,],/* 23 */
            ['estudios' => 'Fisioterapia', 'status' => true,],/* 24 */

            // --- ÁREA DE DERECHO Y CIENCIAS SOCIALES ---
            ['estudios' => 'Derecho', 'status' => true,],/* 25 */
            ['estudios' => 'Sociología', 'status' => true,],/* 26 */
            ['estudios' => 'Trabajo Social', 'status' => true,],/* 27 */
            ['estudios' => 'Ciencia Política', 'status' => true,],/* 28 */
            ['estudios' => 'Comunicación Social', 'status' => true,],/* 29 */

            // --- ÁREA DE ARTE Y HUMANIDADES ---
            ['estudios' => 'Arquitectura', 'status' => true,],/* 30 */
            ['estudios' => 'Artes Plásticas', 'status' => true,],/* 31 */
            ['estudios' => 'Diseño Gráfico', 'status' => true,],/* 32 */
            ['estudios' => 'Música', 'status' => true,],/* 33 */
            ['estudios' => 'Filosofía', 'status' => true,],/* 34 */
            ['estudios' => 'Historia', 'status' => true,],/* 35 */
            ['estudios' => 'Idiomas Modernos', 'status' => true,],/* 36 */

            // --- ÁREA AGROPECUARIA Y AMBIENTAL ---
            ['estudios' => 'Ingeniería Agronómica', 'status' => true,],/* 37 */
            ['estudios' => 'Medicina Veterinaria', 'status' => true,],/* 38 */
            ['estudios' => 'Gestión Ambiental', 'status' => true,],/* 39 */
            ['estudios' => 'Ingeniería Forestal', 'status' => true,],/* 40 */

            // --- ÁREA TECNOLÓGICA Y TÉCNICA ---
            ['estudios' => 'Técnico Superior Universitario en Informática', 'status' => true,],/* 41 */
            ['estudios' => 'Técnico Superior Universitario en Administración', 'status' => true,],/* 42 */
            ['estudios' => 'Técnico Superior Universitario en Electrónica', 'status' => true,],/* 43 */
            ['estudios' => 'Técnico Superior Universitario en Construcción Civil', 'status' => true,],/* 44 */
            ['estudios' => 'Técnico Superior Universitario en Turismo y Hotelería', 'status' => true,],/* 45 */
            ['estudios' => 'Técnico Superior Universitario en Mecánica Industrial', 'status' => true,],/* 46 */
            ['estudios' => 'Profesor en Educación Integral', 'status' => true], /* 47 */
            ['estudios' => 'Licenciado en Educación Integral', 'status' => true], /* 48 */
            ['estudios' => 'Licenciado en Educación', 'status' => true], /* 49 */
            ['estudios' => 'Profesor en Educación Inicial', 'status' => true], /* 50 */
            ['estudios' => 'Licenciado en Educación Inicial', 'status' => true], /* 51 */
            ['estudios' => 'Profesor en Educación Especial', 'status' => true], /* 52 */
            ['estudios' => 'Licenciado en Educación Especial', 'status' => true], /* 53 */
            ['estudios' => 'Educación Especial mención Dificultades de Aprendizaje', 'status' => true], /* 54 */
            ['estudios' => 'Educación Especial mención Retardo Mental', 'status' => true], /* 55 */
            ['estudios' => 'Educación Especial mención Deficiencias Auditivas', 'status' => true], /* 56 */
            ['estudios' => 'Educación Especial mención Deficiencias Visuales', 'status' => true], /* 57 */
            ['estudios' => 'Profesor en Educación mención Matemática', 'status' => true], /* 58 */
            ['estudios' => 'Profesor en Educación mención Física', 'status' => true], /* 59 */
            ['estudios' => 'Profesor en Educación mención Química', 'status' => true], /* 60 */
            ['estudios' => 'Profesor en Educación mención Biología', 'status' => true], /* 61 */
            ['estudios' => 'Profesor en Educación mención Ciencias de la Tierra', 'status' => true], /* 62 */
            ['estudios' => 'Profesor en Educación mención Ciencias Sociales', 'status' => true], /* 63 */
            ['estudios' => 'Profesor en Educación mención Historia', 'status' => true], /* 64 */
            ['estudios' => 'Profesor en Educación mención Geografía', 'status' => true], /* 65 */
            ['estudios' => 'Profesor en Educación mención Castellano y Literatura', 'status' => true], /* 66 */
            ['estudios' => 'Profesor en Educación mención Lengua y Literatura', 'status' => true], /* 67 */
            ['estudios' => 'Profesor en Educación mención Inglés', 'status' => true], /* 68 */
            ['estudios' => 'Profesor en Educación mención Francés', 'status' => true], /* 69 */
            ['estudios' => 'Profesor en Educación mención Italiano', 'status' => true], /* 70 */
            ['estudios' => 'Profesor en Educación mención Lenguas Extranjeras', 'status' => true], /* 71 */
            ['estudios' => 'Profesor en Educación mención Educación para el Trabajo', 'status' => true], /* 72 */
            ['estudios' => 'Profesor en Educación mención Educación Comercial', 'status' => true], /* 73 */
            ['estudios' => 'Profesor en Educación mención Administración', 'status' => true], /* 74 */
            ['estudios' => 'Profesor en Educación mención Contabilidad', 'status' => true], /* 75 */
            ['estudios' => 'Profesor en Educación mención Informática', 'status' => true], /* 76 */
            ['estudios' => 'Profesor en Educación Física', 'status' => true], /* 77 */
            ['estudios' => 'Licenciado en Educación Física', 'status' => true], /* 78 */
            ['estudios' => 'Profesor en Educación mención Educación Musical', 'status' => true], /* 79 */
            ['estudios' => 'Profesor en Educación mención Artes Plásticas', 'status' => true], /* 80 */
            ['estudios' => 'Profesor en Educación mención Artes Escénicas', 'status' => true], /* 81 */
            ['estudios' => 'Licenciado en Educación mención Orientación', 'status' => true], /* 82 */
            ['estudios' => 'Profesor en Educación mención Orientación', 'status' => true], /* 83 */
            ['estudios' => 'Licenciado en Educación mención Gerencia Educativa', 'status' => true], /* 84 */
            ['estudios' => 'Licenciado en Educación mención Supervisión Educativa', 'status' => true], /* 85 */
            ['estudios' => 'Licenciado en Educación mención Planificación Educativa', 'status' => true], /* 86 */
            ['estudios' => 'Profesor en Educación Rural', 'status' => true], /* 87 */
            ['estudios' => 'Profesor en Educación de Adultos', 'status' => true], /* 88 */
            ['estudios' => 'Licenciado en Educación de Adultos', 'status' => true], /* 89 */

        ];

        foreach ($titulos as $titulo) {
            EstudiosRealizado::create($titulo);
        }
        $this->command->info('Titulos universitarios insertados correctamente.');
    }
}
