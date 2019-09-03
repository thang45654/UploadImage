<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Reply extends Model
{
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replyReactions()
    {
        return $this->hasMany(ReplyReaction::class);
    }

    public function currentReaction()
    {
        if (!Auth::check()) {
            return 'none';
        }
        else {
            $user = Auth::user();
            $reaction = $user->replyReactions->where('reply_id', $this->id)->first();
            if ($reaction == null) {
                return 'none';
            }
            else {
                return $reaction->react;
            }
        }
    }
}
