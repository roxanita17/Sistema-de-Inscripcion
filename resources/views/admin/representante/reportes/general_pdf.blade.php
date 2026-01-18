<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reporte de Representantes</title>
    <style>
        :root {
            --color-primario: #4361ee;
            --color-primario-suave: #6b8aff;
            --color-primario-pastel: #eef2ff;
            --color-secundario: #3743a8ff;
            --color-secundario-pastel: #f3e8ff;
            --color-acento: #4cc9f0;
            --color-acento-pastel: #e6f7ff;
            --color-fondo: #ffffff;
            --color-borde: #d1daff;
            --color-texto: #2d3748;
            --color-texto-suave: #718096;
        }

        @page {
            margin: 1cm 1cm 2.5cm 1cm;
            size: landscape;
        }

        body {
            font-family: 'Segoe UI', 'Roboto', 'Arial', sans-serif;
            font-size: 10pt;
            line-height: 1.5;
            color: var(--color-texto);
            margin: 0;
            padding: 0;
            background: var(--color-fondo);
        }

        .container {
            max-width: 100%;
            margin: 0;
            padding: 0;
        }

        .institution-header {
            background-color: var(--color-primario);
            color: white;
            padding: 8px 15px;
            margin: 0 auto 0 auto;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(67, 97, 238, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border-bottom: 2px solid var(--color-acento);
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        .institution-header img {
            max-height: 70px;
            max-width: 70px;
            margin-right: 20px;
            border-radius: 4px;
            border: none;
            padding: 0;
            background: transparent;
            object-fit: contain;
        }

        .institution-text {
            text-align: center;
        }

        .institution-text h1 {
            color: white;
            margin: 0 0 5px 0;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.2;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        .institution-subtitle {
            color: rgba(255, 255, 255, 0.95);
            font-size: 0.9rem;
            font-weight: 500;
            margin: 0;
            font-style: italic;
        }

        .header {
            text-align: center;
            margin-bottom: 0;
            padding: 8px 15px;
            border-bottom: 2px solid var(--color-primario);
            background: var(--color-primario-pastel);
            border-radius: 6px;
            box-shadow: 0 1px 4px rgba(67, 97, 238, 0.08);
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        .header h2 {
            color: var(--color-primario);
            margin: 0 0 5px 0;
            font-size: 14pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
        }

        .header h2.filtros {
            color: var(--color-primario);
            margin: 10px 0 5px 0;
            font-size: 12pt;
            font-weight: 600;
            text-transform: none;
            letter-spacing: normal;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
        }

        .header p {
            color: var(--color-texto-suave);
            margin: 10px 0 0 0;
            font-size: 9pt;
            font-style: italic;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 0 0 0;
            page-break-inside: avoid;
            page-break-before: avoid;
            background: white;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(67, 97, 238, 0.08);
            table-layout: fixed;
            font-size: 9pt;
        }

        th,
        td {
            padding: 6px 8px;
            text-align: left;
            border: 1px solid var(--color-borde);
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            line-height: 1.3;
            border-top: none;
            border-bottom: 1px solid var(--color-borde);
            border-right: 1px solid var(--color-borde);
            border-left: 1px solid var(--color-borde);
            vertical-align: middle;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        th {

            color: var(--color-texto);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 8pt;
            letter-spacing: 0.5px;
            padding: 8px 6px;
            white-space: nowrap;
            text-align: center;
        }

        tr {
            border-bottom: 1px solid rgba(67, 97, 238, 0.1);
        }

        tr:last-child {
            border-bottom: none;
        }

        tr:nth-child(even) {
            background-color: var(--color-primario-pastel);
        }

        tr:hover {
            background-color: var(--color-acento-pastel) !important;
            transition: background-color 0.2s ease;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: var(--color-texto-suave);
        }

        .text-center {
            text-align: center !important;
        }

        .text-right {
            text-align: right !important;
        }

        .long-text {
            word-break: break-word;
            overflow-wrap: break-word;
        }

        /* Ajuste de columnas específicas */
        th:nth-child(1),
        td:nth-child(1) {
            width: 6%;
        }

        /* Cédula Representante */
        th:nth-child(2),
        td:nth-child(2) {
            width: 12%;
        }

        /* Nombre Representante */
        th:nth-child(3),
        td:nth-child(3) {
            width: 12%;
        }

        /* Apellido Representante */
        th:nth-child(4),
        td:nth-child(4) {
            width: 20%;
        }

        /* Estudiante (Cédula y Nombre) */
        th:nth-child(5),
        td:nth-child(5) {
            width: 8%;
        }

        /* Teléfono */
        th:nth-child(6),
        td:nth-child(6) {
            width: 10%;
        }

        /* Correo */
        th:nth-child(7),
        td:nth-child(7) {
            width: 8%;
        }

        /* Ocupación */
        th:nth-child(8),
        td:nth-child(8) {
            width: 6%;
        }

        /* Tipo */
        th:nth-child(9),
        td:nth-child(9) {
            width: 6%;
        }

        /* Sección */
        th:nth-child(10),
        td:nth-child(10) {
            width: 6%;
        }

        /* Grado */
        @if (isset($filtros['es_legal']) && $filtros['es_legal'])
            th:nth-child(11),
            td:nth-child(11) {
                width: 8%;
            }

            /* Banco */
            th:nth-child(12),
            td:nth-child(12) {
                width: 8%;
            }

            /* N° Cuenta */
            th:nth-child(13),
            td:nth-child(13) {
                width: 6%;
            }

            /* Parentesco */
        @endif

        /* Alineación de celdas */
        td {
            font-size: 8.5pt;
        }

        td.text-center {
            text-align: center;
        }
    </style>
</head>

<body class="clearfix">
    <div class="container">
        <div class="institution-header">
            <img src="{{ public_path('img/Liceo_logo.png') }}" alt="Logo" class="institution-logo">
            <div class="institution-text">
                <h1>Liceo Nacional "Gral. Juan Guillermo Iribarren"</h1>
                <div class="institution-subtitle">Formando líderes para el futuro</div>
            </div>
        </div>

        <div class="header">
            <h2>REPORTE DE REPRESENTANTES</h2>



            @if (isset($filtro))
                <STRONG>
                    <H3
                        style="margin-top: 10px; font-size: 12pt; font-weight: 600; text-transform: none; letter-spacing: normal; font-family: 'Segoe UI', 'Roboto', sans-serif; color: var(--color-primario);">
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
                    </H3>
                </STRONG>
            @endif
            <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
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
                            class="text-center">
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

        <script type="text/php">
            if (isset($pdf)) {
                $pdf->page_text(40, 570, "Generado por: {{ Auth::user()->name ?? 'Sistema' }} - {{ date('d/m/Y H:i:s') }}", null, 8, array(90, 90, 90));
                $pdf->page_text(400, 570, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
            }
        </script>
    </div>
</body>

</html>
