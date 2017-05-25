@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/requests.css') }}" />
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Concluir Pedido de Impressão</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ route('finish.request', $request->id) }}">
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
									<li>{{ $request->paper_sizeToStr() }}</li>
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
							<label for="printerused" class="col-md-4 control-label">Impressora utilizada</label>

							<div class="col-md-6">
								<select class="form-control" id="printerused" name="printerused">
									@foreach ($printers as $printer)
										<option value="{{$printer->id}}">{{$printer->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-8 col-md-offset-4">
								<button type="submit" class="btn btn-sm btn-success">Confirmar</button>
								<a href="{{ route('requests.list') }}" class="btn btn-sm btn-danger">Cancelar</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection