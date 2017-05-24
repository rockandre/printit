@extends('layouts.app')

@section('content')
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
			@foreach ($users as $user)
			<tr>
				<td>{{$user->name}}</td>
				<td>{{$user->email}}</td>
				<td>{{$user->phone}}</td>
				<td>
					<a class="btn btn-sm btn-primary" href="#">Ver Perfil</a>
					<a class="btn btn-sm btn-success" href="#">Tornar Administrador</a>
					<a class="btn btn-sm btn-danger" href="#">Bloquear</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
@endsection