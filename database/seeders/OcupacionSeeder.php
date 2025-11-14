<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OcupacionSeeder extends Seeder
{
    public function run()
    {
        $ocupaciones = [

            // Comercio y ventas
            "Comerciante",
            "Vendedor / Vendedora",
            "Cajero / Cajera",
            "Atención al cliente",
            "Mercaderista",
            "Bodeguero",

            // Servicios generales
            "Conserje",
            "Personal de limpieza",
            "Cocinero / Cocinera",
            "Ayudante de cocina",
            "Mesonero",
            "Panadero / Pastelero",
            "Chofer",
            "Repartidor",

            // Oficios y trabajos manuales
            "Carpintero",
            "Electricista",
            "Plomero",
            "Albañil",
            "Herrero",
            "Mecánico automotriz",
            "Técnico en refrigeración",
            "Técnico en mantenimiento",
            "Soldador",
            "Peluquero / Barbero",
            "Manicurista",

            // Sector educativo
            "Docente de primaria",
            "Docente de secundaria",
            "Profesor universitario",
            "Asistente educativo",

            // Salud
            "Médico general",
            "Enfermera / Enfermero",
            "Bioanalista",
            "Farmacéutico",
            "Paramédico",

            // Oficina y administración
            "Secretaria / Secretario",
            "Asistente administrativo",
            "Analista contable",
            "Contador",
            "Recepcionista",

            // Tecnología
            "Técnico en computación",
            "Soporte técnico",
            "Programador",
            "Analista de sistemas",

            // Seguridad
            "Vigilante / Seguridad",
            "Escolta",
            "Supervisor de seguridad",

            // Transporte
            "Taxista",
            "Transportista",
            "Mototaxista",

            // Industria y producción
            "Operador de máquina",
            "Obrero de planta",
            "Empaquetador / Empacador",

            // Sector agrícola
            "Agricultor",
            "Ganadero",
            "Trabajador rural",

            // Comercio informal
            "Buhonero",
            "Vendedor ambulante",
            "Emprendedor independiente",

            // Servicios profesionales
            "Abogado",
            "Ingeniero",
            "Arquitecto",
            "Diseñador gráfico",
        ];

        foreach ($ocupaciones as $nombre) {
            DB::table('ocupacions')->insert([
                'nombre_ocupacion' => $nombre,
                'status' => true,
            ]);
        }
        $this->command->info(string: 'Seeder de ocupaciones ejecutado correctamente. Se insertaron ocupaciones.');
    }
}
