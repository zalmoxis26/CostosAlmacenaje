@extends('layouts.app')

@section('template_title')
    Revision
@endsection

@section('content')
   


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card_title">
                                {{ __('Revision') }}
                            </span>
                            <div class="float-right">
                                <a href="{{ route('revision.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                                    {{ __('Create New') }}
                                </a>
                                
                            </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>REVISOR</th>
            <th>INICIO REVISION</th>
            <th>FIN REVISION</th>
            <th>PRECIO UNITARIO</th>
            <th>TOTAL REVISION</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($revisions as $revision)
            <tr>
                <td>{{ $revision->id }}</td>
                <td>{{ $revision->revisor }}</td>
                <td>{{ $revision->inicio_revision }}</td>
                <td>{{ $revision->fin_revision }}</td>
                <td>{{ $revision->precio_revision }}</td>
                <td>{{ $revision->total_revision }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Modal Title</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Modal content goes here...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>



@endsection
