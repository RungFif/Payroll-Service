<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy
{
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || $user->hasRole('admin');
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || $user->hasRole('admin');
    }

    public function viewAny(User $user)
    {
        return $user->hasRole('admin') || $user->hasRole('editor');
    }

    public function view(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id || $user->hasRole('admin') || $user->hasRole('editor');
    }
}
