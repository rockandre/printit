@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/requests.css') }}" />
<div>
    <h1>Pedidos de Impressão</h1>

    <div>
        <form class="form-vertical" role="form" method="get" action="{{ route('requests.list', ['description' => request('description'), 'user' => request('user'), 'department' => request('department'), 'status' => request('status') ])}}">
            @include('requests.partials.filter')
        </form>
        
    </div>
    @if(count($requests) == 0)
        <div class="alert alert-danger">
            <strong>Erro!</strong> Não foram encontrados Pedidos de Impressão!
        </div>
        
    @else
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Funcionário
                    <a href="{{ route('requests.list', ['description' => request('description'), 'user' => request('user'), 'department' => request('department'), 'status' => request('status'), 'orderByParam' => 'users.name', 'orderByType' => 'asc']) }}"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                    <a href="{{ route('requests.list', ['description' => request('description'), 'user' => request('user'), 'department' => request('department'), 'status' => request('status'), 'orderByParam' => 'users.name', 'orderByType' => 'desc']) }}"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                </th>
                <th>Departamento
                    <a href="{{ route('requests.list', ['description' => request('description'), 'user' => request('user'), 'department' => request('department'), 'status' => request('status'), 'orderByParam' => 'departments.name', 'orderByType' => 'asc']) }}"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                    <a href="{{ route('requests.list', ['description' => request('description'), 'user' => request('user'), 'department' => request('department'), 'status' => request('status'), 'orderByParam' => 'departments.name', 'orderByType' => 'desc']) }}"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                </th>
                <th>Estado
                    <a href="{{ route('requests.list', ['description' => request('description'), 'user' => request('user'), 'department' => request('department'), 'status' => request('status'), 'orderByParam' => 'status', 'orderByType' => 'asc']) }}"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                    <a href="{{ route('requests.list', ['description' => request('description'), 'user' => request('user'), 'department' => request('department'), 'status' => request('status'), 'orderByParam' => 'status', 'orderByType' => 'desc']) }}"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                </th>
                <th>Tipo de Impressão
                    <a href="{{ route('requests.list', ['description' => request('description'), 'user' => request('user'), 'department' => request('department'), 'status' => request('status'), 'orderByParam' => 'requestType', 'orderByType' => 'asc']) }}"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                    <a href="{{ route('requests.list', ['description' => request('description'), 'user' => request('user'), 'department' => request('department'), 'status' => request('status'), 'orderByParam' => 'requestType', 'orderByType' => 'desc']) }}"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                </th>
                <th>Data do Pedido
                    <a href="{{ route('requests.list', ['description' => request('description'), 'user' => request('user'), 'department' => request('department'), 'status' => request('status'), 'orderByParam' => 'requests.created_at', 'orderByType' => 'asc']) }}"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                    <a href="{{ route('requests.list', ['description' => request('description'), 'user' => request('user'), 'department' => request('department'), 'status' => request('status'), 'orderByParam' => 'requests.created_at', 'orderByType' => 'desc']) }}"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                </th>
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
                        <li>{{ $request->paper_typeToStr() }}</li>
                        <li>{{ $request->coloredToStr() }}</li>
                    </ul>

                </td>
                <td>{{ $request->created_at->format('d-m-Y') }}</td>
                <td>
                    <div class="inline">
                        <a href="{{ route('show.request', $request->id) }}" class="btn btn-sm btn-primary">Detalhes</a>
                        @can('edit-remove-request', $request)
                        <form action="{{route('delete.request', $request)}}" method="post" class="inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                            </div>
                        </form>
                        @endcan
                        
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