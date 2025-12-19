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
        ];

        foreach ($titulos as $titulo) {
            EstudiosRealizado::create($titulo);
        }
        $this->command->info('Titulos universitarios insertados correctamente.');
    }
}
