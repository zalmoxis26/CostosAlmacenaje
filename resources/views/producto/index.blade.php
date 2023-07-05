@extends('layouts.app')

@section('template_title')
    Producto
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
                                {{ __('LISTA DE PRODUCTOS') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('productos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('AGREGAR PRODUCTO') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive fs-5">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Name</th>
										<th>Precio</th>
                                        <th>Acciones</th>

                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $producto)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $producto->name }}</td>
											<td>{{ $producto->precio }}</td>
                                            

                                            <td>
                                                <form action="{{ route('productos.destroy',$producto->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('productos.show',$producto->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('MOSTRAR') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('productos.edit',$producto->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('EDITAR') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('ELIMINAR') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $productos->links() !!}
            </div>
        </div>
    </div>
@endsection

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
