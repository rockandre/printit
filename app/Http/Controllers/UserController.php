<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
	public function showUser($id){
		$user = User::findOrFail($id);
		return view('users.showUser', compact('user'));
	}	

	public function users(){
		$users = User::orderBy('name', 'asc')->paginate(10);
		return view('users.users', compact('users'));
	}

	public function statistics(){
		return view('statistics.show');
	}
}

