<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <title>Ficha de Inscripción</title>

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

        /* ESTILOS PARA ACUERDOS DE CONVIVENCIA */
        h4 {
            margin: 3px 0 5px 0;
            padding: 3px 5px;
            font-size: 9px;
            font-weight: bold;
            background-color: #1589e1;
            color: #fff;
            text-align: center;
        }

        ol {
            margin: 0;
            padding-left: 18px;
            list-style-position: outside;
        }

        ol li {
            margin-bottom: 4px;
            line-height: 1.2;
            font-size: 7.5px;
        }

        ul {
            margin: 2px 0;
            padding-left: 15px;
            list-style-type: disc;
        }

        ul li {
            margin-bottom: 1px;
            line-height: 1.15;
            font-size: 7px;
        }

        p {
            margin: 4px 0;
            line-height: 1.2;
            text-align: justify;
            font-size: 8px;
        }

        strong {
            font-weight: bold;
        }

        em {
            font-style: italic;
        }

        div {
            margin: 0;
            padding: 0;
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
    </style>

</head>

<body>

    <div class="pagina">

        <table width="100%" class="cintillo cintillo-color">
            <tr>
                <td width="20%" class="">
                    <img src="{{ public_path('img/logo-ven.webp') }}" alt="Logo" width="90" height="30">
                </td>
                <td width="60%">

                </td>
                <td width="20%" class="" style="color: #eee; font-size: 9px">
                    Ministerio del Poder Popular <br>
                    para la <b>Educacion</b>
                </td>
            </tr>
        </table>
        <!-- ENCABEZADO -->
        <table width="100%" class="encabezado">
            <tr>
                <td width="20%" class="logo">
                    FOTO <br>REPRESENTANTE
                </td>
                <td width="60%">
                    <strong class="text-azul titulo-principal" style="font-size: 14px">LICEO GRAL. JUAN GUILLERMO
                        IRIBARREN</strong><br>
                    PORTUGUESA - ARAURE<br>
                    <strong class="text-azul">FECHA DE INSCRIPCION AÑO ESCOLAR:
                        {{ \Carbon\Carbon::parse($datosCompletos['anio_escolar']['inicio_anio_escolar'])->format('Y') }}
                        -
                        {{ \Carbon\Carbon::parse($datosCompletos['anio_escolar']['cierre_anio_escolar'])->format('Y') }}
                    </strong>
                </td>
                <td width="20%" class="foto">
                    FOTO<br>ESTUDIANTE
                </td>
            </tr>
        </table>
        {{-- PLANTEL DE PROCEDENCIA --}}
        <table width="100%" class="bloque">
            <colgroup>


                <col width="50%">


                <col width="25%">


                <col width="25%">


            </colgroup>

            <tr>
                <td colspan="3" class="titulo">PLANTEL DE PROCEDENCIA</td>
            </tr>

            <tr>
                <td class="campo">
                    <div class="valor label"><b>NUMERO DE ZONIFICADO: </b>
                        {{ $datosCompletos['nuevo_ingreso']['numero_zonificacion'] ?? 'N/A' }}
                    </div>
                </td>
                <td class="campo" colspan="2">
                    <div class="valor label"><b>INSTITUCIÓN DE PROCEDENCIA:
                        </b>{{ $datosCompletos['nuevo_ingreso']['institucion_procedencia']['nombre_institucion'] ?? 'N/A' }}</div>
                </td>
            </tr>

            <tr>
                <td class="campo">
                    <div class="valor label"><b>AÑO DE EGRESO:
                        </b>{{ $datosCompletos['nuevo_ingreso']['anio_egreso'] ?? 'N/A' }}
                    </div>
                </td>
                <td class="campo">
                    <div class="valor label"><b>EXPRESIÓN LITERARIA:

                        </b>{{ $datosCompletos['expresion_literaria']['letra_expresion_literaria'] ?? 'N/A' }}</div>
                </td>
            </tr>
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
                @php
                    use Carbon\Carbon;

                    $fechaNacimiento = Carbon::parse($datosCompletos['persona_alumno']['fecha_nacimiento']);
                    $hoy = Carbon::now();

                    $anios = (int) $fechaNacimiento->diffInYears($hoy);
                    $meses = (int) $fechaNacimiento->copy()->addYears($anios)->diffInMonths($hoy);
                @endphp

                <td class="campo" colspan="2">
                    <div class="valor label">
                        <b>FECHA DE NACIMIENTO:</b>
                        {{ $fechaNacimiento->format('d/m/Y') }}
                    </div>
                </td>

                <td class="campo" colspan="1">
                    <div class="valor label">
                        <b>EDAD (AÑOS):</b> {{ str_pad($anios, 2, '0', STR_PAD_LEFT) }}
                    </div>
                </td>

                <td class="campo" colspan="1">
                    <div class="valor label">
                        <b>EDAD (MESES):</b> {{ str_pad($meses, 2, '0', STR_PAD_LEFT) }}
                    </div>
                </td>

                <td class="campo" colspan="2">
                    <div class="valor label"><b>GENERO: </b>{{ $datosCompletos['persona_alumno']['genero'] ?? 'N/A' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="campo" colspan="2">
                    <div class="valor label"><b>LATERALIDAD: 
                        </b>{{ $datosCompletos['datos_adicionales']['lateralidad']['lateralidad'] ?? 'N/A' }}</div>
                </td>
                <td class="campo" colspan="2">
                    <div class="valor label"><b>ORDEN DE
                            NACIMIENTO:  </b>{{ $datosCompletos['datos_adicionales']['orden_nacimiento']['orden_nacimiento'] ?? 'N/A' }}
                    </div>
                </td>
                <td class="campo" colspan="1">
                    <div class="valor label"><b>ESTATURA:
                        </b>{{ $datosCompletos['alumno']['estatura'] ?? 'N/A' }}
                    </div>
                </td>
                <td class="campo" colspan="1">
                    <div class="valor label"><b>PESO:
                        </b>{{ $datosCompletos['alumno']['peso'] ?? 'N/A' }}</div>
                </td>
            </tr>
            <tr>
                <td class="campo" colspan="2">
                    <div class="valor label"><b>LUGAR DE NACIMIENTO:

                        </b>{{ $datosCompletos['persona_alumno']['localidad']['nombre_localidad'] ?? 'N/A' }}</div>
                </td>
                <td class="campo" colspan="2">
                    <div class="valor label"><b>MUNICIPIO:

                        </b>{{ $datosCompletos['persona_alumno']['localidad']['municipio']['nombre_municipio'] ?? 'N/A' }}
                    </div>
                </td>
                <td class="campo" colspan="2">
                    <div class="valor label"><b>ESTADO:

                        </b>{{ $datosCompletos['persona_alumno']['localidad']['estadoThroughMunicipio']['nombre_estado'] ?? 'N/A' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="campo" colspan="2">
                    <div class="valor label"><b>PERTENECE A PUEBLO INDÍGENA (SI /
                            NO):</b>
                        @if ($datosCompletos['alumno']['etnia_indigena_id'] ?? null)
                            SI
                        @else
                            NO
                        @endif
                    </div>
                </td>
                <td class="campo" colspan="4">
                    <div class="valor label"><b>¿CUÁL?:

                        </b>{{ $datosCompletos['datos_adicionales']['etnia_indigena']['nombre'] ?? 'N/A' }}</div>
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
                    <div class="valor label"><b>TALLA DE ZAPATO:</b>
                        {{ $datosCompletos['alumno']['talla_zapato'] ?? 'N/A' }}</div>
                </td>
            </tr>
            <tr>
                <td class="campo" colspan="2">
                    <div class="valor label"><b>PRESENTA ALGUNA DISCAPACIDAD (SI /
                            NO):</b>
                        @if ($datosCompletos['alumno']['discapacidades'] ?? null)
                            SI
                        @else
                            NO
                        @endif
                    </div>
                </td>
                <td class="campo" colspan="4">
                    <div class="valor label"><b>¿CUÁL?:</b>
                        @if (!empty($datosCompletos['datos_adicionales']['discapacidades']))
                            @foreach ($datosCompletos['datos_adicionales']['discapacidades'] as $discapacidad)
                                {{ $discapacidad['nombre_discapacidad'] }}
                            @endforeach
                        @else
                            Ninguna registrada
                        @endif
                    </div>
                </td>
            </tr>

        </table>

        <table width="100%" class="bloque">
            <tr>
                <td colspan="4" class="titulo">DATOS DE LOS PROGENITORES</td>
            </tr>
        </table>

        </table>
        {{-- DATOS DE LA MADRE --}}
        <table width="100%" class="bloque">
            <colgroup>


                <col width="25%">


                <col width="25%">


                <col width="25%">


                <col width="25%">


            </colgroup>
            <tr>
                <td colspan="4" class="subtitulo">-- MADRE:</td>
            </tr>
            <tr>
                <td class="campo" colspan="3">
                    <div class="valor">
                        <span class="label">NOMBRES Y APELLIDOS:

                            {{ $datosCompletos['persona_madre']['primer_nombre'] ?? 'N/A' }}

                            {{ $datosCompletos['persona_madre']['segundo_nombre'] ?? '' }}

                            {{ $datosCompletos['persona_madre']['primer_apellido'] ?? '' }}

                            {{ $datosCompletos['persona_madre']['segundo_apellido'] ?? '' }}</span>
                    </div>
                </td>

                <td class="campo" colspan="3">
                    <div class="valor">
                        <span class="label">CEDULA:
                            {{ match ($datosCompletos['persona_madre']['tipo_documento_id'] ?? null) {
                                1 => 'V',
                                2 => 'E',
                                default => '',
                            } }}
                            -{{ $datosCompletos['persona_madre']['numero_documento'] }}</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="campo" colspan="2">
                    <div class="valor">
                        <span class="label">
                            LUGAR DE NACIMIENTO:
                            {{ $datosCompletos['persona_madre']['direccion']['localidad']['nombre_localidad'] ?? 'N/A' }}
                        </span>
                    </div>
                </td>

                <td class="campo">
                    <div class="valor">
                        <span class="label">
                            MUNICIPIO:
                            {{ $datosCompletos['persona_madre']['direccion']['municipio']['nombre_municipio'] ?? 'N/A' }}
                        </span>
                    </div>
                </td>

                <td class="campo">
                    <div class="valor">
                        <span class="label">
                            ESTADO:
                            {{ $datosCompletos['persona_madre']['direccion']['estado']['nombre_estado'] ?? 'N/A' }}
                        </span>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="campo" colspan="1">
                    <div class="valor">
                        <span class="label">TELEFONO:
                            {{ $datosCompletos['persona_madre']['prefijo']['prefijo'] ?? 'N/A' }}-
                            {{ $datosCompletos['persona_madre']['telefono'] ?? 'N/A' }}</span>
                    </div>
                </td>
                <td class="campo" colspan="1">
                    <div class="valor">
                        <span class="label">OCUPACION:
                            {{ $datosCompletos['persona_madre']['ocupacion']['nombre_ocupacion'] ?? 'N/A' }}</span>
                    </div>
                </td>
                <td class="campo" colspan="2">
                    <div class="valor">
                        <span class="label">
                            CONVIVENCIA CON EL ESTUDIANTE(SI/NO):
                            {{ $datosCompletos['madre']['convivenciaestudiante_representante'] ?? 0 ? 'SI' : 'NO' }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>

        {{-- DATOS DEL PADRE --}}
        <table width="100%" class="bloque">
            <colgroup>


                <col width="25%">


                <col width="25%">


                <col width="25%">


                <col width="25%">


            </colgroup>
            <tr>
                <td colspan="4" class="subtitulo">-- PADRE:</td>
            </tr>
            <tr>
                <td class="campo" colspan="3">
                    <div class="valor">
                        <span class="label">NOMBRES Y APELLIDOS:

                            {{ $datosCompletos['persona_padre']['primer_nombre'] ?? 'N/A' }}

                            {{ $datosCompletos['persona_padre']['segundo_nombre'] ?? '' }}

                            {{ $datosCompletos['persona_padre']['primer_apellido'] ?? '' }}

                            {{ $datosCompletos['persona_padre']['segundo_apellido'] ?? '' }}</span>
                    </div>
                </td>

                <td class="campo" colspan="3">
                    <div class="valor">
                        <span class="label">CEDULA:
                            {{ match ($datosCompletos['persona_padre']['tipo_documento_id'] ?? null) {
                                1 => 'V',
                                2 => 'E',
                                default => '',
                            } }}
                            -{{ $datosCompletos['persona_padre']['numero_documento'] }}</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="campo" colspan="2">
                    <div class="valor">
                        <span class="label">
                            LUGAR DE NACIMIENTO:
                            {{ $datosCompletos['persona_padre']['direccion']['localidad']['nombre_localidad'] ?? 'N/A' }}
                        </span>
                    </div>
                </td>

                <td class="campo">
                    <div class="valor">
                        <span class="label">
                            MUNICIPIO:
                            {{ $datosCompletos['persona_padre']['direccion']['municipio']['nombre_municipio'] ?? 'N/A' }}
                        </span>
                    </div>
                </td>

                <td class="campo">
                    <div class="valor">
                        <span class="label">
                            ESTADO:
                            {{ $datosCompletos['persona_padre']['direccion']['estado']['nombre_estado'] ?? 'N/A' }}
                        </span>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="campo" colspan="1">
                    <div class="valor">
                        <span class="label">TELEFONO:
                            {{ $datosCompletos['persona_padre']['prefijo']['prefijo'] ?? 'N/A' }}-
                            {{ $datosCompletos['persona_padre']['telefono'] ?? 'N/A' }}</span>
                    </div>
                </td>
                <td class="campo" colspan="1">
                    <div class="valor">
                        <span class="label">OCUPACION:
                            {{ $datosCompletos['persona_padre']['ocupacion']['nombre_ocupacion'] ?? 'N/A' }}</span>
                    </div>
                </td>
                <td class="campo" colspan="2">
                    <div class="valor">
                        <span class="label">
                            CONVIVENCIA CON EL ESTUDIANTE(SI/NO):
                            {{ $datosCompletos['padre']['convivenciaestudiante_representante'] ?? 0 ? 'SI' : 'NO' }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>
        {{-- DATOS DEL REPRESENTANTE LEGAL --}}
        <table width="100%" class="bloque">
            <colgroup>


                <col width="25%">


                <col width="25%">


                <col width="25%">


                <col width="25%">


            </colgroup>
            <tr>
                <td colspan="4" class="titulo">DATOS DEL REPRESENTANTE LEGAL:</td>
            </tr>
            <tr>
                <td class="campo" colspan="3">
                    <div class="valor">
                        <span class="label">NOMBRES Y APELLIDOS:
                            {{ $datosCompletos['persona_representante']['primer_nombre'] ?? 'N/A' }}
                            {{ $datosCompletos['persona_representante']['segundo_nombre'] ?? '' }}
                            {{ $datosCompletos['persona_representante']['tercer_nombre'] ?? '' }}
                            {{ $datosCompletos['persona_representante']['primer_apellido'] ?? '' }}
                            {{ $datosCompletos['persona_representante']['segundo_apellido'] ?? '' }}
                        </span>
                    </div>
                </td>

                <td class="campo" colspan="3">
                    <div class="valor">
                        <span class="label">CEDULA:
                            {{ match ($datosCompletos['persona_representante']['tipo_documento_id'] ?? null) {
                                1 => 'V',
                                2 => 'E',
                                default => '',
                            } }}
                            -{{ $datosCompletos['persona_representante']['numero_documento'] }}
                        </span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="campo" colspan="2">
                    <div class="valor">
                        <span class="label">LUGAR DE NACIMIENTO:
                            {{ $datosCompletos['persona_representante']['direccion']['localidad']['nombre_localidad'] ?? 'N/A' }}
                        </span>
                    </div>
                </td>
                <td class="campo" colspan="1">
                    <div class="valor">
                        <span class="label">MUNICIPIO:
                            {{ $datosCompletos['persona_representante']['direccion']['municipio']['nombre_municipio'] ?? 'N/A' }}
                        </span>
                    </div>
                </td>
                <td class="campo" colspan="1">
                    <div class="valor">
                        <span class="label">ESTADO:
                            {{ $datosCompletos['persona_representante']['direccion']['estado']['nombre_estado'] ?? 'N/A' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="campo" colspan="1">
                    <div class="valor">
                        <span class="label">TELEFONO:
                            {{ $datosCompletos['persona_representante']['prefijo']['prefijo'] ?? 'N/A' }}-
                            {{ $datosCompletos['persona_representante']['telefono'] ?? 'N/A' }}</span>
                        </span>
                    </div>
                </td>
                <td class="campo" colspan="1">
                    <div class="valor">
                        <span class="label">OCUPACION:
                            {{ $datosCompletos['persona_representante']['ocupacion']['nombre_ocupacion'] ?? 'N/A' }}
                        </span>
                    </div>
                </td>
                <td class="campo" colspan="2">
                    <div class="valor">
                        <span class="label">CORREO ELECTRONICO:

                        </span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="campo" colspan="2">
                    <div class="valor">
                        <span class="label">PERTENECE ALGUNA ORGANIZACION POLITICA O
                            COMUNITARIA (SI / NO):
                            {{ $datosCompletos['representante_legal']['pertenece_a_organizacion_representante'] ?? 0 ? 'SI' : 'NO' }}

                        </span>
                    </div>
                </td>
                <td class="campo" colspan="2">
                    <div class="valor">
                        <span class="label">¿CUAL?:
                            {{ $datosCompletos['representante_legal']['cual_organizacion_representante'] ?? 'N/A' }}
                        </span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="campo" colspan="2">
                    <div class="valor">
                        <span class="label">CONVIVE CON EL ESTUDIANTE(SI / NO):
                            {{ $datosCompletos['persona_representante']['convivenciaestudiante_representante'] ?? 0 ? 'SI' : 'NO' }}
                        </span>
                    </div>
                </td>
                <td class="campo" colspan="2">
                    <div class="valor">
                        <span class="label">PARENTESCO:
                            {{ $datosCompletos['representante_legal']['parentesco'] ?? 'N/A' }}
                        </span>
                    </div>
                </td>
                
            </tr>
            <tr>
                <td class="campo" colspan="4">
                    <div class="valor">
                        <span class="label"><b class="text-azul">DIRECCION</b>:
                            {{ $datosCompletos['representante_legal']['direccion_representante'] ?? 'N/A' }}</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="text-azul campo" colspan="1">
                    CARNET DE LA PATRIA:
                </td>
                <td class="campo" colspan="1">
                    <div class="valor">
                        <span class="label">QUIEN LO TIENE AFILIADO:
                            @if ($datosCompletos['representante_legal']['carnet_patria_afiliado'] ?? 'N/A' == 1)
                                MADRE
                            @elseif ($datosCompletos['representante_legal']['carnet_patria_afiliado'] ?? 'N/A' == 2)
                                PADRE
                            @elseif ($datosCompletos['representante_legal']['carnet_patria_afiliado'] ?? 'N/A' == 3)
                                OTRO
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                </td>
                <td class="campo" colspan="1">
                    <div class="valor">
                        <span class="label">SERIAL:
                            {{ $datosCompletos['representante_legal']['serial_carnet_patria_representante'] ?? 'N/A' }}</span>
                    </div>
                </td>
                <td class="campo" colspan="1">
                    <div class="valor">
                        <span class="label">CODIGO:
                            {{ $datosCompletos['representante_legal']['codigo_carnet_patria_representante'] ?? 'N/A' }}</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="campo" colspan="2">
                    <div class="valor">
                        <span class="label">TIPO DE CUENTA:
                            @if ($datosCompletos['representante_legal']['tipo_cuenta'] ?? 'N/A' == 'Corriente')
                                Corriente
                            @elseif ($datosCompletos['representante_legal']['tipo_cuenta'] ?? 'N/A' == 'Ahorro')
                                Ahorro
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                </td>
                <td class="campo" colspan="2">
                    <div class="valor">
                        <span class="label">BANCO:
                            {{ $datosCompletos['representante_legal']['banco']['nombre_banco'] ?? 'N/A' }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>

        <table width="100%" class="bloque">
            <tr>
                <td class="campo">
                    <h4 class="text-center">
                        ACUERDOS DE CONVIVENCIA ESCOLAR ASUMIDO POR EL REPRESENTANTE Y SU REPRESENTANDO DURANTE LA
                        PERMANENCIA
                        DEL ESTUDIANTE EN LA
                        INSTITUCIÓN
                    </h4>
                    <div class="campo">
                        <ol>
                            <li>
                                <strong>Responsabilidad personal:</strong> El estudiante y representante
                                deben asumir la
                                responsabilidad de su comportamiento, actuación y aprendizaje en el
                                cumplimiento de las
                                actividades que le sean asignadas.
                            </li>
                            <li>
                                <strong>Puntualidad:</strong> Asistir puntualmente a las actividades
                                académicas y de evaluación
                                de acuerdo al horario de clase (7:00 am a 12:45 pm).
                                <div>
                                    <strong>Nota:</strong> Los días lunes, el Acto Cívico es obligatorio
                                    a las 7:00 am. La
                                    inasistencia se considerará falta en el primer bloque.
                                </div>
                            </li>
                            <li>
                                <strong>Justificación de inasistencias:</strong> Las ausencias deben ser
                                justificadas por el
                                representante legal. En caso de reposos médicos, deben presentarse en
                                original y dos copias
                                dentro de las 75 horas (3 días) hábiles siguientes.
                            </li>
                            <li>
                                <strong>Uniforme y presentación personal:</strong>
                                <ul style="margin-top: 8px; padding-left: 20px;">
                                    <li>1° a 3° año: Camisa/chemise azul claro</li>
                                    <li>4° y 5° año: Camisa/chemise beige (no franela)</li>
                                    <li>Pantalón azul marino de gabardina clásico (no ajustado, no a la
                                        cadera)</li>
                                    <li>Zapatos negros, azul oscuro, marrón oscuro o blanco (colegiales
                                        o deportivos, no tipo
                                        botín)</li>
                                    <li>Cinturón azul oscuro, negro o marrón</li>
                                    <li>Uniforme de deporte: Mono azul marino con camisa blanca (solo
                                        los días de educación
                                        física)</li>
                                    <li>Cabello natural, sin accesorios inadecuados (aretes, piercings,
                                        etc.)</li>
                                    <li>Sin maquillaje excesivo ni tintes de colores no naturales</li>
                                </ul>
                            </li>
                            <li>
                                <strong>Respeto institucional:</strong> Mantener una actitud de respeto
                                hacia todos los miembros
                                de la comunidad educativa (directivos, docentes, administrativos, obreros,
                                personal PAE y
                                estudiantes), acatando las decisiones y orientaciones del personal directivo
                                y docente.
                            </li>

                            <li>
                                <strong>Cuidado de instalaciones:</strong> Los estudiantes deben mantener en
                                buen estado las
                                instalaciones, mobiliario y materiales. Los daños causados serán
                                responsabilidad económica del
                                estudiante y su representante.
                            </li>

                            <li>
                                <strong>Prohibido recibir visitas:</strong> No se permiten visitas ajenas a
                                la institución en
                                horario de clases.
                            </li>

                            <li>
                                <strong>Permanencia en aulas:</strong> No se permite la permanencia de
                                estudiantes en las aulas
                                durante horas libres o sin supervisión docente.
                            </li>

                            <li>
                                <strong>Uso de celulares:</strong> Prohibido el uso de teléfonos celulares
                                dentro y fuera de las
                                aulas, solo bajo autorización del personal docente o directivo.
                            </li>

                            <li>
                                <strong>Orden y disciplina:</strong> No interrumpir ni obstaculizar el
                                desarrollo normal de las
                                actividades escolares. Prohibido participar en actos contrarios a la
                                disciplina y al orden
                                público.
                            </li>

                            <li>
                                <strong>Objetos prohibidos:</strong> No se permite traer a la institución:
                                radio reproductores,
                                juegos de azar, metras o trompos.
                            </li>

                            <li>
                                <strong>Procedimiento de quejas:</strong> Cualquier queja o reclamo debe
                                presentarse por escrito
                                ante la Coordinación correspondiente.
                            </li>

                            <li>
                                <strong>Prohibición de sustancias:</strong> Se prohíbe fumar, ingerir
                                bebidas alcohólicas,
                                sustancias estupefacientes o cualquier derivado del tabaco dentro o fuera de
                                la institución.
                            </li>

                            <li>
                                <strong>Armas y objetos peligrosos:</strong> Está estrictamente prohibido
                                portar armas blancas,
                                de fuego, municiones, detonantes, explosivos o fuegos artificiales.
                            </li>

                            <li>
                                <strong>Permanencia en puertas de aulas:</strong> No se permite la
                                permanencia de representantes
                                o estudiantes en las puertas de las aulas durante horas de clase.
                            </li>

                            <li>
                                <strong>Estudiantes repitentes:</strong> Al estudiante que repita Calendario
                                Escolar se le brindará una
                                segunda oportunidad con el compromiso y seguimiento del plantel y su
                                representante legal.
                            </li>

                            <li>
                                <strong>Representación legal:</strong> El estudiante que no conviva con su
                                representante
                                biológico deberá informarlo al momento de la inscripción y presentar la
                                autorización
                                correspondiente.
                            </li>

                            <li>
                                <strong>Seguimiento académico:</strong> El representante legal debe vigilar
                                el rendimiento
                                académico y la conducta de su representado, acudiendo al plantel al menos
                                cada dos semanas.
                            </li>

                            <li>
                                <strong>Asistencia a asambleas:</strong> Es obligación de los padres y
                                representantes asistir a
                                las Asambleas Generales, reuniones, citaciones y entrega de boletines.
                            </li>

                            <li>
                                <strong>Madres adolescentes:</strong> Se prohíbe a las madres adolescentes
                                (estudiantes) traer a
                                sus hijos durante las actividades escolares.
                            </li>

                            <li>
                                <strong>Mascotas:</strong> Prohibido traer todo tipo de mascotas a la
                                institución (perros,
                                gatos, loros, entre otros).
                            </li>

                            <li>
                                <strong>Aportes económicos:</strong> No está permitido que los docentes
                                soliciten dinero a los
                                estudiantes sin autorización escrita del Director y conocimiento de los
                                Padres y Representantes.
                            </li>

                            <li>
                                <strong>Vestimenta de representantes:</strong> LOS PADRES Y REPRESENTANTES
                                DEBEN ASISTIR A LA
                                INSTITUCIÓN CON EL ATUENDO ADECUADO (prohibido escotes, franelillas, short,
                                bermudas,
                                chancletas, pijamas, batas, vestidos cortos y claros, entre otros).
                            </li>
                        </ol>

                        <div>
                            <p style=" font-style: italic;">
                                <strong>Nota:</strong> El incumplimiento de estos acuerdos podrá acarrear
                                sanciones
                                disciplinarias según lo establecido en el Reglamento Interno de la
                                Institución.
                            </p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <table width="100%" class="bloque">
            <tr>
                <td class="campo">
                    <h4>
                        ACUERDOS DE CONVIVENCIA ESCOLAR
                    </h4>

                    <div>
                        <p>
                            <strong>Ley Orgánica para la Protección del Niño, Niña y Adolescentes Art. 54
                                (LOPNA):</strong><br>
                            <em>Obligaciones de los padres, madre y representantes responsables en materia de
                                educación.</em>
                        </p>

                        <p>
                            Los padres, representantes o responsables, tienen la obligación inmediata de
                            garantizar la educación
                            de los niños, niñas y adolescentes.
                            En consecuencia deben inscribirlos oportunamente en una escuela, plantel o instituto
                            de educación,
                            de conformidad con la ley,
                            así como exigirles su asistencia regular a clases y participar activamente en el
                            proceso educativo.
                        </p>

                        <div>
                            <p>
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
                                en mi carácter de representante legal, hago constar que me comprometo a
                                cumplir y hacer cumplir
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
                                los deberes y obligaciones que nos imponen las leyes y reglamentos vigentes,
                                así como las
                                establecidas por la institución educativa.
                            </p>
                        </div>

                        <p>
                            <strong>Nota:</strong> Me comprometo a notificar cualquier cambio de domicilio
                            durante el transcurso
                            del Calendario Escolar. La Dirección del plantel no se hace responsable por los
                            perjuicios ocasionados a mi
                            representado(a) por el incumplimiento de esta disposición.
                        </p>
                    </div>

                </td>
            </tr>
        </table>

        {{-- FIRMAS --}}
        <table width="100%" class="firmas">
            <tr class="text-azul">
                <td>Fecha de Inscripcion: _________________________</td>
                <td>Docente Responsable: _________________________</td>
                <td>Firma: _________________________</td>

            </tr>
            <tr class="text-azul">
                <td>_________________________<br>Firma del Representante</td>
                <td>_________________________<br>Firma del Estudiante</td>
                <td>_________________________<br>Director</td>
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

</body>


</html>
