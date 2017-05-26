@extends('layouts.app')

@section('content')

<div class="row panel panel-info" >
	<div class="panel-heading">
		<h2> Informação Pessoal </h2>
	</div>
	<div class="panel-body">
		<div class="col-sm-3">  
			@if($user->profile_photo)
			<img src="{{ route('profile.image', $user->profile_photo) }}" height="190" width="190"> 
			@else
			<img src="{{asset('/img/profiles/male.jpg')}}" height="190" width="190">
			@endif  
		</div>	
		<div class="col-sm-9" >
			<div class="row">
				<div class="col-sm-4">
					<p><b> Name </b> </p>
				</div>
				<div class="col-sm-8">
					<p>{{$user->name}} </p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<p><b> Email </b> </p>
				</div>
				<div class="col-sm-8">
					<p>{{$user->email}} </p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<p><b> Phone </b> </p>
				</div>
				<div class="col-sm-8">
					@if($user->phone)
					<p>{{$user->phone}} </p>
					@else
					Não têm contacto!!
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
					<p><b> Department </b> </p>
				</div>
				<div class="col-sm-8">
					<p>{{$user->department->name}} </p>
				</div>
			</div>
		<div class="row">
			<div class="col-sm-4">
				<p><b> Profile URL </b> </p>
			</div>
			<div class="col-sm-8">
				@if($user->profile_url)
				<p>{{$user->profile_url}} </p>
				@else
				Não têm URL!!
				@endif
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<p><b> Presentation </b> </p>
			</div>
			<div class="col-sm-8">
				@if($user->presentation)
				<p>{{$user->presentation}} </p>
				@else
				Não têm apresentação!!
				@endif
			</div>
		</div>

	</div>
</div>

</div>
@endsection
