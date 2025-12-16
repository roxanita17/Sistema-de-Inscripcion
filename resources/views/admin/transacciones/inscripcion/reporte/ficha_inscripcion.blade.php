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
            margin-bottom: 20px;
            page-break-inside: avoid;
            background: white;
            padding: 15px 18px;
            border-radius: 8px;
            border: 1px solid var(--color-borde);
            box-shadow: 0 2px 6px rgba(67, 97, 238, 0.05);
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
            border: 1px solid var(--color-borde);
        }
        
        th, td {
            padding: 8px 12px;
            text-align: left;
            border: 1px solid var(--color-borde);
            font-family: 'Segoe UI', 'Roboto', sans-serif;
            line-height: 1.4;
            vertical-align: top;
        }
        
        td {
            word-wrap: break-word;
            overflow-wrap: break-word;
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
            transition: background-color 0.2s ease;
        }
        
        tr:last-child {
            border-bottom: none;
        }
        
        tr:nth-child(even) {
            background-color: rgba(67, 97, 238, 0.03);
        }
        
        tr:hover {
            background-color: rgba(76, 201, 240, 0.1);
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
            width: 30%;
            min-width: 180px;
            background-color: rgba(67, 97, 238, 0.03);
            border-right: 2px solid var(--color-borde);
        }
        
        /* Estilo para el logo wrapper original */
        .logo-wrapper {
            display: flex;
            align-items: center;
        }
        
        /* Mejoras para impresión */
        @media print {
            body {
                font-size: 9pt;
                line-height: 1.3;
            }
            
            .section {
                box-shadow: none;
                border: 1px solid #ddd;
                page-break-inside: avoid;
                margin-bottom: 15px;
            }
            
            table {
                page-break-inside: auto;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            
            .institution-header {
                box-shadow: none;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            tr:hover {
                background-color: inherit !important;
            }
        }
        
        .parent-section {
            margin-bottom: 25px;
            background: #f9faff;
            padding: 12px 15px;
            border-radius: 6px;
            border: 1px solid rgba(67, 97, 238, 0.1);
        }
        
        .parent-section h3 {
            color: var(--color-secundario);
            margin: 0 0 10px 0;
            padding-bottom: 6px;
            font-size: 11pt;
            font-weight: 600;
            border-bottom: 1px solid rgba(67, 97, 238, 0.2);
        }
        
        .parent-section table {
            margin: 5px 0 0 0;
            box-shadow: none;
            border: 1px solid rgba(67, 97, 238, 0.1);
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
                <h2>POTUGUESA-ARAURE</h2>
                <div class="institution-subtitle">Formando líderes para el futuro</div>
            </div>
        </div>

        <div class="header">
            <h1>FICHA DE INSCRIPCION AÑO ESCOLAR 
                @if($anioEscolarActivo)
                    {{ $anioEscolarActivo->inicio_anio_escolar->format('Y') }} - {{ $anioEscolarActivo->cierre_anio_escolar->format('Y') }}
                @else
                    {{ date('Y') }}-{{ date('Y') + 1 }}
                @endif
            </h1>
            <h2>ESTUDIANTE {{ $datosCompletos['persona_alumno']['primer_nombre'] ?? 'N/A' }} {{ $datosCompletos['persona_alumno']['primer_apellido'] ?? 'N/A' }}</h2>
            <h3>CÉDULA: {{ $datosCompletos['persona_alumno']['tipo_documento'] ?? 'N/A' }}-{{ $datosCompletos['persona_alumno']['numero_documento'] ?? 'N/A' }}</h3>
            <p>FECHA DE GENERACIÓN: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

        <div class="section">
            <h2>PLANTEL DE PROCEDENCIA</h2>
            <table>
                <tr>
                    <td><strong>Institución de Procedencia:</strong></td>
                    <td>{{ $datosCompletos['institucion_procedencia']['nombre'] ?? ($datosCompletos['institucion_procedencia']['nombre_institucion'] ?? 'N/A') }}</td>
                </tr>
                <tr>
                    <td><strong>Año de Egreso:</strong></td>
                    <td>{{ $datosCompletos['inscripcion']['anio_egreso'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Expresión Literaria:</strong></td>
                    <td>{{ $datosCompletos['expresion_literaria']['letra_expresion_literaria'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Número de Zonificado:</strong></td>
                    <td>{{ $datosCompletos['inscripcion']['numero_zonificacion'] ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
        <div class="section">
            <h2>DATOS DEL ESTUDIANTE</h2>
            <table class="student-info">
                <tr>
                    <td><strong>Nombres:</strong></td>
                    <td>{{ $datosCompletos['persona_alumno']['primer_nombre'] }} {{ $datosCompletos['persona_alumno']['segundo_nombre'] }} {{ $datosCompletos['persona_alumno']['tercer_nombre'] ?? '' }}</td>
                </tr>
                <tr>
                    <td><strong>Apellidos:</strong></td>
                    <td>{{ $datosCompletos['persona_alumno']['primer_apellido'] }} {{ $datosCompletos['persona_alumno']['segundo_apellido'] }}</td>
                </tr>
                <tr>
                    <td><strong>Cédula de Identidad:</strong></td>
                    <td>{{ $datosCompletos['persona_alumno']['tipo_documento_id'] == 1 ? 'V-' : 'E-' }}{{ $datosCompletos['persona_alumno']['numero_documento'] }}</td>
                </tr>
                <tr>
                    <td><strong>Fecha de Nacimiento:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($datosCompletos['persona_alumno']['fecha_nacimiento'])->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($datosCompletos['persona_alumno']['fecha_nacimiento'])->age }} años)</td>
                </tr>
                <tr>
                    <td><strong>Características Físicas:</strong></td>
                    <td>
                        <strong>Estatura:</strong> {{ $datosCompletos['alumno']['estatura'] ?? 'N/A' }} cm | 
                        <strong>Peso:</strong> {{ $datosCompletos['alumno']['peso'] ?? 'N/A' }} kg | 
                        <strong>Talla Camisa:</strong> {{ $datosCompletos['alumno']['talla_camisa'] ?? 'N/A' }} | 
                        <strong>Talla Pantalón:</strong> {{ $datosCompletos['alumno']['talla_pantalon'] ?? 'N/A' }} | 
                        <strong>Talla Zapato:</strong> {{ $datosCompletos['alumno']['talla_zapato'] ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Lateralidad:</strong></td>
                    <td>{{ $datosCompletos['datos_adicionales']['lateralidad']['lateralidad'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Orden de Nacimiento:</strong></td>
                    <td>{{ $datosCompletos['datos_adicionales']['orden_nacimiento']['orden_nacimiento'] ?? 'N/A' }}°</td>
                </tr>
                <tr>
                    <td><strong>Discapacidad:</strong></td>
                                        <td>{{ $datosCompletos['datos_adicionales']['discapacidad']['nombre'] ?? 'Ninguna registrada' }}</td>
                </tr>
                <tr>
                    <td><strong>Etnia Indígena:</strong></td>
                    <td>{{ $datosCompletos['datos_adicionales']['etnia_indigena']['nombre'] ?? 'No pertenece a ninguna etnia indígena' }}</td>
                </tr>
            </table>
        </div>
        <div class="section">
            <h2>DATOS DE LOS PROGENITORES</h2>
            
            <!-- Sección de la Madre -->
            <div class="parent-section">
                <h3>MADRE</h3>
                <table class="parent-info">
                    <tr>
                        <td><strong>Nombres y Apellidos:</strong></td>
                        <td>{{ $datosCompletos['persona_madre']['primer_nombre'] ?? 'N/A' }} 
                            {{ $datosCompletos['persona_madre']['segundo_nombre'] ?? '' }} 
                            {{ $datosCompletos['persona_madre']['primer_apellido'] ?? '' }} 
                            {{ $datosCompletos['persona_madre']['segundo_apellido'] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Cédula de Identidad:</strong></td>
                        <td>{{ $datosCompletos['persona_madre']['tipo_documento_id'] == 1 ? 'V-' : 'E-' }}{{ $datosCompletos['persona_madre']['numero_documento'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Fecha de Nacimiento:</strong></td>
                        <td>{{ isset($datosCompletos['persona_madre']['fecha_nacimiento']) ? \Carbon\Carbon::parse($datosCompletos['persona_madre']['fecha_nacimiento'])->format('d/m/Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Ocupación:</strong></td>
                        <td>{{ $datosCompletos['madre']['ocupacion_representante'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dirección:</strong></td>
                        <td>{{ $datosCompletos['persona_madre']['direccion'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Teléfono:</strong></td>
                        <td>{{ $datosCompletos['persona_madre']['telefono'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Correo Electrónico:</strong></td>
                        <td>{{ $datosCompletos['persona_madre']['email'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Conviven con el estudiante:</strong></td>
                        <td>{{ $datosCompletos['madre']['convivenciaestudiante_representante'] ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>

            <!-- Sección del Padre -->
            <div class="parent-section" style="margin-top: 20px;">
                <h3>PADRE</h3>
                <table class="parent-info">
                    <tr>
                        <td><strong>Nombres y Apellidos:</strong></td>
                        <td>{{ $datosCompletos['persona_padre']['primer_nombre'] ?? 'N/A' }} 
                            {{ $datosCompletos['persona_padre']['segundo_nombre'] ?? '' }} 
                            {{ $datosCompletos['persona_padre']['primer_apellido'] ?? '' }} 
                            {{ $datosCompletos['persona_padre']['segundo_apellido'] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Cédula de Identidad:</strong></td>
                        <td>{{ $datosCompletos['persona_padre']['tipo_documento_id'] == 1 ? 'V-' : 'E-' }}{{ $datosCompletos['persona_padre']['numero_documento'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Fecha de Nacimiento:</strong></td>
                        <td>{{ isset($datosCompletos['persona_padre']['fecha_nacimiento']) ? \Carbon\Carbon::parse($datosCompletos['persona_padre']['fecha_nacimiento'])->format('d/m/Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Ocupación:</strong></td>
                        <td>{{ $datosCompletos['padre']['ocupacion_representante'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dirección:</strong></td>
                        <td>{{ $datosCompletos['persona_padre']['direccion'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Teléfono:</strong></td>
                        <td>{{ $datosCompletos['persona_padre']['telefono'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Correo Electrónico:</strong></td>
                        <td>{{ $datosCompletos['persona_padre']['email'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Conviven con el estudiante:</strong></td>
                        <td>{{ $datosCompletos['padre']['convivenciaestudiante_representante'] ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Sección del Representante Legal -->
        <div class="section">
            <h2>REPRESENTANTE LEGAL</h2>
            <table class="representante-info">
                <tr>
                    <td><strong>Nombres y Apellidos:</strong></td>
                    <td>
                        @if(isset($datosCompletos['representante_legal']['representante']['persona']))
                            {{ $datosCompletos['representante_legal']['representante']['persona']['primer_nombre'] ?? 'N/A' }} 
                            {{ $datosCompletos['representante_legal']['representante']['persona']['segundo_nombre'] ?? '' }} 
                            {{ $datosCompletos['representante_legal']['representante']['persona']['primer_apellido'] ?? '' }} 
                            {{ $datosCompletos['representante_legal']['representante']['persona']['segundo_apellido'] ?? '' }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Cédula de Identidad:</strong></td>
                    <td>
                        @if(isset($datosCompletos['representante_legal']['representante']['persona']['tipo_documento_id']))
                            {{ $datosCompletos['representante_legal']['representante']['persona']['tipo_documento_id'] == 1 ? 'V-' : 'E-' }}
                        @endif
                        {{ $datosCompletos['representante_legal']['representante']['persona']['numero_documento'] ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Parentesco con el Estudiante:</strong></td>
                    <td>{{ $datosCompletos['representante_legal']['parentesco'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Fecha de Nacimiento:</strong></td>
                    <td>
                        @if(isset($datosCompletos['representante_legal']['representante']['persona']['fecha_nacimiento']))
                            {{ \Carbon\Carbon::parse($datosCompletos['representante_legal']['representante']['persona']['fecha_nacimiento'])->format('d/m/Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Ocupación:</strong></td>
                    <td>{{ $datosCompletos['representante_legal']['representante']['ocupacion_representante'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Dirección:</strong></td>
                    <td>{{ $datosCompletos['representante_legal']['direccion_representante'] ?? ($datosCompletos['representante_legal']['representante']['persona']['direccion'] ?? 'N/A') }}</td>
                </tr>
                <tr>
                    <td><strong>Teléfono:</strong></td>
                    <td>
                        @if(isset($datosCompletos['representante_legal']['representante']['persona']['prefijo_id']))
                            {{ $datosCompletos['representante_legal']['representante']['persona']['prefijo']['prefijo'] ?? '' }}
                        @endif
                        {{ $datosCompletos['representante_legal']['representante']['persona']['telefono'] ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Correo Electrónico:</strong></td>
                    <td>{{ $datosCompletos['representante_legal']['correo_representante'] ?? ($datosCompletos['representante_legal']['representante']['persona']['email'] ?? 'N/A') }}</td>
                </tr>
                <tr>
                    <td><strong>Convive con el Estudiante:</strong></td>
                    <td>{{ $datosCompletos['representante_legal']['representante']['convivenciaestudiante_representante'] == 1 ? 'Sí' : 'No' }}</td>
                </tr>
                <tr>
                    <td><strong>Carnet de la Patria:</strong></td>
                    <td>{{ $datosCompletos['representante_legal']['carnet_patria_afiliado'] == 1 ? 'Sí' : 'No' }}</td>
                </tr>
                <tr>
                    <td><strong>Serial del Carnet de la Patria:</strong></td>
                    <td>{{ $datosCompletos['representante_legal']['serial_carnet_patria_representante'] ?? 'N/A' }}</td>
                </tr>
                    <td><strong>Código del Carnet de la Patria:</strong></td>
                    <td>{{ $datosCompletos['representante_legal']['codigo_carnet_patria_representante'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Banco:</strong></td>
                    <td>{{ $datosCompletos['representante_legal']['banco']['nombre_banco'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Tipo de Cuenta:</strong></td>
                    <td>{{ $datosCompletos['representante_legal']['tipo_cuenta'] ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
                @if(isset($datosCompletos['representante_legal']['representante']['persona']))
                    {{ $datosCompletos['representante_legal']['representante']['persona']['primer_nombre'] ?? '' }} 
                    {{ $datosCompletos['representante_legal']['representante']['persona']['primer_apellido'] ?? '' }}
                @else
                    [NOMBRE DEL REPRESENTANTE]
                @endif
                , representante legal del estudiante, me comprometo a cumplir con las normas de convivencia del plantel y a mantener una comunicación constante con las autoridades educativas.</p>
            
        </div>


       
    </div>  
        <div class="footer">
            <p>Generado por: {{ Auth::user()->name ?? 'Sistema' }} - {{ date('d/m/Y H:i:s') }}</p>
        </div>  
</body>
</html>