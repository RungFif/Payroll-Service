<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeRequest extends Model
{
    protected $fillable = [
        'user_id', 'type', 'description', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function comments()
    {
        return $this->morphMany(\App\Models\Comment::class, 'commentable')->latest();
    }
}
