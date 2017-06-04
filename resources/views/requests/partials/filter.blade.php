<div class="container">
  <div class="row">
    <table class="table">
      <thead>
        <tr class="filters">
          <th>Pesquisar
            <input id="description" type="text" class="form-control" name="description" value={{ request('description')}}>
          </th>
          @if(Auth::user()->isAdmin())
          <th>Funcionário
            <select id="user" name="user" class="form-control">
              <option value="-1" {{ request('user') == -1 ? 'selected' : '' }}> -- Todos --</option>
              @foreach($users as $user)
              <option value="{{$user->id}}" {{ $user->id == request('user') ? 'selected' : '' }}>{{$user->name}}</option>
              @endforeach
            </select>
          </th>
          <th>Departamento
            <select id="department" name="department" class="form-control">
              <option value="-1" {{ request('department') == -1 ? 'selected' : '' }}> -- Todos --</option>
              @foreach($departments as $department)
              <option value="{{$department->id}}" {{ $department->id == request('department') ? 'selected' : '' }}>{{$department->name}}</option>
              @endforeach
            </select>
          </th>
          @endif
          <th>Estado
            <select id="status" name="status" class="form-control">
              <option value="-1" selected>-- Todos --</option>
              <option value="0" {{ request()->has('status') ? (request('status') == 0 ? 'selected' : '') : '' }}>Pendente</option>
              <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Recusado</option>
              <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>Concluido</option>
            </select>
          </th>
          <th>Data
            <input id="date" type="text" class="form-control" name="date" value={{ request('date') }}>
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