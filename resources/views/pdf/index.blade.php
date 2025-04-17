<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        @page {
            size: A4;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            margin: 6cm 2cm 2.5cm 2cm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            word-wrap: break-word;
        }

        .page-break {
            page-break-after: always;
        }

        #header {
            position: fixed;
            top: -5.5cm;
            left: 0cm;
            right: 0cm;
            height: auto;
            /* Altura automática para adaptarse al contenido */
        }

        #footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: auto;
            /* Altura automática para adaptarse al contenido */
            text-align: center;
            /* Centrar la numeración de página */
        }

        #main {
            /* No necesitamos posicionamiento absoluto */
        }
    </style>
</head>

<body>
    <div id="header">
        <table style="font-family: 'Arial', sans-serif; color: #333;">
            @yield('header')
        </table>
    </div>

    <div id="footer">
        <table style="width: 100%; font-family: 'Arial', sans-serif; color: #333;">
            <tr>
                <td style="text-align: center;">
                    @yield('footer')
                </td>
            </tr>
        </table>
    </div>

    <table style="font-family: 'Arial', sans-serif; color: #333;">
        @yield('content')
    </table>

    @section('header')
        <tr>
            <td style="text-align: left;">
                <h1 style="margin: 0;">Reporte de Balances</h1>
                <p style="margin: 0;">Generado el {{ now()->format('d/m/Y') }}</p>
            </td>
        </tr>
    @endsection

    @section('content')
        <thead>
            <tr>
                <th style="border: 1px solid #ddd;">Tipo</th>
                <th style="border: 1px solid #ddd;">Método</th>
                <th style="border: 1px solid #ddd;">Monto</th>
                <th style="border: 1px solid #ddd;">Cuenta</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($balances as $balance)
                <tr>
                    <td style="border: 1px solid #ddd;">{{ $balance->type }}</td>
                    <td style="border: 1px solid #ddd;">{{ $balance->method }}</td>
                    <td style="border: 1px solid #ddd;">{{ number_format($balance->amount, 2) }}</td>
                    <td style="border: 1px solid #ddd;">{{ $balance->account->name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    @endsection

    @section('footer')
        <p style="margin: 0;">Página @{{ $page }}</p>
    @endsection
</body>

</html>
