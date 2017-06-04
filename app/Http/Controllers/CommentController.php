<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request as Requests;
use App\Comment;
use Auth;

class CommentController extends Controller
{
    public function create(Request $request, $request_id, $comment_id=null) {
    	$comment = new comment;

    	$comment->comment = $request['comment'];

    	$comment->request_id = $request_id;

    	$comment->user_id = Auth::user()->id;

    	if ($comment_id != null)
    	{
    		$comment->parent_id = $comment_id;
    	}

    	$comment->save();

    	return redirect()->route('show.request', $request_id)->with('success', 'Comentado com sucesso!');
    }
}
