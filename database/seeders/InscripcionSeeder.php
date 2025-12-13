<?php

namespace Database\Seeders;

use App\Models\Inscripcion;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class InscripcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 99; $i++) {
            Inscripcion::create([
                // Relaciones principales
                'alumno_id' => ($i % 10) + 1,
                'grado_id' => 1,

                // Padres y representante (solo del 1 al 3)
                'padre_id' => ($i % 2) + 1,
                'madre_id' => (($i + 1) % 2) + 1,
                'representante_legal_id' => (($i + 2) % 2) + 1,

                // Datos de inscripción
                'fecha_inscripcion' => Carbon::now()->subDays(rand(1, 30)),
                'documentos' => 'Partida de nacimiento, boletín, fotos',
                'estado_documentos' => rand(0, 1) ? 'Completo' : 'Incompleto',
                'observaciones' => $i % 2 === 0
                    ? 'Documentos en revisión'
                    : 'Sin observaciones',

                //INT
                'numero_zonificacion' => $i,

                // Opcionales / catálogos
                'institucion_procedencia_id' => rand(1, 3),
                'expresion_literaria_id' => rand(1, 3),

                //DATE
                'anio_egreso' => Carbon::create(2024, 12, 11),

                // Contrato
                'acepta_normas_contrato' => true,

                // Estado de la inscripción
                'status' => 'Activo' ,
            ]);
        }

        $this->command->info('Seeder de Inscripcion (10 registros) ejecutado correctamente.');
    }
}
