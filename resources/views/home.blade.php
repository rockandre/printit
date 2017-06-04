@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div id="chart-div">
            	{!! $lava->render('PieChart', 'IMDB', 'chart-div') !!}
            </div>
        </div>
    </div>
</div>
@endsection
