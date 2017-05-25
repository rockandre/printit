@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/requests.css') }}" />
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Editar pedido</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('request.update', $request) }}" enctype="multipart/form-data">
                        @include('requests.partials.add-edit')
                        
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection