<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function postReactions()
    {
        return $this->hasMany(PostReaction::class);
    }

    public function commentReactions()
    {
        return $this->hasMany(CommentReaction::class);
    }

    public function replyReactions()
    {
        return $this->hasMany(ReplyReaction::class);
    }

    public function getUserId()
    {
        $user = Auth::user();
        $reaction = $user->postReactions->where('post_id', $this->id)->first();
    }

}
