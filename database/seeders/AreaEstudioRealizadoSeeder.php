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

        $asignaciones = [
            ['area_id' => 5,  'titulo_id' => 1], 
            ['area_id' => 8,  'titulo_id' => 1], 
            ['area_id' => 12, 'titulo_id' => 1], 
            ['area_id' => 13, 'titulo_id' => 1], // Orientación y Convivencia

            /* Estudio 2 - Licenciatura en Contaduría Pública */
            ['area_id' => 5,  'titulo_id' => 2], // Matemáticas
            ['area_id' => 12, 'titulo_id' => 2], // Formación para la Soberanía Nacional
            ['area_id' => 13, 'titulo_id' => 2], // Orientación y Convivencia

            /* Estudio 3 - Licenciatura en Economía */
            ['area_id' => 5,  'titulo_id' => 3], // Matemáticas
            ['area_id' => 8,  'titulo_id' => 3], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 3], // Formación para la Soberanía Nacional
            ['area_id' => 13, 'titulo_id' => 3], // Orientación y Convivencia

            /* Estudio 4 - Licenciatura en Comercio Internacional */
            ['area_id' => 5,  'titulo_id' => 4], // Matemáticas
            ['area_id' => 7,  'titulo_id' => 4], // Inglés y otras lenguas extranjeras
            ['area_id' => 8,  'titulo_id' => 4], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 4], // Formación para la Soberanía Nacional

            /* Estudio 5 - Licenciatura en Gerencia de Recursos Humanos */
            ['area_id' => 5,  'titulo_id' => 5], // Matemáticas
            ['area_id' => 12, 'titulo_id' => 5], // Formación para la Soberanía Nacional
            ['area_id' => 13, 'titulo_id' => 5], // Orientación y Convivencia

            // ============================================
            // ÁREA DE EDUCACIÓN (6-10)
            // ============================================

            /* Estudio 6 - Profesor en Educación Integral */
            ['area_id' => 1, 'titulo_id' => 6], // Castellano
            ['area_id' => 2, 'titulo_id' => 6], // Arte y Patrimonio
            ['area_id' => 3, 'titulo_id' => 6], // Ciencias Naturales
            ['area_id' => 5, 'titulo_id' => 6], // Matemáticas
            ['area_id' => 6, 'titulo_id' => 6], // Educación Física
            ['area_id' => 8, 'titulo_id' => 6], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 6], // Formación para la Soberanía Nacional
            ['area_id' => 13, 'titulo_id' => 6], // Orientación y Convivencia

            /* Estudio 7 - Profesor en Educación Física */
            ['area_id' => 6, 'titulo_id' => 7], // Educación Física
            ['area_id' => 4, 'titulo_id' => 7], // Biología
            ['area_id' => 12, 'titulo_id' => 7], // Formación para la Soberanía Nacional

            /* Estudio 8 - Profesor en Matemáticas */
            ['area_id' => 5, 'titulo_id' => 8], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 8], // Física
            ['area_id' => 12, 'titulo_id' => 8], // Formación para la Soberanía Nacional

            /* Estudio 9 - Profesor en Lengua y Literatura */
            ['area_id' => 1, 'titulo_id' => 9], // Castellano
            ['area_id' => 2, 'titulo_id' => 9], // Arte y Patrimonio
            ['area_id' => 8, 'titulo_id' => 9], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 9], // Formación para la Soberanía Nacional

            /* Estudio 10 - Profesor en Ciencias Naturales */
            ['area_id' => 3,  'titulo_id' => 10], // Ciencias Naturales
            ['area_id' => 4,  'titulo_id' => 10], // Biología
            ['area_id' => 9,  'titulo_id' => 10], // Ciencias de la Tierra
            ['area_id' => 10, 'titulo_id' => 10], // Física
            ['area_id' => 11, 'titulo_id' => 10], // Química
            ['area_id' => 12, 'titulo_id' => 10], // Formación para la Soberanía Nacional

            // ============================================
            // ÁREA DE INGENIERÍA (11-19)
            // ============================================

            /* Estudio 11 - Ingeniería Civil */
            ['area_id' => 5,  'titulo_id' => 11], // Matemáticas
            ['area_id' => 9,  'titulo_id' => 11], // Ciencias de la Tierra
            ['area_id' => 10, 'titulo_id' => 11], // Física
            ['area_id' => 11, 'titulo_id' => 11], // Química

            /* Estudio 12 - Ingeniería Eléctrica */
            ['area_id' => 5,  'titulo_id' => 12], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 12], // Física
            ['area_id' => 11, 'titulo_id' => 12], // Química

            /* Estudio 13 - Ingeniería Electrónica */
            ['area_id' => 5,  'titulo_id' => 13], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 13], // Física
            ['area_id' => 11, 'titulo_id' => 13], // Química

            /* Estudio 14 - Ingeniería en Sistemas */
            ['area_id' => 5,  'titulo_id' => 14], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 14], // Física
            ['area_id' => 7,  'titulo_id' => 14], // Inglés

            /* Estudio 15 - Ingeniería Mecánica */
            ['area_id' => 5,  'titulo_id' => 15], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 15], // Física
            ['area_id' => 11, 'titulo_id' => 15], // Química

            /* Estudio 16 - Ingeniería Industrial */
            ['area_id' => 5,  'titulo_id' => 16], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 16], // Física
            ['area_id' => 11, 'titulo_id' => 16], // Química

            /* Estudio 17 - Ingeniería Química */
            ['area_id' => 5,  'titulo_id' => 17], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 17], // Física
            ['area_id' => 11, 'titulo_id' => 17], // Química
            ['area_id' => 4,  'titulo_id' => 17], // Biología

            /* Estudio 18 - Ingeniería de Telecomunicaciones */
            ['area_id' => 5,  'titulo_id' => 18], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 18], // Física
            ['area_id' => 7,  'titulo_id' => 18], // Inglés

            /* Estudio 19 - Ingeniería en Informática */
            ['area_id' => 5,  'titulo_id' => 19], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 19], // Física
            ['area_id' => 7,  'titulo_id' => 19], // Inglés

            // ============================================
            // ÁREA DE SALUD (20-24)
            // ============================================

            /* Estudio 20 - Medicina */
            ['area_id' => 3,  'titulo_id' => 20], // Ciencias Naturales
            ['area_id' => 4,  'titulo_id' => 20], // Biología
            ['area_id' => 10, 'titulo_id' => 20], // Física
            ['area_id' => 11, 'titulo_id' => 20], // Química

            /* Estudio 21 - Enfermería */
            ['area_id' => 3,  'titulo_id' => 21], // Ciencias Naturales
            ['area_id' => 4,  'titulo_id' => 21], // Biología
            ['area_id' => 11, 'titulo_id' => 21], // Química

            /* Estudio 22 - Bioanálisis */
            ['area_id' => 3,  'titulo_id' => 22], // Ciencias Naturales
            ['area_id' => 4,  'titulo_id' => 22], // Biología
            ['area_id' => 11, 'titulo_id' => 22], // Química
            ['area_id' => 10, 'titulo_id' => 22], // Física

            /* Estudio 23 - Nutrición y Dietética */
            ['area_id' => 3,  'titulo_id' => 23], // Ciencias Naturales
            ['area_id' => 4,  'titulo_id' => 23], // Biología
            ['area_id' => 11, 'titulo_id' => 23], // Química

            /* Estudio 24 - Fisioterapia */
            ['area_id' => 3,  'titulo_id' => 24], // Ciencias Naturales
            ['area_id' => 4,  'titulo_id' => 24], // Biología
            ['area_id' => 10, 'titulo_id' => 24], // Física

            // ============================================
            // ÁREA DE DERECHO Y CIENCIAS SOCIALES (25-29)
            // ============================================

            /* Estudio 25 - Derecho */
            ['area_id' => 1,  'titulo_id' => 25], // Castellano
            ['area_id' => 8,  'titulo_id' => 25], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 25], // Formación para la Soberanía Nacional

            /* Estudio 26 - Sociología */
            ['area_id' => 1,  'titulo_id' => 26], // Castellano
            ['area_id' => 8,  'titulo_id' => 26], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 26], // Formación para la Soberanía Nacional
            ['area_id' => 5,  'titulo_id' => 26], // Matemáticas

            /* Estudio 27 - Trabajo Social */
            ['area_id' => 1,  'titulo_id' => 27], // Castellano
            ['area_id' => 8,  'titulo_id' => 27], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 27], // Formación para la Soberanía Nacional
            ['area_id' => 13, 'titulo_id' => 27], // Orientación y Convivencia

            /* Estudio 28 - Ciencia Política */
            ['area_id' => 1,  'titulo_id' => 28], // Castellano
            ['area_id' => 8,  'titulo_id' => 28], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 28], // Formación para la Soberanía Nacional

            /* Estudio 29 - Comunicación Social */
            ['area_id' => 1,  'titulo_id' => 29], // Castellano
            ['area_id' => 2,  'titulo_id' => 29], // Arte y Patrimonio
            ['area_id' => 8,  'titulo_id' => 29], // Geografía, Historia y Ciudadanía
            ['area_id' => 7,  'titulo_id' => 29], // Inglés

            // ============================================
            // ÁREA DE ARTE Y HUMANIDADES (30-36)
            // ============================================

            /* Estudio 30 - Arquitectura */
            ['area_id' => 2,  'titulo_id' => 30], // Arte y Patrimonio
            ['area_id' => 5,  'titulo_id' => 30], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 30], // Física
            ['area_id' => 8,  'titulo_id' => 30], // Geografía, Historia y Ciudadanía

            /* Estudio 31 - Artes Plásticas */
            ['area_id' => 2,  'titulo_id' => 31], // Arte y Patrimonio
            ['area_id' => 8,  'titulo_id' => 31], // Geografía, Historia y Ciudadanía

            /* Estudio 32 - Diseño Gráfico */
            ['area_id' => 2,  'titulo_id' => 32], // Arte y Patrimonio
            ['area_id' => 5,  'titulo_id' => 32], // Matemáticas

            /* Estudio 33 - Música */
            ['area_id' => 2,  'titulo_id' => 33], // Arte y Patrimonio
            ['area_id' => 5,  'titulo_id' => 33], // Matemáticas

            /* Estudio 34 - Filosofía */
            ['area_id' => 1,  'titulo_id' => 34], // Castellano
            ['area_id' => 8,  'titulo_id' => 34], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 34], // Formación para la Soberanía Nacional

            /* Estudio 35 - Historia */
            ['area_id' => 1,  'titulo_id' => 35], // Castellano
            ['area_id' => 8,  'titulo_id' => 35], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 35], // Formación para la Soberanía Nacional

            /* Estudio 36 - Idiomas Modernos */
            ['area_id' => 1,  'titulo_id' => 36], // Castellano
            ['area_id' => 7,  'titulo_id' => 36], // Inglés y otras lenguas extranjeras
            ['area_id' => 8,  'titulo_id' => 36], // Geografía, Historia y Ciudadanía

            // ============================================
            // ÁREA AGROPECUARIA Y AMBIENTAL (37-40)
            // ============================================

            /* Estudio 37 - Ingeniería Agronómica */
            ['area_id' => 3,  'titulo_id' => 37], // Ciencias Naturales
            ['area_id' => 4,  'titulo_id' => 37], // Biología
            ['area_id' => 9,  'titulo_id' => 37], // Ciencias de la Tierra
            ['area_id' => 11, 'titulo_id' => 37], // Química
            ['area_id' => 5,  'titulo_id' => 37], // Matemáticas

            /* Estudio 38 - Medicina Veterinaria */
            ['area_id' => 3,  'titulo_id' => 38], // Ciencias Naturales
            ['area_id' => 4,  'titulo_id' => 38], // Biología
            ['area_id' => 11, 'titulo_id' => 38], // Química

            /* Estudio 39 - Gestión Ambiental */
            ['area_id' => 3,  'titulo_id' => 39], // Ciencias Naturales
            ['area_id' => 4,  'titulo_id' => 39], // Biología
            ['area_id' => 9,  'titulo_id' => 39], // Ciencias de la Tierra
            ['area_id' => 11, 'titulo_id' => 39], // Química
            ['area_id' => 8,  'titulo_id' => 39], // Geografía, Historia y Ciudadanía

            /* Estudio 40 - Ingeniería Forestal */
            ['area_id' => 3,  'titulo_id' => 40], // Ciencias Naturales
            ['area_id' => 4,  'titulo_id' => 40], // Biología
            ['area_id' => 9,  'titulo_id' => 40], // Ciencias de la Tierra
            ['area_id' => 5,  'titulo_id' => 40], // Matemáticas

            // ============================================
            // ÁREA TECNOLÓGICA Y TÉCNICA (41-46)
            // ============================================

            /* Estudio 41 - TSU en Informática */
            ['area_id' => 5,  'titulo_id' => 41], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 41], // Física
            ['area_id' => 7,  'titulo_id' => 41], // Inglés

            /* Estudio 42 - TSU en Administración */
            ['area_id' => 5,  'titulo_id' => 42], // Matemáticas
            ['area_id' => 1,  'titulo_id' => 42], // Castellano
            ['area_id' => 12, 'titulo_id' => 42], // Formación para la Soberanía Nacional

            /* Estudio 43 - TSU en Electrónica */
            ['area_id' => 5,  'titulo_id' => 43], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 43], // Física
            ['area_id' => 11, 'titulo_id' => 43], // Química

            /* Estudio 44 - TSU en Construcción Civil */
            ['area_id' => 5,  'titulo_id' => 44], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 44], // Física
            ['area_id' => 9,  'titulo_id' => 44], // Ciencias de la Tierra

            /* Estudio 45 - TSU en Turismo y Hotelería */
            ['area_id' => 1,  'titulo_id' => 45], // Castellano
            ['area_id' => 7,  'titulo_id' => 45], // Inglés
            ['area_id' => 8,  'titulo_id' => 45], // Geografía, Historia y Ciudadanía

            /* Estudio 46 - TSU en Mecánica Industrial */
            ['area_id' => 5,  'titulo_id' => 46], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 46], // Física
            ['area_id' => 11, 'titulo_id' => 46], // Química

            // ============================================
            // EDUCACIÓN INTEGRAL (47-51)
            // ============================================

            /* Estudio 47 - Profesor en Educación Integral */
            ['area_id' => 1,  'titulo_id' => 47], // Castellano
            ['area_id' => 2,  'titulo_id' => 47], // Arte y Patrimonio
            ['area_id' => 3,  'titulo_id' => 47], // Ciencias Naturales
            ['area_id' => 5,  'titulo_id' => 47], // Matemáticas
            ['area_id' => 6,  'titulo_id' => 47], // Educación Física
            ['area_id' => 8,  'titulo_id' => 47], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 47], // Formación para la Soberanía Nacional
            ['area_id' => 13, 'titulo_id' => 47], // Orientación y Convivencia

            /* Estudio 48 - Licenciado en Educación Integral */
            ['area_id' => 1,  'titulo_id' => 48], // Castellano
            ['area_id' => 2,  'titulo_id' => 48], // Arte y Patrimonio
            ['area_id' => 3,  'titulo_id' => 48], // Ciencias Naturales
            ['area_id' => 5,  'titulo_id' => 48], // Matemáticas
            ['area_id' => 6,  'titulo_id' => 48], // Educación Física
            ['area_id' => 8,  'titulo_id' => 48], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 48], // Formación para la Soberanía Nacional
            ['area_id' => 13, 'titulo_id' => 48], // Orientación y Convivencia

            /* Estudio 49 - Licenciado en Educación */
            ['area_id' => 1,  'titulo_id' => 49], // Castellano
            ['area_id' => 2,  'titulo_id' => 49], // Arte y Patrimonio
            ['area_id' => 3,  'titulo_id' => 49], // Ciencias Naturales
            ['area_id' => 5,  'titulo_id' => 49], // Matemáticas
            ['area_id' => 8,  'titulo_id' => 49], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 49], // Formación para la Soberanía Nacional
            ['area_id' => 13, 'titulo_id' => 49], // Orientación y Convivencia

            /* Estudio 50 - Profesor en Educación Inicial */
            ['area_id' => 1,  'titulo_id' => 50], // Castellano
            ['area_id' => 2,  'titulo_id' => 50], // Arte y Patrimonio
            ['area_id' => 5,  'titulo_id' => 50], // Matemáticas
            ['area_id' => 6,  'titulo_id' => 50], // Educación Física
            ['area_id' => 13, 'titulo_id' => 50], // Orientación y Convivencia

            /* Estudio 51 - Licenciado en Educación Inicial */
            ['area_id' => 1,  'titulo_id' => 51], // Castellano
            ['area_id' => 2,  'titulo_id' => 51], // Arte y Patrimonio
            ['area_id' => 5,  'titulo_id' => 51], // Matemáticas
            ['area_id' => 6,  'titulo_id' => 51], // Educación Física
            ['area_id' => 13, 'titulo_id' => 51], // Orientación y Convivencia

            // ============================================
            // EDUCACIÓN ESPECIAL (52-57)
            // ============================================

            /* Estudio 52 - Profesor en Educación Especial */
            ['area_id' => 1,  'titulo_id' => 52], // Castellano
            ['area_id' => 5,  'titulo_id' => 52], // Matemáticas
            ['area_id' => 2,  'titulo_id' => 52], // Arte y Patrimonio
            ['area_id' => 13, 'titulo_id' => 52], // Orientación y Convivencia

            /* Estudio 53 - Licenciado en Educación Especial */
            ['area_id' => 1,  'titulo_id' => 53], // Castellano
            ['area_id' => 5,  'titulo_id' => 53], // Matemáticas
            ['area_id' => 2,  'titulo_id' => 53], // Arte y Patrimonio
            ['area_id' => 13, 'titulo_id' => 53], // Orientación y Convivencia

            /* Estudio 54 - Educación Especial mención Dificultades de Aprendizaje */
            ['area_id' => 1,  'titulo_id' => 54], // Castellano
            ['area_id' => 5,  'titulo_id' => 54], // Matemáticas
            ['area_id' => 13, 'titulo_id' => 54], // Orientación y Convivencia

            /* Estudio 55 - Educación Especial mención Retardo Mental */
            ['area_id' => 1,  'titulo_id' => 55], // Castellano
            ['area_id' => 5,  'titulo_id' => 55], // Matemáticas
            ['area_id' => 13, 'titulo_id' => 55], // Orientación y Convivencia

            /* Estudio 56 - Educación Especial mención Deficiencias Auditivas */
            ['area_id' => 1,  'titulo_id' => 56], // Castellano
            ['area_id' => 2,  'titulo_id' => 56], // Arte y Patrimonio
            ['area_id' => 13, 'titulo_id' => 56], // Orientación y Convivencia

            /* Estudio 57 - Educación Especial mención Deficiencias Visuales */
            ['area_id' => 1,  'titulo_id' => 57], // Castellano
            ['area_id' => 2,  'titulo_id' => 57], // Arte y Patrimonio
            ['area_id' => 13, 'titulo_id' => 57], // Orientación y Convivencia

            // ============================================
            // EDUCACIÓN MENCIÓN CIENCIAS (58-62)
            // ============================================

            /* Estudio 58 - Profesor en Educación mención Matemática */
            ['area_id' => 5,  'titulo_id' => 58], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 58], // Física
            ['area_id' => 12, 'titulo_id' => 58], // Formación para la Soberanía Nacional

            /* Estudio 59 - Profesor en Educación mención Física */
            ['area_id' => 10, 'titulo_id' => 59], // Física
            ['area_id' => 5,  'titulo_id' => 59], // Matemáticas
            ['area_id' => 11, 'titulo_id' => 59], // Química
            ['area_id' => 12, 'titulo_id' => 59], // Formación para la Soberanía Nacional

            /* Estudio 60 - Profesor en Educación mención Química */
            ['area_id' => 11, 'titulo_id' => 60], // Química
            ['area_id' => 5,  'titulo_id' => 60], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 60], // Física
            ['area_id' => 4,  'titulo_id' => 60], // Biología
            ['area_id' => 12, 'titulo_id' => 60], // Formación para la Soberanía Nacional

            /* Estudio 61 - Profesor en Educación mención Biología */
            ['area_id' => 4,  'titulo_id' => 61], // Biología
            ['area_id' => 3,  'titulo_id' => 61], // Ciencias Naturales
            ['area_id' => 11, 'titulo_id' => 61], // Química
            ['area_id' => 12, 'titulo_id' => 61], // Formación para la Soberanía Nacional

            /* Estudio 62 - Profesor en Educación mención Ciencias de la Tierra */
            ['area_id' => 9,  'titulo_id' => 62], // Ciencias de la Tierra
            ['area_id' => 4,  'titulo_id' => 62], // Biología
            ['area_id' => 10, 'titulo_id' => 62], // Física
            ['area_id' => 11, 'titulo_id' => 62], // Química
            ['area_id' => 12, 'titulo_id' => 62], // Formación para la Soberanía Nacional

            // ============================================
            // EDUCACIÓN MENCIÓN SOCIALES (63-65)
            // ============================================

            /* Estudio 63 - Profesor en Educación mención Ciencias Sociales */

            ['area_id' => 8,  'titulo_id' => 64], // Geografía, Historia y Ciudadanía
            ['area_id' => 1,  'titulo_id' => 64], // Castellano
            ['area_id' => 12, 'titulo_id' => 64], // Formación para la Soberanía Nacional

            /* Estudio 65 - Profesor en Educación mención Geografía */
            ['area_id' => 8,  'titulo_id' => 65], // Geografía, Historia y Ciudadanía
            ['area_id' => 9,  'titulo_id' => 65], // Ciencias de la Tierra
            ['area_id' => 12, 'titulo_id' => 65], // Formación para la Soberanía Nacional

            // ============================================
            // EDUCACIÓN MENCIÓN LENGUAS (66-71)
            // ============================================

            /* Estudio 66 - Profesor en Educación mención Castellano y Literatura */
            ['area_id' => 1,  'titulo_id' => 66], // Castellano
            ['area_id' => 2,  'titulo_id' => 66], // Arte y Patrimonio
            ['area_id' => 8,  'titulo_id' => 66], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 66], // Formación para la Soberanía Nacional

            /* Estudio 67 - Profesor en Educación mención Lengua y Literatura */
            ['area_id' => 1,  'titulo_id' => 67], // Castellano
            ['area_id' => 2,  'titulo_id' => 67], // Arte y Patrimonio
            ['area_id' => 8,  'titulo_id' => 67], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 67], // Formación para la Soberanía Nacional

            /* Estudio 68 - Profesor en Educación mención Inglés */
            ['area_id' => 7,  'titulo_id' => 68], // Inglés y otras lenguas extranjeras
            ['area_id' => 1,  'titulo_id' => 68], // Castellano
            ['area_id' => 12, 'titulo_id' => 68], // Formación para la Soberanía Nacional

            /* Estudio 69 - Profesor en Educación mención Francés */
            ['area_id' => 7,  'titulo_id' => 69], // Inglés y otras lenguas extranjeras
            ['area_id' => 1,  'titulo_id' => 69], // Castellano
            ['area_id' => 12, 'titulo_id' => 69], // Formación para la Soberanía Nacional

            /* Estudio 70 - Profesor en Educación mención Italiano */
            ['area_id' => 7,  'titulo_id' => 70], // Inglés y otras lenguas extranjeras
            ['area_id' => 1,  'titulo_id' => 70], // Castellano
            ['area_id' => 12, 'titulo_id' => 70], // Formación para la Soberanía Nacional

            /* Estudio 71 - Profesor en Educación mención Lenguas Extranjeras */
            ['area_id' => 7,  'titulo_id' => 71], // Inglés y otras lenguas extranjeras
            ['area_id' => 1,  'titulo_id' => 71], // Castellano
            ['area_id' => 12, 'titulo_id' => 71], // Formación para la Soberanía Nacional

            // ============================================
            // EDUCACIÓN MENCIÓN COMERCIAL (72-76)
            // ============================================

            /* Estudio 72 - Profesor en Educación mención Educación para el Trabajo */
            ['area_id' => 5,  'titulo_id' => 72], // Matemáticas
            ['area_id' => 1,  'titulo_id' => 72], // Castellano
            ['area_id' => 12, 'titulo_id' => 72], // Formación para la Soberanía Nacional
            ['area_id' => 13, 'titulo_id' => 72], // Orientación y Convivencia

            /* Estudio 73 - Profesor en Educación mención Educación Comercial */
            ['area_id' => 5,  'titulo_id' => 73], // Matemáticas
            ['area_id' => 1,  'titulo_id' => 73], // Castellano
            ['area_id' => 12, 'titulo_id' => 73], // Formación para la Soberanía Nacional

            /* Estudio 74 - Profesor en Educación mención Administración */
            ['area_id' => 5,  'titulo_id' => 74], // Matemáticas
            ['area_id' => 1,  'titulo_id' => 74], // Castellano
            ['area_id' => 12, 'titulo_id' => 74], // Formación para la Soberanía Nacional

            /* Estudio 75 - Profesor en Educación mención Contabilidad */
            ['area_id' => 5,  'titulo_id' => 75], // Matemáticas
            ['area_id' => 1,  'titulo_id' => 75], // Castellano
            ['area_id' => 12, 'titulo_id' => 75], // Formación para la Soberanía Nacional

            /* Estudio 76 - Profesor en Educación mención Informática */
            ['area_id' => 5,  'titulo_id' => 76], // Matemáticas
            ['area_id' => 10, 'titulo_id' => 76], // Física
            ['area_id' => 7,  'titulo_id' => 76], // Inglés
            ['area_id' => 12, 'titulo_id' => 76], // Formación para la Soberanía Nacional

            // ============================================
            // EDUCACIÓN FÍSICA (77-78)
            // ============================================

            /* Estudio 77 - Profesor en Educación Física (duplicado - ya está el 7) */
            ['area_id' => 6,  'titulo_id' => 77], // Educación Física
            ['area_id' => 4,  'titulo_id' => 77], // Biología
            ['area_id' => 12, 'titulo_id' => 77], // Formación para la Soberanía Nacional

            /* Estudio 78 - Licenciado en Educación Física */
            ['area_id' => 6,  'titulo_id' => 78], // Educación Física
            ['area_id' => 4,  'titulo_id' => 78], // Biología
            ['area_id' => 12, 'titulo_id' => 78], // Formación para la Soberanía Nacional

            // ============================================
            // EDUCACIÓN ARTES (79-81)
            // ============================================

            /* Estudio 79 - Profesor en Educación mención Educación Musical */
            ['area_id' => 2,  'titulo_id' => 79], // Arte y Patrimonio
            ['area_id' => 5,  'titulo_id' => 79], // Matemáticas
            ['area_id' => 12, 'titulo_id' => 79], // Formación para la Soberanía Nacional

            /* Estudio 80 - Profesor en Educación mención Artes Plásticas */
            ['area_id' => 2,  'titulo_id' => 80], // Arte y Patrimonio
            ['area_id' => 8,  'titulo_id' => 80], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 80], // Formación para la Soberanía Nacional

            /* Estudio 81 - Profesor en Educación mención Artes Escénicas */
            ['area_id' => 2,  'titulo_id' => 81], // Arte y Patrimonio
            ['area_id' => 1,  'titulo_id' => 81], // Castellano
            ['area_id' => 12, 'titulo_id' => 81], // Formación para la Soberanía Nacional

            // ============================================
            // EDUCACIÓN ORIENTACIÓN Y GERENCIA (82-86)
            // ============================================

            /* Estudio 82 - Licenciado en Educación mención Orientación */
            ['area_id' => 13, 'titulo_id' => 82], // Orientación y Convivencia
            ['area_id' => 1,  'titulo_id' => 82], // Castellano
            ['area_id' => 12, 'titulo_id' => 82], // Formación para la Soberanía Nacional

            /* Estudio 83 - Profesor en Educación mención Orientación */
            ['area_id' => 13, 'titulo_id' => 83], // Orientación y Convivencia
            ['area_id' => 1,  'titulo_id' => 83], // Castellano
            ['area_id' => 12, 'titulo_id' => 83], // Formación para la Soberanía Nacional

            /* Estudio 84 - Licenciado en Educación mención Gerencia Educativa */
            ['area_id' => 5,  'titulo_id' => 84], // Matemáticas
            ['area_id' => 12, 'titulo_id' => 84], // Formación para la Soberanía Nacional
            ['area_id' => 13, 'titulo_id' => 84], // Orientación y Convivencia

            /* Estudio 85 - Licenciado en Educación mención Supervisión Educativa */
            ['area_id' => 12, 'titulo_id' => 85], // Formación para la Soberanía Nacional
            ['area_id' => 13, 'titulo_id' => 85], // Orientación y Convivencia

            /* Estudio 86 - Licenciado en Educación mención Planificación Educativa */
            ['area_id' => 5,  'titulo_id' => 86], // Matemáticas
            ['area_id' => 12, 'titulo_id' => 86], // Formación para la Soberanía Nacional
            ['area_id' => 13, 'titulo_id' => 86], // Orientación y Convivencia

            // ============================================
            // EDUCACIÓN RURAL Y ADULTOS (87-89)
            // ============================================

            /* Estudio 87 - Profesor en Educación Rural */
            ['area_id' => 1,  'titulo_id' => 87], // Castellano
            ['area_id' => 5,  'titulo_id' => 87], // Matemáticas
            ['area_id' => 3,  'titulo_id' => 87], // Ciencias Naturales
            ['area_id' => 8,  'titulo_id' => 87], // Geografía, Historia y Ciudadanía
            ['area_id' => 12, 'titulo_id' => 87], // Formación para la Soberanía Nacional

            /* Estudio 88 - Profesor en Educación de Adultos */
            ['area_id' => 1,  'titulo_id' => 88], // Castellano
            ['area_id' => 5,  'titulo_id' => 88], // Matemáticas
            ['area_id' => 12, 'titulo_id' => 88], // Formación para la Soberanía Nacional
            ['area_id' => 13, 'titulo_id' => 88], // Orientación y Convivencia

            /* Estudio 89 - Licenciado en Educación de Adultos */
            ['area_id' => 1,  'titulo_id' => 89], // Castellano
            ['area_id' => 5,  'titulo_id' => 89], // Matemáticas
            ['area_id' => 12, 'titulo_id' => 89], // Formación para la Soberanía Nacional
            ['area_id' => 13, 'titulo_id' => 89], // Orientación y Convivencia
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
        $this->command->info('Total de asignaciones: ' . count($asignaciones));
    }
}
