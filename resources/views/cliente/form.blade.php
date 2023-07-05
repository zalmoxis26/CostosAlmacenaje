<style>
    .custom-container {
        width: 60%;
        margin: 0 auto;
    }
</style>

<div class="custom-container">
    <div class="box box-info padding-1">
        <div class="box-body">
            <div class="form-group">
                {{ Form::label('NOMBRE DEL CLIENTE') }}
                {{ Form::text('name', $cliente->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="form-group">
                {{ Form::label('CODIGO DEL CLIENTE') }}
                {{ Form::text('codigo_cliente', $cliente->codigo_cliente, ['class' => 'form-control' . ($errors->has('codigo_cliente') ? ' is-invalid' : ''), 'placeholder' => 'Codigo Cliente']) }}
                {!! $errors->first('codigo_cliente', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="box-footer mt20">
            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
        </div>
    </div>
</div>
