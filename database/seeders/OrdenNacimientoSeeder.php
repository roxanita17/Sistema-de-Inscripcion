<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrdenNacimiento;

class OrdenNacimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ordenes = [
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '10',
            '11',
            '12',
        ];

        foreach ($ordenes as $orden) {
            OrdenNacimiento::firstOrCreate(['orden_nacimiento' => $orden,
            'status' => true]);
        }

        $this->command->info(string: 'Seeder de ordenes ejecutado correctamente. Se insertaron ordenes.');
    }
}
