<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function replies() {
        return $this->hasMany(Reply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentReactions()
    {
        return $this->hasMany(CommentReaction::class);
    }

    public function currentReaction()
    {
        if (!Auth::check()) {
            return 'none';
        }
        else {
            $user = Auth::user();
            $reaction = $user->commentReactions->where('comment_id', $this->id)->first();
            if ($reaction == null) {
                return 'none';
            }
            else {
                return $reaction->react;
            }
        }
    }
}
