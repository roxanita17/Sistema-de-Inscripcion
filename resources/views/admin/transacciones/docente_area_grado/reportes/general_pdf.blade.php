<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reporte General de Docentes</title>
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
            margin: 1cm;
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

        .header h1 {
            color: var(--color-primario);
            margin: 0 0 5px 0;
            font-size: 14pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
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
            box-shadow: 0 1px 3px rgba(67, 97, 238, 0.05);
            table-layout: fixed;
            font-size: 9pt;
        }

        th,
        td {
            padding: 8px 10px;
            text-align: left;
            border: 1px solid var(--color-borde);
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            line-height: 1.3;
            border-top: none;
            border-bottom: 1px solid var(--color-borde);
            border-right: 1px solid var(--color-borde);
            border-left: 1px solid var(--color-borde);
            vertical-align: middle;
        }

        td {
            padding: 8px 10px;
        }

        th {
            color: var(--color-texto);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 9pt;
            letter-spacing: 0.5px;
            background: linear-gradient(to bottom, #2c3e50 0%, #34495e 100%);
            text-align: center;
        }

        /* Ajuste de columnas específicas */
        th:nth-child(1),
        td:nth-child(1) {
            width: 12%;
        }

        /* Cédula */
        th:nth-child(2),
        td:nth-child(2) {
            width: 25%;
        }

        /* Nombres */
        th:nth-child(3),
        td:nth-child(3) {
            width: 10%;
        }

        /* Género */
        th:nth-child(4),
        td:nth-child(4) {
            width: 20%;
        }

        /* Estudios */
        th:nth-child(5),
        td:nth-child(5) {
            width: 15%;
        }

        /* Sección */
        th:nth-child(6),
        td:nth-child(6) {
            width: 18%;
        }

        /* Área de formación */

        /* Alineación de celdas */
        td {
            font-size: 9pt;
            padding: 8px 10px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .long-text {
            word-break: break-word;
            overflow-wrap: break-word;
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
            font-size: 10pt;
            color: var(--color-texto-suave);
            padding: 10px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Encabezado de la institución -->
        <div class="institution-header">
            <img src="{{ public_path('img/Liceo_logo.png') }}" alt="Logo" class="institution-logo">
            <div class="institution-text">
                <h1>Liceo Nacional "Gral. Juan Guillermo Iribarren"</h1>
                <div class="institution-subtitle">Formando líderes para el futuro</div>
            </div>
        </div>

        <!-- Encabezado del documento -->
        <div class="header">
            <h2>REPORTE GENERAL DE DOCENTES CON AREAS DE FORMACION ASIGNADAS</h2>
            <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

        <!-- Tabla de docentes -->
        <table>
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Nombres y Apellidos</th>
                    <th>Género</th>
                    <th>Áreas de formación, grado y sección</th>
                    <th>Grupos Estables</th>
                </tr>
            </thead>
            <tbody>
                @forelse($docentes as $docente)
                    <tr>
                        <td class="text-center">
                            {{ $docente->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $docente->persona->numero_documento ?? 'N/A' }}
                        </td>
                        <td class="long-text " >
                            {{ $docente->persona->primer_nombre ?? '' }}
                            {{ $docente->persona->segundo_nombre ?? '' }}
                            {{ $docente->persona->primer_apellido ?? '' }}
                            {{ $docente->persona->segundo_apellido ?? '' }}
                        </td>
                        <td class="text-center">{{ $docente->persona->genero->genero ?? 'N/A' }}</td>

                        {{-- Áreas de formación con grado y sección --}}
                        <td class="long-text">
                            @php
                                $areas = $docente->asignacionesAreas
                                    ->where('status', true)
                                    ->where('tipo_asignacion', 'area')
                                    ->filter(fn($a) => $a->areaEstudios !== null); // solo áreas válidas
                            @endphp

                            @forelse($areas as $asign)
                                <strong>Área:</strong>
                                {{ optional($asign->areaEstudios->areaFormacion)->nombre_area_formacion ?? 'N/A' }} |
                                <strong>Nivel:</strong> {{ optional($asign->grado)->numero_grado ?? 'N/A' }} |
                                <strong>Sección:</strong> {{ optional($asign->seccion)->nombre ?? 'N/A' }}
                                @if (!$loop->last)
                                    <br>
                                @endif
                            @empty
                                Sin áreas asignadas
                            @endforelse
                        </td>


                        {{-- Grupos estables --}}
                        <td class="long-text">
                            @php
                                $grupos = $docente->asignacionesAreas
                                    ->where('status', true)
                                    ->where('tipo_asignacion', 'grupo_estable');
                            @endphp

                            @forelse($grupos as $asign)
                                <strong>Grupo:</strong>
                                {{ optional($asign->grupoEstable)->nombre_grupo_estable ?? 'N/A' }} |
                                <strong>Nivel:</strong>
                                {{ optional($asign->gradoGrupoEstable)->numero_grado ?? 'N/A' }}
                                @if (!$loop->last)
                                    <br>
                                @endif
                            @empty
                                Sin grupos asignados
                            @endforelse
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay docentes registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>




        <!-- Pie de página -->
        <div class="footer">
            <p>Total de docentes: <strong>{{ $docentes->count() }}</strong></p>
            <p>Generado por: {{ Auth::user()->name ?? 'Sistema' }} - {{ date('d/m/Y H:i:s') }}</p>
        </div>

        <script type="text/php">
            if (isset($pdf)) {
                $pdf->page_text(40, 570, "Generado por: {{ Auth::user()->name ?? 'Sistema' }} - {{ date('d/m/Y H:i:s') }}", null, 8, array(90, 90, 90));
                $pdf->page_text(400, 570, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
            }
        </script>
    </div>
</body>

</html>
