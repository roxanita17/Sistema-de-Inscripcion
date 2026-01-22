<?php

namespace App\Services;

use App\Models\AnioEscolar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnioEscolarService
{
    /**
     * Crear un nuevo Calendario Escolar
     * 
     * @param array $datos
     * @return array ['success' => bool, 'anio' => AnioEscolar|null, 'error' => string|null]
     */
    public function crear(array $datos): array
    {
        // Validar con el modelo
        $validacion = AnioEscolar::puedeCrearConFechas(
            $datos['inicio_anio_escolar'],
            $datos['cierre_anio_escolar']
        );

        if (!$validacion['valido']) {
            return [
                'success' => false,
                'anio' => null,
                'error' => $validacion['error']
            ];
        }

        // Crear el Calendario Escolar en una transacción
        try {
            $anioEscolar = DB::transaction(function () use ($datos) {
                return AnioEscolar::create([
                    'inicio_anio_escolar' => $datos['inicio_anio_escolar'],
                    'cierre_anio_escolar' => $datos['cierre_anio_escolar'],
                    'status' => 'Activo',
                ]);
            });

            Log::info('Calendario Escolar creado', ['id' => $anioEscolar->id]);

            return [
                'success' => true,
                'anio' => $anioEscolar,
                'error' => null
            ];
        } catch (\Exception $e) {
            Log::error('Error al crear Calendario Escolar', [
                'error' => $e->getMessage(),
                'datos' => $datos
            ]);

            return [
                'success' => false,
                'anio' => null,
                'error' => 'Error al crear el Calendario Escolar. Por favor, intente nuevamente.'
            ];
        }
    }

    /**
     * Extender un Calendario Escolar existente
     * 
     * @param int $id
     * @param string $nuevoCierre
     * @return array
     */
    public function extender(int $id, string $nuevoCierre): array
    {
        $anioEscolar = AnioEscolar::find($id);

        if (!$anioEscolar) {
            return [
                'success' => false,
                'anio' => null,
                'error' => 'Calendario Escolar no encontrado.'
            ];
        }

        // Validar la extensión usando el modelo
        $validacion = $anioEscolar->puedeExtenderA($nuevoCierre);

        if (!$validacion['valido']) {
            return [
                'success' => false,
                'anio' => null,
                'error' => $validacion['error']
            ];
        }

        // Aplicar la extensión
        try {
            DB::transaction(function () use ($anioEscolar, $nuevoCierre) {
                $anioEscolar->extencion_anio_escolar = $nuevoCierre;
                $anioEscolar->cierre_anio_escolar = $nuevoCierre;
                $anioEscolar->save();
                $anioEscolar->marcarComoExtendido();
            });

            Log::info('Calendario Escolar extendido', [
                'id' => $anioEscolar->id,
                'nueva_fecha' => $nuevoCierre
            ]);

            return [
                'success' => true,
                'anio' => $anioEscolar->fresh(),
                'error' => null
            ];
        } catch (\Exception $e) {
            Log::error('Error al extender Calendario Escolar', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'anio' => null,
                'error' => 'Error al extender el Calendario Escolar. Por favor, intente nuevamente.'
            ];
        }
    }

    /**
     * Inactivar un Calendario Escolar
     */
    public function inactivar(int $id): array
    {
        $anioEscolar = AnioEscolar::find($id);

        if (!$anioEscolar) {
            return [
                'success' => false,
                'error' => 'Calendario Escolar no encontrado.'
            ];
        }

        try {
            $anioEscolar->marcarComoInactivo();

            Log::info('Calendario Escolar inactivado', ['id' => $id]);

            return [
                'success' => true,
                'error' => null
            ];
        } catch (\Exception $e) {
            Log::error('Error al inactivar Calendario Escolar', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => 'Error al inactivar el Calendario Escolar.'
            ];
        }
    }
}