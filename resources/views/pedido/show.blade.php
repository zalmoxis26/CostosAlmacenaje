@extends('layouts.app')

@section('template_title')
    {{ $pedido->name ?? "{{ __('Show') Pedido" }}
@endsection

@section('content')


   <div class="container-fluid fs-5">

          <div class="row">
            <div class="col-md-9 mx-auto my-4">
              <table class="table">
              <h1 class="text-center mb-5">RESUMEN DE LA SALIDA # {{ $pedido->id }}</h1>
                <thead class="thead-dark">
                  <tr>
                    <th class="text-center">NOMBRE DE CLIENTE</th>
                    <th class="text-center">CODIGO DE CLIENTE</th>
                    <th class="text-center">REVISOR</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">{{ $pedido->cliente->name }}</td>
                    <td class="text-center">{{ $pedido->cliente->codigo_cliente }}</td>
                     <td class="text-center">{{ $pedido->revision->revisor }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

         
          <div class="row">
            <div class="col-md-9 mx-auto my-4">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th class="text-center">FACTURA</th>
                    <th class="text-center">FECHA ENTRADA</th>
                    <th class="text-center">FECHA SALIDA</th>
                    <th class="text-center">DIAS ALMACENAJE</th>
                    
                  </tr>
                </thead>
                <tbody>
                  <tr>
                  <td class="text-center">{{ $pedido->factura }}</td>
                    <td class="text-center">{{ $pedido->fecha_entrada }}</td>
                    <td class="text-center">{{ $pedido->fecha_salida}}</td>
                    <td class="text-center">{{ $pedido->dias}}</td>
                    
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="row">
            <div class="col-md-9 mx-auto my-4">
              <table class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">NOMBRE</th>
                    <th class="text-center">CANTIDAD DE PIEZAS</th>
                     <th class="text-center">PRECIO UNITARIO</th>
                     <th class="text-center">DIAS</th>
                      <th class="text-center">IMPORTE</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $i = -1;
                  $dias= $pedido->dias;
                  @endphp
                  @foreach ($pedido->productos as $articulo)
                  @php
                  $i++;
                  $cantidad = $pedido->productos[$i]['pivot']['cantidades']; 
                  $precio= $pedido->productos[$i]['pivot']['precio'];
                  $importe = $cantidad * $precio * $dias;
                  @endphp
                  <tr >
                    <td class="text-center">{{ $i+1 }}</td>
                    <td class="text-center">{{ $pedido->productos->pluck('name')[$i] }}</td>
                    <td class="text-center">{{ $pedido->productos[$i]['pivot']['cantidades']}} PIEZAS</td>
                    <td class="text-center">${{ $pedido->productos[$i]['pivot']['precio']}}.00 </td>
                    <td class="text-center">{{ $pedido->dias}} DIAS</td>
                    <td class="text-center">${{ $importe}}.00 </td>
                  </tr>
                  
                  @endforeach

                  <!------- ROWS DE TOTALES -->

                   @php
                   $revision= $pedido->revision->total_revision;
                   $total= $pedido->total;
                  $TotalsinRev = $total - $revision ;
                  @endphp

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style='background-color:#303030;color:white;' class="text-center"><strong>SUBTOTAL</strong></td>
                    <td style='background-color:#DCDCDC' class="text-center"><strong>${{$pedido->revision->total_revision}}</strong></td>
                  </tr>

                  

                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style='background-color:#303030;color:white;' class="text-center"><strong>IMPORTE DE REVISION</strong></td>
                    <td style='background-color:#DCDCDC' class="text-center"><strong>${{$TotalsinRev}}</strong></td>
                  </tr>

                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style='background-color:#303030;color:white;' class="text-center"><strong>IMPORTE DE ALMACENAJE</strong></td>
                    <td style='background-color:#DCDCDC' class="text-center"><strong>${{$total}}</strong></td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>

          
                

          <div class="row">
            <div class="col-md-9 mx-auto my-4">
              <div class="form-group text-center  mt-1">
                <h2><strong>TOTAL DE PIEZAS:</strong> {{ $pedido->cantidad }}</h2>
                
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection
