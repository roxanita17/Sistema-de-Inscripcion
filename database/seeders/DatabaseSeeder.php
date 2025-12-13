<?php

namespace Database\Seeders;

use App\Models\AnioEscolar;
use App\Models\Docente;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Persona;
use App\Models\DetalleDocenteEstudio;
use App\Models\Alumno;
use App\Models\Representante;
use App\Models\RepresentanteLegal;
use App\Models\Inscripcion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // User::factory(10)->create();
        /* AnioEscolar:: create([
            'anio_escolar' => [
                'inicio_anio_escolar' => '2025-01-01',
                'cierre_anio_escolar' => '2025-12-31',
                'status' => 'Activo',
            ],
        ]);
 */

        $this->command->info('Iniciando seeders...');

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('12345678'),
        ]);

        $this->call([
            GradoSeeder::class,
            AreaFormacionSeeder::class,
            EstadoSeeder::class,
            MunicipioSeeder::class,
            LocalidadSeeder::class,
            EstudiosRealizadoSeeder::class,
            AreaEstudioRealizadoSeeder::class,
            GradoAreaFormacionSeeder::class,
            EtniaIndigenaSeeder::class,
            DiscapacidadSeeder::class,
            OcupacionSeeder::class,
            ExpresionLiterariaSeeder::class,
            BancoSeeder::class,
            PrefijoTelefonoSeeder::class,
            RoleSeeder::class,
            InstitucionProcedenciaSeeder::class,
            GeneroSeeder::class,
            LateralidadSeeder::class,
            OrdenNacimientoSeeder::class,
            TipoDocumentoSeeder::class,
            IndiceEdadSeeder::class,
            IndicePesoSeeder::class,
            IndiceEstaturaSeeder::class,
            PersonaSeeder::class,
/*             AlumnoSeeder::class,
 */            DocenteSeeder::class,
            DetalleDocenteEstudioSeeder::class,
            RepresentanteSeeder::class,
            RepresentanteLegalSeeder::class
        ]);

        
        
        
        


        $this->command->info('¡Base de datos poblada con éxito!');

    }
}
