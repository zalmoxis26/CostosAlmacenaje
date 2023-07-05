<style>
    button {
        margin-top: 10px;
    }
    .custom-container {
        width: 60%;
        margin: 0 auto;
    }
</style>

<div class="custom-container">
    <div class="box box-info padding-1">
        <div class="box-body">
            <div class="form-group">
                <label>CLIENTE:</label>
                <select name='cliente_id' type="text" class="form-control" placeholder="NOMBRE DE CLIENTE">
                    @foreach ($clientes as $cliente)
                        <option value="{{$cliente->id}}">{{$cliente->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <label for="producto_id">Producto:</label>
                        <select class="form-control" id="producto_id" name="producto_id">
                            @foreach ($productos as $producto)
                                <option value="{{$producto->id}}">{{$producto->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mt-3">
                        <button class="btn btn-success" title="PULSE PARA AGREGAR PRODUCTO QUE NO ESTE EN EL CATALOGO" type="button" onclick="eliminarProducto()">AGREGAR PRODUCTO</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                {{ Form::label('precio') }}
                {{ Form::text('precio', $precio->precio, ['class' => 'form-control' . ($errors->has('precio') ? ' is-invalid' : ''), 'placeholder' => 'Precio']) }}
                {!! $errors->first('precio', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="box-footer mt20">
            <button type="submit" class="btn btn-primary">{{ __('CREAR PEDIDO') }}</button>
        </div>
    </div>
</div>



<script>
function eliminarProducto() {
  // Obtener el elemento select
  var select = document.getElementById('producto_id');

  // Obtener el valor seleccionado
  var selectedValue = select.value;

  // Obtener el elemento padre del select (el div.form-group)
  var parentElement = select.parentElement;

  // Eliminar el select
  parentElement.removeChild(select);

  // Crear un nuevo elemento input
  var input = document.createElement('input');
  input.type = 'text';
  input.id = 'producto_id';
  input.name = 'producto_id';
  input.classList.add('form-control')
  
  // Insertar el nuevo elemento input
  parentElement.appendChild(input);

  // Restaurar el valor seleccionado en el nuevo input
  input.value = "ESCRIBA EL NUEVO PRODUCTO A AGREGAR";
  //input.placeholder=  "ESCRIBA EL NUEVO PRODUCTO A AGREGAR";
}
</script>
