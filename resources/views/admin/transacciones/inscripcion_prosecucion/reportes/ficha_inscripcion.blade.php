<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Ficha de Inscripción - Prosecución</title>

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

        /* TABLA DE MATERIAS PENDIENTES */
        .tabla-materias {
            margin-top: 10px;
            border: 1px solid #000;
        }

        .tabla-materias th {
            background-color: #6ab2ea;
            color: #fff;
            padding: 4px;
            font-size: 9px;
            border: 1px solid #000;
        }

        .tabla-materias td {
            padding: 3px;
            border: 1px solid #000;
            font-size: 9px;
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

        .text-center {
            text-align: center;
        }
    </style>

</head>

<body>
    @php
        // Obtener todas las prosecuciones del estudiante ordenadas por año escolar
        $alumnoId = $datosCompletos['inscripcion']['alumno_id'] ?? null;

        if ($alumnoId) {
            $todasProsecuciones = \App\Models\InscripcionProsecucion::with([
                'inscripcion.alumno.persona',
                'inscripcion.representanteLegal.representante.persona.tipoDocumento',
                'inscripcion.representanteLegal.representante.persona.prefijo',
                'inscripcion.padre.persona.tipoDocumento',
                'inscripcion.madre.persona.tipoDocumento',
                'grado',
                'seccion',
                'anioEscolar',
                'prosecucionAreas.gradoAreaFormacion.area_formacion',
            ])
                ->whereHas('inscripcion', function ($q) use ($alumnoId) {
                    $q->where('alumno_id', $alumnoId);
                })
                ->orderBy('anio_escolar_id', 'desc')
                ->get();
        } else {
            $todasProsecuciones = collect([]);
        }

        // Si no hay prosecuciones, crear estructura básica con datos disponibles
        if ($todasProsecuciones->isEmpty() && isset($datosCompletos['inscripcion'])) {
            $prosecucionActual = new stdClass();
            $prosecucionActual->anioEscolar = (object)$datosCompletos['anio_escolar'];
            $prosecucionActual->inscripcion = (object)$datosCompletos['inscripcion'];
            $prosecucionActual->grado = (object)['numero_grado' => $datosCompletos['prosecucion']['grado_actual'] ?? 'N/A'];
            $prosecucionActual->seccion = (object)['nombre' => $datosCompletos['prosecucion']['seccion'] ?? 'N/A'];
            $prosecucionActual->repite_grado = ($datosCompletos['prosecucion']['repite_grado'] ?? 'No') == 'Sí';
            $prosecucionActual->observaciones = $datosCompletos['prosecucion']['observaciones'] ?? '';
            $prosecucionActual->created_at = $datosCompletos['inscripcion']['created_at'] ?? now();
            
            // Convertir materias pendientes
            $materiasPendientesCollection = collect();
            if (!empty($datosCompletos['prosecucion']['materias_pendientes'])) {
                foreach ($datosCompletos['prosecucion']['materias_pendientes'] as $materia) {
                    $materiaPendiente = new stdClass();
                    $materiaPendiente->status = 'pendiente';
                    $materiaPendiente->gradoAreaFormacion = (object)[
                        'area_formacion' => (object)[
                            'nombre_area_formacion' => $materia['nombre'] ?? 'N/A'
                        ],
                        'codigo' => $materia['codigo'] ?? 'N/A'
                    ];
                    $materiasPendientesCollection->push($materiaPendiente);
                }
            }
            $prosecucionActual->prosecucionAreas = $materiasPendientesCollection;
            
            $todasProsecuciones = collect([$prosecucionActual]);
        }
    @endphp

    @foreach ($todasProsecuciones as $index => $prosecucion)
        @php
            $anioEscolarProsecucion = $prosecucion->anioEscolar;
            $materiasPendientes = $prosecucion->prosecucionAreas->where('status', 'pendiente');
            $inscripcionProsecucion = $prosecucion->inscripcion;
            $representanteLegal = $inscripcionProsecucion->representanteLegal ?? null;
        @endphp

        <div class="pagina">

            <table width="100%" class="cintillo cintillo-color encabezado">
                <tr style="color: #eee;">
                    <td width="20%">
                        <img src="{{ public_path('img/logo-ven.webp') }}" alt="Logo" width="90" height="30">
                    </td>
                    <td width="60%">
                        <strong class="titulo-principal" style="font-size: 14px">LICEO GRAL. JUAN GUILLERMO
                            IRIBARREN</strong><br>
                        PORTUGUESA - ARAURE<br>
                    </td>
                    <td width="20%" style="font-size: 9px">
                        Ministerio del Poder Popular <br>
                        para la <b>Educación</b>
                    </td>
                </tr>
            </table>

            <!-- ENCABEZADO -->
            <table width="100%" class="encabezado" style="margin-bottom: 5px">
                <tr>
                    <td width="60%">
                        <strong class="titulo-principal" style="font-size: 10px">FICHA POR PROSECUCIÓN O CONTINUIDAD DE ESTUDIOS - AÑO ESCOLAR:
                            @if($anioEscolarProsecucion)
                                {{ \Carbon\Carbon::parse($anioEscolarProsecucion->inicio_anio_escolar)->format('Y') }}
                                -
                                {{ \Carbon\Carbon::parse($anioEscolarProsecucion->cierre_anio_escolar)->format('Y') }}
                            @else
                                N/A
                            @endif
                        </strong>
                    </td>
                </tr>
            </table>

            {{-- DATOS ACADÉMICOS DE PROSECUCIÓN --}}
            <table width="100%" class="bloque">
                <colgroup>
                    <col width="25%">
                    <col width="25%">
                    <col width="25%">
                    <col width="25%">
                </colgroup>

                <tr>
                    <td colspan="4" class="titulo">DATOS DE PROSECUCIÓN</td>
                </tr>

                <tr>
                    <td class="campo">
                        <div class="valor label"><b>NIVEL (AÑO) ANTERIOR: </b>
                            {{ $datosCompletos['prosecucion']['grado_anterior'] ?? 'N/A' }}
                        </div>
                    </td>
                    <td class="campo">
                        <div class="valor label"><b>NIVEL (AÑO) ACTUAL: </b>
                            {{ $prosecucion->grado->numero_grado ?? 'N/A' }}
                        </div>
                    </td>
                    <td class="campo">
                        <div class="valor label"><b>SECCIÓN: </b>
                            {{ $prosecucion->seccion->nombre ?? 'N/A' }}
                        </div>
                    </td>
                    <td class="campo">
                        <div class="valor label"><b>¿REPITE?: </b>
                            {{ $prosecucion->repite_grado ? 'Sí' : 'No' }}
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="campo" colspan="4">
                        <div class="valor label"><b>FECHA DE INSCRIPCIÓN: </b>
                            {{ \Carbon\Carbon::parse($prosecucion->created_at)->format('d/m/Y') }}
                        </div>
                    </td>
                </tr>

                @if ($materiasPendientes->count() > 0)
                    <tr>
                        <td class="campo" colspan="4">
                            <div class="valor label"><b>ÁREAS DE FORMACIÓN PENDIENTES: </b>
                                @foreach ($materiasPendientes as $materia)
                                    {{ $materia->gradoAreaFormacion->area_formacion->nombre_area_formacion ?? 'N/A' }}@if (!$loop->last), @endif
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @endif
            </table>



            {{-- DATOS DEL ESTUDIANTE --}}
            <table width="100%" class="bloque">
                <colgroup>
                    <col width="16.66%">
                    <col width="16.66%">
                    <col width="16.66%">
                    <col width="16.66%">
                    <col width="16.66%">
                    <col width="16.66%">
                </colgroup>

                <tr>
                    <td colspan="6" class="titulo">DATOS DEL O LA ESTUDIANTE</td>
                </tr>

                <tr>
                    <td class="campo" colspan="2">
                        <div class="valor label">
                            <b>NOMBRES:</b> {{ $datosCompletos['persona_alumno']['primer_nombre'] }}
                            {{ $datosCompletos['persona_alumno']['segundo_nombre'] }}
                            {{ $datosCompletos['persona_alumno']['tercer_nombre'] ?? '' }}
                        </div>
                    </td>
                    <td class="campo" colspan="2">
                        <div class="valor label">
                            <b>APELLIDOS:</b>
                            {{ $datosCompletos['persona_alumno']['primer_apellido'] }}
                            {{ $datosCompletos['persona_alumno']['segundo_apellido'] }}
                        </div>
                    </td>
                    <td class="campo" colspan="2">
                        <div class="valor label">
                            <b>CÉDULA DE IDENTIDAD:</b>
                            {{ match ($datosCompletos['persona_alumno']['tipo_documento_id'] ?? null) {
                                1 => 'V',
                                2 => 'E',
                                3 => 'CE',
                                default => '',
                            } }}
                            -{{ $datosCompletos['persona_alumno']['numero_documento'] }}
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="campo" colspan="2">
                        <div class="valor label"><b>ESTATURA:
                            </b>{{ $datosCompletos['alumno']['estatura'] ?? 'N/A' }} cm
                        </div>
                    </td>
                    <td class="campo" colspan="2">
                        <div class="valor label"><b>PESO:
                            </b>{{ $datosCompletos['alumno']['peso'] ?? 'N/A' }} kg
                        </div>
                    </td>
                    <td class="campo" colspan="2">
                        <div class="valor label"><b>TALLA DE ZAPATO:</b>
                            {{ $datosCompletos['alumno']['talla_zapato'] ?? 'N/A' }}
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="campo" colspan="2">
                        <div class="valor label"><b>TALLA DE CAMISA: </b>
                            {{ $datosCompletos['alumno']['talla_camisa'] ?? 'N/A' }}</div>
                    </td>
                    <td class="campo" colspan="2">
                        <div class="valor label"><b>TALLA DE PANTALÓN:</b>
                            {{ $datosCompletos['alumno']['talla_pantalon'] ?? 'N/A' }}</div>
                    </td>
                    <td class="campo" colspan="2">
                        <div class="valor label"><b>PRESENTA DISCAPACIDAD:</b>
                            @if (!empty($datosCompletos['datos_adicionales']['discapacidades']))
                                SI
                            @else
                                NO
                            @endif
                        </div>
                    </td>
                </tr>
            </table>

            {{-- DATOS DEL REPRESENTANTE LEGAL --}}
            <table width="100%" class="bloque">
                <colgroup>
                    <col width="50%">
                    <col width="25%">
                    <col width="25%">
                </colgroup>

                <tr>
                    <td colspan="3" class="titulo">DATOS DEL REPRESENTANTE LEGAL</td>
                </tr>

                <tr>
                    <td class="campo">
                        <div class="valor label">
                            <b>NOMBRES Y APELLIDOS:</b>
                            @if ($datosCompletos['persona_representante'] ?? null)
                                {{ $datosCompletos['persona_representante']['primer_nombre'] ?? '' }}
                                {{ $datosCompletos['persona_representante']['segundo_nombre'] ?? '' }}
                                {{ $datosCompletos['persona_representante']['primer_apellido'] ?? '' }}
                                {{ $datosCompletos['persona_representante']['segundo_apellido'] ?? '' }}
                            @else
                                N/A
                            @endif
                        </div>
                    </td>
                    <td class="campo">
                        <div class="valor label">
                            <b>CÉDULA:</b>
                            @if ($datosCompletos['persona_representante'] ?? null)
                                {{ match ($datosCompletos['persona_representante']['tipo_documento_id'] ?? null) {
                                    1 => 'V',
                                    2 => 'E',
                                    3 => 'CE',
                                    default => '',
                                } }}
                                -{{ $datosCompletos['persona_representante']['numero_documento'] ?? '' }}
                            @else
                                N/A
                            @endif
                        </div>
                    </td>
                    <td class="campo">
                        <div class="valor label">
                            <b>PARENTESCO:</b>
                            {{ $datosCompletos['representante_legal']['parentesco'] ?? 'N/A' }}
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="campo">
                        <div class="valor label">
                            <b>TELÉFONO:</b>
                            @if ($datosCompletos['persona_representante'] ?? null)
                                {{ $datosCompletos['persona_representante']['prefijo']['prefijo'] ?? '' }}
                                {{ $datosCompletos['persona_representante']['telefono'] ?? 'N/A' }}
                            @else
                                N/A
                            @endif
                        </div>
                    </td>
                    <td class="campo" colspan="2">
                        <div class="valor label">
                            <b>OCUPACIÓN:</b>
                            {{ $datosCompletos['persona_representante']['ocupacion']['nombre_ocupacion'] ?? 'N/A' }}
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="campo" colspan="3">
                        <div class="valor label">
                            <b>DIRECCIÓN:</b>
                            @if ($datosCompletos['persona_representante']['direccion'] ?? null)
                                {{ $datosCompletos['persona_representante']['direccion']['localidad']['nombre_localidad'] ?? '' }}@if($datosCompletos['persona_representante']['direccion']['municipio']['nombre_municipio'] ?? null), {{ $datosCompletos['persona_representante']['direccion']['municipio']['nombre_municipio'] }}@endif@if($datosCompletos['persona_representante']['direccion']['estado']['nombre_estado'] ?? null), {{ $datosCompletos['persona_representante']['direccion']['estado']['nombre_estado'] }}@endif
                            @else
                                N/A
                            @endif
                        </div>
                    </td>
                </tr>
            </table>

            {{-- OBSERVACIONES --}}
            @if ($prosecucion->observaciones ?? null)
                <table width="100%" class="bloque">
                    <tr>
                        <td class="titulo">OBSERVACIONES</td>
                    </tr>
                    <tr>
                        <td class="campo" style="min-height: 40px;">
                            <div class="label">
                                {{ $prosecucion->observaciones }}
                            </div>
                        </td>
                    </tr>
                </table>
            @endif

            {{-- FIRMAS --}}
            <table width="100%" class="firmas">
                <tr>
                    <td width="50%">
                        _________________________________<br>
                        <b>Firma del Representante Legal</b>
                    </td>
                    <td width="50%">
                        _________________________________<br>
                        <b>Firma del Docente a Cargo</b>
                    </td>
                </tr>
            </table>

        </div>

        @if(!$loop->last)
            <div class="page-break"></div>
        @endif

    @endforeach

    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_text(40, 570, "Generado por: {{ Auth::user()->name ?? 'Sistema' }} - {{ date('d/m/Y H:i:s') }}", null, 8, array(90, 90, 90));
            $pdf->page_text(700, 570, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 8, array(0, 0, 0));
        }
    </script>

</body>

</html>