@extends('layouts.app')

@section('template_title')
    Pedido
@endsection

@section('content')

<!--SEARCH VAR EN TIEMPO REAL, SCRIPT ESTA EN APP LAYOUT-->

<div class="container">
  <div class="row">
    <div class="col-md-8 mx-auto mb-3">
      <form class="d-flex" id="searchForm" action="{{ route('pedidos.index') }}" method="GET">
        <input class="form-control me-2" type="text" id="searchInput" name="search" placeholder="Buscar" aria-label="Search" value="{{ $query }}">
        <button class="btn btn-primary me-2 h-100" type="submit">BUSCAR</button>
        <a href="{{ route('pedidos.index') }}" class="btn btn-secondary h-100">LIMPIAR</a>
      </form>
    </div>
  </div>
</div>



<!--FIN SEARCH VAR EN TIEMPO REAL-->


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('SALIDAS') }}
                            </span>

                             <div class="float-right">
                                <button id="devolverPedidosBtn" class="btn btn-primary btn-sm float-right" data-placement="left" form="form1" type="submit">DEVOLVER PEDIDOS</button>
                                <button class="btn btn-sm btn-success float-right mr-1" data-toggle="modal" data-target="#exportModal">EXPORTAR EXCEL</button>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive text-center fs-5">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                     
                                    <tr>
                                        
                                        <th>NO</th>
										<th>Cliente Id</th>
										<th>Codigo Id</th>
										<th>Producto Id</th>
										<th>Precio Id</th>
										<th>Factura</th>
										<th>Fecha Entrada</th>
                                        <th>Fecha Salida</th>
										<th>Cantidad</th>
										<th>Dias</th>
										<th>Total</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <form id="form1" action="{{ route('dar_salida') }}" method="get">

                                    @foreach ($pedidos as $pedido)
                                        <tr>
                                     
                                       <td><input type="checkbox" width="30" height="30" value="{{$pedido->id}}" title="{{$pedido->id}} PULSE PARA GENERAR SALIDA" form="exportFormSalidasSeleccion" name="select_pedidos[]" id="checkbox{{$pedido->id}}"></td>

                                      
											<td>{{ $pedido->cliente->name}}</td>
											<td>{{ $pedido->cliente->codigo_cliente }}</td>
											<td>{{  $pedido->productos->pluck('name')->first()}}</td>
											<td>{{ $pedido->productos->pluck('precio')->first() }}</td>
											<td>{{ $pedido->factura }}</td>
											<td>{{ $pedido->fecha_entrada }}</td>
                                            <td>{{ $pedido->fecha_salida }}</td>
											<td>{{ $pedido->cantidad }}</td>
											<td>{{ $pedido->dias }}</td>
											<td>{{ $pedido->total }}</td>

                                            <td>
                                                <form action="{{ route('pedidos.destroy',$pedido->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="#" data-toggle="modal" data-target="#resumenModal{{ $pedido->id }}"><i class="fa fa-fw fa-eye"></i> {{ __('VER') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('edit_salidas',$pedido->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('EDITAR') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('ELIMINAR') }}</button>
                                                </form>
                                            </td>
                                        </tr>

                 

                                    @endforeach
                                       </form>  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $pedidos->links() !!}
            </div>
        </div>
    </div>
@endsection

<!-- Modal FORMULARIO EXPORTAR EXCEL-->
<!-- Modal FORMULARIO EXPORTAR EXCEL-->
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">EXPORTAR A EXCEL</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- HTML -->
                <!-- FORM EXPORTAR TODAS LAS SALIDAS -->
                <form action="{{ route('exportarSalidas') }}" method="get" id="exportForm">
                    @csrf
                    <div class="form-group">
                        <label for="exportOption">Opciones de exportación:</label>
                        <select class="form-control" id="Opciones" name="exportOption" onchange="mostrarBoton()">
                            <option value="todos">TODOS</option>
                            <option value="cliente">CLIENTE</option>
                            <option value="seleccionados">SELECCIONADOS</option>
                        </select>
                    </div>
                </form>
                <!-- FORM EXPORTAR POR CLIENTE -->
                <form action="{{ route('exportar_Cliente', ':clienteId') }}" method="get" id="exportFormPatch" style="display: none;">
                    @csrf
                    <div class="form-group" id="cliente-select">
                        <label for="cliente">Cliente:</label>
                        <select class="form-control" id="cliente" name="cliente_id" onchange="updateClienteId()">
                            <option value="0">SELECCIONE UNA OPCION</option>
                            @foreach ($pedidos->pluck('cliente')->unique() as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary mt-2">EXPORTAR CLIENTE</button>
                    </div>
                </form>
                <!-- FORM EXPORTAR SALIDAS SELECCIONADAS -->
                <form action="{{ route('exportarSalidasSeleccion') }}" method="get" id="exportFormSalidasSeleccion">
                    @csrf
                    <!-- Agrega aquí los campos adicionales que necesites para la exportación de salidas seleccionadas -->
                    <button id="exportarSeleccionados" style="display: none;" class="btn btn-primary mt-2">EXPORTAR SALIDAS SELECCIONADAS</button>
                </form>
                <button id="exportarTodos" type="submit" class="btn btn-primary mt-2" form="exportForm">EXPORTAR TODOS</button>
                
            </div>
        </div>
    </div>
</div>

<!-- fin modal -->

                       <!-- Modal SHOW Salida -->

@foreach ($pedidos as $pedido)
<div class="modal fade" id="resumenModal{{ $pedido->id }}" tabindex="-1" role="dialog" aria-labelledby="resumenModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="resumenModalLabel{{ $pedido->id }}">RESUMEN DE LA SALIDA #{{ $pedido->id }}</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid fs-5">
          <div class="row">
            <div class="col-md-9 mx-auto my-4">
              <table class="table">
                
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
                  <tr>
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
                    <td style='background-color:#DCDCDC' class="text-center"><strong>${{$TotalsinRev}}</strong></td>
                  </tr>

                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style='background-color:#303030;color:white;' class="text-center"><strong>IMPORTE DE REVISION</strong></td>
                    <td style='background-color:#DCDCDC' class="text-center"><strong>${{$pedido->revision->total_revision}}</strong></td>
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
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
@endforeach

 <!-- CODIGO DE LA SEARCH BAR-------->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#searchInput').on('input', function() {
      var query = $(this).val().toLowerCase();
      $('table tbody tr').each(function() {
        var text = $(this).text().toLowerCase();
        if (query === '' || text.includes(query)) {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
    });
    
  });



  $(document).ready(function() {
    $('#devolverPedidosBtn').on('click', function() {
      $('input[name="select_pedidos[]"]').attr('form', 'form1');
    });
  });

  function mostrarBoton() {
        var opcionSeleccionada = document.getElementById("Opciones").value;
        var botonExportar = document.getElementById("exportarTodos");
        var botonExportarSeleccionados = document.getElementById("exportarSeleccionados");
        var formExportPatch = document.getElementById("exportFormPatch");
        
        if (opcionSeleccionada === "todos") {
            botonExportar.style.display = "block";
            botonExportarSeleccionados.style.display = "none";
            formExportPatch.style.display = "none";
        } else if (opcionSeleccionada === "cliente") {
            botonExportar.style.display = "none";
            botonExportarSeleccionados.style.display = "none";
            formExportPatch.style.display = "block";
        } else if (opcionSeleccionada === "seleccionados") {
            botonExportar.style.display = "none";
            botonExportarSeleccionados.style.display = "block";
            formExportPatch.style.display = "none";
        }
    }

  

</script>
