<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte General de Estudiantes</title>
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
            background: #e9ecef;
            color: #333;
            border: 1px solid #ced4da;
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
            width: 12%;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 15%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 18%;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 10%;
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 7%;
        }

        th:nth-child(6),
        td:nth-child(6) {
            width: 8%;
        }

        th:nth-child(7),
        td:nth-child(7) {
            width: 10%;
        }

        th:nth-child(8),
        td:nth-child(8) {
            width: 10%;
        }

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

        .long-text {
            word-break: break-word;
            overflow-wrap: break-word;
        }
    </style>
</head>
<body class="clearfix">
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

        <!-- ENCABEZADO REPORTE -->
        <div class="header">
            <h2>REPORTE GENERAL DE ESTUDIANTES</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th>Fecha Nac.</th>
                    <th>Edad</th>
                    <th>Sexo</th>
                    <th>País</th>
                    <th>Discapacidad</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumnos as $index => $alumno)
                    <tr>
                        <td>{{ $alumno['tipo_documento'] ? $alumno['tipo_documento'] . '-' : '' }}{{ $alumno['numero_documento'] ?? 'N/A' }}</td>
                        <td>{{ trim($alumno['primer_apellido'] . ' ' . $alumno['segundo_apellido']) }}</td>
                        <td>{{ trim($alumno['primer_nombre'] . ' ' . $alumno['segundo_nombre'] . ' ' . $alumno['tercer_nombre']) }}</td>
                        <td class="text-center">{{ $alumno['fecha_nacimiento'] ? date('d/m/Y', strtotime($alumno['fecha_nacimiento'])) : 'N/A' }}</td>
                        <td class="text-center">
                            @if($alumno['fecha_nacimiento'])
                                {{ $alumno['edad'] }} años
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="text-center">{{ $alumno['genero'] }}</td>
                        <td class="text-center">{{ $alumno['pais'] }}</td>
                        <td class="text-center">{{ $alumno['discapacidad'] }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty-message">No se encontraron estudiantes con los criterios seleccionados</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" class="text-right">
                        <strong>Total de estudiantes: {{ $alumnos->count() }}</strong>
                    </td>
                </tr>
            </tfoot>
        </table>

        <p class="footer-info">
            Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}
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