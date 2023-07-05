@extends('layouts.app')

@section('template_title')
    {{ $pedidoProducto->name ?? "{{ __('Show') Pedido Producto" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Pedido Producto</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('pedido-productos.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Pedido Id:</strong>
                            {{ $pedidoProducto->pedido_id }}
                        </div>
                        <div class="form-group">
                            <strong>Producto Id:</strong>
                            {{ $pedidoProducto->producto_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
