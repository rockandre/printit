@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/requests.css') }}" />
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Recusar Pedido de Impressão</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ route('refuse.request', $request->id) }}">
						{{ csrf_field() }}
						<div class="form-group">
							<label class="col-md-4 control-label">Funcionário</label>

							<div class="col-md-6">
								<p class="data-label">{{$request->user->name}}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Departamento</label>

							<div class="col-md-6">
								<p class="data-label">{{$request->user->department->name}}</p>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Tipo de Impressão</label>

							<div class="col-md-6">
								<ul>
									<li>A{{ $request->paper_size }}</li>
									<li>{{ $request->paper_typeToStr()}}</li>
									<li>{{ $request->coloredToStr()}}</li>
								</ul>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Data do Pedido</label>

							<div class="col-md-6">
								<p class="data-label">{{$request->due_date}}</p>
							</div>
						</div>
						<div class="form-group">
							<label for="refusemessage" class="col-md-4 control-label">Razão de Recusa</label>

							<div class="col-md-6">
								<input id="refusemessage" type="text" class="form-control" name="refusemessage" placeholder="Insira a razão de recusa!" required autofocus>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<button type="submit" class="btn btn-sm btn-success">Confirmar</button>
								<a href="{{ route('requests.show') }}" class="btn btn-sm btn-danger">Cancelar</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection