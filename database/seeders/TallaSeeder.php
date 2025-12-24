<?php

namespace Database\Seeders;

use App\Models\Talla;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TallaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tallas = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

        foreach ($tallas as $talla) {
            Talla::create([
                'nombre' => $talla,
            ]);
        }

        $this->command->info(string: 'Seeder de tallas ejecutado correctamente.');
    }
}
