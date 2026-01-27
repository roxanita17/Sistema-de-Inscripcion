<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de Docentes y areas de formacion</title>
    <style>
        @page {
            margin: 0.5cm 0.8cm;
            size: A4;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 9px;
            line-height: 1.1;
            margin: 0;
            padding: 0;
        }

        .pagina {
            width: 100%;
        }

        table {
            table-layout: fixed;
            border-collapse: collapse;
            width: 100%;
        }

        .cintillo {
            padding: 2px;
        }

        .cintillo-color {
            background-color: #1589e1;
        }

        /* ENCABEZADO */
        .encabezado td {
            padding: 3px;
            text-align: center;
            vertical-align: middle;
        }

        .titulo-principal {
            font-size: 11px;
            font-weight: bold;
            line-height: 1.2;
        }

        .text-azul {
            color: #1589e1;
            font-weight: bold;
        }

        .logo {
            font-size: 9px;
        }

        .foto {
            font-size: 8px;
        }

        /* BLOQUES */
        .bloque {
            margin-top: 10px;
            border-collapse: collapse;
            width: 100%;
        }

        .bloque td {
            padding: 1px 3px;
            vertical-align: top;
        }

        .titulo {
            font-size: 9px;
            background-color: #1589e1;
            color: #fff;
            padding: 2px 4px;
            font-weight: bold;
            margin: 0;
        }

        .subtitulo {
            font-size: 8px;
            background-color: #6ab2ea;
            color: #fff;
            padding: 2px 4px;
            font-weight: bold;
        }

        .campo {
            height: auto;
            min-height: 12px;
            vertical-align: top;
            padding: 1px 2px;
        }

        .label {
            font-size: 9px;
            letter-spacing: 0.1px;
            color: #333;
        }

        .valor {
            padding: 1px 2px;
            border-bottom: 1px solid #000;
            min-height: 10px;
        }

        /* FIRMAS */
        .firmas {
            margin-top: 20px;
        }

        .firmas td {
            padding-top: 25px;
            text-align: center;
            font-size: 8px;
            vertical-align: bottom;
        }

        /* PAGINACIÓN */
        .page-break {
            page-break-after: always;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .page-break {
                page-break-after: always;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
            }
        }

        /* Evitar superposiciones */
        .text-center {
            text-align: center;
        }

        /* Tabla con bordes para estudiantes */
        .tabla-bordes {
            border-collapse: collapse;
            width: 100%;
        }

        .tabla-bordes th,
        .tabla-bordes td {
            border: 1px solid #000;
            padding: 4px 6px;
            font-size: 9px;
            text-align: left;
            vertical-align: top;
        }

        .tabla-bordes th {
            background-color: #1589e1;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        .tabla-bordes td.text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="pagina">
        <!-- CINTILLO INSTITUCIONAL -->
        <table width="100%" class="cintillo cintillo-color encabezado">
            <tr style="color: #eee;">
                <td width="20%" class="">
                    <img src="{{ public_path('img/logo-ven.webp') }}" alt="Logo" width="90" height="30">
                </td>
                <td width="60%">
                    <strong class="titulo-principal" style="font-size: 14px">LICEO GRAL. JUAN GUILLERMO
                        IRIBARREN</strong><br>
                    PORTUGUESA - ARAURE<br>
                </td>
                <td width="20%" class="" style="font-size: 9px">
                    Ministerio del Poder Popular <br>
                    para la <b>Educacion</b>
                </td>
            </tr>
        </table>

        <!-- ENCABEZADO DEL DOCUMENTO -->
        <table width="100%" class="encabezado" style="margin-bottom: 25px">
            <tr>
                <td width="60%">
                    <strong class="text-azul" style="font-size: 10px">REPORTE DE DOCENTES CON AREAS DE FORMACION Y ESTUDIANTES</strong>
                </td>

            </tr>
        </table>

        <!-- CONTENIDO PRINCIPAL -->
        @forelse($docentesAgrupados as $docente)
            <!-- DATOS DEL DOCENTE -->
            <table width="100%" class="bloque">
                <colgroup>
                    <col width="50%">
                    <col width="50%">
                </colgroup>
                <tr>
                    <td colspan="2" class="titulo">DATOS DEL DOCENTE</td>
                </tr>
                <tr>
                    <td class="campo" colspan="2">
                        <div class="valor label">
                            <b>NOMBRE COMPLETO:</b> {{ $docente['primer_nombre'] }} {{ $docente['segundo_nombre'] }} {{ $docente['tercer_nombre'] }} {{ $docente['primer_apellido'] }} {{ $docente['segundo_apellido'] }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="campo">
                        <div class="valor label">
                            <b>CÉDULA DE IDENTIDAD:</b> {{ $docente['tipo_documento'] ?? 'N/A' }}-{{ $docente['numero_documento'] ?? 'N/A' }}
                        </div>
                    </td>
                </tr>
            </table>

            @foreach($docente['grados'] as $gradoKey => $gradoData)
                <div style="height: 10px;"></div>
                
                <!-- DATOS DEL GRADO CON MATERIAS Y ESTUDIANTES -->
                <table class="tabla-bordes">
                    <thead>
                        <tr>
                            <th colspan="4" style="background-color: #6ab2ea;">NIVEL: {{ $gradoData['grado'] }} - SECCIÓN: {{ $gradoData['seccion'] ?? 'N/A' }}</th>
                        </tr>
                        <tr>
                            <th colspan="4" style="background-color: #1589e1;">AREAS DE FORMACION ASIGNADAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($gradoData['materias']) > 0)
                            @foreach($gradoData['materias'] as $key => $materia)
                            <tr>
                                <td class="text-center" width="10%">{{ $key + 1 }}</td>
                                <td colspan="3">{{ $materia }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">No hay areas de formacion asignadas</td>
                            </tr>
                        @endif
                        <tr>
                            <th colspan="4" style="background-color: #1589e1;">ESTUDIANTES ASIGNADOS</th>
                        </tr>
                        <tr>
                            <th width="15%">CÉDULA</th>
                            <th width="45%">NOMBRE COMPLETO</th>
                            <th width="20%">NIVEL</th>
                            <th width="20%">SECCIÓN</th>
                        </tr>
                        @if(count($gradoData['estudiantes']) > 0)
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
                                <td class="text-center">{{ $gradoData['grado'] }}</td>
                                <td class="text-center">{{ $gradoData['seccion'] ?? 'N/A' }}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">No hay estudiantes asignados a este nivel academico</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                @if(!$loop->last)
                    <div style="height: 15px;"></div>
                @endif
            @endforeach

            @if(!$loop->last)
                <div class="page-break"></div>
            @endif
        @empty
            <table width="100%" class="bloque">
                <tr>
                    <td class="campo text-center" style="font-size: 11px;">
                        <div class="valor">No hay docentes con asignaciones registradas</div>
                    </td>
                </tr>
            </table>
        @endforelse

        <!-- RESUMEN -->
        <table width="100%" class="bloque">
            <colgroup>
                <col width="50%">
                <col width="50%">
            </colgroup>
            <tr>
                       <!-- FECHA DE GENERACIÓN -->
        <div style="margin-top: 30px; text-align: left; font-size: 9px; color: #666;">
            Generado el: {{ date('d/m/Y') }}
        </div>
                <td class="campo">
                    <div class="valor label">
                        <b>GENERADO POR:</b> {{ Auth::user()->name ?? 'Sistema' }}
                    </div>
                </td>
            </tr>
        </table>
    </div>
        
        <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_text(
                40,
                810,
                "Generado por: {{ Auth::user()->name ?? 'Sistema' }} - {{ date('d/m/Y H:i:s') }}",
                null,
                8,
                array(90, 90, 90)
            );

            $pdf->page_text(
                450,
                810,
                "Página {PAGE_NUM} de {PAGE_COUNT}",
                null,
                9,
                array(0, 0, 0)
            );
        }
        </script>
    </div>
</body>
</html>
