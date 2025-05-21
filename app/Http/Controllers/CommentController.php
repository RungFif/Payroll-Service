<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    use AuthorizesRequests;
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

    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);
        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);
        $comment->body = $request->body;
        $comment->save();

        return back()->with('success', 'Comment updated!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return back()->with('success', 'Comment deleted!');
    }
}
