<?php

namespace App\Http\Controllers;

use App\PostReaction;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $posts = $user->posts;
        return view('dashboard', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|min:5|max:255',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif'
        ]);

        $image = $request->file('image');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);
        $imageUrl = '/images/' . $name;

        $post = new Post();
        $post->title = $request->title;
        $post->image = $imageUrl;
        $post->upvote = 0;
        $post->downvote = 0;
        $post->share = 0;
        $post->user_id = Auth::user()->id;
        $newPublicId = str_random(8);
        while (Post::where('public_id', $newPublicId)->first() != null) {
            $newPublicId = str_random(8);
        }
        $post->public_id = $newPublicId;
        $post->save();

        return back()->with('success', 'Tải ảnh lên thành công');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $post = Post::where('public_id', $id)->first();
        if ($post == null) {
            abort(404);
        } else {
            return view('detail', compact('post'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('dashboard', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post)
    {
        $post->update(request(['title', 'content']));
    }

    public function upvote(Request $request, Post $post)
    {
        $user = Auth::user();
        $post = Post::where('public_id', $request->post_id)->first();
        $reaction = $user->postReactions->where('post_id', $post->id)->first();
        if ($reaction == null) {
            $reaction = new PostReaction();
            $post->upvote++;
            $reaction->user_id = $user->id;
            $reaction->post_id = $post->id;
            $reaction->react = 'upvote';
            $reaction->share = 0;
            $post->save();
            $reaction->save();
        } else {
            if($reaction->react == 'upvote'){
                $post->upvote--;
                $reaction->react = 'none';
            }elseif($reaction->react == 'downvote'){
                $post->upvote++;
                $post->downvote--;
                $reaction->react = 'upvote';
            }else{
                $post->upvote++;
                $reaction->react = 'upvote';
            }
        }
        $post->save();
        $reaction->save();
        return back();
    }

    public function downvote(Request $request, Post $post)
    {
        $user = Auth::user();
        $post = Post::where('public_id', $request->post_id)->first();
        $reaction = $user->postReactions->where('post_id', $post->id)->first();
        if ($reaction == null) {
            $reaction = new PostReaction();
            $post->downvote++;
            $reaction->user_id = $user->id;
            $reaction->post_id = $post->id;
            $reaction->react = 'downvote';
            $reaction->share = 0;
            $post->save();
            $reaction->save();
        } else {
            if($reaction->react == 'upvote'){
                $post->upvote--;
                $post->downvote++;
                $reaction->react = 'downvote';
            }elseif($reaction->react == 'downvote'){
                $post->downvote--;
                $reaction->react = 'none';
            }else{
                $post->downvote++;
                $reaction->react = 'downvote';
            }
        }
        $post->save();
        $reaction->save();
        return back();
    }

    public function Webpage($id)
    {
        $user = Auth::user();
        $posts = $user->posts;

        return view('webpage', compact('posts'));

    }
}
