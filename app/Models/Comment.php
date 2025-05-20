<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'user_id', 'body', 'commentable_id', 'commentable_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function likes()
    {
        return $this->hasMany(\App\Models\CommentLike::class)->where('is_like', true);
    }

    public function dislikes()
    {
        return $this->hasMany(\App\Models\CommentLike::class)->where('is_like', false);
    }

    public function likedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function dislikedBy($userId)
    {
        return $this->dislikes()->where('user_id', $userId)->exists();
    }
}
