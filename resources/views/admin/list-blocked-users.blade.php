@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/users.css') }}" />
<div>
    <h2>Utilizadores Bloqueados</h2>
    <div>
        <form class="form-vertical" role="form" method="GET" action="{{ route('users.blocked', ['user_search' => request('user_search'), 'department' => request('department')]) }}">
            @include('admin.partials.filter-blocked-users')
        </form>
    </div>
    @if(count($users) == 0)
    <div class="alert alert-danger">
        <strong>Erro!</strong> Não foram encontrados Utilizadores!
    </div>
    @else
    <table class="table table-striped">
        <tr>
            <th>Nome 
                <a href="{{ route('users.blocked', ['user_search' => request('user_search'), 'department' => request('department'), 'orderByParam' => 'name', 'orderByType' => 'asc']) }}"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                <a href="{{ route('users.blocked', ['user_search' => request('user_search'), 'department' => request('department'), 'orderByParam' => 'name', 'orderByType' => 'desc']) }}"><i class="fa fa-arrow-up" aria-hidden="true"></i></a> 
            </th>
            <th>Email
                <a href="{{ route('users.blocked', [
                'user_search' => request('user_search'), 
                'department' => request('department'), 
                'orderByParam' => 'email', 
                'orderByType' => 'asc'
                ]) }}"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                <a href="{{ route('users.blocked', ['user_search' => request('user_search'), 'department' => request('department'), 'orderByParam' => 'email', 'orderByType' => 'desc']) }}"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
            </th>
            <th>Telefone</th>
            <th>Ações</th>
        </tr>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->phone}}</td>
                <td>
                    <div class="inline">
                        <a href="{{ route ('user.show', $user->id)}}" class="btn btn-sm btn-primary">Ver Perfil</a>
                        <form action="{{ route('unlock.user', $user->id) }}" method="post" class="inline">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-sm btn-success">Desbloquear</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="alignCenter"> 
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection