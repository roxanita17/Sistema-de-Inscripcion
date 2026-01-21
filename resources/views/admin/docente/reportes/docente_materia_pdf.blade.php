<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de Docentes y Materias</title>
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
            margin: 1.5cm;
            size: portrait;
        }
        
        body {
            font-family: 'Segoe UI', 'Roboto', 'Arial', sans-serif;
            font-size: 10pt;
            line-height: 1.4;
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
            padding: 10px 20px;
            margin: 0 auto 20px auto;
            border-radius: 8px;
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
            max-height: 60px;
            max-width: 60px;
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
            font-size: 1.3rem;
            font-weight: 700;
            line-height: 1.2;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }
        
        .institution-subtitle {
            color: rgba(255, 255, 255, 0.95);
            font-size: 0.85rem;
            font-weight: 500;
            margin: 0;
            font-style: italic;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px 20px;
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
            font-size: 16pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
        }
        
        .header p {
            color: var(--color-texto-suave);
            margin: 5px 0 0 0;
            font-size: 9pt;
            font-style: italic;
        }
        
        .docente-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
            border: 2px solid var(--color-borde);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(67, 97, 238, 0.1);
        }
        
        .docente-header {
            background: linear-gradient(135deg, var(--color-primario) 0%, var(--color-secundario) 100%);
            color: white;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 12pt;
        }
        
        .docente-info {
            background: var(--color-primario-pastel);
            padding: 10px 20px;
            border-bottom: 1px solid var(--color-borde);
        }
        
        .docente-info span {
            font-weight: 600;
            color: var(--color-secundario);
        }
        
        .grado-box {
            margin: 15px;
            border: 1px solid var(--color-borde);
            border-radius: 6px;
            overflow: hidden;
            background: white;
        }
        
        .grado-header {
            background: var(--color-acento-pastel);
            padding: 8px 15px;
            font-weight: 600;
            color: var(--color-primario);
            border-bottom: 1px solid var(--color-borde);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .content-section {
            padding: 15px;
        }
        
        .materias-section, .estudiantes-section {
            margin-bottom: 15px;
        }
        
        .section-title {
            font-weight: 600;
            color: var(--color-secundario);
            margin-bottom: 8px;
            font-size: 11pt;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--color-borde);
            padding-bottom: 5px;
        }
        
        .materia-list, .estudiante-list {
            background: var(--color-fondo);
            border: 1px solid var(--color-borde);
            border-radius: 4px;
            padding: 10px;
        }
        
        .materia-item {
            padding: 4px 0;
            border-bottom: 1px dashed var(--color-borde);
            font-size: 10pt;
        }
        
        .materia-item:last-child {
            border-bottom: none;
        }
        
        .materia-item::before {
            content: "•";
            color: var(--color-primario);
            font-weight: bold;
            margin-right: 8px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            font-size: 9pt;
        }
        
        th, td {
            padding: 6px 8px;
            text-align: left;
            border: 1px solid var(--color-borde);
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            line-height: 1.3;
            vertical-align: middle;
        }
        
        th {
            background: linear-gradient(to bottom, #2c3e50 0%, #34495e 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 8pt;
            letter-spacing: 0.5px;
            text-align: center;
        }
        
        td {
            font-size: 9pt;
        }
        
        .text-center { 
            text-align: center; 
        }
        
        .no-data {
            text-align: center;
            color: var(--color-texto-suave);
            font-style: italic;
            padding: 15px;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9pt;
            color: var(--color-texto-suave);
            padding: 10px 0;
            border-top: 1px solid var(--color-borde);
        }
        
        .page-break {
            page-break-before: always;
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
            <h2>REPORTE DE DOCENTES CON MATERIAS Y ESTUDIANTES</h2>
            <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

        <!-- Contenido principal -->
        @forelse($docentesAgrupados as $docente)
            <div class="docente-section">
                <div class="docente-header">
                    DOCENTE: {{ $docente['primer_nombre'] }} {{ $docente['segundo_nombre'] }} {{ $docente['tercer_nombre'] }} {{ $docente['primer_apellido'] }} {{ $docente['segundo_apellido'] }}
                </div>
                <div class="docente-info">
                    <strong>Código:</strong> <span>{{ $docente['codigo'] ?? 'N/A' }}</span> | 
                    <strong>Cédula:</strong> <span>{{ $docente['numero_documento'] ?? 'N/A' }}</span>
                </div>
                
                @foreach($docente['grados'] as $gradoKey => $gradoData)
                    <div class="grado-box">
                        <div class="grado-header">
                            <span>GRADO: {{ $gradoData['grado'] }}</span>
                            <span>SECCIÓN: {{ $gradoData['seccion_asignada'] ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="content-section">
                            <!-- Materias que dicta el docente en este grado -->
                            <div class="materias-section">
                                <div class="section-title">Materias Asignadas</div>
                                @if(count($gradoData['materias']) > 0)
                                    <div class="materia-list">
                                        @foreach($gradoData['materias'] as $materia)
                                            <div class="materia-item">{{ $materia }}</div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="no-data">No hay materias asignadas</div>
                                @endif
                            </div>
                            
                            <!-- Estudiantes del grado -->
                            <div class="estudiantes-section">
                                <div class="section-title">Estudiantes Asignados</div>
                                @if(count($gradoData['estudiantes']) > 0)
                                    <table>
                                        <thead>
                                            <tr>
                                                <th width="20%">Cédula</th>
                                                <th width="80%">Nombre Completo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($gradoData['estudiantes'] as $estudiante)
                                                <tr>
                                                    <td class="text-center">{{ $estudiante->numero_documento }}</td>
                                                    <td>
                                                        {{ $estudiante->primer_nombre }} 
                                                        {{ $estudiante->segundo_nombre ? $estudiante->segundo_nombre . ' ' : '' }}
                                                        {{ $estudiante->tercer_nombre ? $estudiante->tercer_nombre . ' ' : '' }}
                                                        {{ $estudiante->primer_apellido }} 
                                                        {{ $estudiante->segundo_apellido }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="no-data">No hay estudiantes asignados a este grado</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    @if(!$loop->last)
                        <div style="height: 20px;"></div>
                    @endif
                @endforeach
            </div>
            
            @if(!$loop->last)
                <div class="page-break"></div>
            @endif
        @empty
            <div class="no-data" style="text-align: center; font-size: 12pt; margin: 50px 0;">
                No hay docentes con asignaciones registradas
            </div>
        @endforelse

        <!-- Pie de página -->
        <div class="footer">
            <p><strong>Total de docentes:</strong> {{ count($docentesAgrupados) }}</p>
            <p>Generado por: {{ Auth::user()->name ?? 'Sistema' }} - {{ date('d/m/Y H:i:s') }}</p>
        </div>
        
        <script type="text/php">
            if (isset($pdf)) {
                $pdf->page_text(40, 800, "Generado por: {{ Auth::user()->name ?? 'Sistema' }} - {{ date('d/m/Y H:i:s') }}", null, 8, array(90, 90, 90));
                $pdf->page_text(400, 800, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
            }
        </script>
    </div>
</body>
</html>
