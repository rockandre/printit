<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Department;

class UserController extends Controller
{
    public function showUser($id){
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }	

    public function listUsers(){

        $users = new User;

        $queries = [];

        if (request()->has('user_search')) {
            $users = $users->where('name', 'LIKE', '%'.request('user_search').'%');
            $queries['name'] = request('user_search');
        }

        if (request()->has('department') && request('department') != -1) {
            $users = $users->where('department_id', request('department'));
            $queries['department_id'] = request('department');
        }

        if (request()->has('orderByParam')) {
            $users = $users->orderBy(request('orderByParam'), request('orderByType'));
            $queries['orderByParam'] = request('orderByParam');
            $queries['orderByType'] = request('orderByType');
        } else {
            $users = $users->orderBy('name', 'asc');
        }

        $users = $users->paginate(10)->appends($queries);

        $departments = Department::all();

        return view('users.list', compact('users', 'userslist', 'departments'));
    }

    public function statistics(){
        return view('statistics.show');
    }

    public function showBlockedUsers()
    {
        $blockedUsers = User::where('blocked', '1')->paginate(10);

        return view('admin.list-blocked-users', compact('blockedUsers'));
    }

    public function unlockUser($id)
    {
        $user = User::findOrFail($id);

        $user->blocked = 0;

        $user->save();

        return redirect()->route('users.blocked')->with('success', 'Utilizador desbloqueado com sucesso!');
    }

    public function blockUser($id)
    {
        $user = User::findOrFail($id);

        $user->blocked = 1;

        $user->save();

        return redirect()->route('user.show', $user->id)->with('success', 'Utilizador bloqueado com sucesso!');
    }

    public function makeUserAdmin($id)
    {
        $user = User::findOrFail($id);

        $user->admin = 1;

        $user->save();

        return redirect()->route('users.list');
    }

    public function revokeUserAdmin($id)
    {
        $user = User::findOrFail($id);

        $user->admin = 0;

        $user->save();

        return redirect()->route('users.list');
    }
}

