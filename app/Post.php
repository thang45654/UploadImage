<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function postReactions()
    {
        return $this->hasMany(PostReaction::Class);
    }

    public function currentReaction()
    {
        if(!Auth::check()){
            return 'none';
        }
        $user = Auth::user();
        $reaction = $user->postReactions->where('post_id', $this->id)->first();
        if($reaction == null){
            return 'none';
        }else{
            return $reaction->react;
        }
    }
}
