<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BancoSeeder extends Seeder
{
    public function run()
    {
        $bancos = [
            // Públicos
            ["codigo" => "0102", "nombre" => "Banco de Venezuela"],
            ["codigo" => "0104", "nombre" => "Venezolano de Crédito"],
            ["codigo" => "0105", "nombre" => "Mercantil Banco Universal"],
            ["codigo" => "0108", "nombre" => "Banco Provincial"],
            ["codigo" => "0114", "nombre" => "Bancaribe"],
            ["codigo" => "0115", "nombre" => "Banco Exterior"],
            ["codigo" => "0116", "nombre" => "Banco Occidental de Descuento (BOD/BOI)"],
            ["codigo" => "0128", "nombre" => "Banco Caroní"],
            ["codigo" => "0134", "nombre" => "Banesco Banco Universal"],
            ["codigo" => "0137", "nombre" => "Banco Sofitasa"],
            ["codigo" => "0138", "nombre" => "Banco Plaza"],
            ["codigo" => "0146", "nombre" => "Banco de la Gente Emprendedora (Bangente)"],
            ["codigo" => "0151", "nombre" => "Banco Fondo Común (BFC)"],
            ["codigo" => "0156", "nombre" => "100% Banco"],
            ["codigo" => "0157", "nombre" => "Banco del Tesoro"],
            ["codigo" => "0163", "nombre" => "Banco del Pueblo Soberano"],
            ["codigo" => "0166", "nombre" => "Banco Agrícola de Venezuela"],
            ["codigo" => "0168", "nombre" => "Bancrecer"],
            ["codigo" => "0169", "nombre" => "Mi Banco"],
            ["codigo" => "0171", "nombre" => "Banco Activo"],
            ["codigo" => "0172", "nombre" => "Bancamiga Banco Universal"],
            ["codigo" => "0173", "nombre" => "Banco Internacional de Desarrollo (BID)"],
            ["codigo" => "0174", "nombre" => "Banplus Banco Universal"],
            ["codigo" => "0175", "nombre" => "Banco Bicentenario del Pueblo"],
            ["codigo" => "0176", "nombre" => "Banco Espirito Santo"],
            ["codigo" => "0177", "nombre" => "Banco de la Fuerza Armada Nacional Bolivariana (Banfanb)"],
            ["codigo" => "0190", "nombre" => "Citibank"],
            ["codigo" => "0191", "nombre" => "Banco Nacional de Crédito (BNC)"],

            // Bancos digitales / nuevos
            ["codigo" => "0178", "nombre" => "N56 Banco Digital"],
        ];

        foreach ($bancos as $banco) {
            DB::table('bancos')->insert([
                'codigo_banco' => $banco["codigo"],
                'nombre_banco' => $banco["nombre"],
                'status' => true,
            ]);
        }
        $this->command->info('¡Bancos poblados con éxito!');
    }
}
