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
                    <select name='cliente_id' type="text" class="form-control" value="{{$pedido->cliente_id}}">
                        <option value="{{$pedido->cliente_id}}">  {{$pedido->cliente->name}}</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{$cliente->id}}">{{$cliente->name}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- COMIENZA SEGUNDA FILA SENIOR ---->
        @php
            $i=-1;
        @endphp

        @foreach ($pedido->productos as $articulo)
            @php
                $i++;
            @endphp

            <div class="row concepto-row" >
                <div class="col-lg-4">
                    <div class="form-group">
                        <label>PRODUCTO {{ $i+1}}:</label>
                        <select name='producto_id[]' type="text" class="form-control">
                            <option value="{{$pedido->productos->pluck('id')[$i]}}">{{ $pedido->productos->pluck('name')[$i]}}</option>
                            @foreach ($productos as $producto)
                                <option value="{{$producto->id}}">{{$producto->name}}</option>
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
                    <button type="button" class="btn btn-success agregar-concepto">Agregar</button>
                    <button type="button" class="btn btn-danger quitar-concepto">Eliminar</button>
                </div>
            </div>
        @endforeach

        <div id="nuevo-producto"></div>

   
  <script>
    $(document).ready(function() {
        // Agregar nuevo concepto
        $('.agregar-concepto').click(function() {
            var conceptoRow = `
                <div class="row concepto-row">
                    <div class="col-lg-4">
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
            $('#nuevo-producto').append(conceptoRow);
        });

        // Quitar concepto
        $(document).on('click', '.quitar-concepto', function() {
            $(this).closest('.concepto-row').remove();
        });
    });
</script>



    </div>
</div>
</div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>



                        </form>
                    </div>
                </div>
    </section>
