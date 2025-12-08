<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de Representantes</title>
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
        }
        .institution-header img {
            max-height: 70px;
            max-width: 70px;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 9px;
            table-layout: fixed;
            word-wrap: break-word;
        }
        th {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 6px;
            border: 1px solid #dee2e6;
            font-weight: bold;
        }
        td {
            padding: 5px;
            border: 1px solid #dee2e6;
            word-wrap: break-word;
            vertical-align: top;
        }
        td, th {
            max-width: 100px; /* Ancho máximo para las celdas */
            overflow: hidden;
            text-overflow: ellipsis;
        }
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px; 
            color: #6c757d;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="institution-header">
        <div class="logo-wrapper">
            <img src="{{ public_path('images/comunidad/liceo_logo.png') }}" alt="Logo" class="institution-logo">
        </div>
        <div class="institution-text">
            <h1>Liceo Nacional "Gral. Juan Guillermo Iribarren"</h1>
            <div class="institution-subtitle">Reporte de Representantes</div>
        </div>
    </div>

    <div class="header">
        <h2>REPORTE DE REPRESENTANTES</h2>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
        @if(isset($filtros['es_legal']))
            <p>Tipo: {{ $filtros['es_legal'] ? 'Solo Representantes Legales' : 'Solo Representantes No Legales' }}</p>
        @else
            <p>Tipo: Todos los Representantes</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 8%;">Cédula</th>
                <th style="width: 15%;">Nombres Completos</th>
                <th style="width: 8%;">Teléfono</th>
                <th style="width: 12%;">Correo</th>
                <th style="width: 8%;">Estado</th>
                <th style="width: 8%;">Municipio</th>
                <th style="width: 10%;">Parroquia</th>
                <th style="width: 15%;">Ocupación</th>
                <th style="width: 8%;">Tipo</th>
                @if(isset($filtros['es_legal']) && $filtros['es_legal'])
                    <th>Banco</th>
                    <th>N° Cuenta</th>
                    <th>Parentesco</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($representantes as $index => $representante)
                <tr>
                    <td style="text-align: center;">{{ $representante->numero_documento }}</td>
                    <td>
                        {{ $representante->primer_nombre }} 
                        {{ $representante->segundo_nombre ?? '' }} 
                        {{ $representante->primer_apellido }} 
                        {{ $representante->segundo_apellido ?? '' }}
                    </td>
                    <td style="text-align: center;">{{ $representante->telefono ?? 'N/A' }}</td>
                    <td style="word-break: break-all;">{{ $representante->email ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ $representante->estado_nombre ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ $representante->municipio_nombre ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ $representante->localidad_nombre ?? 'N/A' }}</td>
                    <td style="word-break: break-word;">{{ $representante->ocupacion_nombre ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ $representante->parentesco ? 'Representante Legal' : 'Progenitor' }}</td>
                    @if(isset($filtros['es_legal']) && $filtros['es_legal'])
                        <td style="text-align: center;">{{ $representante->banco_nombre ?? 'N/A' }}</td>
                        <td style="text-align: center;">{{ $representante->codigo_carnet_patria_representante ?? 'N/A' }}</td>
                        <td style="text-align: center;">{{ $representante->parentesco ?? 'N/A' }}</td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ isset($filtros['es_legal']) && $filtros['es_legal'] ? 14 : 11 }}" class="text-center">
                        No se encontraron representantes con los criterios seleccionados
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="{{ isset($filtros['es_legal']) && $filtros['es_legal'] ? 14 : 11 }}" class="text-right">
                    <strong>Total de representantes: {{ $representantes->count() }}</strong>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Generado por: {{ Auth::user()->name ?? 'Sistema' }} - {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>