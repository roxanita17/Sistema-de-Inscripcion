<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reporte General Nuevo Ingreso</title>
    <style>
        :root {
            --color-primario: #4361ee;
            --color-primario-pastel: #eef2ff;
            --color-acento: #4cc9f0;
            --color-texto: #2d3748;
            --color-texto-suave: #718096;
            --color-borde: #d1daff;
        }

        @page {
            margin: 1cm 1cm 2.5cm 1cm;
            size: landscape;
        }

        body {
            font-family: 'Segoe UI', 'Roboto', 'Arial', sans-serif;
            font-size: 9pt;
            line-height: 1.4;
            color: var(--color-texto);
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
        }

        .institution-header {
            background-color: var(--color-primario);
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
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
            object-fit: contain;
        }

        .institution-text {
            text-align: center;
        }

        .institution-text h1 {
            margin: 0 0 5px 0;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .institution-subtitle {
            font-size: 0.9rem;
            font-weight: 500;
            margin: 0;
            font-style: italic;
            color: rgba(255, 255, 255, 0.95);
        }

        .header {
            text-align: center;
            margin: 10px 0 10px 0;
            padding: 8px 15px;
            border-bottom: 2px solid var(--color-primario);
            background: var(--color-primario-pastel);
            border-radius: 6px;
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        .header h2 {
            color: var(--color-primario);
            margin: 0 0 4px 0;
            font-size: 13pt;
            font-weight: 700;
            text-transform: uppercase;
        }

        .header p {
            color: var(--color-texto-suave);
            margin: 0;
            font-size: 9pt;
            font-style: italic;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            background: white;
        }

        th,
        td {
            border: 1px solid var(--color-borde);
            padding: 6px 8px;
            vertical-align: middle;
            word-break: break-word;
        }

        th {
            background: var(--color-primario-pastel);
            color: var(--color-texto);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 8pt;
            letter-spacing: 0.4px;
        }

        tr:nth-child(even) {
            background-color: var(--color-primario-pastel);
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .muted {
            color: var(--color-texto-suave);
        }

        .nowrap {
            white-space: nowrap;
        }

        th:nth-child(1), td:nth-child(1) { width: 3%; }
        th:nth-child(2), td:nth-child(2) { width: 8%; }
        th:nth-child(3), td:nth-child(3) { width: 12%; }
        th:nth-child(4), td:nth-child(4) { width: 12%; }
        th:nth-child(5), td:nth-child(5) { width: 8%; }
        th:nth-child(6), td:nth-child(6) { width: 8%; }
        th:nth-child(7), td:nth-child(7) { width: 6%; }
        th:nth-child(8), td:nth-child(8) { width: 11%; }
        th:nth-child(9), td:nth-child(9) { width: 10%; }
        th:nth-child(10), td:nth-child(10) { width: 12%; }
        th:nth-child(11), td:nth-child(11) { width: 10%; }
    </style>
</head>

<body>
    <div class="container">
        <div class="institution-header">
            <img src="{{ public_path('img/Liceo_logo.png') }}" alt="Logo" class="institution-logo">
            <div class="institution-text">
                <h1>Liceo Nacional "Gral. Juan Guillermo Iribarren"</h1>
                <div class="institution-subtitle">Formando líderes para el futuro</div>
            </div>
        </div>

        <div class="header">
            <h2>REPORTE GENERAL - NUEVO INGRESO</h2>
            <p>
                Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}
                @if(!empty($filtros['anio_escolar']))
                    | Año escolar: {{ $filtros['anio_escolar'] }}
                @endif
            </p>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Cédula</th>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th class="text-center">Género</th>
                    <th class="text-center">Nivel Academico</th>
                    <th class="text-center">Sección</th>
                    <th>Discapacidad</th>
                    <th>Etnia</th>
                    <th>Representante Legal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nuevoIngresos as $index => $ni)
                    @php
                        $ins = $ni->inscripcion;
                        $al = $ins?->alumno;
                        $per = $al?->persona;
                        $tipoDoc = $per?->tipoDocumento?->abreviacion ?? $per?->tipoDocumento?->nombre ?? '';
                        $cedula = trim(($tipoDoc ? $tipoDoc . '-' : '') . ($per?->numero_documento ?? ''));
                        $apellidos = trim(($per?->primer_apellido ?? '') . ' ' . ($per?->segundo_apellido ?? ''));
                        $nombres = trim(($per?->primer_nombre ?? '') . ' ' . ($per?->segundo_nombre ?? '') . ' ' . ($per?->tercer_nombre ?? ''));
                        $genero = $per?->genero?->genero ?? 'N/A';
                        $grado = $ins?->grado?->numero_grado ?? 'N/A';
                        $seccion = $ins?->seccionAsignada?->nombre ?? 'N/A';
                        
                        // Discapacidades
                        $discapacidades = '';
                        if ($al && $al->discapacidades && $al->discapacidades->count() > 0) {
                            $discapacidades = $al->discapacidades->pluck('nombre_discapacidad')->implode(', ');
                        } else {
                            $discapacidades = 'Ninguna';
                        }
                        
                        // Etnia
                        $etnia = $al?->etniaIndigena?->nombre ?? 'No pertenece a ninguna etnia indígena';
                        
                        // Representante Legal
                        $repLegal = '';
                        if ($ins && $ins->representanteLegal && $ins->representanteLegal->representante) {
                            $repPersona = $ins->representanteLegal->representante->persona;
                            $repLegal = trim(($repPersona?->primer_nombre ?? '') . ' ' . ($repPersona?->primer_apellido ?? ''));
                        } else {
                            $repLegal = 'No especificado';
                        }
                        
                       
                    @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="text-center nowrap">{{ $cedula ?: 'N/A' }}</td>
                        <td>{{ $apellidos ?: 'N/A' }}</td>
                        <td>{{ $nombres ?: 'N/A' }}</td>
                        <td class="text-center">{{ $genero }}</td>
                        <td class="text-center">{{ $grado }}</td>
                        <td class="text-center">{{ $seccion }}</td>
                        <td>{{ $discapacidades }}</td>
                        <td>{{ $etnia }}</td>
                        <td>{{ $repLegal }}</td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">No se encontraron inscripciones de nuevo ingreso con los criterios seleccionados</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="11" class="text-right"><strong>Total: {{ $nuevoIngresos->count() }}</strong></td>
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