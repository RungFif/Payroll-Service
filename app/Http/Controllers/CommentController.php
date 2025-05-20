<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer',
            'body' => 'required|string|max:1000',
        ]);

        $commentableClass = $request->commentable_type;
        $commentable = $commentableClass::findOrFail($request->commentable_id);

        $comment = new Comment([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);
        $commentable->comments()->save($comment);

        return back()->with('success', 'Comment added!');
    }
}
