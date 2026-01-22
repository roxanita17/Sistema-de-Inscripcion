<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

        .section {
            margin-bottom: 20px;
            background: white;
            padding: 15px 18px;
            border-radius: 8px;
            border: 1px solid var(--color-borde);
            box-shadow: 0 2px 6px rgba(67, 97, 238, 0.05);
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
            border: 1px solid var(--color-borde);
        }

        th,
        td {
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
                <h1>Liceo General "Gral. Juan Guillermo Iribarren"</h1>
                <h2>POTUGUESA-ARAURE</h2>
                <div class="institution-subtitle">Formando líderes para el futuro</div>
            </div>
        </div>

        <div class="header">
            <h1>FICHA DE INSCRIPCION Calendario Escolar
                @if ($anioEscolarActivo)
                    {{ $anioEscolarActivo->inicio_anio_escolar->format('Y') }} -
                    {{ $anioEscolarActivo->cierre_anio_escolar->format('Y') }}
                @else
                    {{ date('Y') }}-{{ date('Y') + 1 }}
                @endif
            </h1>
            <h2>ESTUDIANTE {{ $datosCompletos['persona_alumno']['primer_nombre'] ?? 'N/A' }}
                {{ $datosCompletos['persona_alumno']['primer_apellido'] ?? 'N/A' }}</h2>
            <h3>CÉDULA:
                {{ $datosCompletos['persona_alumno']['tipo_documento_id'] == 1 ? 'V-' : 'E-' }}{{ $datosCompletos['persona_alumno']['numero_documento'] ?? 'N/A' }}
            </h3>
            <p>FECHA DE GENERACIÓN: {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

               <!-- DATOS ACADÉMICOS DE PROSECUCIÓN -->
        <div class="section">
            <h2>DATOS ACADÉMICOS DE PROSECUCIÓN</h2>
            <table>
                <tr>
                    <td><strong>Nivel academico cursado:</strong></td>
                    <td>{{ $datosCompletos['prosecucion']['grado_anterior'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Año de promoción:</strong></td>
                    <td>{{ $datosCompletos['prosecucion']['grado_actual'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Estado de promoción:</strong></td>
                    <td>
                        @if($datosCompletos['prosecucion']['repite_grado'] == 'Sí')
                            <span style="color: #e74c3c; font-weight: bold;">Repite Nivel academico</span>
                        @else
                            <span style="color: #27ae60; font-weight: bold;">Promovido</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Sección asignada:</strong></td>
                    <td>{{ $datosCompletos['prosecucion']['seccion'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td><strong>Calendario Escolar de referencia:</strong></td>
                    <td>
                        @if ($anioEscolarActivo)
                            {{ $anioEscolarActivo->inicio_anio_escolar->format('Y') }} -
                            {{ $anioEscolarActivo->cierre_anio_escolar->format('Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Aceptación de normas:</strong></td>
                    <td>
                        @if($datosCompletos['prosecucion']['acepta_normas_contrato'] == 'Sí')
                            <span style="color: #27ae60; font-weight: bold;">Sí</span>
                        @else
                            <span style="color: #e74c3c; font-weight: bold;">No</span>
                        @endif
                    </td>
                </tr>
                @if($datosCompletos['prosecucion']['observaciones'])
                    <tr>
                        <td><strong>Observaciones:</strong></td>
                        <td>{{ $datosCompletos['prosecucion']['observaciones'] }}</td>
                    </tr>
                @endif
            </table>
        </div>

        <!-- ESTADO DE MATERIAS POR ÁREA DE FORMACIÓN -->
        <div class="section">
            <h2>ESTADO DE MATERIAS POR ÁREA DE FORMACIÓN</h2>
            
            @if(isset($datosCompletos['prosecucion']['materias_aprobadas']) && $datosCompletos['prosecucion']['materias_aprobadas']->count() > 0)
                <div style="margin-bottom: 20px;">
                    <h3 style="color: #27ae60; border-bottom: 2px solid #27ae60; padding-bottom: 5px;">
                        <i class="fas fa-check-circle"></i> MATERIAS APROBADAS ({{ $datosCompletos['prosecucion']['materias_aprobadas']->count() }})
                    </h3>
                    <table>
                        <thead>
                            <tr style="background-color: #2c3e50; color: white;">
                                <th style="width: 10%;">#</th>
                                <th style="width: 60%;">Materia</th>
                                <th style="width: 20%;">Código</th>
                                <th style="width: 20%;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datosCompletos['prosecucion']['materias_aprobadas'] as $index => $materia)
                                <tr>
                                    <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                                    <td>{{ $materia->gradoAreaFormacion->area_formacion->nombre_area_formacion ?? 'N/A' }}</td>
                                    <td style="text-align: center;">{{ $materia->gradoAreaFormacion->codigo ?? 'N/A' }}</td>
                                    <td style="text-align: center;">
                                        <span style="background: #27ae60; color: white; padding: 4px 8px; border-radius: 4px; font-size: 9pt; font-weight: bold;">
                                            APROBADO
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if(isset($datosCompletos['prosecucion']['materias_pendientes']) && $datosCompletos['prosecucion']['materias_pendientes']->count() > 0)
                <div style="margin-bottom: 20px;">
                    <h3 style="color: #f39c12; border-bottom: 2px solid #f39c12; padding-bottom: 5px;">
                        <i class="fas fa-exclamation-triangle"></i> MATERIAS PENDIENTES ({{ $datosCompletos['prosecucion']['materias_pendientes']->count() }})
                    </h3>
                    <table>
                        <thead>
                            <tr style="background-color: #2c3e50; color: white;">
                                <th style="width: 10%;">#</th>
                                <th style="width: 60%;">Materia</th>
                                <th style="width: 20%;">Código</th>
                                <th style="width: 20%;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datosCompletos['prosecucion']['materias_pendientes'] as $index => $materia)
                                <tr>
                                    <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                                    <td>{{ $materia->gradoAreaFormacion->area_formacion->nombre_area_formacion ?? 'N/A' }}</td>
                                    <td style="text-align: center;">{{ $materia->gradoAreaFormacion->codigo ?? 'N/A' }}</td>
                                    <td style="text-align: center;">
                                        <span style="background: #f39c12; color: white; padding: 4px 8px; border-radius: 4px; font-size: 9pt; font-weight: bold;">
                                            PENDIENTE
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if(isset($datosCompletos['prosecucion']['materias_reprobadas']) && $datosCompletos['prosecucion']['materias_reprobadas']->count() > 0)
                <div style="margin-bottom: 20px;">
                    <h3 style="color: #e74c3c; border-bottom: 2px solid #e74c3c; padding-bottom: 5px;">
                        <i class="fas fa-times-circle"></i> MATERIAS REPROBADAS ({{ $datosCompletos['prosecucion']['materias_reprobadas']->count() }})
                    </h3>
                    <table>
                        <thead>
                            <tr style="background-color: #2c3e50; color: white;">
                                <th style="width: 10%;">#</th>
                                <th style="width: 60%;">Materia</th>
                                <th style="width: 20%;">Código</th>
                                <th style="width: 20%;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datosCompletos['prosecucion']['materias_reprobadas'] as $index => $materia)
                                <tr>
                                    <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                                    <td>{{ $materia->gradoAreaFormacion->area_formacion->nombre_area_formacion ?? 'N/A' }}</td>
                                    <td style="text-align: center;">{{ $materia->gradoAreaFormacion->codigo ?? 'N/A' }}</td>
                                    <td style="text-align: center;">
                                        <span style="background: #e74c3c; color: white; padding: 4px 8px; border-radius: 4px; font-size: 9pt; font-weight: bold;">
                                            REPROBADO
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if((!isset($datosCompletos['prosecucion']['materias_aprobadas']) || $datosCompletos['prosecucion']['materias_aprobadas']->count() == 0) && 
               (!isset($datosCompletos['prosecucion']['materias_pendientes']) || $datosCompletos['prosecucion']['materias_pendientes']->count() == 0) &&
               (!isset($datosCompletos['prosecucion']['materias_reprobadas']) || $datosCompletos['prosecucion']['materias_reprobadas']->count() == 0))
                <div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 5px; border: 1px solid #dee2e6;">
                    <p style="margin: 0; color: #6c757d; font-style: italic;">
                        <i class="fas fa-info-circle"></i> No hay información de materias registradas para esta inscripción de prosecución.
                    </p>
                </div>
            @endif
        </div>
        <div class="section">
            <h2>DATOS DEL ESTUDIANTE</h2>
            <table class="student-info">
                <tr>
                    <td><strong>Nombres:</strong></td>
                    <td>{{ $datosCompletos['persona_alumno']['primer_nombre'] }}
                        {{ $datosCompletos['persona_alumno']['segundo_nombre'] }}
                        {{ $datosCompletos['persona_alumno']['tercer_nombre'] ?? '' }}</td>
                </tr>
                <tr>
                    <td><strong>Apellidos:</strong></td>
                    <td>{{ $datosCompletos['persona_alumno']['primer_apellido'] }}
                        {{ $datosCompletos['persona_alumno']['segundo_apellido'] }}</td>
                </tr>
                <tr>
                    <td><strong>Cédula de Identidad:</strong></td>
                    <td>{{ $datosCompletos['persona_alumno']['tipo_documento_id'] == 1 ? 'V-' : 'E-' }}{{ $datosCompletos['persona_alumno']['numero_documento'] }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Fecha de Nacimiento:</strong></td>
                    <td>{{ \Carbon\Carbon::parse($datosCompletos['persona_alumno']['fecha_nacimiento'])->format('d/m/Y') }}
                        ({{ \Carbon\Carbon::parse($datosCompletos['persona_alumno']['fecha_nacimiento'])->age }} años)
                    </td>
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
                    <td>{{ $datosCompletos['datos_adicionales']['orden_nacimiento']['orden_nacimiento'] ?? 'N/A' }}°
                    </td>
                </tr>
                <tr>
                    <td><strong>Discapacidades:</strong></td>
                    <td>
                        @if (!empty($datosCompletos['datos_adicionales']['discapacidades']))
                            <ul style="margin:0; padding-left:15px;">
                                @foreach ($datosCompletos['datos_adicionales']['discapacidades'] as $discapacidad)
                                    <li>{{ $discapacidad['nombre_discapacidad'] }}</li>
                                @endforeach
                            </ul>
                        @else
                            Ninguna registrada
                        @endif
                    </td>
                </tr>

                <tr>
                    <td><strong>Etnia Indígena:</strong></td>
                    <td>{{ $datosCompletos['datos_adicionales']['etnia_indigena']['nombre'] ?? 'No pertenece a ninguna etnia indígena' }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="section">
            <h2>DATOS DE LOS PROGENITORES</h2>
            
            @if($datosCompletos['persona_madre'] || $datosCompletos['persona_padre'])
                <!-- Sección de la Madre -->
                @if($datosCompletos['persona_madre'])
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

                @endif

                <!-- Sección del Padre -->
                @if($datosCompletos['persona_padre'])
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
                                <td>{{ isset($datosCompletos['persona_padre']['tipo_documento_id']) ? ($datosCompletos['persona_padre']['tipo_documento_id'] == 1 ? 'V-' : 'E-') : '' }}{{ $datosCompletos['persona_padre']['numero_documento'] ?? 'N/A' }}</td>
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
                @endif
            @else
                <p style="text-align: center; font-style: italic; color: #666; margin: 20px 0;">
                    El estudiante no tiene información de progenitores registrada en el sistema.
                </p>
            @endif
        </div>



        <!-- Sección del Representante Legal -->
        <div class="section">
            <h2>REPRESENTANTE LEGAL</h2>
            <table class="representante-info">
                <tr>
                    <td><strong>Nombres y Apellidos:</strong></td>
                    <td>
                        @if (isset($datosCompletos['representante_legal']['representante']['persona']))
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
                        @if (isset($datosCompletos['representante_legal']['representante']['persona']['tipo_documento_id']))
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
                        @if (isset($datosCompletos['representante_legal']['representante']['persona']['fecha_nacimiento']))
                            {{ \Carbon\Carbon::parse($datosCompletos['representante_legal']['representante']['persona']['fecha_nacimiento'])->format('d/m/Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Ocupación:</strong></td>
                    <td>{{ $datosCompletos['representante_legal']['representante']['ocupacion_representante'] ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Dirección:</strong></td>
                    <td>{{ $datosCompletos['representante_legal']['direccion_representante'] ?? ($datosCompletos['representante_legal']['representante']['persona']['direccion'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Teléfono:</strong></td>
                    <td>
                        @if (isset($datosCompletos['representante_legal']['representante']['persona']['prefijo_id']))
                            {{ $datosCompletos['representante_legal']['representante']['persona']['prefijo']['prefijo'] ?? '' }}
                        @endif
                        {{ $datosCompletos['representante_legal']['representante']['persona']['telefono'] ?? 'N/A' }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Correo Electrónico:</strong></td>
                    <td>{{ $datosCompletos['representante_legal']['correo_representante'] ?? ($datosCompletos['representante_legal']['representante']['persona']['email'] ?? 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Convive con el Estudiante:</strong></td>
                    <td>{{ ($datosCompletos['representante_legal']['representante']['convivenciaestudiante_representante'] ?? null) == 1 ? 'Sí' : 'No' }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Carnet de la Patria:</strong></td>
                    <td>{{ ($datosCompletos['representante_legal']['carnet_patria_afiliado'] ?? null) == 1 ? 'Sí' : 'No' }}</td>
                </tr>
                <tr>
                    <td><strong>Serial del Carnet de la Patria:</strong></td>
                    <td>{{ $datosCompletos['representante_legal']['serial_carnet_patria_representante'] ?? 'N/A' }}
                    </td>
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
            <h2 class="text-center"
                style="background-color: var(--color-primario); color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                ACUERDOS DE CONVIVENCIA ESCOLAR
            </h2>
            <h3 class="text-center" style="color: var(--color-secundario); margin-bottom: 20px;">
                ASUMIDO POR EL REPRESENTANTE Y SU REPRESENTANDO DURANTE LA PERMANENCIA DEL ESTUDIANTE EN LA INSTITUCIÓN
            </h3>

            <div style="padding: 15px; margin-bottom: 20px;">
                <ol style="padding-left: 20px; margin: 0;">
                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Responsabilidad personal:</strong> El estudiante y representante deben asumir la
                        responsabilidad de su comportamiento, actuación y aprendizaje en el cumplimiento de las
                        actividades que le sean asignadas.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Puntualidad:</strong> Asistir puntualmente a las actividades académicas y de evaluación
                        de acuerdo al horario de clase (7:00 am a 12:45 pm).
                        <div
                            style="padding: 8px; margin-top: 8px; border-radius: 4px; font-size: 0.9em; background-color: #f8f9fa;">
                            <strong>Nota:</strong> Los días lunes, el Acto Cívico es obligatorio a las 7:00 am. La
                            inasistencia se considerará falta en el primer bloque.
                        </div>
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Justificación de inasistencias:</strong> Las ausencias deben ser justificadas por el
                        representante legal. En caso de reposos médicos, deben presentarse en original y dos copias
                        dentro de las 75 horas (3 días) hábiles siguientes.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Uniforme y presentación personal:</strong>
                        <ul style="margin-top: 8px; padding-left: 20px;">
                            <li>1° a 3° año: Camisa/chemise azul claro</li>
                            <li>4° y 5° año: Camisa/chemise beige (no franela)</li>
                            <li>Pantalón azul marino de gabardina clásico (no ajustado, no a la cadera)</li>
                            <li>Zapatos negros, azul oscuro, marrón oscuro o blanco (colegiales o deportivos, no tipo
                                botín)</li>
                            <li>Cinturón azul oscuro, negro o marrón</li>
                            <li>Uniforme de deporte: Mono azul marino con camisa blanca (solo los días de educación
                                física)</li>
                            <li>Cabello natural, sin accesorios inadecuados (aretes, piercings, etc.)</li>
                            <li>Sin maquillaje excesivo ni tintes de colores no naturales</li>
                        </ul>
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Respeto institucional:</strong> Mantener una actitud de respeto hacia todos los miembros
                        de la comunidad educativa (directivos, docentes, administrativos, obreros, personal PAE y
                        estudiantes), acatando las decisiones y orientaciones del personal directivo y docente.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Cuidado de instalaciones:</strong> Los estudiantes deben mantener en buen estado las
                        instalaciones, mobiliario y materiales. Los daños causados serán responsabilidad económica del
                        estudiante y su representante.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Prohibido recibir visitas:</strong> No se permiten visitas ajenas a la institución en
                        horario de clases.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Permanencia en aulas:</strong> No se permite la permanencia de estudiantes en las aulas
                        durante horas libres o sin supervisión docente.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Uso de celulares:</strong> Prohibido el uso de teléfonos celulares dentro y fuera de las
                        aulas, solo bajo autorización del personal docente o directivo.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Orden y disciplina:</strong> No interrumpir ni obstaculizar el desarrollo normal de las
                        actividades escolares. Prohibido participar en actos contrarios a la disciplina y al orden
                        público.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Objetos prohibidos:</strong> No se permite traer a la institución: radio reproductores,
                        juegos de azar, metras o trompos.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Procedimiento de quejas:</strong> Cualquier queja o reclamo debe presentarse por escrito
                        ante la Coordinación correspondiente.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Prohibición de sustancias:</strong> Se prohíbe fumar, ingerir bebidas alcohólicas,
                        sustancias estupefacientes o cualquier derivado del tabaco dentro o fuera de la institución.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Armas y objetos peligrosos:</strong> Está estrictamente prohibido portar armas blancas,
                        de fuego, municiones, detonantes, explosivos o fuegos artificiales.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Permanencia en puertas de aulas:</strong> No se permite la permanencia de representantes
                        o estudiantes en las puertas de las aulas durante horas de clase.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Estudiantes repitentes:</strong> Al estudiante que repita Calendario Escolar se le brindará una
                        segunda oportunidad con el compromiso y seguimiento del plantel y su representante legal.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Representación legal:</strong> El estudiante que no conviva con su representante
                        biológico deberá informarlo al momento de la inscripción y presentar la autorización
                        correspondiente.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Seguimiento académico:</strong> El representante legal debe vigilar el rendimiento
                        académico y la conducta de su representado, acudiendo al plantel al menos cada dos semanas.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Asistencia a asambleas:</strong> Es obligación de los padres y representantes asistir a
                        las Asambleas Generales, reuniones, citaciones y entrega de boletines.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Madres adolescentes:</strong> Se prohíbe a las madres adolescentes (estudiantes) traer a
                        sus hijos durante las actividades escolares.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Mascotas:</strong> Prohibido traer todo tipo de mascotas a la institución (perros,
                        gatos, loros, entre otros).
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px; border-bottom: 1px solid #eee;">
                        <strong>Aportes económicos:</strong> No está permitido que los docentes soliciten dinero a los
                        estudiantes sin autorización escrita del Director y conocimiento de los Padres y Representantes.
                    </li>

                    <li style="margin-bottom: 15px; padding: 10px;">
                        <strong>Vestimenta de representantes:</strong> LOS PADRES Y REPRESENTANTES DEBEN ASISTIR A LA
                        INSTITUCIÓN CON EL ATUENDO ADECUADO (prohibido escotes, franelillas, short, bermudas,
                        chancletas, pijamas, batas, vestidos cortos y claros, entre otros).
                    </li>
                </ol>

                <div style="padding: 15px; margin-top: 20px; border-top: 2px solid #eee;">
                    <p style="margin: 0; font-style: italic;">
                        <strong>Nota:</strong> El incumplimiento de estos acuerdos podrá acarrear sanciones
                        disciplinarias según lo establecido en el Reglamento Interno de la Institución.
                    </p>
                </div>
            </div>
        </div>

        <div class="section">
            <h2 class="text-center"
                style="background-color: var(--color-primario-pastel); padding: 10px; border-radius: 5px; color: var(--color-primario);">
                ACUERDOS DE CONVIVENCIA ESCOLAR
            </h2>

            <div
                style="margin: 15px 0; padding: 15px; border: 1px solid var(--color-borde); border-radius: 5px; background-color: #f9f9f9;">
                <p style="text-align: justify; margin-bottom: 15px; line-height: 1.6;">
                    <strong>Ley Orgánica para la Protección del Niño, Niña y Adolescentes Art. 54 (LOPNA):</strong><br>
                    <em>Obligaciones de los padres, madre y representantes responsables en materia de educación.</em>
                </p>

                <p style="text-align: justify; margin-bottom: 15px; line-height: 1.6;">
                    Los padres, representantes o responsables, tienen la obligación inmediata de garantizar la educación
                    de los niños, niñas y adolescentes.
                    En consecuencia deben inscribirlos oportunamente en una escuela, plantel o instituto de educación,
                    de conformidad con la ley,
                    así como exigirles su asistencia regular a clases y participar activamente en el proceso educativo.
                </p>

                <div
                    style="background-color: white; padding: 15px; border: 1px solid #e0e0e0; border-radius: 5px; margin: 15px 0;">
                    <p style="text-align: justify; line-height: 1.6; margin: 0;">
                        Yo <strong>
                            @if (isset($datosCompletos['representante_legal']['representante']['persona']))
                                {{ $datosCompletos['representante_legal']['representante']['persona']['primer_nombre'] ?? 'N/A' }}
                                {{ $datosCompletos['representante_legal']['representante']['persona']['segundo_nombre'] ?? '' }}
                                {{ $datosCompletos['representante_legal']['representante']['persona']['primer_apellido'] ?? '' }}
                                {{ $datosCompletos['representante_legal']['representante']['persona']['segundo_apellido'] ?? '' }}
                            @else
                                N/A
                            @endif
                        </strong>,
                        con cédula de identidad
                        <strong>
                            @if (isset($datosCompletos['representante_legal']['representante']['persona']['tipo_documento_id']))
                                {{ $datosCompletos['representante_legal']['representante']['persona']['tipo_documento_id'] == 1 ? 'V-' : 'E-' }}
                            @endif
                            {{ $datosCompletos['representante_legal']['representante']['persona']['numero_documento'] ?? 'N/A' }}
                        </strong>,
                        en mi carácter de representante legal, hago constar que me comprometo a cumplir y hacer cumplir
                        por mi representado(a)
                        <strong>
                            {{ $datosCompletos['persona_alumno']['primer_nombre'] }}
                            {{ $datosCompletos['persona_alumno']['segundo_nombre'] }}
                            {{ $datosCompletos['persona_alumno']['tercer_nombre'] ?? '' }}
                            {{ $datosCompletos['persona_alumno']['primer_apellido'] }}
                            {{ $datosCompletos['persona_alumno']['segundo_apellido'] }}
                        </strong>,
                        portador de la cédula de identidad
                        <strong>
                            {{ $datosCompletos['persona_alumno']['tipo_documento_id'] == 1 ? 'V-' : 'E-' }}{{ $datosCompletos['persona_alumno']['numero_documento'] }}
                        </strong>,
                        los deberes y obligaciones que nos imponen las leyes y reglamentos vigentes, así como las
                        establecidas por la institución educativa.
                    </p>
                </div>

                <p style="text-align: justify; margin-top: 15px; font-style: italic; color: #555;">
                    <strong>Nota:</strong> Me comprometo a notificar cualquier cambio de domicilio durante el transcurso
                    del Calendario Escolar. La Dirección del plantel no se hace responsable por los perjuicios ocasionados a mi
                    representado(a) por el incumplimiento de esta disposición.
                </p>
            </div>
        </div>

       
    </div>  
        <div class="footer">
            <p>Generado por: {{ Auth::user()->name ?? 'Sistema' }} - {{ date('d/m/Y H:i:s') }}</p>
            <script type="text/php">
                if (isset($pdf)) {
                    $pdf->page_text(40, 570, "Generado por: {{ Auth::user()->name ?? 'Sistema' }} - {{ date('d/m/Y H:i:s') }}", null, 8, array(90, 90, 90));
                    $pdf->page_text(400, 570, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
                }
            </script>
        </div>  
</body>

</html>
