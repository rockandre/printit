@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/home.css') }}" />
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="alignMiddleLeft">Departamento {{ $department->name }}</h2>
            @if($statistics['total'] > 0)
            <div class="col-md-4">
                <div class="panel panel-body">
                    <h4>Número total de Impressões: <b>{{ $statistics['total'] }}</b></h4>
                    <h4>Número de Impressões Hoje: <b>{{ $statistics['today'] }}</b></h4>
                    <h4>Média Diária do Mês Atual: <b>{{ $statistics['dailyMonth'] }}</b></h4>
                </div>
            </div>
            <div class="col-md-8">
                <div id="chart-div">
                    {!! $lava->render('PieChart', 'Cores VS Preto e Branco', 'chart-div') !!}
                </div>
            </div>
            @else
            <div class="alert alert-danger">
                <strong>Sem Impressões</strong> Este departamento não contém impressões registadas!
            </div>
            @endif
        </div>
    </div>
</div>
@endsection