<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscapacidadSeeder extends Seeder
{
    public function run()
    {
        $discapacidades = [
            // Discapacidad física o motora
            "Discapacidad física o motora",
            "Parálisis cerebral",
            "Lesión de la médula espinal",
            "Esclerosis múltiple",
            "Distonía muscular",
            "Espina bífida",
            "Osteogénesis imperfecta",
            "Poliomielitis",
            "Enfermedad de Parkinson",
            "Ataxia de Friedreich",
            "Cardiopatía congénita",
            "Extrofia vesical",

            // Discapacidad sensorial
            "Discapacidad sensorial",
            "Discapacidad auditiva (sordera/hipoacusia)",
            "Discapacidad visual (ceguera/baja visión)",

            // Discapacidad intelectual y del desarrollo
            "Discapacidad intelectual",
            "Síndrome de Down",
            "Trastorno del Espectro Autista (TEA)",
            "Trastorno por Déficit de Atención e Hiperactividad (TDAH)",
            "Dislexia",

            // Discapacidad psicosocial
            "Discapacidad psicosocial",
            "Depresión",
            "Esquizofrenia",
            "Trastorno bipolar",

            // Afecciones neurológicas/metabólicas asociadas a discapacidad
            "Epilepsia",
            "Diabetes mellitus",
            "Hemofilia",

            // Otras
            "Pluridiscapacidad (varias discapacidades concomitantes)",
        ];

        foreach ($discapacidades as $nombre) {
            DB::table('discapacidads')->insert([
                'nombre_discapacidad' => $nombre,
                'status' => true,
            ]);
        }
        $this->command->info(string: 'Seeder de discapacidades ejecutado correctamente. Se insertaron discapacidades.');
    }
}
