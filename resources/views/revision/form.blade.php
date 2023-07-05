<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('inicio_revision') }}
            {{ Form::input('datetime-local', 'inicio_revision', $revision->inicio_revision, ['class' => 'form-control' . ($errors->has('inicio_revision') ? ' is-invalid' : ''), 'placeholder' => 'Inicio Revision']) }}
            {!! $errors->first('inicio_revision', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fin_revision') }}
            {{ Form::input('datetime-local', 'fin_revision', $revision->fin_revision, ['class' => 'form-control' . ($errors->has('fin_revision') ? ' is-invalid' : ''), 'placeholder' => 'Fin Revision']) }}
            {!! $errors->first('fin_revision', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('revisor') }}
            {{ Form::text('revisor', $revision->revisor, ['class' => 'form-control' . ($errors->has('revisor') ? ' is-invalid' : ''), 'placeholder' => 'Revisor']) }}
            {!! $errors->first('revisor', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('precio_revision') }}
            {{ Form::text('precio_revision', $revision->precio_revision, ['class' => 'form-control' . ($errors->has('precio_revision') ? ' is-invalid' : ''), 'placeholder' => 'Precio Revision']) }}
            {!! $errors->first('precio_revision', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('total_revision') }}
            {{ Form::text('total_revision', $revision->total_revision, ['class' => 'form-control' . ($errors->has('total_revision') ? ' is-invalid' : ''), 'placeholder' => 'Total Revision']) }}
            {!! $errors->first('total_revision', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
