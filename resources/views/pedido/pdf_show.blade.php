<!DOCTYPE html>
<html>

<head>
    <title>Laravel 10 Generate PDF From View</title>
</head>

<body>

    <!-- Modal show -->
    <div style="text-align: center; border-bottom: 1px solid black; padding-bottom: 10px;">
        <h2 style="text-align: center;">RESUMEN ENTRADA # {{ $pedido->id }}</h2>
        <table style="margin: 0 auto; border-collapse: collapse;">
            <thead style="background: gray; color: white;">
            <tr>
                <th style="border: 1px solid black; padding: 5px; text-align: center;">CLIENTE</th>
                <th style="border: 1px solid black; padding: 5px; text-align: center;">CODIGO CLIENTE</th>
                <th style="border: 1px solid black; padding: 5px; text-align: center;">FECHA ENTRADA</th>
                <th style="border: 1px solid black; padding: 5px; text-align: center;">FACTURA</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="border: 1px solid black; padding: 5px; text-align: center;">{{ $pedido->cliente->name }}</td>
                <td style="border: 1px solid black; padding: 5px; text-align: center;">{{ $pedido->cliente->codigo_cliente }}</td>
                <td style="border: 1px solid black; padding: 5px; text-align: center;">{{ $pedido->fecha_entrada }}</td>
                <td style="border: 1px solid black; padding: 5px; text-align: center;">{{ $pedido->factura }}</td>
            </tr>
            </tbody>
        </table>

        <table style="margin: 0 auto; border-collapse: collapse; margin-top: 10px; margin-bottom: 5px;">
            <thead style="background: gray; color: white;">
            <tr>
                <th style="border: 1px solid black; padding: 5px; text-align: center;">NUM DE PRODUCTO</th>
                <th style="border: 1px solid black; padding: 5px; text-align: center;">NOMBRE</th>
                <th style="border: 1px solid black; padding: 5px; text-align: center;">CANTIDAD DE PIEZAS</th>
            </tr>
            </thead>
            <tbody>
            @php
            $i = -1;
            @endphp
            @foreach ($pedido->productos as $articulo)
                @php
                $i++;
                @endphp
                <tr>
                    <td style="border: 1px solid black; padding: 5px; text-align: center;">{{ $i+1 }}</td>
                    <td style="border: 1px solid black; padding: 5px; text-align: center;">{{ $pedido->productos->pluck('name')[$i] }}</td>
                    <td style="border: 1px solid black; padding: 5px; text-align: center;">{{ $pedido->productos[$i]['pivot']['cantidades']}} PIEZAS</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div style="text-align: center; margin-top: 10px;">
            <h2>TOTAL DE PIEZAS: {{ $pedido->cantidad }}</h2>
        </div>
        
   
    <div style="text-align: center">
   <img src="{{ $qrCodeData }}" alt="QR Code">
    </div>
</div>

    

</body>
</html>
