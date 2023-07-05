@extends('layouts.app')

@section('template_title')
    Cliente
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
      <form class="d-flex" id="searchForm" >        
        <input class="form-control me-2" type="text" id="searchInput" placeholder="Buscar" aria-label="Search"> 
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
                                {{ __('LISTA DE CLIENTES') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('clientes.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    

                    <div class="table-responsive" >
                        <table class="table table-striped table-hover">
                            <!-- Resto del código de la tabla -->
                            <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Name</th>
										<th>Codigo Cliente</th>

                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clientes as $cliente)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $cliente->name }}</td>
											<td>{{ $cliente->codigo_cliente }}</td>

                                            <td>
                                                <form action="{{ route('clientes.destroy',$cliente->id) }}" method="POST">
                                                    <a class="btn btn-primary " href="{{ route('clientes.show',$cliente->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('MOSTRAR') }}</a>
                                                    <a class="btn btn-success" href="{{ route('clientes.edit',$cliente->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('EDITAR') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"><i class="fa fa-fw fa-trash"></i> {{ __('ELIMINAR') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {!! $clientes->links() !!}
        </div>
    </div>
</div>


                   <!-- <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Name</th>
										<th>Codigo Cliente</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clientes as $cliente)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $cliente->name }}</td>
											<td>{{ $cliente->codigo_cliente }}</td>

                                            <td>
                                                <form action="{{ route('clientes.destroy',$cliente->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('clientes.show',$cliente->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('clientes.edit',$cliente->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $clientes->links() !!}
            </div>
        </div>
    </div> -->

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
</script>

@endsection


