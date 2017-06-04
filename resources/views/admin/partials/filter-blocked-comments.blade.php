<div class="container">
    <div class="row">
        <table class="table">
            <thead>
                <tr class="filters">
                    <th>Comentário
                    <input id="comment_search" type="text" class="form-control" name="comment_search" 
                           placeholder="Insira o texto do Comentário!" value={{request('comment_search')}}>
                    </th>
                </th>
                <th>Funcionário
                    <select id="user" name="user" class="form-control">
                        <option value="-1" {{request('user') == -1 ? 'selected' : ''}}> -- Todos --</option>
                        @foreach($users as $user)
                        <option value="{{$user->id}}" {{request('user') == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
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