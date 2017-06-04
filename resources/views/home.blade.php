@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/home.css') }}" />
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 class="alignMiddleLeft">Estatisticas Print It</h2>
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
        </div>
    </div>
    <div class="row departmentArea">
        <div class="col-md-12">
            <div class="panel panel-body">
                <table class="table table-striped">
                    <tr>
                        <th>Departamento</th>
                        <th>Total Impressões</th>
                        <th>Ações</th>
                    </tr>
                    @foreach($departments as $department)
                    <tr>
                        <td>{{ $department->name }}</td>
                        <td>{{ $departmentStats[$department->id]['total'] }}</td>
                        <td><a href="{{ route('department.stats', $department->id) }}" class="btn btn-sm btn-primary">Mais Info</a></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection