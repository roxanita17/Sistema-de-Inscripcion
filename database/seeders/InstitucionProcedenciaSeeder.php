<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InstitucionProcedenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $instituciones = [
            // AMAZONAS - Alto Orinoco (localidad_id: 1)
            ['localidad_id' => 1, 'nombre_institucion' => 'Unidad Educativa Alto Orinoco'],
            ['localidad_id' => 1, 'nombre_institucion' => 'Escuela Básica Indígena Yanomami'],
            
            // Huachamacare Acanaña (localidad_id: 2)
            ['localidad_id' => 2, 'nombre_institucion' => 'Escuela Básica Huachamacare'],
            
            // Marawaka Toky Shamanaña (localidad_id: 3)
            ['localidad_id' => 3, 'nombre_institucion' => 'Unidad Educativa Marawaka'],
            
            // Mavaka Mavaka (localidad_id: 4)
            ['localidad_id' => 4, 'nombre_institucion' => 'Escuela Básica Mavaka'],
            
            // Sierra Parima Parimabé (localidad_id: 5)
            ['localidad_id' => 5, 'nombre_institucion' => 'Unidad Educativa Sierra Parima'],
            
            // ANZOÁTEGUI - Anaco (localidad_id: 26)
            ['localidad_id' => 26, 'nombre_institucion' => 'Unidad Educativa Nacional Anaco'],
            ['localidad_id' => 26, 'nombre_institucion' => 'Colegio San José de Anaco'],
            ['localidad_id' => 26, 'nombre_institucion' => 'Liceo Bolivariano Anaco'],
            
            // Barcelona (Clarines - localidad_id: 104)
            ['localidad_id' => 104, 'nombre_institucion' => 'Unidad Educativa Clarines'],
            ['localidad_id' => 104, 'nombre_institucion' => 'Escuela Básica Simón Bolívar'],
            
            // Lechería (localidad_id: 30)
            ['localidad_id' => 30, 'nombre_institucion' => 'Unidad Educativa Lechería'],
            ['localidad_id' => 30, 'nombre_institucion' => 'Colegio Cristo Rey'],
            
            // Puerto La Cruz (localidad_id: 47)
            ['localidad_id' => 47, 'nombre_institucion' => 'Unidad Educativa Puerto La Cruz'],
            ['localidad_id' => 47, 'nombre_institucion' => 'Liceo Luis Beltrán Prieto Figueroa'],
            ['localidad_id' => 47, 'nombre_institucion' => 'Colegio San Luis Rey'],
            
            // APURE - Achaguas (localidad_id: 29)
            ['localidad_id' => 29, 'nombre_institucion' => 'Unidad Educativa Achaguas'],
            ['localidad_id' => 29, 'nombre_institucion' => 'Escuela Básica República de Venezuela'],
            
            // Biruaca (localidad_id: 30)
            ['localidad_id' => 30, 'nombre_institucion' => 'Liceo Bolivariano Biruaca'],
            
            // San Fernando de Apure (localidad_id: 35)
            ['localidad_id' => 35, 'nombre_institucion' => 'Unidad Educativa Nacional San Fernando'],
            ['localidad_id' => 35, 'nombre_institucion' => 'Liceo Rómulo Gallegos'],
            ['localidad_id' => 35, 'nombre_institucion' => 'Colegio San Agustín'],
            
            // ARAGUA - Maracay (localidad_id: 36)
            ['localidad_id' => 36, 'nombre_institucion' => 'Unidad Educativa Luis Beltrán Prieto Figueroa'],
            ['localidad_id' => 36, 'nombre_institucion' => 'Colegio Salesiano San Juan Bosco'],
            ['localidad_id' => 36, 'nombre_institucion' => 'Liceo Santiago Mariño'],
            ['localidad_id' => 36, 'nombre_institucion' => 'Unidad Educativa Francisco Lazo Martí'],
            
            // Turmero (localidad_id: 48)
            ['localidad_id' => 48, 'nombre_institucion' => 'Unidad Educativa Turmero'],
            ['localidad_id' => 48, 'nombre_institucion' => 'Liceo Simón Rodríguez'],
            
            // Cagua (localidad_id: 50)
            ['localidad_id' => 50, 'nombre_institucion' => 'Unidad Educativa Cagua'],
            ['localidad_id' => 50, 'nombre_institucion' => 'Colegio San Vicente de Paúl'],
            
            // La Victoria (localidad_id: 41)
            ['localidad_id' => 41, 'nombre_institucion' => 'Unidad Educativa La Victoria'],
            ['localidad_id' => 41, 'nombre_institucion' => 'Liceo José Félix Ribas'],
            
            // BARINAS - Barinas (localidad_id: 58)
            ['localidad_id' => 58, 'nombre_institucion' => 'Unidad Educativa Libertador'],
            ['localidad_id' => 58, 'nombre_institucion' => 'Liceo Domingo Alberto Rangel'],
            ['localidad_id' => 58, 'nombre_institucion' => 'Colegio La Salle'],
            
            // Sabaneta (localidad_id: 54)
            ['localidad_id' => 54, 'nombre_institucion' => 'Unidad Educativa Sabaneta'],
            ['localidad_id' => 54, 'nombre_institucion' => 'Liceo Bolivariano Sabaneta'],
            
            // BOLÍVAR - Ciudad Bolívar (localidad_id: 70)
            ['localidad_id' => 70, 'nombre_institucion' => 'Unidad Educativa Ciudad Bolívar'],
            ['localidad_id' => 70, 'nombre_institucion' => 'Liceo Simón Bolívar'],
            ['localidad_id' => 70, 'nombre_institucion' => 'Colegio San Rafael'],
            
            // Ciudad Guayana (localidad_id: 66)
            ['localidad_id' => 66, 'nombre_institucion' => 'Unidad Educativa Puerto Ordaz'],
            ['localidad_id' => 66, 'nombre_institucion' => 'Liceo Raúl Leoni'],
            ['localidad_id' => 66, 'nombre_institucion' => 'Colegio Don Bosco'],
            
            // El Callao (localidad_id: 68)
            ['localidad_id' => 68, 'nombre_institucion' => 'Unidad Educativa El Callao'],
            ['localidad_id' => 68, 'nombre_institucion' => 'Liceo Bolivariano El Callao'],
            
            // CARABOBO - Valencia (localidad_id: 90)
            ['localidad_id' => 90, 'nombre_institucion' => 'Unidad Educativa Miguel José Sanz'],
            ['localidad_id' => 90, 'nombre_institucion' => 'Liceo Aplicación'],
            ['localidad_id' => 90, 'nombre_institucion' => 'Colegio La Presentación'],
            ['localidad_id' => 90, 'nombre_institucion' => 'Unidad Educativa Rafael Urdaneta'],
            
            // Puerto Cabello (localidad_id: 87)
            ['localidad_id' => 87, 'nombre_institucion' => 'Unidad Educativa Puerto Cabello'],
            ['localidad_id' => 87, 'nombre_institucion' => 'Liceo Bartolomé Salóm'],
            
            // Guacara (localidad_id: 80)
            ['localidad_id' => 80, 'nombre_institucion' => 'Unidad Educativa Guacara'],
            ['localidad_id' => 80, 'nombre_institucion' => 'Liceo Manuel Feo La Cruz'],
            
            // Naguanagua (localidad_id: 86)
            ['localidad_id' => 86, 'nombre_institucion' => 'Unidad Educativa Naguanagua'],
            ['localidad_id' => 86, 'nombre_institucion' => 'Colegio Nuestra Señora del Carmen'],
            
            // San Diego (localidad_id: 88)
            ['localidad_id' => 88, 'nombre_institucion' => 'Unidad Educativa San Diego'],
            ['localidad_id' => 88, 'nombre_institucion' => 'Colegio San Ignacio de Loyola'],
            
            // COJEDES - San Carlos (localidad_id: 98)
            ['localidad_id' => 98, 'nombre_institucion' => 'Unidad Educativa San Carlos'],
            ['localidad_id' => 98, 'nombre_institucion' => 'Liceo Carlos Soublette'],
            
            // DELTA AMACURO - Tucupita (localidad_id: 103)
            ['localidad_id' => 103, 'nombre_institucion' => 'Unidad Educativa Tucupita'],
            ['localidad_id' => 103, 'nombre_institucion' => 'Liceo Luis Mariano Rivera'],
            
            // FALCÓN - Coro (localidad_id: 109)
            ['localidad_id' => 109, 'nombre_institucion' => 'Unidad Educativa Nacional Coro'],
            ['localidad_id' => 109, 'nombre_institucion' => 'Liceo Cristóbal Rojas'],
            ['localidad_id' => 109, 'nombre_institucion' => 'Colegio La Salle'],
            
            // Punto Fijo (localidad_id: 108)
            ['localidad_id' => 108, 'nombre_institucion' => 'Unidad Educativa Punto Fijo'],
            ['localidad_id' => 108, 'nombre_institucion' => 'Liceo José Laurencio Silva'],
            
            // GUÁRICO - Calabozo (localidad_id: 143)
            ['localidad_id' => 143, 'nombre_institucion' => 'Unidad Educativa Calabozo'],
            ['localidad_id' => 143, 'nombre_institucion' => 'Liceo Simón Bolívar'],
            
            // San Juan de los Morros (localidad_id: 134)
            ['localidad_id' => 134, 'nombre_institucion' => 'Unidad Educativa San Juan'],
            ['localidad_id' => 134, 'nombre_institucion' => 'Liceo Padre Anchieta'],
            ['localidad_id' => 134, 'nombre_institucion' => 'Colegio San José'],
            
            // Valle de la Pascua (localidad_id: 137)
            ['localidad_id' => 137, 'nombre_institucion' => 'Unidad Educativa Valle de la Pascua'],
            ['localidad_id' => 137, 'nombre_institucion' => 'Liceo Francisco de Miranda'],
            
            // Zaraza (localidad_id: 138)
            ['localidad_id' => 138, 'nombre_institucion' => 'Unidad Educativa Zaraza'],
            ['localidad_id' => 138, 'nombre_institucion' => 'Liceo Bolivariano Zaraza'],
            
            // LARA - Barquisimeto (localidad_id: 146)
            ['localidad_id' => 146, 'nombre_institucion' => 'Unidad Educativa Lisandro Alvarado'],
            ['localidad_id' => 146, 'nombre_institucion' => 'Liceo Egidio Montesinos'],
            ['localidad_id' => 146, 'nombre_institucion' => 'Colegio La Salle'],
            ['localidad_id' => 146, 'nombre_institucion' => 'Unidad Educativa Juan XXIII'],
            
            // Cabudare (localidad_id: 149)
            ['localidad_id' => 149, 'nombre_institucion' => 'Unidad Educativa Cabudare'],
            ['localidad_id' => 149, 'nombre_institucion' => 'Liceo José María Vargas'],
            
            // El Tocuyo (localidad_id: 151)
            ['localidad_id' => 151, 'nombre_institucion' => 'Unidad Educativa El Tocuyo'],
            ['localidad_id' => 151, 'nombre_institucion' => 'Liceo Antonio María Piñate'],
            
            // MÉRIDA - Mérida (localidad_id: 190)
            ['localidad_id' => 190, 'nombre_institucion' => 'Unidad Educativa Glorias Patrias'],
            ['localidad_id' => 190, 'nombre_institucion' => 'Liceo Caracciolo Parra León'],
            ['localidad_id' => 190, 'nombre_institucion' => 'Colegio San Luis'],
            ['localidad_id' => 190, 'nombre_institucion' => 'Unidad Educativa Mariano Picón Salas'],
            
            // El Vigía (localidad_id: 196)
            ['localidad_id' => 196, 'nombre_institucion' => 'Unidad Educativa El Vigía'],
            ['localidad_id' => 196, 'nombre_institucion' => 'Liceo Gerónimo Maldonado'],
            
            // Tovar (localidad_id: 199)
            ['localidad_id' => 199, 'nombre_institucion' => 'Unidad Educativa Tovar'],
            ['localidad_id' => 199, 'nombre_institucion' => 'Liceo Tovar'],
            
            // MIRANDA - Los Teques (localidad_id: 232)
            ['localidad_id' => 232, 'nombre_institucion' => 'Unidad Educativa Los Teques'],
            ['localidad_id' => 232, 'nombre_institucion' => 'Liceo Cecilio Acosta'],
            ['localidad_id' => 232, 'nombre_institucion' => 'Colegio San Ignacio'],
            
            // Guarenas (localidad_id: 239)
            ['localidad_id' => 239, 'nombre_institucion' => 'Unidad Educativa Guarenas'],
            ['localidad_id' => 239, 'nombre_institucion' => 'Liceo José María Vargas'],
            
            // Guatire (localidad_id: 243)
            ['localidad_id' => 243, 'nombre_institucion' => 'Unidad Educativa Guatire'],
            ['localidad_id' => 243, 'nombre_institucion' => 'Liceo Andrés Bello'],
            
            // Petare (localidad_id: 241)
            ['localidad_id' => 241, 'nombre_institucion' => 'Unidad Educativa Petare'],
            ['localidad_id' => 241, 'nombre_institucion' => 'Liceo Leoncio Martínez'],
            ['localidad_id' => 241, 'nombre_institucion' => 'Escuela Básica José Félix Ribas'],
            
            // MONAGAS - Maturín (localidad_id: 258)
            ['localidad_id' => 258, 'nombre_institucion' => 'Unidad Educativa Maturín'],
            ['localidad_id' => 258, 'nombre_institucion' => 'Liceo Luis Beltrán Prieto Figueroa'],
            ['localidad_id' => 258, 'nombre_institucion' => 'Colegio Sagrado Corazón'],
            
            // Caripe (localidad_id: 261)
            ['localidad_id' => 261, 'nombre_institucion' => 'Unidad Educativa Caripe'],
            ['localidad_id' => 261, 'nombre_institucion' => 'Liceo Francisco Aniceto Lugo'],
            
            // NUEVA ESPARTA - Porlamar (localidad_id: 277)
            ['localidad_id' => 277, 'nombre_institucion' => 'Unidad Educativa Porlamar'],
            ['localidad_id' => 277, 'nombre_institucion' => 'Liceo Francisco Fajardo'],
            ['localidad_id' => 277, 'nombre_institucion' => 'Colegio Nuestra Señora del Valle'],
            
            // Juan Griego (localidad_id: 276)
            ['localidad_id' => 276, 'nombre_institucion' => 'Unidad Educativa Juan Griego'],
            ['localidad_id' => 276, 'nombre_institucion' => 'Liceo Juan Griego'],
            
            // PORTUGUESA - Guanare (localidad_id: 285)
            ['localidad_id' => 285, 'nombre_institucion' => 'Unidad Educativa Guanare'],
            ['localidad_id' => 285, 'nombre_institucion' => 'Liceo José Vicente de Unda'],
            ['localidad_id' => 285, 'nombre_institucion' => 'Colegio Nuestra Señora de Coromoto'],
            
            // Acarigua (localidad_id: 283)
            ['localidad_id' => 283, 'nombre_institucion' => 'Unidad Educativa Acarigua'],
            ['localidad_id' => 283, 'nombre_institucion' => 'Liceo Egidio Montesinos'],
            
            // SUCRE - Cumaná (localidad_id: 309)
            ['localidad_id' => 309, 'nombre_institucion' => 'Unidad Educativa Nacional Cumaná'],
            ['localidad_id' => 309, 'nombre_institucion' => 'Liceo Raimundo Martínez Centeno'],
            ['localidad_id' => 309, 'nombre_institucion' => 'Colegio San Pío X'],
            
            // Carúpano (localidad_id: 298)
            ['localidad_id' => 298, 'nombre_institucion' => 'Unidad Educativa Carúpano'],
            ['localidad_id' => 298, 'nombre_institucion' => 'Liceo Cruz Salmerón Acosta'],
            
            // TÁCHIRA - San Cristóbal (localidad_id: 356)
            ['localidad_id' => 356, 'nombre_institucion' => 'Unidad Educativa Libertador'],
            ['localidad_id' => 356, 'nombre_institucion' => 'Liceo Simón Bolívar'],
            ['localidad_id' => 356, 'nombre_institucion' => 'Colegio La Salle'],
            ['localidad_id' => 356, 'nombre_institucion' => 'Unidad Educativa San José'],
            
            // Táriba (localidad_id: 363)
            ['localidad_id' => 363, 'nombre_institucion' => 'Unidad Educativa Táriba'],
            ['localidad_id' => 363, 'nombre_institucion' => 'Liceo La Concordia'],
            
            // San Antonio del Táchira (localidad_id: 360)
            ['localidad_id' => 360, 'nombre_institucion' => 'Unidad Educativa San Antonio'],
            ['localidad_id' => 360, 'nombre_institucion' => 'Liceo Pedro María Ureña'],
            
            // TRUJILLO - Valera (localidad_id: 389)
            ['localidad_id' => 389, 'nombre_institucion' => 'Unidad Educativa Valera'],
            ['localidad_id' => 389, 'nombre_institucion' => 'Liceo Cristóbal Mendoza'],
            ['localidad_id' => 389, 'nombre_institucion' => 'Colegio San José'],
            
            // Trujillo (localidad_id: 387)
            ['localidad_id' => 387, 'nombre_institucion' => 'Unidad Educativa Trujillo'],
            ['localidad_id' => 387, 'nombre_institucion' => 'Liceo Andrés Bello'],
            
            // VARGAS - La Guaira (localidad_id: 390)
            ['localidad_id' => 390, 'nombre_institucion' => 'Unidad Educativa La Guaira'],
            ['localidad_id' => 390, 'nombre_institucion' => 'Liceo Raúl Leoni'],
            ['localidad_id' => 390, 'nombre_institucion' => 'Colegio Simón Bolívar'],
            
            // YARACUY - San Felipe (localidad_id: 415)
            ['localidad_id' => 415, 'nombre_institucion' => 'Unidad Educativa San Felipe'],
            ['localidad_id' => 415, 'nombre_institucion' => 'Liceo Bolivariano San Felipe'],
            
            // ZULIA - Maracaibo (localidad_id: 454)
            ['localidad_id' => 454, 'nombre_institucion' => 'Unidad Educativa Rafael María Baralt'],
            ['localidad_id' => 454, 'nombre_institucion' => 'Liceo Rafael Urdaneta'],
            ['localidad_id' => 454, 'nombre_institucion' => 'Colegio San Vicente de Paúl'],
            ['localidad_id' => 454, 'nombre_institucion' => 'Unidad Educativa Bella Vista'],
            
            // Cabimas (localidad_id: 443)
            ['localidad_id' => 443, 'nombre_institucion' => 'Unidad Educativa Cabimas'],
            ['localidad_id' => 443, 'nombre_institucion' => 'Liceo Alonso de Ojeda'],
            
            // Ciudad Ojeda (localidad_id: 445)
            ['localidad_id' => 445, 'nombre_institucion' => 'Unidad Educativa Ciudad Ojeda'],
            ['localidad_id' => 445, 'nombre_institucion' => 'Liceo Creación Ciudad Ojeda'],
            
            // DISTRITO CAPITAL - Caracas (localidad_id: 462)
            ['localidad_id' => 462, 'nombre_institucion' => 'Unidad Educativa Gran Colombia'],
            ['localidad_id' => 462, 'nombre_institucion' => 'Liceo Andrés Bello'],
            ['localidad_id' => 462, 'nombre_institucion' => 'Colegio Emil Friedman'],
            ['localidad_id' => 462, 'nombre_institucion' => 'Unidad Educativa Juan Manuel Cajigal'],
            ['localidad_id' => 462, 'nombre_institucion' => 'Liceo Fermín Toro'],
        ];


        foreach ($instituciones as $institucion) {
            DB::table('institucion_procedencias')->insert([
                'nombre_institucion' => $institucion['nombre_institucion'],
                'localidad_id' => $institucion['localidad_id'],
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        $this->command->info('Instituciones de procedencia insertadas correctamente.');
    }
}