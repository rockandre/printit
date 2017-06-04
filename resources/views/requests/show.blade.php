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
			<img src="{{ route('profile.image', $request->user->profile_photo) }}" height="250" width="250">
			@else
			<img src="{{ route('profile.image', "default_profile.jpg") }}" height="250" width="250">
			@endif
			<hr>
			<p><b>Nome: </b>{{ $request->user->name }}</p>
			<p><b>Departamento: </b>{{ $request->user->department->name }}</p>
			<p><b>Email: </b>{{ $request->user->email }}</p>
			<p><b>Telefone: </b>{{ $request->user->phone }}</p>
		</div>
		<div class="col-md-9">
			<div class="inline">
				<h2>Pedido de Impressão</h2>
				@if ($request->status != 2 && Auth::user()->id == $request->user->id)
				<a href="#" class="btn btn-sm btn-primary">Editar</a>
				@endif
				@if (Auth::user()->isAdmin() && $request->status == '0')
				<a href="{{ route('finish.request', $request->id) }}" class="btn btn-sm btn-success">Concluir</a>
				<a href="{{ route('refuse.request', $request->id) }}" class="btn btn-sm btn-warning">Recusar</a>
				@endif
			</div>
			<br>
			<p><b>Data do Pedido: </b>{{ $request->created_at }}</p>
			<p><b>Estado do Pedido: </b>{{ $request->statusToStr() }}</p>
			@if ($request->status == 2)
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
			@foreach($request->comments as $comments)
			@if($comments->blocked == 0 && $comments->parent_id == null)
			<div class="media">
				<div class="media-left">
					@if(!empty($comments->user->profile_photo))
					<img src="{{ route('profile.image', $comments->user->profile_photo) }}" height="45" width="45"> 
					@else
					<img src="{{ route('profile.image', "default_profile.jpg") }}" height="45" width="45"> 
					@endif
				</div>
				<div class="media-body">
					<h4 class="media-heading">{{ $comments->user->name }}<small><i> Posted on {{ $comments->created_at }}</i></small></h4>
					<p>{{ $comments->comment }}</p>

					<button class="btn btn-sm btn-info" data-toggle="collapse" data-target="#comment_response{{$comments->id}}">Responder</button>
					<div id="comment_response{{$comments->id}}" class="collapse">
						<div class="commentArea">
							Escrever comentário:
							<form action="{{ route('request.comment', [$request->id, $comments->id]) }}" method="POST">
								{{ csrf_field() }}
								<div class="form-group">
									<input id="comment" type="text" placeholder="Insira aqui o seu comentário!" name="comment" class="form-control" required/>
									<button type="submit" class="btn btn-sm btn-primary btn_comment">Comentar</button>
								</div>
							</form>
						</div>
					</div>

					@foreach($comments->comments as $comment)
					@if($comment->blocked == 0)
					<div class="media">
						<div class="media-left">
							@if(!empty($comment->user->profile_photo))
							<img src="{{ route('profile.image', $comment->user->profile_photo) }}" height="45" width="45"> 
							@else
							<img src="{{ route('profile.image', "default_profile.jpg") }}" height="45" width="45"> 
							@endif
						</div>
						<div class="media-body">
							<h4 class="media-heading">{{ $comment->user->name }}<small><i> Posted on {{ $comment->created_at }}</i></small></h4>
							<p>{{ $comment->comment }}</p>
						</div>
					</div>
					@endif
					@endforeach
				</div>
			</div>
			@endif
			@endforeach

			<div class="commentArea">
				Escrever comentário:
				<form action="{{ route('request.comment', $request->id) }}" method="POST">
					{{ csrf_field() }}
					<div class="form-group">
						<input id="comment" type="text" placeholder="Insira aqui o seu comentário!" name="comment" class="form-control" required/>
						<button type="submit" class="btn btn-sm btn-primary btn_comment">Comentar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
@endsection