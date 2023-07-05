@extends('layouts.app')

@section('template_title')
    {{ $revision->name ?? "{{ __('Show') Revision" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Revision</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('revisions.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Inicio Revision:</strong>
                            {{ $revision->inicio_revision }}
                        </div>
                        <div class="form-group">
                            <strong>Fin Revision:</strong>
                            {{ $revision->fin_revision }}
                        </div>
                        <div class="form-group">
                            <strong>Revisor:</strong>
                            {{ $revision->revisor }}
                        </div>
                        <div class="form-group">
                            <strong>Precio Revision:</strong>
                            {{ $revision->precio_revision }}
                        </div>
                        <div class="form-group">
                            <strong>Total Revision:</strong>
                            {{ $revision->total_revision }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
