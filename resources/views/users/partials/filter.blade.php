<div class="container">
    <div class="row">
        <table class="table">
            <thead>
                <tr class="filters">
                    <th>Funcionario
                    <input id="user_search" type="text" class="form-control" name="user_search" 
                           placeholder="Insira o nome do Funcionario!" value={{request('user_search')}}>
                    </th>
                </th>
                <th>Departamento
                    <select id="department" name="department" class="form-control">
                        <option value="-1" {{request('department') == -1 ? 'selected' : ''}}> -- Todos --</option>
                        @foreach($departments as $department)
                        <option value="{{$department->id}}" {{request('department') == $department->id ? 'selected' : ''}}>{{$department->name}}</option>
                        @endforeach
                    </select>
                </th>
                <th>
                    <button type="submit" class="btn btn-primary">
                        Pesquisar
                    </button>
                </th>   
            </tr>
        </thead>
    </table>
</div>
</div>