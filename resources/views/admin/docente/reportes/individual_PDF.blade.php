<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ficha del Docente - {{ $docente->numero_documento ?? 'N/A' }}</title>
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
        
        .institution-header h1 {
            margin: 0 0 5px 0;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.2;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            color: white;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }
        
        .institution-subtitle {
            font-size: 0.9rem;
            font-weight: 500;
            margin: 0;
            opacity: 0.95;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            font-style: italic;
            color: rgba(255, 255, 255, 0.95);
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
            margin: 0 0 8px 0;
            font-size: 16pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            text-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
        }
        
        .header h2 {
            color: var(--color-secundario);
            margin: 4px 0;
            font-size: 13pt;
            font-weight: 600;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            text-transform: none;
            letter-spacing: 0.3px;
        }
        
        .header p {
            color: var(--color-texto-suave);
            margin: 8px 0 0 0;
            font-size: 9pt;
            font-style: italic;
            letter-spacing: 0.2px;
        }
        
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
            background: white;
            padding: 15px 18px 18px;
            border-radius: 8px;
            border: 1px solid var(--color-borde);
            box-shadow: 0 2px 8px rgba(67, 97, 238, 0.05);
        }
        
        .section-content {
            padding: 5px 0;
        }
        
        .section-title {
            color: var(--color-primario);
            font-size: 11pt;
            margin: 5px 0 12px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--color-borde);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            padding-left: 12px;
        }
        
        .section-title::before {
            content: '';
            position: absolute;
            left: 0;
            top: 6px;
            height: 16px;
            width: 4px;
            background: var(--color-primario);
            border-radius: 2px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            left: 12px;
            bottom: -1px;
            width: 60px;
            height: 2px;
            background: var(--color-acento);
            border-radius: 2px;
        }
        
        .info-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 8px 0 0 0;
            background: white;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(67, 97, 238, 0.08);
        }
        
        .info-item {
            transition: background-color 0.2s ease;
        }
        
        .info-item:not(:last-child) {
            border-bottom: 1px solid var(--color-borde);
        }
        
        .info-item:hover {
            background-color: var(--color-acento-pastel);
        }
        
        .info-label {
            width: 35%;
            padding: 10px 15px;
            font-weight: 600;
            background-color: var(--color-primario-pastel);
            border-right: 1px solid var(--color-borde);
            color: var(--color-secundario);
            font-size: 9.5pt;
            vertical-align: top;
        }
        
        .info-value {
            padding: 10px 15px;
            color: var(--color-texto);
            word-break: break-word;
            font-size: 10pt;
            line-height: 1.5;
        }
        
        .table-grid {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0 0 0;
            page-break-inside: avoid;
            background: white;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(67, 97, 238, 0.08);
        }
        
        .table-grid th {
            background: linear-gradient(to bottom, var(--color-primario) 0%, var(--color-primario-suave) 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 9pt;
            letter-spacing: 0.5px;
            padding: 8px 12px;
            text-align: left;
            border: 1px solid var(--color-borde);
        }
        
        .table-grid td {
            padding: 8px 12px;
            border: 1px solid var(--color-borde);
            font-size: 9.5pt;
            line-height: 1.4;
        }
        
        .table-grid tr:nth-child(even) {
            background-color: var(--color-primario-pastel);
        }
        
        .table-grid tr:hover {
            background-color: var(--color-acento-pastel) !important;
        }
        
        .footer {
            margin-top: 30px;
            padding: 15px 0 5px;
            border-top: 1px dashed var(--color-borde);
            text-align: right;
            color: var(--color-texto-suave);
            font-size: 9pt;
            font-style: italic;
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
        
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        
        .signature-line {
            border-top: 1px solid var(--color-borde);
            width: 200px;
            margin-left: auto;
            padding-top: 5px;
            text-align: center;
            color: var(--color-texto-suave);
            font-size: 9pt;
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
            <h1>FICHA INDIVIDUAL DEL DOCENTE</h1>
            <h2>{{ $docente->primer_nombre ?? 'N/A' }} {{ $docente->primer_apellido ?? 'N/A' }}</h2>
            <p>Cédula: {{ $docente->tipo_documento ?? 'N/A' }}-{{ $docente->numero_documento ?? 'N/A' }} • Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

        <!-- Sección de Datos Personales -->
        <div class="section">
            <div class="section-title">INFORMACIÓN PERSONAL</div>
            <div class="section-content">
            <table class="info-grid">
                <tr class="info-item">
                    <td class="info-label">Cédula de Identidad:</td>
                    <td class="info-value">{{ $docente->tipo_documento ?? 'N/A' }}-{{ $docente->numero_documento ?? 'N/A' }}</td>
                </tr>
                <tr class="info-item">
                    <td class="info-label">Nombres:</td>
                    <td class="info-value">
                        {{ $docente->primer_nombre ?? 'N/A' }}
                        {{ $docente->segundo_nombre ?? '' }}
                        {{ $docente->tercer_nombre ?? '' }}
                    </td>
                </tr>
                <tr class="info-item">
                    <td class="info-label">Apellidos:</td>
                    <td class="info-value">
                        {{ $docente->primer_apellido ?? 'N/A' }}
                        {{ $docente->segundo_apellido ?? '' }}
                    </td>
                </tr>
                <tr class="info-item">
                    <td class="info-label">Fecha de Nacimiento:</td>
                    <td class="info-value">
                        @if(isset($docente->fecha_nacimiento) && $docente->fecha_nacimiento !== 'N/A')
                            {{ \Carbon\Carbon::parse($docente->fecha_nacimiento)->format('d/m/Y') }}
                            ({{ \Carbon\Carbon::parse($docente->fecha_nacimiento)->age }} años)
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr class="info-item">
                    <td class="info-label">Género:</td>
                    <td class="info-value">{{ $docente->genero ?? 'N/A' }}</td>
                </tr>
                <tr class="info-item">
                    <td class="info-label">Correo Electrónico:</td>
                    <td class="info-value">{{ $docente->email ?? 'N/A' }}</td>
                </tr>
                <tr class="info-item">
                    <td class="info-label">Teléfono:</td>
                    <td class="info-value">{{ $docente->telefono ?? 'N/A' }}</td>
                </tr>
                <tr class="info-item">
                    <td class="info-label">Dirección:</td>
                    <td class="info-value">{{ $docente->direccion ?? 'N/A' }}</td>
                </tr>
                <tr class="info-item">
                    <td class="info-label">Dependencia:</td>
                    <td class="info-value">{{ $docente->dependencia ?? 'N/A' }}</td>
                </tr>
            </table>
            </div>
        </div>

        <!-- Sección de Estudios Realizados -->
        <div class="section">
            <div class="section-title">ESTUDIOS REALIZADOS</div>
            <div class="section-content">
                <table class="table-grid">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Estudio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($docente->detalleDocenteEstudio) && $docente->detalleDocenteEstudio->count() > 0)
                            @foreach($docente->detalleDocenteEstudio as $key => $detalle)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>{{ $detalle->estudiosRealizado->estudios ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="2" class="text-center">No se encontraron registros de estudios</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pie de página -->
        <div class="footer">
            Generado el {{ now()->format('d/m/Y H:i:s') }}
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