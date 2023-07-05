@extends('layouts.app')

@section('template_title')
    {{ __('Create') }} Pedido
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Pedido</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('pedidos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

   
      <div class="box box-info padding-1">
    <div class="box-body">

    <!-- PRIMERA FILA SENIOR ---->

    <div class="row">

        <div class="col-lg-3">
            <div class="form-group">
                {{ Form::label('factura') }}
                {{ Form::text('factura', $pedido->factura, ['class' => 'form-control' . ($errors->has('factura') ? ' is-invalid' : ''), 'placeholder' => 'Factura']) }}
                 {!! $errors->first('factura', '<div class="invalid-feedback">:message</div>') !!}
             </div>
        </div>


        <div class="col-lg-6">
            <div class="form-group">
                    <label>CLIENTE:</label>
                    <select name='cliente_id' type="text" class="form-control"  value="{{$pedido->cliente_id}}">
                @foreach ($clientes as $cliente)
                     <option value="{{$cliente->id}}">{{$cliente->name}} </option>
                @endforeach
                    </select>
            </div>
        </div>
            
        <div class="col-lg-3">

             <div class="form-group" style="display: none;">
                <label>CODIGO CLIENTE:</label>
                    <select name='codigo_id' type="text" class="form-control"  value="{{$pedido->codigo_id}}">
                        @foreach ($clientes as $cliente)
                     <option value="{{$cliente->id}}">{{$cliente->codigo_cliente}} </option>
                @endforeach
                    </select>
                </div>
        </div>

    </div>

    <!-- COMIENZA SEGUNDA FILA SENIOR ---->
   
<div id="conceptos">
  <div class="concepto">
    <div class="row">
      <div class="col-lg-4">
        <div class="form-group">
          <label>PRODUCTO:</label>
          <select name='producto_id[]' type="text" class="form-control">
            @foreach ($productos as $producto)
                     <option value="{{$producto->id}}">{{$producto->name}} </option>
                @endforeach
                    </select>
        </div>
      </div>

      <div class="col-lg-2">
        <div class="form-group">
          {{ Form::label('cantidad') }}
          {{ Form::text('cantidad[]', $pedido->cantidad, ['class' => 'form-control' . ($errors->has('cantidad') ? ' is-invalid' : ''), 'placeholder' => 'Cantidad']) }}
          {!! $errors->first('cantidad', '<div class="invalid-feedback">:message</div>') !!}
        </div>
      </div>

      <div class="col-lg-2" style="margin-right: 10px; margin-top: 20px;">
  <button type="button" class="btn btn-success agregar-concepto">Agregar</button>
   <button type="button" class="btn btn-danger quitar-concepto">Quitar</button>
</div>



    </div>
  </div>
</div>

<script>
// Agregar nuevo concepto
const agregarConcepto = () => {
  const conceptos = document.querySelector('#conceptos');
  const nuevoConcepto = conceptos.firstElementChild.cloneNode(true);
  conceptos.appendChild(nuevoConcepto);
}

// Quitar último concepto
const quitarConcepto = (event) => {
  const concepto = event.target.closest('.concepto');
  const conceptos = document.querySelector('#conceptos');
  if (conceptos.children.length > 1) {
    conceptos.removeChild(concepto);
  }
}

// Manejadores de eventos
document.addEventListener('click', (event) => {
  if (event.target.classList.contains('agregar-concepto')) {
    agregarConcepto();
  } else if (event.target.classList.contains('quitar-concepto')) {
    quitarConcepto(event);
  }
});
</script>


    
</div>
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>


                        </form>
                    </div>
                </div>
    </section>
@endsection
