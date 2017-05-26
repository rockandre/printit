@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/users.css') }}" />
<div>
  <h1>Utilizadores</h1>
  <table class="table table-striped">
    <tr>
      <th>Image</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone</th>
      <th>Access</th>
    </tr>
    @foreach($users as $user)
    <tr>
     @if($user->profile_photo)
     <td>
      <img src="{{ route('profile.image', $user->profile_photo)}}" height="30" width="30"> 
    </td>
    @else
    <td>
      <img src="{{asset('/img/profiles/male.jpg')}}" height="30" width="30">  
    </td>
    @endif
    <td>{{$user->name}}</td>
    <td>{{$user->email}}</td>
    <td>
      @if($user->phone)
      {{$user->phone}}
      @else
      -
      @endif
    </td>
    <td> <a href="{{ route ('showUser', $user->id)}}" class="btn btn-success">Access</a> </td>
  </tr>
  @endforeach
</table>
<div class="alignCenter">
  {{$users->links()}}
</div>
@endsection