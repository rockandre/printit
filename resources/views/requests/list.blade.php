@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/requests.css') }}" />
<div>
    <h1>Pedidos de Impressão</h1>

    <div>
        <form class="form-vertical" role="form" method="POST" action="{{ route('request.filter') }}">
            @include('requests.partials.filter')
        </form>
        
    </div>
    @if(count($requests) == 0)
        <div class="alert alert-danger">
            <strong>Erro!</strong> Não foram encontrados resultados para a sua pesquisa.
        </div>
        
    
    @else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Funcionário</th>
                <th>Departamento</th>
                <th>Estado</th>
                <th>Tipo de Impressão</th>
                <th>Data do Pedido</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
            <tr>
                <td>{{ $request->user->name }}</td>
                <td>{{ $request->user->department->name }}</td>
                <td>{{ $request->statusToStr() }}</td>
                <td>
                    <ul>
                        <li>{{ $request->paper_sizeToStr() }}</li>
                        <li>{{ $request->paper_typeToStr()}}</li>
                        <li>{{ $request->coloredToStr()}}</li>
                    </ul>

                </td>
                <td>{{ $request->created_at->format('d-m-Y')   }}</td>
                <td>
                    <div class="inline">
                        <a href="{{ route('show.request', $request->id) }}" class="btn btn-sm btn-primary">Detalhes</a>
                        @if($request->status == '0')
                        <a href="{{ route('finish.request', $request->id) }}" class="btn btn-sm btn-success">Concluir</a>
                        <a href="{{ route('refuse.request', $request->id) }}" class="btn btn-sm btn-warning">Recusar</a>
                        @endif
                        <form action="{{route('delete.request', $request)}}" method="post" class="inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                            </div>
                        </form>
                    </div>
                </td>
                
            </tr>

            @endforeach
        </tbody>
    </table>
    <div class="alignCenter">
        {{ $requests->links() }}
    </div>
    @endif
</div>
@endsection