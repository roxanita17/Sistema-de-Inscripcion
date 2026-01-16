<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MunicipioSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/parroquias.json');
        $data = json_decode(File::get($path), true);

        $municipiosUnicos = collect($data)->unique(function ($item) {
            return $item['estado'] . $item['municipio'];
        });

        foreach ($municipiosUnicos as $item) {
            $nombreEstado = trim($item['estado']);
            $nombreMunicipio = trim($item['municipio']);

            $estado = DB::table('estados')
                ->whereRaw('LOWER(nombre_estado) = ?', [mb_strtolower($nombreEstado)])
                ->first();

            if ($estado) {
                DB::table('municipios')->updateOrInsert(
                    [
                        'nombre_municipio' => $nombreMunicipio,
                        'estado_id'        => $estado->id,
                    ],
                    [
                        'status'           => 1,
                        'created_at'       => now(),
                        'updated_at'       => now(),
                    ]
                );
            } else {
                $this->command->warn("Estado no encontrado: {$nombreEstado} para el municipio {$nombreMunicipio}");
            }
        }

        $this->command->info("Proceso de municipios finalizado.");
    }
}
