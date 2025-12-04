<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RepresentanteLegal;

class RepresentanteLegalSeeder extends Seeder
{
    public function run(): void
    {
        $representantes = [
            [
                'representante_id' => 1,
                'banco_id' => 18,
                'tipo_cuenta' => 'Corriente',
                'parentesco' => 'Padre',
                'correo_representante' => 'Ivan@gmail.com',
                'pertenece_a_organizacion_representante' => 0,
                'carnet_patria_afiliado' => 0,
                'cual_organizacion_representante' => 'Organizacion...',
                'serial_carnet_patria_representante' => '1111',
                'codigo_carnet_patria_representante' => '7771',
                'direccion_representante' => 'Urb. Prados del Sol',
                'estados_representante' => 'Activo'
            ],
            [
                'representante_id' => 4,
                'banco_id' => 18,
                'tipo_cuenta' => 'Corriente',
                'parentesco' => 'Madre',
                'correo_representante' => 'Rebeca@gmail.com',
                'pertenece_a_organizacion_representante' => 0,
                'carnet_patria_afiliado' => 0,
                'cual_organizacion_representante' => 'Organizacion...',
                'serial_carnet_patria_representante' => '1111',
                'codigo_carnet_patria_representante' => '7771',
                'direccion_representante' => 'Urb. Prados del Sol',
                'estados_representante' => 'Activo'
            ],
            
        ];

        foreach ($representantes as $representante) {
            RepresentanteLegal::create($representante);
        }

        $this->command->info('Seeder de 10 representantes ejecutado correctamente.');
    }
}
