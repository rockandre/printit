@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/comments.css') }}" />
<div>
    <h2>Comentários Bloqueados</h2>
    <div>
        <form class="form-vertical" role="form" method="GET" action="{{ route('comments.blocked', ['comment_search' => request('comment_search'), 'user' => request('user')]) }}">
            @include('admin.partials.filter-blocked-comments')
        </form>
    </div>
    @if(count($users) == 0)
    <div class="alert alert-danger">
        <strong>Erro!</strong> Não foram encontrados Utilizadores!
    </div>
    @else
    <table class="table table-striped">
        <tr>
            <th>Funcionário
            <a href="{{ route('comments.blocked', ['comment_search' => request('comment_search'), 'user' => request('user'), 'orderByParam' => 'users.name', 'orderByType' => 'asc']) }}"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                <a href="{{ route('comments.blocked', ['comment_search' => request('comment_search'), 'user' => request('user'), 'orderByParam' => 'users.name', 'orderByType' => 'desc']) }}"><i class="fa fa-arrow-up" aria-hidden="true"></i></a> 
            </th>
            <th>Comentário</th>
            <th>Publicado&nbsp;a
            <a href="{{ route('comments.blocked', ['comment_search' => request('comment_search'), 'user' => request('user'), 'orderByParam' => 'comments.created_at', 'orderByType' => 'asc']) }}"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                <a href="{{ route('comments.blocked', ['comment_search' => request('comment_search'), 'user' => request('user'), 'orderByParam' => 'comments.created_at', 'orderByType' => 'desc']) }}"><i class="fa fa-arrow-up" aria-hidden="true"></i></a> 
            </th>
            <th>Actions</th>
        </tr>
        @foreach ($comments as $comment)   
        <tr> 
            <td>{{$comment->user->name}}</td>
            <td>{{$comment->comment}}</td>
            <td>{{$comment->created_at}}</td>
            <td>
                <form action="{{route('comment.unlock', $comment)}}" method="post" class="inline">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success">Desbloquear</button>
                    </div>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    <div class="alignCenter">
        {{ $comments->links() }}
    </div>
    @endif
</div>
@endsection