@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/requests.css') }}" />
<div>
    <h1>Pedidos de Impressão</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <!--<th>Thumbnail</th>-->
                <th>Funcionario</th>
                <th>Departamento</th>
                <th>Estado</th>
                <th>Tipo de Impressão</th>
                <th>Data do Pedido</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($requests as $request)
            <tr>
                <td>{{ $request->user->name }}</td>
                <td>{{ $request->user->department->name }}</td>
                <td>{{ $request->statusToStr() }}</td>
                <td>
                    <ul>
                        <li>A{{ $request->paper_size }}</li>
                        <li>{{ $request->paper_typeToStr()}}</li>
                        <li>{{ $request->coloredToStr()}}</li>
                    </ul>

                </td>
                <td>{{ $request->due_date }}</td>
                <td>
                    @if($request->status == '0')
                    <div class="inline">
                        <a href="{{ route('finish.request', $request->id) }}" class="btn btn-sm btn-success">Concluir</a>
                        <a href="{{ route('refuse.request', $request->id) }}" class="btn btn-sm btn-danger">Recusar</a>
                    </div>
                    @endif
                </td>
                
            </tr>

            @endforeach
        </tbody>
    </table>
    <div class="alignCenter">
        {{ $requests->links() }}
    </div>
</div>
@endsection