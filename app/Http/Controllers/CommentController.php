<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request as Requests;
use App\Comment;
use App\User;
use Auth;

class CommentController extends Controller
{
    public function showBlockedComments()
    {
        $comments = Comment::leftJoin('users', 'comments.user_id', 'users.id')
                           ->where('comments.blocked', '1')
                           ->select('comments.*', 'users.name');

        $queries = [];

        if (request()->has('comment_search')) {
            $comments = $comments->where('comment', 'LIKE', '%'.request('comment_search').'%');
            $queries['comment_search'] = request('comment_search');
        }
        if (request()->has('user') && request('user') != -1) {
            $comments = $comments->where('user_id', request('user'));
            $queries['owner_id'] = request('user');
        }

        if (request()->has('orderByParam')) {
            $comments = $comments->orderBy(request('orderByParam'), request('orderByType'));
            $queries['orderByParam'] = request('orderByParam');
            $queries['orderByType'] = request('orderByType');
        } else {
            $comments = $comments->orderBy('comments.created_at', 'asc');
        }

        $comments = $comments->paginate(10)->appends($queries);

        $users = User::orderBy('name', 'asc')->get();

        return view('admin.list-blocked-comments', compact('comments', 'users'));
    }

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

    public function blockComment(Comment $comment, $request_id) {

      foreach ($comment->comments as $childcomment) {
         $childcomment->blocked = 1;
         $childcomment->save();
     }

     $comment->blocked = 1;
     $comment->save();

     return redirect()->route('show.request', $request_id)->with('success', "Comentário bloqueado com sucesso!");
 }

 public function unlockComment(Comment $comment) {
    $comment->blocked = 0;
    $comment->save();

    return redirect()->route('comments.blocked')->with('success', 'Comentário desbloqueado com sucesso!');
}
}
