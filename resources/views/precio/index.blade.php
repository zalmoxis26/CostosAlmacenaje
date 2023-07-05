@extends('layouts.app')

@section('template_title')
    Precio
@endsection



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
                               <h5><strong> {{ __('LISTA DE PRECIOS DE PRODUCTOS POR CLIENTES') }} </strong></h5>
                            </span>

                             <div class="float-right">
                                <a href="{{ route('precios.create') }}" class="btn btn-primary float-right"  data-placement="left">
                                  {{ __('AGREGAR PRECIO') }}
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
                        <div class="table-responsive">
                            <table class="table table-striped table-hover fs-5">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Cliente Id</th>
										<th>Producto Id</th>
										<th>Precio</th>
										

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($precios as $precio)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $precio->cliente->name }}</td>
											<td>{{ $precio->producto->name }}</td>
											<td>{{ $precio->precio }}</td>
											

                                            <td>
                                                <form action="{{ route('precios.destroy',$precio->id) }}" method="POST">
                                                    <a class="btn  btn-primary " href="{{ route('precios.show',$precio->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('MOSTRAR') }}</a>
                                                    <a class="btn btn-success" href="{{ route('precios.edit',$precio->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('EDITAR') }}</a>
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
             
        </div>
    </div>

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
