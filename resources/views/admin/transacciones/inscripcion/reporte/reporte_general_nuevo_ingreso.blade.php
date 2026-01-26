<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reporte General Nuevo Ingreso</title>
    <style>
        @page {
            margin: 0.8cm 1cm 2cm 1cm;
            size: landscape;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 8pt;
            line-height: 1.2;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
        }

        /* CINTILLO SUPERIOR */
        .cintillo {
            background-color: #1589e1;
            padding: 3px 10px;
            margin-bottom: 5px;
        }

        .cintillo table {
            border: none;
        }

        .cintillo td {
            border: none;
            padding: 2px;
            color: #fff;
            vertical-align: middle;
        }

        .cintillo img {
            max-height: 35px;
            max-width: 80px;
            object-fit: contain;
        }

        .cintillo-text {
            font-size: 7pt;
            text-align: right;
        }

        /* ENCABEZADO INSTITUCIÓN */
        .institution-header {
            border: 2px solid #1589e1;
            padding: 8px;
            text-align: center;
            margin-bottom: 8px;
            background-color: #f8f9fa;
        }

        .institution-header h1 {
            color: #1589e1;
            margin: 0 0 3px 0;
            font-size: 14pt;
            font-weight: bold;
        }

        .institution-subtitle {
            font-size: 9pt;
            color: #666;
            margin: 0;
            font-style: italic;
        }

        /* ENCABEZADO REPORTE */
        .header {
            text-align: center;
            margin: 0 0 8px 0;
            padding: 6px 10px;
            background: #1589e1;
            color: white;
            border-radius: 3px;
        }

        .header h2 {
            margin: 0 0 3px 0;
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .header p {
            margin: 0;
            font-size: 7.5pt;
            font-style: italic;
            opacity: 0.95;
        }

        /* TABLA */
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            background: white;
        }

        th,
        td {
            border: 1px solid #000000;
            padding: 4px 5px;
            vertical-align: middle;
            word-break: break-word;
        }

        th {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 7pt;
            letter-spacing: 0.3px;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #f0f7ff;
        }

        tbody tr:hover {
            background-color: #e3f2fd;
        }

        tfoot tr {
            background-color: #e9e9e9;
            color: rgb(0, 0, 0);
            font-weight: bold;
        }

        tfoot td {
            border-color: #e9e9e9;
        }

        /* UTILIDADES */
        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .nowrap {
            white-space: nowrap;
        }

        .uppercase {
            text-transform: uppercase;
        }

        /* ANCHOS DE COLUMNAS */
        th:nth-child(1),
        td:nth-child(1) {
            width: 8%;
        }

        /* cedula */
        th:nth-child(2),
        td:nth-child(2) {
            width: 13%;
        }

        /* apellidos */
        th:nth-child(3),
        td:nth-child(3) {
            width: 13%;
        }

        /* nombres */
        th:nth-child(4),
        td:nth-child(4) {
            width: 7%;
        }

        /* nivel */
        th:nth-child(5),
        td:nth-child(5) {
            width: 6%;
        }

        /* seccion */
        th:nth-child(6),
        td:nth-child(6) {
            width: 14%;
        }

        /* discapacidad */
        th:nth-child(7),
        td:nth-child(7) {
            width: 16%;
        }

        /* representante */
        th:nth-child(8),
        td:nth-child(8) {
            width: 16%;
        }

        /* contacto */

        /* ESTILOS PARA IMPRESIÓN */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .container {
                page-break-inside: auto;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }
        }

        /* MENSAJE VACÍO */
        .empty-message {
            padding: 20px;
            text-align: center;
            font-style: italic;
            color: #666;
        }

        /* PIE DE PÁGINA */
        .footer-info {
            font-size: 7pt;
            color: #666;
            margin-top: 5px;
        }

        .cintillo-color {
            background-color: #1589e1;
        }

        .encabezado td {
            padding: 3px;
            vertical-align: middle;
        }

        .titulo-principal {
            font-size: 11px;
            font-weight: bold;
            line-height: 1.2;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- CINTILLO SUPERIOR -->
        <table width="100%" class="cintillo cintillo-color encabezado">
            <tr style="color:#eee;">
                <!-- IZQUIERDA -->
                <td width="33%" class="text-left">
                    <img src="{{ public_path('img/logo-ven.webp') }}" alt="Logo" width="90" height="30">
                </td>

                <!-- CENTRO -->
                <td width="34%" class="text-center" style="text-align: center">
                    <strong class="titulo-principal" style="font-size:14px;">
                        LICEO GRAL. JUAN GUILLERMO IRIBARREN
                    </strong><br>
                    PORTUGUESA – ARAURE
                </td>

                <!-- DERECHA -->
                <td width="33%" class="text-right" style="font-size:9px;">
                    Ministerio del Poder Popular<br>
                    para la <b>Educación</b>
                </td>
            </tr>

        </table>

        <!-- TABLA DE DATOS -->
        <table>
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th>Nivel Acad.</th>
                    <th>Secc.</th>
                    <th>Discapacidad</th>
                    <th>Representante Legal</th>
                    <th>Contacto</th>

                </tr>
            </thead>
            <tbody>
                @forelse($nuevoIngresos as $ni)
                    @php
                        $ins = $ni->inscripcion;
                        $al = $ins?->alumno;
                        $per = $al?->persona;
                        $tipoDoc = $per?->tipoDocumento?->abreviacion ?? ($per?->tipoDocumento?->nombre ?? '');
                        $cedula = trim(($tipoDoc ? $tipoDoc . '-' : '') . ($per?->numero_documento ?? ''));
                        $apellidos = trim(($per?->primer_apellido ?? '') . ' ' . ($per?->segundo_apellido ?? ''));
                        $nombres = trim(
                            ($per?->primer_nombre ?? '') .
                                ' ' .
                                ($per?->segundo_nombre ?? '') .
                                ' ' .
                                ($per?->tercer_nombre ?? ''),
                        );
                        $grado = $ins?->grado?->numero_grado ?? 'N/A';
                        $seccion = $ins?->seccionAsignada?->nombre ?? 'N/A';

                        // Discapacidades
                        $discapacidades = '';
                        if ($al && $al->discapacidades && $al->discapacidades->count() > 0) {
                            $discapacidades = $al->discapacidades->pluck('nombre_discapacidad')->implode(', ');
                        } else {
                            $discapacidades = 'Ninguna';
                        }

                        // Representante Legal
                        $repLegal = '';
                        if ($ins && $ins->representanteLegal && $ins->representanteLegal->representante) {
                            $repPersona = $ins->representanteLegal->representante->persona;
                            $repLegal = trim(
                                ($repPersona?->primer_nombre ?? '') . ' ' . ($repPersona?->primer_apellido ?? ''),
                            );
                        } else {
                            $repLegal = 'No especificado';
                        }

                        $telefonoRep = 'N/A';

                        if (
                            $ins &&
                            $ins->representanteLegal &&
                            $ins->representanteLegal->representante &&
                            $ins->representanteLegal->representante->persona
                        ) {
                            $personaRep = $ins->representanteLegal->representante->persona;

                            $telefonos = array_filter([
                                $personaRep->telefono_completo,
                                $personaRep->telefono_dos_completo,
                            ]);

                            $telefonoRep = $telefonos ? implode(' / ', $telefonos) : 'N/A';
                        }
                    @endphp
                    <tr>
                        <td class="text-center nowrap">{{ $cedula ?: 'N/A' }}</td>
                        <td class="text-left">{{ $apellidos ?: 'N/A' }}</td>
                        <td class="text-left">{{ $nombres ?: 'N/A' }}</td>
                        <td class="text-center">{{ $grado }}</td>
                        <td class="text-center">{{ $seccion }}</td>
                        <td class="text-left">{{ $discapacidades }}</td>
                        <td class="text-left">{{ $repLegal }}</td>
                        <td class="text-left">{{ $telefonoRep }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="empty-message">
                            No se encontraron inscripciones de nuevo ingreso con los criterios seleccionados
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10" class="text-right">
                        <strong>TOTAL DE ESTUDIANTES: {{ $nuevoIngresos->count() }}</strong>
                    </td>
                </tr>
            </tfoot>
        </table>
        <p>
            Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}
            @if (!empty($filtros['anio_escolar']))
                | Año Escolar: {{ $filtros['anio_escolar'] }}
            @endif
        </p>

        <script type="text/php">
            if (isset($pdf)) {
                $pdf->page_text(40, 570, "Generado por: {{ Auth::user()->name ?? 'Sistema' }} - {{ date('d/m/Y H:i:s') }}", null, 7, array(90, 90, 90));
                $pdf->page_text(700, 570, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 8, array(0, 0, 0));
            }
        </script>
    </div>
</body>

</html>
