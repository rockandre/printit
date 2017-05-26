<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
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
}
