@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/users.css') }}" />
<div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($blockedUsers as $user)
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
        {{ $blockedUsers->links() }}
    </div>
</div>
@endsection