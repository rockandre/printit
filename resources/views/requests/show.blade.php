@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/requests.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/rating.css') }}" />
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<h2>Funcionário</h2>
			<br>
			@if (!empty($request->user->profile_photo))
			<img src="{{ route('profile.image', $request->user->profile_photo) }}">
			<hr>
			@endif
			<p><b>Nome: </b>{{ $request->user->name }}</p>
			<p><b>Departamento: </b>{{ $request->user->department->name }}</p>
			<p><b>Email: </b>{{ $request->user->email }}</p>
			<p><b>Telefone: </b>{{ $request->user->phone }}</p>
		</div>
		<div class="col-md-9">
			<div class="inline">
				<h2>Pedido de Impressão</h2>
				<button class="btn btn-sm btn-primary">Editar</button>
			</div>
			<br>
			<p><b>Data do Pedido: </b>{{ $request->created_at }}</p>
			<p><b>Estado do Pedido: </b>{{ $request->statusToStr() }}</p>
			@if ($request->status != 0)
			<p><b>Avaliação do Pedido: </b></p>
			<div class="col-md-12">
				@if ( empty($request->satisfaction_grade) || $request->satisfaction_grade == 0)
				<form class="form-horizontal" role="form" method="POST" action="{{ route('evaluate.request', $request->id) }}">
					{{ csrf_field() }}
					<fieldset class="rating" id="rating">
						<input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Boa - 3 estrelas"></label>
						<input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Razoável - 2 estrelas"></label>
						<input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Má - 1 estrela"></label>
					</fieldset>
					<button type="submit" class="btn btn-sm btn-info">Avaliar</button>
				</form>
				@else 
				<fieldset class="rating" disabled>
					<input type="radio" id="star3" name="rating" value="3" {{($request->satisfaction_grade == 3) ? 'checked' : ''}} /><label class = "full" for="star3" title="Boa - 3 estrelas"></label>
					<input type="radio" id="star2" name="rating" value="2" {{($request->satisfaction_grade == 2) ? 'checked' : ''}} /><label class = "full" for="star2" title="Razoável - 2 estrelas"></label>
					<input type="radio" id="star1" name="rating" value="1" {{($request->satisfaction_grade == 1) ? 'checked' : ''}} /><label class = "full" for="star1" title="Má - 1 estrela"></label>
				</fieldset>
				@endif
			</div>
			<br><br>
			@endif
			@if ($request->status == 1)
			<p><b>Motivo de Recusa: </b>{{ $request->refused_reason}}</p>
			@endif
			<p><b>Detalhes do Pedido: </b></p>
			<ul>
				<li>{{ $request->coloredToStr() }}</li>
				<li>{{ $request->front_backToStr() }}</li>
				<li>{{ $request->stapledToStr() }}</li>
				<li>{{ $request->paper_sizeToStr() }}</li>
				<li>{{ $request->paper_typeToStr() }}</li>
			</ul>
			<p><b>Ficheiro: </b>{{ $request->file }}</p>
			<p><b>Descrição: </b>{{ $request->description }}</p>

		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			Comentários
		</div>
	</div>
</div>
@endsection