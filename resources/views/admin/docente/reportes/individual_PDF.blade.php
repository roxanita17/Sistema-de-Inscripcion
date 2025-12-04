<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ficha del Docente - {{ $docente->numero_documento ?? 'N/A' }}</title>
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
            <h2>FICHA INDIVIDUAL DEL DOCENTE  </h2>
            <h2>{{ $docente->primer_nombre ?? 'N/A' }} {{ $docente->primer_apellido ?? 'N/A' }}</h2>
            <p>Cédula: {{ $docente->tipo_documento ?? 'N/A' }}-{{ $docente->numero_documento ?? 'N/A' }}</p>
            <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

        <!-- Sección de Datos Personales -->
        <div class="section">
            <div class="section-title">INFORMACIÓN PERSONAL</div>
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

        <!-- Sección de Estudios Realizados -->
<div class="section">
    <div class="section-title">ESTUDIOS REALIZADOS</div>
    <table class="table-grid">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="40%">Estudio</th>
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
                    <td colspan="4" class="text-center">No se encontraron registros de estudios</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

        <!-- Pie de página -->
        <div class="footer">
            Generado el {{ now()->format('d/m/Y H:i:s') }}
        </div>
    </div>


</body>
</html>