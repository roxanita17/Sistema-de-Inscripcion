<?php

namespace Database\Seeders;
use App\Models\Docente;
use App\Models\EstudiosRealizado;
use Illuminate\Database\Seeder;
use App\Models\DetalleDocenteEstudio;

class DetalleDocenteEstudioSeeder extends Seeder
{
    public function run(): void
    {
        $detalles = [

            [
                'docente_id'  => 1,
                'estudios_id' => 1, // Licenciatura en Administración
                'status'      => true,
            ],
            [
                'docente_id'  => 2,
                'estudios_id' => 2, // Licenciatura en Contaduría Pública
                'status'      => true,
            ],
            [
                'docente_id'  => 3,
                'estudios_id' => 6, // Profesor en Educación Integral
                'status'      => true,
            ],
            [
                'docente_id'  => 4,
                'estudios_id' => 12, // Ingeniería Civil
                'status'      => true,
            ],
            [
                'docente_id'  => 5,
                'estudios_id' => 21, // Medicina
                'status'      => true,
            ],
            [
                'docente_id'  => 6,
                'estudios_id' => 31, // Arquitectura
                'status'      => true,
            ],
            [
                'docente_id'  => 7,
                'estudios_id' => 15, // Ingeniería en Sistemas
                'status'      => true,
            ],
            [
                'docente_id'  => 8,
                'estudios_id' => 34, // Música
                'status'      => true,
            ],
            [
                'docente_id'  => 9,
                'estudios_id' => 26, // Derecho
                'status'      => true,
            ],
            [
                'docente_id'  => 10,
                'estudios_id' => 18, // Ingeniería Química
                'status'      => true,
            ],

        ];

        foreach ($detalles as $detalle) {
            DetalleDocenteEstudio::create($detalle);
            
        }

        $this->command->info('Seeder de 10 Detalles de Docente y Estudios ejecutado correctamente.');
    }
}
