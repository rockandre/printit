<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Request as Requests;
use App\Comment;

class AdministratorController extends Controller
{
    public function __construct()
    {
    	//Colocar aqui proteçao para apenas administradores acederem!
    }
    
    public function showUsers()
    {
		$users = User::all();

    	return view('admin.list-users', compact('users'));
    }

    public function showComments()
    {
    	$comments = Comment::all();

    	return view('admin.list-comments', compact('comments'));
    }
}
