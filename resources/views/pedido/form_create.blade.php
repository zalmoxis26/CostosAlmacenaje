<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
        <label>CLIENTE:</label>
              <select  name='cliente_id' type="text" class="form-control" placeholder="NOMBRE DE CLIENTE">
                @foreach ($clientes as $cliente)
                     <option value="{{$cliente->id}}">{{$cliente->name}} </option>
                @endforeach
              </select>
        </div>
        <div class="form-group" >
            <label>CODIGO CLIENTE:</label>
                <select  style="display: none;" name='codigo_id' type="text" class="form-control"  placeholder="CL-000">
                @foreach ($clientes as $cliente)
                     <option value="{{$cliente->id}}">{{$cliente->codigo_cliente}} </option>
                @endforeach
              </select>
                </div>
        <div class="form-group">
            <label>PRODUCTO:</label>
                <select  name='producto_id' type="text" class="form-control"  placeholder="NOMBRE DEL PRODUCTO">
                @foreach ($productos as $producto)
                     <option value="{{$producto->id}}">{{$producto->name}} </option>
                @endforeach
              </select>
            </div>

             <div class="form-group">
            <label>PRECIO:</label>
                 <select  name='precio_id' type="text" class="form-control"  placeholder="PRECIO DEL PRODUCTO">
                @foreach ($productos as $producto)
                     <option value="{{$producto->id}}">{{$producto->precio}} </option>
                @endforeach
              </select>
            </div>

        <div class="form-group">
            {{ Form::label('factura') }}
            {{ Form::text('factura', $pedido->factura, ['class' => 'form-control' . ($errors->has('factura') ? ' is-invalid' : ''), 'placeholder' => 'Factura']) }}
            {!! $errors->first('factura', '<div class="invalid-feedback">:message</div>') !!}
        </div>

        <div class="form-group">
            {{ Form::label('fecha_entrada') }}
            {{ Form::date('fecha_entrada', $pedido->fecha_entrada, ['class' => 'form-control' . ($errors->has('fecha_entrada') ? ' is-invalid' : ''), 'placeholder' => $pedido->fecha_entrada]) }}
            {!! $errors->first('fecha_entrada', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_salida') }}
            {{ Form::date('fecha_salida', $pedido->fecha_salida, ['class' => 'form-control' . ($errors->has('fecha_salida') ? ' is-invalid' : ''), 'placeholder' => $pedido->fecha_salida]) }}
            {!! $errors->first('fecha_salida', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cantidad') }}
            {{ Form::text('cantidad', $pedido->cantidad, ['class' => 'form-control' . ($errors->has('cantidad') ? ' is-invalid' : ''), 'placeholder' => 'Cantidad']) }}
            {!! $errors->first('cantidad', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('dias') }}
            {{ Form::text('dias', $pedido->dias, ['class' => 'form-control' , 'placeholder' => 'Dias']) }}
        <div class="form-group">
            {{ Form::label('total') }}
            {{ Form::text('total', $pedido->total, ['class' => 'form-control' , 'placeholder' => 'Total']) }}
            
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
