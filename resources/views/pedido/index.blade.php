@extends('layouts.app')

@section('template_title')
    Pedido
@endsection

<style>
    .table {
        text-align: center;
    }
    
    .table th,
    .table td {
        text-align: center;
         
    }
    
    .table .btn {
        margin: 0 auto;
    }

  

</style>

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
                            {{ __('LISTA DE ENTRADAS') }}
                        </span>
                        <div class="float-right">
                            <button class="btn btn-secondary btn-sm" form="form1" type="submit" title="DAR SALIDA A LOS PEDIDOS SELECCIONADOS">DAR SALIDA</button>
                            <button class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#exportModal">EXPORTAR EXCEL</button>
                            <a href="{{ route('pedidos.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                {{ __('CREAR PEDIDO') }}
                            </a>
                        </div>
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                @if (session('mensaje'))
    <div class="alert alert-Danger">
         <strong>OJO:</strong><br>{!! nl2br(e(session('mensaje'))) !!}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

                <div class="card-body">
                    <div class="table-responsive ">
                        <table class="table table-striped table-hover fs-5">
                            <thead class="thead">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Cliente</th>
                                    <th>Codigo Cliente</th>
                                    <th>Productos</th>
                                    <th>Factura</th>
                                    <th>Fecha Entrada</th>
                                    <th>Total de Piezas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form id="form1" action="{{ route('dar_salida') }}" method="get">
                                    @foreach ($pedidos as $pedido)
                                        <tr class="text-center">
                                            <td>
                                                {{ ++$i }}
                                                <input type="checkbox" width="30" height="30" value="{{$pedido->id}}" title="SELECCIONE PARA GENERAR SALIDA" form="form1" name="select_pedidos[]">
                                            </td>
                                            <td>{{ $pedido->cliente->name }}</td>
                                            <td>{{ $pedido->cliente->codigo_cliente }}</td>
                                            <td>{{ $pedido->productos->pluck('name')->first() }}</td>
                                            <td>{{ $pedido->factura }}</td>
                                            <td>{{ $pedido->fecha_entrada }}</td>
                                            <td>{{ $pedido->cantidad }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('pedidos.destroy',$pedido->id) }}" method="POST">
                                                  
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn" onclick="return confirm('¿Estás seguro de que quieres eliminar este pedido?')">ELIMINAR</button>

        <!-- Button to trigger show modal -->
                       <button type="button" class="btn btn-primary d-inline" id="acciones" data-toggle="modal" data-target="#showPedidoModal{{ $pedido->id }}">
                        {{ __('MOSTRAR') }}</button>
         <a class="btn d-inline btn-success" id="acciones" href="{{ route('pedidos.edit',$pedido->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('EDITAR') }}</a>
         <!-- Botón para abrir el modal de Agregar Revisiones -->
        
          <a href="#" class="btn d-inline btn-dark" data-toggle="modal" data-target="#ModalVerRevision{{ $pedido->id }}">{{ __('REVISIONES') }}</a>

    </form>
</td>
</tr>
@endforeach
</form>
</tbody>
</table>
</div>
<!-- Mostrar enlaces de paginación estilizados con Bootstrap -->
<div class="pagination justify-content-center">
    <ul class="pagination">
        <!-- Enlace "Anterior" -->
        @if ($pedidos->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">Anterior</span>
            </li>
        @else
            <li class="page-item">
                <a href="{{ $pedidos->previousPageUrl() }}" class="page-link" aria-label="Anterior">Anterior</a>
            </li>
        @endif

        <!-- Enlaces numéricos -->
        @foreach ($pedidos->getUrlRange(1, $pedidos->lastPage()) as $page => $url)
            @if ($page == $pedidos->currentPage())
                <li class="page-item active">
                    <span class="page-link">{{ $page }}</span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                </li>
            @endif
        @endforeach

        <!-- Enlace "Siguiente" -->
        @if ($pedidos->hasMorePages())
            <li class="page-item">
                <a href="{{ $pedidos->nextPageUrl() }}" class="page-link" aria-label="Siguiente">Siguiente</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">Siguiente</span>
            </li>
        @endif
    </ul>
</div>
</div>
</div>
</div>
</div>
</div>

                                                                                     

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
                <!-- FORM EXPORTAR TODOS LOS PEDIDOS -->
                <form action="{{ route('exportarPedidos') }}" method="get" id="exportForm">
                    @csrf
                    <div class="form-group">
                        <label for="exportOption">Opciones de exportación:</label>
                        <select class="form-control" id="exportOption" name="exportOption" onchange="handleSelectChange()">
                            <option value="todos">TODOS</option>
                            <option value="cliente">CLIENTE</option>
                            <option value="seleccionados">SELECCIONADOS</option>
                        </select>
                    </div>
                </form>
                <!-- FORM EXPORTAR POR CLIENTE -->
                <form action="{{ route('exportar_Cliente', ':clienteId') }}" method="get" id="exportFormPatch">
                @csrf
                    <div class="form-group" id="cliente-select" style="display: none;">
                     <label for="cliente">Cliente:</label>
                        <select class="form-control" id="cliente" name="cliente_id" onchange="updateClienteId()">
                            <option value="0">SELECCIONE UNA OPCION</option>
                                @foreach ($pedidos->pluck('cliente')->unique() as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->name }}</option>
                                @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary mt-2">EXPORTAR CLIENTE</button>
                                </div>
                            <button type="submit" id="exportarTodos" class="btn btn-primary mt-2" form="exportForm">EXPORTAR TODOS</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- fin modal -->

@foreach ($pedidos as $pedido)
    <!-- Modal show -->
<div class="modal fade" id="showPedidoModal{{ $pedido->id }}" tabindex="-1" role="dialog" aria-labelledby="showPedidoModalLabel{{ $pedido->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="showPedidoModalLabel">{{ __('Show') }} Pedido</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th class="text-center">NOMBRE DE CLIENTE</th>
                    <th class="text-center">CODIGO DE CLIENTE</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">{{ $pedido->cliente->name }}</td>
                    <td class="text-center">{{ $pedido->cliente->codigo_cliente }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th class="text-center">FECHA ENTRADA</th>
                    <th class="text-center">FACTURA</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center">{{ $pedido->fecha_entrada }}</td>
                    <td class="text-center">{{ $pedido->factura }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <table class="table table-striped">
                <thead class="thead-dark">
                  <tr>
                    <th class="text-center">NUMERO DE PRODUCTO</th>
                    <th class="text-center">NOMBRE</th>
                    <th class="text-center">CANTIDAD DE PIEZAS</th>
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
                  <tr >
                    <td class="text-center">{{ $i+1 }}</td>
                    <td class="text-center">{{ $pedido->productos->pluck('name')[$i] }}</td>
                    <td class="text-center">{{ $pedido->productos[$i]['pivot']['cantidades']}} PIEZAS</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group text-center  mt-1">
                <strong >TOTAL DE PIEZAS:</strong>
                {{ $pedido->cantidad }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
      <a href="{{ route('PDF_ENTRADA',$pedido->id) }}" class="btn btn-danger" >{{ __('IMPRIMIR ENTRADA') }}</a>
        <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('Close') }}</button>
      </div>
    </div>
  </div>
</div>

<!--FIN MODAL SHOW-->
@endforeach
                  
@foreach ($pedidos as $pedido)
<!-- MODAL PARA VER REVISION -->
<div class="modal fade" id="ModalVerRevision{{ $pedido->id }}" tabindex="-1" role="dialog" aria-labelledby="ModalVerRevision{{ $pedido->id }}Label">
    <div class="modal-dialog modal-lg ml-auto mr-auto" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ModalVerRevision{{ $pedido->id }}Label">{{ __('Mostrar Revisión') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- Contenido de la revisión -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span id="card_title">
                                            {{ __('DETALLE DE REVISIONES') }}
                                        </span>
                                    </div>
                                </div>
                                @if($message = Session::get('success'))
                                    <div class="alert alert-success">
                                    <p>{{ $message }}</p> </div>
                                       
                                @endif

                                @if(session('mensaje'))
                                    <div class="alert alert-info">{{ session('mensaje') }}</div>
                                @endif

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>REVISOR</th>
                                                    <th>INICIO REVISION</th>
                                                    <th>FIN REVISION</th>
                                                    <th>PRECIO UNITARIO</th>
                                                    <th>TOTAL REVISION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $pedido->revision->id }}</td>
                                                    <td>{{ $pedido->revision->revisor }}</td>
                                                    <td>{{ $pedido->revision->inicio_revision }}</td>
                                                    <td>{{ $pedido->revision->fin_revision }}</td>
                                                    <td>{{ $pedido->revision->precio_revision }}</td>
                                                    <td>{{ $pedido->revision->total_revision }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOTONES PARA MOSTRAR Y AGREGAR REVISION-->
            <div class="modal-footer">
                <button id="mostrarAgregarRevision{{ $pedido->id }}" data-toggle="modal" data-target="#ModalAgregarRevision{{ $pedido->id }}" class="btn btn-primary mr-3 mb-2">Agregar Revisión</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar revisión -->
<div class="modal fade" id="ModalAgregarRevision{{ $pedido->id }}" tabindex="-1" role="dialog" aria-labelledby="ModalAgregarRevision{{ $pedido->id }}Label">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalAgregarRevision{{ $pedido->id }}Label">Agregar Revisión</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Contenido del formulario para agregar revisión -->
                <form method="POST" action="{{ route('revision.store') }}">
                    @csrf
                    <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">
                    <div class="form-group">
                        <label for="revisor">{{ __('Revisor') }}</label>
                        <input type="text" class="form-control" id="revisor" name="revisor" required>
                    </div>
                    <div class="form-group">
                        <label for="inicio_revision">{{ __('Inicio Revisión') }}</label>
                        <input type="datetime-local" class="form-control" id="inicio_revision" name="inicio_revision" required>
                    </div>
                    <div class="form-group">
                        <label for="fin_revision">{{ __('Fin Revisión') }}</label>
                        <input type="datetime-local" class="form-control" id="fin_revision" name="fin_revision" required>
                    </div>
                    <div class="form-group">
                        <label for="precio_revision">{{ __('Precio Revisión') }}</label>
                        <input type="number" class="form-control" id="precio_revision" name="precio_revision" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label for="total_revision">{{ __('Total Revisión') }}</label>
                        <input type="number" class="form-control" id="total_revision" name="total_revision" step="0.01" min="0" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancelar') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection


<script>




function handleSelectChange() {
    const exportOption = document.getElementById('exportOption');
    const clienteSelect = document.getElementById('cliente-select');
    const exportarTodos = document.getElementById('exportarTodos');

    if (exportOption.value === 'cliente') {

        clienteSelect.style.display = 'block';
        exportarTodos.style.display = 'none';

    } else if (exportOption.value === 'todos'){

         exportarTodos.style.display = 'block';
          clienteSelect.style.display = 'none';
    }


}



    
</script>
