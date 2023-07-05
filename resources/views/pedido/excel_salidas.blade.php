


<table>
    <thead>
        <tr>
            <th>NO</th>
            <th>Cliente Id</th>
            <th>Codigo Id</th> 
            <th>Fecha Entrada</th>
            <th>Fecha Salida</th>
            <th>Producto Id</th>
            <th>Precio Id</th>
            <th>Cantidad</th>
            <th>Dias</th>
            <th>Subtotal</th>
            <th>Costo Revision</th>
            <th>Total</th>
            <th>Factura</th>
            <th>Revisor</th>
            
          
            
        </tr>
    </thead>
    <tbody>
        @php
            $i = 0;
            $showTotal = false;
        @endphp
        @foreach ($pedidos as $pedido)
            @if ($pedido->salida === 'SI')
            @foreach ($pedido->productos as $index => $producto)
                <tr>
                    @if ($index === 0)
                        <td>{{ ++$i }}</td>
                        <td>{{ $pedido->cliente->name }}</td>
                        <td>{{ $pedido->cliente->codigo_cliente }}</td>
                        <td>{{ $pedido->fecha_entrada }}</td>
                        <td>{{ $pedido->fecha_salida }}</td>
                        <td>{{ $producto->name }}</td>
                        <td>{{ $producto->pivot->precio }}</td>   
                        <td>{{ $producto->pivot->cantidades }}</td>
                        <td>{{ $pedido->dias }}</td>
                        <td>={{ $producto->pivot->precio }} * {{ $producto->pivot->cantidades }} * {{ $pedido->dias }}</td>
                        <td rowspan="{{ count($pedido->productos) }}">{{$pedido->revision->total_revision}}</td>
                        <td rowspan="{{ count($pedido->productos) }}">{{ $pedido->total }}</td>
                        <td>{{ $pedido->factura }}</td>
                        <td rowspan="{{ count($pedido->productos) }}">{{$pedido->revision->revisor}}</td>
                                    
                        @php $showTotal = true; @endphp
                    @else
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $pedido->fecha_entrada }}</td>
                        <td>{{ $pedido->fecha_salida }}</td>
                        <td>{{ $producto->name }}</td>
                        <td>{{ $producto->pivot->precio }}</td>   
                        <td>{{ $producto->pivot->cantidades }}</td>
                        <td>{{ $pedido->dias }}</td>
                        <td>={{ $producto->pivot->precio }} * {{ $producto->pivot->cantidades }} * {{ $pedido->dias }}</td>
                        <td>{{ $pedido->factura }}</td>
                       
                    @endif
                </tr>
            @endforeach
            @php $showTotal = false; @endphp
              @endif
        @endforeach
      
    </tbody>
</table>


