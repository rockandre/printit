@extends('layouts.app')

@section('content')
<table class="table table-striped">
    <thead>
        <tr>
            <th>Email</th>
            <th>Fullname</th>
            <th>Registered At</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{$user->email}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->created_at}}</td>
            <td>{{$user->typeToStr()}}</td>
            <td>
                @can('edit', $user)
                <a class="btn btn-xs btn-primary" href="{{route('users.edit', $user)}}">Edit</a>
                @endcan
                @can('create-destroy')
                <form action="{{route('users.destroy', $user)}}" method="post" class="inline">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <button type="submit" class="btn btn-xs btn-danger">Delete</button>
                    </div>
                </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection