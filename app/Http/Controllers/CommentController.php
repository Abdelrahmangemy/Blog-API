<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(CreateCommentRequest $request, Post $post)
    {
        $comment = Comment::create([
            'content' => $request->content,
            'post_id' => $post->id,
            'user_id' => auth('api')->id(),
        ]);

        return response()->json(['message' => 'Comment added'], 201);
    }
}
