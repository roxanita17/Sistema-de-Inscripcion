<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte General del Estudiante</title>
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
            margin: 0 auto;
        }
        
        .institution-header {
            background-color: var(--color-primario);
            color: white;
            padding: 10px 15px;
            margin: 0 auto 15px auto;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(67, 97, 238, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border-bottom: 2px solid var(--color-acento);
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
            margin-bottom: 15px;
            padding: 12px 15px;
            border-bottom: 2px solid var(--color-primario);
            background: var(--color-primario-pastel);
            border-radius: 6px;
            box-shadow: 0 1px 4px rgba(67, 97, 238, 0.08);
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
            color: var(--color-secundario);
            margin: 4px 0;
            font-size: 12pt;
            font-weight: 600;
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
        
        h2 {
            color: var(--color-primario);
            font-size: 11pt;
            margin: 15px 0 8px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid var(--color-borde);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            position: relative;
        }
        
        h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 60px;
            height: 2px;
            background: var(--color-primario);
            border-radius: 2px;
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
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0 0 0;
            page-break-inside: avoid;
            background: white;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(67, 97, 238, 0.08);
        }
        
        th, td {
            padding: 6px 10px;
            text-align: left;
            border: 1px solid var(--color-borde);
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            line-height: 1.3;
            border-top: none;
            border-bottom: none;
            border-right: 1px solid var(--color-borde);
            border-left: 1px solid var(--color-borde);
        }
        
        th {
            background: linear-gradient(to bottom, var(--color-primario) 0%, var(--color-primario-suave) 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 9pt;
            letter-spacing: 0.5px;
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
            background-color: var(--color-acento-pastel);
        }
        
        .foto-perfil {
            width: 110px;
            height: 140px;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 2px 6px rgba(67, 97, 238, 0.15);
            margin-left: 20px;
            float: right;
            border-radius: 4px;
        }
        
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        
        .text-muted {
            color: var(--color-texto-suave);
            font-size: 9pt;
            font-family: 'Segoe UI', 'Roboto', sans-serif;
        }
        
        /* Estilo para filas específicas */
        td:first-child {
            font-weight: 600;
            color: var(--color-primario);
            width: 25%;
        }
        
        /* Estilo para el logo wrapper original */
        .logo-wrapper {
            display: flex;
            align-items: center;
        }
        
        /* Mejoras para impresión */
        @media print {
            .section {
                box-shadow: none;
            }
            
            .institution-header {
                box-shadow: none;
            }
            
            tr:hover {
                background-color: inherit;
            }
        }
    </style>
</head>
<body class="clearfix">

    <div class="container">
        <!-- Encabezado de la institución - Manteniendo estructura original -->
        <div class="institution-header">
            <img src="{{ public_path('img/Liceo_logo.png') }}" alt="Logo" class="institution-logo">
            <div class="institution-text">
                <h1>Liceo Nacional "Gral. Juan Guillermo Iribarren"</h1>
                <div class="institution-subtitle">Formando líderes para el futuro</div>
            </div>
        </div>

        <div class="header">
            <h1>FICHA DE REPORTES PARA ESTUDIANTE REGISTRADOS</h1>
            <h2>ESTUDIANTE {{ $alumno->persona->primer_nombre ?? 'N/A' }} {{ $alumno->persona->primer_apellido ?? 'N/A' }}</h2>
            <h3>CÉDULA: {{ $alumno->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $alumno->persona->numero_documento ?? 'N/A' }}</h3>
            <p>FECHA DE GENERACIÓN: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
        
        <h2>1.- DATOS PERSONALES</h2>
        <div class="section">
            <table class="form-table">
                <tr>
                    <td>Nombres</td>
                    <td>{{ $alumno->persona->primer_nombre ?? 'N/A' }}                        
                        {{ $alumno->persona->segundo_nombre ?? '' }}
                        {{ $alumno->persona->tercer_nombre ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td>Apellidos</td>
                    <td>{{ $alumno->persona->primer_apellido ?? 'N/A' }}                        
                        {{ $alumno->persona->segundo_apellido ?? '' }}
                    </td>
                </tr>
                <tr>
                    <td>Número de cédula</td>
                    <td>{{ $alumno->persona->tipoDocumento->nombre ?? 'N/A' }}-{{ $alumno->persona->numero_documento ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Fecha de nacimiento</td>
                    <td>{{ \Carbon\Carbon::parse($alumno->persona->fecha_nacimiento)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                     <td>Edad</td>
                    <td>{{ \Carbon\Carbon::parse($alumno->persona->fecha_nacimiento)->age }}</td>
                </tr>
                <tr>
                    <td>Género</td>
                    <td>{{ $alumno->persona->genero->genero ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
        
        <h2>2.- INFORMACIÓN DE SALUD</h2>
        <div class="section">
            <table class="form-table">
                <tr>
                    <td>Discapacidad</td>
                    <td>{{ $alumno->discapacidad ? 'Sí' : 'No' }}</td>
                </tr>
                <tr>
                    <td>Etnia</td>
                    <td>{{ $alumno->etnia->etnia ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Orden de nacimiento</td>
                    <td>{{ $alumno->ordenNacimiento->orden_nacimiento ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Lateralidad</td>
                    <td>{{ $alumno->lateralidad->lateralidad ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Peso</td>
                    <td>{{ $alumno->peso ?? 'N/A' }} kg</td>
                </tr>
                <tr>
                    <td>Estatura</td>
                    <td>{{ $alumno->estatura ?? 'N/A' }} m</td>
                </tr>
                <tr>
                    <td>Talla camisa</td>
                    <td>{{ $alumno->talla_camisa ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Talla pantalón</td>
                    <td>{{ $alumno->talla_pantalon ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Talla de zapatos</td>
                    <td>{{ $alumno->talla_zapato ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
    </div>  
        <div class="footer">
            <p>Generado por: {{ Auth::user()->name ?? 'Sistema' }} - {{ date('d/m/Y H:i:s') }}</p>
        </div>  
</body>
</html>