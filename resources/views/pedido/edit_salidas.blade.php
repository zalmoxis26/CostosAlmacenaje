@extends('layouts.app')

@section('template_title')
    {{ __('Update') }} Pedido
@endsection

@section('content')

    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Pedido</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('update_salidas', $pedido->id) }}"  role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
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
                                                    <option value="{{$pedido->cliente_id}}">  {{$pedido->cliente->name}}</option>
                                                    @foreach ($clientes as $cliente)
                                                        <option value="{{$cliente->id}}">{{$cliente->name}} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>FECHA SALIDA:</label>
                                                <input name='fecha_salida' type="datetime-local" class="form-control"  value="{{$pedido->fecha_salida}}">
                                            </div>
                                        </div>

                                    </div>

                                    <!-- COMIENZA SEGUNDA FILA SENIOR ---->

                                    <div class="row">

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>REVISOR:</label>
                                                <input name='revisor' type="text" class="form-control"  value="{{$pedido->revision->revisor}}">
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label>TOTAL REVISION:</label>
                                                <input name='total_revision' type="text" class="form-control"  value="{{$pedido->revision->total_revision}}">
                                            </div>
                                        </div>

                                        <div class="col-lg-2 mb-2 mt-4">
                                            <button id="agregar-producto" type="button" class="btn btn-success  btn-md">Agregar Conceptos</button>
                                        </div>

                                        @foreach ($pedido->productos as $i => $articulo)

                                            <div class="row concepto-row">
                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label>PRODUCTO {{ $i+1}}:</label>
                                                        <select name='producto_id[]' type="text" class="form-control">
                                                            <option value="{{$pedido->productos->pluck('id')[$i]}}">{{ $pedido->productos->pluck('name')[$i]}} </option>
                                                            @foreach ($productos as $producto)
                                                                <option value="{{$producto->id}}">{{$producto->name}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        {{ Form::label('cantidad') }}
                                                        {{ Form::text('cantidad[]',  $pedido->productos[$i]['pivot']['cantidades'] , ['class' => 'form-control' . ($errors->has('cantidad') ? ' is-invalid' : ''), 'placeholder' => 'Cantidad']) }}
                                                        {!! $errors->first('cantidad', '<div class="invalid-feedback">:message</div>') !!}
                                                    </div>
                                                </div>

                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        {{ Form::label('precio') }}
                                                        {{ Form::text('precio[]',  $pedido->productos[$i]['pivot']['precio'] , ['class' => 'form-control' . ($errors->has('precio') ? ' is-invalid' : ''), 'placeholder' => 'Precio']) }}
                                                        {!! $errors->first('precio', '<div class="invalid-feedback">:message</div>') !!}
                                                    </div>
                                                </div>

                                                <div class="col-lg-2" style="margin-right: 10px; margin-top: 20px;">
                                                    <button type="button" class="btn btn-danger quitar-concepto mb-3">Eliminar</button>
                                                </div>
                                            </div>
                                        @endforeach

                                        <!--CAMPO PARA NUEVO PRODUCTO-->

                                        <div id="nuevo-producto" class="row concepto-row"  >
                                            <div class="col-lg-3" style="display: none;">
                                                <div class="form-group">
                                                    <label>PRODUCTO:</label>
                                                    <select name='producto_id[]' type="text" class="form-control" disabled>
                                                        @foreach ($productos as $producto)
                                                            <option value="{{$producto->id}}">{{$producto->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-1" style="display: none;">
                                                <div class="form-group">
                                                    <label>CANTIDAD:</label>
                                                    <input name='cantidad[]' type="text" class="form-control" placeholder="Cantidad" disabled>
                                                </div>
                                            </div>

                                            <div class="col-lg-1" style="display: none;">
                                                <div class="form-group">
                                                    <label>PRECIO:</label>
                                                    <input name='precio[]' type="text" class="form-control" placeholder="Precio" disabled>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="box-footer mt-20  btn-lg">
                                <button type="submit" class="btn btn-primary">{{ __('ACTUALIZAR SALIDA') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $('#agregar-producto').click(function() {
                var conceptoRow = `
                <div class="row concepto-row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label>PRODUCTO:</label>
                            <select name='producto_id[]' type="text" class="form-control">
                                @foreach ($productos as $producto)
                                    <option value="{{$producto->id}}">{{$producto->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label>CANTIDAD:</label>
                            <input name='cantidad[]' type="text" class="form-control" placeholder="Cantidad">
                        </div>
                    </div>

                    <div class="col-lg-1">
                        <div class="form-group">
                            <label>PRECIO:</label>
                            <input name='precio[]' type="text" class="form-control" placeholder="Precio">
                        </div>
                    </div>

                    <div class="col-lg-2" style="margin-right: 10px; margin-top: 20px;">
                        <button type="button" class="btn btn-danger quitar-concepto mb-3">Eliminar</button>
                    </div>
                </div>`;
                $('#nuevo-producto').before(conceptoRow);
            });

            $(document).on('click', '.quitar-concepto', function() {
                $(this).closest('.concepto-row').remove();
            });
        });
    </script>

@endsection
