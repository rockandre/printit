{{ csrf_field() }}

<div class="container">
  <div class="row">
    <table class="table">
      <thead>
        <tr class="filters">
          <th>Pesquisar
            <input id="description" type="text" class="form-control" name="description">
          </th>
          @if(Auth::user()->isAdmin())
          <th>Funcionario
            <select id="user_id" name="user_id" class="form-control">
              <option value="-1"> -- Todos --</option>
              @foreach($users as $user)
              <option value="{{$user->id}}">{{$user->name}}</option>
              @endforeach
            </select>
          </th>
          <th>Departamento
            <select id="department_id" name="department_id" class="form-control">
              <option value="-1" selected> -- Todos --</option>
              @foreach($departments as $department)
              <option value="{{$department->id}}">{{$department->name}}</option>
              @endforeach
            </select>
          </th>
          @endif
          <th>Estado
            <select id="estado" name="estado" class="form-control">
              <option value="-1" selected>-- Todos --</option>
              <option value="0">Pendente</option>
              <option value="2">Concluido</option>
            </select>
          </th>
          <th>Data
            <input id="date" type="text" class="form-control" name="date">
          </th>
          <th>
            <button type="submit" class="btn btn-primary">
              Filtrar
            </button>
          </th>
        </tr>
      </thead>
    </table>

  </div>
</div>