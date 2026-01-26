<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ficha del Docente - {{ $docente->numero_documento ?? 'N/A' }}</title>
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
                    <strong class="text-azul" style="font-size: 10px">FICHA INDIVIDUAL DEL DOCENTE</strong>
                </td>
            </tr>
        </table>

        <!-- DATOS PERSONALES -->
        <table width="100%" class="bloque">
            <colgroup>
                <col width="50%">
                <col width="50%">
            </colgroup>
            <tr>
                <td colspan="2" class="titulo">DATOS PERSONALES</td>
            </tr>
            <tr>
                <td class="campo" colspan="2">
                    <div class="valor label">
                        <b>NOMBRES:</b> {{ $docente->primer_nombre ?? 'N/A' }}
                        {{ $docente->segundo_nombre ?? '' }}
                        {{ $docente->tercer_nombre ?? '' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="campo" colspan="2">
                    <div class="valor label">
                        <b>APELLIDOS:</b> {{ $docente->primer_apellido ?? 'N/A' }}
                        {{ $docente->segundo_apellido ?? '' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="campo">
                    <div class="valor label">
                        <b>CÉDULA DE IDENTIDAD:</b> {{ $docente->tipo_documento ?? 'N/A' }}-{{ $docente->numero_documento ?? 'N/A' }}
                    </div>
                </td>
                <td class="campo">
                    <div class="valor label">
                        <b>FECHA DE NACIMIENTO:</b>
                        @if(isset($docente->fecha_nacimiento) && $docente->fecha_nacimiento !== 'N/A')
                            {{ \Carbon\Carbon::parse($docente->fecha_nacimiento)->format('d/m/Y') }}
                        @else
                            N/A
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <td class="campo">
                    <div class="valor label">
                        <b>EDAD:</b>
                        @if(isset($docente->fecha_nacimiento) && $docente->fecha_nacimiento !== 'N/A')
                            {{ \Carbon\Carbon::parse($docente->fecha_nacimiento)->age }} años
                        @else
                            N/A
                        @endif
                    </div>
                </td>
                <td class="campo">
                    <div class="valor label">
                        <b>GÉNERO:</b> {{ $docente->genero ?? 'N/A' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="campo">
                    <div class="valor label">
                        <b>CORREO ELECTRÓNICO:</b> {{ $docente->email ?? 'N/A' }}
                    </div>
                </td>
                <td class="campo">
                    <div class="valor label">
                        <b>TELÉFONO:</b> {{ $docente->telefono ?? 'N/A' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="campo" colspan="2">
                    <div class="valor label">
                        <b>DIRECCIÓN:</b> {{ $docente->direccion ?? 'N/A' }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="campo" colspan="2">
                    <div class="valor label">
                        <b>DEPENDENCIA:</b> {{ $docente->dependencia ?? 'N/A' }}
                    </div>
                </td>
            </tr>
        </table>

        <!-- ESTUDIOS REALIZADOS -->
        <table width="100%" class="bloque">
            <tr>
                <td class="titulo">ESTUDIOS REALIZADOS</td>
            </tr>
        </table>
        
        <table width="100%" class="bloque">
            <colgroup>
                <col width="5%">
                <col width="95%">
            </colgroup>
            <tr>
                <td class="campo text-center">
                    <div class="valor">#</div>
                </td>
                <td class="campo">
                    <div class="valor">ESTUDIO</div>
                </td>
            </tr>
            @if(isset($docente->detalleDocenteEstudio) && $docente->detalleDocenteEstudio->count() > 0)
                @foreach($docente->detalleDocenteEstudio as $key => $detalle)
                <tr>
                    <td class="campo text-center">
                        <div class="valor">{{ $key + 1 }}</div>
                    </td>
                    <td class="campo">
                        <div class="valor">{{ $detalle->estudiosRealizado->estudios ?? 'N/A' }}</div>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" class="campo text-center">
                        <div class="valor">No se encontraron registros de estudios</div>
                    </td>
                </tr>
            @endif
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