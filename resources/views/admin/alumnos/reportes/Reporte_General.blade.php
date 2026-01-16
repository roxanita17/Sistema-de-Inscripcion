<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte General de Estudiantes</title>
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
        
        .header h3 {
            color: var(--color-texto-suave);
            margin: 4px 0;
            font-size: 10.5pt;
            font-weight: 500;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
        }
        
        .header p {
            color: var(--color-texto-suave);
            margin: 10px 0 0 0;
            font-size: 9pt;
            font-style: italic;
        }
        
        .section {
            margin-bottom: 15px;
            page-break-inside: avoid;
            background: white;
            padding: 12px 15px;
            border-radius: 6px;
            border: 1px solid var(--color-borde);
            box-shadow: 0 1px 3px rgba(67, 97, 238, 0.03);
        }
        
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
        }
        
        .info-item {
            border-bottom: 1px solid var(--color-borde);
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            width: 35%;
            padding: 10px 15px;
            font-weight: 700;
            background-color: var(--color-primario-pastel);
            border-right: 1px solid var(--color-borde);
            line-height: 1.5;
            vertical-align: top;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            color: var(--color-texto);
        }
        
        .info-value {
            padding: 10px 15px;
            line-height: 1.5;
            vertical-align: top;
            word-wrap: break-word;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            color: var(--color-texto);
        }
        
        th, td {
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
            padding: 10px;
            white-space: nowrap;
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
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center !important;
        }
        
        .text-right {
            text-align: right !important;
        }
        
        /* Ajuste de columnas específicas */
        th:nth-child(1), td:nth-child(1) { width: 5%; } /* # */
        th:nth-child(2), td:nth-child(2) { width: 12%; } /* Cédula */
        th:nth-child(3), td:nth-child(3) { width: 15%; } /* Apellidos */
        th:nth-child(4), td:nth-child(4) { width: 18%; } /* Nombres */
        th:nth-child(5), td:nth-child(5) { width: 10%; } /* Fecha Nac. */
        th:nth-child(6), td:nth-child(6) { width: 7%; }  /* Edad */
        th:nth-child(7), td:nth-child(7) { width: 8%; }  /* Sexo */
        th:nth-child(8), td:nth-child(8) { width: 10%; } /* Discapacidad */
        th:nth-child(9), td:nth-child(9) { width: 15%; } /* Institución */
        
        .long-text {
            word-break: break-word;
            overflow-wrap: break-word;
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
            <h2>REPORTE GENERAL DE ESTUDIANTES</h2>
            <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
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
                        <td colspan="9" class="text-center">No se encontraron estudiantes con los criterios seleccionados</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9" class="text-right">
                        <strong>Total de estudiantes: {{ $alumnos->count() }}</strong>
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