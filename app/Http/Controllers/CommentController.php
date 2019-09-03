<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CommentReaction;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $currentPost = Post::where('public_id', $request->post_id)->first();
        if($currentPost == null){
            abort(404);
        }
        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = Auth::user()->id;
        $comment->upvote = 0;
        $comment->downvote = 0;
        $comment->post_id = $currentPost->id;
        $comment->save();
        return back();
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect('/post/{id}');
    }

    public function upvote(Request $request, Comment $comment)
    {
        $user = Auth::user();
        $comment = Comment::findOrFail($request->comment_id);
        $reaction = $user->commentReactions->where('comment_id', $comment->id)->first();
        if ($reaction == null) {
            $reaction = new CommentReaction();
            $comment->upvote = 1;
            $reaction->user_id= Auth::user()->id;
            $reaction->comment_id = $request->comment_id;
            $reaction->react = 'upvote';
        } else {
            if ($reaction->react == 'upvote') {
                $comment->upvote--;
                $reaction->react = 'none';
            }
            else if ($reaction->react == 'downvote') {
                $comment->upvote++;
                $comment->downvote--;
                $reaction->react= 'upvote';
            }
            else {
                $comment->upvote++;
                $reaction->react = 'upvote';
            }

        }
        $reaction->save();
        $comment->save();
        return back();
    }

    public function downvote(Request $request, Comment $comment)
    {
        $user = Auth::user();
        $comment = Comment::findOrFail($request->comment_id);
        $reaction = $user->commentReactions->where('comment_id', $comment->id)->first();
        if ($reaction == null) {
            $reaction = new CommentReaction();
            $comment->downvote = 1;
            $reaction->user_id= Auth::user()->id;
            $reaction->comment_id = $request->comment_id;
            $reaction->react = 'downvote';

        } else {
            if ($reaction->react == 'upvote') {
               $comment->upvote--;
                $comment->downvote++;
                $reaction->react = 'downvote';
            }
            else if ($reaction->react = 'downvote') {
               $comment->downvote--;
                $reaction->react= 'none';
            }
            else {
                $comment->downvote++;
                $reaction->react = 'downvote';
            }

        }
        $reaction->save();
        $comment->save();
        return back();
    }
}
