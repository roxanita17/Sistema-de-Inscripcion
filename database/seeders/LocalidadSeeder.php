<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Laravel\Pail\Files;

class LocalidadSeeder extends Seeder
{
    public function run(): void
 {
        $path = database_path('data/parroquias.json');
        if(!File::exists($path)) {
            return;
        }
        $json = File::get($path);
        $data = json_decode($json, true);

        foreach ($data as $item) {
            $municipio = DB::table('municipios')
                ->join('estados', 'municipios.estado_id', '=', 'estados.id')
                ->where('municipios.nombre_municipio', $item['municipio'])
                ->where('estados.nombre_estado', $item['estado'])
                ->select('municipios.id')
                ->first();

            if ($municipio) {
                DB::table('localidads')->updateOrInsert(
                    [
                        'nombre_localidad' => $item['parroquia'],
                        'municipio_id'     => $municipio->id,
                    ],
                    [
                        'status'           => 1,
                        'created_at'       => now(),
                        'updated_at'       => now(),
                    ]
                );
            }
        }
    }
}
