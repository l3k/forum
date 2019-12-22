<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(Request $request) {
        $post = Post::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Post criado com sucesso', 'post' => $post]);
    }

    public function listPosts(User $user) {
        // dd($user);

        $posts = $user->posts()->orderBy('id', 'desc')->get();

        return response()->json(['message' => 'Posts carregados com sucesso', 'posts' => $posts]);
    }

    public function listAll() {
        // dd($user);

        $posts = Post::with([
                'user', 
                'comments' => function ($q) {
                    $q->with([
                        'user'
                    ]);
                },
            ])
            ->orderBy('id', 'desc')
            ->get();

        return response()->json(['message' => 'Posts carregados com sucesso', 'posts' => $posts]);
    }

    public function delete(Post $post) {
        $comments = $post->comments;

        foreach ($comments as $comment) {
            $comment->delete();
        }
        
        $post->delete();

        return response()->json(['message' => 'Post excluído com sucesso']);
    }
    
    public function update(Post $post, Request $request) {
        $post->update([
            'title' => $request->title,
            'description' => $request->description
        ]);

        return response()->json(['message' => 'Post alterado com sucesso']);
    }
}
