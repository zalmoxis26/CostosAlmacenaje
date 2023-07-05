<div class="box box-info padding-1">
    <div class="box-body">


         <div class="form-group">
        <label>CLIENTE:</label>
                <select name='cliente_id' type="text" class="form-control"  value="{{$precio->cliente_id}}">
                    <option value="1">{{$precio->cliente->name }} </option>
                @foreach ($cliente as $clientes)
                     <option value="{{$clientes->id}}">{{$clientes->name}} </option>
                @endforeach
            </select>
            </div>

        <div class="form-group">
            <label>PRODUCTO:</label>
                <select name='producto_id' type="text" class="form-control"  value="{{$precio->producto_id}}">
                    <option value="{{$precio->producto_id}}">{{$precio->producto->name}} </option>
                    @foreach ($productos as $producto)
                     <option value="{{$producto->id}}">{{$producto->name}} </option>
                @endforeach
            </select>
            </div>

        <div class="form-group">
            {{ Form::label('precio') }}
            {{ Form::text('precio', $precio->precio, ['class' => 'form-control' . ($errors->has('precio') ? ' is-invalid' : ''), 'placeholder' => 'Precio']) }}
            {!! $errors->first('precio', '<div class="invalid-feedback">:message</div>') !!}
        </div>

       

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
