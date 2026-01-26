<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reporte de Representantes</title>
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

        .header h2.filtros {
            color: #333;
            margin: 10px 0 5px 0;
            font-size: 10pt;
            font-weight: 600;
            text-transform: none;
            letter-spacing: normal;
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
            width: 6%;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 12%;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 12%;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 18%;
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 6%;
        }

        th:nth-child(6),
        td:nth-child(6) {
            width: 10%;
        }

        th:nth-child(7),
        td:nth-child(7) {
            width: 8%;
        }

        th:nth-child(8),
        td:nth-child(8) {
            width: 6%;
        }

        th:nth-child(9),
        td:nth-child(9) {
            width: 6%;
        }

        th:nth-child(10),
        td:nth-child(10) {
            width: 8%;
        }

        th:nth-child(11),
        td:nth-child(11) {
            width: 8%;
        }

        th:nth-child(12),
        td:nth-child(12) {
            width: 8%;
        }

        th:nth-child(13),
        td:nth-child(13) {
            width: 6%;
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
            <h2>REPORTE DE REPRESENTANTES</h2>

            @if (isset($filtro))
                <h3 class="filtros">
                    @if ($filtro['grado_id'] ?? false)
                        <strong>NIVEL ACADÉMICO:
                            {{ App\Models\Grado::find($filtro['grado_id'])->numero_grado ?? '' }}°</strong>
                    @endif

                    @if ($filtro['seccion_id'] ?? false)
                        <strong>SECCIÓN: {{ $filtro['seccion_id'] }}</strong>
                    @endif

                    @if ($filtro['es_legal'] ?? false)
                        <strong>TIPO:
                            {{ $filtro['es_legal'] == '1' ? 'REPRESENTANTES LEGALES' : 'PROGENITORES' }}</strong>
                    @endif
                </h3>
            @endif
        </div>

        <table>
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Estudiante</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Ocupación</th>
                    <th>Tipo</th>
                    <th>Sección</th>
                    <th>Nivel academico</th>
                    @if (isset($filtros['es_legal']) && $filtros['es_legal'])
                        <th>Banco</th>
                        <th>N° Cuenta</th>
                        <th>Parentesco</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($representantes as $index => $representante)
                    <tr>
                        <td class="text-center">{{ $representante->numero_documento ?? 'N/A' }}</td>
                        <td class="long-text">
                            {{ $representante->primer_nombre ?? 'N/A' }}
                            {{ $representante->segundo_nombre ?? '' }}
                        </td>
                        <td>{{ $representante->primer_apellido ?? 'N/A' }} {{ $representante->segundo_apellido ?? '' }}
                        </td>
                        <td class="long-text">
                            @if ($representante->alumno_cedula && $representante->alumno_primer_nombre)
                                <strong>{{ $representante->alumno_cedula }}</strong><br>
                                {{ $representante->alumno_primer_nombre ?? '' }}
                                {{ $representante->alumno_segundo_nombre ?? '' }}
                                {{ $representante->alumno_primer_apellido ?? '' }}
                                {{ $representante->alumno_segundo_apellido ?? '' }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="text-center">{{ $representante->telefono ?? 'N/A' }}</td>
                        <td class="long-text">{{ $representante->email ?? 'N/A' }}</td>
                        <td class="long-text">{{ $representante->ocupacion_nombre ?? 'N/A' }}</td>
                        <td class="text-center">{{ $representante->parentesco ? 'Representante Legal' : 'Progenitor' }}
                        </td>
                        <td class="text-center">{{ $representante->seccion_nombre ?? 'N/A' }}</td>
                        <td class="text-center">{{ $representante->numero_grado ?? 'N/A' }}°</td>
                        @if (isset($filtros['es_legal']) && $filtros['es_legal'])
                            <td class="text-center">{{ $representante->banco_nombre ?? 'N/A' }}</td>
                            <td class="text-center">{{ $representante->codigo_carnet_patria_representante ?? 'N/A' }}
                            </td>
                            <td class="text-center">{{ $representante->parentesco ?? 'N/A' }}</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ isset($filtros['es_legal']) && $filtros['es_legal'] ? 13 : 10 }}"
                            class="empty-message">
                            No se encontraron representantes con los criterios seleccionados
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="{{ isset($filtros['es_legal']) && $filtros['es_legal'] ? 13 : 10 }}"
                        class="text-right">
                        <strong>Total de representantes: {{ $representantes->count() }}</strong>
                    </td>
                </tr>
            </tfoot>
        </table>
   <!-- FECHA DE GENERACIÓN -->
        <div style="margin-top: 30px; text-align: left; font-size: 9px; color: #666;">
            Generado: {{ date('d/m/Y H:i:s') }}
        </div>
        <script type="text/php">
            if (isset($pdf)) {
                $pdf->page_text(40, 570, "Generado por: {{ Auth::user()->name ?? 'Sistema' }} - {{ date('d/m/Y H:i:s') }}", null, 7, array(90, 90, 90));
                $pdf->page_text(700, 570, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 8, array(0, 0, 0));
            }
        </script>
    </div>
</body>

</html>
