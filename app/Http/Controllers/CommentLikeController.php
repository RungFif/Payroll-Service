<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\CommentLike;

class CommentLikeController extends Controller
{
    public function like(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $user = $request->user();

        CommentLike::updateOrCreate(
            ['comment_id' => $comment->id, 'user_id' => $user->id],
            ['is_like' => true]
        );

        return back();
    }

    public function dislike(Request $request, $commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $user = $request->user();

        CommentLike::updateOrCreate(
            ['comment_id' => $comment->id, 'user_id' => $user->id],
            ['is_like' => false]
        );

        return back();
    }
}
