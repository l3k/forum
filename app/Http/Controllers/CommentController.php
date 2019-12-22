<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request) {
        $comment = Comment::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Comentário criado com sucesso', 'comment' => $comment]);
    }

    public function delete(Comment $comment) {        
        $comment->delete();

        return response()->json(['message' => 'Comentário excluído com sucesso']);
    }
}
