<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use Illuminate\Support\Facades\Auth;
use App\ReplyReaction;

class ReplyController extends Controller
{
    public function store(request $request)
    {
        $reply = new Reply();
        $reply->user_id = Auth::user()->id;
        $reply->comment_id = $request->comment_id;
        $reply->content = $request->content;
        $reply->upvote = 0;
        $reply->downvote = 0;
        $reply->save();
        return back();
    }

    public function delete(Reply $reply)
    {
        $reply->delete();
        return redirect('post/public_id');
    }

    public function upvote(Request $request, Reply $reply)
    {
        $user = Auth::user();
        $reply = Reply::findOrFail($request->reply_id);
        $reaction = $user->replyReactions->where('reply_id', $reply->id)->first();
        if ($reaction == null) {
            $reaction = new ReplyReaction();
            $reply->upvote = 1;
            $reaction->user_id= Auth::user()->id;
            $reaction->reply_id = $request->reply_id;
            $reaction->react = 'upvote';
        } else {
            if ($reaction->react == 'upvote') {
                $reply->upvote--;
                $reaction->react = 'none';
            }
            else if ($reaction->react == 'downvote') {
                $reply->upvote++;
                $reply->downvote--;
                $reaction->react= 'upvote';
            }
            else {
                $reply->upvote++;
                $reaction->react = 'upvote';
            }

        }
        $reaction->save();
        $reply->save();
        return back();
    }

    public function downvote(Request $request, Reply $reply)
    {
        $user = Auth::user();
        $reply = Reply::findOrFail($request->reply_id);
        $reaction = $user->replyReactions->where('reply_id', $reply->id)->first();
        if ($reaction == null) {
            $reaction = new ReplyReaction();
            $reply->downvote = 1;
            $reaction->user_id= Auth::user()->id;
            $reaction->reply_id = $request->reply_id;
            $reaction->react = 'downvote';

        } else {
            if ($reaction->react == 'upvote') {
                $reply->upvote--;
                $reply->downvote++;
                $reaction->react = 'downvote';
            }
            else if ($reaction->react == 'downvote') {
                $reply->downvote--;
                $reaction->react= 'none';
            }
            else {
                $reply->downvote++;
                $reaction->react = 'downvote';
            }

        }
        $reaction->save();
        $reply->save();
        return back();
    }
}
