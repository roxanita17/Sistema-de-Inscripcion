<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte General de Estudiantes</title>
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
            font-size: 10px;
        }
        th {
            background-color: #007bff;
            color: white;
            text-align: left;
            padding: 6px;
            border: 1px solid #dee2e6;
        }
        td {
            padding: 5px;
            border: 1px solid #dee2e6;
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
                <img src="{{ public_path('img/Liceo_logo.png') }}" alt="Logo" class="institution-logo">
            </div>
            <div class="institution-text">
                <h1>Liceo Nacional "Gral. Juan Guillermo Iribarren"</h1>
                <div class="institution-subtitle">Formando líderes para el futuro</div>
            </div>
        </div>

    <div class="header">
        <h2>REPORTE GENERAL DE ESTUDIANTES</h2>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    @if(isset($fecha_inicio) || isset($fecha_fin) || isset($sexo) || isset($edad_min) || isset($edad_max) || isset($discapacidad))
    <div class="filters">
        <strong>Filtros aplicados:</strong><br>
        @if(isset($fecha_inicio) || isset($fecha_fin))
            <span>Fecha de registro:</span> 
            {{ $fecha_inicio ? date('d/m/Y', strtotime($fecha_inicio)) : 'Inicio' }} 
            a 
            {{ $fecha_fin ? date('d/m/Y', strtotime($fecha_fin)) : 'Actual' }}<br>
        @endif
        @if(isset($sexo) && $sexo)
            <span>Sexo:</span> {{ $sexo }}<br>
        @endif
        @if(isset($edad_min) || isset($edad_max))
            <span>Edad:</span> 
            {{ $edad_min ?? 'Mín' }} a {{ $edad_max ?? 'Máx' }} años<br>
        @endif
        @if(isset($discapacidad) && $discapacidad !== null)
            <span>Discapacidad:</span> {{ $discapacidad ? 'Sí' : 'No' }}<br>
        @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Cédula</th>
                <th>Apellidos</th>
                <th>Nombres</th>
                <th>Fecha Nac.</th>
                <th>Edad</th>
                <th>Sexo</th>
                <th>Discapacidad</th>
                <th>Institución</th>
            </tr>
        </thead>
        <tbody>
            @forelse($alumnos as $index => $alumno)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $alumno->tipo_documento ?? 'N/A' }}-{{ $alumno->numero_documento ?? 'N/A' }}</td>
                    <td>{{ ($alumno->primer_apellido ?? '') . ' ' . ($alumno->segundo_apellido ?? '') }}</td>
                    <td>{{ ($alumno->primer_nombre ?? '') . ' ' . ($alumno->segundo_nombre ?? '') . ' ' . ($alumno->tercer_nombre ?? '') }}</td>
                    <td class="text-center">{{ $alumno->fecha_nacimiento ? date('d/m/Y', strtotime($alumno->fecha_nacimiento)) : 'N/A' }}</td>
                    <td class="text-center">
                        @if($alumno->fecha_nacimiento)
                            {{ \Carbon\Carbon::parse($alumno->fecha_nacimiento)->age }} años
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="text-center">{{ $alumno->nombre_genero ?? 'N/A' }}</td>
                    <td class="text-center">{{ $alumno->nombre_discapacidad ?? 'No' }}</td>
                    <td>{{ $alumno->nombre_institucion ?? 'N/A' }}</td>
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

    <div class="footer">
        <p>Generado por: {{ Auth::user()->name ?? 'Sistema' }} - {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>