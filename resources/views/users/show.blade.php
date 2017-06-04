@extends('layouts.app')

@section('content')
<div class="row" >
	<div class="col-sm-3">
		<h1>Fotografia</h1> 
		<br> 
		@if($user->profile_photo)
		<img src="{{ route('profile.image', $user->profile_photo) }}" height="250" width="250"> 
		@else
		<img src="{{ route('profile.image', "default_profile.jpg") }}" height="45" width="45">
		@endif
	</div>	
	<div class="col-sm-9">
		@endif
		<div>
			<h1>Informação Pessoal</h1>
			@can('block-user', $user)
				<form action="{{ route('block.user', $user->id) }}" method="post" class="inline">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-sm btn-danger">Bloquear</button>
                </form>
			@endcan
		</div>
		<br>
		<div class="row">
			<div class="col-sm-4">
				<p><b>Nome</b></p>
				<p><b>Email</b></p>
				<p><b>Telefone</b></p>
				<p><b>Department</b></p>
				@if($user->profile_url)
				<p><b>Profile URL</b></p>
				@endif
				@if($user->presentation)
				<p><b>Presentation</b></p>
				@endif
			</div>
			<div class="col-sm-8">
				<p>{{$user->name}}</p>
				<p>{{$user->email}}</p>
				<p>{{$user->phone}}</p>
				<p>{{$user->department->name}}</p>
				@if($user->profile_url)
				<p>{{$user->profile_url}}</p>
				@endif
				@if($user->presentation)
				<p>{{$user->presentation}}</p>
				@endif
			</div>
		</div>
	</div>
</div>
</div>
@endsection
