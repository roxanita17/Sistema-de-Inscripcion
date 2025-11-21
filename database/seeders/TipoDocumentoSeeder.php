<?php
// database/seeders/EtniasIndigenasSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoDocumento;

class TipoDocumentoSeeder extends Seeder
{
    public function run()
    {   
        $tiposDocumento = [
            'V',
            'E',
        ];

        foreach ($tiposDocumento as $tipoDocumento) {
            TipoDocumento::firstOrCreate(['tipo_documento' => $tipoDocumento,
        'status' => true]);
        }

        $this->command->info(string: 'Seeder de tipos de documentos ejecutado correctamente. Se insertaron tipos de documentos.');
    }

}


