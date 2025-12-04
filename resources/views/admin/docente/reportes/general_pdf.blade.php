<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte General de Docentes</title>
    <style>
        body { 
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.5;
            color: #212529;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }
        .header {
            background-color: #f8f9fa;
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 20px;
            text-align: center;
            font-family: DejaVu Sans, Arial, sans-serif;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .header h2 {
            color: #007bff;
            margin: 0 0 5px 0;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.3;
            font-family: DejaVu Sans, Arial, sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 0;
            color: #6c757d;
            font-size: 0.85rem;
            line-height: 1.4;
            font-family: DejaVu Sans, Arial, sans-serif;
        }
        .section {
            margin-bottom: 25px;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: 0.25rem;
            overflow: hidden;
            font-family: DejaVu Sans, Arial, sans-serif;
        }
        .section-title {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
            line-height: 1.3;
            font-family: DejaVu Sans, Arial, sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            font-family: DejaVu Sans, Arial, sans-serif;
        }
        .info-item {
            border-bottom: 1px solid #dee2e6;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            width: 35%;
            padding: 10px 15px;
            font-weight: 700;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            line-height: 1.5;
            vertical-align: top;
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #495057;
        }
        .info-value {
            padding: 10px 15px;
            line-height: 1.5;
            vertical-align: top;
            word-wrap: break-word;
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #212529;
        }
        .footer {
            margin-top: 30px;
            padding: 15px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            color: #6c757d;
            font-size: 0.85rem;
            line-height: 1.4;
            font-family: DejaVu Sans, Arial, sans-serif;
        }
        .institution-header {
            background-color: #007bff;
            color: white;
            padding: 15px 20px;
            margin: 0 auto 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }
        .institution-header img {
            max-height: 70px;
            max-width: 70px;
        }
        .institution-text {
            text-align: center;
        }
        .institution-header h1 {
            margin: 0 0 5px 0;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.2;
            font-family: DejaVu Sans, Arial, sans-serif;
        }
        .institution-subtitle {
            font-size: 0.9rem;
            font-weight: 500;
            margin: 0;
            opacity: 0.9;
            font-family: DejaVu Sans, Arial, sans-serif;
        }
        .text-muted { color: #6c757d !important; }
        p, td, span {
            line-height: 1.5;
            font-family: DejaVu Sans, Arial, sans-serif;
        }
        .long-text {
            word-break: break-word;
            overflow-wrap: break-word;
        }
        .table-grid {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table-grid th {
            background-color: #f8f9fa;
            padding: 8px 10px;
            text-align: left;
            border: 1px solid #dee2e6;
            font-weight: 700;
        }
        .table-grid td {
            padding: 8px 10px;
            border: 1px solid #dee2e6;
        }
        .text-center {
            text-align: center;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin-left: auto;
            padding-top: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Encabezado de la institución -->
        <div class="institution-header">
            <div class="logo-wrapper">
                <img src="{{ public_path('img/Liceo_logo.png') }}" alt="Logo" class="institution-logo">
            </div>
            <div class="institution-text">
                <h1>Liceo Nacional "Gral. Juan Guillermo Iribarren"</h1>
                <div class="institution-subtitle">Formando líderes para el futuro</div>
            </div>
        </div>

        <!-- Encabezado del documento -->
        <div class="header">
            <h2>LISTA GENERAL DE DOCENTES</h2>
            <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

        <!-- Tabla de docentes -->
        <div class="section">
            <table class="table-grid" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th width="15%">Cédula</th>
                        <th width="30%">Nombres y Apellidos</th>
                        <th width="15%">Género</th>
                        <th width="40%">Estudios Realizados</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($docentes as $docente)
                    <tr>
                        <td>{{ $docente->tipo_documento ?? 'N/A' }}-{{ $docente->numero_documento ?? 'N/A' }}</td>
                        <td>
                            {{ $docente->primer_nombre ?? '' }}
                            {{ $docente->segundo_nombre ?? '' }}
                            {{ $docente->primer_apellido ?? '' }}
                            {{ $docente->segundo_apellido ?? '' }}
                        </td>
                        <td>{{ $docente->genero ?? 'N/A' }}</td>
                        <td>
                            @if(isset($docente->detalleDocenteEstudio) && $docente->detalleDocenteEstudio->count() > 0)
                                @foreach($docente->detalleDocenteEstudio as $key => $detalle)
                                    • {{ $detalle->estudiosRealizado->estudios ?? 'N/A' }}<br>
                                @endforeach
                            @else
                                Sin estudios registrados
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No hay docentes registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pie de página -->
        <div class="footer">
            <p>Total de docentes: {{ $docentes->count() }}</p>
            <p>Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>